---
paths:
  - '**/*.svelte'
---

# General

## Svelte file editing must use svelte-autofixer
When creating, editing, or reviewing any .svelte or .svelte.ts/.svelte.js file, MUST run svelte-autofixer via `npx @sveltejs/mcp svelte-autofixer <file>` to validate code before finalizing. Follow svelte-core-bestpractices: use $state only for reactive vars, prefer $derived over $effect, keyed each blocks, onclick not on:click, snippets not slots. Use `svelte-code-writer` and `inertia-svelte-development` skills for Svelte + Inertia patterns.
