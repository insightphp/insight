const defaultTheme = require("tailwindcss/defaultTheme");
const colors = require("tailwindcss/colors");

module.exports = function (options) {
  const { addBase, theme } = options

  addBase({
    'ul.breadcrumbs': {
      display: 'flex',
      'flex-direction': 'row',
      'align-items': 'center',
    },
    'ul.breadcrumbs li': {
      display: 'inline-flex',
      'flex-direction': 'row',
      'align-items': 'center',
      fontSize: theme('fontSize.sm', defaultTheme.fontSize.sm),
      fontWeight: defaultTheme.fontWeight.medium,
      color: theme('colors.gray.500', colors.gray[500]),
    },
    'ul.breadcrumbs li svg': {
      color: theme('colors.gray.600', colors.gray[600]),
    },
    'ul.breadcrumbs li a, ul.breadcrumbs li button': {
      '&:hover': {
        color: theme('colors.gray.800', colors.gray[800]),
      }
    },
    'ul.breadcrumbs li[data-breadcrumb-current="current"]': {
      color: theme('colors.gray.800', colors.gray[800]),
    },
  })
}
