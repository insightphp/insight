import type { FormModel } from "../contracts";
import { useForm as useInertiaForm } from '@inertiajs/inertia-vue3'
import type { InertiaForm } from '@inertiajs/inertia-vue3'
import type { VisitOptions } from "@inertiajs/inertia";

export interface FormHandler {
  form: InertiaForm<any>
  formModel: FormModel
}

export interface UseFormHandler {
  submit: () => void
  form: FormHandler
}

export function useForm(form: FormModel, options?: Partial<VisitOptions>): UseFormHandler {
  const inertiaForm = useInertiaForm(form.initialValue)

  const submit = () => {
    if (form.method && form.action) {
      inertiaForm.submit(form.method, form.action, options)
    }
  }

  return {
    submit,
    form: {
      form: inertiaForm,
      formModel: form
    }
  }
}

