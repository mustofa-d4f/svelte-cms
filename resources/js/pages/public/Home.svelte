<script module lang="ts">
    import PublicLayout from '@/layouts/PublicLayout.svelte';

    export const layout = PublicLayout;
</script>

<script lang="ts">
    import { Link } from '@inertiajs/svelte';
    import { ArrowRight, BookOpen, Calendar, Eye } from 'lucide-svelte';
    import AppHead from '@/components/AppHead.svelte';
    import { Button } from '@/components/ui/button';
    import { Card, CardContent } from '@/components/ui/card';
    import { archive } from '@/routes';
    import { about } from '@/routes/pages';
    import { show } from '@/routes/posts';

    let { posts }: { posts: any[] } = $props();

    function formatDate(date: string) {
        return new Date(date).toLocaleDateString('id-ID', {
            day: 'numeric',
            month: 'long',
            year: 'numeric',
        });
    }
</script>

<AppHead title="Beranda" />

<section class="relative overflow-hidden bg-gradient-to-br from-primary/5 via-background to-primary/10">
    <div class="mx-auto max-w-6xl px-4 py-20 text-center">
        <h1 class="mb-4 text-4xl font-bold tracking-tight md:text-5xl">
            Selamat Datang di <span class="text-primary">Alfida CMS</span>
        </h1>
        <p class="mx-auto mb-8 max-w-2xl text-lg text-muted-foreground">
            Portal informasi digital sekolah. Temukan berita terkini, artikel pendidikan, dan kegiatan sekolah.
        </p>
        <div class="flex justify-center gap-4">
            <Button href={archive.url()}>
                Lihat Arsip <ArrowRight class="ml-2 h-4 w-4" />
            </Button>
            <Button variant="outline" href={about.url()}>
                Tentang Kami
            </Button>
        </div>
    </div>
</section>

<section class="mx-auto max-w-6xl px-4 py-16">
    <div class="mb-8 flex items-center justify-between">
        <h2 class="text-2xl font-bold">Artikel Terbaru</h2>
        <Button variant="ghost" href={archive.url()}>
            Lihat Semua <ArrowRight class="ml-2 h-4 w-4" />
        </Button>
    </div>

    {#if posts.length === 0}
        <Card>
            <CardContent class="py-12 text-center">
                <BookOpen class="mx-auto mb-4 h-12 w-12 text-muted-foreground" />
                <p class="text-muted-foreground">Belum ada artikel yang dipublikasikan.</p>
            </CardContent>
        </Card>
    {:else}
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            {#each posts as post}
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
    {/if}
</section>
