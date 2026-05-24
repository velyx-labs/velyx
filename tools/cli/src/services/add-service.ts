import { gray } from 'kleur/colors'
import type { AddResult, RegistryData } from '@/src/types'
import type { IRegistryService, IConfigManager } from '../types/interfaces'
import { ComponentService } from './component-service'
import { FilesystemService } from './filesystem-service'
import { logger } from '../utils/logger'
import { highlighter } from '../utils/highlighter'

function extractComponentName(filePath: string): string {
  const uiMatch = filePath.match(/components\/ui\/([^/]+)/)
  if (uiMatch) return uiMatch[1]
  const jsMatch = filePath.match(/js\/ui\/([^.]+)/)
  if (jsMatch) return jsMatch[1]
  return filePath
}

/**
 * Service for handling component addition operations
 */
export class AddService {
  private readonly componentService: ComponentService

  /**
   * Create a new AddService instance
   * @param registryService - Service for registry operations
   * @param configManager - Service for configuration management
   * @param componentService - Optional component service (creates new one if not provided)
   */
  constructor(
    private readonly registryService: IRegistryService,
    private readonly configManager: IConfigManager,
    componentService?: ComponentService,
  ) {
    // ComponentService will be created if not provided
    // This allows for dependency injection in tests
    this.componentService =
      componentService ??
      new ComponentService(
        registryService,
        new FilesystemService(),
        configManager,
      )
  }

  /**
   * Validate that Velyx is initialized
   * @throws Error if not initialized
   */
  validateInitialization(): void {
    if (!this.configManager.validate()) {
      throw new Error('Velyx is not initialized')
    }
  }

  /**
   * Validate that components exist in the registry
   * @param componentNames - Names of components to validate
   * @param registry - Registry data
   * @throws Error if any component is not found
   */
  validateComponents(
    componentNames: readonly string[],
    registry: RegistryData,
  ): void {
    for (const componentName of componentNames) {
      const found = registry.components.find((c) => c.name === componentName)
      if (!found) {
        throw new Error(`Component "${componentName}" not found`)
      }
    }
  }

  /**
   * Get available components from registry
   * @returns Promise resolving to registry data
   * @throws NetworkError if fetch fails
   */
  async getAvailableComponents(): Promise<RegistryData> {
    return await this.registryService.fetchRegistry()
  }

  /**
   * Add components to the project
   * @param componentNames - Names of components to add
   * @returns Promise resolving to result of the operation
   */
  async addComponents(componentNames: readonly string[]): Promise<AddResult> {
    return await this.componentService.addComponents(componentNames)
  }

  /**
   * Display the results of adding components
   * @param result - Result of the add operation
   */
  displayResults(result: AddResult): void {
    const byComponent = new Map<string, string[]>()
    result.added.forEach((filePath) => {
      const name = extractComponentName(filePath)
      if (!byComponent.has(name)) byComponent.set(name, [])
      byComponent.get(name)!.push(filePath)
    })

    byComponent.forEach((files, name) => {
      logger.success(name)
      files.forEach((f) => console.log(`    ${gray(f)}`))
    })

    result.skipped.forEach((name) =>
      logger.warn(`Skipped ${extractComponentName(name)}`),
    )
    result.failed.forEach(({ name, error }) =>
      logger.error(`Failed ${extractComponentName(name)}: ${error}`),
    )
  }

  displayNextSteps(result: AddResult): void {
    if (result.added.length === 0) {
      return
    }

    const names = Array.from(new Set(result.added.map(extractComponentName)))
    const tag = names[0]

    logger.break()
    console.log('  Use it in your Blade templates:')
    console.log(`    ${highlighter.info(`<x-ui.${tag} />`)}`)
    logger.break()
  }
}
