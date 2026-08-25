<script module lang="ts">
    export const layout = {
        breadcrumbs: [
            { title: 'Dashboard', href: '/dashboard' },
            { title: 'Kategori', href: '/admin/categories' },
            { title: 'Edit', href: '#' },
        ],
    };
</script>

<script lang="ts">
    import { useForm } from '@inertiajs/svelte';
    import AppHead from '@/components/AppHead.svelte';
    import { Button } from '@/components/ui/button';
    import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
    import { Input } from '@/components/ui/input';
    import { Label } from '@/components/ui/label';
    import { index, update } from '@/routes/admin/categories';

    let { category, parentCategories }: { category: any; parentCategories: any[] } = $props();

    let form = useForm({
        name: category.name ?? '',
        slug: category.slug ?? '',
        description: category.description ?? '',
        parent_id: category.parent_id ?? '',
    });

    function submit(e: Event) {
        e.preventDefault();
        form.put(update.url(category.id));
    }
</script>

<AppHead title="Edit Kategori" />

<div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold">Edit Kategori</h1>
        <Button variant="outline" href={index.url()}>Kembali</Button>
    </div>

    <Card class="max-w-2xl">
        <CardHeader>
            <CardTitle>Form Kategori</CardTitle>
        </CardHeader>
        <CardContent>
            <form onsubmit={submit} class="space-y-4">
                <div class="space-y-2">
                    <Label for="name">Nama</Label>
                    <Input id="name" bind:value={form.name} placeholder="Nama kategori" />
                    {#if form.errors.name}
                        <p class="text-sm text-destructive">{form.errors.name}</p>
                    {/if}
                </div>
                <div class="space-y-2">
                    <Label for="slug">Slug</Label>
                    <Input id="slug" bind:value={form.slug} placeholder="otomatis dari nama" />
                </div>
                <div class="space-y-2">
                    <Label for="description">Deskripsi</Label>
                    <Input id="description" bind:value={form.description} placeholder="Deskripsi kategori" />
                </div>
                <div class="space-y-2">
                    <Label for="parent_id">Kategori Induk</Label>
                    <select
                        id="parent_id"
                        bind:value={form.parent_id}
                        class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm"
                    >
                        <option value="">Tidak ada (Root)</option>
                        {#each parentCategories as cat (cat.id)}
                            <option value={cat.id}>{cat.name}</option>
                        {/each}
                    </select>
                </div>
                <Button type="submit" disabled={form.processing}>
                    {form.processing ? 'Menyimpan...' : 'Perbarui Kategori'}
                </Button>
            </form>
        </CardContent>
    </Card>
</div>
