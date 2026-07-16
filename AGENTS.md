# AI Agent Guidelines

AI agents rely on this file (AGENTS.md) to understand the project and work effectively.

## AI Agent Instructions

- Never run destructive file system operations (rm -rf, del /F /Q *, git push --force, etc.) without explicit confirmation
- Never commit to git unless explicitly instructed
- Always respond succinctly and directly, without flattery, and with a large vocabulary when appropriate.
- Always think before coding: Explicitly state assumptions, surface ambiguities and tradeoffs, prefer simpler approaches, and ask questions instead of guessing.
- Always use format `yyyy-mm-dd-[short-description].md` for new markdown files if the user does not specify a name.
- Prefer safe, reversible, non-destructive actions by default
- Prefer simplicity first: Write only the minimal code needed—no extra features, abstractions, or speculative handling.
- Prefer surgical changes: Modify only what’s required, match existing style, and avoid unrelated refactoring or cleanup.
- Prefer long variable names for clarity (e.g. `$createdOnMax` instead of `$cMax`)
- You have unlimited search capabilites so use it if you're not sure about something. Do not rely on your own training data even if you are sure when asked to do web search.

## Project Overview

This is a **monorepo of independent, self-contained one-page websites** (mostly demo/prototype sites for barbershops, sushi restaurants, CRMs, an image bookmark manager, etc.), each generated with a different AI coding tool (Gemini CLI, RooCode, Google Stitch, Kilo, opencode) as an experiment. There is **no shared build system, no shared dependencies, and no shared routing** between subfolders — each top-level directory is its own micro-project with its own stack (static HTML/CSS/JS, PHP flat-file backend, or Vite/Vue). Root `index.php` is just a placeholder ("Hello World!"); it is not an entry point for any subproject.

## Requirements

- No global package manager, framework, or test suite applies to the whole repo.
- Each subfolder may use its own stack (plain HTML/CSS/JS, PHP + Composer, or Vite/Vue/Vuetify).
- Treat every top-level folder as an isolated project — never assume conventions from one subfolder apply to another unless it was copied from `0template`.

## Working on a Subproject

- **Always `cd` into the subfolder first.** Commands, dependencies, and `.env` files are scoped per-project (e.g. `simpleprompts/.env.example`, `adminv1/.env.example`, `adminv2/.env.example`).
- `0template/` and `0template-old/` are boilerplate folders used to scaffold brand-new one-pager projects — when asked to create a new site, copy the structure/AGENTS rules from `0template/` rather than inventing a new convention.
- Folders with `AGENTS-plan.md` (e.g. `barber2`, `crm1`, `crm2`, `sushi6fromreference`, `sushi7roocode`, `sushi8googlestitch`) were built in **Gemini CLI "Plan Mode"**: expect `README.md`, `Requirements.md`, `Tasks.md` as the canonical docs for that project's scope.
- Sites named `<theme><n>` (e.g. `sushi1`…`sushi8vitekilo`, `barber1`/`barber2`, `crm1`/`crm2`) are **successive redo attempts of the same brief using a different AI tool/stack** — the number/suffix indicates the tool used, not a version upgrade. Don't merge or "fix up" one variant to match another.
- Some folders replicate a reference design supplied as an image/HTML file (`reference.jpeg`, `reference.html` in `clone1`; `sushi-reference-1.png` in `sushi6fromreference`/`sushi7roocode`; `restaurant-inspiration.jpeg` in `sushi8googlestitch`). If a reference asset exists, the task is to visually match it — `sushi7roocode/failed-instruction-did-not-used-reference.html` is kept intentionally as an example of a **failed attempt that ignored the reference image**; do not delete it, and do not repeat that mistake.

## Install / Run Commands (non-standard, per subproject)

- **PHP + Composer projects** (`adminv1`, `simpleprompts/api`): run `composer install` inside that exact subfolder (not the repo root — there is no root `composer.json`).
- **`sushi8vitekilo`**: the actual app lives under `sushi8vitekilo/frontend/`, not the project root. Run `cd sushi8vitekilo/frontend && npm install && npm run dev` (Vite dev server on `http://localhost:5173/`).
- **`simpleprompts`**: Vite + Vue3 + Vuetify frontend (`npm run dev` / `build` / `preview` from `simpleprompts/`) plus a separate PHP API in `simpleprompts/api/prompts.php` that queries a **Notion database** via `NOTION_API_SECRET` / `NOTION_DATASOURCE_ID` env vars — the frontend calls it via `VITE_PHP_API_URL` in `.env`.
- **Static sites** (`sushi2`–`sushi5`, `barber1`/`barber2`, `crm1`/`crm2`, `clone1`, etc.): just open `index.html` directly; several use Tailwind/Font Awesome via CDN only (no build step, no `node_modules`).
- Root `.htaccess` rewrites `/admin` → `adminv1/public/index.php` and `/admin2` → `adminv2/public/index.php`. These are the only two subprojects reachable through the repo root when served over Apache; all other subfolders are accessed directly by path.

## Code Style / Backend Pattern (PHP flat-file sites)

- PHP admin backends (`adminv1`, `adminv2`, `sushi1/save-config.php`, `bookmark1/save-bookmarks.php`, `verdant1/admin/save-config.php`) have **no database** — they read/write a JSON file directly via `file_get_contents`/`file_put_contents` (`site.json`, `site-config.json`, `bookmarks-data.json`). Always back up/copy the JSON before editing its writer logic; a bug here corrupts the site's only data store.
- `adminv1` converts nested JSON to flat form fields and back via `Helper::Flatten()` / `Helper::Deflatten()` (double-underscore `__` as the path separator, e.g. `realisations__0__title`). Reuse this helper pattern instead of writing new (de)serialization logic if extending that admin.
- `adminv1` and `simpleprompts/api` load env vars via `vlucas/phpdotenv` (Composer). `adminv2` instead has its own hand-rolled `Helper::LoadEnv()` parser and no Composer dependency at all — do not add `vlucas/phpdotenv` to `adminv2` without discussing it; the two admin variants are intentionally implemented differently.
- Password checks in these admin panels are simple string comparisons against `$_ENV["PASSWORD"]` (`adminv1`) or a session-based login (`adminv2`) — there is no hashing, rate limiting, or CSRF protection. Do not present these as secure patterns to replicate elsewhere without flagging it.
- `bookmark1/save-bookmarks.php` has **no authentication at all** on its POST endpoint — anyone who can reach the URL can overwrite `bookmarks-data.json`. Flag this if asked to harden it.

## Project Structure

| Path | Purpose |
|---|---|
| `0template/`, `0template-old/` | Boilerplate to scaffold a new one-pager subproject |
| `adminv1/`, `adminv2/` | PHP flat-file admin panels (password-gated JSON editors), reachable via root `.htaccess` as `/admin` and `/admin2` |
| `simpleprompts/` | Vite+Vue+Vuetify app with a PHP API (`api/`) that proxies a Notion database |
| `sushi8vitekilo/frontend/` | Only subproject using a modern JS framework build (Vite/Vue3/Vuetify); real app code is one level deeper than the project folder |
| `sushi1`, `sushi-kimi-php1`, `verdant1`, `bookmark1`, `sushi6fromreference` | Static frontend + PHP flat-file admin/save endpoint pairs |
| `sushi2`–`sushi5`, `barber1`, `crm1`, `crm2`, `clone1` | Pure static HTML/CSS/JS demos, no backend, no build step |
| `barbershopwptheme/` | WordPress theme (PHP template files: `header.php`, `footer.php`, `functions.php`, `template-parts/`) — different rules from the flat-file sites (uses WP template hierarchy/hooks) |
| `.agents/skills/` | Reusable agent skills (this repo's tooling, unrelated to the one-pager sites themselves) |
| `*.code-workspace` files | Per-project VS Code workspace scoping — open the specific one for the subfolder you're working in, not the root one, when possible |

## Restricted Files

MUST NOT be read, edited, or committed — these hold secrets or are per-environment:
- Every `.env` in every subfolder (e.g. `adminv1/.env`, `adminv2/.env`, `simpleprompts/.env`, `simpleprompts/api/.env`) — only the `*.env.example` templates are safe to read/edit.
- `**/vendor/` (Composer dependencies, gitignored).

**Gotcha:** the root `.gitignore` lists `public/config.json`, `public/site.json`, `public/user.json`, but those patterns only match a literal `public/site.json` at the repo root, so they do **not** actually exclude nested files like `adminv1/public/site.json` or `verdant1/admin/config/site.json` — those live-data JSON files ARE tracked in git. Don't assume they're ignored/safe scratch space; treat edits to them as real content changes.
