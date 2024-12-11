<style>
.container {
    max-width: 1000px;
    margin: 0 auto;
    padding: 20px;
    background-color: #f9f9f9;
    border: 1px solid #ddd;
    border-radius: 8px;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
}

h1 {
    text-align: center;
    font-size: 28px;
    color: #333;
    margin-bottom: 20px;
}

p {
    text-align: center;
    font-size: 16px;
    color: #666;
    margin-bottom: 20px;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
    background-color: #fff;
}

table th,
table td {
    text-align: center;
    padding: 10px;
    border: 1px solid #ddd;
    font-size: 14px;
}

table th {
    background-color: #0056b3;
    color: white;
    font-weight: bold;
}

table tbody tr:nth-child(even) {
    background-color: #f2f2f2;
}

table tbody tr:hover {
    background-color: lightgrey;
}

/* form {
    margin-top: 20px;
} */

.mb-3 {
    margin-bottom: 15px;
}

form .form-label {
    display: block;
    font-size: 14px;
    font-weight: bold;
    margin-bottom: 5px;
    color: #555;
}

form input[type="text"] {
    padding: 10px;
    font-size: 14px;
    border: 1px solid #ccc;
    border-radius: 5px;
    width: 100%;
    box-sizing: border-box;
}

button {
    padding: 10px 15px;
    font-size: 14px;
    border: none;
    border-radius: 5px;
    margin-right: 10px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

button.btn-success {
    background-color: #007bff;
    color: white;
}

button.btn-success:hover {
    background-color: #0056b3;
}

button.btn-danger {
    background-color: #dc3545;
    color: white;
}

button.btn-danger:hover {
    background-color: #c82333;
}

thead th {
    border-bottom: 2px solid #ddd;
}
table td {
        font-size: 12px;
        padding: 8px;
        color:black;
    }

@media (max-width: 768px) {
    .container {
        padding: 15px;
    }

    h1 {
        font-size: 22px;
    }

    table th,
    table td {
        font-size: 12px;
        padding: 8px;
        color:black;
    }

    form input[type="text"] {
        font-size: 12px;
        padding: 8px;
    }

    button {
        font-size: 12px;
        padding: 8px 12px;
    }
}
</style>
@extends('layouts.app')
@include('layouts.navigation')
<br><br><br>

@section('content')
<br><br><br>
<div class="container">
    <h1>Role Management</h1>
    <p>This page is accessed by Admin only.</p>
    
    <form method="GET" class="">
        <table class="table">
            <thead>
                <tr>
                    <th>Role</th>
                    <th>Access Level</th>
                </tr>
            </thead>
            <tbody>
                @foreach($roles as $role)
                    <tr>
                        <td>{{ $role->role }}</td>
                        <td>{{ $role->access_level }}</td>
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
@endsection
