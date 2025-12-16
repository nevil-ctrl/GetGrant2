import intlTelInput from "intl-tel-input";
import "intl-tel-input/build/css/intlTelInput.css";
// Import utils.js as a URL so Vite serves it correctly
import utilsUrl from "intl-tel-input/build/js/utils.js?url";

export function initPhoneInput() {
    const input = document.querySelector<HTMLInputElement>("#phone");
    if (!input) return;

    const options: any = {
        initialCountry: "kg",
        separateDialCode: true,
        nationalMode: false,
        preferredCountries: ["kg", "ru", "kz"],
        // Use Vite-provided URL for utils script
        utilsScript: (utilsUrl as unknown) as string,
    };

    // Support both default and namespace imports depending on bundler
    const create = (intlTelInput as any).default ?? (intlTelInput as any);
    const iti: any = create(input, options);

    if (input.form) {
        input.form.addEventListener("submit", () => {
            input.value = iti.getNumber(); // +996700123456
        });
    }
}
