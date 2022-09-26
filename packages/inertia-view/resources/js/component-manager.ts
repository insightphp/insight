import type { ComponentDef, ComponentMap } from "./contracts";
import { resolveCommonBasePath } from "./utils";

export class InertiaViewComponentManager {

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
      // TODO: Ignore when runnning on vitest.
      console.warn(`No components have been found when registering namespace [${namespace}].`)
      return this
    }

    const base = resolveCommonBasePath(paths)

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

export { ComponentManager }

export function registerComponents(components: ComponentMap|Array<ComponentMap>, namespace: string = 'app') {
  if (Array.isArray(components)) {
    components.forEach(map => ComponentManager.addComponents(map, namespace))
  } else {
    ComponentManager.addComponents(components, namespace)
  }
}

export function resolveNamedComponent(name: string): ComponentDef {
  return ComponentManager.getComponentWithName(name)
}
