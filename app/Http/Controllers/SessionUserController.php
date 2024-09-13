<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Twilio\Rest\Client;
class SessionUserController extends Controller
{
    public function create(){
        return view('auth.login');
    }

    public function show(User $user){
        if($user){
            return view('user.edit',['user'=>$user]);
        }else{
            return back()->with('error','User not found');
        }
    }
    public function update(Request $request,User $user){
        $validatedData=$request->validate([
            'firstname'=>['required','max:15'],
            'lastname'=>['required','max:15'],
            'email'=>['email','required', Rule::unique('users')->ignore($user->id)],
            'phone'=>['nullable','max:10'],
            'address'=>['nullable'],
            'account_type'=>['required','string'],
        ]);
        if($user){
            $user->update($validatedData);
            return back()->with('success','Update Successful');
        }else{
            return back()->with('error','Failed to Update. Please try again');
        }
    }
    public function updatePassword(Request $request,User $user){
        $validatedData=$request->validate([
            'current_password'=>['required','current_password'],
            'password'=>['required','confirmed','min:4'],

        ]);
        if($user){
            if(!Hash::check($validatedData['current_password'],$user->password)){
            return back()->with('error','Current Password is incorrect');
            }

            $user->password=Hash::make($validatedData['password']);
            $user->save();
            return back()->with('success','Password update successful');
        }else{
            return back()->with('error','Invalid User');
        }
    }
    public function store(Request $request){
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


    public function destroy(){
        Auth::logout();
        return redirect('/');
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
}
