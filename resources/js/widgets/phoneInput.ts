import intlTelInput from "intl-tel-input";
import Cleave from "cleave.js";

export function initPhoneInput() {
    const input = document.querySelector<HTMLInputElement>("#phone");
    if (!input) return;

    // путь к utils.js в public
    const utilsUrl = "/js/utils.js";

    // --- intl-tel-input ---
    const iti = intlTelInput(input, {
        initialCountry: "kg",
        separateDialCode: true,
        nationalMode: false,
        utilsScript: utilsUrl, // ⚡ теперь подгружается всегда
        autoHideDialCode: false,
        onlyCountries: ["kg", "ru", "kz"],
        formatOnDisplay: true,
    } as any);

    // --- Cleave.js ---
    if ((input as any).cleave) (input as any).cleave.destroy();
    (input as any).cleave = new Cleave(input, {
        delimiters: ["(", ") ", "-", "-"],
        blocks: [0, 3, 2, 2, 2],
        numericOnly: true,
    });

    // --- Элемент для ошибок ---
    const errorEl = document.querySelector<HTMLParagraphElement>("#phone-error") 
        ?? (() => {
            const el = document.createElement("p");
            el.id = "phone-error";
            el.className = "mt-1 text-sm text-red-500";
            input.parentNode?.appendChild(el);
            return el;
        })();

    // --- Проверка при потере фокуса ---
    input.addEventListener("blur", () => {
        if (input.value && !iti.isValidNumber()) {
            input.classList.add("border-red-500");
            input.classList.remove("border-gray-200");
            errorEl.textContent = "Неверный номер телефона";
        } else {
            input.classList.remove("border-red-500");
            input.classList.add("border-gray-200");
            errorEl.textContent = "";
        }
    });

    // --- Перед отправкой формы ---
    if (input.form) {
        input.form.addEventListener("submit", (e) => {
            if (!iti.isValidNumber()) {
                e.preventDefault();
                input.classList.add("border-red-500");
                errorEl.textContent = "Неверный номер телефона";
                return false;
            }
            input.value = iti.getNumber(); // отправка в формате E.164 для Fortify
        });
    }
}
