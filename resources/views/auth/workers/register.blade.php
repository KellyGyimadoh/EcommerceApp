<!DOCTYPE html>
<html lang="en">
@include('components.pagebody.head',['pagetitle'=>'Register Account'])

<body class="bg-primary">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4">Register New Account</h3>
                                </div>
                                <div class="card-body">
                                    <x-forms.form method="POST" action="{{route('worker.signup')}}">
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                               <x-forms.input name="firstname" label="FirstName" placeholder="First Name" />
                                            </div>
                                            <div class="col-md-6">
                                                <x-forms.input name="lastname" label="LastName" placeholder="Last Name"/>

                                            </div>
                                        </div>
                                        <x-forms.input type="email" name="email" label="Email" placeholder="name@example.com"/>

                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                        <x-forms.input type="password" name="password" label="Password" placeholder="Your password"/>

                                            </div>
                                            <div class="col-md-6">
                                                <x-forms.input type="password" name="password_confirmation" label="Confirm Password" placeholder="Repeat password"/>

                                            </div>
                                        </div>
                                        <x-forms.input type="tel" name="phone" label="Phone Number" placeholder="Phone Number"/>
                                        <x-forms.input  name="address" label="Address" placeholder="P.O BOX"/>


                                        <div class="mt-4 mb-0">
                                            <div class="d-grid"><x-forms.button class="btn btn-primary btn-block" >Create Account</x-forms.button></div>
                                        </div>
                                    </x-forms.form>
                                </div>


                                <div class="card-footer text-center py-3 mt-3">
                                    <div class="small"><a href="{{route('login.worker')}}">Have an account? Workers login</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <div id="layoutAuthentication_footer" class="mt-4">
            @include('components.pagebody.footer')
        </div>
    </div>
    @include('components.pagebody.script')


</body>

</html>
