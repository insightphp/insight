# Components

## Text Input

The `TextInput` component is a standard `input` component.

### Basic usage

```vue
<template>
  <TextInput v-model="value" />
</template>
<script setup lang="ts">
import { TextInput } from '@insightphp/elements'
import { ref } from "vue";

const value = ref('')
</script>
```

### Props

You can pass any standard `input` attributes to the `TextInput`. Besides that, `TextInput` has few more available
properties that can be set.

#### error

- **Type:** `?string | null`

The `error` prop is used to render error message under the input. The `input` has also different style when `error` is
set to some string.

### Emits

The `TextInput` component emits single event when that `input` value changes.

#### @input

- **Type:** `(text: string) => void`

The event is emmited when an `input` changes its value.
