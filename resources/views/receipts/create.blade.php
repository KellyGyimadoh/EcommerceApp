<x-layout pagetitle="Receipt" pageurl="/payments-receipt/{{ $order->id }}">
    <div class="row justify-content-center px-4">
        <div class="col">
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-header">
                    <h3 class="text-center font-weight-light my-1">RECEIPT DETAILS</h3>
                </div>
                <div class="card-body">
                    <ol class="list-group list-group-numbered">
                        <li class="list-group-item d-flex justify-content-between align-items-start">
                            <div class="ms-2 me-auto">
                                <div class="fw-bold">OrderId</div>

                            </div>
                            <span class="badge text-bg-primary rounded-pill"> {{ $order->id }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-start">
                            <div class="ms-2 me-auto">
                                <div class="fw-bold">Transaction ID</div>

                            </div>
                            <span class="badge text-bg-primary  text-wrap ms-1"> {{ $payment->transaction_id }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-start">
                            <div class="ms-2 me-auto">
                                <div class="fw-bold">Items</div>
                            </div>
                            @foreach ($order->orderitems as $item)
                                <span class="badge text-bg-primary text-wrap ms-1"> {{ $item->products->name }}-{{$item->quantity}}</span>
                                      @endforeach

                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-start">
                            <div class="ms-2 me-auto">
                                <div class="fw-bold">Amount Paid</div>

                            </div>
                            <span class="badge text-bg-primary text-wrap ms-1">{{ $payment->amount_paid }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-start">
                            <div class="ms-2 me-auto">
                                <div class="fw-bold">Status</div>

                            </div>
                            <span class="badge text-bg-primary text-wrap ms-1 "> {{ $payment->payment_status }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-start">
                            <div class="ms-2 me-auto">
                                <div class="fw-bold">Payment Method</div>
                            </div>
                            <span class="badge text-bg-primary text-wrap ms-1">
                                {{ $payment->payment_method ? $payment->payment_method : 'N/A' }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-start">
                            <div class="ms-2 me-auto">
                                <div class="fw-bold">Payment Date</div>
                            </div>
                            <span class="badge text-bg-primary text-wrap ms-1"> {{ $payment->updated_at }}</span>
                        </li>
                    </ol>
                    <div class="mt-1 d-flex justify-content-evenly">
                    <div >
                        <button class="btn btn-outline-info" id="backbutton">Back</button>
                    </div>
                    <div >
                        <button class="btn  btn-outline-dark" id="printreceipt" >Print Receipt</button>
                    </div>
                    </div>
                </div>



            </div>
        </div>
    </div>
</x-layout>
<script>
    document.addEventListener("DOMContentLoaded", function() {
    const printReceiptButton = document.getElementById("printreceipt");
    const backButton = document.getElementById("backbutton");
    if (printReceiptButton) {
        printReceiptButton.addEventListener("click", function() {
            window.open('{{ route('receipt.print', ['orderid' => $order->id]) }}', '_blank');
        });
    }
    if(backButton){
        backButton.addEventListener('click',()=>{

            window.history.back();
        })
    }
});
</script>
