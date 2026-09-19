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
