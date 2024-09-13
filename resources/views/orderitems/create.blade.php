<x-layout pagetitle="Order Items" pageurl="/orderitems-add">
    <div class="row justify-content-center px-4">
        <div class="col">
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-header">
                    <h3 class="text-center font-weight-light my-1">Order Items</h3>
                </div>
                <div class="card-body">
                    <x-forms.form method="POST" action="/orderitems-add" enctype="multipart/form-data" autocomplete="on">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <x-forms.input name="order_id" label="Order ID" placeholder="Order ID"
                                    value="{{ $order->id }}" disabled />

                            </div>
                            <div class="col-md-6">
                                <select name="product_id" class="form-select" disabled>
                                    <option value="">Pending</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-md-6">
                                <x-forms.input name="price" label="Price"
                                    placeholder="Price" value="" />
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
