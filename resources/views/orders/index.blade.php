<x-layout pagetitle="My Orders" pageurl="/orders">



    <div class="card shadow-lg border-0 rounded-lg px-4">
        @if ($orders->isEmpty())
            <p class="text-danger text-center fs-4">No Orders Available</p>
            <div class="d-flex justify-content-center mb-3">
                <a class="btn btn-warning" href="/orders-add">Order Items</a>
            </div>
        @else
            <div class="mb-1">
                <h5 class="text-warning"> Orders Pending: {{ $totalorders }}</h5>
                <a href="/add-carts" role="button" class="btn btn-secondary mb-2">Place New Order</a>

            </div>

            <div class="d-flex justify-content-end">

                <div>
                    <form action="/searchorders" method="GET">

                        <input type="search" name="q" placeholder="Search for orders" />
                        <select name="orderstatus">
                            <option value="all">All</option>

                        </select>
                        <button class="btn btn-success">search</button>
                    </form>
                </div>
            </div>
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                My Orders
            </div>
            <div class="card-body ">
                <table class="table table-striped table-hover ">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Order ID</th>
                            <th scope="col">Items</th>

                            <th scope="col">Price GH&#8373;</th>
                            <th scope="col" class="text-center">Shipping Address</th>
                            <th scope="col">Order Date</th>
                            <th scope="col">Order Status</th>
                            <th scope="col">Payment Status</th>

                            <th scope="col" class="text-center">Action</th>

                        </tr>
                    </thead>
                    <tfoot class="table-dark">
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Order ID</th>
                            <th scope="col">Items</th>

                            <th scope="col">Price GH&#8373;</th>
                            <th scope="col" class="text-center">Shipping Address</th>
                            <th scope="col">Order Date</th>

                            <th scope="col">Order Status</th>
                            <th scope="col">Payment Status</th>





                            <th scope="col" class="text-center">Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr>
                                <td scope="row">{{ $loop->iteration }}</td>
                                <td>{{ $order->id }}</td>
                                <td>
                                    @foreach ($order->orderItems as $orderItem)
                                        {{ $orderItem->products->name }}@if (!$loop->last)
                                            ,
                                        @endif
                                    @endforeach
                                </td>
                                <td>{{ number_format($order->total_price, 2) }}</td>
                                <td>
                                    @if ($order->shipping_address)
                                        {{ $order->shipping_address }}
                                    @else
                                        <p class="text-danger text-center">N/A</p>
                                    @endif
                                </td>
                                <td>{{ $order->created_at }}</td>

                                <td>
                                    <div class="d-flex justify-content-between">
                                        @if ($order->order_status == 0)
                                            <div class="d-flex justify-content-between">
                                                <button class="btn btn-primary ms-2">Pending
                                                </button>

                                            </div>
                                        @elseif ($order->order_status == 1)
                                            <div class="d-flex justify-content-between">
                                                <button class="btn btn-warning ms-2">Processing
                                                </button>

                                            </div>
                                        @else
                                            <button class="btn btn-success ms-2">Completed
                                            </button>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-between">
                                        @if ($order->payment_status == 0)
                                            <div class="d-flex justify-content-between">
                                                <button class="btn btn-dark ms-2">Unpaid
                                                </button>

                                            </div>
                                        @else
                                            <button class="btn btn-info ms-2">Paid
                                            </button>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-between">
                                        @if ($order->payment_status==1)
                                        <div class=" ms-2"><a role="button" href="/payments-receipt/{{ $order->id }}"
                                            class="btn btn-sm btn-info">Print Receipt</a>
                                    </div>
                                       @else
                                        <div class=" ms-2"><a role="button" href="/payments/{{ $order->id }}"
                                                class="btn btn-sm btn-success">Make Payment</a>
                                        </div>
                                        @endif
                                        <div class=" ms-2">
                                            <a role="button" data-bs-toggle="modal" data-bs-target="#editorder"
                                                class="btn btn-dark text-wrap" data-id="{{ $order->id }}">Edit</a>

                                        </div>
                                        <div class=" ms-2"><a role="button" data-bs-toggle="modal"
                                                data-bs-target="#deleteorder" class="btn btn-danger"
                                                data-id="{{ $order->id }}">Delete</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    {{ $orders->links() }}
                </table>
            </div>

            <x-modal target="editorder" action="Edit Order" modaltitle="Edit Order?" formtarget="editorderform">

                <x-forms.form method="POST" id="editorderform">
                    @method('PATCH')
                    <x-forms.input name="shipping_address" label="Shipping Address" placeholder="Shipping Address" />
                </x-forms.form>
            </x-modal>
            <x-modal target="deleteorder" action="Remove Order" modaltitle="Remove Order?" formtarget="deleteorderform">
                <p>Are you sure you want to delete this Order</p>
                <x-forms.form method="POST" id="deleteorderform">
                    @method('DELETE')

                </x-forms.form>
            </x-modal>


        @endif

    </div>



</x-layout>
