@extends('layouts.master')
@section('title','Store Management')
@section('page_name','Store Management')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="p-2">
                        <table id="store_datatable" class="border table table-bordered table-striped table-condesed">
                            <thead>
                                <tr>
                                    <td></td>
                                    <td>Id</td>
                                    <td>Unique&nbsp;Id</td>
                                    <td>Short&nbsp;Name</td>
                                    <td>Full&nbsp;Name</td>
                                    <td>Domain&nbsp;Name</td>
                                    <td>Default&nbsp;User&nbsp;Commission</td>
                                    <td>Commission&nbsp;Type</td>
                                    <td>Referral&nbsp;Validity</td>
                                    <td>Created&nbsp;At</td>
                                    <!-- <td>Last&nbsp;Updated&nbsp;At</td> -->
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
        
        CONF.dataTable = $('#store_datatable').DataTable({
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
                "url": CONF.baseurl+"/store/list",
                "type": "POST",
                "data": function (d) {}
            },
            "columns":  [
                {"className":'details-control',"orderable":false,"visible":false,"data":'',"defaultContent": ''},
                { "data": "id","visible":false},
                { "data": "advertiser_id"},
                { "data": "short_name"},
                { "data": "full_name"},
                { "data": "domain_name"},
                { "data": "default_user_commision"},
                { "data": "user_commission_type"},
                { "data": "referral_validity"},
                { "data": "created_at"},
                // { "data": "updated_at"},
                { "data": "id",
                    render: function ( data, type, row ) 
                    {
                        var msg = '<a style="margin-right:10px" href="{{url('/store/detail')}}/'+row.advertiser_id+'" class="btn btn-sm btn-primary" title="View / Edit"><i class="fa fa-eye"></i></a>';
                        if(row.status == 1){
                            msg += "<a style='margin-right:10px; color:white;' class='btn btn-sm btn-danger changeStoreStatus' data-status='0' title='Disable'><i class=\"fa fa-times\"></i></a>";
                        }else{
                            msg += "<a style='margin-right:10px; color:white;' class='btn btn-sm btn-success changeStoreStatus' data-status='1' title='Enable'><i class=\"fa fa-check\"></i></a>";
                        }
                        return msg;
                    }
                },
            ],
            responsive: true
        });

        var btn_pc = '<a class="btn btn-default btn-sm newStore" style="color:white;" type="button" title="Add new"><i class="fa fa-plus"></i></a>';
            btn_pc += '&nbsp;&nbsp;<button id="refreshAll" class="btn btn-default btn-sm" type="button" title="Reload"><i class="fa fa-refresh"></i></button>';

        $('.dataTables_filter','#store_datatable_wrapper').prepend(btn_pc);
        $("#refreshAll").click(function(){ CONF.dataTable.ajax.reload(); });

        $("#store_datatable").on("click",".changeStoreStatus",function(){
            
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
                content: '<br><center>Are you sure you want to '+Rstatus+' this Store ?</center><br>',
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

                            $.post( CONF.baseurl+"/store/changeStatus", {'id':rowData.advertiser_id,'status':Rstatus}, function( data ) {

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

        $(".newStore").click(function(){
            
            _this = $(this);

            $.confirm({
                title: 'New store',
                content: "Processing...",
                columnClass: 'col-md-10 col-md-offset-2',
                draggable: true,
                dragWindowBorder: false,
                onOpenBefore: function(){

                    var $this = this;
                    $.post( CONF.baseurl+"/store/getForm", {id:''}, function( data ) {

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
                        text: 'submit',
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

                            $.post( CONF.baseurl+"/store/new", $('#storeForm').serialize(), function( data ) {

                                $this.setTitle('New Store');
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
    // });
</script>
@endsection
