@extends('layouts.master')
@section('title','Customer Management')
@section('page_name','Customer Detail')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="p-2">
                        <div class="row">
                            <div class="col-md-6"><div class="row">
                                <div class="col-md-4">First Name</div> 
                                <div class="col-md-8">: {{$user_data->first_name}}</div>
                            </div></div>
                            <div class="col-md-6"><div class="row">
                                <div class="col-md-4">Last Name</div> 
                                <div class="col-md-8">: {{$user_data->last_name}}</div>
                            </div></div>
                            <div class="col-md-6"><div class="row">
                                <div class="col-md-4">Email</div> 
                                <div class="col-md-8">: {{$user_data->email}}</div>
                            </div></div>
                            <div class="col-md-6"><div class="row">
                                <div class="col-md-4">Country</div> 
                                <div class="col-md-8">: {{$user_data->country}}</div>
                            </div></div>
                            <div class="col-md-6"><div class="row">
                                <div class="col-md-4">Wallet Balance</div> 
                                <div class="col-md-8">: {{$user_data->wallet_balance}} USD</div>
                            </div></div>
                            <div class="col-md-6"><div class="row">
                                <div class="col-md-4">Referral Code</div> 
                                <div class="col-md-8">
                                    : <span id="refCode">{{$user_data->referral_code}}</span>
                                    <i onclick="CopyToClipboard('refCode')" class="btn btn-sm btn-blue fa fa-copy" alt="Copy"></i>
                                </div>
                            </div></div>
                            <div class="col-md-6"><div class="row">
                                <div class="col-md-4">Created At</div> 
                                <div class="col-md-8">: {{date('d M Y H:i a', strtotime($user_data->created_at))}}</div>
                            </div></div>
                            <div class="col-md-6"><div class="row">
                                <div class="col-md-4">Last Updated At</div> 
                                <div class="col-md-8">: {{date('d M Y H:i a', strtotime($user_data->updated_at))}}</div>
                            </div></div>
                            <div class="col-md-6"><div class="row">
                                <div class="col-md-4">Current Status</div> 
                                <div class="col-md-8">: @if($user_data->is_active) Activated @else Deactivated @endif</div>
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
                                    <li class="nav-item"> <a class="nav-link active show" data-toggle="tab" href="#link1" role="tablist"> Order History </a> </li>
                                    <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#link2" role="tablist"> Wallet History </a> </li>
                                </ul>
                                <div class="pt-4">
                                    <div class="tab-content tab-space">
                                        <div class="tab-pane active show" id="link1">
                                            <table id="order_history_datatable" class="border table table-bordered table-striped table-condesed">
                                                <thead>
                                                    <tr>
                                                        <td></td>
                                                        <td></td>
                                                        <td>Order Id</td>
                                                        <td>Advertiser Name</td>
                                                        <td>Campaign Name</td>
                                                        <td>User Commission</td>
                                                        <td>Purchase Amount</td>
                                                        <td>BTC Value</td>
                                                        <td>BTC Rate</td>
                                                        <td>Status</td>
                                                        <td>Order At</td>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                        <div class="tab-pane" id="link2">
                                            <table id="wallet_history_datatable" class="border table table-bordered table-striped table-condesed" style="width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <td></td>
                                                        <td></td>
                                                        <td>Order Id</td>
                                                        <td>Referral Amount</td>
                                                        <td>Referral Type</td>
                                                        <td>Txn Type</td>
                                                        <td>BTC Value</td>
                                                        <td>BTC Rate</td>
                                                        <td>Status</td>
                                                        <td>Order At</td>
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

        function CopyToClipboard(containerid) {
          
            var range = document.createRange();
            range.selectNode(document.getElementById(containerid));
            window.getSelection().addRange(range);
            document.execCommand("copy");
            $.notify('Referral Code copied', "success");
        }
        
        CONF.order_histroy_dataTable = $('#order_history_datatable').DataTable({
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
                "url": CONF.baseurl+"/ordersList",
                "type": "POST",
                "data": function (d) {
                    d.user = '{{$user_data->id}}';
                }
            },
            "columns":  [
                {"className":'details-control',"orderable":false,"visible":false,"data":'',"defaultContent": ''},
                { "data": "id","visible":false},
                { "data": "order_id"},
                { "data": "advertiser_name"},
                { "data": "campaign_name"},
                { "data": "user_commission_amount"},
                { "data": "purchase_amount"},
                { "data": "btc_value"},
                { "data": "btc_rate"},
                { "data": "status"},
                { "data": "created_at"},
            ],
            responsive: true
        });

        // var btn_pc = '<a href="{{url('/users/new')}}" class="btn btn-default btn-sm" type="button" title="Add new"><i class="fa fa-plus"></i></a>';
        var order_btn = '&nbsp;&nbsp;<button id="refreshAllOrders" class="btn btn-default btn-sm" type="button" title="Reload"><i class="fa fa-refresh"></i></button>';

        $('.dataTables_filter','#order_history_datatable_wrapper').prepend(order_btn);
        $("#refreshAllOrders").click(function(){ CONF.order_histroy_dataTable.ajax.reload(); });


        CONF.wallet_history_dataTable = $('#wallet_history_datatable').DataTable({
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
                "url": CONF.baseurl+"/wallet_history_list",
                "type": "POST",
                "data": function (d) {
                    d.user = '{{$user_data->id}}';
                }
            },
            "columns":  [
                {"className":'details-control',"orderable":false,"visible":false,"data":'',"defaultContent": ''},
                { "data": "id","visible":false},
                { "data": "order_id"},
                { "data": "user_amount"},
                { "data": "referral_reward_type"},
                { "data": "txn_type"},
                { "data": "btc_value"},
                { "data": "btc_rate"},
                { "data": "status"},
                { "data": "created_at"},
            ],
            responsive: true
        });

        // var btn_pc = '<a href="{{url('/users/new')}}" class="btn btn-default btn-sm" type="button" title="Add new"><i class="fa fa-plus"></i></a>';
        var wallet_btn = '&nbsp;&nbsp;<button id="refreshAllWallet" class="btn btn-default btn-sm" type="button" title="Reload"><i class="fa fa-refresh"></i></button>';

        $('.dataTables_filter','#wallet_history_datatable_wrapper').prepend(wallet_btn);
        $("#refreshAllWallet").click(function(){ CONF.wallet_history_dataTable.ajax.reload(); });
    // });
</script>
@endsection
