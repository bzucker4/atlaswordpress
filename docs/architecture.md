# Architecture

## Theme vs. plugin split

Atlas Relics follows the standard WordPress separation of concerns: **the theme owns
presentation, the plugin owns behavior and data.** This matters because the theme should be
swappable in principle without losing store logic, and the plugin should keep working under a
future theme redesign.

- **`wp-content/themes/atlas-relics`** — the block theme. `theme.json` (design tokens), block
  templates and template parts (`templates/`, `parts/`), block patterns (`patterns/`), and
  `functions.php` (theme support flags, nav menu registration, asset enqueue only). The theme
  contains **no business logic** — no order handling, no third-party API calls, no custom data
  models.
- **`wp-content/plugins/atlas-relics-core`** — the companion plugin. Owns security hardening
  (Phase 1); WooCommerce bundle logic, the Beacons importer, MailerLite/newsletter handling, SEO
  output, and default-page/navigation scaffolding (Phase 2); and Tally-driven fulfillment
  automation, the customer/order migration tool, internal analytics, and the Atlas Relics Ops
  dashboard (Phase 3). Content types the storefront needs (products beyond WooCommerce's own,
  reflection responses, fulfillment records) belong here so they survive a theme change.

If a later phase needs the theme to react to plugin state (e.g. show an "order shipped" banner),
prefer the plugin firing a documented action/filter (see `atlas_relics_core_registered_content_types`
in `includes/class-setup.php` for the pattern) that the theme or a block pattern hooks into,
rather than the theme reaching into plugin internals.

## Why a block theme (FSE)

The theme is a full-site-editing (FSE) block theme rather than a classic PHP-template theme:

- Design tokens (`theme.json`) are the single source of truth for color/type/spacing, enforced in
  the editor UI itself (`custom: false` limits the color picker to brand tokens) rather than by
  convention alone.
- Phase 2's content-heavy pages (Conscious Mirror, Caves, Journal, About) are built as block
  patterns and inserted into their page via a single `core/pattern` reference block, so page
  content and pattern markup never drift apart into two copies.
- WooCommerce's own block-based templates (Cart, Checkout, product blocks) integrate directly with
  an FSE theme's template system rather than requiring classic `woocommerce.php` overrides.

### Why Cart and Checkout aren't forked theme templates

The theme ships `templates/single-product.html` and `templates/archive-product.html` (simple,
stable WooCommerce blocks), but deliberately does **not** ship `cart.html` or `checkout.html`.
WooCommerce registers its own default block templates for Cart and Checkout, and a block theme
inherits them automatically unless it provides its own. Those two templates' inner-block structure
is genuinely complex and changes between WooCommerce releases; hand-authoring and maintaining a
forked copy risks silently breaking checkout on a WooCommerce update. Instead,
`assets/css/woocommerce.css` re-themes WooCommerce's own default Cart/Checkout markup (and the
classic My Account/notice templates) via CSS selectors — full visual integration with the design
system, none of the fork-maintenance risk. Revisit only if the storefront needs cart/checkout
*layout* changes that CSS can't express.

## Directory structure

```
wp-content/themes/atlas-relics/
  theme.json            Design system: color, type, spacing, layout, element styles
  functions.php          Theme support, nav menus, asset enqueue, pattern category, perf tweaks
  templates/              front-page, page, page-no-title, single, archive, search, 404, index,
                           single-product, archive-product
  parts/                  header, footer
  patterns/               PHP-registered block patterns: hero, newsletter-signup (+ segment
                           variants), start-here, conscious-mirror, caves, relics, pattern-map,
                           about
  assets/css/              accessibility.css, forms.css, woocommerce.css

wp-content/plugins/atlas-relics-core/
  atlas-relics-core.php   Plugin bootstrap: constants, requires, activation/deactivation hooks
  includes/
    class-atlas-relics-core.php   Singleton that wires up feature classes
    class-security.php            Phase 1 security hardening
    class-setup.php               Scaffolding for future content types
    class-pages.php               Creates journey pages + nav menus on activation (Phase 2)
    class-settings.php            Settings → Atlas Relics (API keys, group IDs)
    class-seo.php                 Meta description / canonical / Open Graph output
    class-mailerlite.php          MailerLite Connect API wrapper
    class-newsletter.php          AJAX handler behind the newsletter signup forms
    class-bundles.php             Bundle products + restrained upsell/related display
    class-beacons-importer.php    Tools → Beacons Import CSV importer (+ file transfer)
    class-tally.php                Tally webhook receiver + API helper
    class-fulfillment.php          Conscious Mirror / Pattern Map fulfillment automation
    class-migration.php            Tools → Atlas Relics Migration (customers/orders, dry-run gated)
    class-analytics.php            Internal snapshot (wp-admin widget + Ops page)
    class-dashboard.php            Atlas Relics Ops top-level admin page
  assets/js/newsletter.js  Newsletter form submit handler
  uninstall.php            Cleanup on uninstall
```

## Local development environment

`.wp-env.json` at the repo root defines a [`wp-env`](https://developer.wordpress.org/block-editor/reference-guides/packages/packages-env/)
Docker stack: it mounts `wp-content/themes/atlas-relics` and `wp-content/plugins/atlas-relics-core`
straight from the repo, so there is no separate "install the plugin" step for local development.
WordPress core itself is **not** vendored into the repo — `wp-env` downloads it into a Docker
volume, keeping the repo limited to code this project owns.

## Phase 2 additions

- **WooCommerce** is declared via `Requires Plugins: woocommerce` in `atlas-relics-core.php`'s
  header, so the plugin cannot activate until WooCommerce is already active — every
  WooCommerce-dependent class (`class-bundles.php`, `class-beacons-importer.php`) is still guarded
  with `class_exists( 'WooCommerce' )` in `Atlas_Relics_Core::__construct()` so a later WooCommerce
  *deactivation* degrades gracefully instead of a fatal error.
- **MailerLite** is a thin wrapper (`class-mailerlite.php`) called only by `class-newsletter.php`'s
  AJAX handler — no other class makes an HTTP call or touches the API key directly.
- **Default pages and navigation** (`class-pages.php`) run once, from the plugin's activation hook,
  and are idempotent: re-activating (or redeploying) never duplicates pages or overwrites a menu
  an admin has since customized.

## Phase 3 additions

- **Fulfillment records** (`class-fulfillment.php`) are a private `atlas_relics_fulfillment` post
  type rather than a new database table — queryable with `WP_Query`/meta queries without a schema
  migration, which matters more at this project's scale than raw query performance. One record per
  order line item that needs a personalized reading.
- **Tally** (`class-tally.php`) only receives webhooks — it doesn't poll an API on a schedule. Its
  field-extraction is defensive by necessity (see docs/testing.md): Tally's exact webhook payload
  shape needs confirming against a real form once one exists.
- **Migration** (`class-migration.php`) is intentionally two admin actions, not one — see
  docs/security.md for why, and docs/launch.md for how it fits into an actual go-live.
- **Analytics** (`class-analytics.php`) reads only data this site already has (WooCommerce orders,
  fulfillment records, migrated-customer meta). It does not wrap Google Analytics or another
  external service — that needs a real tracking ID this codebase doesn't have, and is a front-end
  concern for whoever sets up the live site rather than something to hard-code a placeholder for.
- **Atlas Relics Ops** (`class-dashboard.php`) is a thin composition layer: it renders data other
  classes already expose (`Atlas_Relics_Core_Analytics::get_snapshot()`, fulfillment/unmatched
  queries, `Atlas_Relics_Core_Migration::OPTION_LAST_RUN`) rather than owning any logic itself.
