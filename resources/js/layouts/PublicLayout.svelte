<script lang="ts">
    import { Link, page } from '@inertiajs/svelte';
    import type { Snippet } from 'svelte';
    import { home, login, dashboard, archive } from '@/routes';
    import { about, contact } from '@/routes/pages';

    let { children }: { children?: Snippet } = $props();

    let auth = $derived(page.props.auth);
</script>

<div class="min-h-screen bg-background">
    <header class="sticky top-0 z-50 border-b bg-background/95 backdrop-blur supports-[backdrop-filter]:bg-background/60">
        <div class="mx-auto flex h-16 max-w-6xl items-center justify-between px-4">
            <Link href={home.url()} class="text-xl font-bold">
                <span class="text-primary">Alfida</span> CMS
            </Link>
            <nav class="hidden items-center gap-6 md:flex">
                <Link href={home.url()} class="text-sm font-medium transition-colors hover:text-primary" data-active={page.url === '/'}>
                    Beranda
                </Link>
                <Link href={archive.url()} class="text-sm font-medium transition-colors hover:text-primary" data-active={page.url.startsWith('/arsip')}>
                    Arsip
                </Link>
                <Link href={about.url()} class="text-sm font-medium transition-colors hover:text-primary" data-active={page.url.startsWith('/tentang-kami')}>
                    Tentang Kami
                </Link>
                <Link href={contact.url()} class="text-sm font-medium transition-colors hover:text-primary" data-active={page.url.startsWith('/kontak')}>
                    Kontak
                </Link>
            </nav>
            <div class="flex items-center gap-3">
                {#if auth?.user}
                    <Link href={dashboard.url()} class="text-sm font-medium hover:text-primary">
                        Dashboard
                    </Link>
                {:else}
                    <Link href={login.url()} class="text-sm font-medium hover:text-primary">
                        Masuk
                    </Link>
                {/if}
            </div>
        </div>
    </header>

    <main>
        {@render children?.()}
    </main>

    <footer class="border-t bg-muted/50">
        <div class="mx-auto max-w-6xl px-4 py-12">
            <div class="grid gap-8 md:grid-cols-3">
                <div>
                    <h3 class="mb-3 text-lg font-bold">
                        <span class="text-primary">Alfida</span> CMS
                    </h3>
                    <p class="text-sm text-muted-foreground">
                        Platform CMS profesional untuk mengelola konten digital sekolah.
                    </p>
                </div>
                <div>
                    <h4 class="mb-3 font-semibold">Navigasi</h4>
                    <ul class="space-y-2 text-sm text-muted-foreground">
                        <li><Link href={home.url()} class="hover:text-primary">Beranda</Link></li>
                        <li><Link href={archive.url()} class="hover:text-primary">Arsip Artikel</Link></li>
                        <li><Link href={about.url()} class="hover:text-primary">Tentang Kami</Link></li>
                        <li><Link href={contact.url()} class="hover:text-primary">Kontak</Link></li>
                    </ul>
                </div>
                <div>
                    <h4 class="mb-3 font-semibold">Kontak</h4>
                    <ul class="space-y-2 text-sm text-muted-foreground">
                        <li>Email: info@alfida-cms.local</li>
                        <li>Telp: (021) 1234-5678</li>
                        <li>Alamat: Jl. Pendidikan No. 123</li>
                    </ul>
                </div>
            </div>
            <div class="mt-8 border-t pt-6 text-center text-sm text-muted-foreground">
                &copy; {new Date().getFullYear()} Alfida CMS. Hak cipta dilindungi.
            </div>
        </div>
    </footer>
</div>
