import { NetworkError } from '../errors/errors'

/**
 * Custom error class for Velyx-specific errors with code and context
 */
export class VelyxError extends Error {
  constructor(
    message: string,
    public readonly code: string,
    public readonly context?: Readonly<Record<string, unknown>>,
  ) {
    super(message)
    this.name = 'VelyxError'
  }
}

/**
 * Handles and formats errors for display
 */
export class ErrorHandler {
  handle(error: Error, context: string): void {
    if (error instanceof VelyxError) {
      console.error(`[${error.code}] ${error.message}`)
      if (error.context) {
        console.error('Context:', error.context)
      }
      return
    }

    if (error instanceof NetworkError) {
      console.error(`✖ ${error.message}`)
      const hint = this.networkHint(error)
      if (hint) console.error(`  → ${hint}`)
      return
    }

    console.error(`Unexpected error in ${context}: ${error.message}`)
  }

  private networkHint(error: NetworkError): string | null {
    const msg = error.message + (error.cause?.message ?? '')
    if (msg.includes('ENOTFOUND') || msg.includes('ECONNREFUSED')) {
      return 'Check your internet connection or try again later'
    }
    if (msg.includes('timed out') || msg.includes('ETIMEDOUT')) {
      return 'The registry took too long to respond — try again in a moment'
    }
    if (msg.includes('certificate') || msg.includes('SSL')) {
      return 'SSL certificate error — check your network proxy settings'
    }
    return null
  }
}
