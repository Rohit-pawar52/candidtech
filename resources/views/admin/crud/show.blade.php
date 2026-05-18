@extends('admin.layout')

@section('title', $title . ' Details')

@section('content')
<div class="card shadow-sm">
    <div class="card-body">
        <dl class="row">
            @foreach($fields as $name => $field)
                <dt class="col-sm-3">{{ $field['label'] }}</dt>
                <dd class="col-sm-9">{{ $record->{$name} }}</dd>
            @endforeach
        </dl>
        <a href="{{ route($routeName . '.index') }}" class="btn btn-outline-secondary">Back</a>
    </div>
</div>
@endsection
