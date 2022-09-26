# Installation

Elements can be installed in two ways - either as Vue component library or as Inertia View Component library. 

## Installing as a standalone Vue library

This guide will assume you already have your Vue application set up with Tailwind CSS.

To install Elements, run following command:
```sh
npm i -D @insightphp/elements
```

Once installed, you need to configure Tailwind CSS. This consist of two steps.
First, you have to set content paths to library components, so Tailwind can read all classes used by Elements.
Then you have to add Elements Tailwind plugin inside plugins section of your `tailwind.config.js`.

Inside plugins section of your `tailwind.config.js`, add following:
```javascript
module.exports = {
  content: [
    // Other content paths..
    
    './node_modules/@insightphp/elements/resources/**/*.vue',
    './node_modules/@insightphp/elements/resources/**/*.ts',
  ],
  // ...
  plugins: [
    require('@insightphp/elements/tailwind-plugin'),
    // Other plugins...
  ]
  // ...
}
```

That's all for the Elements setup as standalone Vue library. You can now use all components in your Vue templates like following:

```vue
<template>
  <span>{{ title }}</span>
  
  <TextInput v-model="title"/>
</template>
<script setup lang="ts">
import { ref } from "vue";
import { TextInput } from '@insightphp/elements'

const title = ref('')
</script>
```

## Installing as an Inertia View Components library

This guide assumes you already have Inertia View Components installed and set up.

To install Elements as Inertia View Components library, install the PHP package first:
```sh
composer require @insightphp/elements
```

Laravel will automatically discover service provider of the package which will register all available View Components.

After you installed the PHP package, install Vue library like descirbed in the guide above *Installing as a standalone Vue library*.

Once installed, add plugin to your Vue application:
```typescript
import { Plugin as InertiaViewComponents } from '@insightphp/inertia-view'
import { Plugin as ElementsPlugin } from '@insightphp/elements' // Add this import

createInertiaApp({
  // ...
  setup({el, app, props, plugin}) {
    const vueApp = createApp({render: () => h(app, props)})
      .use(plugin)
      .use(ElementsPlugin) // Add this line.
      .use(InertiaViewComponents, {
        components: {
          app: {
            './ViewComponents': import.meta.globEager('./ViewComponents/**/*.vue')
          }
        }
      })

    vueApp.mount(el)
  },
  // ...
})
```
