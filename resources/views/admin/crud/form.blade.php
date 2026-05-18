@extends('admin.layout')

@section('title', $record ? 'Edit ' . $title : 'Create ' . $title)

@section('content')
<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ $record ? route($routeName . '.update', $record->id) : route($routeName . '.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            @if($record)
                @method('PUT')
            @endif

            @foreach($fields as $name => $field)
                <div class="mb-3">
                    <label class="form-label">{{ $field['label'] }}</label>
                    @if($field['type'] === 'textarea')
                        <textarea class="form-control" name="{{ $name }}" rows="4">{{ old($name, $record->{$name} ?? '') }}</textarea>
                    @elseif($field['type'] === 'file')
                        <input type="file" class="form-control" name="{{ $name }}" accept="image/*">
                        @if($record && $record->{$name})
                            <small class="d-block mt-2">
                                <a href="{{ asset('storage/' . $record->{$name}) }}" target="_blank">View current file</a>
                            </small>
                        @endif
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
@endsection
