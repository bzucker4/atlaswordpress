# Testing

Atlas Relics does not have automated end-to-end tests yet (Phase 2 introduces WooCommerce flows
worth automating). Until then, every phase ships against the manual checklists below, plus the
automated lint check that does exist.

## Automated checks (all phases)

- `npm run lint:php` — PHP_CodeSniffer against the WordPress Coding Standards ruleset
  (`phpcs.xml.dist`). Must pass with zero errors before merging.
- `wp-env` boot — the environment in `.wp-env.json` must start clean (`npm run env:start`) with
  no PHP fatal errors or warnings in the debug log (`WP_DEBUG_LOG` is on by default).

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

## Phase 2 — Storefront checklist (for when that phase starts)

- [ ] WooCommerce shop, single product, cart, and checkout blocks render using the design system
      (no unstyled WooCommerce defaults leaking through).
- [ ] A full test purchase (test payment gateway) succeeds end-to-end, including a downloadable
      product delivering its file.
- [ ] Bundles and related/upsell products display correctly and do not affect cart totals
      incorrectly.
- [ ] Beacons importer runs against sample/test export data without data loss or duplication.
- [ ] MailerLite signup forms submit successfully and land subscribers in the correct group/segment.
- [ ] Core Web Vitals (LCP, CLS, INP) pass "Good" thresholds on the homepage and a product page.
- [ ] Automated accessibility scan (e.g. axe) has zero critical/serious issues on customer-facing
      pages.

## Phase 3 — Migration & automation checklist (for when that phase starts)

- [ ] A full migration **dry run** completes against a staging copy with a written reconciliation
      report (counts in vs. counts imported) before any real-data import is approved.
- [ ] Imported customer/order data is spot-checked against the source system for accuracy.
- [ ] Newsletter consent/unsubscribe status is preserved exactly — no previously-unsubscribed
      contact receives a new email as a result of migration.
- [ ] Fulfillment automation (Conscious Mirror, Pattern Map) is tested with real-shaped but
      non-production data, including the failure path (what happens when an automated step
      errors) and confirming an admin notification fires.
- [ ] Refund and cancellation flows are tested, not just the happy path.
- [ ] Rollback plan has been executed at least once in staging (restore from backup, confirm site
      returns to a known-good state) before go-live.
