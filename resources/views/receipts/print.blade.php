<!-- resources/views/print-receipt.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Receipt</title>

    <link href="{{asset('assets/css/styles.css')}}" rel="stylesheet"  media="print"/>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body>
    <div class="receipt-container">
        <!-- Your receipt content here -->
        <h1>Receipt</h1>
        <p>Order ID: {{ $order->id }}</p>
        <p>Transaction ID: {{ $payment->transaction_id }}</p>
        <p>Items: @foreach ($order->orderitems as $item)

         {{ $item->products->name }} {{$item->quantity}} qty GH&#8373;{{$item->products->price}} <br> @endforeach</p>
        <p>Amount Paid: {{ $payment->amount_paid }}</p>
        <p>Status: {{ $payment->payment_status }}</p>
        <p>Payment Method: {{ $payment->payment_method ? $payment->payment_method : 'N/A' }}</p>
        <p>Payment Date: {{ $payment->updated_at }}</p>
    </div>
</body>
<script>
    window.print()
</script>
</html>
