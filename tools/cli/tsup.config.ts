import { cpSync } from 'fs'
import { defineConfig } from 'tsup'

export default defineConfig({
  clean: true,
  dts: true,
  entry: ['src/index.ts'],
  format: ['esm'],
  platform: 'node',
  sourcemap: true,
  minify: true,
  target: 'esnext',
  outDir: 'dist',
  treeshake: true,
  esbuildOptions(options) {
    options.define = {
      ...options.define,
      'process.env.VELYX_REGISTRY_URL': JSON.stringify(
        process.env.VELYX_REGISTRY_URL ?? 'https://registry.velyx.dev/api/v1',
      ),
    }
  },
  onSuccess: async () => {
    cpSync('src/colors', 'dist/colors', { recursive: true, force: true })
  },
})
