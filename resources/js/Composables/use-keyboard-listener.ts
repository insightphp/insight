import {onBeforeUnmount, onMounted} from "vue";

export function useKeyboardListener(callback: (event: KeyboardEvent) => void) {
  onMounted(() => {
    window.addEventListener('keydown', callback)
  })

  onBeforeUnmount(() => {
    window.removeEventListener('keydown', callback)
  })
}

export function onKeyDown(code: string, callback: (event: KeyboardEvent) => void) {
  useKeyboardListener((event: KeyboardEvent) => {
    if (event.code === code) {
      callback(event)
    }
  })
}

export function onEscapePress(callback: (event: KeyboardEvent) => void) {
  onKeyDown('Escape', callback)
}
