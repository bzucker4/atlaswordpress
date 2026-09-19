# Brand & design system

Atlas Relics reads as considered and unhurried — a premium, editorial tone rather than a loud
retail one. The design system exists as tokens in
[`wp-content/themes/atlas-relics/theme.json`](../wp-content/themes/atlas-relics/theme.json); this
document explains the intent behind those tokens so future phases (and future contributors)
extend them consistently instead of hard-coding new values.

## Color palette

| Token | Hex | Use |
| --- | --- | --- |
| `navy-900` | `#0B1B33` | Primary dark surface — header, footer, hero sections |
| `navy-700` | `#16294A` | Secondary dark surface, muted text on light backgrounds |
| `ivory-50` | `#F7F3E9` | Primary page background, text on dark surfaces |
| `ivory-100` | `#EFE8D6` | Card / section background, subtle contrast against `ivory-50` |
| `gold-500` | `#C6A15C` | Primary accent — buttons, links, dividers, eyebrows |
| `gold-600` | `#AD8748` | Hover/active state for gold elements |
| `charcoal-900` | `#1C1C1C` | Body text on light backgrounds |
| `white` | `#FFFFFF` | Rare — high-contrast accents only |

Rules:

- **Never introduce a new color outside this palette.** `theme.json` sets
  `color.custom: false` / `color.customGradient: false` specifically to keep the editor's color
  picker limited to these tokens; extend the palette in `theme.json` (and this table) if a
  genuine new need appears, rather than working around the restriction.
- Gold is an accent, not a background. Use it for buttons, dividers, small eyebrow labels, and
  hover states — not for large fills.
- Maintain WCAG AA contrast: `ivory-50` text on `navy-900` and `charcoal-900` text on `ivory-50`
  both pass; `gold-500` text should only be used at large/bold sizes or against `navy-900`, never
  as body copy on `ivory-50`.

## Typography

- **Headings** use the `heading` font family — a serif system stack (`Iowan Old Style`,
  `Palatino Linotype`, `Palatino`, `Georgia`) chosen so Phase 1 ships without external font
  requests. When a licensed display serif (e.g. a Fraunces or Canela-style face) is selected for
  the brand, add it as a local `fontFace` in `theme.json` and it will apply everywhere headings
  are used — no template changes required.
- **Body copy** uses the `body` font family — a neutral system sans stack. Swap this the same way
  once a body typeface is licensed.
- Type sizes are fluid (`settings.typography.fluid`) and scale between the `small`/`medium`/
  `large`/`x-large`/`xx-large` presets — always reference a preset size, never a literal `px`/`rem`
  value in block markup.

## Voice

Atlas Relics writes like a guide, not a salesperson: short declarative sentences, a reflective
register, and calls-to-action framed as invitations ("Start Here", "Try the Conscious Mirror")
rather than pressure ("Buy Now", "Limited Time"). Avoid exclamation points, urgency language, and
discount-driven copy — that tone belongs to a different kind of brand.

## Layout

- Constrained content width: `720px` for reading content, `1200px` wide alignment — set once in
  `theme.json` `settings.layout` and inherited by every template.
- Spacing uses the generated `spacingScale` presets (`var:preset|spacing|40`, `|50`, `|60`, …)
  instead of arbitrary padding/margin values, so vertical rhythm stays consistent as new pages are
  added in Phase 2.

## Logo & imagery

No logo mark exists yet — Phase 1 uses the site title (`core/site-title`) styled in the heading
font as a wordmark placeholder. When a logo is produced, register it via `custom-logo` theme
support and update `parts/header.html` and `parts/footer.html` to use `core/site-logo` in place
of `core/site-title`.
