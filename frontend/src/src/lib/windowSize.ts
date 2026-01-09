import { computed, ref } from 'vue'
export const windowHeight = ref(window.innerHeight)
export const windowWidth = ref(window.innerWidth)
export enum WindowSizeType {
  small,
  medium,
  large,
}
export const windowSize = computed<WindowSizeType>(() => {
  if (windowWidth.value < 800) {
    return WindowSizeType.small
  } else if (windowWidth.value < 1024) {
    return WindowSizeType.medium
  } else {
    return WindowSizeType.large
  }
})
window.addEventListener('resize', () => {
  windowHeight.value = window.innerHeight
  windowWidth.value = window.innerWidth
})
