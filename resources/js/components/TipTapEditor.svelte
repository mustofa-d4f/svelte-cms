<script lang="ts">
    import { Editor } from '@tiptap/core';
    import Highlight from '@tiptap/extension-highlight';
    import Image from '@tiptap/extension-image';
    import Placeholder from '@tiptap/extension-placeholder';
    import TextAlign from '@tiptap/extension-text-align';
    import StarterKit from '@tiptap/starter-kit';
    import {
        Bold, Italic, Underline as UnderlineIcon, Strikethrough,
        AlignLeft, AlignCenter, AlignRight, AlignJustify,
        List, ListOrdered, Quote, Code, Minus, Undo2, Redo2,
        ImagePlus, Link as LinkIcon, Heading1, Heading2, Heading3,
        Highlighter,
    } from 'lucide-svelte';
    import { onMount, onDestroy } from 'svelte';
    import { Button } from '@/components/ui/button';
    import { Input } from '@/components/ui/input';

    let {
        content = $bindable(''),
        placeholder = 'Tulis konten artikel di sini...',
        onImagePicker,
    }: {
        content?: string;
        placeholder?: string;
        onImagePicker?: () => void;
    } = $props();

    let editorElement: HTMLDivElement;
    let editor: Editor | undefined = $state(undefined);
    let showLinkInput = $state(false);
    let linkUrl = $state('');
    let isActive = $state<Record<string, boolean>>({});

    function updateActiveStates() {
        if (!editor) {
return;
}

        isActive = {
            bold: editor.isActive('bold'),
            italic: editor.isActive('italic'),
            underline: editor.isActive('underline'),
            strike: editor.isActive('strike'),
            h1: editor.isActive('heading', { level: 1 }),
            h2: editor.isActive('heading', { level: 2 }),
            h3: editor.isActive('heading', { level: 3 }),
            bulletList: editor.isActive('bulletList'),
            orderedList: editor.isActive('orderedList'),
            blockquote: editor.isActive('blockquote'),
            code: editor.isActive('code'),
            codeBlock: editor.isActive('codeBlock'),
            highlight: editor.isActive('highlight'),
            alignLeft: editor.isActive({ textAlign: 'left' }),
            alignCenter: editor.isActive({ textAlign: 'center' }),
            alignRight: editor.isActive({ textAlign: 'right' }),
            alignJustify: editor.isActive({ textAlign: 'justify' }),
            link: editor.isActive('link'),
        };
    }

    onMount(() => {
        editor = new Editor({
            element: editorElement,
            extensions: [
                StarterKit.configure({
                    heading: { levels: [1, 2, 3] },
                    link: { openOnClick: false, HTMLAttributes: { class: 'text-primary underline' } },
                    underline: {},
                }),
                Image.configure({ inline: false, allowBase64: true }),
                Placeholder.configure({ placeholder }),
                TextAlign.configure({ types: ['heading', 'paragraph'] }),
                Highlight.configure({ multicolor: false }),
            ],
            content,
            onUpdate: ({ editor: e }) => {
                content = e.getHTML();
                updateActiveStates();
            },
            onSelectionUpdate: () => updateActiveStates(),
            onCreate: () => updateActiveStates(),
        });
    });

    onDestroy(() => {
        editor?.destroy();
    });

    function toggleLink() {
        if (isActive.link) {
            editor.chain().focus().unsetLink().run();
            showLinkInput = false;
        } else {
            showLinkInput = true;
            linkUrl = '';
        }
    }

    function applyLink() {
        if (linkUrl) {
            let url = linkUrl;

            if (!url.startsWith('http://') && !url.startsWith('https://')) {
                url = 'https://' + url;
            }

            editor.chain().focus().setLink({ href: url }).run();
        }

        showLinkInput = false;
        linkUrl = '';
    }

    function insertImage(url: string) {
        editor.chain().focus().setImage({ src: url }).run();
    }

    function handleImageUpload() {
        if (onImagePicker) {
            onImagePicker();
        }
    }

    const toolbarGroups = [
        { items: [
            { action: () => editor.chain().focus().toggleHeading({ level: 1 }).run(), active: 'h1', icon: Heading1, label: 'H1' },
            { action: () => editor.chain().focus().toggleHeading({ level: 2 }).run(), active: 'h2', icon: Heading2, label: 'H2' },
            { action: () => editor.chain().focus().toggleHeading({ level: 3 }).run(), active: 'h3', icon: Heading3, label: 'H3' },
        ]},
        { items: [
            { action: () => editor.chain().focus().toggleBold().run(), active: 'bold', icon: Bold, label: 'Bold' },
            { action: () => editor.chain().focus().toggleItalic().run(), active: 'italic', icon: Italic, label: 'Italic' },
            { action: () => editor.chain().focus().toggleUnderline().run(), active: 'underline', icon: UnderlineIcon, label: 'Underline' },
            { action: () => editor.chain().focus().toggleStrike().run(), active: 'strike', icon: Strikethrough, label: 'Strike' },
            { action: () => editor.chain().focus().toggleHighlight().run(), active: 'highlight', icon: Highlighter, label: 'Highlight' },
        ]},
        { items: [
            { action: () => editor.chain().focus().setTextAlign('left').run(), active: 'alignLeft', icon: AlignLeft, label: 'Left' },
            { action: () => editor.chain().focus().setTextAlign('center').run(), active: 'alignCenter', icon: AlignCenter, label: 'Center' },
            { action: () => editor.chain().focus().setTextAlign('right').run(), active: 'alignRight', icon: AlignRight, label: 'Right' },
            { action: () => editor.chain().focus().setTextAlign('justify').run(), active: 'alignJustify', icon: AlignJustify, label: 'Justify' },
        ]},
        { items: [
            { action: () => editor.chain().focus().toggleBulletList().run(), active: 'bulletList', icon: List, label: 'Bullet' },
            { action: () => editor.chain().focus().toggleOrderedList().run(), active: 'orderedList', icon: ListOrdered, label: 'Ordered' },
            { action: () => editor.chain().focus().toggleBlockquote().run(), active: 'blockquote', icon: Quote, label: 'Quote' },
            { action: () => editor.chain().focus().toggleCodeBlock().run(), active: 'codeBlock', icon: Code, label: 'Code Block' },
            { action: () => editor.chain().focus().setHorizontalRule().run(), active: null, icon: Minus, label: 'HR' },
        ]},
    ];
</script>

<div class="rounded-md border border-input bg-background">
    <!-- Toolbar -->
    <div class="flex flex-wrap items-center gap-0.5 border-b border-input p-1">
        {#each toolbarGroups as group, gi}
            <div class="flex items-center">
                {#if gi > 0}
                    <div class="mx-1 h-6 w-px bg-border"></div>
                {/if}
                {#each group.items as item}
                    <Button
                        type="button"
                        variant="ghost"
                        size="icon"
                        class="h-8 w-8 {isActive[item.active] ? 'bg-accent text-accent-foreground' : ''}"
                        onclick={item.action}
                        title={item.label}
                    >
                        <item.icon class="h-4 w-4" />
                    </Button>
                {/each}
            </div>
        {/each}

        <div class="mx-1 h-6 w-px bg-border"></div>

        <Button
            type="button"
            variant="ghost"
            size="icon"
            class="h-8 w-8 {isActive.link ? 'bg-accent text-accent-foreground' : ''}"
            onclick={toggleLink}
            title="Link"
        >
            <LinkIcon class="h-4 w-4" />
        </Button>

        <Button
            type="button"
            variant="ghost"
            size="icon"
            class="h-8 w-8"
            onclick={handleImageUpload}
            title="Gambar"
        >
            <ImagePlus class="h-4 w-4" />
        </Button>

        <div class="ml-auto flex items-center">
            <Button
                type="button"
                variant="ghost"
                size="icon"
                class="h-8 w-8"
                onclick={() => editor?.chain().focus().undo().run()}
                disabled={!editor?.can().undo()}
                title="Undo"
            >
                <Undo2 class="h-4 w-4" />
            </Button>
            <Button
                type="button"
                variant="ghost"
                size="icon"
                class="h-8 w-8"
                onclick={() => editor?.chain().focus().redo().run()}
                disabled={!editor?.can().redo()}
                title="Redo"
            >
                <Redo2 class="h-4 w-4" />
            </Button>
        </div>
    </div>

    {#if showLinkInput}
        <div class="flex items-center gap-2 border-b border-input px-3 py-2">
            <LinkIcon class="h-4 w-4 text-muted-foreground" />
            <Input
                type="url"
                bind:value={linkUrl}
                placeholder="https://..."
                class="h-8 flex-1"
                onkeydown={(e) => {
                    if (e.key === 'Enter') {
 e.preventDefault(); applyLink(); 
}

                    if (e.key === 'Escape') {
 showLinkInput = false; 
}
                }}
            />
            <Button type="button" size="sm" onclick={applyLink}>OK</Button>
            <Button type="button" size="sm" variant="ghost" onclick={() => showLinkInput = false}>Batal</Button>
        </div>
    {/if}

    <!-- Editor Content -->
    <div bind:this={editorElement} class="min-h-[400px] p-4 focus:outline-none"></div>
</div>

<style>
    :global(.tiptap) {
        outline: none;
        min-height: 400px;
    }
    :global(.tiptap p.is-editor-empty:first-child::before) {
        content: attr(data-placeholder);
        float: left;
        color: hsl(var(--muted-foreground));
        pointer-events: none;
        height: 0;
    }
    :global(.tiptap h1) { font-size: 2em; font-weight: 700; margin: 0.5em 0; }
    :global(.tiptap h2) { font-size: 1.5em; font-weight: 600; margin: 0.5em 0; }
    :global(.tiptap h3) { font-size: 1.25em; font-weight: 600; margin: 0.5em 0; }
    :global(.tiptap p) { margin: 0.5em 0; line-height: 1.7; }
    :global(.tiptap ul), :global(.tiptap ol) { padding-left: 1.5em; margin: 0.5em 0; }
    :global(.tiptap ul) { list-style: disc; }
    :global(.tiptap ol) { list-style: decimal; }
    :global(.tiptap li) { margin: 0.25em 0; }
    :global(.tiptap blockquote) {
        border-left: 3px solid hsl(var(--border));
        padding-left: 1em;
        margin: 0.5em 0;
        color: hsl(var(--muted-foreground));
        font-style: italic;
    }
    :global(.tiptap pre) {
        background: hsl(var(--muted));
        border-radius: 0.375rem;
        padding: 0.75em 1em;
        margin: 0.5em 0;
        font-family: monospace;
        font-size: 0.875em;
        overflow-x: auto;
    }
    :global(.tiptap code) {
        background: hsl(var(--muted));
        border-radius: 0.25rem;
        padding: 0.15em 0.3em;
        font-family: monospace;
        font-size: 0.875em;
    }
    :global(.tiptap pre code) {
        background: none;
        padding: 0;
    }
    :global(.tiptap hr) {
        border: none;
        border-top: 2px solid hsl(var(--border));
        margin: 1.5em 0;
    }
    :global(.tiptap img) {
        max-width: 100%;
        height: auto;
        border-radius: 0.375rem;
        margin: 1em 0;
    }
    :global(.tiptap mark) {
        background-color: #fef08a;
        border-radius: 0.15em;
        padding: 0.1em 0;
    }
    :global(.tiptap a) {
        color: hsl(var(--primary));
        text-decoration: underline;
    }
</style>
