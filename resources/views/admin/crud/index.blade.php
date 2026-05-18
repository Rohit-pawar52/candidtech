@extends('admin.layout')

@section('title', $title)

@section('content')
<style>
    .table-image {
        max-width: 100px;
        max-height: 100px;
        border-radius: 4px;
    }
</style>

<div class="mb-4 d-flex justify-content-between align-items-center">
    <h4>{{ $title }} List</h4>
    <a href="{{ route($routeName . '.create') }}" class="btn btn-primary @if(in_array($routeName, ['admin.banners', 'admin.abouts', 'admin.company-details'])) d-none @endif">Add New</a>
</div>
<table class="table table-bordered bg-white">
    <thead>
        <tr>
            <th>#</th>
            @foreach(array_keys($fields) as $field)
                <th>{{ ucwords(str_replace('_', ' ', $field)) }}</th>
            @endforeach
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($records as $record)
            <tr>
                <td>{{ $loop->iteration }}</td>
                @foreach(array_keys($fields) as $field)
                    <td>
                        @if($fields[$field]['type'] === 'file' && !empty($record->{$field}))
                            @php
                                $imagePath = $record->{$field};
                                $imageUrl = \Illuminate\Support\Str::startsWith($imagePath, 'uploads/') ? asset('storage/' . $imagePath) : asset($imagePath);
                            @endphp
                            <img src="{{ $imageUrl }}" alt="{{ $field }}" class="table-image" onerror="this.src='{{ asset('upload/service1.jpeg') }}'; this.onerror=null;">
                        @elseif($fields[$field]['type'] === 'file')
                            <small class="text-muted">No image</small>
                        @else
                            {{ \Illuminate\Support\Str::limit($record->{$field} ?? '', 60) }}
                        @endif
                    </td>
                @endforeach
                <td class="text-nowrap">
                    <a href="{{ route($routeName . '.edit', $record->id) }}" class="btn btn-sm btn-secondary">Edit</a>
                    <form action="{{ route($routeName . '.destroy', $record->id) }}" method="post" class="d-inline-block @if(in_array($routeName, ['admin.banners', 'admin.abouts', 'admin.company-details'])) d-none @endif" onsubmit="return confirm('Delete this item?');">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="{{ count($fields) + 2 }}" class="text-center">No records found.</td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection
