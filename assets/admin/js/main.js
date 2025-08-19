document.addEventListener('DOMContentLoaded', function () {
    // تنظیمات SMS
    const smsCheckbox = document.querySelector('input[name="sms_enabled"]');
    const smsFormSection = document.querySelector('#sms-form-section');
    if (smsCheckbox && smsFormSection) {
        smsCheckbox.addEventListener('change', () => {
            smsFormSection.style.display = smsCheckbox.checked ? 'block' : 'none';
        });
        smsFormSection.style.display = smsCheckbox.checked ? 'block' : 'none';
    }
});