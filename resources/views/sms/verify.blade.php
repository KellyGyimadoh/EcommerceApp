<!DOCTYPE html>
<html lang="en">
@include('components.pagebody.head', ['pagetitle' => 'Verify OTP'])

<body class="bg-primary">
    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show alertbox" role="alert">
        {{ session('success') }}<span id="alertmessage"></span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
@if (session('error'))
<div class="alert alert-danger alert-dismissible fade show alertbox" role="alert">
    {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4">Verify OTP</h3>
                                </div>
                                <div class="card-body">
                                    <x-forms.form method="POST" action="/verify-sms">

                                        <x-forms.input name='phone' label='Phone Number'
                                            value="{{old('phone',Auth::user()->phone)}}" placeholder="0000" />
                                        <x-forms.input name='smscode' label='Sms Code' placeholder="0000" />

                                        <div class="d-flex align-items-center justify-content-between mt-4 mb-0">

                                            <x-forms.button type="submit">Submit</x-forms.button>
                                        </div>
                                    </x-forms.form>
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
