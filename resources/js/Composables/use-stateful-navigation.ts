import type { Models } from "../models";
import type { Ref } from 'vue'
import { onBeforeUnmount, onMounted, ref } from "vue";
import type { Models as ElementsModels } from "@insightphp/elements";
import route from "ziggy-js";
import { Inertia } from "@inertiajs/inertia";

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

export function isActivated(activation: ElementsModels.LinkActivation) {
  if (activation.activatedOnRoutes.some(it => route().current(it.route, it.params))) {
    return true
  }

  // TODO: Check for locations

  return false
}

export function useStatefulNavigation(navigation: Models.Navigation) {
  const isItemActivated = (item: Models.NavigationItem) => {
    const activation = item.link.isActive

    if (activation) {
      return isActivated(activation)
    }

    return false
  }

  const createItem: (item: Models.NavigationItem) => StatefulNavigationItem = (item) => ({
    item,
    isActive: ref(isItemActivated(item)),
    childNavigation: item.childNavigation ? createNavigation(item.childNavigation) : null,
    isExpanded: ref(false),
  })

  const createNavigation: (navigation: Models.Navigation) => StatefulNavigation = (navigation) => ({
    items: navigation.items.map(it => createItem(it)),
    childActive: ref(false)
  })

  const statefulNavigation = createNavigation(navigation)

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

  const refreshStateOfNavigation = (navigation: StatefulNavigation) => {
    navigation.items.forEach(it => {
      it.isActive.value = isItemActivated(it.item)

      if (it.childNavigation) {
        refreshStateOfNavigation(it.childNavigation)
      }
    })

    navigation.childActive.value = navigation.items.some(it => it.isActive.value)
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

  let activeInertiaListener: VoidFunction

  onMounted(() => {
    activeInertiaListener = Inertia.on('finish', () => {
      refreshStateOfNavigation(statefulNavigation)
      refreshStateOfExpansions(statefulNavigation, true)
    })

    refreshStateOfNavigation(statefulNavigation)
    refreshStateOfExpansions(statefulNavigation)
  })

  onBeforeUnmount(() => {
    activeInertiaListener()
  })

  return {
    navigation: statefulNavigation,
  }
}
