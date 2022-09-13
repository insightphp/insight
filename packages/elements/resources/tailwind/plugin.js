const plugin = require('tailwindcss/plugin')
const colors = require('tailwindcss/colors')

const addButtons = require('./buttons')
const addForms = require('./forms')

module.exports = plugin(function(options) {
  addButtons(options)
  addForms(options)
}, {
  theme: {
    extend: {
      colors: {
        primary: colors.purple,
        danger: colors.red,
        warning: colors.amber,
        info: colors.blue,
      }
    }
  },
})
