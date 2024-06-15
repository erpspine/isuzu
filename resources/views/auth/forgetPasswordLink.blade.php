@extends('layouts.auth')

@section('content')
<div class="main-wrapper">
        <!-- ============================================================== -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- ============================================================== -->
        <div class="preloader">
            <div class="lds-ripple">
                <div class="lds-pos"></div>
                <div class="lds-pos"></div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Login box.scss -->
        <!-- ============================================================== -->
        <div class="auth-wrapper d-flex no-block justify-content-center align-items-center" style="background:url(../assets/images/background/login1.jpg) no-repeat center center; background-size: cover;">
            <div class="auth-box p-4 bg-white rounded">
                <div id="loginform">
                    <div class="logo">
                        <h3 class="box-title mb-3">RESET PASSWORD</h3>
                    </div>
                    <!-- Form -->
                    <div class="row">
                        @if (Session::has('message'))
                        <div class="alert alert-success" role="alert">
                           {{ Session::get('message') }}
                       </div>
                   @endif
                        <div class="col-12">
                            <form action="{{ route('reset.password.post') }}" method="POST">
                                <input type="hidden" name="token" value="{{ $token }}">
                        @csrf

                   

                <div class="form-group mb-4">
                    <div class="">
                        <input class="form-control " id="email_address" name="email" type="email" value="{{ old('email') }}"  required="" placeholder="Email"> 

                        @if ($errors->has('email'))
                        <span class="text-danger">{{ $errors->first('email') }}</span>
                    @endif

                       


 </div>
                </div>




                        <div class="form-group mb-4">
                            <div class="">
                                <input id="password" name="password" class="form-control @error('password') is-invalid @enderror" type="password" required placeholder="New Password" autocomplete="current-password">

                                @if ($errors->has('password'))
                                <span class="text-danger">{{ $errors->first('password') }}</span>
                            @endif

                               
 

         </div>
                        </div>

                        <div class="form-group mb-4">
                            <div class="">
                                <input d="password-confirm" name="password_confirmation"  class="form-control @error('password') is-invalid @enderror" type="password" required placeholder="Confirm Password" autocomplete="confirm-password">

                                @if ($errors->has('password_confirmation'))
                                <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
                            @endif

                               
 

         </div>
                        </div>

                              
                          
                                <div class="form-group text-center mt-4">
                                    <div class="col-xs-12">
                                        <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" type="submit"> Reset Password</button>
                                    </div>
                                </div>
                               
                               
                            </form>
                        </div>
                    </div>
                </div>
              
            </div>
        </div>
        

        
    </div>
@endsection
@section('after-scripts')


@endsection