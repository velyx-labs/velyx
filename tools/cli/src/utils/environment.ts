export const getRegistryApiUrl = (): string => {
  if (process.env.VELYX_REGISTRY_URL) {
    return process.env.VELYX_REGISTRY_URL.replace(/\/$/, '')
  }
  return 'https://registry.velyx.dev/api/v1'
}
