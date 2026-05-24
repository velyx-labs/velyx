import { exec } from 'child_process'
import path from 'path'
import fs from 'fs-extra'
import { gray } from 'kleur/colors'
import { promisify } from 'util'
import { highlighter } from '@/src/utils/highlighter'
import { logger } from '@/src/utils/logger'
import { spinner } from '@/src/utils/spinner'
import prompts from 'prompts'
import { detectPackageManager } from '@/src/utils/package-manager'
import type { InitOptions } from '@/src/utils/init-project'
import type { PackageManager } from '@/src/types'

const execAsync = promisify(exec)

export interface ProjectInfo {
  name: string
  framework: {
    name: string
    label: string
    version?: string
  }
  hasAlpine: boolean
  hasVite: boolean
  packageManager: PackageManager
  paths: {
    views: string
    assets: string
    public: string
    config: string
  }
}

export async function getProjectInfo(cwd: string): Promise<ProjectInfo | null> {
  try {
    const composerPath = path.resolve(cwd, 'composer.json')
    const packagePath = path.resolve(cwd, 'package.json')

    if (!fs.existsSync(composerPath)) {
      return null
    }

    const composer = await fs.readJson(composerPath)
    const isLaravel =
      composer.require?.['laravel/framework'] ||
      composer.require?.['illuminate/foundation']

    if (!isLaravel) {
      return null
    }

    const originalDir = process.cwd()
    process.chdir(cwd)
    const pkgManager = detectPackageManager()
    process.chdir(originalDir)

    const projectInfo: ProjectInfo = {
      name: composer.name || path.basename(cwd),
      framework: {
        name: 'laravel',
        label: 'Laravel',
        version: composer.require?.['laravel/framework'] || 'unknown',
      },
      hasAlpine: false,
      hasVite: false,
      packageManager: pkgManager,
      paths: {
        views: 'resources/views',
        assets: 'resources/js',
        public: 'public',
        config: 'config',
      },
    }

    if (fs.existsSync(packagePath)) {
      const pkg = await fs.readJson(packagePath)
      projectInfo.hasAlpine = !!(
        pkg.dependencies?.alpinejs || pkg.devDependencies?.alpinejs
      )
      projectInfo.hasVite = !!pkg.devDependencies?.vite
    }

    return projectInfo
  } catch {
    return null
  }
}

export async function preFlightInit(options: InitOptions): Promise<{
  errors: Record<string, boolean>
  projectInfo: ProjectInfo | null
}> {
  const errors: Record<string, boolean> = {}

  if (!fs.existsSync(options.cwd)) {
    errors['MISSING_DIR'] = true
    return { errors, projectInfo: null }
  }

  const velyxConfigPath = path.resolve(options.cwd, 'velyx.json')
  if (fs.existsSync(velyxConfigPath) && !options.force) {
    const { action } = await prompts(
      {
        type: 'select',
        name: 'action',
        message: 'velyx.json already exists',
        choices: [
          { title: 'Re-initialize', value: 'reinit' },
          { title: 'Keep existing', value: 'keep' },
          { title: 'Exit', value: 'exit' },
        ],
        initial: 0,
      },
      { onCancel: () => process.exit(0) },
    )

    if (!action || action === 'exit' || action === 'keep') {
      process.exit(0)
    }
  }

  const envSpinner = spinner.start('Checking environment...')
  const projectInfo = await getProjectInfo(options.cwd)

  if (!projectInfo || projectInfo.framework.name !== 'laravel') {
    errors['UNSUPPORTED_PROJECT'] = true
    envSpinner.fail('No Laravel project found')
    logger.break()
    process.exit(1)
  }

  envSpinner.stop()

  if (!projectInfo.hasAlpine) {
    const { installAlpine } = await prompts(
      {
        type: 'confirm',
        name: 'installAlpine',
        message: 'Alpine.js not found — install it now?',
        initial: true,
      },
      { onCancel: () => process.exit(0) },
    )

    if (installAlpine) {
      const installSpinner = spinner.start('Installing Alpine.js...')
      try {
        await execAsync(`${projectInfo.packageManager} install alpinejs`, {
          cwd: options.cwd,
        })
        installSpinner.stop()
        projectInfo.hasAlpine = true
      } catch {
        installSpinner.fail('Failed to install Alpine.js')
        logger.log(
          gray(
            `  Install manually: ${highlighter.info(`${projectInfo.packageManager} install alpinejs`)}`,
          ),
        )
        process.exit(1)
      }
    } else {
      logger.log(
        gray(
          `  Run: ${highlighter.info(`${projectInfo.packageManager} install alpinejs`)}`,
        ),
      )
      process.exit(1)
    }
  }

  const parts = [projectInfo.framework.label, projectInfo.packageManager]
  if (projectInfo.hasAlpine) parts.push('Alpine.js')
  console.log(gray(`  ✓  ${parts.join('  ·  ')}`))

  if (Object.keys(errors).length > 0) {
    logger.break()
    process.exit(1)
  }

  return { errors, projectInfo }
}
