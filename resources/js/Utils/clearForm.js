export function clearForm(form, defaultValues = {}) {
    Object.keys(form.value).forEach((key) => {
        form.value[key] = defaultValues[key] || "";
    });
}
