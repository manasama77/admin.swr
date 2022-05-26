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
            Kategori Pengguna
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">User Management</a></li>
            <li class="active">Kategori Pengguna</li>
        </ol>
    </section>

    <section class="content">
        <div class="box box-info">
            <div class="box-header with-border">
                <button onclick="add_data()" class="btn btn-primary bold"><i class="fa fa-plus-circle"></i> Tambah Data</button>
            </div>
            <div class="box-body">
                <table id="UserGroupTable" class="table table-bordered table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>Kode Kategori Pengguna</th>
                            <th>Nama Kategori Pengguna</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($usergroup->result() as $row) : ?>
                            <tr>
                                <td><?php echo $row->user_group_code; ?></td>
                                <td><?php echo $row->user_group_name; ?></td>
                                <td><?php echo $row->str_status; ?></td>
                                <td>
                                    <button class="btn btn-sm btn-success bold" onclick="view_data(<?php echo $row->user_group_id; ?>)"><i class="fa fa-file-text-o"></i></button>
                                    &nbsp;
                                    <button class="btn btn-sm btn-warning bold" onclick="edit_data(<?php echo $row->user_group_id; ?>)"><i class="fa fa-pencil"></i></button>
                                    &nbsp;
                                    <button class="btn btn-sm btn-danger bold" onclick="delete_data(<?php echo $row->user_group_id; ?>)"><i class="fa fa-ban"></i></button>
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
                            <input type="hidden" class="form-control" id="usergroupid" name="usergroupid" value="0">

                            <div class="form-group">
                                <label class="col-sm-4 control-label">Kode Kategori Pengguna</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="usergroupcode" name="usergroupcode" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Nama Kategori Pengguna</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="usergroupname" name="usergroupname">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Status Kategori Pengguna</label>
                                <div class="col-sm-6">
                                    <select class="form-control input-sm select2" id="usergroupstatus" name="usergroupstatus" style="width:100%">
                                        <option value="1" selected>Aktif</option>
                                        <option value="0">Non Aktif</option>
                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success pull-left" data-dismiss="modal">Kembali</button>
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

    $("#UserGroupTable").DataTable({
        dom: 'Bfrtip',
        lengthMenu: [
            [10, 25, 50, -1],
            ['10 rows', '25 rows', '50 rows', 'Show all']
        ],
        buttons: [
            'pageLength',
            {
                extend: 'excelHtml5',
                title: 'Kategori Pengguna',
                exportOptions: {
                    columns: [0, 1, 2]
                }
            },
            {
                extend: 'pdfHtml5',
                title: 'Kategori Pengguna',
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
        $("#rolestatus").val(1);

        $('#usergroupcode').attr('disabled', false); //set button disable 
        $('#usergroupname').attr('disabled', false); //set button disable 
        $('#usergroupstatus').attr('disabled', false); //set button disable 

        $('#FormModal').modal('show'); // show bootstrap modal
        $('.modal-title').text('Tambah Kategori Pengguna'); // Set Title to Bootstrap modal title
    }

    function view_data(usergroupid) {
        $('#formtype').val("view");
        $('#form')[0].reset(); // reset form on modals

        //Ajax Load data from ajax
        $.ajax({
            type: "POST",
            dataType: "JSON",
            url: "<?php echo site_url() ?>user_management/user_group/ajax_view",
            data: {
                id: usergroupid
            },
            success: function(data) {
                $('#usergroupid').val(usergroupid);
                $('#usergroupcode').val(data.user_group_code);
                $('#usergroupname').val(data.user_group_name);
                $('#usergroupstatus').val(data.user_group_status).change();

                $('#usergroupcode').attr('disabled', true); //set button disable 
                $('#usergroupname').attr('disabled', true); //set button disable 
                $('#usergroupstatus').attr('disabled', true); //set button disable 
                $('#btnSave').attr('disabled', true); //set button disable 

                $('#FormModal').modal('show'); // show bootstrap modal
                $('.modal-title').text('Lihat Kategori Pengguna'); // Set Title to Bootstrap modal title
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

    function edit_data(usergroupid) {
        $('#formtype').val("edit");
        $('#form')[0].reset(); // reset form on modals

        //Ajax Load data from ajax
        $.ajax({
            type: "POST",
            dataType: "JSON",
            url: "<?php echo site_url() ?>user_management/user_group/ajax_view",
            data: {
                id: usergroupid
            },
            success: function(data) {
                $('#usergroupid').val(usergroupid);
                $('#usergroupcode').val(data.user_group_code);
                $('#usergroupname').val(data.user_group_name);
                $('#usergroupstatus').val(data.user_group_status).change();

                $('#usergroupcode').attr('disabled', true); //set button disable 
                $('#usergroupname').attr('disabled', false); //set button disable 
                $('#usergroupstatus').attr('disabled', false); //set button disable 
                $('#btnSave').attr('disabled', false); //set button disable 

                $('#FormModal').modal('show'); // show bootstrap modal
                $('.modal-title').text('Ubah Kategori Pengguna'); // Set Title to Bootstrap modal title
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
        $('#btnSave').text('saving...'); //change button text
        $('#btnSave').attr('disabled', true); //set button disable 
        var url;
        var formtype = $('#formtype').val();

        if (formtype == 'add') {
            url = "<?php echo site_url() ?>user_management/user_group/ajax_add";
        } else {
            url = "<?php echo site_url() ?>user_management/user_group/ajax_update";
        }

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
                    url: "<?php echo site_url() ?>user_management/user_group/ajax_delete",
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