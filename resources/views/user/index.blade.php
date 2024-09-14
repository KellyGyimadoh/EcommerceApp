<x-layout pagetitle="All Customers" pageurl="/users">



    <div class="card shadow-lg buser-0 rounded-lg px-4">
        @if ($users->isEmpty())
            <p class="text-danger text-center fs-4">No Customers Available</p>
            <div class="d-flex justify-content-center mb-3">
                <a class="btn btn-warning" href="/users-add">Add Customers</a>
            </div>
        @else
            <div class="mb-1">
                <h5 class="text-warning"> Total Users: {{ $totalusers }}</h5>
                <a href="/add-carts" role="button" class="btn btn-secondary mb-2">Add New Customer</a>

            </div>

            <div class="d-flex justify-content-end">

                <div>
                    <form action="/searchusers" method="GET">

                        <input type="search" name="q" placeholder="Search for User" />
                        <select name="account_type">
                            <option value="all">All</option>
                            <option value="staff">Staff</option>
                            <option value="admin">Admin</option>
                            <option value="customer">Customers</option>

                        </select>
                        <button class="btn btn-success">search</button>
                    </form>
                </div>
            </div>
            <div class="card-header">
                <i class="bi bi-people-fill"></i>
                All Customers
            </div>
            <div class="card-body ">
                <table class="table table-striped table-hover ">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">FirstName</th>
                            <th scope="col">LastName</th>

                            <th scope="col">Email</th>
                            <th scope="col">Phone</th>
                            <th scope="col" class="text-center"> Address</th>
                            <th scope="col" class="text-center">Status</th>


                            <th scope="col" class="text-center">Action</th>

                        </tr>
                    </thead>
                    <tfoot class="table-dark">
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">FirstName</th>
                            <th scope="col">LastName</th>
                            <th scope="col">Email</th>
                            <th scope="col">Phone</th>
                            <th scope="col" class="text-center"> Address</th>
                            <th scope="col" class="text-center">Status</th>
                            <th scope="col" class="text-center">Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td scope="row">{{ $loop->iteration }}</td>
                                <td>{{ $user->firstname }}</td>
                                <td>
                                  {{$user->lastname}}
                                </td>
                                <td>{{$user->email }}</td>
                                <td>{{$user->phone}}</td>

                                <td>{{ $user->address }}</td>

                                <td>
                                    <div class="d-flex justify-content-between">
                                        @if ($user->status == 0)
                                            <div class="d-flex justify-content-between">
                                                <button class="btn btn-danger ms-2">Suspended
                                                </button>

                                            </div>

                                        @else
                                            <button class="btn btn-success ms-2">Active
                                            </button>
                                        @endif
                                    </div>
                                </td>

                                <td>
                                    <div class="d-flex justify-content-between">

                                        <div class=" ms-2">
                                            <a role="button" data-bs-toggle="modal" data-bs-target="#edituser"
                                                class="btn btn-dark text-wrap" data-id="{{ $user->id }}">Edit</a>

                                        </div>



                                        <div class=" ms-2"><a role="button" data-bs-toggle="modal"
                                                data-bs-target="#deleteuser" class="btn btn-danger"
                                                data-id="{{ $user->id }}">Delete</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    {{ $users->links() }}
                </table>
            </div>

            <x-modal target="edituser" action="Edit user" modaltitle="Edit user?" formtarget="edituserform">

                <x-forms.form method="POST" id="edituserform">
                    @method('PATCH')
                    <x-forms.input name="firstname" label="First Name" placeholder="First Name" />
                    <x-forms.input name="lastname" label="Last Name" placeholder="Last Name" />
                    <x-forms.input name="email" label="Email" placeholder="Email" />
                    <x-forms.input name="phone" label="Phone" placeholder="Phone" />
                    <x-forms.input name="address" label="Address" placeholder=" Address" />
                    <x-forms.select name="account_type">
                        <option value="admin">Admin</option>
                        <option value="staff">Staff</option>
                        <option value="customer">Customer</option>
                    </x-forms.select>
                    <div class="mt-4">
                    <x-forms.select name="status" class="mt-2">
                        <option value="0">Suspend</option>
                        <option value="1">Activate</option>
                    </x-forms.select>
                    </div>
                    </x-forms.form>
            </x-modal>
            <x-modal target="deleteuser" action="Remove user" modaltitle="Remove user?" formtarget="deleteuserform">
                <p>Are you sure you want to delete this user</p>
                <x-forms.form method="POST" id="deleteuserform">
                    @method('DELETE')

                </x-forms.form>
            </x-modal>


        @endif

    </div>



</x-layout>
