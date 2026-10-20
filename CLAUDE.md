# Architecture Atlas

A personal atlas of 8 American architecture movements, built as a classic PHP WordPress theme. This is a learning project for working with AI agents. Keep scope small.

## How we work

- You can write and edit code, one task at a time. Wait for my approval of each edit.
- Keep every task small, and stop after each one so I can review.
- Write classic PHP theme code and explain it in classic WordPress terms.
- After each task, summarize what you changed in 3 bullets.
- Explain in classic WordPress terms (header.php, template hierarchy, the Loop).
- If my code conflicts with best practice, say so and explain why.

## Stack

- Classic PHP theme, plain CSS in style.css (no theme.json yet)
- ACF free for custom fields
- Later: one React feature, built as a custom block
- Local by Flywheel, PHP 8.2+

## Scope limits

- 3 CPTs: Movement, Building, Architect
- 1 taxonomy: Place (Southern California, New York, New Orleans, Chicago, New Mexico)
- 8 movements: Spanish Colonial Revival, Craftsman, Mid-Century Modern, Pueblo Revival, Beaux-Arts, Art Deco, Creole & Shotgun, Chicago School
- Anything else goes in LATER.md

## Coding standards

- WordPress Coding Standards
- Escape all output, sanitize all input
- Prefix functions with atlas\_, text domain is atlas
- Enqueue styles and scripts, never hardcode them
- Accessible by default (WCAG 2.2 AA)

## Images

- Wikimedia Commons only, with license and attribution stored per image
