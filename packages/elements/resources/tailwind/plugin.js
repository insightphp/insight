const plugin = require('tailwindcss/plugin')
const colors = require('tailwindcss/colors')

const addButtons = require('./buttons')
const addForms = require('./forms')
const addCard = require('./card')
const addBadges = require('./badges')
const addOutlineMenu = require('./outline-menu')

module.exports = plugin(function(options) {
  addButtons(options)
  addCard(options)
  addForms(options)
  addBadges(options)
  addOutlineMenu(options)
}, {
  theme: {
    extend: {
      colors: {
        primary: colors.purple,
        danger: colors.red,
        warning: colors.amber,
        info: colors.sky,
      }
    }
  },
})
