@extends('layouts.master')
@section('title','User Management')
@section('page_name','User Management')
@section('css')
    @parent
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="p-2">
                        <table id="user_datatable" class="border table table-bordered table-striped table-condesed">
                            <thead>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td>Name</td>
                                    <td>Email</td>
                                    <td>Created At</td>
                                    <td>Last Updated At</td>
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
@endsection

@section('footerjs')
<script type="text/javascript">
  // $(document).ready(function() {
        
        CONF.dataTable = $('#user_datatable').DataTable({
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
                "url": CONF.baseurl+"/admin/list",
                "type": "POST",
                "data": function (d) {}
            },
            "columns":  [
                {"className":'details-control',"orderable":false,"visible":false,"data":'',"defaultContent": ''},
                { "data": "id","visible":false},
                { "data": "name"},
                { "data": "email"},
                { "data": "created_at"},
                { "data": "updated_at"},
                { "data": "id",
                    render: function ( data, type, row ) 
                    {
                        var msg = '<a style="margin-right:10px" href="{{url('/users/edit')}}/'+row.token+'" class="btn btn-sm btn-primary" title="View / Edit"><i class="fa fa-eye"></i></a>';
                        return msg;
                    }
                },
            ],
            responsive: true
        });

        var btn_pc = '<a href="{{url('/users/new')}}" class="btn btn-default btn-sm" type="button" title="Add new"><i class="fa fa-plus"></i></a>';
            btn_pc += '&nbsp;&nbsp;<button id="refreshAll" class="btn btn-default btn-sm" type="button" title="Reload"><i class="fa fa-refresh"></i></button>';

        $('.dataTables_filter','#user_datatable_wrapper').prepend(btn_pc);
        $("#refreshAll").click(function(){ CONF.dataTable.ajax.reload(); });
    // });
</script>
@endsection
