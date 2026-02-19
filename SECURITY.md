# WorodYaar Security Policy / سیاست امنیتی

## Reporting a Vulnerability / گزارش باگ امنیتی
If you discover a security vulnerability in WorodYaar, please report it responsibly by opening an issue on GitHub and labeling it as `security`, or contact the author directly via email: mahdi@example.com.  
اگر یک آسیب‌پذیری امنیتی در WorodYaar پیدا کردید، لطفاً به صورت مسئولانه از طریق باز کردن یک Issue در گیت‌هاب با برچسب `security` یا از طریق ایمیل با نویسنده تماس بگیرید: mahdi@example.com.

## Supported Versions / نسخه‌های پشتیبانی‌شده
- v1.0.0 – Initial release / اولین نسخه رسمی
- Future releases will follow semantic versioning / نسخه‌های بعدی طبق Semantic Versioning خواهند بود.

## Security Considerations / نکات امنیتی
- All user inputs are validated and sanitized. / تمام ورودی‌های کاربران بررسی و پاک‌سازی می‌شوند.
- Nonces are used to prevent CSRF attacks. / از Nonce برای جلوگیری از حملات CSRF استفاده می‌شود.
- Prepared statements and WordPress APIs are used to prevent SQL injection. / برای جلوگیری از SQL Injection از Prepared Statements و APIهای وردپرس استفاده می‌شود.
- Passwords and sensitive data are never stored in plain text. / رمز عبور و اطلاعات حساس هیچگاه به صورت متن ساده ذخیره نمی‌شوند.

## Reporting Timeline / زمان‌بندی پاسخ
- Security reports will be acknowledged within 48 hours / گزارش‌های امنیتی طی ۴۸ ساعت تأیید خواهند شد.
- Critical issues will be prioritized for hotfixes / مشکلات حیاتی در اولویت رفع سریع قرار می‌گیرند.
