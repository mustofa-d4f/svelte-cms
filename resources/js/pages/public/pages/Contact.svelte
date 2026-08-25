<script module lang="ts">
    import PublicLayout from '@/layouts/PublicLayout.svelte';

    export const layout = PublicLayout;
</script>

<script lang="ts">
    import { Mail, Phone, MapPin, Clock } from 'lucide-svelte';
    import AppHead from '@/components/AppHead.svelte';
    import { Card, CardContent } from '@/components/ui/card';
</script>

<AppHead title="Kontak" />

<div class="mx-auto max-w-6xl px-4 py-12">
    <div class="mb-12 text-center">
        <h1 class="mb-4 text-3xl font-bold md:text-4xl">Hubungi Kami</h1>
        <p class="mx-auto max-w-2xl text-muted-foreground">
            Jangan ragu untuk menghubungi kami jika memiliki pertanyaan atau membutuhkan informasi lebih lanjut.
        </p>
    </div>

    <div class="grid gap-8 md:grid-cols-2">
        <Card>
            <CardContent class="space-y-6 py-8">
                <h2 class="text-2xl font-bold">Informasi Kontak</h2>

                <div class="space-y-4">
                    <div class="flex items-start gap-4">
                        <MapPin class="mt-0.5 h-5 w-5 text-primary" />
                        <div>
                            <p class="font-medium">Alamat</p>
                            <p class="text-sm text-muted-foreground">Jl. Pendidikan No. 123, Kota, Provinsi, 12345</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <Phone class="mt-0.5 h-5 w-5 text-primary" />
                        <div>
                            <p class="font-medium">Telepon</p>
                            <p class="text-sm text-muted-foreground">(021) 1234-5678</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <Mail class="mt-0.5 h-5 w-5 text-primary" />
                        <div>
                            <p class="font-medium">Email</p>
                            <p class="text-sm text-muted-foreground">info@alfida-cms.local</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <Clock class="mt-0.5 h-5 w-5 text-primary" />
                        <div>
                            <p class="font-medium">Jam Operasional</p>
                            <p class="text-sm text-muted-foreground">Senin - Jumat: 07:00 - 16:00</p>
                            <p class="text-sm text-muted-foreground">Sabtu: 07:00 - 12:00</p>
                        </div>
                    </div>
                </div>
            </CardContent>
        </Card>

        <Card>
            <CardContent class="space-y-6 py-8">
                <h2 class="text-2xl font-bold">Kirim Pesan</h2>

                <form class="space-y-4" onsubmit={(e) => {
 e.preventDefault(); alert('Pesan berhasil dikirim! (Demo)'); 
}}>
                    <div class="space-y-2">
                        <label for="name" class="text-sm font-medium">Nama</label>
                        <input
                            id="name"
                            type="text"
                            required
                            class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring"
                            placeholder="Nama lengkap"
                        />
                    </div>
                    <div class="space-y-2">
                        <label for="email" class="text-sm font-medium">Email</label>
                        <input
                            id="email"
                            type="email"
                            required
                            class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring"
                            placeholder="email@example.com"
                        />
                    </div>
                    <div class="space-y-2">
                        <label for="subject" class="text-sm font-medium">Subjek</label>
                        <input
                            id="subject"
                            type="text"
                            required
                            class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring"
                            placeholder="Subjek pesan"
                        />
                    </div>
                    <div class="space-y-2">
                        <label for="message" class="text-sm font-medium">Pesan</label>
                        <textarea
                            id="message"
                            required
                            class="flex min-h-[120px] w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring"
                            placeholder="Tulis pesan Anda di sini..."
                        ></textarea>
                    </div>
                    <button
                        type="submit"
                        class="inline-flex h-10 items-center justify-center rounded-md bg-primary px-8 text-sm font-medium text-primary-foreground ring-offset-background transition-colors hover:bg-primary/90 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2"
                    >
                        Kirim Pesan
                    </button>
                </form>
            </CardContent>
        </Card>
    </div>
</div>
