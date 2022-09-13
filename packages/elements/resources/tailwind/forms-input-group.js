const colors = require("tailwindcss/colors");
const defaultTheme = require("tailwindcss/defaultTheme");

const { borderWidth, borderRadius } = defaultTheme

module.exports = function ({ addComponents, theme }) {
  addComponents({
    '.input-group:focus-within .input-group-widget': {
      'border-color': theme('colors.primary.300', colors.purple[300]),
    },
    '.input-group:focus-within': {
      'border-color': 'transparent',
      'border-width': 0,
      'border-radius': borderRadius.lg,
      outline: '2px solid transparent',
      'outline-offset': '2px',
      '--tw-ring-inset': 'var(--tw-empty,/*!*/ /*!*/)',
      '--tw-ring-offset-width': '0px',
      '--tw-ring-offset-color': '#fff',
      '--tw-ring-color': theme('colors.primary.100', colors.purple[100]),
      '--tw-ring-offset-shadow': `var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color)`,
      '--tw-ring-shadow': `var(--tw-ring-inset) 0 0 0 calc(4px + var(--tw-ring-offset-width)) var(--tw-ring-color)`,
      'box-shadow': `var(--tw-ring-offset-shadow), var(--tw-ring-shadow), var(--tw-shadow)`,
    },
    '.input-group.has-error .input-group-left': {
      borderColor: theme('colors.danger.300', colors.red[300]),
    },
    '.input-group.has-error .input-group-right': {
      borderColor: theme('colors.danger.300', colors.red[300]),
    },
    '.input-group.has-error .form-input': {
      borderColor: theme('colors.danger.300', colors.red[300]),
    },
    '.input-group.has-error:focus-within': {
      '--tw-ring-color': theme('colors.danger.100', colors.red[100]),
      borderColor: theme('colors.danger.300', colors.red[300]),
    },
    '.input-group .form-input': {
      '&:focus': {
        '--tw-ring-offset-shadow': 'var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color)',
        '--tw-ring-shadow': 'var(--tw-ring-inset) 0 0 0 calc(0px + var(--tw-ring-offset-width)) var(--tw-ring-color)',
        'box-shadow': 'var(--tw-ring-offset-shadow), var(--tw-ring-shadow), var(--tw-shadow, 0 0 #0000)',
      }
    },
    '.input-group .select-button': {
      'border-width': 0,
      '&:focus': {
        '--tw-ring-offset-shadow': 'var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color)',
        '--tw-ring-shadow': 'var(--tw-ring-inset) 0 0 0 calc(0px + var(--tw-ring-offset-width)) var(--tw-ring-color)',
        'box-shadow': 'var(--tw-ring-offset-shadow), var(--tw-ring-shadow), var(--tw-shadow, 0 0 #0000)',
      }
    },
    '.input-group .select-option-list': {
      'margin-top': '0.2rem',
      'border-top-left-radius': borderRadius.lg,
      'border-top-right-radius': borderRadius.lg,
    },

    // Input Group - Left Widget
    '.input-group-left': {
      'background-color': '#fff',
      'border-color': theme('colors.gray.300', colors.gray[300]),
      'border-width': borderWidth['DEFAULT'],
      'border-top-left-radius': borderRadius.lg,
      'border-bottom-left-radius': borderRadius.lg,
    },
    '.input-group-left .select-button': {
      'border-bottom-left-radius': borderRadius.lg,
      'border-top-left-radius': borderRadius.lg,
      'border-bottom-right-radius': borderRadius.none,
      'border-top-right-radius': borderRadius.none,
    },
    '.input-group-has-left .form-input': {
      'border-left-width': borderWidth[0],
      'border-top-left-radius': borderRadius.none,
      'border-bottom-left-radius': borderRadius.none,
    },

    // Input Group - Right Widget
    '.input-group-right': {
      'background-color': '#fff',
      'border-color': theme('colors.gray.300', colors.gray[300]),
      'border-width': borderWidth['DEFAULT'],
      'border-top-right-radius': borderRadius.lg,
      'border-bottom-right-radius': borderRadius.lg,
    },
    '.input-group-right .select-button': {
      'border-bottom-left-radius': borderRadius.none,
      'border-top-left-radius': borderRadius.none,
      'border-bottom-right-radius': borderRadius.lg,
      'border-top-right-radius': borderRadius.lg,
    },
    '.input-group-has-right .form-input': {
      'border-right-width': borderWidth[0],
      'border-top-right-radius': borderRadius.none,
      'border-bottom-right-radius': borderRadius.none,
    },
  })
}
