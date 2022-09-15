const colors = require("tailwindcss/colors");
const defaultTheme = require("tailwindcss/defaultTheme");
module.exports = function (options) {
  const { addComponents, addBase, theme } = options

  // Simple Tabs
  addBase({
    'ul.tabs': {
      display: 'flex',
      flexDirection: 'row',
      borderBottomColor: theme('colors.gray.200', colors.gray[200]),
      borderBottomWidth: defaultTheme.borderWidth.DEFAULT,
    },
    'ul.tabs li': {
      color: theme('colors.gray.700', colors.gray[700]),
      fontSize: theme('fontSize.sm', defaultTheme.fontSize.sm),
      fontWeight: defaultTheme.fontWeight.medium,
      borderBottomColor: 'transparent',
      borderBottomWidth: defaultTheme.borderWidth[2],
      padding: '0 .25rem',
      marginRight: '1.5rem',
      marginBottom: '-1px',
      transitionTimingFunction: defaultTheme.transitionTimingFunction.DEFAULT,
      transitionProperty: defaultTheme.transitionProperty.colors,
      transitionDuration: defaultTheme.transitionDuration[300],
    },
    'ul.tabs li:last-child': {
      marginRight: 0,
    },
    'ul.tabs li > *': {
      display: 'inline-flex',
      flexDirection: 'row',
      alignItems: 'center',
      paddingBottom: '0.3rem',
    },
    'ul.tabs li:hover': {
      color: theme('colors.primary.500', colors.purple[500]),
      borderBottomColor: theme(`colors.primary.500`, colors.purple[500]),
    },
    'ul.tabs li.active': {
      color: theme('colors.primary.700', colors.purple[700]),
      borderBottomColor: theme(`colors.primary.700`, colors.purple[700]),
      '&:hover': {
        color: theme('colors.primary.700', colors.purple[700]),
        borderBottomColor: theme(`colors.primary.700`, colors.purple[700]),
      }
    },
  })

  // Flat Tabs
  addBase({
    'ul.tabs-flat': {
      display: 'flex',
      flexDirection: 'row',
    },
    'ul.tabs-flat li': {
      display: 'inline-flex',
      flexDirection: 'row',
      alignItems: 'center',
      color: theme('colors.gray.700', colors.gray[700]),
      fontSize: theme('fontSize.sm', defaultTheme.fontSize.sm),
      fontWeight: defaultTheme.fontWeight.medium,
      marginRight: '1rem',
      transitionTimingFunction: defaultTheme.transitionTimingFunction.DEFAULT,
      transitionProperty: defaultTheme.transitionProperty.colors,
      transitionDuration: defaultTheme.transitionDuration[300],
      padding: '.25rem 1.25rem',
      borderColor: 'transparent',
      borderWidth: defaultTheme.borderWidth.DEFAULT,
      borderRadius: defaultTheme.borderRadius.lg,
      '&:hover': {
        color: theme('colors.primary.600', colors.purple[600]),
        backgroundColor: theme('colors.primary.100', colors.purple[100]),
        borderColor: theme('colors.primary.100', colors.purple[100]),
      }
    },
    'ul.tabs-flat li.active': {
      color: theme('colors.primary.700', colors.purple[700]),
      backgroundColor: theme('colors.primary.200', colors.purple[200]),
      borderColor: theme('colors.primary.200', colors.purple[200]),
    },
    'ul.tabs-flat li:last-child': {
      marginRight: 0,
    },
    'ul.tabs-flat li > *': {
      display: 'inline-flex',
      flexDirection: 'row',
      alignItems: 'center',
    },
  })
}
