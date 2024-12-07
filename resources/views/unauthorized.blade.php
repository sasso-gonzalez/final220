@extends('layouts.app')

@section('content')

<div class="NUH_UH">
    <h1>Nuh Uh</h1>
    <br>
    <h2>unauthorized access</h2>
    <br>
    <img src="https://c.tenor.com/8Dr6NEjB9K4AAAAC/nope-no.gif" alt="NOPE">
    <form action="{{ route('your.route.name') }}" method="POST">
        @csrf
        <button type="submit">NOW LEAVE!!!</button>
    </form>

</div>


@endsection