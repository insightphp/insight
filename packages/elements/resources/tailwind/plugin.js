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
const addTables = require('./tables')

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
  addTables(options)
}, {
  theme: {
    extend: {
      fontFamily: {
        'inter': ['Inter', ...defaultTheme.fontFamily.sans],
      },
      colors: {
        primary: colors.purple,
        danger: colors.red,
        success: colors.green,
        warning: colors.amber,
        info: colors.sky,
        gray: {
          25: '#fcfdfd',
          50: '#f9fafb',
          100: '#f2f4f7',
          200: '#eaecf0',
          300: '#d0d5dd',
          400: '#98a2b3',
          500: '#667085',
          600: '#465467',
          700: '#334054',
          800: '#1c2939',
          900: '#101828',
        }
      }
    }
  },
})
