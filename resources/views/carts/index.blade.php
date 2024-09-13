<x-layout pagetitle="Buy Items" pageurl="/add-carts">



    <div class="card shadow-lg border-0 rounded-lg px-4">
        @if ($products->isEmpty())
            <p class="text-danger text-center fs-4">No Products Available</p>
            <div class="d-flex justify-content-center mb-3">
                <a class="btn btn-warning" href="/products-add">Add Items to Cart</a>
            </div>
        @else
        <div class="mb-1">
           <h5 class="text-warning"> Items In Cart: {{$totalItems}}</h5>
        </div>
        @if(session('cartid'))
        <div>
            <a href="/cartitems/{{ session('cartid') }}" class="btn btn-success">View Cart Items</a>
        </div>
    @endif

            <div class="d-flex justify-content-end">

                <div>
                    <form action="/searchcartproducts" method="GET">

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
                            <th scope="col">Quantity Available</th>
                            <th scope="col">Image</th>

                            <th scope="col">Choose Quantity</th>

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
                            <th scope="col">Quantity Available</th>
                            <th scope="col">Image</th>
                            <th scope="col">Choose Quantity</th>


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
                                <td><img src="{{ asset('storage/' . $product->image) }}" alt="" class="img-fluid"
                                        width="50" /></td>
                                <td>
                                    <input type="number" name="quantity" form="addcart-{{ $product->id }}"
                                        value="1" min="1" max="{{ $product->stock_quantity }}"
                                        class="form-control" style="width: 70px;">
                                </td>
                                <td>
                                    <div class="d-flex justify-content-between">
                                        @if ($product->stock_quantity > 0)
                                            <div class="d-flex justify-content-between">
                                                <button form="addcart-{{ $product->id }}" class="btn btn-primary ms-2">Add
                                                    to Cart</button>

                                            </div>
                                        @else
                                            <span class="text-danger">Out of Stock</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            <x-forms.form method="POST" id="addcart-{{ $product->id }}" action="/add-carts" hidden>
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">

                            </x-forms.form>
                        @endforeach
                    </tbody>
                    {{ $products->links() }}
                </table>
            </div>




        @endif

    </div>



</x-layout>
