@extends('admin.admin.profile')

@section('form')
    <div class="card-body">
        <div class="row">
            <div class="col-sm-12">
                <form method="POST" action="{{ route('admin.admin.data.update', ['adminId' => $admin->id()]) }}">
                    @csrf

                    <div class="form-group row">
                        <label for="full-name" class="col-md-4 col-form-label text-md-right">{{ __('form.label.full_name') }}</label>

                        <div class="col-md-6">
                            <input id="full-name" type="text" name="full_name" value="{{ old('full_name', $admin->fullName()) }}"
                                   class="form-control @error('full_name') is-invalid @enderror" required>

                            @error('full_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="locale" class="col-md-4 col-form-label text-md-right">{{ __('form.label.locale') }}</label>

                        <div class="col-md-6">
                            <select id="locale" class="form-control @error('locale') is-invalid @enderror" name="locale">
                                @foreach ($supported_language_collection->all() as $language)
                                    <option value="{{ $language->code() }}"
                                            @if (old('locale', $user->locale()) === $language->code()) selected="selected" @endif>
                                        {{ $language->name(locale()->current()) }}
                                    </option>
                                @endforeach
                            </select>

                            @error('locale')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-4 col-form-label text-md-right">{{ __('form.label.roles') }}</label>

                        <div class="col-md-6 my-2">
                            @foreach ($role_collection->all() as $role)
                                <div class="form-check form-check-inline @if ($errors->has('roles')) is-invalid @endif">
                                    @if ($admin->isOfUser(Auth::user()) && $role->isOfType('admin'))
                                        <input type="hidden" name="roles[{{ $role->type() }}]" value="{{ $role->id() }}"/>
                                    @endif
                                    <input class="form-check-input" type="checkbox"
                                           @if ($admin->isOfUser(Auth::user()) && $role->isOfType('admin')) disabled="disabled" @endif
                                           name="roles[{{ $role->type() }}]" @if ($user->hasRole($role->type())) checked="checked" @endif
                                           id="role_{{ $role->type() }}" value="{{ $role->id() }}">
                                    <label class="form-check-label" for="role_{{ $role->type() }}">
                                        {{ $role->description(locale()->current()) }}
                                    </label>
                                </div>
                            @endforeach

                            @if ($errors->has('roles'))
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('roles') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                {{ __('form.button.update') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
