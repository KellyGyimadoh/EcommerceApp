<x-layout pagetitle="My Cart Items" pageurl="/cartitems/{{session('cartid')}}">



    <div class="card shadow-lg border-0 rounded-lg px-4">
        @if ($cartitems->isEmpty())
            <p class="text-danger text-center fs-4">No cartitems Available</p>
            <div class="d-flex justify-content-center mb-3">
                <a class="btn btn-warning" href="/add-carts">Add Items to Cart</a>
            </div>
        @else
            <div>

                <a href="/add-carts" role="button" class="btn btn-secondary mb-2">Add More Items to Cart</a>
                <x-forms.form method="POST" action="/carts/{{ $cartid }}">
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger">Delete Cart</button>
                </x-forms.form>

            </div>
            <div class="d-flex justify-content-end">

                <div>
                    <form action="/searchcartitems/{{$cartid}}" method="GET">

                        <input type="search" name="q" placeholder="Search for cartitems" />
                        <select name="cartitemtype">
                            <option value="all">All</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <button class="btn btn-success">search</button>
                    </form>
                </div>
            </div>
            <div class="card-header d-flex justify-content-between">
                <div> <i class="bi bi-cart-fill me-1"></i>
                    Cart items
                </div>
                <div class="d-flex justify-content-end">
                    <div class="btn btn-outline-warning ms-2">Total Amount GH&#8373;:</div>
                    <div class="fs-4 ms-2">{{ number_format($totalAmount, 2) }}</div>
                </div>

            </div>
            <div class="card-body ">
                <table class="table table-striped table-hover ">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Product Name</th>
                            <th scope="col">Price GH&#8373;</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Category</th>
                            <th scope="col">Total</th>

                            <th scope="col" class="text-center">Action</th>

                        </tr>
                    </thead>
                    <tfoot class="table-dark">
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Product Name</th>
                            <th scope="col">Price GH&#8373;</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Category</th>
                            <th scope="col">Total</th>

                            <th scope="col" class="text-center">Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($cartitems as $cartitem)
                            <tr>
                                <td scope="row">{{ $loop->iteration }}</td>
                                <td>{{ $cartitem->product->name }}</td>

                                <td>{{ number_format($cartitem->product->price, 2) }}</td>
                                <td class="text-center">{{ $cartitem->quantity }}</td>
                                <td>{{ $cartitem->product->category->name }}</td>
                                <td>{{ number_format($cartitem->quantity * $cartitem->product->price, 2) }}</td>
                                <td>
                                    <div class="d-flex justify-content-evenly">
                                        <div> <a role="button" data-bs-toggle="modal" data-bs-target="#editcartitem"
                                                class="btn btn-success " data-id="{{ $cartitem->id }}">
                                                Edit</a>
                                        </div>
                                        <div>
                                            <a role="button" data-bs-toggle="modal" data-bs-target="#deletecartitem"
                                                class="btn btn-danger" data-id="{{ $cartitem->id }}">Remove From
                                                Cart</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                    {{ $cartitems->links() }}
                </table>
                <div class="d-flex justify-content-end">

                    <a href="/orders-add/{{Auth::user()->id}}" class="btn btn-warning">Proceed to Order</a>
                </div>

            </div>


            <x-modal target="editcartitem" action="Edit Item" modaltitle="Edit Item" formtarget="editcartitemform">
                <x-forms.form id="editcartitemform" method="POST">
                    @method('PATCH')
                    <x-forms.input type="hidden" name="product_id" label="Id Of product" placeholder="ID" readonly />
                    <x-forms.input name="productname" label="Name Of product" placeholder="name" disabled />
                    <x-forms.input name="price" label="Price" placeholder="price" disabled />
                    <x-forms.input name="quantity" type="number" label="Quantity" type="number"
                        placeholder="Quantity" />


                </x-forms.form>
            </x-modal>
            <x-modal target="deletecartitem" action="Remove Item" modaltitle="Remove product?"
                formtarget="deletecartitemform">
                <p>Are you sure you want to remove this item</p>
                <x-forms.form method="POST" id="deletecartitemform">
                    @method('DELETE')

                </x-forms.form>
            </x-modal>

        @endif

    </div>



</x-layout>
