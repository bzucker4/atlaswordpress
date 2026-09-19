# Atlas Relics (theme)

Native WordPress block theme (full-site editing). All design tokens — colors, type scale,
spacing, and element styles — live in `theme.json`; do not add hard-coded colors, fonts, or
spacing values in template or pattern markup. Use the presets (`var:preset|color|navy-900`,
`has-gold-500-background-color`, etc.) so brand changes only ever need to happen in one place.

- `templates/` — top-level page templates (`front-page`, `page`, `single`, `archive`, `search`,
  `404`, `index`, plus the `page-no-title` custom template).
- `parts/` — reusable template parts (`header`, `footer`).
- `patterns/` — PHP-registered block patterns (auto-loaded by WordPress from this directory).
- `functions.php` — theme support, nav menu registration, asset enqueue, pattern category.

See [`/docs/brand.md`](../../../docs/brand.md) for the design system this theme implements and
[`/docs/architecture.md`](../../../docs/architecture.md) for how the theme and the Atlas Relics
Core plugin divide responsibilities.
