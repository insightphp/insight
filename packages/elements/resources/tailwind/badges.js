const defaultTheme = require("tailwindcss/defaultTheme");
const colors = require("tailwindcss/colors");

function addBadgeVariant(name, color, fallbackColor, options) {
  const { addComponents, theme } = options

  addComponents({
    [`.badge.${name}`]: {
      backgroundColor: theme(`colors.${color}.200`, colors[fallbackColor][200]),
      color: theme(`colors.${color}.700`, colors[fallbackColor][700]),
      borderColor: theme(`colors.${color}.200`, colors[fallbackColor][200]),
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
      backgroundColor: theme('colors.gray.600', colors.gray[600]),
      color: theme('colors.gray.50', colors.gray[50]),
      borderColor: theme('colors.gray.600', colors.gray[600]),
      padding: '.05rem .4rem',
      borderRadius: defaultTheme.borderRadius.full,
      borderWidth: defaultTheme.borderWidth.DEFAULT,
      fontWeight: defaultTheme.fontWeight.medium,
    },
    '.badge.light': {
      backgroundColor: theme('colors.gray.200', colors.gray[200]),
      color: theme('colors.gray.700', colors.gray[700]),
      borderColor: theme('colors.gray.200', colors.gray[200]),
    },
    '.badge.large': {
      fontSize: theme('fontSize.sm', defaultTheme.fontSize.sm),
      padding: '0 .6rem',
    }
  })

  addBadgeVariant('primary', 'primary', 'purple', options)
  addBadgeVariant('success', 'success', 'green', options)
  addBadgeVariant('danger', 'danger', 'red', options)
  addBadgeVariant('warning', 'warning', 'amber', options)
  addBadgeVariant('info', 'info', 'sky', options)
}
