<!DOCTYPE html>
<html lang="en">
@include('components.pagebody.head',['pagetitle'=>'Login'])

<body class="bg-primary">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4">Login</h3>
                                </div>
                                <div class="card-body">
                                    <x-forms.form method="POST" action="login">

                                        <x-forms.input type="email" name='email' label='Email' placeholder="example@mail.com"/>
                                        <x-forms.input name='password' label='Password' type="password"  placeholder="Password"/>

                                        <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                            <a class="small" href="password.html">Forgot Password?</a>
                                        <x-forms.button type="submit">Login</x-forms.button>
                                        </div>
                                    </x-forms.form>
                                </div>
                                <div class="card-footer text-center py-3">
                                    <div class="small"><a href="{{route('register')}}">Need an account? Sign up!</a></div>
                                </div>
                                <div class="card-footer text-center py-3">
                                    <div class="small"><a href="{{route('register.worker')}}">Workers Sign up here!</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <div id="layoutAuthentication_footer">
            @include('components.pagebody.footer')
        </div>
    </div>
    @include('components.pagebody.script')


</body>

</html>
