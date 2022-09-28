const plugin = require('tailwindcss/plugin')
const colors = require('tailwindcss/colors')
const defaultTheme = require('tailwindcss/defaultTheme')

const addButtons = require('./buttons')
const addForms = require('./forms')
const addCard = require('./card')
const addBadges = require('./badges')
const addOutlineMenu = require('./outline-menu')
const addBreadcrumbs = require('./breadcrumbs')
const addBanners = require('./banners')
const addTabs = require('./tabs')
const addSideMenu = require('./side-menu')
const addDate = require('./date')

module.exports = plugin(function(options) {
  addButtons(options)
  addCard(options)
  addForms(options)
  addBadges(options)
  addOutlineMenu(options)
  addBreadcrumbs(options)
  addBanners(options)
  addTabs(options)
  addSideMenu(options)
  addDate(options)
}, {
  theme: {
    extend: {
      fontFamily: {
        'inter': ['Inter', ...defaultTheme.fontFamily.sans],
      },
      colors: {
        primary: colors.purple,
        danger: colors.red,
        warning: colors.amber,
        info: colors.sky,
      }
    }
  },
})
