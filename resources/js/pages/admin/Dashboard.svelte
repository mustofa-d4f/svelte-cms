<script module lang="ts">
    export const layout = {
        breadcrumbs: [
            {
                title: 'Dashboard',
                href: '/dashboard',
            },
        ],
    };
</script>

<script lang="ts">
    import AppHead from '@/components/AppHead.svelte';
    import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';

    let { stats, recent_posts }: { stats: any; recent_posts: any[] } = $props();
</script>

<AppHead title="Dashboard Admin" />

<div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
    <div class="grid auto-rows-min gap-4 md:grid-cols-4">
        <Card>
            <CardHeader class="pb-2">
                <CardTitle class="text-sm font-medium text-muted-foreground">Total Artikel</CardTitle>
            </CardHeader>
            <CardContent>
                <div class="text-2xl font-bold">{stats.total_posts}</div>
            </CardContent>
        </Card>
        <Card>
            <CardHeader class="pb-2">
                <CardTitle class="text-sm font-medium text-muted-foreground">Dipublikasikan</CardTitle>
            </CardHeader>
            <CardContent>
                <div class="text-2xl font-bold text-green-600">{stats.published_posts}</div>
            </CardContent>
        </Card>
        <Card>
            <CardHeader class="pb-2">
                <CardTitle class="text-sm font-medium text-muted-foreground">Draft</CardTitle>
            </CardHeader>
            <CardContent>
                <div class="text-2xl font-bold text-yellow-600">{stats.draft_posts}</div>
            </CardContent>
        </Card>
        <Card>
            <CardHeader class="pb-2">
                <CardTitle class="text-sm font-medium text-muted-foreground">Kategori</CardTitle>
            </CardHeader>
            <CardContent>
                <div class="text-2xl font-bold">{stats.total_categories}</div>
            </CardContent>
        </Card>
    </div>

    <Card>
        <CardHeader>
            <CardTitle>Artikel Terbaru</CardTitle>
        </CardHeader>
        <CardContent>
            {#if recent_posts.length === 0}
                <p class="text-sm text-muted-foreground">Belum ada artikel.</p>
            {:else}
                <div class="space-y-3">
                    {#each recent_posts as post}
                        <div class="flex items-center justify-between border-b pb-2">
                            <div>
                                <p class="font-medium">{post.title}</p>
                                <p class="text-xs text-muted-foreground">
                                    oleh {post.author?.name ?? '-'} | {post.category?.name ?? 'Tanpa Kategori'}
                                </p>
                            </div>
                            <span
                                class="inline-flex items-center rounded-full px-2 py-1 text-xs font-medium
                                {post.status === 'published'
                                    ? 'bg-green-100 text-green-700'
                                    : post.status === 'draft'
                                        ? 'bg-yellow-100 text-yellow-700'
                                        : 'bg-gray-100 text-gray-700'}"
                            >
                                {post.status}
                            </span>
                        </div>
                    {/each}
                </div>
            {/if}
        </CardContent>
    </Card>
</div>
