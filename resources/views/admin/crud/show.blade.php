@extends('admin.layout')

@section('title', $title . ' Details')

@section('content')
<div class="card shadow-sm">
    <div class="card-body">
        <dl class="row">
            @foreach($fields as $name => $field)
                <dt class="col-sm-3">{{ $field['label'] }}</dt>
                <dd class="col-sm-9">
                    @if($field['type'] === 'file' && !empty($record->{$name}))
                        <div class="mb-2">
                            <a href="{{ asset('storage/' . $record->{$name}) }}" target="_blank" class="btn btn-sm btn-primary">View File</a>
                            <br><small class="text-muted">{{ $record->{$name} }}</small>
                        </div>
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
