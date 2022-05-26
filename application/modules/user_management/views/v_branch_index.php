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
            Cabang
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">User Management</a></li>
            <li class="active">Cabang</li>
        </ol>
    </section>

    <section class="content">
        <div class="box box-info">
            <div class="box-header with-border">
                List Data
            </div>
            <div class="box-body">
                <table id="BranchTable" class="table table-bordered table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>Jenis Kantor</th>
                            <th>Kode Cabang</th>
                            <th>Nama Cabang</th>
                            <th>Status Cabang</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($branch->result() as $row) : ?>
                            <tr>
                                <td><?php echo $row->office_type; ?></td>
                                <td><?php echo $row->branch_code; ?></td>
                                <td><?php echo $row->branch_name; ?></td>
                                <td><?php echo $row->strbranch_status; ?></td>
                                <td>
                                    <button class="btn btn-sm btn-success bold" onclick="view_data(<?php echo $row->branch_id; ?>)"><i class="fa fa-file-text-o"></i></button>
                                    &nbsp;
                                    <button class="btn btn-sm btn-warning bold" onclick="edit_data(<?php echo $row->branch_id; ?>)"><i class="fa fa-pencil"></i></button>
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
                            <input type="hidden" class="form-control" id="branchid" name="branchid" value="0">
                            <input type="hidden" class="form-control" id="strbranchaddress" name="strbranchaddress" value="">

                            <div class="form-group">
                                <label class="col-sm-4 control-label">Kode Cabang</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="branchcode" name="branchcode" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Jenis Kantor</label>
                                <div class="col-sm-6">
                                    <select class="form-control input-sm select2" id="officetype" name="officetype" style="width:100%">
                                        <option value="1" selected>Pusat</option>
                                        <option value="2">Cabang</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Nama Cabang</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="branchname" name="branchname">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Status Cabang</label>
                                <div class="col-sm-6">
                                    <select class="form-control input-sm select2" id="branchstatus" name="branchstatus" style="width:100%">
                                        <option value="1" selected>Aktif</option>
                                        <option value="0">Non Aktif</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Alamat Cabang</label>
                                <div class="col-sm-6">
                                    <textarea style="width:100%" rows="10" cols="9" id="branchaddress" name="branchaddress">
                                  </textarea>
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

    $("#BranchTable").DataTable({
        dom: 'Bfrtip',
        lengthMenu: [
            [10, 25, 50, -1],
            ['10 rows', '25 rows', '50 rows', 'Show all']
        ],
        buttons: [
            'pageLength',
            {
                extend: 'excelHtml5',
                title: 'Daftar Cabang',
                exportOptions: {
                    columns: [0, 1, 2, 3]
                }
            },
            {
                extend: 'pdfHtml5',
                title: 'Daftar Cabang',
                orientation: 'portrait',
                pageSize: 'A4',
                exportOptions: {
                    columns: [0, 1, 2, 3]
                },
                customize: function(doc) {
                    doc.content[1].table.widths =
                        Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                }
            },
            {
                extend: 'print',
                title: 'Daftar Cabang',
                orientation: 'portrait',
                pageSize: 'A4',
                exportOptions: {
                    columns: [0, 1, 2, 3]
                },
                customize: function(win) {
                    $(win.document.body)
                        .css('font-size', '10pt');

                    $(win.document.body).find('table')
                        .addClass('compact')
                        .css('font-size', 'inherit');
                }
            }
        ],
        "scrollX": true,
        "lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ],
        'searching': true,
        'ordering': true
    });

    $(document).ready(function() {
        CKEDITOR.replace('branchaddress');
    });

    function add_data() {
        $('#formtype').val("add");
        $('#form')[0].reset(); // reset form on modals

        $('#officetype').attr('disabled', false); //set button disable 
        $('#branchcode').attr('disabled', false); //set button disable 
        $('#branchname').attr('disabled', false); //set button disable 
        $('#branchaddress').attr('disabled', false); //set button disable 
        $('#branchstatus').attr('disabled', false); //set button disable 

        $('#FormModal').modal('show'); // show bootstrap modal
        $('.modal-title').text('Tambah Data Cabang'); // Set Title to Bootstrap modal title
    }

    function view_data(branchid) {
        $('#formtype').val("view");
        $('#form')[0].reset(); // reset form on modals

        //Ajax Load data from ajax
        $.ajax({
            type: "POST",
            dataType: "JSON",
            url: "<?php echo site_url() ?>user_management/branch/ajax_view",
            data: {
                id: branchid
            },
            success: function(data) {
                $('#branchid').val(branchid);
                $('#officetype').val(data.office_type).change();
                $('#branchcode').val(data.branch_code);
                $('#branchname').val(data.branch_name);
                $('#branchstatus').val(data.branch_status).change();

                CKEDITOR.instances.branchaddress.setData(data.branch_address);
                CKEDITOR.instances.branchaddress.readOnly = true;

                $('#officetype').attr('disabled', true); //set button disable 
                $('#branchcode').attr('disabled', true); //set button disable 
                $('#branchname').attr('disabled', true); //set button disable 
                $('#branchaddress').attr('disabled', true); //set button disable 
                $('#branchstatus').attr('disabled', true); //set button disable 

                $('#FormModal').modal('show'); // show bootstrap modal
                $('.modal-title').text('Lihat Data Cabang'); // Set Title to Bootstrap modal title
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

    function edit_data(branchid) {
        $('#formtype').val("edit");
        $('#form')[0].reset(); // reset form on modals

        //Ajax Load data from ajax
        $.ajax({
            type: "POST",
            dataType: "JSON",
            url: "<?php echo site_url() ?>user_management/branch/ajax_view",
            data: {
                id: branchid
            },
            success: function(data) {
                $('#branchid').val(branchid);
                $('#officetype').val(data.office_type).change();
                $('#branchcode').val(data.branch_code);
                $('#branchname').val(data.branch_name);
                $('#branchstatus').val(data.branch_status).change();

                CKEDITOR.instances.branchaddress.setData(data.branch_address);
                CKEDITOR.instances.branchaddress.readOnly = false;

                $('#officetype').attr('disabled', true); //set button disable 
                $('#branchcode').attr('disabled', true); //set button disable 
                $('#branchname').attr('disabled', false); //set button disable 
                $('#branchstatus').attr('disabled', false); //set button disable 

                $('#FormModal').modal('show'); // show bootstrap modal
                $('.modal-title').text('Ubah Data Cabang'); // Set Title to Bootstrap modal title
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
        var strbranchaddress = CKEDITOR.instances.branchaddress.getData();
        $('#strbranchaddress').val(strbranchaddress);

        $('#btnSave').text('saving...'); //change button text
        $('#btnSave').attr('disabled', true); //set button disable 
        var url;
        var formtype = $('#formtype').val();

        if (formtype == 'add') {
            url = "<?php echo site_url() ?>user_management/branch/ajax_add";
        } else {
            url = "<?php echo site_url() ?>user_management/branch/ajax_update";
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

    function delete_data(branchid) {
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
                    url: "<?php echo site_url() ?>user_management/branch/ajax_delete",
                    data: {
                        id: branchid
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