@extends('admin.admin.profile')

@section('form')
    <ul class="list-group list-group-flush">
        <li class="list-group-item d-flex justify-content-between align-items-center">
            {{ __('admin.admin.full_name') }}
            <span class="badge badge-light badge-pill">{{ $admin->fullName() }}</span>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            {{ __('admin.admin.email') }}
            <span class="badge badge-light badge-pill">{{ $admin->email() }}</span>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            {{ __('admin.admin.role') }}
            <span class="badge badge-light badge-pill">
                @foreach ($user->roles() as $role)
                    {{ $role }}
                @endforeach
            </span>
        </li>
    </ul>
@endsection
