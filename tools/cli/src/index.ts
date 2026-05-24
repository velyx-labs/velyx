import { bold, gray } from 'kleur/colors'
import { Command } from 'commander'
import { init } from '@/src/commands/init'
import { add } from '@/src/commands/add'
import { list } from '@/src/commands/list'

import packageJson from '../package.json'

function displayIntro(): void {
  console.log('')
  console.log(`  ${bold(packageJson.name)}  ${gray(`v${packageJson.version}`)}`)
  console.log(`  ${gray('Blade components for Laravel')}`)
  console.log('')
}

/**
 * Velyx CLI program entry point
 */
const program = new Command()
program
  .name('velyx')
  .description('Velyx CLI: Copy UI components into your Laravel project')
  .version(
    packageJson.version || '1.0.0',
    '-v, --version',
    'display the version number',
  )
  .hook('preAction', () => {
    displayIntro()
  })

program.addCommand(add).addCommand(init).addCommand(list)

program.parse(process.argv)
