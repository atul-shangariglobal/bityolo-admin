<?php

namespace App\Http\Controllers;

// use App\Permission;
// use App\User;

use Illuminate\Http\Request;
use App\Models\{Querymodel};
use Illuminate\Support\Facades\DB;

class SettingsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data['config'] = DB::table('config')->first();
        return view('settings', $data);
    }

    public function updateConfig(Request $req)
    {
        $validatedData = $req->validate([
            'min_withdrawal_limit'  => 'required|numeric',
            'user_commission'       => 'required|numeric',
            'referral_reward_value' => 'required|numeric',
        ]);

        $input = $req->input();

        $data = [
            'min_withdrawal_limit'                  => $input['min_withdrawal_limit'],
            'user_commission'                       => $input['user_commission'],
            'user_commission_type'                  => $input['user_commission_type'],
            'default_user_commission_point'         => $input['default_user_commission_point'],
            'referral_reward_type'                  => $input['referral_reward_type'],
            'referral_reward_value'                 => $input['referral_reward_value'],
            'referral_reward_on'                    => $input['referral_reward_on'],
            'referral_reward_reciever'              => $input['referral_reward_reciever'],
            'is_referral_reward'                    => 0,
            'user_email_notification_on_purchase'   => 0,
            'email_verification_on_signup'          => 0,
            'withdrawal_status'                     => 0,
        ];

        if(isset($input['is_referral_reward'])){

            $data['is_referral_reward'] = 1;
        }

        if(isset($input['user_email_notification_on_purchase'])){
            
            $data['user_email_notification_on_purchase'] = 1;
        }

        if(isset($input['email_verification_on_signup'])){
            
            $data['email_verification_on_signup'] = 1;
        }

        if(isset($input['withdrawal_status'])){
            
            $data['withdrawal_status'] = 1;
        }

        DB::table('config')->update($data);

        return back()->withStatus(__('Settings updated successfully.'));
    }
}
