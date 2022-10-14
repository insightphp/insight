import { onMounted, onBeforeUnmount } from 'vue'

export function useWindowEvent(event: keyof WindowEventMap, callback: EventListenerOrEventListenerObject) {
  onMounted(() => {
    window.addEventListener(event, callback)
  })

  onBeforeUnmount(() => {
    window.removeEventListener(event, callback)
  })
}
