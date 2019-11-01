<style type="text/css">
    .custom-select.is-invalid:focus, .form-control.is-invalid:focus, .was-validated .custom-select:invalid:focus, .was-validated .form-control:invalid:focus{
        box-shadow : 0 0 0 !important;
    }
    .custom-select.is-valid:focus, .form-control.is-valid:focus, .was-validated .custom-select:valid:focus, .was-validated .form-control:valid:focus{
        box-shadow : 0 0 0 !important;        
    }
    .bmd-label-floating{
        top: -10px !important;
        left: 0;
        font-size: .6875rem;
        position: absolute;
    }
</style>
@if(@$store_data->advertiser_id)
<form class="was-validated" id="storeForm" method="post" action="{{url('/')}}/store/update">
@else
<form class="was-validated" id="storeForm" method="post" action="{{url('/')}}/store/new">
@endif
    @csrf
    <div class="col-md-12">
        <input type="hidden" class="form-control" id="store_id" name="store_id" value="{{@$store_data->advertiser_id}}">
        <div class="row pb-4">
            <div class="col-md-4 form-group">
                <label for="short_name" class="bmd-label-floating">Short Name</label>
                <input type="text" class="form-control" id="short_name" name="short_name" value="{{@$store_data->short_name}}" autocomplete="off" required="">
                <!-- <span class="bmd-help">We'll never share your email with anyone else.</span> -->
                <div class="invalid-feedback">Please fill out this field.</div>
            </div>
            <div class="col-md-4 form-group">
                <label for="full_name" class="bmd-label-floating">Full Name</label>
                <input type="text" class="form-control" id="full_name" name="full_name" value="{{@$store_data->full_name}}" autocomplete="off" required="">
                <!-- <span class="bmd-help">We'll never share your email with anyone else.</span> -->
                <div class="invalid-feedback">Please fill out this field.</div>
            </div>
            <div class="col-md-4 form-group">
                <label for="domain_name" class="bmd-label-floating">Domain Name</label>
                <input type="text" class="form-control" id="domain_name" name="domain_name" value="{{@$store_data->domain_name}}" autocomplete="off" required="">
                <!-- <span class="bmd-help">We'll never share your email with anyone else.</span> -->
                <div class="invalid-feedback">Please fill out this field.</div>
            </div>
        </div>
        <div class="row pb-4">
            <div class="col-md-4 form-group">
                <label for="default_user_commision" class="bmd-label-floating">Default User Commision</label>
                <input type="text" class="form-control" id="default_user_commision" name="default_user_commision" value="{{@$store_data->default_user_commision}}" autocomplete="off" required="">
                <!-- <span class="bmd-help">We'll never share your email with anyone else.</span> -->
                <div class="invalid-feedback">Please fill out this field.</div>
            </div>
            <div class="col-md-4 form-group is-filled bmd-form-group">
                <label for="user_commission_type" class="bmd-label-floating">User commission type</label>
                <select class="form-control" id="user_commission_type" name="user_commission_type" autocomplete="off">
                    <option value="flat" @if(@$store_data->user_commission_type == 'falt') selected @endif >Flat</option>
                    <option value="percentage" @if(@$store_data->user_commission_type == 'percentage') selected @endif>Percentage</option>
                </select>
                <!-- <span class="bmd-help">We'll never share your email with anyone else.</span> -->
                <div class="invalid-feedback">Please fill out this field.</div>
            </div>
            <div class="col-md-4 form-group">
                <label for="referral_validity" class="bmd-label-floating">Referral Validity</label>
                <input type="text" class="form-control" id="referral_validity" name="referral_validity" value="{{@$store_data->referral_validity}}" autocomplete="off" required="">
                <!-- <span class="bmd-help">We'll never share your email with anyone else.</span> -->
                <div class="invalid-feedback">Please fill out this field.</div>
            </div>
        </div>
    </div>    
</form>