declare type Component = Promise<any> | (() => Promise<any>)

class ViewComponents {

  registeredComponents: Record<string, Component> = {}

  /**
   * Registers view components for given namespace.
   */
  registerComponentsInNamespace<T>(
    components: Record<string, Component>,
    baseDirectory: string,
    namespace: string = 'app'
  ) {
    Object.keys(components).forEach(fileName => {
      const relativeComponentPath = fileName
        .replace('./', '')
        .replace(baseDirectory.replace('./', ''), '')
        .replace('/', '')
        .replace(/\//g, '-')

      this.registeredComponents[`${namespace}-${this.resolveComponentName(relativeComponentPath)}`] = (components[fileName] as any).default
    })
  }

  /**
   * Retrieve registered component with given name.
   */
  getComponentWithName(name: string): Component {
    if (! Object.keys(this.registeredComponents).includes(name)) {
      throw new Error(`The Component with name [${name}] is not registered.`)
    }

    return this.registeredComponents[name]
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
}

const ComponentManager = new ViewComponents()
export default ComponentManager
