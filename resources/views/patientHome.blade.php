@extends('layouts.app')
@include('layouts.navigation')
<br><br><br><br><b><br><br><br><br>
@php
    $firstName = $user->first_name;
    $lastName = $user->last_name;
@endphp

<br><br><br><br><br>
@section('content')
<div class="container">
    <h1>Welcome, {{ $firstName }} {{ $lastName }}!</h1>
    <h2>Patient ID: {{$patient->patient_id}}</h2>
    <table>
        <tr>
            
        </tr>
    </table>
</div>
@endsection
