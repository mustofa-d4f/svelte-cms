<script module lang="ts">
    import PublicLayout from '@/layouts/PublicLayout.svelte';

    export const layout = PublicLayout;
</script>

<script lang="ts">
    import { Link } from '@inertiajs/svelte';
    import { Calendar, Eye, ArrowLeft, BookOpen, User } from 'lucide-svelte';
    import AppHead from '@/components/AppHead.svelte';
    import { Card, CardContent } from '@/components/ui/card';
    import { archive } from '@/routes';
    import { show } from '@/routes/posts';

    let { post, relatedPosts }: { post: any; relatedPosts: any[] } = $props();

    function formatDate(date: string) {
        return new Date(date).toLocaleDateString('id-ID', {
            day: 'numeric',
            month: 'long',
            year: 'numeric',
        });
    }
</script>

<AppHead
    title={post.meta_title || post.title}
    description={post.meta_description || post.excerpt}
    image={post.featured_image}
    url={`/artikel/${post.slug}`}
/>

<article class="mx-auto max-w-4xl px-4 py-12">
    <Link href={archive.url()} class="mb-8 inline-flex items-center text-sm text-muted-foreground hover:text-primary">
        <ArrowLeft class="mr-2 h-4 w-4" /> Kembali ke Arsip
    </Link>

    <header class="mb-8 space-y-4">
        {#if post.category}
            <Link
                href={archive.url({ category: post.category_id })}
                class="inline-block rounded-full bg-primary/10 px-3 py-1 text-xs font-medium text-primary hover:bg-primary/20"
            >
                {post.category.name}
            </Link>
        {/if}

        <h1 class="text-3xl font-bold leading-tight md:text-4xl">{post.title}</h1>

        <div class="flex flex-wrap items-center gap-4 text-sm text-muted-foreground">
            <span class="flex items-center gap-1.5">
                <User class="h-4 w-4" />
                {post.author?.name ?? 'Admin'}
            </span>
            <span class="flex items-center gap-1.5">
                <Calendar class="h-4 w-4" />
                {formatDate(post.published_at)}
            </span>
            <span class="flex items-center gap-1.5">
                <Eye class="h-4 w-4" />
                {post.views} views
            </span>
        </div>
    </header>

    {#if post.featured_image}
        <div class="mb-8 overflow-hidden rounded-xl">
            <img
                src={post.featured_image}
                alt={post.title}
                class="aspect-video w-full object-cover"
            />
        </div>
    {/if}

    {#if post.tags?.length > 0}
        <div class="mb-8 flex flex-wrap gap-2">
            {#each post.tags as tag}
                <Link
                    href={archive.url({ tag: tag.id })}
                    class="rounded-full border px-3 py-1 text-xs text-muted-foreground hover:bg-muted"
                >
                    #{tag.name}
                </Link>
            {/each}
        </div>
    {/if}

    <div class="prose prose-neutral dark:prose-invert max-w-none">
        {@html post.content}
    </div>

    {#if relatedPosts.length > 0}
        <section class="mt-16 border-t pt-8">
            <h2 class="mb-6 text-2xl font-bold">Artikel Terkait</h2>
            <div class="grid gap-6 md:grid-cols-3">
                {#each relatedPosts as related}
                    <Link href={show.url(related.slug)} class="group">
                        <Card class="h-full transition-shadow hover:shadow-md">
                            {#if related.featured_image}
                                <div class="aspect-video overflow-hidden rounded-t-xl">
                                    <img
                                        src={related.featured_image}
                                        alt={related.title}
                                        class="h-full w-full object-cover transition-transform group-hover:scale-105"
                                    />
                                </div>
                            {:else}
                                <div class="flex aspect-video items-center justify-center rounded-t-xl bg-gradient-to-br from-primary/10 to-primary/5">
                                    <BookOpen class="h-8 w-8 text-primary/30" />
                                </div>
                            {/if}
                            <CardContent class="space-y-2">
                                <h3 class="line-clamp-2 font-semibold group-hover:text-primary">{related.title}</h3>
                                <p class="text-xs text-muted-foreground">{formatDate(related.published_at)}</p>
                            </CardContent>
                        </Card>
                    </Link>
                {/each}
            </div>
        </section>
    {/if}
</article>
