@extends('admin.layouts.app')

@section('title', 'Users')

@section('content')

<a href="{{ route('users.create') }}" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600 mb-4 inline-block">Create User</a>

<x-alert />

<table class="w-full table-auto">
    <thead class="bg-gray-200">
        <tr>
            <th class="px-4 py-2 text-left">Name</th>
            <th class="px-4 py-2 text-left">Email</th>
            <th class="px-4 py-2 text-left">Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($users as $user)
            <tr class="border-b">
                <td class="px-4 py-2 text-white">{{ $user->name }}</td>
                <td class="px-4 py-2 text-white">{{ $user->email }}</td>
                <td class="px-4 py-2 text-white">
                    <a href="{{ route('users.edit', $user->id) }}" class="text-blue-500 hover:text-blue-600">Edit</a>
                    <a href="{{ route('users.show', $user->id) }}" class="text-blue-500 hover:text-blue-600">Detail</a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="3" class="px-4 py-2 text-center">No users found</td>
            </tr>
        @endforelse
    </tbody>
</table>

{{ $users->links() }}
@endsection