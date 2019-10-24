@extends('layouts.master')
@section('title','Wallet History')
@section('page_name','Wallet History')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="p-2">
                        <table id="wallet_history_datatable" class="border table table-bordered table-striped table-condesed">
                            <thead>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td>Order&nbsp;Id</td>
                                    <td>Customer&nbsp;Name</td>
                                    <td>Referral&nbsp;Amount</td>
                                    <td>Referral&nbsp;Type</td>
                                    <td>Txn&nbsp;Type</td>
                                    <td>BTC&nbsp;Value</td>
                                    <td>BTC&nbsp;Rate</td>
                                    <td>Status</td>
                                    <td>Order&nbsp;At</td>   
                                </tr>
                            </thead>
                        </table>
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
                "data": function (d) {}
            },
            "columns":  [
                {"className":'details-control',"orderable":false,"visible":false,"data":'',"defaultContent": ''},
                { "data": "id","visible":false},
                { "data": "order_id"},
                { "data": "cust_first_name",
                    render: function ( data, type, row )
                    {
                        return '<a href="'+CONF.baseurl+'/customer/detail/'+row.cust_unique_id+'" target="_blank">'+data + ' ' + row.cust_last_name+'</a>';
                    }
                },
                { "data": "user_referral_amt"},
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
