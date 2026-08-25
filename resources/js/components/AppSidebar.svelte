<script lang="ts">
    import { Link, page } from '@inertiajs/svelte';
    import BookOpen from 'lucide-svelte/icons/book-open';
    import FileText from 'lucide-svelte/icons/file-text';
    import Folder from 'lucide-svelte/icons/folder';
    import FolderGit2 from 'lucide-svelte/icons/folder-git-2';
    import Image from 'lucide-svelte/icons/image';
    import LayoutGrid from 'lucide-svelte/icons/layout-grid';
    import Tags from 'lucide-svelte/icons/tags';
    import type { Snippet } from 'svelte';
    import AppLogo from '@/components/AppLogo.svelte';
    import NavFooter from '@/components/NavFooter.svelte';
    import NavMain from '@/components/NavMain.svelte';
    import NavUser from '@/components/NavUser.svelte';
    import {
        Sidebar,
        SidebarContent,
        SidebarFooter,
        SidebarHeader,
        SidebarMenu,
        SidebarMenuButton,
        SidebarMenuItem,
    } from '@/components/ui/sidebar';
    import { toUrl } from '@/lib/utils';
    import { dashboard } from '@/routes';
    import type { NavItem } from '@/types';

    let {
        children,
    }: {
        children?: Snippet;
    } = $props();

    const user = $derived(page.props.auth?.user);
    const permissions = $derived(user?.permissions ?? []);

    function hasPermission(permission: string): boolean {
        if (user?.roles?.includes('admin')) {
return true;
}

        return permissions.includes(permission);
    }

    const mainNavItems = $derived.by(() => {
        const items: NavItem[] = [];

        if (hasPermission('view dashboard')) {
            items.push({ title: 'Dashboard', href: dashboard(), icon: LayoutGrid });
        }

        return items;
    });

    const cmsNavItems = $derived.by(() => {
        const items: NavItem[] = [];

        if (hasPermission('manage posts')) {
            items.push({ title: 'Artikel', href: '/admin/posts', icon: FileText });
        }

        if (hasPermission('manage categories')) {
            items.push({ title: 'Kategori', href: '/admin/categories', icon: Folder });
        }

        if (hasPermission('manage tags')) {
            items.push({ title: 'Tag', href: '/admin/tags', icon: Tags });
        }

        if (hasPermission('manage media')) {
            items.push({ title: 'Media', href: '/admin/media', icon: Image });
        }

        return items;
    });

    const footerNavItems: NavItem[] = [
        {
            title: 'Repository',
            href: 'https://github.com/laravel/svelte-starter-kit',
            icon: FolderGit2,
        },
        {
            title: 'Documentation',
            href: 'https://laravel.com/docs/starter-kits#svelte',
            icon: BookOpen,
        },
    ];
</script>

<Sidebar collapsible="icon" variant="inset">
    <SidebarHeader>
        <SidebarMenu>
            <SidebarMenuItem>
                <SidebarMenuButton size="lg" asChild>
                    {#snippet children(props)}
                        <Link
                            {...props}
                            href={toUrl(dashboard())}
                            class={props.class}
                        >
                            <AppLogo />
                        </Link>
                    {/snippet}
                </SidebarMenuButton>
            </SidebarMenuItem>
        </SidebarMenu>
    </SidebarHeader>

    <SidebarContent>
        {#if mainNavItems.length > 0}
            <NavMain items={mainNavItems} label="Menu" />
        {/if}
        {#if cmsNavItems.length > 0}
            <NavMain items={cmsNavItems} label="CMS" />
        {/if}
    </SidebarContent>

    <SidebarFooter>
        <NavFooter items={footerNavItems} />
        <NavUser />
    </SidebarFooter>
</Sidebar>
{@render children?.()}
