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
            Pengguna
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">User Management</a></li>
            <li class="active">Pengguna</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="box box-info">
            <div class="box-header with-border">
                <button onclick="add_data()" class="btn btn-primary bold"><i class="fa fa-plus-circle"></i> Tambah Data</button>
            </div>
            <div class="box-body">
                <table id="UserTable" class="table table-bordered table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>Kategori Pengguna</th>
                            <th>Nama Lengkap</th>
                            <th>Telepon</th>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($user->result() as $row) : ?>
                            <tr>
                                <td><?php echo $row->user_group_name; ?></td>
                                <td><?php echo $row->fullname; ?></td>
                                <td><?php echo $row->phone; ?></td>
                                <td><?php echo $row->email; ?></td>
                                <td>
                                    <button class="btn btn-sm btn-success bold" onclick="view_data(<?php echo $row->user_id; ?>)"><i class="fa fa-file-text-o"></i></button>
                                    &nbsp;
                                    <button class="btn btn-sm btn-warning bold" onclick="edit_data(<?php echo $row->user_id; ?>)"><i class="fa fa-pencil"></i></button>
                                    &nbsp;
                                    <button class="btn btn-sm btn-danger bold" onclick="delete_data(<?php echo $row->user_id; ?>)"><i class="fa fa-ban"></i></button>
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
                            <input type="hidden" class="form-control" id="userid" name="userid" value="0">

                            <div class="form-group">
                                <label class="col-sm-4 control-label">Kategori Pengguna</label>
                                <div class="col-sm-6">
                                    <select class="form-control select2" id="usergroupid" name="usergroupid" style="width: 100%;">
                                        <option value='0' selected>Silahkan Pilih</option>
                                        <?php foreach ($usergroup->result() as $row) : ?>
                                            <?php echo "<option value='" . $row->user_group_id . "'>" . $row->user_group_name . "</option>"; ?>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Cabang</label>
                                <div class="col-sm-6">
                                    <select class="form-control select2" id="branchid" name="branchid" style="width: 100%;">
                                        <option value='0' selected>Silahkan Pilih</option>
                                        <?php foreach ($branch->result() as $row) : ?>
                                            <?php echo "<option value='" . $row->branch_id . "'>" . $row->branch_name . "</option>"; ?>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Nama Lengkap</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="fullname" name="fullname">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Telepon</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="phone" name="phone">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Email</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="email" name="email">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Alamat</label>
                                <div class="col-sm-6">
                                    <textarea style="width:100%" rows="4" id="address" name="address">
                                </textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Username</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="username" name="username" values="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Password</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="password" name="password" values="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Nametag Barcode</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="logincode" name="logincode" values="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Status</label>
                                <div class="col-sm-6">
                                    <select class="form-control input-sm select2" id="status" name="status" style="width:100%">
                                        <option value="1" selected>Aktif</option>
                                        <option value="0">Non Aktif</option>
                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success pull-left" data-dismiss="modal">Batal</button>
                            <button type="button" id="btnSave" onclick="save_data()" class="btn btn-danger pull-right">Simpan</button>
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

    $("#UserTable").DataTable({
        dom: 'Bfrtip',
        lengthMenu: [
            [10, 25, 50, -1],
            ['10 rows', '25 rows', '50 rows', 'Show all']
        ],
        buttons: [
            'pageLength',
            {
                extend: 'excelHtml5',
                title: 'Pengguna',
                exportOptions: {
                    columns: [0, 1, 2]
                }
            },
            {
                extend: 'pdfHtml5',
                title: 'Pengguna',
                orientation: 'portrait',
                pageSize: 'A4',
                exportOptions: {
                    columns: [0, 1, 2]
                },
                customize: function(doc) {
                    doc.content[1].table.widths =
                        Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                }
            }, 'print'
        ],
        "scrollX": true,
        "lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ],
        'searching': true,
        'ordering': true
    });

    function add_data() {
        $('#formtype').val("add");
        $('#form')[0].reset(); // reset form on modals
        $("#usergroupid").val(0).change();
        $("#branchid").val(0).change();
        $("#status").val(1).change();

        $('#usergroupid').attr('disabled', false); //set button disable 
        $('#branchid').attr('disabled', false); //set button disable 
        $('#fullname').attr('disabled', false); //set button disable 
        $('#phone').attr('disabled', false); //set button disable 
        $('#email').attr('disabled', false); //set button disable 
        $('#address').attr('disabled', false); //set button disable 
        $('#status').attr('disabled', false); //set button disable 

        $('#FormModal').modal('show'); // show bootstrap modal
        $('.modal-title').text('Tambah Pengguna'); // Set Title to Bootstrap modal title
    }

    function view_data(userid) {
        $('#formtype').val("view");
        $('#form')[0].reset(); // reset form on modals

        //Ajax Load data from ajax
        $.ajax({
            type: "POST",
            dataType: "JSON",
            url: "<?php echo site_url() ?>user_management/user/ajax_view",
            data: {
                id: userid
            },
            success: function(data) {
                $('#userid').val(userid);
                $('#usergroupid').val(data.user_group_id).change();
                $('#branchid').val(data.branch_id).change();
                $('#fullname').val(data.fullname);
                $('#phone').val(data.phone);
                $('#email').val(data.email);
                $('#address').val(data.address);
                $('#username').val(data.username);
                $('#password').val(data.password);
                $('#logincode').val(data.login_code);
                $('#status').val(data.status).change();

                $('#usergroupid').attr('disabled', true); //set button disable 
                $('#branchid').attr('disabled', true); //set button disable 
                $('#fullname').attr('disabled', true); //set button disable 
                $('#phone').attr('disabled', true); //set button disable 
                $('#email').attr('disabled', true); //set button disable 
                $('#address').attr('disabled', true); //set button disable 
                $('#username').attr('disabled', true); //set button disable 
                $('#password').attr('disabled', true); //set button disable 
                $('#logincode').attr('disabled', true); //set button disable 
                $('#status').attr('disabled', true); //set button disable 

                $('#FormModal').modal('show'); // show bootstrap modal
                $('.modal-title').text('Lihat Pengguna'); // Set Title to Bootstrap modal title
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

    function edit_data(userid) {
        $('#formtype').val("edit");
        $('#form')[0].reset(); // reset form on modals

        //Ajax Load data from ajax
        $.ajax({
            type: "POST",
            dataType: "JSON",
            url: "<?php echo site_url() ?>user_management/user/ajax_view",
            data: {
                id: userid
            },
            success: function(data) {
                $('#userid').val(userid);
                $('#usergroupid').val(data.user_group_id).change();
                $('#branchid').val(data.branch_id).change();
                $('#fullname').val(data.fullname);
                $('#phone').val(data.phone);
                $('#email').val(data.email);
                $('#address').val(data.address);
                $('#username').val(data.username);
                $('#password').val(data.password);
                $('#logincode').val(data.login_code);
                $('#status').val(data.status).change();

                $('#usergroupid').attr('disabled', true); //set button disable 
                $('#branchid').attr('disabled', false); //set button disable 
                $('#fullname').attr('disabled', false); //set button disable 
                $('#phone').attr('disabled', false); //set button disable 
                $('#email').attr('disabled', false); //set button disable 
                $('#address').attr('disabled', false); //set button disable 
                $('#username').attr('disabled', false); //set button disable 
                $('#password').attr('disabled', false); //set button disable 
                $('#logincode').attr('disabled', false); //set button disable 
                $('#status').attr('disabled', false); //set button disable 

                $('#FormModal').modal('show'); // show bootstrap modal
                $('.modal-title').text('Lihat Pengguna'); // Set Title to Bootstrap modal title
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
        var isSave = true;
        var isExist = 0;

        $('#btnSave').text('saving...'); //change button text
        $('#btnSave').attr('disabled', true); //set button disable 
        var url;
        var formtype = $('#formtype').val();

        if (formtype == 'add') {
            url = "<?php echo site_url() ?>user_management/user/ajax_add";
            var usergroupid = $('#usergroupid option:selected').val();
            var branchid = $('#branchid option:selected').val();
            var username = $('#username').val();
            var logincode = $('#logincode').val();

            $.ajax({
                type: "POST",
                dataType: "JSON",
                url: "<?php echo site_url() ?>user_management/user/ajax_check_exist",
                data: {
                    username: username,
                    logincode: logincode
                },
                success: function(data) {
                    isExist = data.is_exist;
                },
                error: function() {
                    Swal.fire({
                        icon: 'warning',
                        title: "Peringatan",
                        text: "Gagal Memproses Data",
                    })
                }
            });

            if (usergroupid == 0) {
                isSave = false;
                $('#btnSave').text('Simpan');
                $('#btnSave').attr('disabled', false);
                Swal.fire({
                    icon: 'warning',
                    title: "Notifikasi",
                    text: "Silahkan Pilih Kategori Pengguna",
                })
            } else if (branchid == 0) {
                isSave = false;
                $('#btnSave').text('Simpan');
                $('#btnSave').attr('disabled', false);
                Swal.fire({
                    icon: 'warning',
                    title: "Notifikasi",
                    text: "Silahkan Pilih Cabang Pengguna",
                })
            } else if (isExist > 0) {
                isSave = false;
                $('#btnSave').text('Simpan');
                $('#btnSave').attr('disabled', false);
                Swal.fire({
                    icon: 'warning',
                    title: "Notifikasi",
                    text: "Username atau Nametag Barcode yang diinput sudah digunakan oleh Pengguna lain",
                })
            }

        } else {
            url = "<?php echo site_url() ?>user_management/user/ajax_update";
        }

        if (isSave) {
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
                        }).then(e => {
                            window.location.reload()
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
                    $('#btnSave').text('Simpan');
                    $('#btnSave').attr('disabled', false);
                    Swal.fire({
                        icon: 'warning',
                        title: "Peringatan",
                        text: "Gagal Memproses Data",
                    })
                }
            });
        }

    }

    function delete_data(usergroupid) {
        Swal.fire({
            icon: 'warning',
            title: "Hapus Data",
            text: "Apa anda yakin menghapus data ini?",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Hapus",
            cancelButtonText: "Batal",
            closeOnConfirm: false,
            closeOnCancel: false
        }).then(e => {
            if (e.isConfirm) {
                $.ajax({
                    type: "POST",
                    dataType: "JSON",
                    url: "<?php echo site_url() ?>user_management/user/ajax_delete",
                    data: {
                        id: usergroupid
                    },
                    success: function(data) {
                        Swal.fire({
                            icon: 'success',
                            title: "Notifikasi",
                            text: data.message,
                        }).then(() => {
                            location.reload();
                        })
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        Swal.fire({
                            icon: 'warning',
                            title: "Peringatan",
                            text: "Gagal Memproses Data",
                        })
                    }
                });
            }
        })
    }
</script>

<?php $this->load->view('template/footer'); ?>