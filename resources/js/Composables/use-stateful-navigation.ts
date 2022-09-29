import type { Models } from "../models";
import type { ComputedRef, Ref } from 'vue'
import { ref, watch } from "vue";

export interface StatefulNavigation {
  items: Array<StatefulNavigationItem>
  childActive: Ref<boolean>
}

export interface StatefulNavigationItem {
  item: Models.NavigationItem
  childNavigation: StatefulNavigation|null
  isActive: Ref<boolean>
  isExpanded: Ref<boolean>
}

export function useStatefulNavigation(navigation: ComputedRef<Models.Navigation>) {
  const createNavigation: (navigation: Models.Navigation) => StatefulNavigation = (navigation) => ({
    items: navigation.items.map(it => ({
      item: it,
      isActive: ref(it.link.isActive),
      childNavigation: it.childNavigation ? createNavigation(it.childNavigation) : null,
      isExpanded: ref(false),
    })),
    childActive: ref(false)
  })

  const isAnyChildActive: (navigation: StatefulNavigation) => boolean = (navigation) => {
    return navigation.items.some(it => {
      if (it.isActive.value) {
        return true
      }

      if (it.childNavigation) {
        return isAnyChildActive(it.childNavigation)
      }

      return false
    })
  }

  const refreshStateOfExpansions = (navigation: StatefulNavigation, keepOpenStates: boolean = false) => {
    navigation.items.forEach(item => {
      if (item.childNavigation) {
        if (keepOpenStates && item.isExpanded.value) {
          refreshStateOfExpansions(item.childNavigation, keepOpenStates)
          return
        }

        item.isExpanded.value = item.isActive.value || isAnyChildActive(item.childNavigation)
        refreshStateOfExpansions(item.childNavigation)
      } else{
        if (keepOpenStates && item.isExpanded.value) {
          return
        }

        item.isExpanded.value = item.isActive.value
      }
    })
  }

  const updateNavigation = (existingNavigation: StatefulNavigation, updatedNavigation: Models.Navigation) => {
    existingNavigation.items.forEach((item) => {
      const updatedItem = updatedNavigation.items.find(it => it.link.location === item.item.link.location)

      if (updatedItem) {
        item.isActive.value = updatedItem.link.isActive

        if (item.childNavigation && updatedItem.childNavigation) {
          updateNavigation(item.childNavigation, updatedItem.childNavigation)
        }
      }
    })
  }

  const statefulNavigation = createNavigation(navigation.value)

  watch(navigation, newNavigation => {
    updateNavigation(statefulNavigation, newNavigation)
    refreshStateOfExpansions(statefulNavigation, true)
  })

  refreshStateOfExpansions(statefulNavigation)

  return {
    navigation: statefulNavigation,
  }
}
