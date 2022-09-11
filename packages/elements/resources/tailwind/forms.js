const colors = require("tailwindcss/colors");
const defaultTheme = require('tailwindcss/defaultTheme')
const svgToDataUri = require('mini-svg-data-uri')

const [{ lineHeight: baseLineHeight }] = defaultTheme.fontSize.base
const { spacing, borderWidth, borderRadius } = defaultTheme

module.exports = function (addBase, addComponents, theme) {
  const rules = [
    {
      selector: [
        "[type='text']",
        "[type='email']",
        "[type='url']",
        "[type='password']",
        "[type='number']",
        "[type='date']",
        "[type='datetime-local']",
        "[type='month']",
        "[type='search']",
        "[type='tel']",
        "[type='time']",
        "[type='week']",
        '[multiple]',
        'textarea',
        'select',
      ],
      styles: {
        appearance: 'none',
        'background-color': '#fff',
        'border-color': theme('colors.gray.300', colors.gray[300]),
        'border-width': borderWidth['DEFAULT'],
        'border-radius': borderRadius.lg,
        'padding-top': spacing[2],
        'padding-right': spacing[3],
        'padding-bottom': spacing[2],
        'padding-left': spacing[3],
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
        },
      },
    },
    {
      selector: [
        "[type='text'].has-error",
        "[type='email'].has-error",
        "[type='url'].has-error",
        "[type='password'].has-error",
        "[type='number'].has-error",
        "[type='date'].has-error",
        "[type='datetime-local'].has-error",
        "[type='month'].has-error",
        "[type='search'].has-error",
        "[type='tel'].has-error",
        "[type='time'].has-error",
        "[type='week'].has-error",
        '[multiple].has-error',
        'textarea.has-error',
        'select.has-error',
      ],
      styles: {
        borderColor: theme('colors.danger.300', colors.red[300]),
        '&:focus': {
          '--tw-ring-color': theme('colors.danger.100', colors.red[100]),
          borderColor: theme('colors.danger.300', colors.red[300]),
        }
      },
    },
    {
      selector: ['input::placeholder', 'textarea::placeholder'],
      styles: {
        color: theme('colors.gray.300', colors.gray[300]),
        opacity: '1',
      },
    },
    {
      selector: ['::-webkit-datetime-edit-fields-wrapper'],
      styles: {
        padding: '0',
      },
    },
    {
      // Unfortunate hack until https://bugs.webkit.org/show_bug.cgi?id=198959 is fixed.
      // This sucks because users can't change line-height with a utility on date inputs now.
      // Reference: https://github.com/twbs/bootstrap/pull/31993
      selector: ['::-webkit-date-and-time-value'],
      styles: {
        'min-height': '1.5em',
      },
    },
    {
      // In Safari on macOS date time inputs are 4px taller than normal inputs
      // This is because there is extra padding on the datetime-edit and datetime-edit-{part}-field pseudo elements
      // See https://github.com/tailwindlabs/tailwindcss-forms/issues/95
      selector: [
        '::-webkit-datetime-edit',
        '::-webkit-datetime-edit-year-field',
        '::-webkit-datetime-edit-month-field',
        '::-webkit-datetime-edit-day-field',
        '::-webkit-datetime-edit-hour-field',
        '::-webkit-datetime-edit-minute-field',
        '::-webkit-datetime-edit-second-field',
        '::-webkit-datetime-edit-millisecond-field',
        '::-webkit-datetime-edit-meridiem-field',
      ],
      styles: {
        'padding-top': 0,
        'padding-bottom': 0,
      },
    },
    {
      selector: ['select'],
      styles: {
        'background-image': `url("${svgToDataUri(
          `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20"><path stroke="${theme(
            'colors.gray.500',
            colors.gray[500]
          )}" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 8l4 4 4-4"/></svg>`
        )}")`,
        'background-position': `right ${spacing[2]} center`,
        'background-repeat': `no-repeat`,
        'background-size': `1.5em 1.5em`,
        'padding-right': spacing[10],
        'print-color-adjust': `exact`,
      },
    },
    {
      selector: ['[multiple]'],
      styles: {
        'background-image': 'initial',
        'background-position': 'initial',
        'background-repeat': 'unset',
        'background-size': 'initial',
        'padding-right': spacing[3],
        'print-color-adjust': 'unset',
      },
    },
    {
      selector: [`[type='checkbox']`, `[type='radio']`],
      styles: {
        appearance: 'none',
        padding: '0',
        'print-color-adjust': 'exact',
        display: 'inline-block',
        'vertical-align': 'middle',
        'background-origin': 'border-box',
        'user-select': 'none',
        'flex-shrink': '0',
        height: spacing[4],
        width: spacing[4],
        color: theme('colors.blue.600', colors.blue[600]),
        'background-color': '#fff',
        'border-color': theme('colors.gray.300', colors.gray[300]),
        'border-width': borderWidth['DEFAULT'],
        '--tw-shadow': '0 0 #0000',
      },
    },
    {
      selector: [`[type='checkbox']`],
      styles: {
        'border-radius': borderRadius['none'],
      },
    },
    {
      selector: [`[type='radio']`],
      styles: {
        'border-radius': '100%',
      },
    },
    {
      selector: [`[type='checkbox']:focus`, `[type='radio']:focus`],
      styles: {
        outline: '2px solid transparent',
        'outline-offset': '2px',
        '--tw-ring-inset': 'var(--tw-empty,/*!*/ /*!*/)',
        '--tw-ring-offset-width': '2px',
        '--tw-ring-offset-color': '#fff',
        '--tw-ring-color': theme('colors.primary.100', colors.purple[100]),
        '--tw-ring-offset-shadow': `var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color)`,
        '--tw-ring-shadow': `var(--tw-ring-inset) 0 0 0 calc(2px + var(--tw-ring-offset-width)) var(--tw-ring-color)`,
        'box-shadow': `var(--tw-ring-offset-shadow), var(--tw-ring-shadow), var(--tw-shadow)`,
      },
    },
    {
      selector: [`[type='checkbox']:checked`, `[type='radio']:checked`],
      styles: {
        'border-color': `transparent`,
        'background-color': `currentColor`,
        'background-size': `100% 100%`,
        'background-position': `center`,
        'background-repeat': `no-repeat`,
      },
    },
    {
      selector: [`[type='checkbox']:checked`],
      styles: {
        'background-image': `url("${svgToDataUri(
          `<svg viewBox="0 0 16 16" fill="white" xmlns="http://www.w3.org/2000/svg"><path d="M12.207 4.793a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0l-2-2a1 1 0 011.414-1.414L6.5 9.086l4.293-4.293a1 1 0 011.414 0z"/></svg>`
        )}")`,
      },
    },
    {
      selector: [`[type='radio']:checked`],
      styles: {
        'background-image': `url("${svgToDataUri(
          `<svg viewBox="0 0 16 16" fill="white" xmlns="http://www.w3.org/2000/svg"><circle cx="8" cy="8" r="3"/></svg>`
        )}")`,
      },
    },
    {
      selector: [
        `[type='checkbox']:checked:hover`,
        `[type='checkbox']:checked:focus`,
        `[type='radio']:checked:hover`,
        `[type='radio']:checked:focus`,
      ],
      styles: {
        'border-color': 'transparent',
        'background-color': 'currentColor',
      },
    },
    {
      selector: [`[type='checkbox']:indeterminate`],
      styles: {
        'background-image': `url("${svgToDataUri(
          `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 16"><path stroke="white" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h8"/></svg>`
        )}")`,
        'border-color': `transparent`,
        'background-color': `currentColor`,
        'background-size': `100% 100%`,
        'background-position': `center`,
        'background-repeat': `no-repeat`,
      },
    },
    {
      selector: [`[type='checkbox']:indeterminate:hover`, `[type='checkbox']:indeterminate:focus`],
      styles: {
        'border-color': 'transparent',
        'background-color': 'currentColor',
      },
    },
    {
      selector: [`[type='file']`],
      styles: {
        background: 'unset',
        'border-color': 'inherit',
        'border-width': '0',
        'border-radius': '0',
        padding: '0',
        'font-size': 'unset',
        'line-height': 'inherit',
      },
    },
    {
      selector: [`[type='file']:focus`],
      styles: {
        outline: [
          `1px solid ButtonText`,
          `1px auto -webkit-focus-ring-color`
        ],
      },
    },
  ]

  addBase(rules.map((rule) => ({[rule.selector]: rule.styles})))

  // appearance: 'none',
  //   'background-color': '#fff',
  //   'border-color': theme('colors.gray.300', colors.gray[300]),
  //   'border-width': borderWidth['DEFAULT'],
  //   'border-radius': borderRadius.lg,
  //   'padding-top': spacing[2],
  //   'padding-right': spacing[3],
  //   'padding-bottom': spacing[2],
  //   'padding-left': spacing[3],
  //   'font-size': theme('fontSize.sm', defaultTheme.fontSize.sm),
  //   'line-height': baseLineHeight,
  //   '--tw-shadow': '0 0 #0000',
  //   color: theme('colors.gray.900', colors.gray[900]),
  //   '&:focus': {
  //   outline: '2px solid transparent',
  //     'outline-offset': '2px',
  //     '--tw-ring-inset': 'var(--tw-empty,/*!*/ /*!*/)',
  //     '--tw-ring-offset-width': '0px',
  //     '--tw-ring-offset-color': '#fff',
  //     '--tw-ring-color': theme('colors.primary.100', colors.purple[100]),
  //     '--tw-ring-offset-shadow': `var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color)`,
  //     '--tw-ring-shadow': `var(--tw-ring-inset) 0 0 0 calc(4px + var(--tw-ring-offset-width)) var(--tw-ring-color)`,
  //     'box-shadow': `var(--tw-ring-offset-shadow), var(--tw-ring-shadow), var(--tw-shadow)`,
  //     'border-color': theme('colors.primary.300', colors.purple[300]),
  // },

  addComponents({
    '.input-error': {
      fontSize: theme('fontSize.xs', defaultTheme.fontSize.xs),
      color: theme('colors.danger.600', colors.red[600]),
      marginTop: '.2rem',
    },
    '.input-group-left': {
      'background-color': '#fff',
      'border-color': theme('colors.gray.300', colors.gray[300]),
      borderWidth: borderWidth['DEFAULT'],
      'border-radius-left-top': borderRadius.lg,
      'border-radius-left-bottom': borderRadius.lg,
    }
  })
}
