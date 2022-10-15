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
    // 'ul.breadcrumbs li svg': {
      // color: theme('colors.gray.300', colors.gray[300]),
    // },
    'ul.breadcrumbs li a, ul.breadcrumbs li button': {
      '&:hover': {
        color: theme('colors.gray.800', colors.gray[800]),
      }
    },
    'ul.breadcrumbs li[data-breadcrumb-current="current"]': {
      backgroundColor: theme('colors.gray.50', colors.gray[50]),
      color: theme('colors.gray.700', colors.gray[700]),
      fontWeight: defaultTheme.fontWeight.semibold,
      padding: '0.25rem 0.5rem',
      borderRadius: defaultTheme.borderRadius.md,
    },
  })
}
