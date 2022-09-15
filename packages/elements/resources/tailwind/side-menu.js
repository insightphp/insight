const colors = require("tailwindcss/colors");
const defaultTheme = require("tailwindcss/defaultTheme");

function configureListItemDepth(options, basePadding = 8, size = 20, depth = 4) {
  const { addComponents } = options

  for (let i = 1; i <= depth; i++) {
    const finalPadding = `${(size * (i) + basePadding)}px`

    const prefix = Array.from(Array(i).keys()).map(() => `ul > li`).join(' ')

    addComponents({
      [`ul.side-menu > li > ${prefix} > button`]: { paddingLeft: finalPadding },
      [`ul.side-menu > li > ${prefix} > a`]: { paddingLeft: finalPadding },
    })
  }
}

module.exports = function (options) {
  const { addComponents, theme } = options

  addComponents({
    'ul.side-menu': {
      borderLeftColor: theme('colors.gray.200', colors.gray[200]),
      borderLeftWidth: defaultTheme.borderWidth.DEFAULT,
      padding: '.4rem 0'
    },

    'ul.side-menu li': {
      color: theme('colors.gray.700', colors.gray[700]),
      fontSize: theme('fontSize.sm', defaultTheme.fontSize.sm),
      position: 'relative',
    },

    // Ensure border of a/button aligns with border of the root list.
    'ul.side-menu > li': {
      marginLeft: '-1px',
    },

    'ul.side-menu li > .caret': {
      position: 'absolute',
      right: 0,
      top: '6px',
      transitionTimingFunction: defaultTheme.transitionTimingFunction.DEFAULT,
      transitionProperty: defaultTheme.transitionProperty.transform,
      transitionDuration: defaultTheme.transitionDuration[150],
      pointerEvents: 'none'
    },

    'ul.side-menu li > button, ul.side-menu li > a': {
      display: 'flex',
      width: '100%',
      borderLeftColor: 'transparent',
      borderLeftWidth: '2px',
      paddingLeft: '8px',
      paddingTop: '2px',
      paddingBottom: '2px',
      transitionTimingFunction: defaultTheme.transitionTimingFunction.DEFAULT,
      transitionProperty: defaultTheme.transitionProperty.colors,
      transitionDuration: defaultTheme.transitionDuration[150],
      '&:hover': {
        color: theme('colors.primary.500', colors.purple[500]),
        borderColor: theme('colors.primary.400', colors.purple[400]),
      }
    },

    'ul.side-menu li.active > button, ul.side-menu li.active > a': {
      color: theme('colors.primary.800', colors.purple[800]),
      borderColor: theme('colors.primary.800', colors.purple[800]),
      fontWeight: defaultTheme.fontWeight.medium,
    },

    'ul.side-menu li > ul': {
      display: 'none',
    },

    'ul.side-menu li.expanded > ul': {
      display: 'block'
    },
    'ul.side-menu li.expanded > .caret': {
      transform: 'rotate(180deg)'
    },
  })

  configureListItemDepth(options)
}
