/// <reference types="vite/client" />

import { expect, test } from 'vitest'
import { InertiaViewPageManager } from "../js/page-manager";

test('it should register pages', () => {
  const manager = new InertiaViewPageManager()
  manager.addPages(import.meta.glob('./Pages/**/*.vue'))

  expect(manager.getRegisteredPages()).toHaveProperty('app:Profile')
  expect(manager.getRegisteredPages()).toHaveProperty('app:Settings')
  expect(manager.getRegisteredPages()).toHaveProperty('app:Orders/ListOrders')
})

test('it should register pages within custom namespace', () => {
  const manager = new InertiaViewPageManager()
  manager.addPages(import.meta.glob('./Pages/**/*.vue'), 'insight')

  expect(manager.getRegisteredPages()).toHaveProperty('insight:Profile')
  expect(manager.getRegisteredPages()).toHaveProperty('insight:Settings')
  expect(manager.getRegisteredPages()).toHaveProperty('insight:Orders/ListOrders')
})

test('it should resolve page', () => {
  const manager = new InertiaViewPageManager()
  const pages = import.meta.glob('./Pages/**/*.vue')
  manager.addPages(pages)

  expect(manager.resolve('Profile')).toBeDefined()
  expect(manager.resolve('app:Profile')).toBeDefined()
})

test('it should throw error when resolving not registered page', () => {
  const manager = new InertiaViewPageManager()
  expect(() => manager.resolve('NonExistingPage')).toThrowError('The page [NonExistingPage] could not be found.')
})
