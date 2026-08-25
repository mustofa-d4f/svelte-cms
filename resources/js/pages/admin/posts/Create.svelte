<script module lang="ts">
    export const layout = {
        breadcrumbs: [
            { title: 'Dashboard', href: '/dashboard' },
            { title: 'Artikel', href: '/admin/posts' },
            { title: 'Buat Baru', href: '#' },
        ],
    };
</script>

<script lang="ts">
    import { useForm } from '@inertiajs/svelte';
    import AppHead from '@/components/AppHead.svelte';
    import MediaPicker from '@/components/MediaPicker.svelte';
    import TipTapEditor from '@/components/TipTapEditor.svelte';
    import { Button } from '@/components/ui/button';
    import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
    import { Input } from '@/components/ui/input';
    import { Label } from '@/components/ui/label';
    import { index, store } from '@/routes/admin/posts';

    let { categories, tags }: { categories: any[]; tags: any[] } = $props();

    let showMediaPicker = $state(false);
    let mediaTarget = $state<'featured' | 'content'>('featured');

    let form = useForm({
        title: '',
        slug: '',
        category_id: '',
        content: '',
        excerpt: '',
        featured_image: '',
        status: 'draft',
        published_at: '',
        tags: [],
        meta_title: '',
        meta_description: '',
    });

    function submit(e: Event) {
        e.preventDefault();
        form.post(store.url());
    }

    function openMediaPicker(target: 'featured' | 'content') {
        mediaTarget = target;
        showMediaPicker = true;
    }

    function handleMediaSelect(url: string) {
        if (mediaTarget === 'featured') {
            form.featured_image = url;
        }

        showMediaPicker = false;
    }

    function autoSlug() {
        if (!form.slug && form.title) {
            form.slug = form.title
                .toLowerCase()
                .replace(/[^a-z0-9]+/g, '-')
                .replace(/^-|-$/g, '');
        }
    }
</script>

<AppHead title="Buat Artikel Baru" />
<MediaPicker bind:open={showMediaPicker} onSelect={handleMediaSelect} />

<div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold">Buat Artikel Baru</h1>
        <Button variant="outline" href={index.url()}>Kembali</Button>
    </div>

    <form onsubmit={submit}>
        <div class="grid gap-6 md:grid-cols-3">
            <div class="md:col-span-2 space-y-6">
                <Card>
                    <CardHeader>
                        <CardTitle>Konten</CardTitle>
                    </CardHeader>
                    <CardContent class="space-y-4">
                        <div class="space-y-2">
                            <Label for="title">Judul</Label>
                            <Input id="title" bind:value={form.title} placeholder="Judul artikel" onblur={autoSlug} />
                            {#if form.errors.title}
                                <p class="text-sm text-destructive">{form.errors.title}</p>
                            {/if}
                        </div>
                        <div class="space-y-2">
                            <Label for="slug">Slug (URL)</Label>
                            <Input id="slug" bind:value={form.slug} placeholder="otomatis dari judul" />
                            {#if form.errors.slug}
                                <p class="text-sm text-destructive">{form.errors.slug}</p>
                            {/if}
                        </div>
                        <div class="space-y-2">
                            <Label for="excerpt">Ringkasan</Label>
                            <textarea
                                id="excerpt"
                                bind:value={form.excerpt}
                                class="flex min-h-[80px] w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2"
                                placeholder="Ringkasan singkat artikel"
                            ></textarea>
                        </div>
                        <div class="space-y-2">
                            <Label for="content">Konten</Label>
                            <TipTapEditor bind:content={form.content} onImagePicker={() => openMediaPicker('content')} />
                            {#if form.errors.content}
                                <p class="text-sm text-destructive">{form.errors.content}</p>
                            {/if}
                        </div>
                    </CardContent>
                </Card>

                <Card>
                    <CardHeader>
                        <CardTitle>SEO</CardTitle>
                    </CardHeader>
                    <CardContent class="space-y-4">
                        <div class="space-y-2">
                            <Label for="meta_title">Meta Title</Label>
                            <Input id="meta_title" bind:value={form.meta_title} placeholder="Judul untuk mesin pencari" />
                            <p class="text-xs text-muted-foreground">Kosongkan = menggunakan judul artikel</p>
                        </div>
                        <div class="space-y-2">
                            <Label for="meta_description">Meta Description</Label>
                            <textarea
                                id="meta_description"
                                bind:value={form.meta_description}
                                class="flex min-h-[60px] w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2"
                                placeholder="Deskripsi untuk mesin pencari (max 160 karakter)"
                            ></textarea>
                        </div>
                    </CardContent>
                </Card>
            </div>

            <div class="space-y-6">
                <Card>
                    <CardHeader>
                        <CardTitle>Pengaturan</CardTitle>
                    </CardHeader>
                    <CardContent class="space-y-4">
                        <div class="space-y-2">
                            <Label for="status">Status</Label>
                            <select
                                id="status"
                                bind:value={form.status}
                                class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring"
                            >
                                <option value="draft">Draft</option>
                                <option value="published">Dipublikasikan</option>
                                <option value="archived">Diarsipkan</option>
                            </select>
                        </div>
                        <div class="space-y-2">
                            <Label for="category_id">Kategori</Label>
                            <select
                                id="category_id"
                                bind:value={form.category_id}
                                class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring"
                            >
                                <option value="">Pilih Kategori</option>
                                {#each categories as cat (cat.id)}
                                    <option value={cat.id}>{cat.name}</option>
                                {/each}
                            </select>
                        </div>
                        <div class="space-y-2">
                            <Label for="published_at">Tanggal Publikasi</Label>
                            <Input id="published_at" type="datetime-local" bind:value={form.published_at} />
                        </div>
                        <div class="space-y-2">
                            <Label>Gambar Utama</Label>
                            {#if form.featured_image}
                                <div class="relative">
                                    <img src={form.featured_image} alt="Featured" class="w-full rounded-md object-cover" />
                                    <Button
                                        type="button"
                                        variant="destructive"
                                        size="icon"
                                        class="absolute right-1 top-1 h-6 w-6"
                                        onclick={() => form.featured_image = ''}
                                    >
                                        ×
                                    </Button>
                                </div>
                            {/if}
                            <Button type="button" variant="outline" size="sm" class="w-full" onclick={() => openMediaPicker('featured')}>
                                {#if form.featured_image}Ganti Gambar{:else}Pilih Gambar{/if}
                            </Button>
                        </div>
                        <div class="space-y-2">
                            <Label>Tag</Label>
                            <div class="flex flex-wrap gap-2">
                                {#each tags as tag (tag.id)}
                                    <label class="flex items-center gap-1 text-sm">
                                        <input
                                            type="checkbox"
                                            value={tag.id}
                                            checked={form.tags.includes(tag.id)}
                                            onchange={(e) => {
                                                const target = e.target as HTMLInputElement;

                                                if (target.checked) {
                                                    form.tags = [...form.tags, tag.id];
                                                } else {
                                                    form.tags = form.tags.filter((id: number) => id !== tag.id);
                                                }
                                            }}
                                        />
                                        {tag.name}
                                    </label>
                                {/each}
                            </div>
                        </div>
                    </CardContent>
                </Card>

                <Button type="submit" class="w-full" disabled={form.processing}>
                    {form.processing ? 'Menyimpan...' : 'Simpan Artikel'}
                </Button>
            </div>
        </div>
    </form>
</div>
