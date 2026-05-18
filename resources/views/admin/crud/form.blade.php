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
                    @if($field['type'] === 'textarea')
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
function previewImage(input, fieldName) {
    const placeholderUrl = "{{ asset('upload/service1.jpeg') }}";
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const area = input.parentElement;
            area.innerHTML = '<img src="' + e.target.result + '" alt="Preview" class="image-preview" onerror="this.src=\'' + placeholderUrl + '\'; this.onerror=null;">';
            area.classList.add('has-image');
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
