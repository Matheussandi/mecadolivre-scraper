@extends('admin.layouts.app')

@section('title', 'Create User')

@section('content')
<h1>Create User</h1>

<form action="{{ route('users.store') }}" method="post">
    @include('admin.users.components.form')
</form>
@endsection