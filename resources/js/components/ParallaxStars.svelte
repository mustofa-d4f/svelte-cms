<script lang="ts">
    import { onMount } from 'svelte';
    import type { Snippet } from 'svelte';

    let { children }: { children?: Snippet } = $props();

    let canvas: HTMLCanvasElement;
    let scrollY = $state(0);

    interface Star {
        x: number;
        y: number;
        size: number;
        speed: number;
        opacity: number;
        twinkleSpeed: number;
        twinkleOffset: number;
    }

    let stars: Star[] = [];
    let shootingStars: { x: number; y: number; length: number; speed: number; opacity: number; angle: number }[] = [];
    let animationId: number;

    function createStars(width: number, height: number) {
        stars = [];
        const layers = [
            { count: 80, sizeMin: 0.5, sizeMax: 1.5, speed: 0.1, opacityMin: 0.3, opacityMax: 0.7 },
            { count: 50, sizeMin: 1, sizeMax: 2, speed: 0.3, opacityMin: 0.5, opacityMax: 0.9 },
            { count: 20, sizeMin: 2, sizeMax: 3, speed: 0.5, opacityMin: 0.7, opacityMax: 1 },
        ];

        for (const layer of layers) {
            for (let i = 0; i < layer.count; i++) {
                stars.push({
                    x: Math.random() * width,
                    y: Math.random() * height * 2,
                    size: layer.sizeMin + Math.random() * (layer.sizeMax - layer.sizeMin),
                    speed: layer.speed,
                    opacity: layer.opacityMin + Math.random() * (layer.opacityMax - layer.opacityMin),
                    twinkleSpeed: 0.5 + Math.random() * 2,
                    twinkleOffset: Math.random() * Math.PI * 2,
                });
            }
        }
    }

    function spawnShootingStar(width: number, height: number) {
        if (Math.random() > 0.005) return;
        shootingStars.push({
            x: Math.random() * width,
            y: Math.random() * height * 0.5,
            length: 80 + Math.random() * 120,
            speed: 8 + Math.random() * 8,
            opacity: 0.8 + Math.random() * 0.2,
            angle: Math.PI / 4 + (Math.random() - 0.5) * 0.3,
        });
    }

    function draw(time: number) {
        if (!canvas) return;
        const ctx = canvas.getContext('2d');
        if (!ctx) return;

        const width = canvas.width;
        const height = canvas.height;

        ctx.clearRect(0, 0, width, height);

        for (const star of stars) {
            const parallaxY = star.y - scrollY * star.speed;
            const wrappedY = ((parallaxY % (height * 2)) + height * 2) % (height * 2) - height * 0.5;

            const twinkle = Math.sin(time * 0.001 * star.twinkleSpeed + star.twinkleOffset) * 0.3 + 0.7;
            const alpha = star.opacity * twinkle;

            ctx.beginPath();
            ctx.arc(star.x, wrappedY, star.size, 0, Math.PI * 2);
            ctx.fillStyle = `rgba(255, 255, 255, ${alpha})`;
            ctx.fill();

            if (star.size > 2) {
                ctx.beginPath();
                ctx.arc(star.x, wrappedY, star.size * 2, 0, Math.PI * 2);
                ctx.fillStyle = `rgba(200, 220, 255, ${alpha * 0.15})`;
                ctx.fill();
            }
        }

        for (let i = shootingStars.length - 1; i >= 0; i--) {
            const ss = shootingStars[i];
            ss.x += Math.cos(ss.angle) * ss.speed;
            ss.y += Math.sin(ss.angle) * ss.speed;
            ss.opacity -= 0.01;

            if (ss.opacity <= 0 || ss.x > width || ss.y > height) {
                shootingStars.splice(i, 1);
                continue;
            }

            const gradient = ctx.createLinearGradient(
                ss.x, ss.y,
                ss.x - Math.cos(ss.angle) * ss.length,
                ss.y - Math.sin(ss.angle) * ss.length
            );
            gradient.addColorStop(0, `rgba(255, 255, 255, ${ss.opacity})`);
            gradient.addColorStop(1, 'rgba(255, 255, 255, 0)');

            ctx.beginPath();
            ctx.moveTo(ss.x, ss.y);
            ctx.lineTo(
                ss.x - Math.cos(ss.angle) * ss.length,
                ss.y - Math.sin(ss.angle) * ss.length
            );
            ctx.strokeStyle = gradient;
            ctx.lineWidth = 2;
            ctx.stroke();
        }

        spawnShootingStar(width, height);
        animationId = requestAnimationFrame(draw);
    }

    function handleScroll() {
        scrollY = window.scrollY;
    }

    function handleResize() {
        if (canvas) {
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
            createStars(canvas.width, canvas.height);
        }
    }

    onMount(() => {
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;
        createStars(canvas.width, canvas.height);
        animationId = requestAnimationFrame(draw);

        window.addEventListener('scroll', handleScroll, { passive: true });
        window.addEventListener('resize', handleResize);

        return () => {
            cancelAnimationFrame(animationId);
            window.removeEventListener('scroll', handleScroll);
            window.removeEventListener('resize', handleResize);
        };
    });
</script>

<canvas
    bind:this={canvas}
    class="pointer-events-none fixed inset-0 z-0"
    style="opacity: 0.7;"
></canvas>

<div class="relative z-10">
    {@render children?.()}
</div>
