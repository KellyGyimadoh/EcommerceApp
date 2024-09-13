<?php

namespace App\Http\Controllers;

use App\Models\Workers;
use App\Http\Requests\StoreWorkersRequest;
use App\Http\Requests\UpdateWorkersRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Twilio\Rest\Client;

class WorkersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('auth.workers.register');
    }

    public function login(){
        return view('auth.workers.login');
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreWorkersRequest $request)
    {
        dd('reac');
        $validatedData= $request->validated();

        $worker=Workers::create($validatedData);

 // Log the worker in using the 'worker' guard
  Auth::guard('worker')->login($worker);
  $request->session()->regenerate();

        // if(!Auth::guard('worker')->check()){

        //     Auth::guard('worker')->login($user);
        // }

        return redirect('/dashboard')->with('success','Registration success-login successful');




    }
    public function verify(Request $request){
        $validatedData=$request->validate([
            'email'=>['email','required'],
            'password'=>['required']
        ]);

        if(!Auth::attempt($validatedData)){
           throw ValidationException::withMessages(
            ['email'=>'Credentials do not  match!']
           );
        }

        $request->session()->regenerate();
        $user= Auth::user();

        if ($user->phone) {
            // Send SMS code
            $this->sendsmscode($user->phone);

            // Redirect to the SMS verification page
            return redirect()->route('sms.verifyform');
        } else {
            return redirect('/dashboard')->with(['success' => 'Login successful', 'user' => $user]);
        }

    }

    private function sendsmscode($phone)
    {
        // Find your Account SID and Auth Token at twilio.com/console
        // and set the environment variables. See http://twil.io/secure
        $sid = getenv("TWILIO_SID");
        $token = getenv("TWILIO_TOKEN");
        $verifysid = getenv("TWILIO_VERIFY_SERVICE_SID");
        $twilio = new Client($sid, $token);
        $formattedphone= $this->formatPhoneNumber($phone);


        $verification = $twilio->verify->v2
            ->services($verifysid)
            ->verifications->create(
                $formattedphone,// to
                "sms" // channel
            );
            if($verification->status==='approved'){
                return true;
            }else{
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
     * Display the specified resource.
     */
    public function show(Workers $workers)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Workers $workers)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWorkersRequest $request, Workers $workers)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Workers $workers)
    {
        //
    }
}
