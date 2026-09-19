# Atlas Relics — WordPress & WooCommerce Ecosystem

Atlas Relics is a premium WordPress/WooCommerce platform built in three phases. This repository
is developed one phase at a time: each phase is completed, tested, and merged before the next
begins.

## Phase roadmap

- **Phase 1 — Foundation** *(done)*: native block theme, companion plugin, design system, base
  templates, local dev environment, and documentation/rules. No live store or third-party services.
- **Phase 2 — Storefront** *(this phase)*: homepage, journey pages, WooCommerce shop/cart/checkout,
  bundles, Beacons import tooling, MailerLite forms, SEO/accessibility/performance work. Uses test
  products and sanitized data only — see the Status note in [docs/product.md](docs/product.md).
- **Phase 3 — Migration & automation**: real product/customer/order migration, MailerLite and
  Tally integrations, fulfillment automation, admin operations dashboard, analytics, and
  launch/rollback planning. Real data is imported only after a successful dry run and approval.

See [docs/product.md](docs/product.md) for the full product vision and ecosystem description.

## What's in Phase 1

| Deliverable | Location |
| --- | --- |
| Atlas Relics block theme | `wp-content/themes/atlas-relics` |
| Atlas Relics Core plugin | `wp-content/plugins/atlas-relics-core` |
| Design system (navy / ivory / antique gold) | `wp-content/themes/atlas-relics/theme.json`, [docs/brand.md](docs/brand.md) |
| Base templates, navigation, header, footer | `wp-content/themes/atlas-relics/templates`, `.../parts` |
| Local development environment | `.wp-env.json` |
| Documentation | `docs/` |
| Security & coding rules | [docs/security.md](docs/security.md), [docs/coding-standards.md](docs/coding-standards.md) |

## What's in Phase 2

| Deliverable | Location |
| --- | --- |
| Homepage + journey pages (Start Here, Conscious Mirror, Caves, Relics, Pattern Map, Journal, About) | `wp-content/themes/atlas-relics/patterns`, created automatically by `class-pages.php` |
| WooCommerce theme support + single-product/archive-product templates | `functions.php`, `templates/single-product.html`, `templates/archive-product.html` |
| Cart/Checkout/My Account theming | `assets/css/woocommerce.css` (see `docs/architecture.md` for why these aren't forked templates) |
| Bundles + restrained upsells/related products | `class-bundles.php` |
| Beacons CSV importer | Tools → Beacons Import, `class-beacons-importer.php`, [docs/integrations.md](docs/integrations.md) |
| MailerLite newsletter + segmentation | Settings → Atlas Relics, `class-mailerlite.php`, `class-newsletter.php`, [docs/integrations.md](docs/integrations.md) |
| SEO meta/OG tags, accessibility (skip link, focus states), perf (no emoji scripts) | `class-seo.php`, `assets/css/accessibility.css` |

Phase 2 uses test products and sanitized information — no real customers or historical orders are
imported (that's Phase 3).

## Local development

This project uses [`@wordpress/env`](https://developer.wordpress.org/block-editor/reference-guides/packages/packages-env/)
(`wp-env`), the official Docker-based local WordPress environment, so the whole team runs an
identical stack.

### Prerequisites

- [Docker](https://www.docker.com/) (Docker Desktop or compatible)
- [Node.js](https://nodejs.org/) 18+ (for `npm` / `wp-env`)
- [Composer](https://getcomposer.org/) (for PHP coding-standards tooling)

### Start the environment

```bash
npm install
npm run env:start
```

This launches WordPress at `http://localhost:8888` (admin at `/wp-admin`, default
credentials `admin` / `password`) with WooCommerce, the Atlas Relics theme, and the Atlas Relics
Core plugin mounted/installed from `.wp-env.json`, plus a matching test-site instance on
`http://localhost:8889`.

### Common commands

```bash
npm run env:start     # start the local environment
npm run env:stop      # stop the local environment
npm run env:destroy   # tear down containers and volumes
npm run env:cli       # run a wp-cli command, e.g. npm run env:cli -- theme list
npm run lint:php      # run PHP_CodeSniffer against the WordPress Coding Standards
```

On first boot, activate the theme and plugins in this order — WooCommerce first, since
Atlas Relics Core declares it as a required dependency (wp-env does not auto-activate a plugin
bundled under `wp-content/plugins`):

```bash
npm run env:cli -- theme activate atlas-relics
npm run env:cli -- plugin activate woocommerce
npm run env:cli -- plugin activate atlas-relics-core
```

Activating `atlas-relics-core` creates the Phase 2 journey pages and navigation menus
automatically (see [docs/architecture.md](docs/architecture.md)). To finish wiring up the
storefront, add a MailerLite API key and group IDs under **Settings → Atlas Relics** — see
[docs/integrations.md](docs/integrations.md).

## Repository layout

```
docs/                                Product, brand, architecture, testing, security, integrations
wp-content/themes/atlas-relics/      Native WordPress block theme
wp-content/plugins/atlas-relics-core/ Companion plugin (security, storefront, fulfillment)
.wp-env.json                         Local dev environment definition (includes WooCommerce)
phpcs.xml.dist                       WordPress Coding Standards ruleset
```

See [docs/architecture.md](docs/architecture.md) for details on how the theme and plugin divide
responsibilities.

## Contributing rules

Before opening a PR, read [docs/coding-standards.md](docs/coding-standards.md) and
[docs/security.md](docs/security.md). Every PR must pass `npm run lint:php` and the checklist in
[docs/testing.md](docs/testing.md) for the phase it belongs to.
