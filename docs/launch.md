# Backup, launch, cutover, and rollback

This is the runbook for moving Atlas Relics from a working codebase to `atlasrelics.com` running
real data. It exists because Phase 3 handles real customers, real orders, and real payments —
mistakes here are expensive and some are irreversible, so every real-data step below is manual,
reviewed, and reversible until the moment it deliberately isn't.

**Nothing in this repository runs any of these steps automatically.** The migration tool
(`docs/integrations.md` → Beacons/Tally, and this file's migration section) always stops at a dry
run until a human reviews it and explicitly confirms. Treat that as a hard rule, not a default.

## 1. Backup

Before *any* Phase 3 action touches the production site:

- [ ] Full site backup (database + `wp-content`) taken and **verified restorable** — a backup you
      haven't test-restored is a hope, not a backup. Restore it to a scratch environment and
      confirm the site loads.
- [ ] Database backup timestamped and retained separately from the routine backup schedule, so a
      migration mistake can be rolled back to this exact point without also losing days of
      unrelated backup rotation.
- [ ] Confirm the host's backup/restore process and who has access to trigger a restore, before
      you need it under pressure.

## 2. Staging dry run

- [ ] Restore the verified backup to a staging copy of the site.
- [ ] Run the full migration dry run (Tools → Atlas Relics Migration) against staging with the
      real customer/order export files — this exercises the exact code path production will use,
      against realistic data volume, without any risk to production.
- [ ] Review the reconciliation report: row counts in vs. valid vs. invalid, and specifically the
      *reasons* invalid rows failed (a systematic reason — e.g. a date format issue — usually
      means fixing the export, not the importer).
- [ ] Commit the dry run **on staging** and manually spot-check the results: a handful of
      customers and orders, checked against the source system by hand.
- [ ] Confirm newsletter consent carried over correctly (see docs/security.md — consent is stored
      as data, never used to auto-resubscribe anyone).

Do not proceed to production until the staging commit's reconciliation numbers make sense and the
spot check passes.

## 3. Production migration

- [ ] Re-confirm the backup from step 1 is recent enough to still be the right rollback point (if
      real-world time has passed and new backups were taken, use the most recent verified one).
- [ ] Run the dry run again on **production** (not just staging) — data can drift between when
      staging was tested and when production migration actually happens.
- [ ] Review the reconciliation report again. If it doesn't match the staging run's shape, stop
      and find out why before committing.
- [ ] Commit the production import.
- [ ] Immediately verify: total customer count, total order count, and revenue-total sanity check
      against the source system.
- [ ] Confirm the Beacons file transfer (if used) actually moved files — spot check a downloadable
      product's file URL points at this site, not Beacons.

## 4. Connect live services

- [ ] MailerLite: real API key and group IDs in Settings → Atlas Relics (replace any staging/test
      values).
- [ ] Tally: real webhook secret and form URLs in Settings → Atlas Relics; each Tally form's
      webhook pointed at the URL shown on that settings page.
- [ ] Payment gateway: live (not test/sandbox) credentials in WooCommerce → Settings → Payments.
- [ ] Confirm `WP_DEBUG_DISPLAY` is off and `DISALLOW_FILE_EDIT` is on in production
      `wp-config.php` (see docs/security.md).

## 5. Pre-launch testing (see docs/testing.md Phase 3 checklist for the full list)

- [ ] A real payment, for a real (small) amount, completes end-to-end.
- [ ] A downloadable product delivers its file to a real customer account.
- [ ] A refund is issued and reflected correctly in both WooCommerce and the payment gateway.
- [ ] Order confirmation, downloadable-file, and fulfillment-reminder emails all arrive, are
      correctly branded, and don't land in spam.
- [ ] A Conscious Mirror or Pattern Map purchase triggers the fulfillment email, the Tally
      submission arrives via webhook, and Atlas Relics Ops shows it as ready to prepare.

## 6. Cutover

- [ ] DNS/hosting cutover to the new site, following your host's standard process.
- [ ] Old site (if any) put into a maintenance/redirect state rather than deleted — keep it
      reachable in case of an unexpected rollback need.
- [ ] Monitor error logs and Atlas Relics Ops closely for the first 24–48 hours: watch the
      "Unmatched Tally submissions" table and fulfillment backlog specifically, since those are
      the parts of the system most dependent on external services behaving as expected.

## 7. Rollback plan

Rehearse this in staging (step 2) before you need it for real.

- [ ] Trigger: define in advance what actually triggers a rollback (e.g. payments failing for
      more than N minutes, data corruption discovered, migration produced materially wrong
      counts) — deciding this *during* an incident is how bad decisions get made.
- [ ] DNS/hosting cutover reversed back to the previous known-good site.
- [ ] Database restored from the step-1 backup if the new site wrote data that needs to be
      discarded (e.g. a botched migration commit) — restoring the backup, not attempting to
      hand-undo the migration, is the safe path, because the migration tool creates real
      users/orders with side effects (emails already sent) that can't be cleanly reversed by
      deleting rows alone.
- [ ] Post-rollback: confirm the previous site is fully functional again before investigating
      what went wrong, then fix forward in staging.

## Ongoing operations

Once launched, this isn't a one-time checklist:

- Weekly: check Atlas Relics Ops for a growing fulfillment backlog or an unusual number of
  unmatched Tally submissions — both are signals something upstream (Tally form config, webhook
  secret rotation, an email deliverability issue) needs attention.
- The migration cache directory (`wp-content/uploads/atlas-relics-migration/`) self-cleans dry-run
  files older than 24 hours via the same daily cron fulfillment reminders use — no manual cleanup
  needed, but it's worth knowing that directory exists and why it's `.htaccess`-protected (see
  docs/security.md).
