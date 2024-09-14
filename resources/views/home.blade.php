<x-layout pagetitle="Home Catalog" pageurl="/dashboard">

    <div class="row ms-5 auto">
        @if ($products->isEmpty())
            <div class=" d-flex justify-content-center">
                <div>
                    <h4>No Product to Browse</h4>
                </div>
            </div>
        @else
            <div class="d-flex align-items-end flex-column mb-3 px-5 fixed-bottom">
                @if (session('cartid'))
                    <div class="mb-2">
                        <a href="/cartitems/{{ session('cartid') }}" class="btn btn-success">View Cart Items</a>
                    </div>
                @endif
                <div class="mb-1 d-flex justify-content-start">
                    <h5 class="text-warning"> Items In Cart: {{ $totalItems }}</h5>
                </div>
            </div>

            @foreach ($products as $product)
                <div class="col-md-4">
                    <div class="card shadow-lg border-0 rounded-lg mx-3 mb-3 auto" style="width: 18rem;">
                        <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" height="200" alt="...">
                        <div class="card-body">
                            <div class="d-flex justify-content-start">
                                <p class="card-text ">
                                <h6>Category</h6><span class="ms-4">{{ ucfirst($product->category->name) }}</span>
                            </p>
                            </div>
                            <h5 class="card-title text-center">{{ strtoupper($product->name) }}</h5>
                            <p class="card-text fw-bold text-warning text-center">GH&#8373;{{ $product->price }}</p>
                            @if ($product->stock_quantity <= 0)
                                <p class="card-text text-danger text-center">Out Of Stock</p>
                            @else
                                <p class="card-text text-center">Available: {{ $product->stock_quantity }}</p>

                                <div class="mb-2 d-flex justify-content-center">
                                    <div class="d-flex justify-content-evenly">
                                    <div><i class="bi bi-cart-plus-fill"></i></div>
                                    <div class="ms-2"><input type="number" name="quantity"
                                            form="dashboardcart-{{ $product->id }}" value="1" min="1"
                                            max="{{ $product->stock_quantity }}" class="form-control"
                                            style="width: 60px; height:23px;">
                                    </div >
                                    </div>
                                </div>
                            @endif
                            <div class="d-flex justify-content-center">
                                <button form="dashboardcart-{{ $product->id }}" class="btn btn-outline-dark">Add to
                                    Cart</button>
                            </div>


                        </div>
                    </div>

                </div>
                <x-forms.form method="POST" id="dashboardcart-{{ $product->id }}" action="/add-carts" hidden>
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">

                </x-forms.form>
            @endforeach
        @endif
    </div>

</x-layout>
