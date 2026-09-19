# Coding standards

## PHP

- Follow the [WordPress Coding Standards](https://developer.wordpress.org/coding-standards/wordpress-coding-standards/)
  exactly as enforced by `phpcs.xml.dist` (`WordPress-Extra` + `WordPress-Docs` +
  `PHPCompatibilityWP`, targeting PHP 8.1+). Run `npm run lint:php` before opening a PR; it must
  be clean.
- Tabs for indentation (WordPress convention), not spaces — see `.editorconfig`.
- One class per file, filename `class-{class-name-with-dashes}.php`, matching
  `wp-content/plugins/atlas-relics-core/includes/class-security.php` and `class-setup.php`.
- Prefix all globals (functions, classes, constants, hooks, option/transient keys) with
  `atlas_relics_` / `Atlas_Relics_` / `ATLAS_RELICS_` as appropriate — see `docs/security.md`
  rule 7.
- Every file starts with `if ( ! defined( 'ABSPATH' ) ) { exit; }` immediately after the opening
  PHP tag (after any file-level docblock) to prevent direct access.
- Docblocks on every function/class/file, but keep them factual (`@param`, `@return`, one-line
  `@package`) — do not narrate implementation detail that the code already shows.
- New plugin behavior is added as its own `Atlas_Relics_Core_*` class registered from
  `Atlas_Relics_Core::__construct()`, following the existing `class-security.php` / `class-setup.php`
  pattern, rather than piling more hooks into one file.

## Theme (block theme / FSE)

- All design values (color, font, spacing, radius) come from `theme.json` presets
  (`var:preset|color|navy-900`, `has-gold-500-background-color`, `var:preset|spacing|50`, …).
  Never hand-write a hex color, `px` font size, or arbitrary spacing value in template/pattern
  markup — add or adjust the token in `theme.json` instead, so the change applies everywhere.
- New reusable sections become block patterns in `wp-content/themes/atlas-relics/patterns/`
  (PHP file with a `Title:`/`Slug:`/`Categories:` header comment), not one-off markup duplicated
  across templates.
- Keep `functions.php` to theme concerns only (theme support flags, nav menu registration, asset
  enqueue, pattern category registration). Business logic belongs in `atlas-relics-core`.

## JavaScript / CSS

- None is needed yet in Phase 1 (the theme is pure block markup + `theme.json`). When Phase 2
  introduces custom blocks or scripts, follow the
  [WordPress JavaScript Coding Standards](https://developer.wordpress.org/coding-standards/wordpress-coding-standards/javascript/)
  (ESLint config `@wordpress/eslint-plugin`) and enqueue via `wp_enqueue_script`/`_style` with
  correct dependency arrays — never inline `<script>`/`<style>` tags in templates.

## Git & PRs

- Branch per unit of work; commit messages describe *why*, not a restatement of the diff.
- A PR must pass `npm run lint:php` and the relevant phase checklist in `docs/testing.md` before
  merge.
- Don't mix phases in one PR — Phase 2 storefront work does not ship in the same PR as a Phase 1
  foundation fix, so each phase's "completed, tested, merged" gate stays meaningful.
- No commented-out code, no debug `error_log()`/`var_dump()` left in, no TODO comments without a
  linked follow-up — see the project-wide rule against half-finished implementations.
