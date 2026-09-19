# Product vision

Atlas Relics is a WordPress + WooCommerce ecosystem built at `atlasrelics.com`. It is developed
as one clean, private codebase in three sequential phases — each completed, tested, and merged
before the next begins — rather than as one large simultaneous build.

**Status:** Phases 1–3 are implemented in code. All three still need a full manual QA pass against
the checklists in [docs/testing.md](testing.md) — see that file for what to verify — before any of
them is considered "completed, tested, and merged." **No real customer data, orders, or payments
have been migrated or processed** — Phase 3's migration tool is built but has not been run against
real data by anyone; that only happens after the dry run + approval sequence in
[docs/launch.md](launch.md), which is a decision for whoever runs the live site to make.

## Phase 1 — Foundation

Builds the underlying WordPress system and brand framework:

- Native Atlas Relics WordPress block theme
- Atlas Relics Core companion plugin
- Premium navy, ivory, and antique-gold design system
- Basic page templates, navigation, header, and footer
- Local development environment
- Product, brand, architecture, and testing documentation
- Security and coding rules

Phase 1 creates the structure. It does **not** build the finished store or connect real
services — there is no live checkout, no test or real product catalog, and no third-party
integration configured yet.

## Phase 2 — Storefront

Turns the foundation into a complete customer-facing store:

- Homepage and Start Here journey
- Conscious Mirror, Caves, Relics, Pattern Map, Journal, and About pages
- WooCommerce shop, product pages, cart, checkout, downloads, and customer accounts
- Product bundles, related products, and restrained upsells
- Beacons product-inventory template and product importer
- MailerLite newsletter forms and audience segmentation
- SEO, accessibility, mobile optimization, and performance improvements

Phase 2 uses test products and sanitized information. It does not import real customers or
historical orders.

## Phase 3 — Migration & automation

Moves the existing business into the new system and automates repeatable work:

- Transfer Beacons products and secure download files
- Import approved customers and historical orders
- Preserve newsletter consent and unsubscribe records
- Connect MailerLite
- Connect Tally questionnaires
- Automate Conscious Mirror and Pattern Map fulfillment
- Add reminders, admin notifications, delivery tracking, and error handling
- Create an administrative operations dashboard
- Add analytics and migration reconciliation
- Test payments, downloads, refunds, emails, and personalized orders
- Prepare backup, launch, cutover, and rollback plans

Real data is imported only after a successful dry run and explicit approval.

## The finished customer journey

1. Someone discovers Atlas Relics through an article, Medium, search, or social content.
2. They enter through a free reflection or Conscious Mirror.
3. They join The Weekly Mirror newsletter.
4. They purchase a Cave, guide, or bundle.
5. They can progress to a course, personalized reading, or Pattern Map.
6. WooCommerce manages payments, orders, downloads, coupons, and customer accounts.
7. MailerLite manages newsletters and customer-interest groups.
8. Tally collects personalized reflection responses.
9. Atlas Relics Core manages fulfillment, reminders, statuses, and administrative workflows.

The result is one unified brand, store, newsletter, customer system, and fulfillment workflow.
