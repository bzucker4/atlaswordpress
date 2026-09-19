# Integrations

Phase 2 wires up the *code* for two integrations. Neither goes live until an admin fills in real
credentials in **Settings → Atlas Relics** — nothing here ships with a hard-coded key, per
[docs/security.md](security.md) rule 6.

## MailerLite

Newsletter signup (footer, Start Here, Conscious Mirror) posts through
`Atlas_Relics_Core_Newsletter` (`wp-content/plugins/atlas-relics-core/includes/class-newsletter.php`)
to `Atlas_Relics_Core_MailerLite::subscribe()`
(`wp-content/plugins/atlas-relics-core/includes/class-mailerlite.php`), which calls the
[MailerLite Connect API](https://developers.mailerlite.com/docs/subscribers.html).

**Setup:**

1. In MailerLite: Integrations → API → create an API key. Subscribers → Groups → create a group
   for each segment you want (footer signups, Start Here, Conscious Mirror).
2. In wp-admin: Settings → Atlas Relics → paste the API key and each group's ID.
3. That's it — the existing signup forms on the homepage, Start Here, and Conscious Mirror pages
   start working immediately; no template changes needed.

**Segmentation** is by which pattern the form came from, not a form field: each of the three
newsletter-signup pattern variants (`patterns/newsletter-signup.php`,
`newsletter-signup-start-here.php`, `newsletter-signup-conscious-mirror.php`) sets a
`data-segment` attribute the AJAX handler reads to pick the matching group setting. Add a new
segment by duplicating one of those patterns with a new `data-segment` value, adding its settings
field in `class-settings.php`, and adding the mapping in `Atlas_Relics_Core_Newsletter::$segments`.

## Beacons product import

Tools → Beacons Import (`Atlas_Relics_Core_Beacons_Importer`,
`wp-content/plugins/atlas-relics-core/includes/class-beacons-importer.php`) uploads a CSV and
creates/updates WooCommerce products from it.

**CSV columns:** `title, description, price, sku, download_url, image_url`. Download a filled-in
example from the "Download a sample CSV template" link on the import page itself.

**Behavior to know before running a real import:**

- Every imported/updated product is set to **draft** — nothing goes live automatically.
- Matching is by `sku`: a row whose SKU matches an existing product updates it instead of creating
  a duplicate, so the same file can be re-imported safely.
- `download_url` presence makes the product virtual + downloadable with that URL as its file.
- `image_url` is only sideloaded if the product doesn't already have a featured image, so it won't
  overwrite an image an admin has already set manually.

Phase 2 uses this against test/sanitized exports only. The real historical catalog moves in
Phase 3, after a dry run (see [docs/testing.md](testing.md)).
