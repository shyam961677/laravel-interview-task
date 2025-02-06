@extends('layouts.app')

@section('content')
    <h2>Edit User</h2>

    @include('common.error')
    <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="mb-3">
            <label for="name" class="form-label">Name*</label>
            <input type="text" class="form-control" id="name" name="name" required value="{{ old('name', $user->name) }}">
        </div>
        
        <div class="mb-3">
            <label for="email" class="form-label">Email*</label>
            <input type="email" class="form-control" id="email" name="email" required value="{{ old('email', $user->email) }}">
        </div>
        
        <div class="mb-3">
            <label for="password" class="form-label">Password (leave blank if not changing)</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>
        
        <div class="mb-3">
            <label for="mobile" class="form-label">Mobile</label>
            <input type="text" class="form-control" id="mobile" name="mobile" value="{{ old('mobile', $user->mobile) }}">
        </div>
        
        <div class="mb-3">
            <label for="date" class="form-label">Date (DOB)</label>
            <input type="date" class="form-control" id="date" name="date" value="{{ old('date', $user->date) }}">
        </div>
        
        <div class="mb-3">
            <label for="role" class="form-label">Role*</label>
            <select name="role" id="role" class="form-select" required>
                <option value="User" {{ (old('role', $user->role) == 'User') ? 'selected' : '' }}>User</option>
                <option value="Admin" {{ (old('role', $user->role) == 'Admin') ? 'selected' : '' }}>Admin</option>
            </select>
        </div>
        
        <div class="mb-3">
            <label for="image" class="form-label">Image</label>
            @if($user->image)
                <div class="mb-2">
                    <img src="{{ asset($user->image) }}" alt="User Image" width="100">
                </div>
            @endif
            <input type="file" class="form-control" id="image" name="image">
        </div>
        
        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
@endsection
