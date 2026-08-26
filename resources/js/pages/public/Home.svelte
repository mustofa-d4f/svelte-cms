<script module lang="ts">
    import PublicLayout from '@/layouts/PublicLayout.svelte';

    export const layout = PublicLayout;
</script>

<script lang="ts">
    import { Link } from '@inertiajs/svelte';
    import { ArrowRight, BookOpen, Calendar, Eye } from 'lucide-svelte';
    import AppHead from '@/components/AppHead.svelte';
    import ParallaxStars from '@/components/ParallaxStars.svelte';
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

<ParallaxStars>
    <section class="relative overflow-hidden bg-gradient-to-b from-transparent via-background/80 to-background">
        <div class="mx-auto max-w-6xl px-4 py-24 text-center">
            <div class="mb-6 inline-flex items-center gap-2 rounded-full border bg-background/50 px-4 py-2 text-sm backdrop-blur-sm">
                <span class="h-2 w-2 rounded-full bg-green-500 animate-pulse"></span>
                Portal Digital Sekolah
            </div>
            <h1 class="mb-6 text-5xl font-bold tracking-tight md:text-6xl lg:text-7xl">
                Selamat Datang di<br />
                <span class="bg-gradient-to-r from-primary via-primary/80 to-primary bg-clip-text text-transparent">
                    Alfida CMS
                </span>
            </h1>
            <p class="mx-auto mb-10 max-w-2xl text-lg text-muted-foreground md:text-xl">
                Portal informasi digital sekolah. Temukan berita terkini, artikel pendidikan, dan kegiatan sekolah dalam satu platform modern.
            </p>
            <div class="flex justify-center gap-4">
                <Button href={archive.url()} size="lg" class="shadow-lg shadow-primary/25">
                    Lihat Arsip <ArrowRight class="ml-2 h-4 w-4" />
                </Button>
                <Button variant="outline" href={about.url()} size="lg">
                    Tentang Kami
                </Button>
            </div>
        </div>
    </section>

    <section class="relative mx-auto max-w-6xl px-4 py-16">
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
                {#each posts as post (post.id)}
                    <Link href={show.url(post.slug)} class="group">
                        <Card class="h-full overflow-hidden border transition-all duration-300 hover:shadow-xl hover:shadow-primary/10 hover:-translate-y-1">
                            {#if post.featured_image}
                                <div class="aspect-video overflow-hidden">
                                    <img
                                        src={post.featured_image}
                                        alt={post.title}
                                        class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110"
                                    />
                                </div>
                            {:else}
                                <div class="flex aspect-video items-center justify-center bg-gradient-to-br from-primary/20 via-primary/10 to-transparent">
                                    <BookOpen class="h-16 w-16 text-primary/30" />
                                </div>
                            {/if}
                            <CardContent class="space-y-3 p-5">
                                {#if post.category}
                                    <span class="inline-block rounded-full bg-primary/10 px-3 py-1 text-xs font-medium text-primary">
                                        {post.category.name}
                                    </span>
                                {/if}
                                <h3 class="line-clamp-2 text-lg font-semibold group-hover:text-primary transition-colors">{post.title}</h3>
                                {#if post.excerpt}
                                    <p class="line-clamp-2 text-sm text-muted-foreground">{post.excerpt}</p>
                                {/if}
                                <div class="flex items-center gap-4 pt-2 text-xs text-muted-foreground">
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
</ParallaxStars>
