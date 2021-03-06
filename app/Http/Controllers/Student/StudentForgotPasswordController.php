<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;

class StudentForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    public function __construct(){
        $this->middleware('guest:student');
    }
    public function showLinkRequestForm()
    {
        return view('student.passwords.email');
    }

    public function broker(){
        return Password::broker('students');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $this->validate($request,['email'=>'required|email']);
        $response=$this->broker()->sendResetLink($request->only('email'));
        $response==Password::RESET_LINK_SENT
        ?$this->sendResetLinkResponse($request,$response)
        :$this->sendResetLinkFailedResponse($request.$response);
    }
}
