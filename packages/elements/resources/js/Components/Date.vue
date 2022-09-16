<template>
  <DatePicker
      v-model="internalValue"
      :time-picker="timePickerProp"
      :enable-time-picker="enableTimePickerProp"
      :range="rangeProp"
      :week-picker="weekPickerProp"
      :month-picker="monthPickerProp"
      :year-picker="yearPickerProp"
      :locale="locale"
      text-input
      :enable-seconds="enableSeconds"
      :format="formatDateLabel"
      :partial-range="false"
      :placeholder="placeholder"
      :disabled="disabled"
      class="date-input"
      :class="{ 'has-error': hasError }"
      :month-change-on-scroll="false"
      :clearable="nullable"
      :auto-apply="autoApply"
      :name="name"
      :week-numbers="weekNumbers"
      :select-text="chooseLabel"
      :cancel-text="cancelLabel"
      :month-name-format="longMonthNames ? 'long' : 'short'"
  >
    <template #input-icon>
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="ml-2.5 w-5 h-5">
        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
      </svg>
    </template>

    <!--<template #clear-icon="{ clear }">-->
    <!--  <button @click.prevent="clear">-->
    <!--    <svg class="w-5 h-5 mr-2 mt-1 text-danger-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">-->
    <!--      <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zm-1.72 6.97a.75.75 0 10-1.06 1.06L10.94 12l-1.72 1.72a.75.75 0 101.06 1.06L12 13.06l1.72 1.72a.75.75 0 101.06-1.06L13.06 12l1.72-1.72a.75.75 0 10-1.06-1.06L12 10.94l-1.72-1.72z" clip-rule="evenodd" />-->
    <!--    </svg>-->
    <!--  </button>-->
    <!--</template>-->

    <template #arrow-left>
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
      </svg>
    </template>

    <template #arrow-right>
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
      </svg>
    </template>

    <template #clock-icon>
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
      </svg>
    </template>

    <template #calendar-icon>
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V15zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z" />
      </svg>
    </template>

    <template #arrow-up>
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5" />
      </svg>
    </template>

    <template #arrow-down>
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
      </svg>
    </template>
  </DatePicker>

  <InputError :error="error" />
</template>

<script setup lang="ts">
import { computed, ref, watch } from "vue"
import InputError from "./InputError.vue"
import DatePicker from '@vuepic/vue-datepicker'
import { format, getHours, getMinutes, getMonth, getSeconds, getYear, parse, setHours, setMinutes, setMonth, setSeconds, setYear } from "date-fns";

type Mode = 'date' | 'datetime' | 'time' | 'daterange' | 'datetimerange' | 'timerange' | 'week' | 'month' | 'year' | 'monthrange' | 'yearrange'

type TimeStruct = { hours: number, minutes: number, seconds: number }
type MonthStruct = { month: number, year: number }

const emit = defineEmits(['change', 'update:modelValue'])

const props = withDefaults(defineProps<{
  name?: string
  error?: string
  modelValue?: string|Array<string>|number
  locale: string
  mode: Mode
  enableSeconds?: boolean
  placeholder: string
  disabled?: boolean
  nullable: boolean
  autoApply: boolean
  weekNumbers: boolean
  chooseLabel: string
  cancelLabel: string
  longMonthNames: boolean
}>(), {
  mode: 'date',
  locale: 'en-US',
  placeholder: 'Select date…',
  nullable: true,
  autoApply: true,
  weekNumbers: false,
  chooseLabel: 'Choose',
  cancelLabel: 'Cancel',
  longMonthNames: true
})

const timePickerProp = computed(() => props.mode == 'time' || props.mode == 'timerange' ? true : undefined )
const enableTimePickerProp = computed(() => props.mode == 'date' || props.mode == 'daterange' ? false : undefined ) // mode == 'time' ? undefined : mode == 'datetime'
const rangeProp = computed(() => props.mode == 'monthrange' || props.mode == 'yearrange' || props.mode == 'daterange' || props.mode == 'datetimerange' || props.mode == 'timerange' || undefined)
const weekPickerProp = computed(() => props.mode == 'week' || undefined)
const monthPickerProp = computed(() => props.mode == 'month' || props.mode == 'monthrange' || undefined)
const yearPickerProp = computed(() => props.mode == 'year' || props.mode == 'yearrange' || undefined)

const hasError = computed(() => !!props.error)

const resolveFormattingLabel = (configurations: Record<Mode, string|undefined> ) => {
  return configurations[props.mode]
}

const enableSeconds = computed(() => !!props.enableSeconds)

const formatDateLabel = computed(() => resolveFormattingLabel({
  date: 'dd.MM.yyyy',
  datetime: enableSeconds.value ? 'dd.MM.yyyy HH:mm:ss' : 'dd.MM.yyyy HH:mm',
  daterange: 'dd.MM.yyyy',
  month: undefined,
  time: undefined,
  datetimerange: enableSeconds.value ? 'dd.MM.yyyy HH:mm:ss' : 'dd.MM.yyyy HH:mm',
  monthrange: undefined,
  week: 'dd.MM.yyyy',
  year: undefined,
  timerange: undefined,
  yearrange: undefined,
}))

const resolveFormattingToken = () => {
  const tokens: Record<Mode, string> = {
    date: 'yyyy-MM-dd',
    datetime: enableSeconds.value ? 'yyyy-MM-dd HH:mm:ss' : 'yyyy-MM-dd HH:mm',
    daterange: 'yyyy-MM-dd',
    month: 'yyyy-MM',
    time: enableSeconds.value ? 'HH:mm:ss' : 'HH:mm',
    datetimerange: enableSeconds.value ? 'yyyy-MM-dd HH:mm:ss' : 'yyyy-MM-dd HH:mm',
    monthrange: 'yyyy-MM',
    week: 'yyyy-MM-dd',
    year: '',
    timerange: enableSeconds.value ? 'HH:mm:ss' : 'HH:mm',
    yearrange: '',
  }

  return tokens[props.mode]
}

const formatTime = (time: TimeStruct) => {
  let date = new Date()
  date = setHours(date, time.hours)
  date = setMinutes(date, time.minutes)
  date = setSeconds(date, time.seconds)
  return format(date, resolveFormattingToken())
}

const resolveTimeStructFromDateObject = (date: Date) => {
  if (props.enableSeconds) {
    return { hours: getHours(date), minutes: getMinutes(date), seconds: getSeconds(date) }
  } else {
    return { hours: getHours(date), minutes: getMinutes(date), seconds: 0 }
  }
}

const formatMonth = (month: MonthStruct) => {
  let date = new Date()
  date = setYear(date, month.year)
  date = setMonth(date, month.month)
  return format(date, resolveFormattingToken())
}

const resolveMonthStructFromDateObject = (date: Date) => {
  return { month: getMonth(date), year: getYear(date) }
}

const resolveSelectedValue = (value: null|undefined|number|Date|Array<Date>|TimeStruct|MonthStruct) => {
  if (value === null || value === undefined) {
    return null
  }

  if (typeof value == 'number' || props.mode == 'year') {
    return value
  } else if (value instanceof Date) {
    return format(value, resolveFormattingToken())
  } else if (Array.isArray(value)) {
    return value.map(it => {
      if (typeof it == 'number' && props.mode == 'yearrange') {
        return it
      } else if (it instanceof Date) {
        return format(it, resolveFormattingToken())
      } else if (props.mode == 'timerange') {
        return formatTime(it as any)
      } else if (props.mode == 'monthrange') {
        return formatMonth(it as any)
      } else {
        return null
      }
    })
  } else if (typeof value == 'object') {
    if (props.mode == 'time') {
      return formatTime(value as TimeStruct)
    }

    if (props.mode == 'month') {
      return formatMonth(value as MonthStruct)
    }
  }

  throw new Error("The format of the value could not be resolved.")
}

const resolveInternalValue = (value: null|undefined|string|number|Array<string>) => {
  if (value === null || value === undefined) {
    return null
  }

  if (typeof value == 'number') {
    if (props.mode == 'year') {
      return value
    }
  } else if (typeof value == 'string') {
    if (props.mode == 'date') {
      return parse(value, 'yyyy-MM-dd', new Date())
    } else if (props.mode == 'datetime') {
      return parse(value, props.enableSeconds ? 'yyyy-MM-dd HH:mm:ss' : 'yyyy-MM-dd HH:mm' , new Date())
    } else if (props.mode == 'time') {
      return resolveTimeStructFromDateObject(parse(value, props.enableSeconds ? 'HH:mm:ss' : 'HH:mm', new Date()))
    } else if (props.mode == 'month') {
      return resolveMonthStructFromDateObject(parse(value, 'yyyy-MM', new Date()))
    }
  } else if (Array.isArray(value) && value.length == 2) {
    return value.map(it => {
      if (props.mode == 'daterange') {
        return parse(it, 'yyyy-MM-dd', new Date())
      } else if (props.mode == 'datetimerange') {
        return parse(it, props.enableSeconds ? 'yyyy-MM-dd HH:mm:ss' : 'yyyy-MM-dd HH:mm', new Date())
      } else if (props.mode == 'timerange') {
        return resolveTimeStructFromDateObject(parse(it, props.enableSeconds ? 'HH:mm:ss' : 'HH:mm', new Date()))
      } else if (props.mode == 'week') {
        return parse(it, 'yyyy-MM-dd', new Date())
      } else if (props.mode == 'monthrange') {
        return resolveMonthStructFromDateObject(parse(it, 'yyyy-MM', new Date()))
      } else if (typeof it == 'number' && props.mode == 'yearrange') {
        return it
      }
    })
  }

  throw new Error("The v-model value is invalid.")
}

const internalValue = ref<any>(resolveInternalValue(props.modelValue))

watch(internalValue, value => {
  emit('change', resolveSelectedValue(value as any))
  emit('update:modelValue', resolveSelectedValue(value as any))
})

watch(props, newProps => {
  if (JSON.stringify(resolveInternalValue(newProps.modelValue)) != JSON.stringify(internalValue.value)) {
    internalValue.value = resolveInternalValue(props.modelValue)
  }
})
</script>
