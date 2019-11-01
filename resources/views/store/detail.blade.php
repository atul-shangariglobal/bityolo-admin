@extends('layouts.master')
@section('title','Store Management')
@section('page_name','Store Detail')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="p-2">
                        <div class="row">
                            <div class="col-md-6"><div class="row">
                                <div class="col-md-4">Short Name</div> 
                                <div class="col-md-8">: {{$store_data->short_name}}</div>
                            </div></div>
                            <div class="col-md-6"><div class="row">
                                <div class="col-md-4">Full Name</div> 
                                <div class="col-md-8">: {{$store_data->full_name}}</div>
                            </div></div>
                            <div class="col-md-6"><div class="row">
                                <div class="col-md-4">Domain Name</div> 
                                <div class="col-md-8">: {{$store_data->domain_name}}</div>
                            </div></div>
                            <div class="col-md-6"><div class="row">
                                <div class="col-md-4">Default User Commision</div> 
                                <div class="col-md-8">: {{$store_data->default_user_commision}}</div>
                            </div></div>
                            <div class="col-md-6"><div class="row">
                                <div class="col-md-4">User Commission Type</div> 
                                <div class="col-md-8">: {{$store_data->user_commission_type}}</div>
                            </div></div>
                            <div class="col-md-6"><div class="row">
                                <div class="col-md-4">Referral Validity</div> 
                                <div class="col-md-8">: {{$store_data->referral_validity}}</div>
                            </div></div>
                            <div class="col-md-6"><div class="row">
                                <div class="col-md-4">Created At</div> 
                                <div class="col-md-8">: {{date('d M Y H:i a', strtotime($store_data->created_at))}}</div>
                            </div></div>
                            <div class="col-md-6"><div class="row">
                                <div class="col-md-4">Last Updated At</div> 
                                <div class="col-md-8">: {{date('d M Y H:i a', strtotime($store_data->updated_at))}}</div>
                            </div></div>
                            <div class="col-md-6"><div class="row">
                                <div class="col-md-4">Current Status</div> 
                                <div class="col-md-8">: @if($store_data->status) Enabled @else Disabled @endif</div>
                            </div></div>
                            <div class="col-md-6"><div class="row">
                                <div class="col-md-4"></div> 
                                <div class="col-md-8 text-right">
                                    <a style="margin-right:10px; color:white;" class="btn btn-sm btn-primary editStore" title="Edit"><i class="fa fa-pencil"></i></a>
                                </div>
                            </div></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body ">
                    <div class="p-2">
                        <div class="row">
                            <div class="col-md-12">
                                <ul class="nav nav-pills nav-pills-warning" role="tablist">
                                    <li class="nav-item"> <a class="nav-link active show" data-toggle="tab" href="#link1" role="tablist"> Campaigns </a> </li>
                                </ul>
                                <div class="pt-4">
                                    <div class="tab-content tab-space">
                                        <div class="tab-pane active show" id="link1">
                                            <table id="campaign_datatable" class="border table table-bordered table-striped table-condesed">
                                                <thead>
                                                    <tr>
                                                        <td></td>
                                                        <td>Id</td>
                                                        <td>Campaign Id</td>
                                                        <td>Name</td>
                                                        <td>UTM Link</td>
                                                        <td>Min Discount</td>
                                                        <td>Max Discount</td>
                                                        <!-- <td>Start Date</td> -->
                                                        <!-- <td>End Date</td> -->
                                                        <td>Created At</td>
                                                        <td>Action</td>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                       </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footerjs')
<script type="text/javascript">
  // $(document).ready(function() {

        CONF.dataTable = $('#campaign_datatable').DataTable({
            "processing": true,
            "serverSide": true,
            "stripeClasses": [ 'odd-row', 'even-row' ],
            "language": {
                "search": "_INPUT_",
                "sLengthMenu": "_MENU_",
                "searchPlaceholder": "Search...",
                "paginate": {
                    "previous": "",
                    "next":""
                }
            },
            "order": [[1, 'desc']],
            "ajax": {
                "url": CONF.baseurl+"/store/campaign",
                "type": "POST",
                "data": function (d) {
                    d.adid = '{{$store_data->advertiser_id}}';
                }
            },
            "columns":  [
                {"className":'details-control',"orderable":false,"visible":false,"data":'',"defaultContent": ''},
                { "data": "id","visible":false},
                { "data": "campaign_id"},
                { "data": "name"},
                { "data": "utm_link"},
                { "data": "min_discount"},
                { "data": "max_discount"},
                // { "data": "start_date"},
                // { "data": "end_date"},
                { "data": "created_at"},
                { "data": "id",
                    render: function ( data, type, row ) 
                    {
                        var msg = '<a style="margin-right:10px; color:white;" class="btn btn-sm btn-primary editCampaign" title="Edit"><i class="fa fa-pencil"></i></a>';
                        if(row.status == 1){
                            msg += "<a style='margin-right:10px; color:white;' class='btn btn-sm btn-danger changeCampaignStatus' data-status='0' title='Disable'><i class=\"fa fa-times\"></i></a>";
                        }else{
                            msg += "<a style='margin-right:10px; color:white;' class='btn btn-sm btn-success changeCampaignStatus' data-status='1' title='Enable'><i class=\"fa fa-check\"></i></a>";
                        }
                        return msg;
                    }
                },
            ],
            responsive: true
        });

        var btn_pc = '<a style="color:white;" class="btn btn-default btn-sm newCampaign" type="button" title="Add new"><i class="fa fa-plus"></i></a>';
            btn_pc += '&nbsp;&nbsp;<button id="refreshAllOrders" class="btn btn-default btn-sm" type="button" title="Reload"><i class="fa fa-refresh"></i></button>';

        $('.dataTables_filter','#campaign_datatable_wrapper').prepend(btn_pc);
        $("#refreshAllOrders").click(function(){ CONF.dataTable.ajax.reload(); });

        $("#campaign_datatable").on("click",".changeCampaignStatus",function(){
            
            _this = $(this);
            var Rstatus = _this.attr('data-status');
            var rowData = CONF.dataTable.row(_this.parent().parent()).data();

            var btnClass = '';
            if(Rstatus == 0){
                Rstatus = 'Disable';
                btnClass = 'btn-danger';
            }else{
                Rstatus = 'Enable';
                btnClass = 'btn-blue';
            }

            $.confirm({
                title: 'Confirm!',
                content: '<br><center>Are you sure you want to '+Rstatus+' this Campaign ?</center><br>',
                columnClass: 'col-md-4 col-md-offset-4',
                draggable: true,
                dragWindowBorder: false,
                buttons: 
                {
                    submit: 
                    {
                        text: Rstatus,
                        btnClass: btnClass,
                        action: function () {
                            
                            var $this = this;
                            
                            ajaxRequestOn = true;
                            $this.setTitle("Processing...");
                            $this.buttons.submit.disable();
                            $this.buttons.submit.setText(TOOLS.spin_html);
                            $this.buttons.cancel.disable();

                            $.post( CONF.baseurl+"/store/changeCampaignStatus", {'id':rowData.campaign_id,'status':Rstatus}, function( data ) {

                                $this.buttons.submit.enable();
                                $this.buttons.submit.setText('submit');
                                $this.buttons.cancel.enable();
                                
                                ajaxRequestOn = false;
                                
                                data = $.parseJSON(data);
                                if(data.status == '201'){

                                    $.notify(data.msg);
                                }

                                if(data.status == '200'){

                                    $.notify(data.msg, "success");
                                    CONF.dataTable.ajax.reload();
                                    $this.close();
                                }
                            });

                            return false;
                        }
                    },
                    cancel: 
                    {
                        text: 'Close',
                        btnClass: 'btn-default'
                    }
                }
            });
        });

        $(document).on("click",".editStore",function(){
            
            _this = $(this);
            var advertiser_id = '{{$store_data->advertiser_id}}';

            $.confirm({
                title: advertiser_id + ' Detail',
                content: "Processing...",
                columnClass: 'col-md-10 col-md-offset-2',
                draggable: true,
                dragWindowBorder: false,
                onOpenBefore: function(){

                    var $this = this;
                    $.post( CONF.baseurl+"/store/getForm", {'id':advertiser_id}, function( data ) {

                        $this.setContent("<br>"+data);

                        $this.$content.find('#default_user_commision,#referral_validity').keypress(function (e) {
                            
                            var id = $(this).attr('id');
                            if (e.which != 8 && e.which != 0 && e.which != 46 && (e.which < 48 || e.which > 57)) {
                                $this.$content.find('#'+id).parent().find('.invalid-feedback').html("Digits Only").show();
                                return false;
                            }
                        });
                        return false;
                    });
                },
                buttons: 
                {
                    submit: 
                    {
                        text: 'update',
                        btnClass: 'btn-blue',
                        action: function () {
                            
                            var $this = this;
                            
                            if(!$this.$content.find('#short_name').val() || !$this.$content.find('#full_name').val() || !$this.$content.find('#domain_name').val() || !$this.$content.find('#default_user_commision').val() || !$this.$content.find('#referral_validity').val()){
                                
                                return false;
                            }

                            ajaxRequestOn = true;
                            $this.setTitle("Processing...");
                            $this.buttons.submit.disable();
                            $this.buttons.submit.setText(TOOLS.spin_html);
                            $this.buttons.cancel.disable();

                            $.post( CONF.baseurl+"/store/update", $('#storeForm').serialize(), function( data ) {

                                $this.setTitle(advertiser_id + ' Detail');
                                $this.buttons.submit.enable();
                                $this.buttons.submit.setText('update');
                                $this.buttons.cancel.enable();
                                
                                ajaxRequestOn = false;
                                
                                data = $.parseJSON(data);
                                if(data.status == "201"){

                                    var ids = data.msg.join(',#');
                                    $this.$content.find('#'+ids).parent().find('.invalid-feedback').show();
                                }

                                if(data.status == '202'){

                                    $.notify(data.msg);
                                }

                                if(data.status == '200'){

                                    $.notify(data.msg, "success");
                                    $this.close();
                                    setTimeout(function(){ location.reload(); }, 2000);
                                }
                            });

                            return false;
                        }
                    },
                    cancel: 
                    {
                        text: 'Close',
                        btnClass: 'btn-default'
                    }
                }
            });
        });

        $(".newCampaign").click(function(){
            
            _this = $(this);

            $.confirm({
                title: 'New Campaign',
                content: "Processing...",
                columnClass: 'col-md-10 col-md-offset-2',
                draggable: true,
                dragWindowBorder: false,
                onOpenBefore: function(){

                    var $this = this;
                    $.post( CONF.baseurl+"/store/getCampaignForm", {id:'',store_id:'{{$store_data->advertiser_id}}'}, function( data ) {

                        $this.setContent("<br>"+data);

                        $this.$content.find('#min_discount,#max_discount').keypress(function (e) {
                            
                            var id = $(this).attr('id');
                            if (e.which != 8 && e.which != 0 && e.which != 46 && (e.which < 48 || e.which > 57)) {
                                $this.$content.find('#'+id).parent().find('.invalid-feedback').html("Digits Only").show();
                                return false;
                            }
                        });
                        return false;
                    });
                },
                buttons: 
                {
                    submit: 
                    {
                        text: 'submit',
                        btnClass: 'btn-blue',
                        action: function () {
                            
                            var $this = this;
                            
                            if(!$this.$content.find('#name').val() || !$this.$content.find('#utm_link').val() || !$this.$content.find('#min_discount').val() || !$this.$content.find('#max_discount').val()){
                                
                                return false;
                            }

                            ajaxRequestOn = true;
                            $this.setTitle("Processing...");
                            $this.buttons.submit.disable();
                            $this.buttons.submit.setText(TOOLS.spin_html);
                            $this.buttons.cancel.disable();

                            $.post( CONF.baseurl+"/store/newCampaign", $('#campaignForm').serialize(), function( data ) {

                                $this.setTitle('New Campaign');
                                $this.buttons.submit.enable();
                                $this.buttons.submit.setText('submit');
                                $this.buttons.cancel.enable();
                                
                                ajaxRequestOn = false;
                                
                                data = $.parseJSON(data);
                                if(data.status == "201"){

                                    var ids = data.msg.join(',#');
                                    $this.$content.find('#'+ids).parent().find('.invalid-feedback').show();
                                }

                                if(data.status == '202'){

                                    $.notify(data.msg);
                                }

                                if(data.status == '200'){

                                    $.notify(data.msg, "success");
                                    CONF.dataTable.ajax.reload();
                                    $this.close();
                                }
                            });

                            return false;
                        }
                    },
                    cancel: 
                    {
                        text: 'Close',
                        btnClass: 'btn-default'
                    }
                }
            });
        });

        $(document).on("click",".editCampaign",function(){
            
            _this = $(this);
            var rowData = CONF.dataTable.row(_this.parent().parent()).data();

            $.confirm({
                title: rowData.campaign_id + ' Detail',
                content: "Processing...",
                columnClass: 'col-md-10 col-md-offset-2',
                draggable: true,
                dragWindowBorder: false,
                onOpenBefore: function(){

                    var $this = this;
                    $.post( CONF.baseurl+"/store/getCampaignForm", {'id':rowData.campaign_id, store_id:rowData.advertiser_id}, function( data ) {

                        $this.setContent("<br>"+data);

                        $this.$content.find('#min_discount,#max_discount').keypress(function (e) {
                            
                            var id = $(this).attr('id');
                            if (e.which != 8 && e.which != 0 && e.which != 46 && (e.which < 48 || e.which > 57)) {
                                $this.$content.find('#'+id).parent().find('.invalid-feedback').html("Digits Only").show();
                                return false;
                            }
                        });
                        return false;
                    });
                },
                buttons: 
                {
                    submit: 
                    {
                        text: 'update',
                        btnClass: 'btn-blue',
                        action: function () {
                            
                            var $this = this;
                            
                            if(!$this.$content.find('#name').val() || !$this.$content.find('#utm_link').val() || !$this.$content.find('#min_discount').val() || !$this.$content.find('#max_discount').val()){
                                
                                return false;
                            }

                            ajaxRequestOn = true;
                            $this.setTitle("Processing...");
                            $this.buttons.submit.disable();
                            $this.buttons.submit.setText(TOOLS.spin_html);
                            $this.buttons.cancel.disable();

                            $.post( CONF.baseurl+"/store/updateCampaign", $('#campaignForm').serialize(), function( data ) {

                                $this.setTitle(rowData.campaign_id + ' Detail');
                                $this.buttons.submit.enable();
                                $this.buttons.submit.setText('update');
                                $this.buttons.cancel.enable();
                                
                                ajaxRequestOn = false;
                                
                                data = $.parseJSON(data);
                                if(data.status == "201"){

                                    var ids = data.msg.join(',#');
                                    $this.$content.find('#'+ids).parent().find('.invalid-feedback').show();
                                }

                                if(data.status == '202'){

                                    $.notify(data.msg);
                                }

                                if(data.status == '200'){

                                    $.notify(data.msg, "success");
                                    CONF.dataTable.ajax.reload();
                                    $this.close();
                                }
                            });

                            return false;
                        }
                    },
                    cancel: 
                    {
                        text: 'Close',
                        btnClass: 'btn-default'
                    }
                }
            });
        });
    // });
</script>
@endsection
