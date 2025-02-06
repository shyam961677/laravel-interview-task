@extends('layouts.app')

@section('content')
    <h2>User Details</h2>
    <div class="card">
        <div class="card-header">
            {{ $user->name }}
        </div>
        <div class="card-body">
            @if($user->image)
                <img src="{{ asset($user->image) }}" alt="User Image" width="150" class="mb-3">
            @endif
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Mobile:</strong> {{ $user->mobile }}</p>
            <p><strong>Date:</strong> {{ $user->date }}</p>
            <p><strong>Role:</strong> {{ $user->role }}</p>
        </div>
    </div>
    <a href="{{ route('users.index') }}" class="btn btn-primary mt-3">Back</a>
@endsection
