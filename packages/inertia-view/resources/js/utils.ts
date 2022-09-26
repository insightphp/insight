/**
 * Resolve common path prefix for given list of paths.
 * Paths must be within same directory for this function to work.
 * Given path list:
 *  - ./Components/User.vue
 *  - ./Components/Customers/Avatar.vue
 *  - ./Components/Customers/Settings.vue
 * will resolve to "./Components/" since this is the common base path for all paths.
 */
export function resolveCommonBasePath(paths: Array<string>): string {
  if (paths.length <= 0) {
    throw new Error("At least one file is required for resolving base path.")
  }

  if (paths.length == 1) {
    const parts = paths[0].split('/')

    return `${parts.slice(0, parts.length - 1).join('/')}/`
  }

  const files = [...paths]
  files.sort((a, b) => b.length - a.length)
  const first = files[0]
  const last = files[files.length - 1]

  let eq
  for (eq = 0; eq < Math.min(first.length, last.length) && first[eq] == last[eq]; eq++);

  return first.substring(0, eq)
}
