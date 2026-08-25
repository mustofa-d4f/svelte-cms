<script module lang="ts">
    import PublicLayout from '@/layouts/PublicLayout.svelte';

    export const layout = PublicLayout;
</script>

<script lang="ts">
    import { Target, Eye, Award, Users } from 'lucide-svelte';
    import AppHead from '@/components/AppHead.svelte';
    import { Card, CardContent } from '@/components/ui/card';
</script>

<AppHead title="Tentang Kami" />

<div class="mx-auto max-w-6xl px-4 py-12">
    <div class="mb-12 text-center">
        <h1 class="mb-4 text-3xl font-bold md:text-4xl">Tentang Kami</h1>
        <p class="mx-auto max-w-2xl text-muted-foreground">
            Mengenal lebih dekat sekolah kami dan komitmen kami dalam pendidikan.
        </p>
    </div>

    <Card class="mb-12">
        <CardContent class="space-y-4 py-8">
            <h2 class="text-2xl font-bold">Profil Sekolah</h2>
            <p class="text-muted-foreground">
                Sekolah kami adalah lembaga pendidikan yang berkomitmen untuk mencerdaskan kehidupan bangsa melalui pendidikan berkualitas. Dengan fasilitas modern dan tenaga pengajar profesional, kami berusaha memberikan yang terbaik bagi setiap siswa.
            </p>
            <p class="text-muted-foreground">
                Didirikan pada tahun 2000, sekolah kami telah berkembang menjadi salah satu lembaga pendidikan terkemuda di daerah ini. Kami percaya bahwa setiap anak memiliki potensi luar biasa yang perlu dikembangkan.
            </p>
        </CardContent>
    </Card>

    <div class="mb-12 grid gap-6 md:grid-cols-2">
        <Card>
            <CardContent class="space-y-4 py-8">
                <div class="flex items-center gap-3">
                    <Target class="h-8 w-8 text-primary" />
                    <h3 class="text-xl font-bold">Visi</h3>
                </div>
                <p class="text-muted-foreground">
                    Menjadi sekolah unggul yang menghasilkan generasi cerdas, berkarakter, dan berdaya saing global.
                </p>
            </CardContent>
        </Card>
        <Card>
            <CardContent class="space-y-4 py-8">
                <div class="flex items-center gap-3">
                    <Eye class="h-8 w-8 text-primary" />
                    <h3 class="text-xl font-bold">Misi</h3>
                </div>
                <ul class="space-y-2 text-muted-foreground">
                    <li>1. Menyelenggarakan pendidikan berkualitas berdasarkan kurikulum nasional</li>
                    <li>2. Mengembangkan potensi siswa secara holistik</li>
                    <li>3. Membangun karakter dan akhlak mulia</li>
                    <li>4. Meningkatkan kompetensi tenaga pendidik</li>
                </ul>
            </CardContent>
        </Card>
    </div>

    <div class="mb-12 grid gap-6 md:grid-cols-4">
        <Card>
            <CardContent class="py-6 text-center">
                <Award class="mx-auto mb-2 h-8 w-8 text-primary" />
                <p class="text-2xl font-bold">15+</p>
                <p class="text-sm text-muted-foreground">Tahun Pengalaman</p>
            </CardContent>
        </Card>
        <Card>
            <CardContent class="py-6 text-center">
                <Users class="mx-auto mb-2 h-8 w-8 text-primary" />
                <p class="text-2xl font-bold">500+</p>
                <p class="text-sm text-muted-foreground">Siswa Aktif</p>
            </CardContent>
        </Card>
        <Card>
            <CardContent class="py-6 text-center">
                <Users class="mx-auto mb-2 h-8 w-8 text-primary" />
                <p class="text-2xl font-bold">50+</p>
                <p class="text-sm text-muted-foreground">Guru & Staf</p>
            </CardContent>
        </Card>
        <Card>
            <CardContent class="py-6 text-center">
                <Award class="mx-auto mb-2 h-8 w-8 text-primary" />
                <p class="text-2xl font-bold">20+</p>
                <p class="text-sm text-muted-foreground">Prestasi</p>
            </CardContent>
        </Card>
    </div>

    <Card>
        <CardContent class="space-y-4 py-8">
            <h2 class="text-2xl font-bold">Sambutan Kepala Sekolah</h2>
            <div class="flex gap-6">
                <div class="hidden h-32 w-32 flex-shrink-0 items-center justify-center rounded-full bg-muted md:flex">
                    <Users class="h-16 w-16 text-muted-foreground" />
                </div>
                <div class="space-y-4">
                    <p class="text-muted-foreground">
                        Assalamualaikum Warahmatullahi Wabarakatuh,
                    </p>
                    <p class="text-muted-foreground">
                        Selamat datang di website resmi sekolah kami. Saya sangat bangga dengan pencapaian siswa-siswa kami dan komitmen seluruh stakeholder dalam memajukan pendidikan di sekolah ini.
                    </p>
                    <p class="text-muted-foreground">
                        Website ini kami hadirkan sebagai media informasi dan komunikasi antara sekolah dengan orang tua, siswa, dan masyarakat luas. Semoga dapat bermanfaat bagi kita semua.
                    </p>
                    <p class="font-semibold">Wassalamualaikum Warahmatullahi Wabarakatuh</p>
                    <p class="text-sm text-muted-foreground">Kepala Sekolah</p>
                </div>
            </div>
        </CardContent>
    </Card>
</div>
