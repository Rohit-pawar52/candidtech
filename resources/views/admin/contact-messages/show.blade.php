@extends('admin.layout')

@section('title', 'Message Details')

@section('content')
<div class="card shadow-sm">
    <div class="card-body">
        <dl class="row">
            <dt class="col-sm-3">Name</dt>
            <dd class="col-sm-9">{{ $message->name }}</dd>
            <dt class="col-sm-3">Email</dt>
            <dd class="col-sm-9">{{ $message->email }}</dd>
            <dt class="col-sm-3">Subject</dt>
            <dd class="col-sm-9">{{ $message->subject }}</dd>
            <dt class="col-sm-3">Message</dt>
            <dd class="col-sm-9">{{ $message->message }}</dd>
            <dt class="col-sm-3">Received</dt>
            <dd class="col-sm-9">{{ $message->created_at->format('Y-m-d H:i') }}</dd>
        </dl>
        <a href="{{ route('admin.contact-messages.index') }}" class="btn btn-outline-secondary">Back to messages</a>
    </div>
</div>
@endsection
