@extends('layouts.master')
@section('title','Referral Management')
@section('page_name','Referral Management')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="p-2">
                        <table id="referrals_datatable" class="border table table-bordered table-striped table-condesed">
                            <thead>
                                <tr>
                                    <td></td>
                                    <td>Unique Id</td>
                                    <td>Referrer Full Name</td>
                                    <td>Referee Full Name</td>
                                    <td>Referred At</td>
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
        
        CONF.dataTable = $('#referrals_datatable').DataTable({
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
                "url": CONF.baseurl+"/referrals/list",
                "type": "POST",
                "data": function (d) {}
            },
            "columns":  [
                {"className":'details-control',"orderable":false,"visible":false,"data":'',"defaultContent": ''},
                { "data": "id","visible":false},
                { "data": "referrer_first_name",
                    render: function ( data, type, row )
                    {
                        return '<a href="'+CONF.baseurl+'/customer/detail/'+row.referrer_unique_id+'" target="_blank">'+data + ' ' + row.referrer_last_name+'</a>';
                    }
                },
                { "data": "user_first_name",
                    render: function ( data, type, row )
                    {
                        return '<a href="'+CONF.baseurl+'/customer/detail/'+row.user_unique_id+'" target="_blank">'+data + ' ' + row.user_last_name+'</a>';
                    }
                },
                { "data": "created_at"},
            ],
            responsive: true
        });

        // var btn_pc = '<a href="{{url('/users/new')}}" class="btn btn-default btn-sm" type="button" title="Add new"><i class="fa fa-plus"></i></a>';
        var btn_pc = '&nbsp;&nbsp;<button id="refreshAll" class="btn btn-default btn-sm" type="button" title="Reload"><i class="fa fa-refresh"></i></button>';

        $('.dataTables_filter','#referrals_datatable_wrapper').prepend(btn_pc);
        $("#refreshAll").click(function(){ CONF.dataTable.ajax.reload(); });
    // });
</script>
@endsection
