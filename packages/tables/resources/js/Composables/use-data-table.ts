import type { ComputedRef, Ref } from "vue";
import { computed, customRef, ref, watch } from "vue";
import type { ParsedQs } from 'qs'
import qs from 'qs'
import { Inertia } from "@inertiajs/inertia";

function debouncedRef(value: string, delay = 400) {
  let timeout: number
  return customRef((track, trigger) => {
    return {
      get() {
        track()
        return value
      },
      set(newValue) {
        clearTimeout(timeout)
        timeout = setTimeout(() => {
          value = newValue
          trigger()
        }, delay)
      }
    }
  })
}

export interface DataTableHandler {
  perPage: Ref<number>
  searchTerm: Ref<string>
  sortAs: Ref<string>
  isSearching: ComputedRef<boolean>
}

export function unpackSortAs(value: string): { sortAs: string, direction: 'asc' | 'desc' } {
  if (value.includes(':')) {
    const [sortAs, direction] = value.split(':')

    return { sortAs, direction: direction as any }
  }

  return { sortAs: '', direction: 'asc' }
}

export function packSortAs(sortAs: string, sortDirection: 'asc' | 'desc'): string {
  if (sortAs.length > 0) {
    return `${sortAs}:${sortDirection}`
  }

  return ''
}

export interface DataTableHandlerOptions {
  prefix: string
  perPageParam: string
  searchParam: string
  sortAsParam: string
  sortDirectionParam: string
}

type Query = ParsedQs

function resolvePerPageFromQuery(defaultValue: number, query: Query, key: string, prefix: string): number {
  const param = `${prefix}${key}`

  if (query.hasOwnProperty(param)) {
      const value = parseInt(`${query[param]}`)

      if (! isNaN(value) && value > 0) {
        return value
      }
  }

  return defaultValue
}

function setPerPageToQuery(value: number, defaultValue: number, query: Query, key: string, prefix: string) {
  const param = `${prefix}${key}`

  if (value === defaultValue) {
    delete query[param]
  } else {
    query[param] = `${value}`
  }
}

function resolveSearchFromQuery(query: Query, key: string, prefix: string): string {
  const param = `${prefix}${key}`

  if (query.hasOwnProperty(param)) {
    return `${query[param]}`
  }

  return ''
}

function setSearchToQuery(value: string, defaultValue: string, query: Query, key: string, prefix: string) {
  const param = `${prefix}${key}`

  if (value === defaultValue) {
    delete query[param]
  } else {
    query[param] = `${value}`
  }
}

function resolveSortAsFromQuery(query: Query, defaultDirection: 'asc' | 'desc', sortAsKey: string, sortDirectionKey: string, prefix: string): string {
  const sortAsParam = `${prefix}${sortAsKey}`

  if (query.hasOwnProperty(sortAsParam)) {
    const value = query[sortAsParam]

    if (typeof value === 'string' && value.length > 0) {
      const sortDirectionParam = `${prefix}${sortDirectionKey}`

      const direction = query[sortDirectionParam]
      const finalDirection = direction === 'asc' || direction === 'desc' ? direction : defaultDirection

      return `${value}:${finalDirection}`
    }
  }

  return ''
}

function setSortAsToQuery(value: string, query: Query, sortAsKey: string, sortDirectionKey: string, prefix: string) {
  const sortAsParam = `${prefix}${sortAsKey}`
  const sortDirectionParam = `${prefix}${sortDirectionKey}`

  const sortAs = unpackSortAs(value)

  if (sortAs.sortAs.length > 0) {
    query[sortAsParam] = sortAs.sortAs
    query[sortDirectionParam] = sortAs.direction
  } else {
    delete query[sortAsParam]
    delete query[sortDirectionParam]
  }
}

export function useDataTable(options: DataTableHandlerOptions = {
  prefix: '', perPageParam: 'limit', searchParam: 's' ,
  sortAsParam: 'sort_by', sortDirectionParam: 'sort_as'
}): DataTableHandler {
  const perPage = ref(25)
  const searchTerm = ref('')
  const sortAs = ref('')
  const querySearchTerm = debouncedRef('')

  const updateFromQuery = (query: ParsedQs) => {
    perPage.value = resolvePerPageFromQuery(25, query, options.perPageParam, options.prefix)
    searchTerm.value = resolveSearchFromQuery(query, options.searchParam, options.prefix)
    sortAs.value = resolveSortAsFromQuery(query, 'desc', options.sortAsParam, options.sortDirectionParam, options.prefix)
  }

  const isSearching = computed(() => searchTerm.value.length > 0)

  const parseCurrentQuery = () => {
    let search = window.location.search

    if (search.startsWith('?')) {
      search = search.slice(1, search.length)
    }

    return qs.parse(search)
  }

  const formatUrl = (query: ParsedQs) => {
    const formattedQuery = qs.stringify(query, { encode: true })

    const baseUrl = window.location.href.split('?')[0]

    if (formattedQuery.length > 0) {
      return `${baseUrl}?${formattedQuery}`
    }

    return baseUrl
  }

  let parsedQuery = parseCurrentQuery()

  updateFromQuery(parsedQuery)

  const saveQuery = () => {
    const currentQuery = parseCurrentQuery()
    if (JSON.stringify(currentQuery).split('').sort().join() != JSON.stringify(parsedQuery).split('').sort().join()) {
      Inertia.visit(formatUrl(parsedQuery), {
        preserveState: true
      })
    }
  }

  watch(perPage, newPerPage => {
    setPerPageToQuery(newPerPage, 25, parsedQuery, options.perPageParam, options.prefix)

    saveQuery()
  })

  watch(searchTerm, newTerm => {
    querySearchTerm.value = newTerm
  })

  watch(querySearchTerm, newTerm => {
    setSearchToQuery(newTerm, '', parsedQuery, options.searchParam, options.prefix)

    saveQuery()
  })

  watch(sortAs, newSortAs => {
    setSortAsToQuery(newSortAs, parsedQuery, options.sortAsParam, options.sortDirectionParam, options.prefix)

    saveQuery()
  })

  return {
    perPage, searchTerm, sortAs, isSearching
  }
}
