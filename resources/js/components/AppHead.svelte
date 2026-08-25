<script lang="ts">
    import type { Snippet } from 'svelte';

    let {
        title = '',
        description = '',
        image = '',
        url = '',
        children,
    }: {
        title?: string;
        description?: string;
        image?: string;
        url?: string;
        children?: Snippet;
    } = $props();

    const appName = import.meta.env.VITE_APP_NAME || 'Laravel';
    const fullTitle = $derived(title ? `${title} - ${appName}` : appName);
    const appUrl = import.meta.env.VITE_APP_URL || 'http://localhost:8000';
    const fullUrl = $derived(url ? `${appUrl}${url}` : appUrl);
</script>

<svelte:head>
    <title>{fullTitle}</title>
    {#if description}
        <meta name="description" content={description} />
        <meta property="og:description" content={description} />
        <meta name="twitter:description" content={description} />
    {/if}
    <meta property="og:title" content={fullTitle} />
    <meta property="og:url" content={fullUrl} />
    <meta name="twitter:title" content={fullTitle} />
    {#if image}
        <meta property="og:image" content={image} />
        <meta name="twitter:image" content={image} />
        <meta name="twitter:card" content="summary_large_image" />
    {/if}
    <meta property="og:type" content="website" />
    {@render children?.()}
</svelte:head>
