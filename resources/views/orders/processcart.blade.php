<x-layout pagetitle="Place My Order" pageurl="/orders-add/{{ Auth::user()->id }}">
    <div class="row justify-content-center px-4">
        <div class="col">
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-header">
                    <h3 class="text-center font-weight-light my-1">Place My Order</h3>
                </div>
                <div class="card-body">
                    <div>
                        <table class="table table-dark table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Item</th>
                                    <th scope="col">Price GH&#8373;</th>
                                    <th scope="col" class="text-center">Quantity</th>
                                </tr>
                            </thead>
                            @foreach ($cartitems as $cartitem)
                                <tr class="table-info">
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="fw-bold ">{{ $cartitem->product->name }}</td>


                                    <td class="ms-2 me-auto">
                                        {{ number_format($cartitem->product->price, 2) }}
                                    </td>
                                    <td class="ms-2 text-center">
                                        <span class="badge text-bg-primary squared-pill">{{ $cartitem->quantity }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach

                        </table>
                        <div class="d-flex justify-content-start">
                            <div class="btn btn-outline-warning ms-2">Total Amount GH&#8373;:</div>
                            <div class="fs-4 ms-2">{{ number_format($totalAmount, 2) }}</div>
                        </div>


                    </div>
                    <x-forms.form method="POST" action="/orders">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <x-forms.input type="hidden" name="user_id" label="" placeholder="User ID"
                                    value="{{ $user->id }}" readonly />
                            </div>
                            <div class="col-md-6 mb-3">
                                <x-forms.input type="hidden" name="total_price" label="" placeholder=""
                                    value="{{ $totalAmount }}" readonly />
                            </div>

                        </div>
                        <div class="row">

                            <div class="col-md-6">
                                <x-forms.input name="shipping_address" label="Shipping Address"
                                    placeholder="Shipping Address" value="{{ old('shipping_address') }}" />
                            </div>
                        </div>


                </div>
            </div>


            <div class="mt-4 mb-0">
                <div class="d-grid">
                    <p class="text-center text-danger">"Please note that this action is irreversible and cannot be undone."</p>
                    <x-forms.button class="btn btn-primary btn-block">
                        Proceed to Order Items</x-forms.button>
                    <a role="button" href="{{url('/cartitems/'.session('cartid')."")}}" class="btn btn-secondary mt-3">Cancel</a>

                </div>
            </div>

            </x-forms.form>
        </div>



    </div>
    </div>
    </div>
</x-layout>
