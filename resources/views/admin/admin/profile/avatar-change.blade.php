@extends('admin.admin.profile')

@section('form')
    <div class="card-body">
        <div class="row">
            <div class="col-sm-12">
                <form method="POST" action="{{ route('admin.admin.avatar.change', ['adminId' => $admin->id()]) }}" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group row">
                        <div class="col-md-12 text-center">
                            <div class="kv-avatar">
                                <div class="file-loading">
                                    <input id="{{ Media::AVATAR() }}" name="{{ Media::AVATAR() }}" type="file" required class="@error('avatar') is-invalid @enderror">
                                </div>
                            </div>

                            @error('avatar')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-12 text-center">
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

@section('css-script')
    <style>
        .kv-avatar .krajee-default.file-preview-frame,.kv-avatar .krajee-default.file-preview-frame:hover {
            margin: 0;
            padding: 0;
            border: none;
            box-shadow: none;
            text-align: center;
        }
        .kv-avatar {
            display: inline-block;
        }
        .kv-avatar .file-input {
            display: table-cell;
            width: 213px;
        }
        .kv-reqd {
            color: red;
            font-family: monospace;
            font-weight: normal;
        }
    </style>
@endsection

@section('js-script')
    <script type="application/javascript">
        account().load_avatar(
            '{{ Media::AVATAR() }}',
            '{{ $user->locale() }}',
            '<img src="{{ $admin->avatar()->mediaSource() }}" class="img-thumbnail"/>' +
            '<h6 class="text-muted">{{ __('form.button.file_change') }}</h6>'
        );
    </script>
@endsection
