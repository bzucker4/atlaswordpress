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
- **Phase 2 (what's already implemented)**: the newsletter AJAX endpoint
  (`class-newsletter.php`) verifies a nonce via `check_ajax_referer()` and validates the email with
  `is_email()` before ever calling MailerLite; the MailerLite API key is stored in the options
  table via the Settings API (`class-settings.php`), never in code. The Beacons importer
  (`class-beacons-importer.php`) requires `manage_woocommerce`, verifies a nonce, and imports every
  product as a **draft** — nothing it creates goes live without a human reviewing it first. The
  bundle meta box (`class-bundles.php`) verifies a nonce and `edit_product` capability before
  saving, and validates every component product ID actually resolves to a `product` post before
  storing it.
- **Phase 3 (real customer data, migration)**: real customer/order data is only imported after a
  dry run and explicit approval (see `docs/testing.md`). Exported migration files containing PII
  are never committed to the repository and are deleted from any local/staging environment once
  the migration is verified. Newsletter consent status must be preserved exactly during migration
  — this is a legal requirement (CAN-SPAM / GDPR-style consent), not just a UX nicety.
- **Phase 3 (what's already implemented)**:
  - **Migration is two-step by design** (`class-migration.php`): a dry run only ever validates and
    caches to disk; committing requires the *exact* token from that dry run plus an explicit
    confirmation checkbox, verified with a fresh nonce per token (so a token can't be replayed
    against a different confirmation). The commit handler deletes the cache file before doing any
    writes, so the same dry run can never be committed twice. Cached dry-run files (real customer
    PII) live under `wp-content/uploads/atlas-relics-migration/`, are `.htaccess`-denied and
    `index.php`-silenced on creation, and are deleted automatically after 24 hours if never
    committed. **The `.htaccess` file only protects Apache** — a site hosted on Nginx needs an
    equivalent `location` block denying that path; this is called out in `docs/testing.md` and
    `docs/launch.md` so it isn't missed during launch.
  - **Migration never calls the MailerLite API.** Newsletter consent from an imported customer is
    stored as user meta only (`_atlas_relics_newsletter_consent`) — the importer cannot
    (re-)subscribe anyone. Only the customer's own action, through the newsletter signup form,
    triggers a MailerLite subscribe call.
  - **The Tally webhook** (`class-tally.php`) verifies an HMAC-SHA256 signature
    (`hash_equals()` against a secret stored in Settings) before any payload is processed, and
    rejects the request with 401 if the signature is missing or doesn't match — it does not trust
    an unauthenticated POST to a guessable REST URL.
  - **A submission that can't be matched** to a fulfillment record (bad/missing hidden field, or
    an email that doesn't match the order) is logged, not silently dropped, and triggers an admin
    email so a human reconciles it — see `log_unmatched_submission()` in `class-fulfillment.php`.
