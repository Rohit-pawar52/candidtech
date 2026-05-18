@extends('admin.layout')

@section('title', 'Contact Messages')

@section('content')
<div class="mb-4 d-flex justify-content-between align-items-center">
    <h4>Contact Messages</h4>
</div>
<table class="table table-bordered bg-white">
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Email</th>
            <th>Subject</th>
            <th>Received</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($messages as $message)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $message->name }}</td>
                <td>{{ $message->email }}</td>
                <td>{{ $message->subject }}</td>
                <td>{{ $message->created_at->format('Y-m-d H:i') }}</td>
                <td>
                    <a href="{{ route('admin.contact-messages.show', $message->id) }}" class="btn btn-sm btn-secondary">View</a>
                    <form action="{{ route('admin.contact-messages.destroy', $message->id) }}" method="post" class="d-inline-block" onsubmit="return confirm('Delete this message?');">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-center">No messages yet.</td>
            </tr>
        @endforelse
    </tbody>
</table>
<div>{{ $messages->links() }}</div>
@endsection
