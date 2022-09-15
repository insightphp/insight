const colors = require("tailwindcss/colors");
const defaultTheme = require("tailwindcss/defaultTheme");

function addColoredVariant(name, color, fallbackColor, options) {
  const { addComponents, theme } = options

  addComponents({
    [`.banner.${name}`]: {
      backgroundColor: theme(`colors.${color}.50`, colors[fallbackColor][50]),
      borderColor: theme(`colors.${color}.200`, colors[fallbackColor][200]),
      color: theme(`colors.${color}.700`, colors[fallbackColor][700]),
    }
  })
}

module.exports = function (options) {
  const { addComponents, theme } = options

  addComponents({
    '.banner': {
      backgroundColor: '#fff',
      color: theme('colors.gray.700', colors.gray[700]),
      fontSize: theme('fontSize.sm', defaultTheme.fontSize.sm),
      borderColor: theme(`colors.gray.300`, colors.gray[300]),
      borderRadius: defaultTheme.borderRadius.lg,
      borderWidth: defaultTheme.borderWidth.DEFAULT,
      padding: '.75rem 1rem',
    },
    '.banner h1,h2,h3,h4,h5,h6': {
      fontWeight: defaultTheme.fontWeight.medium,
    }
  })

  addColoredVariant('primary', 'primary', 'purple', options)
  addColoredVariant('success', 'succes', 'green', options)
  addColoredVariant('danger', 'danger', 'red', options)
  addColoredVariant('warning', 'warning', 'amber', options)
  addColoredVariant('info', 'info', 'sky', options)
}
