@extends('frontpage')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('auth.register') }}</div>

                    <div class="card-body">

                        @if ($errors->has('code'))
                            <p class="alert alert-danger">
                                {{ $errors->first('code') }}
                            </p>
                        @endif

                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="form-group row">
                                <label for="name"
                                       class="col-md-4 col-form-label text-md-right">{{ __('user.name') }} *</label>

                                <div class="col-md-6">
                                    <input id="name" type="text"
                                           class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                           name="name" value="{{ old('name') }}" required autofocus>
                                    <small id="nameHelpBlock" class="form-text text-muted">
                                        {{  __('user.name_help') }}
                                    </small>
                                    @if ($errors->has('name'))
                                        <span class="alert-danger" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="name"
                                       class="col-md-4 col-form-label text-md-right">{{ __('user.username') }} *</label>

                                <div class="col-md-6">
                                    <input id="username" type="text"
                                           class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}"
                                           name="username" value="{{ old('username') }}" required maxlength="32">
                                    <small id="userNameHelpBlock" class="form-text text-muted">
                                        {{  __('user.username_help') }}
                                    </small>
                                    @if ($errors->has('username'))
                                        <span class="alert-danger" role="alert">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email"
                                       class="col-md-4 col-form-label text-md-right">{{ __('user.email') }} *</label>

                                <div class="col-md-6">
                                    <input id="email" type="email"
                                           class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                           name="email" required>
                                    <small id="emailHelpBlock" class="form-text text-muted">
                                        {{  __('user.email_help') }}
                                    </small>
                                    @if ($errors->has('email'))
                                        <span class="alert-danger" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password"
                                       class="col-md-4 col-form-label text-md-right">{{ __('user.password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" autocomplete="off"
                                           class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                           name="password" required>
                                    <small id="passwordHelpBlock" class="form-text text-muted">
                                        {{  __('user.password_help') }} <a
                                                href="https://github.com/improv-ee/improv-web/wiki/Password-requirements"
                                                target="_blank">{{ __('site.more_info') }}</a>
                                    </small>
                                    @if ($errors->has('password'))
                                        <span class="alert-danger" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password-confirm"
                                       class="col-md-4 col-form-label text-md-right">{{ __('user.password_again') }}</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control" autocomplete="off"
                                           name="password_confirmation" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="agree-tos" class="col-md-4 col-form-label text-md-right">
                                    {!! __('user.agree_tos', ['terms'=> '<a href="/#/terms" target="_blank">'.__('user.terms').'</a>']) !!}

                                </label>

                                <div class="col-md-6">
                                    <input type="checkbox" class="form-check-inline" value="1" id="agree-tos" name="tos" />
                                    @if ($errors->has('tos'))
                                        <p class="alert-danger" role="alert">
                                        <strong>{{ $errors->first('tos') }}</strong>
                                    </p>
                                    @endif
                                </div>

                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('auth.register') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
