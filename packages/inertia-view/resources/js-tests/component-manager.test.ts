/// <reference types="vite/client" />

import { expect, test } from 'vitest'
import { InertiaViewComponentManager } from "../js/component-manager";

test('it should register components', () => {
  const components = import.meta.glob('./Components/**/*.vue')

  const manager = new InertiaViewComponentManager()

  manager.addComponents(components)

  expect(manager.getResolvedComponents()).toHaveProperty('app-user')
  expect(manager.getResolvedComponents()).toHaveProperty('app-profile-payments')
  expect(manager.getResolvedComponents()).toHaveProperty('app-profile-settings')
})

test('it should register components from multiple paths to single namespace', () => {
  const components = import.meta.glob('./Components/**/*.vue')
  const anoherComponents = import.meta.glob('./AnotherComponents/**/*.vue')

  const manager = new InertiaViewComponentManager()

  manager.addComponents(components)
  manager.addComponents(anoherComponents)

  const resolvedComponents = manager.getResolvedComponents()

  expect(Object.keys(resolvedComponents)).toHaveLength(5)
  expect(resolvedComponents).toHaveProperty('app-user')
  expect(resolvedComponents).toHaveProperty('app-profile-payments')
  expect(resolvedComponents).toHaveProperty('app-profile-settings')
  expect(resolvedComponents).toHaveProperty('app-product')
  expect(resolvedComponents).toHaveProperty('app-customer-orders')
})

test('it should register components to multiple namespaces', () => {
  const components = import.meta.glob('./Components/**/*.vue')
  const anoherComponents = import.meta.glob('./AnotherComponents/**/*.vue')

  const manager = new InertiaViewComponentManager()

  manager.addComponents(components)
  manager.addComponents(anoherComponents, 'commerce')

  const resolvedComponents = manager.getResolvedComponents()

  expect(Object.keys(resolvedComponents)).toHaveLength(5)
  expect(resolvedComponents).toHaveProperty('app-user')
  expect(resolvedComponents).toHaveProperty('app-profile-payments')
  expect(resolvedComponents).toHaveProperty('app-profile-settings')
  expect(resolvedComponents).toHaveProperty('commerce-product')
  expect(resolvedComponents).toHaveProperty('commerce-customer-orders')
})

test('it should register empty components', () => {
  const manager = new InertiaViewComponentManager()

  const components = import.meta.glob('./Components/**/NonExistingComponent*.vue')

  manager.addComponents(components)

  expect(Object.keys(manager.getResolvedComponents())).toHaveLength(0)
})

test('it should register single component', () => {
  const manager = new InertiaViewComponentManager()

  const components = import.meta.glob('./Components/**/User.vue')

  manager.addComponents(components)

  expect(Object.keys(manager.getResolvedComponents())).toHaveLength(1)
  expect(manager.getResolvedComponents()).toHaveProperty('app-user')
})
