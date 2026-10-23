# Status report

Last updated: 2026-10-23, after the first real smoke-testing round on a local `wp-env`
instance. This file is a point-in-time snapshot for quick reference — `docs/product.md`
carries the canonical phase status note, `docs/testing.md` the detailed checklists, and
`docs/launch.md` the go-live runbook. If this file and those disagree, trust the `docs/`
files and update this one.

## What we did

### Phase 1 — Foundation (`e44d8a5`)

- Native Atlas Relics block theme: `theme.json` design system (navy / ivory / antique-gold
  palette, fluid type scale), base templates (front page, page, single, archive, search,
  404), header/footer template parts, a starter hero block pattern.
- Atlas Relics Core plugin: bootstrap + security hardening (version fingerprint removal,
  XML-RPC pingback lockdown, REST user-enumeration protection, generic login errors,
  security headers, `DISALLOW_FILE_EDIT`).
- Local dev environment (`wp-env` via `.wp-env.json`), coding-standards tooling (`phpcs`,
  `.editorconfig`), and the initial `docs/` set (product, brand, architecture, testing,
  security, coding-standards).

### Phase 2 — Storefront (`d05336f`)

- Journey pages — Start Here, Conscious Mirror, Caves, Relics, Pattern Map, Journal,
  About — created and linked automatically on plugin activation (`class-pages.php`), each
  as an editable block pattern.
- WooCommerce theme support, `single-product`/`archive-product` block templates, and
  Cart/Checkout/My Account themed via CSS rather than forked templates (see
  `docs/architecture.md` for why).
- Lightweight product bundles (no paid extension needed) and restrained upsell/related
  product display.
- Beacons CSV importer (Tools → Beacons Import), draft-only, matched by SKU.
- MailerLite newsletter signup with per-page segmentation (footer / Start Here /
  Conscious Mirror).
- SEO meta/OG tags, accessibility (skip link, focus-visible styles), performance (dropped
  emoji scripts).

### Phase 3 — Migration & automation (`a896ff8`)

- Tally webhook receiver (signature-verified) driving Conscious Mirror / Pattern Map
  fulfillment automation: order completion → personalized questionnaire link emailed →
  webhook matches the response back to the order → admin notified → marked delivered from
  Atlas Relics Ops. Stale fulfillments get an automated reminder via daily cron; unmatched
  webhook submissions are logged and flagged, not dropped.
- Atlas Relics Ops: one admin dashboard for the fulfillment backlog, unmatched
  submissions, migration status, and an operational snapshot.
- Customer/order migration tool, deliberately two admin actions rather than one: a dry run
  that only validates and caches to disk, and a commit step gated behind the exact
  dry-run token plus an explicit confirmation checkbox. Newsletter consent is preserved as
  data only — migration never calls the MailerLite API.
- Beacons importer gained an optional file-transfer step (move download files into this
  site's own storage instead of linking to Beacons' hosting).
- `docs/launch.md`: the backup → staging dry-run → production migration → cutover →
  rollback runbook.

### Smoke-test fixes (`34c1f13`, `e8a4a0d`)

Running Phase 3 against a real `wp-env` instance surfaced four real bugs that static
review (PHP lint, JSON validation, block-markup checks) couldn't have caught:

1. The `atlas_relics_fulfillment` post type slug was 25 characters — WordPress silently
   refuses to register post types over 20 characters, so fulfillment records never
   worked. Renamed to `ar_fulfillment`.
2. Tally reports a hidden field's auto-generated `key` (e.g. `question_abc123`) with the
   field's actual name in `label`, not `key` as originally assumed — webhook matching
   would have silently failed. `extract_field()` now matches either, case-insensitively,
   and is hardened against malformed field entries.
3. A duplicate `<link rel="canonical">` tag (core's own plus ours) — fixed by removing
   core's `rel_canonical` output.
4. The Atlas Relics Ops dashboard linked to orders via `post.php?post={id}`, which breaks
   under WooCommerce's High-Performance Order Storage (now the default) since orders
   aren't posts in that mode. Fixed to use `get_edit_order_url()`.

### Getting a working local environment running (this session)

- Confirmed `wp-env` + Docker is the right (and free) way to run this locally; ruled out
  paying for WordPress.com hosting ($9+/mo) as unnecessary for preview purposes.
- Walked through a fresh Chromebook (ChromeOS/Crostini) setup from zero: installed Docker
  Engine, resolved a docker-group permission issue, booted `wp-env`, activated the theme
  and both plugins, and confirmed the site renders.
- Set up a Cloudflare Tunnel (`cloudflared tunnel --url http://localhost:8888`) as the
  $0 way to get a shareable preview link from a local instance.
- A free (never upgraded, no cost incurred) WordPress.com test site was created during
  the hosting-options exploration (`testsite9959.wordpress.com`) but isn't part of the
  active workflow — local `wp-env` + tunnel is what's actually being used.

## What needs to get done

### Immediate — visual/content polish

Flagged directly from the first real preview:

- **No logo** — site title is a text placeholder.
- **No real products** — Shop, Caves, and Relics pages have nothing to show (no product
  category data exists yet).
- **Draft copy** — the journey-page copy is a first pass, not reviewed brand voice.
- **System fonts only** — no licensed typeface loaded (deliberate, pending a brand
  decision — see `docs/brand.md`).
- **Unstyled WooCommerce defaults** — likely still showing through in places our CSS
  doesn't specifically cover.

Sample/test products to populate Shop/Caves/Relics is something that can happen without
further input; logo, typography, and copy need a decision first (see the open questions
below).

### QA — work through the phase checklists for real

`docs/testing.md` has the full checklist per phase. Confirmed so far: environment boots,
theme/plugins activate, fulfillment post type registers, Tally field matching works. Not
yet confirmed: the full Phase 1/2/3 checklists end to end (every template, every form,
bundles, the migration dry run, the Ops dashboard, accessibility/performance checks).

### Two unverified assumptions, flagged in the code itself

- **WooCommerce block names** in `templates/single-product.html` /
  `archive-product.html` — written from best knowledge, not confirmed against the
  specific WooCommerce version now running. If the Site Editor shows an "unrecognized
  block," that's this.
- **Tally's webhook payload shape** — the fix above corrected the `key`/`label` mismatch,
  but the extraction logic should still be confirmed against a real Tally form submission
  once one exists, per the note in `class-tally.php`.

### Real credentials — none configured yet

MailerLite API key + group IDs, Tally webhook secret + form URLs, a real/sandbox payment
gateway. Steps are in `docs/integrations.md`.

### The actual migration — intentionally not started

No real customer, order, or payment data has been touched. The migration tool is built
and basic-tested but has never been run against real data. That's a deliberate decision
gated behind a dry run and explicit approval (`docs/launch.md`), to be made by whoever
operates the live site — not something to do casually during development testing.

### Process loose ends

- No pull request exists. The repo started empty, so there's no `main` branch with a
  meaningful diff to PR against (a stray, harmless, never-upgraded `main` branch exists on
  GitHub as a byproduct of exploring that — safe to delete, or ignore).
- No automated tests — everything is manual QA per `docs/testing.md` until Phase 2's
  WooCommerce flows are stable enough to be worth automating.

### Open questions for you

1. Do you have a logo, or should that stay a placeholder for now?
2. Any typeface preference, or stay on system fonts until there's a brand decision?
3. Do you want another copy pass on the journey pages, or will you rewrite them yourself
   once real content is loaded?
