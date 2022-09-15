const defaultTheme = require("tailwindcss/defaultTheme");
const colors = require("tailwindcss/colors");

function createColoredButtonVariant(name, color, fallbackColor, options) {
  const { addComponents, theme } = options

  addComponents({
    [`.btn.${name}`]: {
      backgroundColor: theme(`colors.${color}.200`, colors[fallbackColor][200]),
      color: theme(`colors.${color}.700`, colors[fallbackColor][700]),
      borderColor: theme(`colors.${color}.300`, colors[fallbackColor][300]),
      '&:hover': {
        backgroundColor: theme(`colors.${color}.100`, colors[fallbackColor][100]),
      },
      '&:focus': {
        '--tw-ring-color': theme(`colors.${color}.300`, colors[fallbackColor][300]),
        borderColor: theme(`colors.${color}.300`, colors[fallbackColor][300]),
      },
      '&:disabled': {
        '&:hover': {
          backgroundColor: theme(`colors.${color}.200`, colors[fallbackColor][200]),
        }
      }
    },
    [`.btn.${name} .processing-indicator`]: {
      color: theme(`colors.${color}.700`, colors[fallbackColor][700]),
    },
    [`.btn.${name} .processing-animation-spin`]: {
      color: theme(`colors.${color}.700`, colors[fallbackColor][700]),
    },
    [`.btn.${name} .processing-animation-ping span`]: {
      backgroundColor: theme(`colors.${color}.700`, colors[fallbackColor][700]),
    },
    [`.btn-link.${name}`]: {
      color: theme(`colors.${color}.600`, colors[fallbackColor][600]),
      '&:hover': {
        color: theme(`colors.${color}.500`, colors[fallbackColor][500]),
      }
    },
    [`.btn-link.${name}:disabled`]: {
      '&:hover': {
        color: theme(`colors.${color}.600`, colors[fallbackColor][600]),
      },
    },
    [`.btn-link.${name} .processing-indicator`]: {
      color: theme(`colors.${color}.600`, colors[fallbackColor][600]),
    },
    [`.btn-link.${name} .processing-animation-spin`]: {
      color: theme(`colors.${color}.600`, colors[fallbackColor][600]),
    },
    [`.btn-link.${name} .processing-animation-ping span`]: {
      backgroundColor: theme(`colors.${color}.600`, colors[fallbackColor][600]),
    },
  })
}

module.exports = function (options) {
  const { addComponents, theme } = options

  // Regular Button
  addComponents({
    '.btn': {
      display: 'inline-flex',
      'align-items': 'center',
      fontSize: theme('fontSize.sm', defaultTheme.fontSize.sm),
      backgroundColor: '#fff',
      color: theme(`colors.gray.700`, colors.gray[700]),
      borderColor: theme(`colors.gray.300`, colors.gray[300]),
      padding: '.4rem .95rem',
      borderRadius: defaultTheme.borderRadius.lg,
      fontWeight: defaultTheme.fontWeight.medium,
      borderWidth: defaultTheme.borderWidth.DEFAULT,
      transitionTimingFunction: defaultTheme.transitionTimingFunction.DEFAULT,
      transitionProperty: defaultTheme.transitionProperty.colors,
      transitionDuration: defaultTheme.transitionDuration[150],
      '&:hover': {
        backgroundColor: theme('colors.gray.50', colors.gray[50]),
      },
      '&:focus': {
        outline: '2px solid transparent',
        'outline-offset': '2px',
        '--tw-ring-inset': 'var(--tw-empty,/*!*/ /*!*/)',
        '--tw-ring-offset-width': '2px',
        '--tw-ring-color': theme(`colors.gray.300`, colors.gray[300]),
        '--tw-ring-offset-shadow': `var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color)`,
        '--tw-ring-shadow': `var(--tw-ring-inset) 0 0 0 calc(2px + var(--tw-ring-offset-width)) var(--tw-ring-color)`,
        'box-shadow': `var(--tw-ring-offset-shadow), var(--tw-ring-shadow), var(--tw-shadow)`,
        '--tw-ring-offset-color': '#fff',
        borderColor: theme(`colors.gray.300`, colors.gray[300]),
      },
      '&:disabled': {
        opacity: defaultTheme.opacity[70],
        '&:hover': {
          backgroundColor: '#fff',
        }
      }
    },
    '.btn.processing:disabled': {
      opacity: defaultTheme.opacity[100],
    },
    '.btn.processing': {
      cursor: defaultTheme.cursor["not-allowed"]
    },
    '.btn.small': {
      fontSize: theme('fontSize.xs', defaultTheme.fontSize.xs),
      padding: '.3rem .8rem',
    },
    '.btn .processing-indicator': {
      color: theme('colors.gray.700', colors.gray[700]),
    },
    '.btn .processing-animation-spin': {
      color: theme('colors.gray.700', colors.gray[700]),
    },
    '.btn .processing-animation-ping span': {
      backgroundColor: theme('colors.gray.700', colors.gray[700]),
    },
  })

  // Link Button
  addComponents({
    '.btn-link': {
      display: 'inline-flex',
      'align-items': 'center',
      fontSize: theme('fontSize.sm', defaultTheme.fontSize.sm),
      color: theme('colors.gray.700', colors.gray[700]),
      fontWeight: defaultTheme.fontWeight.medium,
      '&:hover': {
        color: theme('colors.gray.800', colors.gray[800]),
      },
    },
    '.btn-link:disabled': {
      opacity: defaultTheme.opacity[60],
      '&:hover': {
        color: theme('colors.gray.900', colors.gray[900]),
      },
    },
    '.btn-link .processing-indicator': {
      color: theme('colors.gray.900', colors.gray[900]),
    },
    '.btn-link .processing-animation-spin': {
      color: theme('colors.gray.900', colors.gray[900]),
    },
    '.btn-link .processing-animation-ping span': {
      backgroundColor: theme('colors.gray.900', colors.gray[900]),
    },
    '.btn-link.processing': {
      cursor: defaultTheme.cursor["not-allowed"]
    },
    '.btn-link.processing:disabled': {
      opacity: defaultTheme.opacity[100],
    },
  })

  // Dark Variant of Button
  addComponents({
    '.btn.dark': {
      backgroundColor: theme('colors.gray.900', colors.gray[900]),
      color: theme('colors.gray.50', colors.gray[50]),
      borderColor: theme('colors.gray.900', colors.gray[900]),
      '&:hover': {
        backgroundColor: theme('colors.gray.800', colors.gray[800]),
      },
      '&:focus': {
        '--tw-ring-color': theme('colors.gray.700', colors.gray[700]),
        borderColor: theme('colors.gray.900', colors.gray[900]),
      }
    },
    '.btn.dark .processing-indicator': {
      color: theme('colors.gray.50', colors.gray[50]),
    },
    '.btn.dark .processing-animation-spin': {
      color: theme('colors.gray.50', colors.gray[50]),
    },
    '.btn.dark .processing-animation-ping span': {
      backgroundColor: theme('colors.gray.50', colors.gray[50]),
    },
  })

  // Colored Variants
  createColoredButtonVariant('primary', 'primary', 'purple', options)
  createColoredButtonVariant('success', 'success', 'green', options)
  createColoredButtonVariant('danger', 'danger', 'red', options)
  createColoredButtonVariant('info', 'info', 'blue', options)
  createColoredButtonVariant('warning', 'warning', 'amber', options)
}
