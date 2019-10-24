@extends('layouts.master')
@section('title','Customer Management')
@section('page_name','Customer Management')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="p-2">
                        <table id="customer_datatable" class="border table table-bordered table-striped table-condesed">
                            <thead>
                                <tr>
                                    <td></td>
                                    <td>Unique Id</td>
                                    <td>Full Name</td>
                                    <td>Email</td>
                                    <td>Wallet Balance</td>
                                    <td>Country</td>
                                    <td>Referral Code</td>
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
        
        CONF.dataTable = $('#customer_datatable').DataTable({
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
                "url": CONF.baseurl+"/customer/list",
                "type": "POST",
                "data": function (d) {}
            },
            "columns":  [
                {"className":'details-control',"orderable":false,"visible":false,"data":'',"defaultContent": ''},
                { "data": "id","visible":false},
                { "data": "first_name",
                    render: function ( data, type, row )
                    {
                        return data + ' ' + row.last_name;
                    }
                },
                { "data": "email"},
                { "data": "wallet_balance"},
                { "data": "country"},
                { "data": "referral_code"},
                { "data": "created_at"},
                { "data": "updated_at"},
                { "data": "id",
                    render: function ( data, type, row ) 
                    {
                        var msg = '<a style="margin-right:10px" href="{{url('/customer/detail')}}/'+row.unique_id+'" class="btn btn-sm btn-primary" title="View / Edit"><i class="fa fa-eye"></i></a>';
                        if(row.is_active == 1){
                            msg += "<a style='margin-right:10px; color:white;' class='btn btn-sm btn-danger changeUserStatus' data-status='0' title='Disable'><i class=\"fa fa-times\"></i></a>";
                        }else{
                            msg += "<a style='margin-right:10px; color:white;' class='btn btn-sm btn-success changeUserStatus' data-status='1' title='Enable'><i class=\"fa fa-check\"></i></a>";
                        }
                        return msg;
                    }
                },
            ],
            responsive: true
        });

        // var btn_pc = '<a href="{{url('/users/new')}}" class="btn btn-default btn-sm" type="button" title="Add new"><i class="fa fa-plus"></i></a>';
        var btn_pc = '&nbsp;&nbsp;<button id="refreshAll" class="btn btn-default btn-sm" type="button" title="Reload"><i class="fa fa-refresh"></i></button>';

        $('.dataTables_filter','#customer_datatable_wrapper').prepend(btn_pc);
        $("#refreshAll").click(function(){ CONF.dataTable.ajax.reload(); });

        $("#customer_datatable").on("click",".changeUserStatus",function(){
            
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
                content: '<br><center>Are you sure you want to '+Rstatus+' this user ?</center><br>',
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

                            $.post( CONF.baseurl+"/customer/changeUserStatus", {'usr_id':rowData.unique_id,'status':Rstatus}, function( data ) {

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
    // });
</script>
@endsection
