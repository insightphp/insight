import { reactive, watch } from "vue";

export interface DataTableSettings {
  compact: boolean
}

export function createDefaultSettings(
  compact: boolean = false
): DataTableSettings {
  return {
    compact
  }
}

export function useSettings(key: string, defaultSettings: DataTableSettings|null = null) {
  const settings = reactive(defaultSettings || createDefaultSettings())

  const localStorageKey = `data-table-settings:${key}`

  try {
    let storedSettings = localStorage.getItem(localStorageKey)
    if (typeof storedSettings === 'string') {
      const parsedSettings: DataTableSettings = JSON.parse(storedSettings)
      if (typeof parsedSettings === 'object') {
        Object.keys(parsedSettings).forEach(setting => {
          if (Object.keys(settings).includes(setting)) {
            (settings as any)[setting] = (parsedSettings as any)[setting];
          }
        })
      }
    }
  } catch (e) {
    console.error(e)
  }

  watch(settings, newSettings => {
    try {
      localStorage.setItem(localStorageKey, JSON.stringify(newSettings))
      console.log('saved', newSettings)
    } catch (e) {
      console.error(e)
    }
  })

  return { settings }
}
