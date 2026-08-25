<script module lang="ts">
    export const layout = {
        breadcrumbs: [
            { title: 'Dashboard', href: '/dashboard' },
            { title: 'Kategori', href: '/admin/categories' },
        ],
    };
</script>

<script lang="ts">
    import { router } from '@inertiajs/svelte';
    import { Plus, Pencil, Trash2, X, Check } from 'lucide-svelte';
    import AppHead from '@/components/AppHead.svelte';
    import { Button } from '@/components/ui/button';
    import { Card, CardContent } from '@/components/ui/card';
    import { Input } from '@/components/ui/input';
    import { Label } from '@/components/ui/label';
    import { store, update, destroy } from '@/routes/admin/categories';

    let { categories }: { categories: any } = $props();

    let showForm = $state(false);
    let editingId = $state<number | null>(null);
    let formName = $state('');
    let formSlug = $state('');
    let formDescription = $state('');
    let formParentId = $state<number | null>(null);

    function resetForm() {
        formName = '';
        formSlug = '';
        formDescription = '';
        formParentId = null;
        editingId = null;
        showForm = false;
    }

    function startEdit(cat: any) {
        editingId = cat.id;
        formName = cat.name;
        formSlug = cat.slug;
        formDescription = cat.description ?? '';
        formParentId = cat.parent_id;
        showForm = true;
    }

    function submitForm(e: Event) {
        e.preventDefault();
        const data = {
            name: formName,
            slug: formSlug,
            description: formDescription,
            parent_id: formParentId,
        };

        if (editingId) {
            router.put(update.url(editingId), data, { onSuccess: resetForm });
        } else {
            router.post(store.url(), data, { onSuccess: resetForm });
        }
    }

    function deleteCategory(id: number) {
        if (confirm('Yakin ingin menghapus kategori ini?')) {
            router.delete(destroy.url(id));
        }
    }
</script>

<AppHead title="Kelola Kategori" />

<div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold">Kategori</h1>
        <Button onclick={() => {
 resetForm(); showForm = true; 
}}>
            <Plus class="mr-2 h-4 w-4" /> Kategori Baru
        </Button>
    </div>

    {#if showForm}
        <Card>
            <CardContent class="pt-6">
                <form onsubmit={submitForm} class="space-y-4">
                    <h3 class="font-semibold">{editingId ? 'Edit Kategori' : 'Kategori Baru'}</h3>
                    <div class="grid gap-4 md:grid-cols-2">
                        <div class="space-y-2">
                            <Label for="name">Nama</Label>
                            <Input id="name" bind:value={formName} placeholder="Nama kategori" />
                        </div>
                        <div class="space-y-2">
                            <Label for="slug">Slug</Label>
                            <Input id="slug" bind:value={formSlug} placeholder="otomatis dari nama" />
                        </div>
                    </div>
                    <div class="space-y-2">
                        <Label for="description">Deskripsi</Label>
                        <Input id="description" bind:value={formDescription} placeholder="Deskripsi kategori" />
                    </div>
                    <div class="space-y-2">
                        <Label for="parent_id">Kategori Induk</Label>
                        <select
                            id="parent_id"
                            bind:value={formParentId}
                            class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm"
                        >
                            <option value={null}>Tidak ada (Root)</option>
                            {#each categories.data.filter((c: any) => !c.parent_id) as cat (cat.id)}
                                <option value={cat.id}>{cat.name}</option>
                            {/each}
                        </select>
                    </div>
                    <div class="flex gap-2">
                        <Button type="submit"><Check class="mr-2 h-4 w-4" /> {editingId ? 'Perbarui' : 'Simpan'}</Button>
                        <Button type="button" variant="outline" onclick={resetForm}><X class="mr-2 h-4 w-4" /> Batal</Button>
                    </div>
                </form>
            </CardContent>
        </Card>
    {/if}

    <Card>
        <CardContent class="pt-6">
            {#if categories.data.length === 0}
                <p class="text-sm text-muted-foreground text-center py-8">Belum ada kategori.</p>
            {:else}
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b">
                                <th class="pb-3 text-left font-medium">Nama</th>
                                <th class="pb-3 text-left font-medium">Slug</th>
                                <th class="pb-3 text-left font-medium">Induk</th>
                                <th class="pb-3 text-right font-medium">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            {#each categories.data as cat (cat.id)}
                                <tr class="border-b">
                                    <td class="py-3">
                                        <p class="font-medium">{cat.name}</p>
                                        {#if cat.description}
                                            <p class="text-xs text-muted-foreground">{cat.description}</p>
                                        {/if}
                                    </td>
                                    <td class="py-3 text-muted-foreground">{cat.slug}</td>
                                    <td class="py-3">{cat.parent?.name ?? '-'}</td>
                                    <td class="py-3 text-right">
                                        <div class="flex justify-end gap-1">
                                            <Button variant="ghost" size="icon" onclick={() => startEdit(cat)}>
                                                <Pencil class="h-4 w-4" />
                                            </Button>
                                            <Button variant="ghost" size="icon" onclick={() => deleteCategory(cat.id)}>
                                                <Trash2 class="h-4 w-4 text-destructive" />
                                            </Button>
                                        </div>
                                    </td>
                                </tr>
                            {/each}
                        </tbody>
                    </table>
                </div>
            {/if}
        </CardContent>
    </Card>
</div>
