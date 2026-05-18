@extends('admin.layout')

@section('title', 'Dashboard')

@section('content')
<div class="row g-4">
    @foreach($counts as $key => $value)
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title text-capitalize">{{ str_replace('-', ' ', $key) }}</h5>
                    <p class="display-6 mb-0">{{ $value }}</p>
                </div>
            </div>
        </div>
    @endforeach
</div>
<div class="mt-4">
    <p>Use the menu to manage homepage content and review contact messages.</p>
</div>
@endsection
