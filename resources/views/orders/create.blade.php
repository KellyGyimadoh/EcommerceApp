<x-layout pagetitle="Place New order" pageurl="/orders-add">
    <div class="row justify-content-center px-4">
        <div class="col">
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-header">
                    <h3 class="text-center font-weight-light my-1">Place New Order</h3>
                </div>
                <div class="card-body">
                    <x-forms.form method="POST" action="/orders-add" enctype="multipart/form-data" autocomplete="on">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <select name="user_id" class="form-select">
                                    <option value="">Select User</option>
                                    @foreach ($users as $user )
                                    <option value="{{$user->id}}">{{$user->firstname}}</option>

                                    @endforeach
                                </select>
                                              </div>
                            <div class="col-md-6">
                                <select name="order_status" class="form-select" disabled>
                                    <option value="0">Pending</option>
                                </select>
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
                <div class="d-grid"><x-forms.button class="btn btn-primary btn-block">
                        Proceed to Order Items</x-forms.button>
                </div>
            </div>

            </x-forms.form>
        </div>



    </div>
    </div>
    </div>
</x-layout>
