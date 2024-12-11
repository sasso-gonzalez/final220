<style>
.container1{
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}
.container.admin-dashboard {
    border-left: 5px solid #4db8ff;
    background-color: #eef7fc;
    width:100%;
}


.container.admin-dashboard h1 {
    color: #4db8ff;
}

</style>
@extends('layouts.app')
@include('layouts.navigation')
<link rel="stylesheet" href="{{ asset('CSS/employeesHomes.css') }}">
<br><br><br>

@section('content') 
<div class="container1">
    <div class="container admin-dashboard">
        <h1>Welcome, Admin!</h1>
        <p>This is the Admin Dashboard.</p>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
    </div>
    </div>
@endsection


                        