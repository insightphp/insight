const defaultTheme = require('tailwindcss/defaultTheme')
const colors = require('tailwindcss/colors')

const [{ lineHeight: baseLineHeight }] = defaultTheme.fontSize.base
const { spacing, borderWidth, borderRadius } = defaultTheme

module.exports = function (options) {
  const { addComponents, theme } = options

  addComponents({
    ".dp__input_wrap": {
      position: "relative",
      width: "100%",
      // boxSizing: "unset"
    },
    ".dp__input_wrap:focus": {
      borderColor: theme('colors.primary.300', colors.purple[300]),
      // outline: "none"
    },
    ".dp__input": {
      'background-color': '#fff',
      'border-color': theme('colors.gray.300', colors.gray[300]),
      'border-width': borderWidth['DEFAULT'],
      'border-radius': borderRadius.lg,
      color: theme('colors.gray.900', colors.gray[900]),
      'font-size': theme('fontSize.sm', defaultTheme.fontSize.sm),
      'line-height': baseLineHeight,
      'padding-top': spacing[2],
      'padding-right': spacing[3],
      'padding-bottom': spacing[2],
      'padding-left': spacing[3],
      width: '100%',

      // backgroundColor: "var(--dp-background-color)",
      // borderRadius: "4px",
      // border: "1px solid var(--dp-border-color)",
      // outline: "none",
      // transition: "border-color .2s cubic-bezier(0.645, 0.045, 0.355, 1)",
      // fontSize: "1rem",
      // lineHeight: "1.5rem",
      // padding: "6px 12px",
      // color: "var(--dp-text-color)",
      // boxSizing: "border-box"
    },
    ".dp__input::placeholder": {
      color: theme('colors.gray.300', colors.gray[300]),
      opacity: '1',
      // opacity: 0.7
    },
    ".dp__input:hover": {
      // borderColor: "var(--dp-border-color-hover)"
    },
    ".dp__input_reg": {
      // caretColor: "rgba(0, 0, 0, 0)"
    },
    ".dp__input_focus": {
      // borderColor: "var(--dp-border-color-hover)"
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
    ".dp__disabled": {
      // background: "var(--dp-disabled-color)"
      'background-color': theme('colors.gray.50', colors.gray[50]),
      cursor: 'not-allowed',
    },
    ".dp__disabled::placeholder": {
      // color: "var(--dp-disabled-color-text)"
    },
    ".dp__input_icons": {
      display: "inline-block",
      width: "1rem",
      height: "1rem",
      strokeWidth: 0,
      // fontSize: "1rem",
      // lineHeight: "1.5rem",
      // padding: "6px 12px",
      // color: "var(--dp-icon-color)",
      boxSizing: "content-box",

      'font-size': theme('fontSize.sm', defaultTheme.fontSize.sm),
      'line-height': baseLineHeight,
      color: theme('colors.gray.900', colors.gray[900]),

      'padding-top': spacing[2],
      'padding-right': spacing[3],
      'padding-bottom': spacing[2],
      'padding-left': spacing[3],
    },
    ".dp__input_icon": {
      cursor: "pointer",
      position: "absolute",
      top: "50%",
      left: "0",
      transform: "translateY(-50%)",
      // color: "var(--dp-icon-color)"
      color: theme('colors.gray.900', colors.gray[900]),
    },
    ".dp__clear_icon": {
      position: "absolute",
      top: "50%",
      right: "0",
      transform: "translateY(-50%)",
      cursor: "pointer",
      // color: "var(--dp-icon-color)"
      color: theme('colors.gray.900', colors.gray[900]),
    },
    ".dp__input_icon_pad": {
      paddingLeft: "35px"
    },
    ".dp__input_valid": {
      // boxShadow: "0 0 4px var(--dp-success-color)",
      // borderColor: "var(--dp-success-color)"
    },
    ".dp__input_valid:hover": {
      // borderColor: "var(--dp-success-color)"
    },
    ".dp__input_invalid": {
      // TODO: HAS ERROR
      boxShadow: "0 0 4px var(--dp-danger-color)",
      borderColor: "var(--dp-danger-color)"
    },
    ".dp__input_invalid:hover": {
      borderColor: "var(--dp-danger-color)"
    },
    ".dp__menu": {
      overflow: 'hidden',
      position: "absolute",
      // background: "var(--dp-background-color)",
      'background-color': '#fff',
      borderRadius: "4px",
      minWidth: "260px",
      // fontFamily: '-apple-system, blinkmacsystemfont, "Segoe UI", roboto, oxygen, ubuntu, cantarell, "Open Sans", "Helvetica Neue", sans-serif',
      // fontSize: "1rem",
      'font-size': theme('fontSize.sm', defaultTheme.fontSize.sm),
      userSelect: "none",
      // border: "1px solid var(--dp-menu-border-color)",
      // boxSizing: "border-box"
      'border-color': theme('colors.gray.300', colors.gray[300]),
      'border-width': borderWidth['DEFAULT'],
      'border-radius': borderRadius.lg,
      marginTop: '-8px', // Move calendar UP
    },
    // ".dp__menu::after": { boxSizing: "border-box" },
    // ".dp__menu::before": { boxSizing: "border-box" },
    ".dp__menu:focus": {
      // border: "1px solid var(--dp-menu-border-color)",
      // outline: "none"
    },
    ".dp__menu_index": { zIndex: 99999 },
    ".dp__menu_readonly, .dp__menu_disabled": {
      position: "absolute",
      top: "0",
      left: "0",
      right: "0",
      bottom: "0",
      zIndex: 1
    },
    ".dp__menu_disabled": {
      background: "rgba(255, 255, 255, .5)",
      cursor: "not-allowed"
    },
    ".dp__menu_readonly": { background: "rgba(0, 0, 0, 0)", cursor: "default" },
    ".dp__arrow_top": {
      // left: "50%",
      // top: "-1px",
      // height: "12px",
      // width: "12px",
      // backgroundColor: "var(--dp-background-color)",
      // position: "absolute",
      // borderLeft: "1px solid var(--dp-menu-border-color)",
      // borderTop: "1px solid var(--dp-menu-border-color)",
      // transform: "translate(-50%, -50%) rotate(45deg)"
    },
    ".dp__arrow_bottom": {
      // left: "50%",
      // bottom: "-1px",
      // height: "12px",
      // width: "12px",
      // backgroundColor: "var(--dp-background-color)",
      // position: "absolute",
      // borderRight: "1px solid var(--dp-menu-border-color)",
      // borderBottom: "1px solid var(--dp-menu-border-color)",
      // transform: "translate(-50%, 50%) rotate(45deg)"
    },
    ".dp__now_wrap": { textAlign: "center", padding: "2px 0" },
    ".dp__now_button": {
      border: "1px solid var(--dp-primary-color)",
      color: "var(--dp-primary-color)",
      padding: "0 4px",
      fontWeight: "bold",
      borderRadius: "4px",
      fontSize: "1rem",
      cursor: "pointer",
      background: "rgba(0, 0, 0, 0)"
    },
    ".dp__preset_ranges": {
      padding: "5px",
      borderRight: "1px solid var(--dp-border-color)"
    },
    ".dp__preset_range": { padding: "5px" },
    ".dp__preset_range:hover": {
      backgroundColor: "var(--dp-hover-color)",
      cursor: "pointer"
    },
    ".dp__menu_content_wrapper": { display: "flex" },
    ".dp__calendar_wrap": {
      display: "flex",
      justifyContent: "center",
      alignItems: "center",
      flexDirection: "column",
      // fontFamily: '-apple-system, blinkmacsystemfont, "Segoe UI", roboto, oxygen, ubuntu, cantarell, "Open Sans", "Helvetica Neue", sans-serif',
      flex: 0
    },
    ".dp__calendar_header": {
      position: "relative",
      display: "flex",
      justifyContent: "center",
      alignItems: "center",
      // color: "var(--dp-text-color)",
      color: theme('colors.gray.700', colors.gray[700]),
      whiteSpace: "nowrap",
      fontWeight: defaultTheme.fontWeight.medium,
    },
    ".dp__calendar_header_item": {
      textAlign: "center",
      flexGrow: 1,
      height: "35px",
      padding: "5px",
      width: "35px",
      boxSizing: "border-box"
    },
    ".dp__calendar_row": {
      display: "flex",
      justifyContent: "center",
      alignItems: "center",
      margin: "5px 0"
    },
    ".dp__calendar_item": {
      textAlign: "center",
      flexGrow: 1,
      boxSizing: "border-box",
      // color: "var(--dp-text-color)"
      color: theme('colors.gray.700', colors.gray[700]),
    },
    ".dp__calendar": { position: "relative" },
    ".dp__calendar_header_cell": {
      borderBottom: "thin solid var(--dp-border-color)",
      padding: ".5rem"
    },
    ".dp__cell_inner": {
      display: "flex",
      alignItems: "center",
      textAlign: "center",
      justifyContent: "center",
      // borderRadius: "4px",
      // border: "1px solid rgba(0, 0, 0, 0)",
      'border-color': 'transparent',
      'border-width': borderWidth['DEFAULT'],
      'border-radius': borderRadius.lg,
      height: "35px",
      padding: "5px",
      width: "35px",
      boxSizing: "border-box",
      position: "relative"
    },
    ".dp__cell_auto_range_start, .dp__date_hover_start:hover, .dp__range_start": {
      borderBottomRightRadius: "0",
      borderTopRightRadius: "0"
    },
    ".dp__cell_auto_range_end, .dp__date_hover_end:hover, .dp__range_end": {
      borderBottomLeftRadius: "0",
      borderTopLeftRadius: "0"
    },
    ".dp__range_end, .dp__range_start, .dp__active_date": {
      backgroundColor: theme('colors.primary.700', colors.purple[700]),
      color: theme('colors.primary.100', colors.purple[100]),
      // background: "var(--dp-primary-color)",
      // color: "var(--dp-primary-text-color)"
    },
    ".dp__cell_auto_range_end, .dp__cell_auto_range_start": {
      borderTop: "1px dashed var(--dp-primary-color)",
      borderBottom: "1px dashed var(--dp-primary-color)"
    },
    ".dp__date_hover_end:hover, .dp__date_hover_start:hover, .dp__date_hover:hover": {
      // background: "var(--dp-hover-color)",
      backgroundColor: theme('colors.primary.100', colors.purple[100]),
      color: theme('colors.primary.700', colors.purple[700]),
      // color: "var(--dp-hover-text-color)"
    },
    ".dp__cell_offset": {
      // color: "var(--dp-secondary-color)"
      color: theme('colors.gray.400', colors.gray[400]),
    },
    ".dp__cell_disabled": {
      color: "var(--dp-secondary-color)",
      cursor: "not-allowed"
    },
    ".dp__range_between": {
      // background: "var(--dp-hover-color)",
      backgroundColor: theme('colors.primary.100', colors.purple[100]),
      color: theme('colors.primary.900', colors.purple[900]),
      borderRadius: "0",
      borderTop: "1px solid var(--dp-hover-color)",
      borderBottom: "1px solid var(--dp-hover-color)"
    },
    ".dp__range_between_week": {
      background: "var(--dp-primary-color)",
      color: "var(--dp-primary-text-color)",
      borderRadius: "0",
      borderTop: "1px solid var(--dp-primary-color)",
      borderBottom: "1px solid var(--dp-primary-color)"
    },
    ".dp__today": { border: "1px solid var(--dp-primary-color)" },
    ".dp__week_num": { color: "var(--dp-secondary-color)", textAlign: "center" },
    ".dp__cell_auto_range": {
      borderRadius: "0",
      borderTop: "1px dashed var(--dp-primary-color)",
      borderBottom: "1px dashed var(--dp-primary-color)"
    },
    ".dp__cell_auto_range_start": {
      borderLeft: "1px dashed var(--dp-primary-color)"
    },
    ".dp__cell_auto_range_end": {
      borderRight: "1px dashed var(--dp-primary-color)"
    },
    ".dp__calendar_header_separator": {
      width: "100%",
      height: "1px",
      background: "var(--dp-border-color)"
    },
    ".dp__calendar_next": { marginLeft: "10px" },
    ".dp__marker_line, .dp__marker_dot": {
      height: "5px",
      backgroundColor: "var(--dp-marker-color)",
      position: "absolute",
      bottom: "0"
    },
    ".dp__marker_dot": {
      width: "5px",
      borderRadius: "50%",
      left: "50%",
      transform: "translateX(-50%)"
    },
    ".dp__marker_line": { width: "100%", left: "0" },
    ".dp__marker_tooltip": {
      position: "absolute",
      borderRadius: "4px",
      backgroundColor: "var(--dp-tooltip-color)",
      padding: "5px",
      border: "1px solid var(--dp-border-color)",
      zIndex: 99999,
      boxSizing: "border-box",
      cursor: "default"
    },
    ".dp__tooltip_content": { whiteSpace: "nowrap" },
    ".dp__tooltip_text": {
      display: "flex",
      alignItems: "center",
      flexFlow: "row nowrap",
      color: "var(--dp-text-color)"
    },
    ".dp__tooltip_mark": {
      height: "5px",
      width: "5px",
      borderRadius: "50%",
      backgroundColor: "var(--dp-text-color)",
      color: "var(--dp-text-color)",
      marginRight: "5px"
    },
    ".dp__arrow_bottom_tp": {
      left: "50%",
      bottom: "0",
      height: "8px",
      width: "8px",
      backgroundColor: "var(--dp-tooltip-color)",
      position: "absolute",
      borderRight: "1px solid var(--dp-border-color)",
      borderBottom: "1px solid var(--dp-border-color)",
      transform: "translate(-50%, 50%) rotate(45deg)"
    },
    ".dp__instance_calendar": { position: "relative" },
    "@media only screen and (max-width: 600px)": {
      ".dp__flex_display": { flexDirection: "column" }
    },
    ".dp__cell_highlight": { backgroundColor: "var(--dp-highlight-color)" },
    ".dp__month_year_row": {
      display: "flex",
      alignItems: "center",
      height: "35px",
      // color: "var(--dp-text-color)",
      color: theme('colors.primary.700', colors.purple[700]),
      boxSizing: "border-box"
    },
    ".dp__inner_nav": {
      display: "flex",
      alignItems: "center",
      justifyContent: "center",
      cursor: "pointer",
      height: "25px",
      width: "25px",
      // color: "var(--dp-icon-color)",
      color: theme('colors.gray.700', colors.gray[700]),
      textAlign: "center",
      // borderRadius: "50%"
      'border-radius': borderRadius.lg,
      marginLeft: '4px',
      marginRight: '4px',
      transitionTimingFunction: defaultTheme.transitionTimingFunction.DEFAULT,
      transitionProperty: defaultTheme.transitionProperty.colors,
      transitionDuration: defaultTheme.transitionDuration[150],
    },
    ".dp__inner_nav svg": { height: "20px", width: "20px" },
    ".dp__inner_nav:hover": {
      // background: "var(--dp-hover-color)",
      // color: "var(--dp-hover-icon-color)"
      backgroundColor: theme('colors.primary.100', colors.purple[100]),
      color: theme('colors.primary.700', colors.purple[700]),
    },
    ".dp__inner_nav_disabled:hover, .dp__inner_nav_disabled": {
      background: "var(--dp-disabled-color)",
      color: "var(--dp-disabled-color-text)",
      cursor: "not-allowed"
    },
    ".dp__month_year_select": {
      width: "50%",
      textAlign: "center",
      cursor: "pointer",
      height: "35px",
      display: "flex",
      alignItems: "center",
      justifyContent: "center",
      borderRadius: defaultTheme.borderRadius.lg,
      boxSizing: "border-box",
      transitionTimingFunction: defaultTheme.transitionTimingFunction.DEFAULT,
      transitionProperty: defaultTheme.transitionProperty.colors,
      transitionDuration: defaultTheme.transitionDuration[150],
      marginTop: '4px'
    },
    ".dp__month_year_select:hover": {
      // background: "var(--dp-hover-color)",
      // color: "var(--dp-hover-text-color)"
      backgroundColor: theme('colors.primary.100', colors.purple[100]),
      color: theme('colors.primary.800', colors.purple[800]),
    },
    ".dp__overlay": {
      position: "absolute",
      overflowY: "auto",
      width: "100%",
      height: "100%",
      background: "var(--dp-background-color)",
      top: "0",
      left: "0",
      transition: "opacity 1s ease-out",
      zIndex: 99999,
      fontFamily:
        '-apple-system, blinkmacsystemfont, "Segoe UI", roboto, oxygen, ubuntu, cantarell, "Open Sans", "Helvetica Neue", sans-serif',
      color: "var(--dp-text-color)",
      boxSizing: "border-box"
    },
    ".dp__overlay::-webkit-scrollbar-track": {
      boxShadow: "var(--dp-scroll-bar-background)",
      backgroundColor: "var(--dp-scroll-bar-background)"
    },
    ".dp__overlay::-webkit-scrollbar": {
      width: "5px",
      backgroundColor: "var(--dp-scroll-bar-background)"
    },
    ".dp__overlay::-webkit-scrollbar-thumb": {
      backgroundColor: "var(--dp-scroll-bar-color)",
      borderRadius: "10px"
    },
    ".dp__overlay:focus": { border: "none", outline: "none" },
    ".dp__container_flex": { display: "flex" },
    ".dp__container_block": { display: "block" },
    ".dp__overlay_container": { height: "100%", flexDirection: "column" },
    ".dp__overlay_row": {
      padding: "0",
      boxSizing: "border-box",
      display: "flex",
      marginLeft: "auto",
      marginRight: "auto",
      flexWrap: "wrap",
      maxWidth: "100%",
      width: "100%",
      alignItems: "center"
    },
    ".dp__overlay_container > .dp__overlay_row": { flex: 1 },
    ".dp__overlay_col": {
      boxSizing: "border-box",
      width: "33%",
      padding: "3px",
      whiteSpace: "nowrap"
    },
    ".dp__overlay_cell_pad": { padding: "10px 0" },
    ".dp__overlay_cell_active": {
      cursor: "pointer",
      borderRadius: "4px",
      textAlign: "center",
      background: "var(--dp-primary-color)",
      color: "var(--dp-primary-text-color)"
    },
    ".dp__overlay_cell": {
      cursor: "pointer",
      borderRadius: "4px",
      textAlign: "center"
    },
    ".dp__overlay_cell:hover": {
      // background: "var(--dp-hover-color)",
      // color: "var(--dp-hover-text-color)"
      color: theme('colors.primary.700', colors.gray[700]),
      backgroundColor: theme('colors.primary.50', colors.gray[50]),
    },
    ".dp__cell_in_between": {
      // background: "var(--dp-hover-color)",
      // color: "var(--dp-hover-text-color)"
      color: theme('colors.primary.700', colors.gray[700]),
      backgroundColor: theme('colors.primary.100', colors.gray[100]),
    },
    ".dp__overlay_action": {
      position: "sticky",
      bottom: "0",
      background: "#fff"
    },
    ".dp__over_action_scroll": { right: "5px", boxSizing: "border-box" },
    ".dp__overlay_cell_disabled": {
      cursor: "not-allowed",
      background: "var(--dp-disabled-color)"
    },
    ".dp__overlay_cell_disabled:hover": {
      background: "var(--dp-disabled-color)"
    },
    ".dp__overlay_cell_active_disabled": {
      cursor: "not-allowed",
      background: "var(--dp-primary-disabled-color)"
    },
    ".dp__overlay_cell_active_disabled:hover": {
      background: "var(--dp-primary-disabled-color)"
    },
    ".dp__month_picker_header": {
      display: "flex",
      width: "100%",
      alignItems: "center",
      justifyContent: "space-between",
      height: "35px"
    },
    ".dp__time_input": {
      width: "100%",
      display: "flex",
      alignItems: "center",
      justifyContent: "center",
      userSelect: "none",
      fontFamily:
        '-apple-system, blinkmacsystemfont, "Segoe UI", roboto, oxygen, ubuntu, cantarell, "Open Sans", "Helvetica Neue", sans-serif',
      color: "var(--dp-text-color)"
    },
    ".dp__time_col_reg": { padding: "0 20px" },
    ".dp__time_col_reg_with_button": { padding: "0 15px" },
    ".dp__time_col_sec": { padding: "0 10px" },
    ".dp__time_col_sec_with_button": { padding: "0 5px" },
    ".dp__time_col": {
      fontSize: "2rem",
      textAlign: "center",
      display: "flex",
      alignItems: "center",
      justifyContent: "center",
      flexDirection: "column"
    },
    ".dp__time_display": {
      cursor: "pointer",
      color: "var(--dp-text-color)",
      borderRadius: "4px",
      display: "flex",
      alignItems: "center",
      justifyContent: "center",
      padding: "0 3px"
    },
    ".dp__time_display:hover": {
      background: "var(--dp-hover-color)",
      color: "var(--dp-hover-text-color)"
    },
    ".dp__inc_dec_button": {
      padding: "5px",
      margin: "0",
      height: "32px",
      width: "32px",
      display: "flex",
      alignItems: "center",
      justifyContent: "center",
      cursor: "pointer",
      // borderRadius: "50%",
      // color: "var(--dp-icon-color)",
      // boxSizing: "border-box"
      color: theme('colors.primary.700', colors.gray[700]),
      borderRadius: defaultTheme.borderRadius.lg,
      transitionTimingFunction: defaultTheme.transitionTimingFunction.DEFAULT,
      transitionProperty: defaultTheme.transitionProperty.colors,
      transitionDuration: defaultTheme.transitionDuration[150],
    },
    ".dp__inc_dec_button svg": { height: "32px", width: "32px" },
    ".dp__inc_dec_button:hover": {
      // background: "var(--dp-hover-color)",
      // color: "var(--dp-primary-color)"
      color: theme('colors.primary.800', colors.gray[800]),
      backgroundColor: theme('colors.primary.100', colors.gray[100]),
    },
    ".dp__pm_am_button": {
      background: "var(--dp-primary-color)",
      color: "var(--dp-primary-text-color)",
      border: "none",
      padding: "10px",
      borderRadius: "4px",
      cursor: "pointer"
    },
    ".dp__action_row": {
      display: "flex",
      alignItems: "center",
      width: "100%",
      padding: "10px",
      boxSizing: "border-box",
      color: "var(--dp-text-color)",
      background: "var(--dp-background-color)",

      'border-color': 'transparent',
      'border-width': borderWidth['DEFAULT'],
      'border-bottom-left-radius': borderRadius.lg,
      'border-bottom-right-radius': borderRadius.lg,
    },
    ".dp__action_row svg": { height: "20px", width: "auto" },
    ".dp__selection_preview": {
      width: "50%",
      // color: "var(--dp-text-color)",
      color: theme('colors.gray.700', colors.gray[700]),
      fontSize: ".8rem"
    },
    ".dp__action_buttons": { width: "50%", textAlign: "right" },
    ".dp__action": {
      fontWeight: defaultTheme.fontWeight.medium,
      fontSize: theme('fontSize.sm', defaultTheme.fontSize.sm),
      transitionTimingFunction: defaultTheme.transitionTimingFunction.DEFAULT,
      transitionProperty: defaultTheme.transitionProperty.colors,
      transitionDuration: defaultTheme.transitionDuration[150],
      cursor: "pointer",
      padding: "2px 5px",
      borderRadius: "4px",
      display: "inline-flex",
      alignItems: "center"
    },
    ".dp__select": {
      // color: "var(--dp-success-color)"
      color: theme('colors.primary.600', colors.purple[600]),
      '&:hover': {
        color: theme('colors.primary.900', colors.purple[900]),
      }
    },
    ".dp__action_disabled": {
      // color: "var(--dp-success-color-disabled)",
      color: theme('colors.primary.400', colors.purple[400]),
      cursor: "not-allowed"
    },
    ".dp__cancel": {
      // color: "var(--dp-secondary-color)"
      color: theme('colors.gray.400', colors.gray[400]),
      '&:hover': {
        color: theme('colors.gray.600', colors.gray[600]),
      }
    },
    ".dp__theme_dark": {
      "--dp-background-color": "#212121",
      "--dp-text-color": "#fff",
      "--dp-hover-color": "#484848",
      "--dp-hover-text-color": "#fff",
      "--dp-hover-icon-color": "#959595",
      "--dp-primary-color": theme('colors.primary.700', colors.purple[700]),
      "--dp-primary-disabled-color": "#61a8ea",
      "--dp-primary-text-color": "#fff",
      "--dp-secondary-color": "#a9a9a9",
      "--dp-border-color": "#2d2d2d",
      "--dp-menu-border-color": "#2d2d2d",
      "--dp-border-color-hover": "#aaaeb7",
      "--dp-disabled-color": "#737373",
      "--dp-disabled-color-text": "#d0d0d0",
      "--dp-scroll-bar-background": "#212121",
      "--dp-scroll-bar-color": "#484848",
      "--dp-success-color": "#00701a",
      "--dp-success-color-disabled": "#428f59",
      "--dp-icon-color": "#959595",
      "--dp-danger-color": "#e53935",
      "--dp-marker-color": "#e53935",
      "--dp-tooltip-color": "#3e3e3e",
      "--dp-highlight-color": "rgb(0 92 178 / 20%)"
    },
    ".dp__theme_light": {
      "--dp-background-color": "#fff",
      "--dp-text-color": "#212121",
      "--dp-hover-color": "#f3f3f3",
      "--dp-hover-text-color": "#212121",
      "--dp-hover-icon-color": "#959595",
      "--dp-primary-color": theme('colors.primary.700', colors.purple[700]),
      "--dp-primary-disabled-color": "#6bacea",
      "--dp-primary-text-color": "#f8f5f5",
      "--dp-secondary-color": "#c0c4cc",
      "--dp-border-color": "#ddd",
      "--dp-menu-border-color": "#ddd",
      "--dp-border-color-hover": "#aaaeb7",
      "--dp-disabled-color": "#f6f6f6",
      "--dp-scroll-bar-background": "#f3f3f3",
      "--dp-scroll-bar-color": "#959595",
      "--dp-success-color": "#76d275",
      "--dp-success-color-disabled": "#a3d9b1",
      "--dp-icon-color": "#959595",
      "--dp-danger-color": "#ff6f60",
      "--dp-marker-color": "#ff6f60",
      "--dp-tooltip-color": "#fafafa",
      "--dp-disabled-color-text": "#8e8e8e",
      "--dp-highlight-color": "rgb(25 118 210 / 10%)"
    },
    ".dp__main": {
      fontFamily:
        '-apple-system, blinkmacsystemfont, "Segoe UI", roboto, oxygen, ubuntu, cantarell, "Open Sans", "Helvetica Neue", sans-serif',
      userSelect: "none",
      boxSizing: "border-box"
    },
    ".dp__pointer": { cursor: "pointer" },
    ".dp__icon": { stroke: "currentcolor", fill: "currentcolor" },
    ".dp__button": {
      width: "100%",
      textAlign: "center",
      color: theme('colors.primary.700', colors.gray[700]),
      backgroundColor: theme('colors.primary.50', colors.gray[50]),
      transitionTimingFunction: defaultTheme.transitionTimingFunction.DEFAULT,
      transitionProperty: defaultTheme.transitionProperty.colors,
      transitionDuration: defaultTheme.transitionDuration[150],
      // color: "var(--dp-icon-color)",
      // background: "var(--dp-background-color)",
      cursor: "pointer",
      display: "flex",
      alignItems: "center",
      alignContent: "center",
      justifyContent: "center",
      padding: "10px",
      boxSizing: "border-box",
      height: "35px"
    },
    ".dp__button:hover": {
      // background: "var(--dp-hover-color)",
      // color: "var(--dp-hover-icon-color)"
      color: theme('colors.primary.700', colors.gray[700]),
      backgroundColor: theme('colors.primary.100', colors.gray[100]),
    },
    ".dp__button svg": { height: "20px", width: "auto" },
    ".dp__button_bottom": {
      borderBottomLeftRadius: "4px",
      borderBottomRightRadius: "4px"
    },
    ".dp__flex_display": { display: "flex" },
    ".dp__flex_display_with_input": {
      flexDirection: "column",
      alignItems: "start"
    },
    ".dp__relative": { position: "relative" },
    ".calendar-next-enter-active, .calendar-next-leave-active, .calendar-prev-enter-active, .calendar-prev-leave-active": {
      transition: "all .1s ease-out"
    },
    ".calendar-next-enter-from": { opacity: 0, transform: "translateX(22px)" },
    ".calendar-next-leave-to": { opacity: 0, transform: "translateX(-22px)" },
    ".calendar-prev-enter-from": { opacity: 0, transform: "translateX(-22px)" },
    ".calendar-prev-leave-to": { opacity: 0, transform: "translateX(22px)" },
    ".dp-menu-appear-enter-active, .dp-menu-appear-leave-active, .dp-slide-up-enter-active, .dp-slide-up-leave-active, .dp-slide-down-enter-active, .dp-slide-down-leave-active": {
      transition: "all .1s ease-out"
    },
    ".dp-slide-down-leave-to, .dp-slide-up-enter-from": {
      opacity: 0,
      transform: "translateY(22px)"
    },
    ".dp-slide-down-enter-from, .dp-slide-up-leave-to": {
      opacity: 0,
      transform: "translateY(-22px)"
    },
    ".dp-menu-appear-enter-from": { opacity: 0 },
    ".dp-menu-appear-leave-to": { opacity: 1 }
  })

}
