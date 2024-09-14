@extends('admin.layouts.app')

@section('title', 'Detail User')

@section('content')
<h1>Detail User</h1>

<div class="card">
    <div class="card-body">
        <h5 class="card-title">{{ $user->name }}</h5>
        <h6 class="card-subtitle mb-2 text-muted">{{ $user->email }}</h6>
        <p class="card-text">{{ $user->created_at }}</p>
    </div>

    <x-alert />

    <!-- @can('is-owner', $user)
        You can delete
    @endcan -->

    @can('is-admin')
        <form action={{ route('users.destroy', $user->id) }} method="post">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Delete</button>
        </form>
    @endcan
</div>
@endsection