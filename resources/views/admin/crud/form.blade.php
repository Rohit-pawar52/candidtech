@extends('admin.layout')

@section('title', $record ? 'Edit ' . $title : 'Create ' . $title)

@section('content')

<style>
    .image-upload-area {
        border: 2px dashed #ccc;
        border-radius: 8px;
        padding: 20px;
        text-align: center;
        background: #f9f9f9;
        cursor: pointer;
        transition: all 0.3s;
    }
    .image-upload-area:hover {
        border-color: #007bff;
        background: #f0f8ff;
    }
    .image-upload-area.has-image {
        border: none;
        background: transparent;
        padding: 0;
    }
    .image-preview {
        max-width: 300px;
        max-height: 300px;
        border-radius: 8px;
        display: block;
        margin-bottom: 15px;
    }
    .image-upload-input {
        display: none;
    }
    .ck-editor__editable {
        min-height: 200px;
    }
    .rich-editor-wrapper {
        border: 1px solid #ced4da;
        border-radius: 0.375rem;
        background: #ffffff;
    }
    .rich-editor-toolbar {
        display: flex;
        flex-wrap: wrap;
        gap: 0.25rem;
        padding: 0.5rem;
        border-bottom: 1px solid #dee2e6;
        background: #f8f9fa;
    }
    .rich-editor-toolbar button {
        border: 1px solid #ced4da;
        border-radius: 0.375rem;
        background: #ffffff;
        color: #212529;
        padding: 0.35rem 0.75rem;
        cursor: pointer;
    }
    .rich-editor-toolbar button:hover {
        background: #e9ecef;
    }
    .rich-editor-toolbar input[type="color"] {
        border: none;
        width: 1.75rem;
        height: 1.75rem;
        padding: 0;
        margin-left: 0.25rem;
        background: transparent;
        cursor: pointer;
    }
    .rich-editor-toolbar select {
        border: 1px solid #ced4da;
        border-radius: 0.375rem;
        background: #ffffff;
        color: #212529;
        padding: 0.35rem 0.5rem;
        cursor: pointer;
    }
    .rich-editor-content {
        min-height: 200px;
        padding: 1rem;
        outline: none;
        white-space: pre-wrap;
        word-break: break-word;
        background: #ffffff;
    }
    .rich-editor-content:focus {
        box-shadow: inset 0 0 0 1px #80bdff;
    }
</style>

<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ $record ? route($routeName . '.update', $record->id) : route($routeName . '.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            @if($record)
                @method('PUT')
            @endif

            @foreach($fields as $name => $field)
                @php
                    $hasImage = isset($record) && !empty($record->{$name});
                    $imageUrl = '';
                    if ($hasImage) {
                        $imagePath = $record->{$name};
                        $imageUrl = \Illuminate\Support\Str::startsWith($imagePath, 'uploads/') ? asset('storage/' . $imagePath) : asset($imagePath);
                    }
                @endphp
                <div class="mb-3">
                    <label class="form-label">{{ $field['label'] }}</label>
                    @if($field['type'] === 'ckeditor')
                        <textarea id="editor-{{ $name }}" class="form-control ckeditor-field" name="{{ $name }}">{{ old($name, $record->{$name} ?? '') }}</textarea>
                    @elseif($field['type'] === 'textarea')
                        <textarea class="form-control" name="{{ $name }}" rows="4">{{ old($name, $record->{$name} ?? '') }}</textarea>
                    @elseif($field['type'] === 'file')
                        <div class="image-upload-area {{ $hasImage ? 'has-image' : '' }}" onclick="document.getElementById('file-{{ $name }}').click();">
                            @if($hasImage)
                                <img src="{{ $imageUrl }}" alt="{{ $field['label'] }}" class="image-preview" onerror="this.src='{{ asset('upload/service1.jpeg') }}'; this.onerror=null;">
                            @else
                                <div style="padding: 20px; color: #999;">
                                    <i class="fas fa-cloud-upload-alt" style="font-size: 40px; margin-bottom: 10px; display: block;"></i>
                                    <p style="margin-bottom: 5px;"><strong>Click to upload</strong> or drag and drop</p>
                                    <small>JPEG, PNG or GIF (Max 5MB)</small>
                                </div>
                            @endif
                        </div>
                        <input type="file" id="file-{{ $name }}" name="{{ $name }}" accept="image/*" class="image-upload-input" onchange="previewImage(this, '{{ $name }}')">
                    @else
                        <input type="{{ $field['type'] }}" class="form-control" name="{{ $name }}" value="{{ old($name, $record->{$name} ?? '') }}">
                    @endif
                    @error($name)
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>
            @endforeach

            <button class="btn btn-primary" type="submit">{{ $record ? 'Update' : 'Save' }}</button>
            <a href="{{ route($routeName . '.index') }}" class="btn btn-outline-secondary ms-2">Back</a>
        </form>
    </div>
</div>

<script>
window._ckEditorLoadState = null;
window.onCkeditorScriptLoaded = function() {
    window._ckEditorLoadState = 'loaded';
    if (window._initializeEditorFieldsReady) {
        initializeEditorFields(true);
    }
};
window.onCkeditorScriptFailed = function() {
    window._ckEditorLoadState = 'failed';
    if (window._initializeEditorFieldsReady) {
        initializeEditorFields(false);
    }
};
</script>
<script src="https://cdn.ckeditor.com/ckeditor5/latest/classic/ckeditor.js" onload="onCkeditorScriptLoaded()" onerror="onCkeditorScriptFailed()"></script>
<script>
function previewImage(input, fieldName) {
    const uploadArea = input.closest('.mb-3').querySelector('.image-upload-area');
    const placeholderUrl = "{{ asset('upload/service1.jpeg') }}";

    if (!uploadArea || !input.files || !input.files[0]) {
        return;
    }

    const reader = new FileReader();
    reader.onload = function(e) {
        uploadArea.innerHTML = '<img src="' + e.target.result + '" alt="Preview" class="image-preview" onerror="this.src=\'' + placeholderUrl + '\'; this.onerror=null;">';
        uploadArea.classList.add('has-image');
    };
    reader.readAsDataURL(input.files[0]);
}

function syncFallbackEditor(textarea, editor) {
    textarea.value = editor.innerHTML;
}

function createFallbackEditor(textarea) {
    if (textarea.dataset.fallbackInitialized === 'true') {
        return;
    }

    textarea.style.display = 'none';
    textarea.dataset.fallbackInitialized = 'true';

    const wrapper = document.createElement('div');
    wrapper.className = 'rich-editor-wrapper';

    const toolbar = document.createElement('div');
    toolbar.className = 'rich-editor-toolbar';

    const editorDiv = document.createElement('div');
    editorDiv.className = 'rich-editor-content';
    editorDiv.contentEditable = 'true';
    editorDiv.innerHTML = textarea.value || '';

    const toolbarControls = [
        { type: 'button', command: 'bold', label: 'B', title: 'Bold' },
        { type: 'button', command: 'italic', label: 'I', title: 'Italic' },
        { type: 'button', command: 'underline', label: 'U', title: 'Underline' },
        { type: 'button', command: 'insertUnorderedList', label: '• List', title: 'Bullet List' },
        { type: 'button', command: 'insertOrderedList', label: '1. List', title: 'Numbered List' },
        { type: 'button', command: 'formatBlock', value: 'blockquote', label: '“”', title: 'Block Quote' },
        { type: 'button', command: 'createLink', label: 'Link', title: 'Add Link' },
        { type: 'color', command: 'foreColor', label: 'A', title: 'Text Color' },
        { type: 'color', command: 'hiliteColor', label: 'BG', title: 'Highlight Color' },
        { type: 'select', command: 'formatBlock', options: [
            { value: 'p', label: 'Normal' },
            { value: 'h1', label: 'H1' },
            { value: 'h2', label: 'H2' },
            { value: 'h3', label: 'H3' }
        ], title: 'Paragraph / Heading' },
        { type: 'button', command: 'undo', label: 'Undo', title: 'Undo' },
        { type: 'button', command: 'redo', label: 'Redo', title: 'Redo' }
    ];

    toolbarControls.forEach(control => {
        if (control.type === 'button') {
            const button = document.createElement('button');
            button.type = 'button';
            button.textContent = control.label;
            button.title = control.title;
            button.addEventListener('click', function() {
                if (control.command === 'createLink') {
                    const url = prompt('Enter URL for the link');
                    if (url) {
                        document.execCommand('createLink', false, url);
                    }
                    return;
                }
                document.execCommand(control.command, false, control.value || null);
                editorDiv.focus();
            });
            toolbar.appendChild(button);
            return;
        }

        if (control.type === 'color') {
            const label = document.createElement('label');
            label.className = 'rich-editor-color-picker';
            label.title = control.title;
            label.textContent = control.label;
            const input = document.createElement('input');
            input.type = 'color';
            input.value = control.command === 'foreColor' ? '#000000' : '#ffff00';
            input.style.marginLeft = '0.25rem';
            input.addEventListener('input', function() {
                document.execCommand(control.command, false, input.value);
                editorDiv.focus();
            });
            label.appendChild(input);
            toolbar.appendChild(label);
            return;
        }

        if (control.type === 'select') {
            const select = document.createElement('select');
            select.title = control.title;
            select.style.minWidth = '110px';
            control.options.forEach(optionData => {
                const option = document.createElement('option');
                option.value = optionData.value;
                option.textContent = optionData.label;
                select.appendChild(option);
            });
            select.addEventListener('change', function() {
                document.execCommand(control.command, false, select.value);
                editorDiv.focus();
            });
            toolbar.appendChild(select);
        }
    });

    wrapper.appendChild(toolbar);
    wrapper.appendChild(editorDiv);
    textarea.insertAdjacentElement('afterend', wrapper);

    const form = textarea.closest('form');
    if (form) {
        form.addEventListener('submit', function() {
            syncFallbackEditor(textarea, editorDiv);
        });
    }
}

function initializeCKEditorField(textarea) {
    if (textarea.dataset.fallbackInitialized === 'true') {
        return;
    }

    ClassicEditor
        .create(textarea, {
            toolbar: {
                items: [
                    'heading', '|',
                    'bold', 'italic', 'underline', '|',
                    'alignment', '|',
                    'bulletedList', 'numberedList', '|',
                    'blockQuote', 'link', '|',
                    'undo', 'redo'
                ]
            },
            heading: {
                options: [
                    { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                    { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                    { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                    { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
                    { model: 'heading4', view: 'h4', title: 'Heading 4', class: 'ck-heading_heading4' },
                    { model: 'heading5', view: 'h5', title: 'Heading 5', class: 'ck-heading_heading5' },
                    { model: 'heading6', view: 'h6', title: 'Heading 6', class: 'ck-heading_heading6' }
                ]
            }
        })
        .catch(error => {
            console.error('CKEditor initialization error:', error);
            createFallbackEditor(textarea);
        });
}

function initializeEditorFields(useCkeditor) {
    document.querySelectorAll('.ckeditor-field').forEach(textarea => {
        if (useCkeditor && typeof ClassicEditor !== 'undefined') {
            initializeCKEditorField(textarea);
            return;
        }

        createFallbackEditor(textarea);
    });
}

window._initializeEditorFieldsReady = false;

function onCkeditorScriptLoaded() {
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            initializeEditorFields(true);
        });
    } else {
        initializeEditorFields(true);
    }
}

function onCkeditorScriptFailed() {
    console.warn('CKEditor CDN failed, using local editor fallback.');
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            initializeEditorFields(false);
        });
    } else {
        initializeEditorFields(false);
    }
}

window._initializeEditorFieldsReady = true;

if (window._ckEditorLoadState === 'loaded') {
    initializeEditorFields(true);
} else if (window._ckEditorLoadState === 'failed') {
    initializeEditorFields(false);
} else {
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            initializeEditorFields(typeof ClassicEditor !== 'undefined');
        });
    } else {
        initializeEditorFields(typeof ClassicEditor !== 'undefined');
    }
}
</script>
@endsection
