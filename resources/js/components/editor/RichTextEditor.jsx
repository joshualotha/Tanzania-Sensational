import React, { useEffect } from 'react';
import { useEditor, EditorContent } from '@tiptap/react';
import StarterKit from '@tiptap/starter-kit';

export function RichTextEditor({ value, onChange }) {
    const editor = useEditor({
        extensions: [StarterKit],
        content: value || '',
        editorProps: {
            attributes: {
                style: [
                    'min-height: 260px',
                    'padding: 12px',
                    'outline: none',
                    'line-height: 1.7',
                    'font-size: 15px',
                    'color: white',
                ].join(';'),
            },
        },
        onUpdate: ({ editor }) => {
            onChange?.(editor.getHTML());
        },
    });

    useEffect(() => {
        if (!editor) return;
        const current = editor.getHTML();
        const next = value || '';
        if (current !== next) editor.commands.setContent(next, false);
    }, [editor, value]);

    if (!editor) return null;

    return (
        <div style={{ border: '1px solid var(--border)', background: '#000' }}>
            <div style={{ display: 'flex', gap: 8, padding: 8, borderBottom: '1px solid rgba(255,255,255,0.06)' }}>
                <button className="admin-btn-mini" onClick={() => editor.chain().focus().toggleBold().run()} style={{ opacity: editor.isActive('bold') ? 1 : 0.6 }}>Bold</button>
                <button className="admin-btn-mini" onClick={() => editor.chain().focus().toggleItalic().run()} style={{ opacity: editor.isActive('italic') ? 1 : 0.6 }}>Italic</button>
                <button className="admin-btn-mini" onClick={() => editor.chain().focus().toggleBulletList().run()} style={{ opacity: editor.isActive('bulletList') ? 1 : 0.6 }}>Bullets</button>
                <button className="admin-btn-mini" onClick={() => editor.chain().focus().toggleOrderedList().run()} style={{ opacity: editor.isActive('orderedList') ? 1 : 0.6 }}>Numbered</button>
                <button className="admin-btn-mini" onClick={() => editor.chain().focus().toggleHeading({ level: 2 }).run()} style={{ opacity: editor.isActive('heading', { level: 2 }) ? 1 : 0.6 }}>H2</button>
                <button className="admin-btn-mini" onClick={() => editor.chain().focus().toggleHeading({ level: 3 }).run()} style={{ opacity: editor.isActive('heading', { level: 3 }) ? 1 : 0.6 }}>H3</button>
                <button className="admin-btn-mini" onClick={() => editor.chain().focus().toggleBlockquote().run()} style={{ opacity: editor.isActive('blockquote') ? 1 : 0.6 }}>Quote</button>
            </div>
            <EditorContent editor={editor} />
        </div>
    );
}

