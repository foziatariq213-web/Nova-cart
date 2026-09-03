# Nova Cart — Stripe Payment Integration

Learning project (C:\learning) wale pattern par banaya gaya hai: **PaymentIntent + Stripe Payment Element + Webhook**. Theme bilkul wahi hai (dark indigo NovaCart style) — koi design change nahi.

---

## Flow kaise chalta hai

1. **Checkout page** → customer "Credit / Debit Card" select karta hai (fake card inputs hata diye gaye hain — ab wahan sirf ek note hai ke Stripe page par redirect hoga).
2. **Place Order** → order ban jata hai `payment_status = Unpaid` ke sath, cart clear, aur browser `/checkout/pay/{order}` par chala jata hai.
3. **Stripe payment page** (`stripe-pay.blade.php`) → NovaCart ki dark theme mein Stripe Payment Element. Card details **sirf Stripe handle karta hai** — hamare server ko kabhi nahi milti.
4. **Payment ke baad** → Stripe browser ko `/checkout/stripe/return` par wapas bhejta hai. Wahan server-side verify hota hai (secret key se intent retrieve) aur My Orders par success/error message ke sath redirect.
5. **Webhook** (`POST /stripe/webhook`) → Stripe ke server se aata hai, signature verify hoti hai, `payments` table mein record ban jata hai aur order `Paid` mark hota hai. **Webhook hi source of truth hai** — return page sirf fauri sync ke liye hai (dono idempotent hain, double record nahi banta).

COD, JazzCash, EasyPaisa ka flow bilkul pehle jaisa hai — unko haath nahi lagaya.

---

## Nayi / badli hui files

**Nayi:**
- `app/Http/Controllers/StripePaymentController.php` — pay page + return handler
- `app/Http/Controllers/StripeWebhookController.php` — webhook (signature verification)
- `app/Services/StripePaymentService.php` — intent create/reuse + payment record (shared logic)
- `app/Models/Payment.php`
- `resources/views/frontend/stripe-pay.blade.php` — payment page (NovaCart theme)
- `database/migrations/2026_09_03_180000_create_payments_table.php`
- `database/migrations/2026_09_03_180100_add_stripe_payment_intent_id_to_orders_table.php`
- `tests/Feature/StripeWebhookTest.php`

**Badli hui:**
- `routes/web.php` — webhook route, pay/return routes, checkout closure mein card branch
- `resources/views/frontend/checkout.blade.php` — fake card inputs → Stripe note; AJAX redirect
- `resources/views/frontend/orders.blade.php` + `order-details.blade.php` — card orders ab DB ka **asli** payment status dikhate hain (pehle hamesha "Paid" dikhta tha)
- `app/Models/Order.php` — `payments()` relation, label fix
- `bootstrap/app.php` — webhook CSRF exclusion (Laravel 12 style)
- `config/services.php` — stripe block
- `.env` — Stripe test keys (learning project wali, same account) + `STRIPE_CURRENCY=pkr`

---

## Test kaise karein

```bash
php artisan serve
```

1. Login karein → koi product cart mein dalein → checkout par jayein.
2. Shipping details bharein → **Credit / Debit Card** select karein → Place Order.
3. Stripe page par ye test card dalein:

| Result | Card Number | Baqi fields |
|---|---|---|
| ✅ Success | `4242 4242 4242 4242` | koi bhi future expiry, koi bhi CVC |
| ❌ Decline | `4000 0000 0000 0002` | same |
| 🔐 3D Secure | `4000 0025 0000 3155` | same |

4. Payment ke baad My Orders par message aayega aur order **Paid** dikhega.
5. Verify: Stripe Dashboard → Test mode → Payments mein entry, aur DB `payments` table mein record.

---

## Webhook locally chalane ke liye (zaroori!)

Return page ki wajah se payment success **webhook ke baghair bhi** dikh jayega, lekin proper flow ke liye Stripe CLI chalayein:

```bash
stripe listen --forward-to http://127.0.0.1:8000/stripe/webhook
```

- CLI jo `whsec_...` print kare, usse `.env` ke `STRIPE_WEBHOOK_SECRET` se compare karein.
- Agar different hai to `.env` mein naya wala dal kar `php artisan config:clear` karein.
- (Learning project wala secret tabhi chalega agar wo bhi isi CLI ke `stripe listen` se aaya tha.)

Test event bhejne ke liye:
```bash
stripe trigger payment_intent.succeeded
```

---

## Notes

- **Keys**: Stripe test keys account-level hoti hain, project-level nahi — isliye learning project wali keys yahan bhi chalti hain. Dono projects ki payments aapke ek hi Stripe test dashboard mein dikheingi.
- **Currency**: `STRIPE_CURRENCY=pkr` rakha hai kyunke NovaCart "Rs" mein prices dikhata hai. Agar Stripe account PKR par error de to `.env` mein `usd` kar dein.
- **Refunds**: cancelled paid orders ka refund flow abhi nahi hai (out of scope) — future improvement.
- **Retry**: agar payment fail ho jaye to user usi pay page par dobara try kar sakta hai; page refresh karne par duplicate intent nahi banta (order par intent id save hoti hai).
