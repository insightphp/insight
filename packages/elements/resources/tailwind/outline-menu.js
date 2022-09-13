const colors = require("tailwindcss/colors");
const defaultTheme = require("tailwindcss/defaultTheme");

function addItemVariant(name, color, fallbackColor, options) {
  const { addComponents, theme } = options

  addComponents({
    [`.outline-menu .menu-item.${name}`]: {
      color: theme(`colors.${color}.700`, colors[fallbackColor][700]),
    },
    [`.outline-menu .menu-item.${name}:not([data-headlessui-state])`]: {
      '&:hover': {
        backgroundColor: theme(`colors.${color}.100`, colors[fallbackColor][100]),
      }
    },
    [`.outline-menu .menu-item.${name}[data-headlessui-state="active"]`]: {
      backgroundColor: theme(`colors.${color}.100`, colors[fallbackColor][100]),
    },
  })
}

module.exports = function (options) {
  const { addComponents, theme } = options

  addComponents({
    '.outline-menu': {
      display: 'flex',
      'flex-direction': 'column',
      color: theme('colors.gray.700', colors.gray[700]),
      backgroundColor: theme(`colors.white`, colors.white),
      borderColor: theme('colors.gray.200', colors.gray[200]),
      borderWidth: defaultTheme.borderWidth.DEFAULT,
      borderRadius: defaultTheme.borderRadius.lg,
      padding: '.3rem 0',
      '&:focus': {
        outline: 'none',
      }
    },
    '.outline-menu .menu-item': {
      display: 'flex',
      'align-items': 'center',
      'text-align': 'left',
      padding: '.4rem .8rem',
      fontSize: theme('fontSize.sm', defaultTheme.fontSize.sm),
    },
    '.outline-menu .menu-item:not([data-headlessui-state])': {
      '&:hover': {
        backgroundColor: theme('colors.gray.100', colors.gray[100]),
      }
    },
    '.outline-menu .menu-item[data-headlessui-state="active"]': {
      backgroundColor: theme('colors.gray.100', colors.gray[100]),
    }
  })

  addItemVariant('primary', 'primary', 'purple', options)
  addItemVariant('success', 'success', 'green', options)
  addItemVariant('danger', 'danger', 'red', options)
  addItemVariant('warning', 'warning', 'amber', options)
  addItemVariant('info', 'info', 'sky', options)
}
