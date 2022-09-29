import { ref } from "vue";
import type { Models } from "../models";

export function useActivatedLink(activation: Models.LinkActivation|null) {
  const active = ref<boolean>(false)

  const updateActivation = (activation: Models.LinkActivation|null) => {

  }

  return { active, updateActivation }
}
