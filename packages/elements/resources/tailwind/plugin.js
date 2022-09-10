const plugin = require('tailwindcss/plugin')
const colors = require('tailwindcss/colors')
const defaultTheme = require('tailwindcss/defaultTheme')

function addButtonVariant(theme, color, defaultColor) {
  return {
    backgroundColor: theme(`colors.${color}.200`, colors[defaultColor][200]),
    color: theme(`colors.${color}.700`, colors[defaultColor][700]),
    borderColor: theme(`colors.${color}.300`, colors[defaultColor][300]),
    '&:hover': {
      backgroundColor: theme(`colors.${color}.100`, colors[defaultColor][100]),
    },
    '&:focus': {
      '--tw-ring-color': theme(`colors.${color}.300`, colors[defaultColor][300]),
      borderColor: theme(`colors.${color}.300`, colors[defaultColor][300]),
    },
    '&:disabled': {
      '&:hover': {
        backgroundColor: theme(`colors.${color}.200`, colors[defaultColor][200]),
      }
    }
  }
}

module.exports = plugin(function({ addUtilities, addComponents, theme, config }) {
  addComponents({
    '.btn': {
      fontSize: theme('fontSize.sm', defaultTheme.fontSize.sm),
      backgroundColor: theme('colors.gray.900', colors.gray[900]),
      color: theme('colors.gray.50', colors.gray[50]),
      borderColor: theme('colors.gray.900', colors.gray[900]),
      padding: '.4rem 1rem',
      borderRadius: defaultTheme.borderRadius.lg,
      fontWeight: defaultTheme.fontWeight.medium,
      borderWidth: defaultTheme.borderWidth.DEFAULT,
      transitionTimingFunction: defaultTheme.transitionTimingFunction.DEFAULT,
      transitionProperty: defaultTheme.transitionProperty.colors,
      transitionDuration: defaultTheme.transitionDuration[150],
      '&:hover': {
        backgroundColor: theme('colors.gray.800', colors.gray[800]),
      },
      '&:focus': {
        outline: '2px solid transparent',
        'outline-offset': '2px',
        '--tw-ring-inset': 'var(--tw-empty,/*!*/ /*!*/)',
        '--tw-ring-offset-width': '2px',
        '--tw-ring-offset-color': '#fff',
        '--tw-ring-color': theme('colors.gray.700', colors.gray[700]),

        '--tw-ring-offset-shadow': `var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color)`,
        '--tw-ring-shadow': `var(--tw-ring-inset) 0 0 0 calc(2px + var(--tw-ring-offset-width)) var(--tw-ring-color)`,
        'box-shadow': `var(--tw-ring-offset-shadow), var(--tw-ring-shadow), var(--tw-shadow)`,
        borderColor: theme('colors.gray.900', colors.gray[900]),
      },
      '&:disabled': {
        opacity: defaultTheme.opacity[70],
        '&:hover': {
          backgroundColor: theme('colors.gray.900', colors.gray[900])
        }
      }
    },
    '.btn.small': {
      fontSize: theme('fontSize.xs', defaultTheme.fontSize.xs),
      padding: '.3rem .8rem',
    },
    '.btn.light': addButtonVariant(theme, 'gray', 'gray'),
    '.btn.primary': addButtonVariant(theme, 'primary', 'purple'),
    '.btn.success': addButtonVariant(theme, 'success', 'green'),
    '.btn.danger': addButtonVariant(theme, 'danger', 'red'),
    '.btn.info': addButtonVariant(theme, 'info', 'blue'),
    '.btn.warning': addButtonVariant(theme, 'warning', 'amber'),
  })
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
