@extends('layouts.master')
@section('title','Order History')
@section('page_name','Order History')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="p-2">
                        <table id="order_history_datatable" class="border table table-bordered table-striped table-condesed">
                            <thead>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td>Order&nbsp;Id</td>
                                    <td>Customer&nbsp;Name</td>
                                    <td>Advertiser&nbsp;Name</td>
                                    <td>Campaign&nbsp;Name</td>
                                    <td>User&nbsp;Commission</td>
                                    <td>Purchase&nbsp;Amount</td>
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
        
    // });
</script>
@endsection
