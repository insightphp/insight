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
  })

  const createNavigation: (navigation: Models.Navigation) => StatefulNavigation = (navigation) => ({
    items: navigation.items.map(it => createItem(it)),
    childActive: ref(false)
  })

  const statefulNavigation = createNavigation(navigation)

  const refreshStateOfNavigationItem = (item: StatefulNavigationItem) => {
    item.isActive.value = isItemActivated(item.item)
    if (item.childNavigation) {
      refreshStateOfNavigation(item.childNavigation)
    }
  }

  const refreshStateOfNavigation = (navigation: StatefulNavigation) => {
    navigation.items.forEach(it => refreshStateOfNavigationItem(it))

    navigation.childActive.value = navigation.items.some(it => it.isActive.value)
  }

  let activeInertiaListener: VoidFunction

  onMounted(() => {
    activeInertiaListener = Inertia.on('finish', () => {
      refreshStateOfNavigation(statefulNavigation)
    })

    refreshStateOfNavigation(statefulNavigation)
  })

  onBeforeUnmount(() => {
    activeInertiaListener()
  })

  return {
    navigation: statefulNavigation,
  }
}
