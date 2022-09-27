import type { ComponentMap } from "./contracts";
import type { DefineComponent } from "vue";
import type { ComponentDef } from "./contracts";
import { resolveCommonBasePath } from "./utils";
import Portal from "./portal";

export class InertiaViewPageManager {

  registeredPages: Record<string, ComponentDef> = {}

  /**
   * Retrieve map of registered pages.
   */
  getRegisteredPages(): Record<string, ComponentDef> {
    return this.registeredPages
  }

  /**
   * Register pages for given namespace.
   */
  addPages(pages: Record<string, ComponentDef>, namespace: string = 'app'): InertiaViewPageManager {
    const paths = Object.keys(pages)

    if (paths.length <= 0) {
      // TODO: Ignore when runnning on vitest.
      console.warn(`No pages have been found when registering namespace [${namespace}].`)
      return this
    }

    const base = resolveCommonBasePath(paths)

    Object.keys(pages).forEach(fileName => {
      const path = fileName.replace(base, '').replace('.vue', '')

      this.registeredPages[`${namespace}:${path}`] = pages[fileName]
    })

    return this
  }

  /**
   * Resolve page with given name.
   *
   * @param page
   */
  resolve(page: string): Promise<ComponentDef> {
    let path = page

    if (! path.includes(':')) {
      path = `app:${path}`
    }

    if (! Object.keys(this.registeredPages).includes(path)) {
      throw new Error(`The page [${page}] could not be found.`)
    }

    const pageComponent = (this.registeredPages[path] as any).default

    if (! pageComponent.layout) {
      pageComponent.layout = (h: any, page: any) => {
        if (Array.isArray(page.props._layouts)) {
          const nestedLayouts = [...page.props._layouts].reverse()
          const renderFunctions: Array<any> = []
          nestedLayouts.forEach((layout, index) => {
            if (index == 0) {
              renderFunctions.push(() => h(Portal, { component: layout }, () => page))
            } else {
              renderFunctions.push(() => h(Portal, { component: layout }, renderFunctions[index - 1]))
            }
          })

          return renderFunctions[renderFunctions.length - 1]()
        }

        return h(page)
      }
    }

    return pageComponent
  }
}

const PageManager = new InertiaViewPageManager()
export { PageManager }

export function registerPages(pages: ComponentMap|Array<ComponentMap>, namespace: string = 'app') {
  if (Array.isArray(pages)) {
    pages.forEach(map => PageManager.addPages(map, namespace))
  } else {
    PageManager.addPages(pages, namespace)
  }
}

export function resolvePage(name: string): DefineComponent | Promise<DefineComponent> | { default: DefineComponent } {
  // TODO: Add correct types
  return PageManager.resolve(name) as any
}
