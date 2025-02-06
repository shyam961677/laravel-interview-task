@extends('layouts.app')

@section('content')
    <h2>Create New User</h2>

    @include('common.error')
    <div class="row">
        <div class="col-6 col-offset-lg-3">
            <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="mb-3">
                    <label for="name" class="form-label">Name*</label>
                    <input type="text" class="form-control" id="name" name="name" required value="{{ old('name') }}">
                </div>
                
                <div class="mb-3">
                    <label for="email" class="form-label">Email*</label>
                    <input type="email" class="form-control" id="email" name="email" required value="{{ old('email') }}">
                </div>
                
                <div class="mb-3">
                    <label for="password" class="form-label">Password*</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                
                <div class="mb-3">
                    <label for="mobile" class="form-label">Mobile</label>
                    <input type="text" class="form-control" id="mobile" name="mobile" value="{{ old('mobile') }}">
                </div>
                
                <div class="mb-3">
                    <label for="date" class="form-label">Date (DOB)</label>
                    <input type="date" class="form-control" id="date" name="date" value="{{ old('date') }}">
                </div>
                
                <div class="mb-3">
                    <label for="role" class="form-label">Role*</label>
                    <select name="role" id="role" class="form-select" required>
                        <option value="User" {{ old('role') == 'User' ? 'selected' : '' }}>User</option>
                        <option value="Admin" {{ old('role') == 'Admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                </div>
                
                <div class="mb-3">
                    <label for="image" class="form-label">Image</label>
                    <input type="file" class="form-control" id="image" name="image">
                </div>
                
                <button type="submit" class="btn btn-success">Submit</button>
                <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
    
@endsection
