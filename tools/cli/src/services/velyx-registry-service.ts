import type {
  RegistryComponentWithFiles,
  RegistryComponentsResponse,
  RegistryVersionsResponse,
  RegistryComponentResponse,
  VelyxComponentMeta,
} from '../types'
import type { IRegistryService } from '../types/interfaces'
import { NetworkError, ComponentNotFoundError } from '../errors/errors'
import { HttpService } from './http-service'
import { getRegistryApiUrl } from '../utils/environment'

export class VelyxRegistryService implements IRegistryService {
  private readonly httpService: HttpService
  private readonly baseUrl: string

  constructor(httpService?: HttpService) {
    this.httpService = httpService ?? new HttpService()
    this.baseUrl = getRegistryApiUrl()
  }

  async fetchRegistry(): Promise<{
    components: readonly VelyxComponentMeta[]
    count: number
  }> {
    try {
      const response = await this.httpService.fetch(`${this.baseUrl}/components`)

      if (!response.ok) {
        throw new NetworkError(
          `Failed to fetch registry: ${response.status} ${response.statusText}`,
        )
      }

      const data = (await response.json()) as RegistryComponentsResponse
      const components = Object.values(data.data)

      return { components, count: data.count }
    } catch (error) {
      if (error instanceof NetworkError) throw error
      throw new NetworkError(`Failed to fetch registry: ${(error as Error).message}`)
    }
  }

  async fetchComponent(
    name: string,
    options?: { version?: string; includeFiles?: boolean },
  ): Promise<VelyxComponentMeta | RegistryComponentWithFiles> {
    try {
      const url = this.buildComponentUrl(name, options)
      const response = await this.httpService.fetch(url)

      if (response.status === 404) throw new ComponentNotFoundError(name)
      if (!response.ok) {
        throw new NetworkError(
          `Failed to fetch component: ${response.status} ${response.statusText}`,
        )
      }

      const result = (await response.json()) as RegistryComponentResponse

      return options?.includeFiles
        ? result.data
        : this.convertRegistryComponentToMeta(result.data)
    } catch (error) {
      if (error instanceof ComponentNotFoundError || error instanceof NetworkError) throw error
      throw new NetworkError(`Failed to fetch component "${name}": ${(error as Error).message}`)
    }
  }

  async fetchFile(componentUrl: string, filePath: string): Promise<string> {
    try {
      const componentName = componentUrl.split('/').pop() || componentUrl
      const url = `${this.baseUrl}/components/${componentName}`
      const response = await this.httpService.fetch(url)

      if (response.status === 404) throw new ComponentNotFoundError(componentName)
      if (!response.ok) {
        throw new NetworkError(
          `Failed to fetch component: ${response.status} ${response.statusText}`,
        )
      }

      const component = (await response.json()) as RegistryComponentWithFiles
      const fileContent = component.files[filePath]

      if (fileContent === undefined) {
        throw new NetworkError(`File "${filePath}" not found in component "${componentName}"`)
      }

      return fileContent
    } catch (error) {
      if (error instanceof ComponentNotFoundError || error instanceof NetworkError) throw error
      throw new NetworkError(`Failed to fetch file "${filePath}": ${(error as Error).message}`)
    }
  }

  async resolveDependencies(
    component: VelyxComponentMeta,
  ): Promise<readonly VelyxComponentMeta[]> {
    const visited = new Set<string>()
    const resolved: VelyxComponentMeta[] = []

    const resolve = async (comp: VelyxComponentMeta) => {
      if (visited.has(comp.name)) return
      visited.add(comp.name)
      resolved.push(comp)
    }

    await resolve(component)
    return resolved
  }

  async getComponentVersions(name: string): Promise<RegistryVersionsResponse> {
    try {
      const url = `${this.baseUrl}/components/${name}/versions`
      const response = await this.httpService.fetch(url)

      if (response.status === 404) throw new ComponentNotFoundError(name)
      if (!response.ok) {
        throw new NetworkError(
          `Failed to fetch component versions: ${response.status} ${response.statusText}`,
        )
      }

      return (await response.json()) as RegistryVersionsResponse
    } catch (error) {
      if (error instanceof ComponentNotFoundError || error instanceof NetworkError) throw error
      throw new NetworkError(`Failed to fetch versions for "${name}": ${(error as Error).message}`)
    }
  }

  private convertRegistryComponentToMeta(
    component: RegistryComponentWithFiles,
  ): VelyxComponentMeta {
    return {
      name: component.name,
      description: component.description,
      latest: component.latest,
      versions: component.versions,
      requires_alpine: component.requires_alpine,
      requires: component.requires,
      categories: component.categories,
      laravel: component.laravel,
    }
  }

  private buildComponentUrl(
    name: string,
    options?: { version?: string; includeFiles?: boolean },
  ): string {
    const params = new URLSearchParams()
    if (options?.version) params.append('version', options.version)
    if (options?.includeFiles) params.append('include', 'files')
    const qs = params.toString()
    return `${this.baseUrl}/components/${name}${qs ? `?${qs}` : ''}`
  }
}
