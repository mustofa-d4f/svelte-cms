<script module lang="ts">
    export const layout = {
        breadcrumbs: [
            { title: 'Dashboard', href: '/dashboard' },
            { title: 'Artikel', href: '/admin/posts' },
        ],
    };
</script>

<script lang="ts">
    import { router, Link } from '@inertiajs/svelte';
    import { Plus, Search, Pencil, Trash2 } from 'lucide-svelte';
    import AppHead from '@/components/AppHead.svelte';
    import { Button } from '@/components/ui/button';
    import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
    import { Input } from '@/components/ui/input';
    import { index, create, edit, destroy } from '@/routes/admin/posts';

    let { posts, filters }: { posts: any; filters: any } = $props();

    let search = $state(filters?.search ?? '');
    let status = $state(filters?.status ?? '');

    function getPostStatus(post: any): string {
        if (post.status === 'draft') {
return 'draft';
}

        if (post.status === 'archived') {
return 'archived';
}

        if (post.status === 'published' && post.published_at && new Date(post.published_at) > new Date()) {
            return 'scheduled';
        }

        return 'published';
    }

    function getStatusLabel(post: any): string {
        const s = getPostStatus(post);
        const labels: Record<string, string> = {
            draft: 'Draft',
            published: 'Diterbitkan',
            scheduled: 'Terjadwal',
            archived: 'Diarsipkan',
        };

        return labels[s] ?? s;
    }

    function getStatusClass(post: any): string {
        const s = getPostStatus(post);
        const classes: Record<string, string> = {
            draft: 'bg-yellow-100 text-yellow-700',
            published: 'bg-green-100 text-green-700',
            scheduled: 'bg-blue-100 text-blue-700',
            archived: 'bg-gray-100 text-gray-700',
        };

        return classes[s] ?? '';
    }

    function applyFilters() {
        router.get(index.url({ search, status }), {}, { preserveState: true, replace: true });
    }

    function deletePost(id: number) {
        if (confirm('Yakin ingin menghapus artikel ini?')) {
            router.delete(destroy.url(id));
        }
    }
</script>

<AppHead title="Kelola Artikel" />

<div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold">Artikel</h1>
        <Button href={create.url()}>
            <Plus class="mr-2 h-4 w-4" /> Artikel Baru
        </Button>
    </div>

    <Card>
        <CardContent class="pt-6">
            <form onsubmit={(e) => {
 e.preventDefault(); applyFilters(); 
}} class="flex gap-2">
                <Input bind:value={search} placeholder="Cari artikel..." class="max-w-sm" />
                <select bind:value={status} class="rounded-md border border-input bg-background px-3 py-2 text-sm">
                    <option value="">Semua Status</option>
                    <option value="draft">Draft</option>
                    <option value="published">Diterbitkan</option>
                    <option value="scheduled">Terjadwal</option>
                    <option value="archived">Diarsipkan</option>
                </select>
                <Button type="submit" variant="secondary"><Search class="mr-2 h-4 w-4" /> Filter</Button>
            </form>
        </CardContent>
    </Card>

    <Card>
        <CardContent class="pt-6">
            {#if posts.data.length === 0}
                <p class="text-sm text-muted-foreground text-center py-8">Belum ada artikel.</p>
            {:else}
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b">
                                <th class="pb-3 text-left font-medium">Judul</th>
                                <th class="pb-3 text-left font-medium">Kategori</th>
                                <th class="pb-3 text-left font-medium">Status</th>
                                <th class="pb-3 text-left font-medium">Tanggal</th>
                                <th class="pb-3 text-right font-medium">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            {#each posts.data as post}
                                <tr class="border-b">
                                    <td class="py-3">
                                        <p class="font-medium">{post.title}</p>
                                        <p class="text-xs text-muted-foreground">oleh {post.author?.name ?? '-'}</p>
                                    </td>
                                    <td class="py-3">{post.category?.name ?? '-'}</td>
                                    <td class="py-3">
                                        <span class="inline-flex items-center rounded-full px-2 py-1 text-xs font-medium {getStatusClass(post)}">
                                            {getStatusLabel(post)}
                                        </span>
                                    </td>
                                    <td class="py-3 text-muted-foreground">
                                        {#if getPostStatus(post) === 'scheduled'}
                                            <span class="block text-xs text-blue-600">Terjadwal: {new Date(post.published_at).toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' })}</span>
                                        {:else}
                                            {new Date(post.created_at).toLocaleDateString('id-ID')}
                                        {/if}
                                    </td>
                                    <td class="py-3 text-right">
                                        <div class="flex justify-end gap-1">
                                            <Button variant="ghost" size="icon" href={edit.url(post.id)}>
                                                <Pencil class="h-4 w-4" />
                                            </Button>
                                            <Button variant="ghost" size="icon" onclick={() => deletePost(post.id)}>
                                                <Trash2 class="h-4 w-4 text-destructive" />
                                            </Button>
                                        </div>
                                    </td>
                                </tr>
                            {/each}
                        </tbody>
                    </table>
                </div>

                {#if posts.last_page > 1}
                    <div class="mt-4 flex justify-center gap-2">
                        {#each Array.from({ length: posts.last_page }, (_, i) => i + 1) as page}
                            <Button
                                variant={page === posts.current_page ? 'default' : 'outline'}
                                size="sm"
                                href={index.url({ page, search, status })}
                            >
                                {page}
                            </Button>
                        {/each}
                    </div>
                {/if}
            {/if}
        </CardContent>
    </Card>
</div>
