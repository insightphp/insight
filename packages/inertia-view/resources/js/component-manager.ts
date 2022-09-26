declare type ComponentDef = Promise<any> | (() => Promise<any>)

class InertiaViewComponentManager {

  /**
   * Map of resolved components.
   */
  resolvedComponents: Record<string, ComponentDef> = {}

  /**
   * Registers view components for given namespace.
   */
  addComponents<T>(
    components: Record<string, ComponentDef>,
    namespace: string = 'app'
  ): InertiaViewComponentManager {
    const paths = Object.keys(components)

    if (paths.length <= 0) {
      console.warn(`No components have been found when registering namespace [${namespace}].`)
      return this
    }

    const base = this.resolvePathBase(paths)

    Object.keys(components).forEach(fileName => {
      const path = fileName.replace(base, '')
      const name = this.resolveComponentName(path.replace(/\//g, '-'), namespace)

      this.resolvedComponents[name] = (components[fileName] as any).default
    })

    return this
  }

  getResolvedComponents(): Record<string, ComponentDef> {
    return this.resolvedComponents
  }

  protected resolvePathBase(componentFiles: Array<string>): string {
    if (componentFiles.length <= 0) {
      throw new Error("At least one file is required for resolving base path.")
    }

    if (componentFiles.length == 1) {
      throw new Error("NOT IMPLEMENTED")
    }

    const files = [...componentFiles]
    files.sort((a, b) => b.length - a.length)
    const first = files[0]
    const last = files[files.length - 1]

    let eq
    for (eq = 0; eq < Math.min(first.length, last.length) && first[eq] == last[eq]; eq++);

    return first.substring(0, eq)
  }

  /**
   * Retrieve registered component with given name.
   */
  getComponentWithName(name: string): ComponentDef {
    if (! Object.keys(this.resolvedComponents).includes(name)) {
      throw new Error(`The Component with name [${name}] is not registered.`)
    }

    return this.resolvedComponents[name]
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

const ComponentManager = new InertiaViewComponentManager()
export default ComponentManager
