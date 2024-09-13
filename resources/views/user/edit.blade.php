<x-layout pagetitle="{{ $user->firstname }} Profile" pageurl="/user/{{ $user->id }}">
    <div class="row justify-content-center px-4">
        <div class="col">
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-header">
                    <h3 class="text-center font-weight-light my-1">My Profile</h3>
                </div>
                <div class="card-body">
                    <x-forms.form method="POST" action="/user/{{ $user->id }}" enctype="multipart/form-data"
                        autocomplete="on">
                        @method('PATCH')
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <x-forms.input name="firstname" label="First Name" placeholder="First Name"
                                    value="{{ $user->firstname }}" />

                            </div>
                            <div class="col-md-6 mb-3">
                                <x-forms.input name="lastname" label="Last Name" placeholder="Last Name"
                                    value="{{ $user->lastname }}" />

                            </div>
                        </div>
                        <div class="row">

                            <div class="col-md-6">
                                <x-forms.input name="email" type="email" label="Email" placeholder="Email"
                                    value="{{ $user->email }}" />
                            </div>
                            <div class="col-md-6">
                                <x-forms.input name="phone" label="Phone" placeholder="Phone"
                                    value="{{ $user->phone }}" />
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <x-forms.select name="account_type">
                                    <option value="">Select Account Type</option>


                                    @if ($user->account_type==='admin')
                                    @php
                                    $accountTypes = ['admin', 'staff'];
                                    // Define available account types
                                    @endphp
                                     @else
                                     @php
                                     $accountTypes = ['staff'];
                                     // Define available account types
                                     @endphp
                                     @endif
                                    @foreach ($accountTypes as $type)
                                        <option value="{{ $type }}" {{ $user->account_type == $type ? 'selected' : '' }}>
                                            {{ ucwords($type) }}
                                        </option>
                                    @endforeach

                                </x-forms.select>

                            </div>
                            <div class="col-md-6">
                                <x-forms.input name="address" label="Address" placeholder="Address"
                                    value="{{ $user->address }}" />
                            </div>
                        </div>

                        <div class="mt-4 mb-0 d-flex justify-content-center">
                            <div><x-forms.button class="btn btn-primary btn-block">
                                    Update Details</x-forms.button>
                            </div>
                        </div>

                    </x-forms.form>
                </div>
            </div>



        </div>

        <hr class="mt-3 border border-danger border-2 opacity-50">
        <div class="col">
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-header">
                    <h3 class="text-center font-weight-light my-1">Change My Password</h3>
                </div>
                <div class="card-body">
                    <x-forms.form method="POST" action="/user-password/{{ $user->id }}">
                        @method('PATCH')
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <x-forms.input name="current_password" label="Current Password" placeholder="Current Password"
                                />

                            </div>
                            <div class="col-md-6 mb-3">
                                <x-forms.input name="password" label="New Password" placeholder="New Password"
                                     />

                            </div>
                            <div class="col-md-6 mb-3 offset-md-6">
                                <x-forms.input name="password_confirmation" label="Confirm Password" placeholder="Confirm Password"
                                     />

                            </div>
                        </div>

                        <div class="mt-4 mb-0 d-flex justify-content-center">
                            <div><x-forms.button class="btn btn-primary btn-block">
                                    Change Password</x-forms.button>
                            </div>
                        </div>

                    </x-forms.form>





                </div>
            </div>
        </div>
    </div>
</x-layout>
