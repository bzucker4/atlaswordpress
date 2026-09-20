# Testing

Atlas Relics does not have automated end-to-end tests yet (Phase 2 introduces WooCommerce flows
worth automating). Until then, every phase ships against the manual checklists below, plus the
automated lint check that does exist.

## Automated checks (all phases)

- `npm run lint:php` — PHP_CodeSniffer against the WordPress Coding Standards ruleset
  (`phpcs.xml.dist`). Must pass with zero errors before merging.
- `wp-env` boot — the environment in `.wp-env.json` must start clean (`npm run env:start`) with
  no PHP fatal errors or warnings in the debug log (`WP_DEBUG_LOG` is on by default). wp-env
  installs the theme but does not activate it, so after `npx wp-env start` run
  `npx wp-env run cli wp theme activate atlas-relics` (or `npm run env:start`, then
  `npm run env:cli -- theme activate atlas-relics`).

## Phase 1 — Foundation checklist

- [ ] `npm run env:start` boots WordPress with no fatal errors.
- [ ] Theme activates cleanly: `npm run env:cli -- theme activate atlas-relics`.
- [ ] Plugin activates cleanly: `npm run env:cli -- plugin activate atlas-relics-core`, and
      deactivates/reactivates without errors.
- [ ] Site Editor loads the theme's global styles; the color picker for text/background is
      limited to the eight palette tokens (confirms `theme.json` `custom: false` is respected).
- [ ] Every template renders without a PHP notice/warning: front page, a standard page, a post
      (`single`), the post archive, search results, and a deliberately-invalid URL (`404`).
- [ ] Header and footer navigation menus can be assigned (Appearance → Menus → Primary/Footer)
      and render on the front end.
- [ ] `docs/security.md` hardening is observably active: response headers include
      `X-Content-Type-Options`, `X-Frame-Options`, and `Referrer-Policy`; `/?author=1` redirects
      instead of resolving a username; `/wp-json/wp/v2/users` is not publicly listed while logged
      out.
- [ ] Lighthouse or browser dev tools show no console errors on any Phase 1 template.
- [ ] Responsive check at mobile (375px), tablet (768px), and desktop (1280px+) widths for the
      front page, a standard page, and the header/footer nav (including the mobile nav overlay).

## Phase 2 — Storefront checklist

Requires WooCommerce active before `atlas-relics-core` can activate, since Phase 2 added
`Requires Plugins: woocommerce`. `.wp-env.json` already lists WooCommerce as a mapped plugin, so
`npm run env:start` installs it automatically.

- [ ] WooCommerce activates cleanly on `npm run env:start` (or
      `npm run env:cli -- plugin activate woocommerce` if it didn't auto-activate).
- [ ] Plugin activation creates all seven pages (Home, Start Here, Conscious Mirror, Caves,
      Relics, Pattern Map, Journal, About) exactly once — deactivate/reactivate and confirm no
      duplicates appear (Pages list).
- [ ] Reading settings show a static front page after activation, with Journal as the posts page —
      but only on a fresh site; re-run activation on a site with custom Reading settings and
      confirm they're left untouched.
- [ ] Primary and Footer navigation menus are created and assigned automatically; every link
      resolves (no 404s), including the Shop link once WooCommerce's default pages exist.
- [ ] `templates/single-product.html` and `archive-product.html` render without an "unrecognized
      block" notice in the Site Editor — WooCommerce block names can shift between versions, so
      verify against the WooCommerce version actually installed and adjust the template if needed.
- [ ] WooCommerce's own Cart and Checkout block templates (not forked by this theme — see
      `docs/architecture.md`) pick up the navy/ivory/gold theming from `assets/css/woocommerce.css`
      with no unstyled default WooCommerce elements visible.
- [ ] A full test purchase (test payment gateway) succeeds end-to-end, including a downloadable
      product delivering its file.
- [ ] Bundles: mark a product as a bundle (product edit screen → "Atlas Relics Bundle" box), add it
      to the cart, and confirm the component products appear in the cart at $0, are removed
      together when the bundle line is removed, and each component's stock is decremented after a
      completed order.
- [ ] Related/upsell products on a product page are capped at 3/2 respectively, not a long list.
- [ ] Beacons importer (Tools → Beacons Import): import the sample CSV, confirm products are
      created as **drafts**; re-import the same file and confirm it updates rather than duplicates
      (matched by SKU).
- [ ] MailerLite: fill in an API key and group IDs under Settings → Atlas Relics, submit each of
      the three newsletter forms (homepage/footer, Start Here, Conscious Mirror), and confirm each
      subscriber lands in the correct MailerLite group.
- [ ] `<meta name="description">`, canonical link, and Open Graph tags appear in page source on a
      page, a post, and a product.
- [ ] Skip-to-content link is reachable and functional via keyboard (Tab from page load).
- [ ] Core Web Vitals (LCP, CLS, INP) pass "Good" thresholds on the homepage and a product page.
- [ ] Automated accessibility scan (e.g. axe) has zero critical/serious issues on customer-facing
      pages.

## Phase 3 — Migration & automation checklist

Follow [docs/launch.md](launch.md) for the full backup/staging/cutover/rollback sequence this
checklist fits into. Nothing here should run against production before it's passed in staging.

**Tally webhook (verify first — everything else depends on it working):**

- [ ] The exact webhook payload shape from a real Tally form submission has been logged and
      compared against `Atlas_Relics_Core_Tally::extract_field()` /
      `extract_field_by_type()` (`class-tally.php`) — Tally's schema wasn't something this
      codebase could verify without a live account; confirm field extraction actually finds the
      hidden `fulfillment_id` and the respondent's email, and adjust the extraction methods if not.
- [ ] A request to the webhook URL with a missing or wrong `Tally-Signature` header is rejected
      (401), confirming signature verification is actually active and not silently bypassed.

**Migration tool:**

- [ ] A full migration **dry run** completes against a staging copy with a written reconciliation
      report (counts in vs. counts valid vs. invalid) before any real-data import is approved —
      Tools → Atlas Relics Migration enforces this by design (there is no one-step import).
- [ ] The commit step is refused if the confirmation checkbox isn't ticked, and refused again if
      the same token is submitted a second time (replay protection).
- [ ] Imported customer/order data is spot-checked against the source system for accuracy.
- [ ] Re-running the same dry run + commit a second time updates/skips rather than duplicating
      (customers matched by email, orders matched by `external_order_id`).
- [ ] Newsletter consent/unsubscribe status is preserved exactly — no previously-unsubscribed
      contact receives a new email as a result of migration (confirm by checking that migration
      never calls the MailerLite API — see `commit_customer_row()` in `class-migration.php`).
- [ ] `wp-content/uploads/atlas-relics-migration/` is not reachable directly over HTTP (test both
      Apache `.htaccess` and, if the host uses Nginx, its equivalent config — the `.htaccess` file
      this tool writes has no effect on Nginx).

**Fulfillment automation:**

- [ ] Mark a test product as "Conscious Mirror" or "Pattern Map" fulfillment type, complete a test
      order for it, and confirm: a fulfillment record is created, the customer receives the
      personalized Tally link email, submitting that Tally form fires the webhook, and the record
      updates to "ready to prepare" with an admin notification email.
- [ ] Failure path: submit a Tally webhook with a `fulfillment_id` that doesn't exist, and confirm
      it's logged to "Unmatched Tally submissions" in Atlas Relics Ops with an admin notification,
      rather than failing silently.
- [ ] Reminder cron (`atlas_relics_core_daily_check`) fires and emails customers whose fulfillment
      has been "awaiting response" past the configured reminder window — trigger it manually with
      `npm run env:cli -- cron event run atlas_relics_core_daily_check` rather than waiting a day.
- [ ] "Mark delivered" in Atlas Relics Ops updates the record's status and is protected by a nonce
      + capability check (confirm the link 403s for a non-admin user).

**Beacons file transfer:**

- [ ] Import with "Transfer files to this site" checked and confirm the resulting product's
      download file URL points at this site's `wp-content/uploads/woocommerce_uploads/`, not the
      original Beacons URL.

**Analytics:**

- [ ] The "Atlas Relics Snapshot" widget (wp-admin dashboard and Atlas Relics Ops) shows figures
      that match a manual count for orders, revenue, and fulfillment status.

**General:**

- [ ] Refund and cancellation flows are tested, not just the happy path.
- [ ] Rollback plan has been executed at least once in staging (restore from backup, confirm site
      returns to a known-good state) before go-live.
