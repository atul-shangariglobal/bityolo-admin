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
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="p-2">
                        <form class="was-validated">
                            <div class="col-md-12">
                                <div class="row pb-4">
                                    <div class="col-md-6 form-group">
                                        <label for="min_withdrawal_limit" class="bmd-label-floating">Minimum Withdrawal Limit</label>
                                        <input type="text" class="form-control" id="min_withdrawal_limit" autocomplete="off">
                                        <!-- <span class="bmd-help">We'll never share your email with anyone else.</span> -->
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="user_email_notification_on_purchase" class="bmd-label-floating">User Email Notification On Purchase</label>
                                        <input type="text" class="form-control" id="user_email_notification_on_purchase">
                                        <!-- <span class="bmd-help">We'll never share your email with anyone else.</span> -->
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
                                </div>
                                <div class="row pb-4">
                                    <div class="col-md-6 form-group">
                                        <label for="email_verification_on_signup" class="bmd-label-floating">Email Verification On Signup</label>
                                        <input type="text" class="form-control" id="email_verification_on_signup" autocomplete="off">
                                        <!-- <span class="bmd-help">We'll never share your email with anyone else.</span> -->
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="user_commission" class="bmd-label-floating">User Commission</label>
                                        <input type="text" class="form-control" id="user_commission">
                                        <!-- <span class="bmd-help">We'll never share your email with anyone else.</span> -->
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
                                </div>
                                <div class="row pb-4">
                                    <div class="col-md-6 form-group">
                                        <label for="user_commission_type" class="bmd-label-floating">User Commission Type</label>
                                        <input type="text" class="form-control" id="user_commission_type" autocomplete="off">
                                        <!-- <span class="bmd-help">We'll never share your email with anyone else.</span> -->
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="default_user_commission_point" class="bmd-label-floating">Default User Commission Point</label>
                                        <input type="text" class="form-control" id="default_user_commission_point">
                                        <!-- <span class="bmd-help">We'll never share your email with anyone else.</span> -->
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
                                </div>
                                <div class="row pb-4">
                                    <div class="col-md-6 form-group">
                                        <label for="is_referral_reward" class="bmd-label-floating">Referral Reward</label>
                                        <input type="text" class="form-control" id="is_referral_reward" autocomplete="off">
                                        <!-- <span class="bmd-help">We'll never share your email with anyone else.</span> -->
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="referral_reward_type" class="bmd-label-floating">Referral Reward Type</label>
                                        <input type="text" class="form-control" id="referral_reward_type">
                                        <!-- <span class="bmd-help">We'll never share your email with anyone else.</span> -->
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
                                </div>
                                <div class="row pb-4">
                                    <div class="col-md-6 form-group">
                                        <label for="referral_reward_value" class="bmd-label-floating">Referral Reward Value</label>
                                        <input type="text" class="form-control" id="referral_reward_value" autocomplete="off">
                                        <!-- <span class="bmd-help">We'll never share your email with anyone else.</span> -->
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="referral_reward_on" class="bmd-label-floating">Referral Reward On</label>
                                        <input type="text" class="form-control" id="referral_reward_on">
                                        <!-- <span class="bmd-help">We'll never share your email with anyone else.</span> -->
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
                                </div>
                                <div class="row pb-4">
                                    <div class="col-md-6 form-group">
                                        <label for="referral_reward_reciever" class="bmd-label-floating">Referral Reward Receiver</label>
                                        <input type="text" class="form-control" id="referral_reward_reciever" autocomplete="off">
                                        <!-- <span class="bmd-help">We'll never share your email with anyone else.</span> -->
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="withdrawal_status" class="bmd-label-floating">Withdrawal Status</label>
                                        <input type="text" class="form-control" id="withdrawal_status">
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
@endsection
