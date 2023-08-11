<?php

namespace App\Http\Controllers;

use App\Mail\EmailCampaignMail;
use App\Models\Customer;
use App\Models\EmailCampaign;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailCampaignController extends Controller
{
    use HttpResponses;
    function PromotionalPage(){
        return view('pages.dashboard.promotional-page');
    }
    public function SendEmailCampaign(Request $request)
    {
        try {
            $offerSub = $request->input('offerSub');
            $offerBody = $request->input('offerBody');
            $user_id = $request->header('id');
            $emails = Customer::where('user_id', $user_id)->pluck('email');
            foreach ($emails as $email) {
                EmailCampaign::create([
                    'offerBody' => $offerBody,
                    'email' => $email,
                ]);
                // OTP Email Address
                Mail::to($email)->send(new EmailCampaignMail($offerSub, $offerBody));
            }
            return $this->success('Offer send success', 200);
        } catch(Exception $e) {
            return $this->error('SomeThink Went Worng');
        }
    }
}
