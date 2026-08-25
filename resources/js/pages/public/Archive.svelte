<script module lang="ts">
    import PublicLayout from '@/layouts/PublicLayout.svelte';

    export const layout = PublicLayout;
</script>

<script lang="ts">
    import { Link, router } from '@inertiajs/svelte';
    import { BookOpen, Calendar, Eye, Search } from 'lucide-svelte';
    import AppHead from '@/components/AppHead.svelte';
    import { Button } from '@/components/ui/button';
    import { Card, CardContent } from '@/components/ui/card';
    import { Input } from '@/components/ui/input';
    import { archive } from '@/routes';
    import { show } from '@/routes/posts';

    let { posts, categories, tags, filters }: { posts: any; categories: any[]; tags: any[]; filters: any } = $props();

    let search = $state(filters?.search ?? '');
    let selectedCategory = $state(filters?.category ?? '');
    let selectedTag = $state(filters?.tag ?? '');

    function applyFilters() {
        const params: Record<string, string> = {};

        if (search) {
params.search = search;
}

        if (selectedCategory) {
params.category = selectedCategory;
}

        if (selectedTag) {
params.tag = selectedTag;
}

        router.get(archive.url(params), {}, { preserveState: true, replace: true });
    }

    function formatDate(date: string) {
        return new Date(date).toLocaleDateString('id-ID', {
            day: 'numeric',
            month: 'long',
            year: 'numeric',
        });
    }
</script>

<AppHead title="Arsip Artikel" />

<div class="mx-auto max-w-6xl px-4 py-12">
    <h1 class="mb-8 text-3xl font-bold">Arsip Artikel</h1>

    <div class="mb-8 grid gap-4 md:grid-cols-4">
        <div class="md:col-span-2">
            <form onsubmit={(e) => {
 e.preventDefault(); applyFilters(); 
}} class="flex gap-2">
                <Input bind:value={search} placeholder="Cari artikel..." class="flex-1" />
                <Button type="submit" variant="secondary"><Search class="mr-2 h-4 w-4" /> Cari</Button>
            </form>
        </div>
        <div>
            <select
                bind:value={selectedCategory}
                onchange={applyFilters}
                class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm"
            >
                <option value="">Semua Kategori</option>
                {#each categories as cat (cat.id)}
                    <option value={cat.id}>{cat.name}</option>
                {/each}
            </select>
        </div>
        <div>
            <select
                bind:value={selectedTag}
                onchange={applyFilters}
                class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm"
            >
                <option value="">Semua Tag</option>
                {#each tags as tag (tag.id)}
                    <option value={tag.id}>{tag.name}</option>
                {/each}
            </select>
        </div>
    </div>

    {#if posts.data.length === 0}
        <Card>
            <CardContent class="py-12 text-center">
                <BookOpen class="mx-auto mb-4 h-12 w-12 text-muted-foreground" />
                <p class="text-muted-foreground">Tidak ada artikel yang ditemukan.</p>
            </CardContent>
        </Card>
    {:else}
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            {#each posts.data as post (post.id)}
                <Link href={show.url(post.slug)} class="group">
                    <Card class="h-full transition-shadow hover:shadow-md">
                        {#if post.featured_image}
                            <div class="aspect-video overflow-hidden rounded-t-xl">
                                <img
                                    src={post.featured_image}
                                    alt={post.title}
                                    class="h-full w-full object-cover transition-transform group-hover:scale-105"
                                />
                            </div>
                        {:else}
                            <div class="flex aspect-video items-center justify-center rounded-t-xl bg-gradient-to-br from-primary/10 to-primary/5">
                                <BookOpen class="h-12 w-12 text-primary/30" />
                            </div>
                        {/if}
                        <CardContent class="space-y-3">
                            {#if post.category}
                                <span class="inline-block rounded-full bg-primary/10 px-2.5 py-0.5 text-xs font-medium text-primary">
                                    {post.category.name}
                                </span>
                            {/if}
                            <h3 class="line-clamp-2 font-semibold group-hover:text-primary">{post.title}</h3>
                            {#if post.excerpt}
                                <p class="line-clamp-2 text-sm text-muted-foreground">{post.excerpt}</p>
                            {/if}
                            <div class="flex items-center gap-4 text-xs text-muted-foreground">
                                <span class="flex items-center gap-1">
                                    <Calendar class="h-3 w-3" />
                                    {formatDate(post.published_at)}
                                </span>
                                <span class="flex items-center gap-1">
                                    <Eye class="h-3 w-3" />
                                    {post.views} views
                                </span>
                            </div>
                        </CardContent>
                    </Card>
                </Link>
            {/each}
        </div>

        {#if posts.last_page > 1}
            <div class="mt-8 flex justify-center gap-2">
                {#each Array.from({ length: posts.last_page }, (_, i) => i + 1) as page (page)}
                    <Button
                        variant={page === posts.current_page ? 'default' : 'outline'}
                        size="sm"
                        href={archive.url({ page, search, category: selectedCategory, tag: selectedTag })}
                    >
                        {page}
                    </Button>
                {/each}
            </div>
        {/if}
    {/if}
</div>
