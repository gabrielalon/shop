@extends('layouts.admin')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('admin.admin.list.header') }}</div>

                <div class="card-body">
                    <div class="card-body">
                        <blockquote class="blockquote mb-0 text-right">
                            <footer class="blockquote-footer">{{ __('admin.admin.list.manage') }}</footer>
                        </blockquote>
                    </div>
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">{{ __('admin.admin.logo') }}</th>
                            <th scope="col">{{ __('admin.admin.full_name') }}</th>
                            <th scope="col">{{ __('admin.admin.email') }}</th>
                            <th scope="col">{{ __('admin.admin.manage') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php $counter = 1 @endphp
                        @foreach ($admin_collection->all() as $admin)
                            <tr>
                                <th scope="row" class="align-middle">{{ $counter++ }}</th>
                                <td class="align-middle">
                                    @if (true === $admin->avatar()->exists())
                                        <img src="{{ $admin->avatar()->mediaSource() }}"
                                             class="img-thumbnail d-inline-block" style="height: 50px;" />
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="align-middle">{{ $admin->fullName() }}</td>
                                <td class="align-middle">{{ $admin->email() }}</td>
                                <td class="align-middle">
                                    <a href="{{ route('admin.admin.profile.show', ['adminId' => $admin->id()]) }}"
                                       class="badge badge-light text-dark">
                                        <i class="fa fa-search"></i>
                                    </a>
                                    <a href="{{ route('admin.admin.data.show', ['adminId' => $admin->id()]) }}"
                                       class="badge badge-light text-dark">
                                        <i class="fa fa-pencil-square-o"></i>
                                    </a>
                                    @if (false === $admin->isOfUser(Auth::user()))
                                        <a class="badge badge-light text-danger"
                                           href="{{ route('admin.admin.remove', ['adminId' => $admin->id()]) }}"
                                           onclick="event.preventDefault();
                                                    document.getElementById('account-remove-{{ $admin->id() }}').submit();">
                                            <i class="fa fa-trash-o"></i>
                                        </a>

                                        <form id="account-remove-{{ $admin->id() }}"
                                              action="{{ route('admin.admin.remove', ['adminId' => $admin->id()]) }}"
                                              method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
