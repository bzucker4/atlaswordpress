# Security rules

These rules apply to every phase. Phase 1's `Atlas_Relics_Core_Security` class
(`wp-content/plugins/atlas-relics-core/includes/class-security.php`) implements the baseline
items below; later phases must extend, not bypass, this baseline.

## Baseline hardening (implemented in Phase 1)

- Version fingerprinting removed from `<head>`, RSS generator tag, and asset query strings.
- `DISALLOW_FILE_EDIT` forced on if not already set in `wp-config.php` — no editing PHP files
  through wp-admin, ever, on any environment including local.
- REST API `/wp/v2/users` collection/single endpoints hidden from unauthenticated requests
  (prevents username enumeration).
- `?author=N` enumeration redirected to the homepage instead of resolving to a username-revealing
  archive URL.
- XML-RPC pingback methods removed (`pingback.ping`, `pingback.extensions.getPingbacks`) and the
  `X-Pingback` header stripped, without disabling XML-RPC entirely (some integrations need it).
- Generic login error message — never reveal whether a failed login had a bad username or a bad
  password.
- Baseline response headers on every front-end request: `X-Content-Type-Options: nosniff`,
  `X-Frame-Options: SAMEORIGIN`, `Referrer-Policy: strict-origin-when-cross-origin`.

## Coding rules (all contributors, all phases)

1. **Escape all output.** Every value echoed into HTML, an attribute, a URL, or JS must go
   through the matching `esc_html()`, `esc_attr()`, `esc_url()`, or `wp_json_encode()` /
   `esc_js()` call at the point of output — not "trusted" because it was sanitized earlier.
2. **Sanitize all input.** Anything from `$_GET`, `$_POST`, `$_REQUEST`, or a REST request must be
   sanitized with the appropriate `sanitize_*()` function before use, and validated against an
   allow-list where the value has a known set of valid options (post status, order status, etc.).
3. **Verify nonces on every state-changing action** (form submission, AJAX handler, REST write
   endpoint) with `wp_verify_nonce()` / `check_admin_referer()` / a REST `permission_callback`.
   Never rely on `is_admin()` or a hidden field alone.
4. **Check capabilities, not roles.** Use `current_user_can( 'manage_woocommerce' )`-style
   capability checks, not `current_user_can( 'administrator' )` role checks, so permissions stay
   correct if custom roles are introduced later.
5. **Use `$wpdb->prepare()`** for every raw SQL query with a variable in it. Prefer WP_Query /
   the WooCommerce CRUD APIs over raw SQL wherever they cover the need.
6. **Never commit secrets.** API keys (MailerLite, Tally, payment gateways) are set via
   environment variables or `wp-config.php` constants that are themselves gitignored — never
   hard-coded in theme/plugin PHP, never in a committed `.env` file. `.gitignore` already excludes
   `.env*` (except `.env.example`).
7. **Prefix everything.** All functions, classes, hooks, option names, and transient keys use the
   `atlas_relics` / `Atlas_Relics` / `ATLAS_RELICS` prefix family (enforced by
   `phpcs.xml.dist`'s `PrefixAllGlobals` rule) to avoid collisions with WordPress core, WooCommerce,
   or other plugins.
8. **Dependencies stay current.** WordPress core, WooCommerce, and any added plugin are kept on
   supported versions; `composer.json` and `package.json` versions are reviewed for known CVEs
   before each phase's merge.

## Phase-specific security notes

- **Phase 2 (payments, downloads, accounts)**: use WooCommerce's own payment-gateway
  infrastructure rather than custom payment handling; never store raw card data. Downloadable
  file URLs must be non-guessable and access-checked, not `wp-content/uploads` direct links.
- **Phase 3 (real customer data, migration)**: real customer/order data is only imported after a
  dry run and explicit approval (see `docs/testing.md`). Exported migration files containing PII
  are never committed to the repository and are deleted from any local/staging environment once
  the migration is verified. Newsletter consent status must be preserved exactly during migration
  — this is a legal requirement (CAN-SPAM / GDPR-style consent), not just a UX nicety.
