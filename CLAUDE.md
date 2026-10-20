# Architecture Atlas

A personal atlas of 8 American architecture movements, built as a WordPress block theme. This is a learning project for working with AI agents. Keep scope small.

## Stack
- Block theme with `theme.json` (no classic PHP templates unless I ask)
- ACF (free) for custom fields
- React via `@wordpress/scripts` for one feature: a filterable movement timeline using the REST API
- Local by Flywheel, PHP 8.2+

## Scope limits (do not exceed)
- 3 CPTs: Movement, Building, Architect
- 1 taxonomy: Place (Southern California, New York, New Orleans, Chicago, New Mexico)
- 1 React feature
- 8 movements, 2 buildings each to start
- No custom illustrations, no extra plugins, no "filming locations" feature
- Anything else goes in `LATER.md`, not in the code

## Movements
Spanish Colonial Revival, Craftsman, Mid-Century Modern (Southern California); Pueblo Revival (New Mexico); Beaux-Arts, Art Deco (New York); Creole & Shotgun (New Orleans); Chicago School (Chicago).
Source data lives in `data/movements.json`.

## Coding standards
- Follow WordPress Coding Standards
- Escape all output (`esc_html`, `esc_attr`, `esc_url`, `wp_kses_post`)
- Sanitize and validate all input
- Prefix functions and hooks with `atlas_`; text domain is `atlas`
- Enqueue scripts and styles properly, never hardcode them
- Use `theme.json` for colors, typography, and spacing. No inline styles.
- Accessible by default (WCAG 2.2 AA): semantic HTML, alt text, visible focus states

## Images
- No scraped photos and no show stills. Wikimedia Commons only.
- Every image needs an ACF field for license and attribution.

## Workflow rules
- Work only inside this theme folder
- Plan first. Show the plan and wait for my approval before building.
- One task per commit, with a clear message. Never commit or push without asking.
- Explain any non-obvious code. I must be able to explain it back.
- I choose the color palettes. You implement them.
- If my request conflicts with these rules or with best practice, say so before doing it.
