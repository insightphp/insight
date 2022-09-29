export { default as Link } from './Link.vue'
export { default as TextInput } from './TextInput.vue'

export namespace Components {
  export interface Link {
    title: string
    location: string
    method: string|null
    as: string|null
    external: boolean
    isActive: boolean
  }

  export interface TextInput {
    id?: string
    name?: string
    modelValue?: string|null|number
    error?: string|null
    type?: string
    placeholder?: string|null
  }
}
