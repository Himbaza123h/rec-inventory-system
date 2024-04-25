@extends('layouts.base')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-xs-4"></div>
        <div class="col-xs-4">
            <div class="panel panel-color panel-primary panel-pages" style="margin-top: 20%;">
                <div class="panel-heading">
                    <div class="bg-overlay"></div>
                    <h3 class="text-center m-t-10 text-white" style="font-family: Century Gothic;"> <strong>Rwanda Eye
                            Clinic</strong></h3>
                    <h4 class="text-center m-t-10 text-white" style="font-family: Century Gothic;">
                        <strong>Inventory</strong>
                    </h4>
                </div>

                <div class="panel-body">
                    <form class="form-horizontal m-t-20" method="post" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group">
                            <div class="col-xs-12">
                                <input class="form-control input-lg" type="text" required="Plz Provide Email Address" name="email" placeholder="Email Address">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <input class="form-control input-lg" type="password" name="password" required="your password plz" placeholder="Password">
                                @error('password')
                                <span class="invalid-password text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        @error('email')
                        <span class="invalid-email text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                        <div class="form-group">
                            <div class="col-xs-12">
                                <div class="checkbox checkbox-primary">
                                    <input id="checkbox-signup" type="checkbox" {{ old('remember') ? 'checked' : '' }}>
                                    <label for="checkbox-signup">
                                        Remember me
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group text-center m-t-40">
                            <div class="col-xs-12">
                                <button class="btn btn-primary btn-lg w-lg waves-effect waves-light" name="submit" type="submit" style="background-color:#425481 !important;border: 1px solid #425481 !important">{{ __('Sign In') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection