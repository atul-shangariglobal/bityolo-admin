@extends('layouts.master')
@section('title','System Settings')
@section('page_name','System Settings')

@section('content')
<style type="text/css">
    .custom-select.is-invalid:focus, .form-control.is-invalid:focus, .was-validated .custom-select:invalid:focus, .was-validated .form-control:invalid:focus{
        box-shadow : 0 0 0 !important;
    }
    .custom-select.is-valid:focus, .form-control.is-valid:focus, .was-validated .custom-select:valid:focus, .was-validated .form-control:valid:focus{
        box-shadow : 0 0 0 !important;        
    }
</style>
<style>
.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

.switch input { 
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #4caf50;
}

input:focus + .slider {
  box-shadow: 0 0 1px #4caf50;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}
.resp-invalid-feedback{
    width: 100%;
    margin-top: .25rem;
    font-size: 80%;
    color:
    #f44336;
}
</style>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="p-2">
                        <form class="was-validated" method="post" action="{{url('/')}}/settings/update">
                            @csrf
                            <div class="col-md-12">
                                <div class="row pb-4">
                                    <div class="col-md-4 form-group">
                                        <label for="min_withdrawal_limit" class="bmd-label-floating">Minimum withdrawal limit (USD)</label>
                                        <input type="text" class="form-control" id="min_withdrawal_limit" name="min_withdrawal_limit" value="{{@$config->min_withdrawal_limit}}" autocomplete="off" required="">
                                        <!-- <span class="bmd-help">We'll never share your email with anyone else.</span> -->
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                        @if ($errors->has('min_withdrawal_limit'))
                                            <div class="resp-invalid-feedback">{{ $errors->first('min_withdrawal_limit') }}</div>
                                        @endif
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label for="user_commission" class="bmd-label-floating">User commission (USD)</label>
                                        <input type="text" class="form-control" id="user_commission" name="user_commission" value="{{@$config->user_commission}}" autocomplete="off" required="">
                                        <!-- <span class="bmd-help">We'll never share your email with anyone else.</span> -->
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                        @if ($errors->has('user_commission'))
                                            <div class="resp-invalid-feedback">{{ $errors->first('user_commission') }}</div>
                                        @endif
                                    </div>
                                    <div class="col-md-4 form-group is-filled bmd-form-group">
                                        <label for="user_commission_type" class="bmd-label-floating">User commission type</label>
                                        <select class="form-control" id="user_commission_type" name="user_commission_type" autocomplete="off">
                                            <option value="flat" @if($config->user_commission_type == 'falt') selected @endif >Flat</option>
                                            <option value="percentage" @if($config->user_commission_type == 'percentage') selected @endif>Percentage</option>
                                        </select>
                                        <!-- <span class="bmd-help">We'll never share your email with anyone else.</span> -->
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>                                    
                                </div>
                                <div class="row pb-4">
                                    <div class="col-md-4 form-group is-filled bmd-form-group">
                                        <label for="default_user_commission_point" class="bmd-label-floating">Default user commission point</label>
                                        <select class="form-control" id="default_user_commission_point" name="default_user_commission_point" autocomplete="off">
                                            <option value="storewise" @if($config->default_user_commission_point == 'storewise') selected @endif>Storewise</option>
                                            <option value="global" @if($config->default_user_commission_point == 'global') selected @endif>Global</option>
                                        </select>
                                        <!-- <span class="bmd-help">We'll never share your email with anyone else.</span> -->
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
                                    <div class="col-md-4 form-group is-filled bmd-form-group">
                                        <label for="referral_reward_type" class="bmd-label-floating">Referral reward type</label>
                                        <select class="form-control" id="referral_reward_type" name="referral_reward_type" autocomplete="off">
                                            <option value="flat" @if($config->referral_reward_type == 'falt') selected @endif>Flat</option>
                                            <option value="percentage" @if($config->referral_reward_type == 'percentage') selected @endif>Percentage</option>
                                        </select>
                                        <!-- <span class="bmd-help">We'll never share your email with anyone else.</span> -->
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label for="referral_reward_value" class="bmd-label-floating">Referral reward value (USD)</label>
                                        <input type="text" class="form-control" id="referral_reward_value" name="referral_reward_value" value="{{@$config->referral_reward_value}}" autocomplete="off" required="">
                                        <!-- <span class="bmd-help">We'll never share your email with anyone else.</span> -->
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                        @if ($errors->has('referral_reward_value'))
                                            <div class="resp-invalid-feedback">{{ $errors->first('referral_reward_value') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="row pb-4">
                                    <div class="col-md-4 form-group is-filled bmd-form-group">
                                        <label for="referral_reward_on" class="bmd-label-floating">Referral reward on</label>
                                        <select class="form-control" id="referral_reward_on" name="referral_reward_on" autocomplete="off"> 
                                            <option value="registration" @if($config->referral_reward_on == 'registration') selected @endif>Registration</option>
                                            <option value="transaction" @if($config->referral_reward_on == 'transaction') selected @endif>Transaction</option>
                                        </select>
                                        <!-- <span class="bmd-help">We'll never share your email with anyone else.</span> -->
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
                                    <div class="col-md-4 form-group is-filled bmd-form-group">
                                        <label for="referral_reward_reciever" class="bmd-label-floating">Referral reward receiver</label>
                                        <select class="form-control" id="referral_reward_reciever" name="referral_reward_reciever" autocomplete="off">
                                            <option value="referrer" @if($config->referral_reward_reciever == 'referrer') selected @endif>Referrer</option>
                                            <option value="both" @if($config->referral_reward_reciever == 'both') selected @endif>Both</option>
                                        </select>
                                        <!-- <span class="bmd-help">We'll never share your email with anyone else.</span> -->
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label for="is_referral_reward" class="bmd-label-floating">Referral reward</label>
                                        <label class="switch" style="float: right;">
                                            <input type="checkbox" @if($config->is_referral_reward) checked @endif id="is_referral_reward" name="is_referral_reward" autocomplete="off">
                                            <span class="slider round"></span>
                                        </label>
                                        <!-- <span class="bmd-help">We'll never share your email with anyone else.</span> -->
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
                                </div>
                                <div class="row pb-4">

                                    <div class="col-md-4 form-group">
                                        <label for="user_email_notification_on_purchase" class="bmd-label-floating">User email notification on purchase</label>
                                        <label class="switch" style="float: right;">
                                            <input type="checkbox" @if($config->user_email_notification_on_purchase) checked @endif id="user_email_notification_on_purchase" name="user_email_notification_on_purchase" autocomplete="off">
                                            <span class="slider round"></span>
                                        </label>
                                        <!-- <span class="bmd-help">We'll never share your email with anyone else.</span> -->
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label for="email_verification_on_signup" class="bmd-label-floating">Email verification on signup</label>
                                        <label class="switch" style="float: right;">
                                            <input type="checkbox" @if($config->email_verification_on_signup) checked @endif id="email_verification_on_signup" name="email_verification_on_signup" autocomplete="off">
                                            <span class="slider round"></span>
                                        </label>
                                        <!-- <span class="bmd-help">We'll never share your email with anyone else.</span> -->
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label for="withdrawal_status" class="bmd-label-floating">Withdrawal status</label>
                                        <label class="switch" style="float: right;">
                                            <input type="checkbox" @if($config->withdrawal_status) checked @endif id="withdrawal_status" name="withdrawal_status" autocomplete="off">
                                            <span class="slider round"></span>
                                        </label>
                                        <!-- <span class="bmd-help">We'll never share your email with anyone else.</span> -->
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
                                </div>
                            </div>
                            
                            <button type="submit" class="btn btn-primary btn-raised" style="float: right;">Update</button>
                        </form>                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footerjs')
    
    <script type="text/javascript">
        if("{{session('status')}}"){
            $.notify("{{session('status')}}", "success");
        }
    </script>
@endsection
