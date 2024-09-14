@extends('admin.layouts.app')

@section('title', 'Edit User')

@section('content')
<h1>Edit User {{ $user->name }}</h1>

<form action="{{ route('users.update', $user->id) }}" method="POST">
    @method('PUT')
    @include('admin.users.components.form')
</form>
@endsection