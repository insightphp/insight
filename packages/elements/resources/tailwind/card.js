const defaultTheme = require("tailwindcss/defaultTheme");
const colors = require("tailwindcss/colors");

module.exports = function ({ addComponents, theme }) {
  addComponents({
    '.card': {
      backgroundColor: theme(`colors.white`, colors.white),
      borderColor: theme('colors.gray.200', colors.gray[200]),
      borderWidth: defaultTheme.borderWidth.DEFAULT,
      borderRadius: defaultTheme.borderRadius.lg,
    },
    '.card .card-footer': {
      backgroundColor: theme('colors.gray.100', colors.gray[100]),
      'border-top-color': theme('colors.gray.200', colors.gray[200]),
      'border-top-width': defaultTheme.borderWidth.DEFAULT,
      'border-bottom-width': defaultTheme.borderWidth.DEFAULT,
      'border-bottom-color': colors.transparent,
      'border-bottom-left-radius': '0.43rem',
      'border-bottom-right-radius': '0.43rem',
    }
  })
}
