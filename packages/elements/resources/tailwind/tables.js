const colors = require("tailwindcss/colors");
const defaultTheme = require("tailwindcss/defaultTheme");

module.exports = function (options) {
  const { addComponents, addBase, theme } = options

  addBase({
    'table.table thead tr th': {
      backgroundColor: theme('colors.gray.50', colors.gray[50]),
      borderWidth: defaultTheme.borderWidth.DEFAULT,
      borderColor: theme(`colors.gray.200`, colors.gray[200]),
      borderTopWidth: defaultTheme.borderWidth.DEFAULT,
      borderBottomWidth: defaultTheme.borderWidth.DEFAULT,
      borderLeftWidth: 0,
      borderRightWidth: 0,
      fontWeight: defaultTheme.fontWeight.medium,
      fontSize: theme('fontSize.xs', defaultTheme.fontSize.xs),
      color: theme(`colors.gray.600`, colors.gray[600]),
      padding: '0.8rem 1rem',
    },
    'table.table tbody tr td': {
      color: theme(`colors.gray.900`, colors.gray[900]),
      fontSize: theme('fontSize.sm', defaultTheme.fontSize.sm),
      padding: '1rem 1rem',
      borderBottomWidth: defaultTheme.borderWidth.DEFAULT,
      borderColor: theme(`colors.gray.200`, colors.gray[200]),
      backgroundColor: theme('colors.white', colors.white),
    },
    'table.table thead tr th.header-row-select': {
      textAlign: 'left',
      paddingRight: 0,
      width: '1rem',
    },
    'table.table tbody tr td.row-select': {
      textAlign: 'left',
      paddingRight: 0,
      width: '1rem',
    },
  })

  addComponents({
    '.data-table table.table': {
      width: '100%',
    },
    '.data-table table.table th': {
      // borderTopWidth: 0,
      '&:first-child': {
        // borderTopLeftRadius: '0.33rem',
      },
      '&:last-child': {
        // borderTopRightRadius: '0.33rem',
      },
    },
    '.data-table table.table tbody tr:last-child td:first-child': {
      borderBottomLeftRadius: '0.33rem'
    },
    '.data-table table.table tbody tr:last-child td:last-child': {
      borderBottomRightRadius: '0.33rem'
    },
    '.data-table table.table tbody tr:last-child td': {
      borderBottomWidth: 0,
    }
  })

}
