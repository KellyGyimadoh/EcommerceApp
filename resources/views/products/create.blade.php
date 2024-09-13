<x-layout pagetitle=" Add New Categories" pageurl="/categories-add">
    <div class="row justify-content-center px-4">
        <div class="col">
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-header">
                    <h3 class="text-center font-weight-light my-1">Add New Product</h3>
                </div>
                <div class="card-body">
                    <x-forms.form method="POST" action="/products-add" enctype="multipart/form-data" autocomplete="on">
                        <div class="row">
                            <div class="col-md-6">
                                <x-forms.input name="name" label="Name Of product" placeholder="name"
                                    :value="old('name')" />
                            </div>
                            <div class="col-md-6">
                                <x-forms.input name="description" label="Description" placeholder="description"
                                    :value="old('description')" />
                            </div>
                        </div>
                        <div class="row">
                        <div class="col-md-6">
                            <x-forms.input name="price" type="number" step=".01" label="Price" placeholder="price"
                            value="{{ old('price') }}" />
                        </div>
                        <div class="col-md-6">
                             <x-forms.input name="stock_quantity" label="Quantity" type="number" placeholder="Quantity"
                            value="{{ old('stock_quantity') }}" />
                        </div>
                        </div>
                        <div class="row mt-1 mb-3">
                        <label for="status"><h6>Status</h6></label>
                        <div class="col-md-5"><x-forms.select name="status" class="col-md-6 form-select">
                            <option value="">Choose Expiry Status</option>
                            <option value="0">Not Expired</option>
                            <option value="1">Expired</option>
                        </x-forms.select></div>
                        <div class="col-md-5">
                            <x-forms.select name="category_id" class="col-md-6 form-select">
                            <option value="">Select Category</option>
                            @foreach ($categories as $category )
                            <option value="{{$category->id}}">{{$category->name}}</option>

                            @endforeach
                            </x-forms.select>
                    </div>
                        </div>
                        <div class="row mt-1">
                            <div class="col-md-6">
                        <x-forms.input type="date" name="expiry_date" label="Expiry Date"
                            placeholder="expiry date" />
                            </div>
                            <div class="col-md-6">
                                <x-forms.input type="file" name="image" label="Product Image"/>
                            </div>
                        </div>


                        <div class="mt-4 mb-0">
                            <div class="d-grid"><x-forms.button class="btn btn-primary btn-block">
                                    Add New Product</x-forms.button>
                            </div>
                        </div>

                    </x-forms.form>
                </div>



            </div>
        </div>
    </div>
</x-layout>
