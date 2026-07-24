import Quill from 'quill';
import 'quill/dist/quill.snow.css';

const toolbarOptions = [
    ['bold', 'italic', 'underline', 'strike'],
    [{ color: [] }, { background: [] }],
    [{ header: [1, 2, 3, false] }],
    [{ list: 'ordered' }, { list: 'bullet' }],
    ['link'],
    ['clean'],
];

function syncEditor(editor, input) {
    input.value = editor.root.innerHTML;
}

function isEditorEmpty(editor) {
    const text = editor.getText().trim();

    return text === '';
}

function initRichTextEditor(container) {
    const input = container.querySelector('[data-rich-text-input]');
    const editorElement = container.querySelector('[data-rich-text-area]');

    if (!input || !editorElement) {
        return;
    }

    const editor = new Quill(editorElement, {
        theme: 'snow',
        modules: {
            toolbar: toolbarOptions,
        },
        placeholder: container.dataset.placeholder || 'Start writing...',
    });

    if (input.value.trim() !== '') {
        editor.root.innerHTML = input.value;
    }

    editor.on('text-change', () => syncEditor(editor, input));

    const form = container.closest('form');

    if (form) {
        form.addEventListener('submit', (event) => {
            syncEditor(editor, input);

            if (container.dataset.required === 'true' && isEditorEmpty(editor)) {
                event.preventDefault();
                editorElement.classList.add('ring-2', 'ring-red-500');
            }
        });
    }
}

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-rich-text-editor]').forEach(initRichTextEditor);
});
