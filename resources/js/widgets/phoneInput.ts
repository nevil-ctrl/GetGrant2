import intlTelInput from "intl-tel-input";
import "intl-tel-input/build/css/intlTelInput.css";
import utilsScript from "intl-tel-input/build/js/utils.js"; // ESM

export function initPhoneInput() {
    const input = document.querySelector<HTMLInputElement>("#phone");
    if (!input) return;

    const iti = intlTelInput(input, {
        // Используем автоопределение страны по IP, чтобы не навязывать KG по умолчанию
        initialCountry: "auto",
        geoIpLookup: (callback: (countryCode: string) => void) => {
            fetch("https://ipapi.co/json/")
                .then((res) => res.json())
                .then((data) => callback((data.country_code || "kg").toLowerCase()))
                .catch(() => callback("kg"));
        },
        separateDialCode: true,
        // Разрешаем ввод национальных номеров в локальном формате, например (700) 12-34-56
        nationalMode: true,
        autoHideDialCode: false,
        // Убрали 'onlyCountries' — теперь пользователь может выбрать любую страну
        formatOnDisplay: true,
        utilsScript, // здесь ESM корректно работает с Vite
    } as any);

    const errorEl =
        document.querySelector<HTMLParagraphElement>("#phone-error") ??
        (() => {
            const el = document.createElement("p");
            el.id = "phone-error";
            el.className = "mt-1 text-sm text-red-500";
            input.parentNode?.appendChild(el);
            return el;
        })();

    // Отладочный блок на странице (для тех, кто не смотрит консоль)
    const debugEl =
        document.querySelector<HTMLDivElement>("#phone-debug") ??
        (() => {
            const el = document.createElement("div");
            el.id = "phone-debug";
            el.className = "mt-2 text-xs text-gray-600 whitespace-pre-line";
            input.parentNode?.appendChild(el);
            return el;
        })();

    function getValidationMessage(code: number | null) {
        // Возвращаем понятное сообщение для кода ошибки, если utils не доступен — падем обратно на общее
        switch (code) {
            case 1:
                return "Неверный код страны";
            case 2:
                return "Слишком короткий номер";
            case 3:
                return "Слишком длинный номер";
            default:
                return "Неверный номер телефона";
        }
    }

    input.addEventListener("blur", () => {
        const isValid = iti.isValidNumber();
        // @ts-ignore — некоторые версии intl-tel-input могут возвращать undefined
        const err = typeof iti.getValidationError === "function" ? iti.getValidationError() : null;

        const sel = iti.getSelectedCountryData();
        const digits = input.value.replace(/\D/g, "");
        const isKgNine = sel && sel.iso2 === "kg" && digits.length === 9;

        // Дополнительная отладка для проблемного номера
        const problematic = input.value && (input.value.replace(/\s|\(|\)|-/g, "").indexOf("559") === 0 || input.value.trim() === "(559) 02-35-13");
        if (problematic) {
            // eslint-disable-next-line no-console
            console.info("[phone-debug] value:", input.value);
            // eslint-disable-next-line no-console
            console.info("[phone-debug] selectedCountry:", sel);
            // eslint-disable-next-line no-console
            console.info("[phone-debug] isValid:", isValid);
            // @ts-ignore
            // eslint-disable-next-line no-console
            console.info("[phone-debug] validationError (instance):", err);
            // eslint-disable-next-line no-console
            console.info("[phone-debug] intl utils validation (if available):", (window as any).intlTelInputUtils?.getValidationError ? (window as any).intlTelInputUtils.getValidationError(0, input.value) : null);
            try {
                // eslint-disable-next-line no-console
                console.info("[phone-debug] getNumber (E.164):", iti.getNumber());
                let nat = null;
                try {
                    // Попытаться получить национальный формат через utils.numberFormat.NATIONAL
                    // @ts-ignore
                    const nf = (window as any).intlTelInputUtils?.numberFormat;
                    if (nf) {
                        // @ts-ignore
                        nat = iti.getNumber(nf.NATIONAL);
                    }
                } catch (e) {
                    // ignore
                }
                // eslint-disable-next-line no-console
                console.info("[phone-debug] getNumber (national):", nat);
            } catch (e) {
                // eslint-disable-next-line no-console
                console.info("[phone-debug] getNumber threw:", e);
            }

            // Пишем результат также в видимый блок на странице
            try {
                const lines = [];
                lines.push("value: " + input.value);
                lines.push("selected: " + JSON.stringify(sel));
                lines.push("isValid: " + String(isValid));
                lines.push("validationError: " + String(err));
                // @ts-ignore
                lines.push("intlUtils: " + (typeof (window as any).intlTelInputUtils?.getValidationError === 'function' ? String((window as any).intlTelInputUtils.getValidationError(0, input.value)) : 'n/a'));
                lines.push("E.164: " + String(iti.getNumber()));
                lines.push("national: " + String(nat));
                debugEl.textContent = lines.join('\n');
            } catch (e) {
                // ignore
            }
        }

        if (input.value && !isValid && !isKgNine) {
            // Стандартная ошибка — помечаем красным
            input.classList.add("border-red-500");
            input.classList.remove("border-yellow-400");
            const suggestion = sel && sel.dialCode ? ` Номер для страны ${sel.name} (+${sel.dialCode}) не верен. Выберите правильную страну или введите номер в международном формате (+...)` : '';
            errorEl.textContent = getValidationMessage(err) + suggestion;
            // Для разработки полезно видеть причину в консоли
            // eslint-disable-next-line no-console
            console.debug("Phone validation failed:", { value: input.value, err, formatted: iti.getNumber(), country: sel });
        } else if (isKgNine) {
            // Для Кыргызстана 9-значные номера принимаем как допустимые, но показываем предупреждение
            input.classList.remove("border-red-500");
            input.classList.add("border-yellow-400");
            errorEl.textContent = "Предупреждение: номер не подтверждён библиотекой, но будет принят";
        } else {
            input.classList.remove("border-red-500");
            input.classList.remove("border-yellow-400");
            errorEl.textContent = "";
        }
    });

    if (input.form) {
        input.form.addEventListener("submit", (e) => {
            const isValid = iti.isValidNumber();
            // @ts-ignore
            const err = typeof iti.getValidationError === "function" ? iti.getValidationError() : null;
            const sel = iti.getSelectedCountryData();

            if (!isValid) {
                // Fallback: если выбранная страна — KG и в поле 9 цифр — позволяем отправить с предупреждением
                const digits = input.value.replace(/\D/g, "");
                const isKgNine = sel && sel.iso2 === "kg" && digits.length === 9;
                if (isKgNine) {
                    // Не блокируем отправку, но показываем предупреждение и помечаем поле
                    input.classList.add("border-yellow-400");
                    input.classList.remove("border-red-500");
                    errorEl.textContent = "Предупреждение: номер не подтверждён библиотекой, будет сохранён как есть";
                    // Добавим скрытое поле, чтобы сервер знал, что номер не валидирован полностью
                    if (!input.form.querySelector("input[name=phone_unvalidated]")) {
                        const hidden = document.createElement("input");
                        hidden.type = "hidden";
                        hidden.name = "phone_unvalidated";
                        hidden.value = "1";
                        input.form.appendChild(hidden);
                    }
                    // Также передадим страну для сервера
                    if (!input.form.querySelector("input[name=phone_country]")) {
                        const h2 = document.createElement("input");
                        h2.type = "hidden";
                        h2.name = "phone_country";
                        h2.value = sel?.iso2 ?? '';
                        input.form.appendChild(h2);
                    }
                    // Сохраняем число в международном формате если возможно, иначе отправляем как есть
                    try {
                        input.value = iti.getNumber() || input.value;
                    } catch (e) {
                        /* ignore */
                    }
                    // eslint-disable-next-line no-console
                    console.debug("Phone fallback accepted on submit:", { value: input.value, err, country: sel });
                    return; // allow submit
                }

                e.preventDefault();
                input.classList.add("border-red-500");
                errorEl.textContent = getValidationMessage(err) + (sel && sel.dialCode ? ` Номер для страны ${sel.name} (+${sel.dialCode}) не верен.` : '');
                // eslint-disable-next-line no-console
                console.debug("Phone validation failed on submit:", { value: input.value, err, formatted: iti.getNumber(), country: sel });
                return;
            }

            // ✅ ВАЖНО: сохраняем в международном формате
            input.value = iti.getNumber(); // +996700123456
            // добавляем страну в скрытое поле для серверной попытки нормализации
            if (!input.form.querySelector("input[name=phone_country]")) {
                const h2 = document.createElement("input");
                h2.type = "hidden";
                h2.name = "phone_country";
                h2.value = sel?.iso2 ?? '';
                input.form.appendChild(h2);
            }
        });
    }
}
// Инициализация при загрузке страницы
document.addEventListener("DOMContentLoaded", () => {
    initPhoneInput();
});