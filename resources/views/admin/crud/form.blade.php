@extends('admin.layout')

@section('title', $record ? 'Edit ' . $title : 'Create ' . $title)

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/ckeditor5@latest/build/ckeditor5.min.css">
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

<script src="https://cdn.jsdelivr.net/npm/ckeditor5@latest/build/ckeditor5.umd.js"></script>
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

// Initialize CKEditor for all ckeditor fields
document.addEventListener('DOMContentLoaded', function() {
    const { ClassicEditor, Essentials, Paragraph, Bold, Italic, Underline, Heading, List, Link, BlockQuote, Alignment } = CKEDITOR;

    document.querySelectorAll('.ckeditor-field').forEach(textarea => {
        ClassicEditor
            .create(textarea, {
                plugins: [Essentials, Paragraph, Bold, Italic, Underline, Heading, List, Link, BlockQuote, Alignment],
                toolbar: {
                    items: [
                        'heading', '|',
                        'bold', 'italic', 'underline', '|',
                        'alignment', '|',
                        'bulletedList', 'numberedList', '|',
                        'blockQuote', 'link', '|',
                        'undo', 'redo'
                    ]
                }
            })
            .catch(error => {
                console.error('CKEditor initialization failed:', error);
            });
    });
});
</script>
@endsection
