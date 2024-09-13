<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Client\Request as ClientRequest;
use Illuminate\Http\Request;
use Twilio\Rest\Client;
class VerifyUserController extends Controller
{
    public function index(){
        return view('sms.verify');
    }

    public function verifyotp( Request $request)
    {
        // Find your Account SID and Auth Token at twilio.com/console
        // and set the environment variables. See http://twil.io/secure
        $request->validate([
            'smscode'=>['required'],
            'phone'=>['required','phone:AUTO,GH'],
        ]);
        $phone=$request->input('phone');
        if (strpos($phone, '+') !== 0) {
            // If the phone number doesn't start with '+', add the country code. Replace '233' with the appropriate country code
            $phone = '+233' . ltrim($phone, '0'); // Remove leading zero and prepend country code
        }
        $smscode=$request->smscode;
        $sid = getenv("TWILIO_SID");
        $token = getenv("TWILIO_TOKEN");
        $twilio = new Client($sid, $token);
        $verifysid = getenv("TWILIO_VERIFY_SERVICE_SID");

        try{$verification_check = $twilio->verify->v2
            ->services($verifysid)
            ->verificationChecks->create([
                "to" => $phone,
                "code" => $smscode,
            ]);

        if ($verification_check->status === 'approved') {
            return redirect('/dashboard')->with(['success' => 'Login successful']);
        } else {
            return redirect()->back()->with('error', 'Invalid code. Please try again.');
        }
    }catch(Exception $e){
         // Handle Twilio exceptions or other errors
         return redirect()->back()->with('error', 'An error occurred. Please try again.');

    }
    }

}
