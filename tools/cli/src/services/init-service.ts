import prompts from 'prompts'
import type {
  VelyxConfig,
  PackageManager,
  VelyxTheme,
  FileInfo,
} from '@/src/types'
import type { IFileSystemService } from '../types/interfaces'
import { isLaravelProject } from '../utils/laravel'
import { readPackageJson, detectTailwindV4 } from '../utils/tailwind'
import { hasAlpineJs } from '../utils/requirements'
import { detectPackageManager } from '../utils/package-manager'
import { findMainCss, hasTailwindImport, injectVelyxImport } from '../utils/css'
import { findMainJs } from '../utils/js'
import { copyTheme } from '../utils/theme'
import { writeVelyxConfig } from '../utils/config'
import fs from 'fs'
import { gray } from 'kleur/colors'
import { logger } from '../utils/logger'
import { highlighter } from '../utils/highlighter'
import packageJson from '../../package.json'

/**
 * Environment validation result
 */
export interface EnvironmentValidation {
  /** Whether Laravel project is detected */
  isLaravel: boolean
  /** Whether Tailwind v4 is detected */
  hasTailwindV4: boolean
  /** Whether Alpine.js is detected */
  hasAlpine: boolean
  /** Detected package manager */
  detectedPackageManager: PackageManager
  /** Main CSS file info if found */
  cssFile: FileInfo | null
  /** Main JS file info if found */
  jsFile: FileInfo | null
  /** Whether CSS can be injected */
  canInjectCss: boolean
}

/**
 * Initialization options
 */
export interface InitOptions {
  /** Selected package manager */
  packageManager: PackageManager
  /** Selected theme */
  theme: VelyxTheme
  /** Whether to import styles */
  importStyles: boolean
}

/**
 * Service for handling Velyx initialization
 */
export class InitService {
  /**
   * Create a new InitService instance
   * @param fileSystem - File system service
   */
  constructor(private readonly fileSystem: IFileSystemService) {}

  /**
   * Validate the project environment
   * @returns Environment validation result
   * @throws Error if critical requirements are not met
   */
  validateEnvironment(): EnvironmentValidation {
    // Validate Laravel project
    if (!isLaravelProject()) {
      throw new Error('No Laravel project detected')
    }

    // Check Tailwind v4
    const pkg = readPackageJson()
    if (!pkg || !detectTailwindV4(pkg)) {
      throw new Error('Tailwind CSS v4 was not detected')
    }

    // Check interactivity frameworks
    const hasAlpine = hasAlpineJs()
    const detectedPm = detectPackageManager()

    // Find CSS and JS files
    const css = findMainCss()
    const js = findMainJs()
    const canInject = css ? hasTailwindImport(css.content) : false

    return {
      isLaravel: true,
      hasTailwindV4: true,
      hasAlpine,
      detectedPackageManager: detectedPm,
      cssFile: css,
      jsFile: js,
      canInjectCss: canInject,
    }
  }

  /**
   * Display environment information and warnings
   * @param validation - Environment validation result
   */
  displayEnvironmentInfo(validation: EnvironmentValidation): void {
    if (!validation.cssFile) {
      logger.log(gray('  → no CSS entry found — styles will not be auto-imported'))
    } else if (!validation.canInjectCss) {
      logger.log(gray('  → Tailwind import missing — styles will not be auto-imported'))
    }

    if (!validation.jsFile) {
      logger.log(gray('  → no JS entry found — scripts will not be auto-imported'))
    }
  }

  /**
   * Create the UI components directory
   * @param path - Directory path (default: "resources/views/components/ui")
   * @returns Promise that resolves when directory is created
   */
  async createComponentsDirectory(
    path = 'resources/views/components/ui',
  ): Promise<void> {
    await this.fileSystem.ensureDir(path)
  }

  /**
   * Create the Velyx theme CSS file
   * @param theme - Theme to use
   * @param targetPath - Target CSS file path (default: "resources/css/velyx.css")
   * @returns Promise that resolves when theme is created
   * @throws Error if theme creation fails
   */
  async createThemeFile(
    theme: VelyxTheme,
    targetPath = 'resources/css/velyx.css',
  ): Promise<void> {
    // Ensure directory exists
    const dirPath = targetPath.split('/').slice(0, -1).join('/')
    await this.fileSystem.ensureDir(dirPath)

    if (!fs.existsSync(targetPath)) {
      try {
        copyTheme(theme, targetPath)
      } catch (error) {
        throw new Error(
          `Failed to create theme file: ${(error as Error).message}`,
        )
      }
    } else {
      const { override } = await prompts(
        {
          type: 'confirm',
          name: 'override',
          message: `${targetPath} already exists — overwrite?`,
          initial: false,
        },
        { onCancel: () => false },
      )

      if (override) {
        try {
          copyTheme(theme, targetPath)
        } catch (error) {
          throw new Error(
            `Failed to update theme file: ${(error as Error).message}`,
          )
        }
      }
    }
  }

  /**
   * Inject Velyx styles import into main CSS file
   * @param cssPath - Path to main CSS file
   * @returns Promise that resolves when import is injected
   */
  async injectStylesImport(cssPath: string): Promise<void> {
    injectVelyxImport(cssPath)
  }

  /**
   * Generate and write Velyx configuration file
   * @param options - Initialization options
   * @param validation - Environment validation result
   * @returns Promise that resolves when config is written
   */
  async generateConfig(
    options: InitOptions,
    validation: EnvironmentValidation,
  ): Promise<void> {
    const config: VelyxConfig = {
      version: packageJson.version as string,
      theme: options.theme,
      packageManager: options.packageManager,
      css: {
        entry: validation.cssFile?.path ?? '',
        velyx: 'resources/css/velyx.css',
      },
      js: {
        entry: validation.jsFile?.path ?? '',
      },
      components: {
        path: 'resources/views/components/ui',
      },
    }

    writeVelyxConfig(config)
  }

  /**
   * Display initialization summary
   * @param options - Initialization options
   * @param validation - Environment validation result
   * @param stylesImported - Whether styles were imported
   */
  displaySummary(
    options: InitOptions,
    validation: EnvironmentValidation,
    stylesImported: boolean,
  ): void {
    const parts: string[] = [options.theme, options.packageManager]
    if (validation.cssFile) {
      parts.push(stylesImported ? 'styles imported' : 'styles skipped')
    }

    logger.break()
    console.log(gray(`  ✓  ${parts.join('  ·  ')}`))
    logger.break()
    console.log(`  ${highlighter.info('velyx add button')}`)
    logger.break()
  }
}
