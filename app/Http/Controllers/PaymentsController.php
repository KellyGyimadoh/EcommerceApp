<?php

namespace App\Http\Controllers;

use App\Models\Payments;
use App\Http\Requests\StorePaymentsRequest;
use App\Http\Requests\UpdatePaymentsRequest;
use App\Jobs\SalesMailJob;
use App\Models\OrderItems;
use App\Models\Orders;
use App\Models\SalesMail;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\Exception\SignatureVerificationException;
use Stripe\PaymentIntent;
use Stripe\PaymentMethod;
use Stripe\Stripe;
use Stripe\StripeClient;
use Stripe\Webhook;
use Twilio\Rest\Client;
use UnexpectedValueException;

class PaymentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function checkout($orders)
    {
        $order = Orders::where('id', $orders)->first();
        $paymentstatus = Payments::where('order_id', $order->id)->first();
        if ($paymentstatus && $paymentstatus->payment_status === 'paid') {
            return redirect()->back()->with('error', 'Payment already made.');
        }
        $stripe = new StripeClient(env('STRIPE_SK'));

        $orderItems = OrderItems::where('order_id', $orders)->get();
        if ($orderItems->isEmpty()) {
            return redirect()->back()->with('error', 'No items in the order.');
        }
        $lineItems = $orderItems->map(function ($cartItem) {
            return [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $cartItem->products->name, // Use product name or other identifier
                    ],
                    'unit_amount' => $cartItem->products->price * 100, // Convert dollars to cents
                ],
                'quantity' => $cartItem->quantity, // Quantity of this specific product
            ];
        })->toArray();

        $checkout_session = $stripe->checkout->sessions->create([
            'line_items' =>  $lineItems,
            'mode' => 'payment',
            'client_reference_id' => $orders,
            'success_url' => route('order.success', [], true),
            'cancel_url' => route('order.cancel', [], true),
        ]);

        Payments::create([
            'payment_status' => 'pending',
            'order_id' => $orders,
        ]);

        return redirect($checkout_session->url);
    }



    public function webhook()
    {
        $endpoint_secret = env('STRIPE_WEBHOOK_SECRET');
        $payload = @file_get_contents('php://input');
        $event = null;
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];

        $stripe = new StripeClient(env('STRIPE_SK'));
        try {
            $event = Webhook::constructEvent($payload, $sig_header, $endpoint_secret);
        } catch (UnexpectedValueException $e) {
            return response('', 400);
        } catch (SignatureVerificationException $e) {
            return response('', 400);
        }

        switch ($event->type) {
            case 'checkout.session.completed':
                $session = $event->data->object;
                // Access the amount_total from the session
                $orderId = $session->client_reference_id;
                $amountPaid = $session->amount_total; // Amount in cents
                // Retrieve PaymentIntent
                $paymentIntentId = $session->payment_intent;
                $paymentIntent = $stripe->paymentIntents->retrieve($paymentIntentId);

                // Retrieve Payment Method from PaymentIntent
                $paymentMethodId = $paymentIntent->payment_method;
               // $paymentMethod = PaymentMethod::retrieve($paymentMethodId);

                // Now you have payment method details
                 // 'card', 'bank_transfer', etc.
                if ($paymentMethodId) {
                    $paymentMethod = $stripe->paymentMethods->retrieve($paymentMethodId);
                    $paymentMethodType = $paymentMethod->type;  // e.g., 'card'
                }else{
                    $paymentMethodType="N/A";
                }
                $payment = Payments::where('order_id', $orderId)->first();
                if ($payment && $payment->payment_status === 'pending') {
                    $payment->update([
                        'payment_status' => 'paid',
                        'amount_paid' => $amountPaid / 100,
                        'transaction_id' => $session->id,
                        'payment_method' => $paymentMethodType
                    ]);

                    Log::info('Payment updated successfully', ['payment' => $payment]);

                    // Reduce stock quantities
                    $order = Orders::where('id', $orderId)->first();
                    $order->update(['order_status' => 1, 'payment_status' => 1]);
                    foreach ($order->orderitems as $cartItem) {
                        $cartItem->products->stock_quantity -= $cartItem->quantity;
                        $cartItem->products->save();
                    }

                    // Optionally update order status
                    // or whatever status you use
                    $order->save();

                    $user= User::where('id',$order->user_id)->first();
                    $salesmail=SalesMail::create([
                        'subject'=>'THANKS FOR SHOPPING WITH US',
                        'body'=>'More goods available. Check them out here',
                        'recipient'=>$user->email,
                        'user_id'=>$user->id
                    ]);

                   if(dispatch(new SalesMailJob($salesmail))){
                    Log::info('mail sent');
                   }
                   $phone=0541402343;
                   $this->sendSalesMessage($phone,'Thanks for buying');
                }


                break;
            default:
                echo 'Received unknown event type ' . $event->type;
        }

        return response('');

        /* try {
                    $paymentIntentId = $session->payment_intent;
                    $paymentIntent = $stripe->paymentIntents->retrieve($paymentIntentId);

                    // Check if payment_method is available
                    $paymentMethodId = $paymentIntent->payment_method;
                    if ($paymentMethodId) {
                        $paymentMethod = $stripe->paymentMethods->retrieve($paymentMethodId);
                        $paymentMethodType = $paymentMethod->type;  // e.g., 'card'

                        $payment = Payments::where('order_id', $orderId)->first();
                        if ($payment && $payment->payment_status === 'pending') {
                            $payment->update([
                                'payment_status' => 'paid',
                                'amount_paid' => $amountPaid / 100,
                                'transaction_id' => $session->id,
                                'payment_method' => $paymentMethodType,
                            ]);

                            // Additional processing here...

                            $order = $payment->orders;
                            $order->update(['order_status' => 1, 'payment_status' => 1]);
                            foreach ($order->orderitems as $cartItem) {
                                $cartItem->product->stock_quantity -= $cartItem->quantity;
                                $cartItem->product->save();
                            }
                            $order->save();
                        }
                    } else {
                        Log::error('Payment method ID not available for PaymentIntent: ' . $paymentIntentId);
                    }
                } catch (\Exception $e) {
                    Log::error('Error handling payment method: ' . $e->getMessage());
                    return response('', 500);
                }*/
    }
    public function sendSalesMessage($phone, $messageBody)
    {
        // Get Twilio credentials from environment variables
        $sid = getenv("TWILIO_SID");
        $token = getenv("TWILIO_TOKEN");
        $twilio = new Client($sid, $token);

        // Format the phone number to E.164
        $formattedPhone = $this->formatPhoneNumber($phone);  // This function should ensure correct phone formatting

        try {
            // Send the SMS message
            $message = $twilio->messages->create(
                $formattedPhone, // To phone number
                [
                    'from' => getenv("TWILIO_PHONENUMBER"), // Your Twilio phone number
                    'body' => $messageBody // Message content
                ]
            );

            if ($message->sid) {
                return true; // SMS sent successfully
            }
        } catch (Exception $e) {
            // Handle errors
            Log::error('Error sending SMS: ' . $e->getMessage());
            return false;
        }
    }

    private function formatPhoneNumber($phone)
    {
        // Format phone number as +[CountryCode][PhoneNumber]
        // This is a basic implementation; you may need to adjust based on your requirements
        // For example, use a library like libphonenumber for more robust formatting
        $phone = preg_replace('/\D/', '', $phone); // Remove all non-numeric characters
        return '+233' . $phone; // Assuming country code is +1 for the US; adjust as necessary
    }

    /**
     * Show the form for creating a new resource.
     */
    public function printReceipt($orderid)
    {
        $payment=Payments::with('orders')->where('order_id',$orderid)->first();
        $order=Orders::where('id',$orderid)->first();
        return view('receipts.create',['payment'=>$payment,'order'=>$order]);
    }
    public function printPage($orderid)
{
    $order = Orders::findOrFail($orderid);
    $payment = Payments::where('order_id', $orderid)->first();

    return view('receipts.print', compact('order', 'payment'));
}


    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePaymentsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Payments $payments)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payments $payments)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePaymentsRequest $request, Payments $payments)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payments $payments)
    {
        //
    }
}
