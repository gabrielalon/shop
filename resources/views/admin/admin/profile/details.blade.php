<div class="col-md-3">
    <ul class="list-group">
        <li class="list-group-item text-muted"><i class="fa fa-dashboard"></i> {{ __('admin.admin.details') }}</li>
        <li class="list-group-item text-center">
            @if (true === $admin->avatar()->exists())
                {!! $admin->avatar()->mediaHtml(['class' => 'img-thumbnail']) !!}
            @else
                -
            @endif
        </li>
        <a href="{{ route('admin.admin.avatar.show', ['adminId' => $admin->id()]) }}"
           class="list-group-item list-group-item-action @if (Route::is('admin.admin.avatar.show')) active @endif">
            {{ __('admin.admin.action.avatar_change') }}
        </a>
        <a href="{{ route('admin.admin.data.show', ['adminId' => $admin->id()]) }}"
           class="list-group-item list-group-item-action @if (Route::is('admin.admin.data.show')) active @endif">
            {{ __('admin.admin.action.data_update') }}
        </a>
        <a href="{{ route('admin.admin.password.reset.show', ['adminId' => $admin->id()]) }}"
           class="list-group-item list-group-item-action @if (Route::is('admin.admin.password.reset.show')) active @endif">
            {{ __('admin.admin.action.password_reset') }}
        </a>
    </ul>
</div>
