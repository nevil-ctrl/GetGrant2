import intlTelInput from "intl-tel-input";
import "intl-tel-input/build/css/intlTelInput.css";
import utilsUrl from "intl-tel-input/build/js/utils.js?url";
import Cleave from "cleave.js";

export function initPhoneInput() {
    const input = document.querySelector<HTMLInputElement>("#phone");
    if (!input) return;

    // intl-tel-input
    const iti = intlTelInput(input, {
        initialCountry: "kg",
        separateDialCode: false,
        nationalMode: true,
        utilsScript: utilsUrl,
    } as any);

    // Cleave.js
    if ((input as any).cleave) (input as any).cleave.destroy();
    (input as any).cleave = new Cleave(input, {
        delimiters: ['(', ') ', '-', '-'],
        blocks: [0, 3, 2, 2, 2],
        numericOnly: true
    });

    // Элемент для ошибки
    let errorEl = document.querySelector<HTMLParagraphElement>("#phone-error");
    if (!errorEl) {
        errorEl = document.createElement("p");
        errorEl.id = "phone-error";
        errorEl.className = "mt-1 text-sm text-red-500";
        input.parentNode?.appendChild(errorEl);
    }

    // Проверка при потере фокуса
    input.addEventListener("blur", () => {
        // Очищаем input от всех нецифр для проверки
        input.value = input.value.replace(/\D/g, '');
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

    // Перед отправкой формы
    if (input.form) {
        input.form.addEventListener("submit", (e) => {
            input.value = input.value.replace(/\D/g, '');
            if (!iti.isValidNumber()) {
                e.preventDefault();
                input.classList.add("border-red-500");
                errorEl.textContent = "Неверный номер телефона";
                return false;
            }
            input.value = iti.getNumber(); // +996XXXXXXXXX
        });
    }
}
