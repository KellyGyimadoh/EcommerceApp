<x-layout pagetitle="Products" pageurl="/products">



        <div class="card shadow-lg border-0 rounded-lg px-4">
            @if ($products->isEmpty())
                <p class="text-danger text-center fs-4">No Products Available</p>
                <div class="d-flex justify-content-center mb-3">
                    <a class="btn btn-warning" href="/products-add">Add New Product</a>
                </div>
            @else
                <div class="d-flex justify-content-end">
                    <div>
                        <form action="/searchproducts" method="GET">

                            <input type="search" name="q" placeholder="Search for Products" />
                            <select name="producttype">
                                <option value="all">All</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <button class="btn btn-success">search</button>
                        </form>
                    </div>
                </div>
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Products
                </div>
                <div class="card-body ">
                    <table class="table table-striped table-hover ">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Name</th>
                                <th scope="col">Description</th>
                                <th scope="col">Category</th>
                                <th scope="col">Price GH&#8373;</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Image</th>
                                <th scope="col">Status</th>
                                <th scope="col">Expiry Date</th>

                                <th scope="col">Action</th>

                            </tr>
                        </thead>
                        <tfoot class="table-dark">
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Name</th>
                                <th scope="col">Description</th>
                                <th scope="col">Category</th>
                                <th scope="col">Price GH&#8373;</th>
                                <th scope="col" >Quantity</th>
                                <th scope="col">Image</th>
                                <th scope="col">Status</th>
                                <th scope="col">Expiry Date</th>

                                <th scope="col">Action</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <td scope="row">{{ $loop->iteration }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->description }}</td>
                                    <td>{{ $product->category->name }}</td>
                                    <td>{{ $product->price }}</td>
                                    <td class="text-center">{{ $product->stock_quantity }}</td>
                                    <td><img src="{{asset('storage/'.$product->image) }}" alt="" class="img-fluid" width="50"/></td>
                                    <td>
                                        @if ($product->status === 0)
                                            <button type="button" class="btn btn-outline-primary">
                                                <span class="text-success">Unexpired</span></button>
                                        @else
                                            <button type="button" class="btn btn-outline-dark">
                                                <span class="text-danger">Expired</span></button>
                                        @endif
                                    </td>
                                    <td>{{ $product->expiry_date }}</td>
                                    <td>
                                        <div class="d-flex justify-content-between">
                                            <a role="button" data-bs-toggle="modal" data-bs-target="#editproduct"
                                                class="btn btn-success ms-2" data-id="{{ $product->id }}">Edit</a>
                                            <a role="button" data-bs-toggle="modal" data-bs-target="#deleteproduct"
                                                class="btn btn-danger ms-2" data-id="{{ $product->id }}">Delete</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        {{ $products->links() }}
                    </table>
                </div>
                <x-modal target="editproduct" action="Edit Product" modaltitle="Edit Product" formtarget="editproductform">
                    <x-forms.form id="editproductform" method="POST">
                        @method('PATCH')
                        <x-forms.input name="name" label="Name Of product" placeholder="name" />
                        <x-forms.input name="description" label="Description" placeholder="description" />
                        <x-forms.input name="price" type="number" label="Price" placeholder="price" />
                        <x-forms.input name="stock_quantity" label="Quantity" type="number" placeholder="Quantity" />
                        <select name="category_id" class="col-md-6 form-select mb-3">
                            <option value="">Select Category</option>
                            @foreach ($categories as $category )
                            <option value="{{$category->id}}">{{$category->name}}</option>

                            @endforeach
                        </select>
                        <x-forms.input name="status" label="Expiry Status" placeholder="Expiry Status" disabled/>

                        <x-forms.input type="date" name="expiry_date" label="Expiry Date"
                            placeholder="expiry date" />
                            <x-forms.input type="file" name="image" label="Product Image"/>

                    </x-forms.form>
                </x-modal>
                <x-modal target="deleteproduct" action="Delete product" modaltitle="Delete product?" formtarget="deleteproductform">
                    <p>Are you sure you want to delete this product</p>
                    <x-forms.form method="POST" id="deleteproductform">
                        @method('DELETE')

                    </x-forms.form>
                </x-modal>
            @endif
                <div class="d-flex justify-content-end mb-2">
                    <button type="submit" form="deleteallproduct" class="btn btn-danger">Delete all</button>
                </div>
        </div>

<x-forms.form action="/deleteall-products" id="deleteallproduct" method="POST" hidden>
@method("DELETE")
</x-forms.form>

</x-layout>
