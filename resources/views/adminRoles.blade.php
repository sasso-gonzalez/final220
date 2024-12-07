@extends('layouts.app')
@include('layouts.navigation')
<br><br><br><br>

@section('content')
<div class="container">
    <h1>Role Management</h1>
    <p>This page is accessed by Admin only.</p>
    
    <form method="GET" class="">
        <table class="table">
            <thead>
                <tr>
                    <th>Role</th>
                    <th>Access Level</th>
                    <!-- <th>Actions</th> -->
                </tr>
            </thead>
            <tbody>
                @foreach($roles as $role)
                    <tr>
                        <td>{{ $role->role }}</td>
                        <td>{{ $role->access_level }}</td>
                        <!-- <td><a href="#">Edit</a></td> Mr hassan said no edit/delete i think? -serena-->
                    </tr>
                @endforeach
            </tbody>
        </table>
    </form>
    <br>
    <thead>
        <tr>
            <th>Role</th>
            <th>Access Level</th><br>
        </tr>
    </thead>
    <tbody>
        <form action="{{ route('admin.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <x-input-label for="role" class="form-label">New Role</x-input-label>
                <input type="text" id="role" name="role" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="access_level" class="form-label">Access Level</label>
                <input type="text" id="access_level" name="access_level" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success">OK</button>
            <button type="reset" class="btn btn-danger">Cancel</button>
        </form>
    </tbody>
</div>

