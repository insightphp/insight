import type { App } from "vue";

declare type Component = Promise<any> | (() => Promise<any>)

class ViewComponents {

  app: App|null = null

  components: Record<string, Record<string, Component>> = {}

  /**
   * Registers view components for given namespace.
   */
  registerComponentsInNamespace<T>(
    components: Record<string, Component>,
    baseDirectory: string,
    namespace: string = 'app'
  ) {
    if (! this.components.hasOwnProperty(namespace)) {
      this.components[namespace] = {}
    }

    Object.keys(components).forEach(fileName => {
      const relativeComponentPath = fileName
        .replace('./', '')
        .replace(baseDirectory.replace('./', ''), '')
        .replace('/', '')
        .replace(/\//g, '-')

      this.components[namespace][this.resolveComponentName(relativeComponentPath)] = components[fileName]
    })

    if (this.app) {
      this.bootComponents(this.app)
    }
  }

  /**
   * Resolve component name from file name.
   *
   * @param fileName
   * @param prefix
   */
  resolveComponentName(fileName: string, prefix: string|null = null): string {
    const parts = fileName.split('/');

    const camelCase = parts[parts.length - 1].replace('.vue', '')

    const kebabCase = camelCase.replace(/\B([A-Z])(?=[a-z])/g, '-$1')
      .replace(/\B([a-z0-9])([A-Z])/g, '$1-$2')
      .toLowerCase()

    if (prefix) {
      return `${prefix}-${kebabCase}`
    }

    return kebabCase
  }

  bootComponents(app: App) {
    Object.keys(this.components).forEach(namespace => {
      Object.keys(this.components[namespace]).forEach(componentName => {
        app.component(`${namespace}-${componentName}`, (this.components[namespace][componentName] as any).default)
      })
    })
  }

  boot(app: App) {
    this.app = app;

    this.bootComponents(app)

    console.log('BOOTED', this)
  }
}

const ViewComponentManager = new ViewComponents()
export default ViewComponentManager
