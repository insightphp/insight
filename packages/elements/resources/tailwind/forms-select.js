const colors = require("tailwindcss/colors");
const defaultTheme = require("tailwindcss/defaultTheme");

const [{ lineHeight: baseLineHeight }] = defaultTheme.fontSize.base
const { spacing, borderWidth, borderRadius } = defaultTheme

module.exports = function ({ addComponents, theme }) {
  addComponents({
    '.select-button': {
      'background-color': '#fff',
      'border-color': theme('colors.gray.300', colors.gray[300]),
      'border-width': borderWidth['DEFAULT'],
      'border-radius': borderRadius.lg,
      'font-size': theme('fontSize.sm', defaultTheme.fontSize.sm),
      'line-height': baseLineHeight,
      '--tw-shadow': '0 0 #0000',
      color: theme('colors.gray.900', colors.gray[900]),
      '&:focus': {
        outline: '2px solid transparent',
        'outline-offset': '2px',
        '--tw-ring-inset': 'var(--tw-empty,/*!*/ /*!*/)',
        '--tw-ring-offset-width': '0px',
        '--tw-ring-offset-color': '#fff',
        '--tw-ring-color': theme('colors.primary.100', colors.purple[100]),
        '--tw-ring-offset-shadow': `var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color)`,
        '--tw-ring-shadow': `var(--tw-ring-inset) 0 0 0 calc(4px + var(--tw-ring-offset-width)) var(--tw-ring-color)`,
        'box-shadow': `var(--tw-ring-offset-shadow), var(--tw-ring-shadow), var(--tw-shadow)`,
        'border-color': theme('colors.primary.300', colors.purple[300]),
      }
    },
    '.select-button-content': {
      'padding-top': spacing[2],
      'padding-right': spacing[3],
      'padding-bottom': spacing[2],
      'padding-left': spacing[3],
    },
    '.select-button.has-error': {
      borderColor: theme('colors.danger.300', colors.red[300]),
      '&:focus': {
        '--tw-ring-color': theme('colors.danger.100', colors.red[100]),
        borderColor: theme('colors.danger.300', colors.red[300]),
      }
    },
    '.select-button.open': {
      'border-bottom-color': colors.transparent,
      'border-bottom-left-radius': borderRadius.none,
      'border-bottom-right-radius': borderRadius.none,
    },
  })
}
