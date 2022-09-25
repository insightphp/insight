import { expect, test } from 'vitest'
import ComponentManager from "../js/component-manager";

test('it should register components', () => {
  const components = import.meta.glob('./Components/**/*.vue')

  ComponentManager.addComponents(components)

  expect(ComponentManager.getResolvedComponents())
    .toHaveProperty('app-user')
    .toHaveProperty('app-profile-payments')
    .toHaveProperty('app-profile-settings')
})
