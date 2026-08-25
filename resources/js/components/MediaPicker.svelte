<script lang="ts">
    import { router } from '@inertiajs/svelte';
    import { Upload, X, Search, Copy, ImageIcon } from 'lucide-svelte';
    import { Button } from '@/components/ui/button';
    import { Card, CardContent } from '@/components/ui/card';
    import { Input } from '@/components/ui/input';
    import { store as storeMedia } from '@/routes/admin/media';

    let {
        open = $bindable(false),
        onSelect,
    }: {
        open?: boolean;
        onSelect?: (url: string) => void;
    } = $props();

    let media = $state<any[]>([]);
    let search = $state('');
    let uploading = $state(false);
    let dragOver = $state(false);
    let fileInput = $state<HTMLInputElement>();

    async function loadMedia() {
        try {
            const params = search ? `?search=${encodeURIComponent(search)}` : '';
            const res = await fetch(`/admin/media${params}`);
            const html = await res.text();
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const script = doc.querySelector('script[data-page]');

            if (script) {
                const pageData = JSON.parse(script.textContent || '{}');
                media = pageData?.props?.media?.data ?? [];
            }
        } catch {
            media = [];
        }
    }

    async function handleUpload(e: Event) {
        const input = e.target as HTMLInputElement;
        const file = input?.files?.[0];

        if (!file) {
return;
}

        uploading = true;
        const formData = new FormData();
        formData.append('file', file);

        try {
            const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            const res = await fetch('/admin/media', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-XSRF-TOKEN': decodeURIComponent(
                        document.cookie.match(/XSRF-TOKEN=([^;]+)/)?.[1] ?? ''
                    ),
                },
                body: formData,
            });

            if (res.ok) {
                const newMedia = await res.json();
                media = [newMedia, ...media];

                if (onSelect) {
onSelect(`/storage/${newMedia.path}`);
}
            }
        } catch (err) {
            console.error('Upload failed:', err);
        } finally {
            uploading = false;

            if (fileInput) {
fileInput.value = '';
}
        }
    }

    function handleDrop(e: DragEvent) {
        e.preventDefault();
        dragOver = false;
        const file = e.dataTransfer?.files?.[0];

        if (file) {
            const dt = new DataTransfer();
            dt.items.add(file);

            if (fileInput) {
                fileInput.files = dt.files;
                fileInput.dispatchEvent(new Event('change', { bubbles: true }));
            }
        }
    }

    function selectImage(url: string) {
        if (onSelect) {
onSelect(url);
}

        open = false;
    }

    function copyUrl(url: string) {
        navigator.clipboard.writeText(url);
    }

    function formatSize(bytes: number): string {
        if (bytes < 1024) {
return bytes + ' B';
}

        if (bytes < 1024 * 1024) {
return (bytes / 1024).toFixed(1) + ' KB';
}

        return (bytes / (1024 * 1024)).toFixed(1) + ' MB';
    }

    $effect(() => {
        if (open) {
loadMedia();
}
    });

    $effect(() => {
        const _search = search;

        if (open) {
            const timer = setTimeout(() => loadMedia(), 300);

            return () => clearTimeout(timer);
        }
    });
</script>

{#if open}
    <div class="fixed inset-0 z-50 flex items-center justify-center">
        <button type="button" class="fixed inset-0 bg-black/50" aria-label="Tutup" onclick={() => open = false}></button>
        <div class="relative z-10 flex h-[80vh] w-full max-w-4xl flex-col rounded-lg border bg-background shadow-lg">
            <!-- Header -->
            <div class="flex items-center justify-between border-b px-6 py-4">
                <h2 class="text-lg font-semibold">Media Library</h2>
                <div class="flex items-center gap-2">
                    <input
                        bind:this={fileInput}
                        type="file"
                        accept="image/*"
                        class="hidden"
                        onchange={handleUpload}
                    />
                    <Button size="sm" onclick={() => fileInput?.click()} disabled={uploading}>
                        <Upload class="h-4 w-4" />
                        {uploading ? 'Mengunggah...' : 'Upload'}
                    </Button>
                    <Button variant="ghost" size="icon" class="h-8 w-8" onclick={() => open = false}>
                        <X class="h-4 w-4" />
                    </Button>
                </div>
            </div>

            <!-- Search -->
            <div class="border-b px-6 py-3">
                <div class="relative">
                    <Search class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-muted-foreground" />
                    <Input
                        bind:value={search}
                        placeholder="Cari gambar..."
                        class="pl-9"
                    />
                </div>
            </div>

            <!-- Drop Zone / Content -->
            <div
                class="flex-1 overflow-y-auto p-6"
                role="region"
                aria-label="Area upload"
                ondragover={(e) => {
 e.preventDefault(); dragOver = true; 
}}
                ondragleave={() => dragOver = false}
                ondrop={handleDrop}
            >
                {#if dragOver}
                    <div class="flex h-40 items-center justify-center rounded-lg border-2 border-dashed border-primary bg-primary/5">
                        <p class="text-sm text-primary">Lepaskan file untuk diunggah</p>
                    </div>
                {:else if media.length === 0}
                    <div class="flex h-40 flex-col items-center justify-center rounded-lg border-2 border-dashed">
                        <ImageIcon class="mb-2 h-10 w-10 text-muted-foreground" />
                        <p class="text-sm text-muted-foreground">Belum ada media</p>
                        <Button size="sm" variant="outline" class="mt-2" onclick={() => fileInput?.click()}>
                            <Upload class="h-4 w-4" /> Upload Gambar
                        </Button>
                    </div>
                {:else}
                    <div class="grid grid-cols-4 gap-3 sm:grid-cols-5 md:grid-cols-6">
                        {#each media as item}
                            {@const url = `/storage/${item.path}`}
                            <div
                                class="group relative aspect-square overflow-hidden rounded-md border-2 border-transparent bg-muted transition-all hover:border-primary"
                                role="button"
                                tabindex="0"
                                onclick={() => selectImage(url)}
                                onkeydown={(e) => {
 if (e.key === 'Enter' || e.key === ' ') {
selectImage(url);
} 
}}
                            >
                                <img
                                    src={url}
                                    alt={item.name}
                                    class="h-full w-full object-cover"
                                    loading="lazy"
                                />
                                <div class="absolute inset-0 flex items-center justify-center gap-1 bg-black/50 opacity-0 transition-opacity group-hover:opacity-100">
                                    <button
                                        type="button"
                                        class="rounded bg-white/20 p-1 text-white hover:bg-white/40"
                                        onclick={(e) => {
 e.stopPropagation(); copyUrl(url); 
}}
                                        title="Copy URL"
                                    >
                                        <Copy class="h-3 w-3" />
                                    </button>
                                </div>
                                <div class="absolute bottom-0 left-0 right-0 bg-black/60 px-1 py-0.5 text-center">
                                    <span class="text-[10px] text-white truncate block">{item.name}</span>
                                </div>
                            </div>
                        {/each}
                    </div>
                {/if}
            </div>
        </div>
    </div>
{/if}
