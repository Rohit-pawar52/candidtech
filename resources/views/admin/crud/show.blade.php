@extends('admin.layout')

@section('title', $title . ' Details')

@section('content')
<style>
    .image-display {
        max-width: 400px;
        max-height: 400px;
        border-radius: 8px;
        border: 1px solid #ddd;
    }
</style>

<div class="card shadow-sm">
    <div class="card-body">
        <dl class="row">
            @foreach($fields as $name => $field)
                <dt class="col-sm-3">{{ $field['label'] }}</dt>
                <dd class="col-sm-9">
                    @if($field['type'] === 'file' && !empty($record->{$name}))
                        @php
                            $imagePath = $record->{$name};
                            $imageUrl = \Illuminate\Support\Str::startsWith($imagePath, 'uploads/') ? asset('storage/' . $imagePath) : asset($imagePath);
                        @endphp
                        <img src="{{ $imageUrl }}" alt="{{ $field['label'] }}" class="image-display" onerror="this.src='{{ asset('upload/service1.jpeg') }}'; this.onerror=null;">
                    @elseif($field['type'] === 'file')
                        <small class="text-muted">No image</small>
                    @else
                        {{ $record->{$name} }}
                    @endif
                </dd>
            @endforeach
        </dl>
        <a href="{{ route($routeName . '.index') }}" class="btn btn-outline-secondary">Back</a>
    </div>
</div>
@endsection
