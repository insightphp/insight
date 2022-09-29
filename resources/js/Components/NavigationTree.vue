<script lang="ts">
import { h, defineComponent, withModifiers, mergeProps, computed } from "vue";
import type { PropType, VNode, Slot } from 'vue';
import type { Models } from "../models";
import { useStatefulNavigation } from "../Composables";
import type { StatefulNavigation, StatefulNavigationItem } from "../Composables";
import { Portal } from "@insightphp/inertia-view";

function renderNavigationItem(renderItem: Slot, renderCaret: Slot|undefined, item: StatefulNavigationItem) {
  if (item.childNavigation) {
    const childs: Array<VNode> = []

    if (item.item.link.location == '#') {
      childs.push(
          h('button', {
            onClick: withModifiers(() => {
              item.isExpanded.value = !item.isExpanded.value
            }, ['prevent']),
          }, item.item.link.title)
      )
    } else {
      childs.push(
          h(Portal, {
            component: item.item.link,
            onClick: withModifiers(() => {
              item.isExpanded.value = true
            }, ['prevent'])
          })
      )
    }

    if (renderCaret) {
      childs.push(h(renderCaret, {
        toggle: () => {
          item.isExpanded.value = !item.isExpanded.value
        }
      }))
    }

    childs.push(renderNavigation(renderItem, renderCaret, item.childNavigation))

    return h('li', mergeProps({
      class: { 'expanded': item.isExpanded.value, 'active': item.isActive.value }
    }), childs)
  } else {
    return h(renderItem, { item: item.item, active: item.isActive })
  }
}

function renderNavigation(renderItem: Slot, renderCaret: Slot|undefined, navigation: StatefulNavigation, props: any = {}) {
  const items: Array<VNode> = []

  navigation.items.forEach(it => {
    items.push(renderNavigationItem(renderItem, renderCaret, it))
  })

  return h('ul', props, items)
}

export default defineComponent({
  props: {
    navigation: { type: Object as PropType<Models.Navigation>, required: true }
  },
  setup(props, { slots }) {
    const itemSlot = slots.item
    const caretSlot = slots.caret

    if (! itemSlot) {
      throw new Error("The #item slot is missing from NavigationTree component.")
    }

    const navigation = computed(() => props.navigation)

    const statefulNavigation = useStatefulNavigation(navigation)

    return () => renderNavigation(itemSlot, caretSlot, statefulNavigation.navigation, { class: ['side-menu'] })
  }
})
</script>
