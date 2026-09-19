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
  (Phase 1), and will own custom post types/taxonomies, WooCommerce hooks, Beacons import,
  MailerLite/Tally integration, fulfillment automation, and the admin operations dashboard as
  later phases add them. Content types the storefront needs (products beyond WooCommerce's own,
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
- Phase 2's content-heavy pages (Conscious Mirror, Caves, Journal, About) can be built and edited
  as block patterns without new PHP templates for every page.
- WooCommerce's own block-based templates (Cart, Checkout, product blocks) integrate directly with
  an FSE theme's template system rather than requiring classic `woocommerce.php` overrides.

## Directory structure

```
wp-content/themes/atlas-relics/
  theme.json            Design system: color, type, spacing, layout, element styles
  functions.php          Theme support, nav menus, asset enqueue, pattern category
  templates/              front-page, page, page-no-title, single, archive, search, 404, index
  parts/                  header, footer
  patterns/               PHP-registered block patterns (e.g. hero)

wp-content/plugins/atlas-relics-core/
  atlas-relics-core.php   Plugin bootstrap: constants, requires, activation/deactivation hooks
  includes/
    class-atlas-relics-core.php   Singleton that wires up feature classes
    class-security.php            Phase 1 security hardening
    class-setup.php               Scaffolding for future content types
  uninstall.php            Cleanup on uninstall
```

## Local development environment

`.wp-env.json` at the repo root defines a [`wp-env`](https://developer.wordpress.org/block-editor/reference-guides/packages/packages-env/)
Docker stack: it mounts `wp-content/themes/atlas-relics` and `wp-content/plugins/atlas-relics-core`
straight from the repo, so there is no separate "install the plugin" step for local development.
WordPress core itself is **not** vendored into the repo — `wp-env` downloads it into a Docker
volume, keeping the repo limited to code this project owns.

## Extension points for later phases

- **Phase 2 (WooCommerce)**: WooCommerce will be added as a required plugin dependency (declared
  in `atlas-relics-core.php`'s header once WooCommerce-specific code lands) rather than bundled;
  the theme already ships template-part slots (`header`/`footer`) WooCommerce's blocks can render
  inside without modification.
- **Phase 2 (MailerLite)**: newsletter forms will call out via a thin wrapper class inside
  `atlas-relics-core`, keeping API keys and HTTP calls out of the theme.
- **Phase 3 (Tally, automation, dashboard)**: new `includes/class-*.php` files registered from
  `Atlas_Relics_Core::__construct()`, following the same one-class-per-concern pattern as
  `class-security.php` and `class-setup.php`.
