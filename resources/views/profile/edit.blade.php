@extends('layouts.app')

@section('content')
    <h2>Edit Profil</h2>

    <form method="POST" action="{{ route('profile.update') }}">
        @csrf
        @method('PATCH')

        <label>Nama:</label>
        <input type="text" name="name" value="{{ $user->name }}"><br>

        <label>Email:</label>
        <input type="email" name="email" value="{{ $user->email }}"><br>

        <button type="submit">Update</button>
    </form>
@endsection
