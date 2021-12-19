<!doctype html>
<html>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" crossorigin="anonymous">
</head>
<style type="text/css">
    .fa{
        cursor: pointer;
        font-size: 18px;
        margin-right: 5px;
    }
    .fa-trash-o{
        color: red;
    }
    #add-new{
        margin-bottom: 5px;
    }
</style>
<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-primary card-outline">
                        <h3 class="card-title">Interview</h3>
                        <div class="card-tools pull-right">
                            <button class="btn btn-info" id="add-new"> Add New</button>
                        </div>
                    </div>                    
                    <div class="box">
                        <div class="box-body ">
                            <table id="list" class="table table-bordered table-responsive-lg">
                                <thead>
                                    <tr>
                                        <th>SPId</th>
                                        <th>Hostname</th>
                                        <th>Loopback</th>
                                        <th>Mac Address</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <!-- <?php foreach($routers as $router): ?>
                                    <tr>
                                        <td><?= $router['spid']; ?></td>
                                        <td><?= $router['hostname']; ?></td>
                                        <td><?= $router['loopback']; ?></td>
                                        <td><?= $router['mac']; ?></td>
                                        <td>
                                            <i data-id="<?= $router['id']; ?>" class="pointer fa fa-pencil-square-o edit" aria-hidden="true"></i>
                                            <i data-id="<?= $router['id']; ?>" class="fa fa-trash-o delete" aria-hidden="true"></i>
                                        </td>
                                    </tr>
                                <?php endforeach; ?> -->
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
<script type="text/javascript" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>

<?php echo view('create')?>
<script type="text/javascript">
    var base_url = "<?= base_url()?>";
    $(document).ready(function(){
        // $('#list').DataTable();
        load_data();
        
        function load_data()
        {
            $('#list').DataTable({
                destroy:true,
                dom: 'lfBrtip',
                bFilter: false,
                "processing": true,
                "serverSide": false,
                'searching' : true,
                "paging": true,
                "ordering": true,
                "order"     : [],
                ajax: {
                    url: base_url + "/ajax-load-data",
                    type: "post",
                },
                columns: [
                    { data: "spid" },
                    { data: "hostname" },
                    { data: "loopback" },
                    { data: "mac" },
                    { 
                        data: "id",
                        "orderable": false,
                        "render": function ( data, type, full, meta ) {
                            var html = '';
                            html += '<i data-id="'+full.id+'" class="pointer fa fa-pencil-square-o edit" aria-hidden="true"></i>';
                            html += '<i data-id="'+full.id+'" class="fa fa-trash-o delete" aria-hidden="true"></i>';
                            return html;
                        }
                    },
                ]
            });
        }

        $("#add-new").click(function(){
            $("#insert-record").trigger('reset');
            $("#id").val('');
            $('#create').modal({backdrop: 'static', keyboard: false});
        });
        $("#insert-record").submit(async function( e ) {
            e.preventDefault();
            $.ajax({
                url:base_url+"/add_update",
                type: "POST",
                dataType: 'json',
                data: $("#insert-record").serialize(),
                success: function(res) {
                    if(res.success){
                        toastr.success('Success!!');
                        load_data();
                        $('#create').modal('toggle');
                    }else{
                        toastr.error('Something want wrong');
                    }
                }
            });
        });
        $(document).on('click', ".delete", function(){
            var id = $(this).data('id');
            $.ajax({
                url:base_url+"/delete/"+id,
                type: "DELETE",
                dataType: 'json',
                success: function(res) {
                    if(res.success){
                        toastr.success('Success!!');
                        load_data();
                    }else{
                        toastr.error('Something want wrong');
                    }
                }
            });
        });
        $(document).on('click', ".edit", function(){
            var id = $(this).data('id');
            $.ajax({
                url:base_url+"/edit/"+id,
                type: "GET",
                dataType: 'json',
                success: function(res) {
                    if(res.data){
                        $('#create').modal({backdrop: 'static', keyboard: false});
                        $("#spid").val(res.data.spid);
                        $("#loopback").val(res.data.loopback);
                        $("#mac").val(res.data.mac);
                        $("#hostname").val(res.data.hostname);
                        $("#id").val(res.data.id);
                    }else{
                        toastr.error('Something want wrong');
                    }
                }
            });
        });
    })
</script>