@extends('admin.layout')

@section('title', $title)

@section('content')
<div class="mb-4 d-flex justify-content-between align-items-center">
    <h4>{{ $title }} List</h4>
    <a href="{{ route($routeName . '.create') }}" class="btn btn-primary">Add New</a>
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
                    <td>{{ \Illuminate\Support\Str::limit($record->{$field} ?? '', 60) }}</td>
                @endforeach
                <td class="text-nowrap">
                    <a href="{{ route($routeName . '.edit', $record->id) }}" class="btn btn-sm btn-secondary">Edit</a>
                    <form action="{{ route($routeName . '.destroy', $record->id) }}" method="post" class="d-inline-block" onsubmit="return confirm('Delete this item?');">
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
