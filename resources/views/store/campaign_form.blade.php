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
@if(@$camp_data->campaign_id)
<form class="was-validated" id="campaignForm" method="post" action="{{url('/')}}/store/updateCampaign">
@else
<form class="was-validated" id="campaignForm" method="post" action="{{url('/')}}/store/newCampaign">
@endif
    @csrf
    <div class="col-md-12">
        <input type="hidden" class="form-control" id="campaign_id" name="campaign_id" value="{{@$camp_data->campaign_id}}">
        <input type="hidden" class="form-control" id="advertiser_id" name="advertiser_id" value="{{@$store_id}}">
        <div class="row pb-4">
            <div class="col-md-4 form-group">
                <label for="name" class="bmd-label-floating">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{@$camp_data->name}}" autocomplete="off" required="">
                <!-- <span class="bmd-help">We'll never share your email with anyone else.</span> -->
                <div class="invalid-feedback">Please fill out this field.</div>
            </div>
            <div class="col-md-4 form-group">
                <label for="min_discount" class="bmd-label-floating">Min Discount</label>
                <input type="text" class="form-control" id="min_discount" name="min_discount" value="{{@$camp_data->min_discount}}" autocomplete="off" required="">
                <!-- <span class="bmd-help">We'll never share your email with anyone else.</span> -->
                <div class="invalid-feedback">Please fill out this field.</div>
            </div>
            <div class="col-md-4 form-group">
                <label for="max_discount" class="bmd-label-floating">Max Discount</label>
                <input type="text" class="form-control" id="max_discount" name="max_discount" value="{{@$camp_data->max_discount}}" autocomplete="off" required="">
                <!-- <span class="bmd-help">We'll never share your email with anyone else.</span> -->
                <div class="invalid-feedback">Please fill out this field.</div>
            </div>
        </div>
        <div class="row pb-4">
            <div class="col-md-12 form-group">
                <label for="utm_link" class="bmd-label-floating">UTM Link</label>
                <input type="text" class="form-control" id="utm_link" name="utm_link" value="{{@$camp_data->utm_link}}" autocomplete="off" required="">
                <!-- <span class="bmd-help">We'll never share your email with anyone else.</span> -->
                <div class="invalid-feedback">Please fill out this field.</div>
            </div>
        </div>
    </div>    
</form>