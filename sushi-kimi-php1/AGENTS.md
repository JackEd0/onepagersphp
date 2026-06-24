# AI Agent Guidelines

AI agents rely on this file (AGENTS.md) to understand the project and work effectively.

## Rules

- Never run destructive file system operations (rm -rf, del /F /Q *, git push --force, etc.) without explicit confirmation
- Never commit to git unless explicitly instructed
- Always respond succinctly and directly, without flattery, and with a large vocabulary when appropriate.
- Always think before coding: Explicitly state assumptions, surface ambiguities and tradeoffs, prefer simpler approaches, and ask questions instead of guessing.
- Always use format `yyyy-mm-dd-[short-description].md` for new markdown files if the user does not specify a name.
- Prefer safe, reversible, non-destructive actions by default
- Prefer simplicity first: Write only the minimal code needed—no extra features, abstractions, or speculative handling.
- Prefer surgical changes: Modify only what’s required, match existing style, and avoid unrelated refactoring or cleanup.
- Prefer long variable names for clarity (e.g. `$createdOnMax` instead of `$cMax`)
- You have unlimited search capabilities so use it if you're not sure about something. Do not rely on your own training data even if you are sure when asked to do web search.
- Always use forward slashes (`/`) for directory paths in shell scripts, even on Windows. Backslashes (`\`) are strictly reserved for escaping characters.
- Always use the Context7 tools to fetch up-to-date documentation before doing code generation or configuration with external libraries. If not available, use the web search tool.
- Keep all documents and comments concise and actionable.

## Restricted Files

Files containing sensitive data MUST NOT be edited or committed:

- `python-scripts/.env`
- `*/.env` (any environment files in subdirectories)
- `.playwright-mcp/*.log`, `logs/*.log` (debug logs)
- `mcp.json` (MCP server configuration)
