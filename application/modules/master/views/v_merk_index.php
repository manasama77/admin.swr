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
            Merk
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Data Utama</a></li>
            <li class="active">Merk</li>
        </ol>
    </section>

    <section class="content">
        <div class="box box-info">
            <div class="box-header with-border">
                <button onclick="add_data()" class="btn btn-primary bold"><i class="fa fa-plus-circle"></i> Tambah Data</button>
            </div>
            <div class="box-body">
                <table id="SupplierTable" class="table table-bordered table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Merk</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($merk->result() as $row) :
                        ?>
                            <tr>
                                <td><?php echo $i++; ?></td>
                                <td><?php echo $row->name; ?></td>
                                <td>
                                    <div class="btn-group">
                                        <button class="btn btn-sm btn-warning bold" onclick="edit_data(<?php echo $row->id; ?>)"><i class="fa fa-pencil"></i></button>
                                        <button class="btn btn-sm btn-danger bold" onclick="delete_data(<?php echo $row->id; ?>)"><i class="fa fa-ban"></i></button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <div class="modal fade bd-example-modal" id="FormModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" style="text-align:center;"><strong>Role Form</strong></h4>
                </div>
                <form action="#" id="form" class="form-horizontal">
                    <div class="modal-body">
                        <input type="hidden" class="form-control" id="formtype" name="formtype" value="">
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Nama Merk</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="nama_merk" name="nama_merk">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" id="id_merk_edit" name="id_merk_edit" />
                        <button type="button" class="btn btn-success pull-left" data-dismiss="modal">Batal</button>
                        <button type="button" id="btnSave" onclick="save_data()" class="btn btn-danger pull-right">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="ImportModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" style="text-align:center;"><strong>Import Data</strong></h4>
                </div>
                <form class="form-horizontal" method='post' action='' enctype="multipart/form-data" id="formimport">
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Excel File</label>
                            <div class="col-sm-6">
                                <input type="file" name="file">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label"></label>
                            <div class="col-sm-6">
                                <font color="red">* Only .xls excel file accepted</font>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success pull-left" data-dismiss="modal">Cancel</button>
                        <button type="submit" id="btnImport" class="btn btn-danger pull-right">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="WarningModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" style="text-align:center;"><strong>Notification</strong></h3>
                </div>
                <div class="modal-body">
                    <div id="WarningContent"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="btnClose" class="btn btn-success pull-right" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="ConfirmModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" style="text-align:center;"><strong>Warning</strong></h3>
                </div>
                <div class="modal-body">
                    <input type="hidden" class="form-control" id="dataId" name="dataId" value="0">
                    <div id="ConfirmContent"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success pull-left" data-dismiss="modal">No</button>
                    <button type="button" id="btnConfirm" class="btn btn-danger pull-right">Yes</button>
                </div>
            </div>
        </div>
    </div>

</div>

<?php
$this->load->view('template/js');
?>
<script>
    $(".select2").select2();

    $("#SupplierTable").DataTable({
        dom: 'frtip',
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

    $('#ImportButton').click(function(e) {
        $('#ImportModal').modal('show');
    });

    $(document).ready(function() {
        $('#ExportButton').click(function(e) {
            get_export();
        });

        $('#formimport').submit(function(e) {
            $('#ImportModal').modal('hide');

            e.preventDefault();

            var filename = $('input[type=file]').val().replace(/.*(\/|\\)/, '');
            var extension = filename.replace(/^.*\./, '');
            if (extension == filename) {
                extension = '';
            } else {
                extension = extension.toLowerCase();
            }

            if (extension == "xls") {
                $.ajax({
                    url: '<?php echo site_url() ?>master/supplier/file_upload',
                    type: "post",
                    data: new FormData(this),
                    processData: false,
                    contentType: false,
                    cache: false,
                    async: false,
                    success: function(data) {
                        window.location.href = '<?php echo site_url() ?>master/supplier/import/' + filename;
                    }
                });
            } else {
                $("#WarningContent").replaceWith("<div id='WarningContent'>Only accept .xls excel file</div>");
                $('#WarningModal').modal('show');
            }
        });
    });

    function get_export() {
        var win = window.open('<?php echo site_url() ?>master/supplier/get_export', '_blank');
        if (win) {
            win.focus();
        } else {
            $("#WarningContent").replaceWith("<div id='WarningContent'>Please allow popups for this website</div>");
            $('#WarningModal').modal('show');
        }
    }

    function val_delete(id) {
        $('#dataId').val(id);
        $("#ConfirmContent").replaceWith("<div id='ConfirmContent'>Are you sure delete this data?</div>");
        $('#ConfirmModal').modal('show');
    }

    $(function() {
        $('#btnConfirm').click(function(e) {
            var dataId = $('#dataId').val();
            $('#ConfirmModal').modal('hide');

            var success = true;
            $.ajax({
                type: 'POST',
                dataType: 'JSON',
                url: '<?php echo site_url() ?>master/supplier/delete',
                data: {
                    supplierid: dataId
                },
                success: function(data) {
                    $("#WarningContent").replaceWith("<div id='WarningContent'>" + data + "</div>");
                },
                error: function() {
                    success = false;
                }
            });

            if (success) {
                $('#WarningModal').modal('show');
            }
        });

        $('#btnClose').click(function(e) {
            $('#WarningModal').modal('hide');
            location.reload();
        });
    });

    function add_data() {
        $('#formtype').val("add");
        $('#form')[0].reset(); // reset form on modals
        $('#nama_merk').attr('disabled', false); //set button disable
        $('#FormModal').modal('show'); // show bootstrap modal
        $('.modal-title').text('Tambah Merk'); // Set Title to Bootstrap modal title
    }

    function view_data(supplierid) {
        $('#formtype').val("view");
        $('#form')[0].reset(); // reset form on modals

        //Ajax Load data from ajax
        $.ajax({
            type: "POST",
            dataType: "JSON",
            url: "<?php echo site_url() ?>master/merk/ajax_view",
            data: {
                id: supplierid
            },
            success: function(data) {
                $('#supplierid').val(supplierid);
                $('#suppliercode').val(data.supplier_code);
                $('#suppliername').val(data.supplier_name);
                $('#contactname').val(data.contact_name);
                $('#phone').val(data.phone);
                $('#handphone').val(data.email);
                $('#email').val(data.email);
                $('#city').val(data.email);
                $('#address').val(data.address);
                $('#description').val(data.address);

                $('#suppliername').attr('disabled', true); //set button disable 
                $('#contactname').attr('disabled', true); //set button disable 
                $('#phone').attr('disabled', true); //set button disable 
                $('#handphone').attr('disabled', true); //set button disable 
                $('#email').attr('disabled', true); //set button disable 
                $('#city').attr('disabled', true); //set button disable 
                $('#address').attr('disabled', true); //set button disable 
                $('#description').attr('disabled', true); //set button disable 

                $('#FormModal').modal('show'); // show bootstrap modal
                $('.modal-title').text('Lihat Supplier'); // Set Title to Bootstrap modal title
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

    function edit_data(id_merk) {
        $('#formtype').val("edit");
        $('#form')[0].reset(); // reset form on modals

        //Ajax Load data from ajax
        $.ajax({
            type: "POST",
            dataType: "JSON",
            url: "<?php echo site_url() ?>master/merk/ajax_view",
            data: {
                id: id_merk
            },
            success: function(data) {
                console.log(data)
                $('#id_merk_edit').val(id_merk);
                $('#nama_merk').val(data.name);
                $('#nama_merk').attr('disabled', false); //set button disable 
                $('#FormModal').modal('show'); // show bootstrap modal
                $('.modal-title').text('Ubah Merk'); // Set Title to Bootstrap modal title
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
            url = "<?php echo site_url() ?>master/merk/ajax_add";
        } else {
            url = "<?php echo site_url() ?>master/merk/ajax_update";
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

    function delete_data(id_merk_edit) {
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
                    url: "<?php echo site_url() ?>master/merk/ajax_delete",
                    data: {
                        id: id_merk_edit
                    },
                    success: function(data) {
                        Swal.fire({
                            icon: 'success',
                            title: "Notifikasi",
                            text: data.message,
                        }).then(e => {
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
<?php
$this->load->view('template/footer');
?>