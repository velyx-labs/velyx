import { bold, cyan, gray, green } from 'kleur/colors'
import type { VelyxComponentMeta } from '@/src/types'
import { RegistryService } from '@/src/services/registry-service'
import { logger } from '@/src/utils/logger'

export type ListOptions = {
  query?: string
  limit?: number
  offset?: number
  json: boolean
}

function filterComponents(
  components: readonly VelyxComponentMeta[],
  query?: string,
): VelyxComponentMeta[] {
  if (!query) {
    return [...components]
  }

  const normalized = query.toLowerCase()
  return components.filter((component) => {
    const nameMatch = component.name.toLowerCase().includes(normalized)
    const descriptionMatch = component.description
      ? component.description.toLowerCase().includes(normalized)
      : false
    const categoryMatch = component.categories
      ? component.categories.some((category) =>
          category.toLowerCase().includes(normalized),
        )
      : false

    return nameMatch || descriptionMatch || categoryMatch
  })
}

function sliceComponents(
  components: VelyxComponentMeta[],
  offset?: number,
  limit?: number,
): VelyxComponentMeta[] {
  const start = Math.max(0, offset ?? 0)
  if (limit === undefined) {
    return components.slice(start)
  }
  return components.slice(start, start + Math.max(0, limit))
}

// Strip ANSI escape codes to measure visible length
// eslint-disable-next-line no-control-regex
const ANSI_RE = /\x1B\[[0-9;]*m/g

function pad(str: string, width: number): string {
  const visible = str.replace(ANSI_RE, '')
  const diff = width - visible.length
  return diff > 0 ? str + ' '.repeat(diff) : str
}

function truncate(str: string, max: number): string {
  return str.length > max ? str.slice(0, max - 1) + '…' : str
}

export async function listComponents(options: ListOptions): Promise<void> {
  const registryService = new RegistryService()
  const registry = await registryService.fetchRegistry()

  const sorted = [...registry.components].sort((a, b) =>
    a.name.localeCompare(b.name),
  )

  const filtered = filterComponents(sorted, options.query)
  const sliced = sliceComponents(filtered, options.offset, options.limit)

  if (options.json) {
    console.log(
      JSON.stringify(
        {
          total: filtered.length,
          count: sliced.length,
          offset: options.offset ?? 0,
          limit: options.limit ?? null,
          components: sliced,
        },
        null,
        2,
      ),
    )
    return
  }

  if (sliced.length === 0) {
    logger.warn('No components found.')
    return
  }

  const NAME_W = 22
  const DESC_W = 48
  const CAT_W = 20

  console.log('')
  console.log(
    `  ${bold(pad('Component', NAME_W))}  ${bold(pad('Description', DESC_W))}  ${bold('Categories')}`,
  )
  console.log(`  ${gray('─'.repeat(NAME_W + DESC_W + CAT_W + 4))}`)

  for (const component of sliced) {
    const name = pad(cyan(component.name), NAME_W + 9)
    const desc = pad(truncate(component.description || '—', DESC_W), DESC_W)
    const cats = gray(truncate(component.categories?.join(', ') || '—', CAT_W))
    console.log(`  ${name}  ${desc}  ${cats}`)
  }

  console.log('')
  logger.info(`Run ${green('velyx add <component>')} to add one.`)
}
