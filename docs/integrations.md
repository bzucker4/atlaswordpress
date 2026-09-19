# Integrations

This project wires up the *code* for each integration below. None goes live until an admin fills
in real credentials in **Settings → Atlas Relics** — nothing here ships with a hard-coded key, per
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
Phase 3, after a dry run (see [docs/testing.md](testing.md)). Check "Transfer files to this site"
to move each `download_url` into this site's own protected storage instead of linking to Beacons'
hosting — see the class docblock in `class-beacons-importer.php` for why that matters.

## Tally

The Conscious Mirror and Pattern Map questionnaires are Tally forms. `Atlas_Relics_Core_Tally`
(`wp-content/plugins/atlas-relics-core/includes/class-tally.php`) receives each submission via
webhook and hands it to `Atlas_Relics_Core_Fulfillment` (`class-fulfillment.php`) to match against
the order it belongs to. See `docs/architecture.md` for how fulfillment records flow end to end.

**Setup:**

1. In wp-admin: Settings → Atlas Relics → Tally section. Generate a random secret (a password
   manager or `openssl rand -hex 32` both work) and paste it into "Webhook Signing Secret". Copy
   the webhook URL shown on that same page.
2. Build (or reuse) a Tally form for Conscious Mirror and one for Pattern Map. Paste each form's
   share URL into the matching "Form URL" field in Settings → Atlas Relics.
3. In Tally: form → Integrations → Webhooks → add a webhook pointing at the URL from step 1, using
   the same secret so Tally signs its requests with it.
4. On the product edit screen for any product that should trigger a personalized reading (a
   Pattern Map product, for example), set "Atlas Relics Fulfillment" → "Requires a personalized
   reading?" to the matching type.

**Before relying on this in production**, verify the actual webhook payload shape against a real
Tally submission — see the note at the top of `class-tally.php` and the corresponding item in
`docs/testing.md`'s Phase 3 checklist. Tally's field extraction is written defensively (it never
fatals on an unexpected shape), but "defensive" isn't the same as "verified".
