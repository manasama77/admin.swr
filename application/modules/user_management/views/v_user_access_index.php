<?php
$this->load->view('template/header');
?>
<!--tambahkan custom css disini-->
<?php
$this->load->view('template/topbar');
$this->load->view('template/sidebar');
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Hak Akses
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">User Management</a></li>
            <li class="active">Hak Akses</li>
        </ol>
    </section>

    <section class="content">
        <div class="box box-info">
            <div class="box-body">
                <table id="UserAccessTable" class="table table-bordered table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>User Group Code</th>
                            <th>User Group Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($useraccess->result() as $row) : ?>
                            <tr>
                                <td><?php echo $row->user_group_code; ?></td>
                                <td><?php echo $row->user_group_name; ?></td>
                                <td>
                                    <button class="btn btn-sm btn-warning bold" onclick="edit_data(<?php echo $row->user_group_id; ?>)"><i class="fa fa-pencil"></i></button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="modal fade bd-example-modal-lg" id="FormModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" style="text-align:center;"><strong>Role Form</strong></h4>
                    </div>
                    <form action="#" id="form" class="form-horizontal">
                        <div class="modal-body">
                            <input type="hidden" class="form-control" id="formtype" name="formtype" value="">
                            <input type="hidden" class="form-control" id="usergroupid" name="usergroupid" value="">
                            <input type="hidden" class="form-control" id="activemenu" name="activemenu" value="">

                            <div class="form-group">
                                <label class="col-sm-4 control-label">User Group Code</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="usergroupcode" name="usergroupcode" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">User Group Name</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="usergroupname" name="usergroupname" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Dashboard</label>
                                <div class="col-sm-6">
                                    <input type="checkbox" id="menu25" name="menu" value="25">
                                </div>
                            </div>
                            <br>
                            <div class="nav-tabs-custom">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="#tab_1" data-toggle="tab">Manajemen Pengguna</a></li>
                                    <li><a href="#tab_2" data-toggle="tab">Data Utama</a></li>
                                    <li><a href="#tab_3" data-toggle="tab">Inventory</a></li>
                                    <li><a href="#tab_4" data-toggle="tab">Transaksi</a></li>
                                    <li><a href="#tab_5" data-toggle="tab">Laporan</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab_1">

                                        <div id="show_manajemen"></div>

                                    </div>
                                    <!-- /.tab-pane -->
                                    <div class="tab-pane" id="tab_2">

                                        <div id="show_data_utama"></div>

                                    </div>
                                    <!-- /.tab-pane -->
                                    <div class="tab-pane" id="tab_3">

                                        <div id="show_inventory"></div>

                                    </div>
                                    <!-- /.tab-pane -->
                                    <div class="tab-pane" id="tab_4">

                                        <div id="show_transaksi"></div>

                                    </div>
                                    <!-- /.tab-pane -->
                                    <div class="tab-pane" id="tab_5">

                                        <div id="show_laporan"></div>

                                    </div>
                                    <!-- /.tab-pane -->
                                </div>
                                <!-- /.tab-content -->
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success pull-left" data-dismiss="modal">Cancel</button>
                            <button type="button" id="btnSave" onclick="save_data()" class="btn btn-danger pull-right">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </section><!-- /.content -->

</div>

<?php $this->load->view('template/js'); ?>

<script>
    $(".select2").select2();

    $("#UserAccessTable").DataTable({
        dom: 'Bfrtip',
        lengthMenu: [
            [10, 25, 50, -1],
            ['10 rows', '25 rows', '50 rows', 'Show all']
        ],
        "scrollX": true,
        "lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ],
        'searching': true,
        'ordering': true
    });

    function edit_data(usergroupid) {
        $('#formtype').val("edit");
        $('#form')[0].reset(); // reset form on modals

        //Ajax Load data from ajax
        $.ajax({
            type: "POST",
            dataType: "JSON",
            url: "<?php echo site_url() ?>user_management/user_access/ajax_view",
            data: {
                usergroupid: usergroupid
            },
            success: function(data) {
                console.log(data);
                $('#usergroupid').val(usergroupid);
                $('#usergroupcode').val(data.user_group.user_group_code);
                $('#usergroupname').val(data.user_group.user_group_name);

                $.each(data.dashboard, function(i, item) {
                    if (item.is_access == 1) {
                        $("#menu25").prop("checked", true);
                    } else {
                        $("#menu25").prop("checked", false);
                    }
                });

                html = '<table class="table table-striped">' +
                    '<tr>' +
                    '<th style="width:45%; text-align:right;">Nama Menu</th>' +
                    '<th style="width:10%;"></th>' +
                    '<th>Boleh Mengakses?</th>' +
                    '</tr>';
                $.each(data.manajemen, function(i, item) {

                    html += '<tr>' +
                        '<td style="width:45%; text-align:right;">' + item.menu_name + '</td>' +
                        '<td style="width:10%;"></td>';

                    if (item.is_access == 1) {
                        html += '<td><input type="checkbox" id="menu' + item.menu_id + '" name="menu" value="' + item.menu_id + '" checked></td>';
                    } else {
                        html += '<td><input type="checkbox" id="menu' + item.menu_id + '" name="menu" value="' + item.menu_id + '"></td>';
                    }

                    html += '</tr>';

                });
                html += '</table>';

                $("#show_manajemen").empty();
                $("#show_manajemen").append(html);

                //=========================================================================================================================//

                html = '<table class="table table-striped">' +
                    '<tr>' +
                    '<th style="width:45%; text-align:right;">Nama Menu</th>' +
                    '<th style="width:10%;"></th>' +
                    '<th>Boleh Mengakses?</th>' +
                    '</tr>';
                $.each(data.data_utama, function(i, item) {

                    html += '<tr>' +
                        '<td style="width:45%; text-align:right;">' + item.menu_name + '</td>' +
                        '<td style="width:10%;"></td>';

                    if (item.is_access == 1) {
                        html += '<td><input type="checkbox" id="menu' + item.menu_id + '" name="menu" value="' + item.menu_id + '" checked></td>';
                    } else {
                        html += '<td><input type="checkbox" id="menu' + item.menu_id + '" name="menu" value="' + item.menu_id + '"></td>';
                    }

                    html += '</tr>';

                });
                html += '</table>';

                $("#show_data_utama").empty();
                $("#show_data_utama").append(html);

                //=========================================================================================================================//

                html = '<table class="table table-striped">' +
                    '<tr>' +
                    '<th style="width:45%; text-align:right;">Nama Menu</th>' +
                    '<th style="width:10%;"></th>' +
                    '<th>Boleh Mengakses?</th>' +
                    '</tr>';
                $.each(data.inventory, function(i, item) {

                    html += '<tr>' +
                        '<td style="width:45%; text-align:right;">' + item.menu_name + '</td>' +
                        '<td style="width:10%;"></td>';

                    if (item.is_access == 1) {
                        html += '<td><input type="checkbox" id="menu' + item.menu_id + '" name="menu" value="' + item.menu_id + '" checked></td>';
                    } else {
                        html += '<td><input type="checkbox" id="menu' + item.menu_id + '" name="menu" value="' + item.menu_id + '"></td>';
                    }

                    html += '</tr>';

                });
                html += '</table>';

                $("#show_inventory").empty();
                $("#show_inventory").append(html);

                //=========================================================================================================================//

                html = '<table class="table table-striped">' +
                    '<tr>' +
                    '<th style="width:45%; text-align:right;">Nama Menu</th>' +
                    '<th style="width:10%;"></th>' +
                    '<th>Boleh Mengakses?</th>' +
                    '</tr>';
                $.each(data.transaksi, function(i, item) {

                    html += '<tr>' +
                        '<td style="width:45%; text-align:right;">' + item.menu_name + '</td>' +
                        '<td style="width:10%;"></td>';

                    if (item.is_access == 1) {
                        html += '<td><input type="checkbox" id="menu' + item.menu_id + '" name="menu" value="' + item.menu_id + '" checked></td>';
                    } else {
                        html += '<td><input type="checkbox" id="menu' + item.menu_id + '" name="menu" value="' + item.menu_id + '"></td>';
                    }

                    html += '</tr>';

                });
                html += '</table>';

                $("#show_transaksi").empty();
                $("#show_transaksi").append(html);

                //=========================================================================================================================//

                html = '<table class="table table-striped">' +
                    '<tr>' +
                    '<th style="width:45%; text-align:right;">Nama Menu</th>' +
                    '<th style="width:10%;"></th>' +
                    '<th>Boleh Mengakses?</th>' +
                    '</tr>';
                $.each(data.laporan, function(i, item) {

                    html += '<tr>' +
                        '<td style="width:45%; text-align:right;">' + item.menu_name + '</td>' +
                        '<td style="width:10%;"></td>';

                    if (item.is_access == 1) {
                        html += '<td><input type="checkbox" id="menu' + item.menu_id + '" name="menu" value="' + item.menu_id + '" checked></td>';
                    } else {
                        html += '<td><input type="checkbox" id="menu' + item.menu_id + '" name="menu" value="' + item.menu_id + '"></td>';
                    }

                    html += '</tr>';

                });
                html += '</table>';

                $("#show_laporan").empty();
                $("#show_laporan").append(html);

                $('#FormModal').modal('show'); // show bootstrap modal
                $('.modal-title').text('Ubah Hak Akses'); // Set Title to Bootstrap modal title
            },
            error: function() {
                Swal.fire({
                    icon: 'warning',
                    title: "Peringatan",
                    text: "Gagal Memproses Data",
                })
            }
        });
    }

    function save_data() {
        var allmenu = [];
        $.each($("input[name='menu']:checked"), function() {
            allmenu.push($(this).val());
        });
        var activemenu = allmenu.join(",");
        $('#activemenu').val(activemenu);

        $('#btnSave').text('saving...'); //change button text
        $('#btnSave').attr('disabled', true); //set button disable 
        var url = "<?php echo site_url() ?>user_management/user_access/ajax_update";
        var formtype = $('#formtype').val();

        $('#formtype').val("");
        var frm = $('#form');
        // ajax adding data to database
        $.ajax({
            url: url,
            type: "POST",
            data: frm.serialize(),
            dataType: "JSON",
            success: function(data) {
                if (data.status) //if success close modal and reload ajax table
                {
                    Swal.fire({
                        icon: 'success',
                        title: "Notifikasi",
                        text: data.message,
                    }).then(() => {
                        location.reload();
                    })
                } else {
                    Swal.fire({
                        icon: 'warning',
                        title: "Notifikasi",
                        text: data.message,
                    })
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                $('#btnSave').text('save');
                $('#btnSave').attr('disabled', false);
                Swal.fire({
                    icon: 'warning',
                    title: "Peringatan",
                    text: "Gagal Memproses Data",
                })
            }
        });
    }
</script>

<?php $this->load->view('template/footer'); ?>