import intlTelInput from "intl-tel-input";
import "intl-tel-input/build/css/intlTelInput.css";
import utilsUrl from "intl-tel-input/build/js/utils.js?url";
import Cleave from "cleave.js";

export function initPhoneInput() {
    const input = document.querySelector<HTMLInputElement>("#phone");
    if (!input) return;

    // intl-tel-input для проверки номера
    const iti = intlTelInput(input, {
        initialCountry: "kg",
        separateDialCode: false, // показываем только национальный номер
        nationalMode: true,
        utilsScript: utilsUrl,
    } as any);

    // Очистка старого Cleave
    if ((input as any).cleave) {
        (input as any).cleave.destroy();
    }

    // Cleave.js маска для KG: (XXX) XX-XX-XX
    (input as any).cleave = new Cleave(input, {
        delimiters: ['(', ') ', '-', '-'],
        blocks: [0, 3, 2, 2, 2], // блок 0 нужен для (
        numericOnly: true
    });

    const errorEl = document.querySelector<HTMLParagraphElement>("#phone-error");

    // Валидация при потере фокуса
    input.addEventListener("blur", () => {
        if (input.value.trim() && !iti.isValidNumber()) {
            input.classList.add("border-red-500");
            input.classList.remove("border-gray-200");
            if (errorEl) errorEl.textContent = "Неверный номер телефона";
        } else {
            input.classList.remove("border-red-500");
            input.classList.add("border-gray-200");
            if (errorEl) errorEl.textContent = "";
        }
    });

    // Перед отправкой формы конвертируем в международный формат
    if (input.form) {
        input.form.addEventListener("submit", (e) => {
            if (!iti.isValidNumber()) {
                e.preventDefault();
                input.classList.add("border-red-500");
                if (errorEl) errorEl.textContent = "Неверный номер телефона";
                return false;
            }
            input.value = iti.getNumber(); // +996700123456
        });
    }
}
