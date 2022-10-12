const defaultTheme = require("tailwindcss/defaultTheme");
const colors = require("tailwindcss/colors");

function addColoredVariant(name, color, fallbackColor, options) {
  const { addComponents, theme } = options

  addComponents({
    [`.badge.${name}`]: {
      backgroundColor: theme(`colors.${color}.50`, colors[fallbackColor][50]),
      color: theme(`colors.${color}.700`, colors[fallbackColor][700]),
      borderColor: theme(`colors.${color}.50`, colors[fallbackColor][50]),
    }
  })
}

module.exports = function (options) {
  const { addComponents, theme } = options

  addComponents({
    '.badge': {
      display: 'inline-flex',
      'align-items': 'center',
      fontSize: theme('fontSize.xs', defaultTheme.fontSize.xs),
      backgroundColor: '#fff',
      color: theme('colors.gray.700', colors.gray[700]),
      borderColor: theme('colors.gray.300', colors.gray[300]),
      padding: '.05rem .4rem',
      borderRadius: defaultTheme.borderRadius.full,
      borderWidth: defaultTheme.borderWidth.DEFAULT,
      fontWeight: defaultTheme.fontWeight.medium,
    },
    '.badge.dark': {
      backgroundColor: theme('colors.gray.900', colors.gray[900]),
      color: theme('colors.gray.50', colors.gray[50]),
      borderColor: theme('colors.gray.900', colors.gray[900]),
    },
    '.badge.large': {
      fontSize: theme('fontSize.sm', defaultTheme.fontSize.sm),
      padding: '0 .6rem',
    }
  })

  addColoredVariant('primary', 'primary', 'purple', options)
  addColoredVariant('success', 'success', 'green', options)
  addColoredVariant('danger', 'danger', 'red', options)
  addColoredVariant('warning', 'warning', 'amber', options)
  addColoredVariant('info', 'info', 'sky', options)
}
