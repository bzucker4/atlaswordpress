# Atlas Relics — WordPress & WooCommerce Ecosystem

Atlas Relics is a premium WordPress/WooCommerce platform built in three phases. This repository
is developed one phase at a time: each phase is completed, tested, and merged before the next
begins.

## Phase roadmap

- **Phase 1 — Foundation** *(this phase)*: native block theme, companion plugin, design system,
  base templates, local dev environment, and documentation/rules. No live store or third-party
  services yet.
- **Phase 2 — Storefront**: homepage, journey pages, WooCommerce shop/cart/checkout/accounts,
  bundles, Beacons import tooling, MailerLite forms, SEO/accessibility/performance work. Uses
  test products and sanitized data only.
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

Phase 1 establishes structure only — no live storefront, no third-party service connections, and
no real customer data.

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
credentials `admin` / `password`) with the Atlas Relics theme and Atlas Relics Core plugin
mounted from this repo, plus a matching test-site instance on `http://localhost:8889`.

### Common commands

```bash
npm run env:start     # start the local environment
npm run env:stop      # stop the local environment
npm run env:destroy   # tear down containers and volumes
npm run env:cli       # run a wp-cli command, e.g. npm run env:cli -- theme list
npm run lint:php      # run PHP_CodeSniffer against the WordPress Coding Standards
```

On first boot, activate the theme and plugin (wp-env does not auto-activate a plugin bundled
under `wp-content/plugins`):

```bash
npm run env:cli -- theme activate atlas-relics
npm run env:cli -- plugin activate atlas-relics-core
```

## Repository layout

```
docs/                                Product, brand, architecture, testing, security docs
wp-content/themes/atlas-relics/      Native WordPress block theme
wp-content/plugins/atlas-relics-core/ Companion plugin (fulfillment, security, setup)
.wp-env.json                         Local dev environment definition
phpcs.xml.dist                       WordPress Coding Standards ruleset
```

See [docs/architecture.md](docs/architecture.md) for details on how the theme and plugin divide
responsibilities.

## Contributing rules

Before opening a PR, read [docs/coding-standards.md](docs/coding-standards.md) and
[docs/security.md](docs/security.md). Every PR must pass `npm run lint:php` and the checklist in
[docs/testing.md](docs/testing.md) for the phase it belongs to.
