<script module lang="ts">
    export const layout = {
        breadcrumbs: [
            { title: 'Dashboard', href: '/dashboard' },
            { title: 'Tag', href: '/admin/tags' },
        ],
    };
</script>

<script lang="ts">
    import { router } from '@inertiajs/svelte';
    import { Plus, Trash2, X, Check } from 'lucide-svelte';
    import AppHead from '@/components/AppHead.svelte';
    import { Button } from '@/components/ui/button';
    import { Card, CardContent } from '@/components/ui/card';
    import { Input } from '@/components/ui/input';
    import { store, destroy } from '@/routes/admin/tags';

    let { tags }: { tags: any } = $props();

    let showForm = $state(false);
    let formName = $state('');

    function submitForm(e: Event) {
        e.preventDefault();
        router.post(store.url(), { name: formName }, {
            onSuccess: () => {
 formName = ''; showForm = false; 
},
        });
    }

    function deleteTag(id: number) {
        if (confirm('Yakin ingin menghapus tag ini?')) {
            router.delete(destroy.url(id));
        }
    }
</script>

<AppHead title="Kelola Tag" />

<div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold">Tag</h1>
        <Button onclick={() => {
 formName = ''; showForm = true; 
}}>
            <Plus class="mr-2 h-4 w-4" /> Tag Baru
        </Button>
    </div>

    {#if showForm}
        <Card>
            <CardContent class="pt-6">
                <form onsubmit={submitForm} class="flex gap-2">
                    <Input bind:value={formName} placeholder="Nama tag" class="max-w-sm" />
                    <Button type="submit"><Check class="mr-2 h-4 w-4" /> Simpan</Button>
                    <Button type="button" variant="outline" onclick={() => showForm = false}><X class="mr-2 h-4 w-4" /> Batal</Button>
                </form>
            </CardContent>
        </Card>
    {/if}

    <Card>
        <CardContent class="pt-6">
            {#if tags.data.length === 0}
                <p class="text-sm text-muted-foreground text-center py-8">Belum ada tag.</p>
            {:else}
                <div class="flex flex-wrap gap-2">
                    {#each tags.data as tag}
                        <div class="inline-flex items-center gap-2 rounded-full border px-3 py-1.5 text-sm">
                            <span>{tag.name}</span>
                            <span class="text-xs text-muted-foreground">({tag.posts_count ?? 0})</span>
                            <button
                                class="ml-1 text-destructive hover:text-destructive/80"
                                onclick={() => deleteTag(tag.id)}
                            >
                                <Trash2 class="h-3 w-3" />
                            </button>
                        </div>
                    {/each}
                </div>
            {/if}
        </CardContent>
    </Card>
</div>
