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
            Anggota
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Data Utama</a></li>
            <li class="active">Anggota</li>
        </ol>
    </section>

    <section class="content">
        <div class="box box-info">
            <div class="box-header with-border">
                <button onclick="add_data()" class="btn btn-primary bold"><i class="fa fa-plus-circle"></i> Tambah Data</button>
            </div>
            <div class="box-body">
                <table id="MemberTable" class="table table-bordered table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>Kode Anggota</th>
                            <th>Nama Lengkap</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($member->result() as $row) : ?>
                            <tr>
                                <td><?php echo $row->member_code; ?></td>
                                <td><?php echo $row->fullname; ?></td>
                                <td><?php echo $row->strstatus; ?></td>
                                <td>
                                    <button class="btn btn-sm btn-success bold" onclick="view_data(<?php echo $row->member_id; ?>)"><i class="fa fa-file-text-o"></i></button>
                                    &nbsp;
                                    <button class="btn btn-sm btn-warning bold" onclick="edit_data(<?php echo $row->member_id; ?>)"><i class="fa fa-pencil"></i></button>
                                    &nbsp;
                                    <button class="btn btn-sm btn-danger bold" onclick="delete_data(<?php echo $row->member_id; ?>)"><i class="fa fa-ban"></i></button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

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

    <div class="modal fade bd-example-modal-lg" id="FormModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" style="text-align:center;"><strong>Role Form</strong></h4>
                </div>
                <form action="#" id="form" class="form-horizontal">
                    <div class="modal-body">
                        <input type="hidden" class="form-control" id="formtype" name="formtype" value="">
                        <input type="hidden" class="form-control" id="memberid" name="memberid" value="0">

                        <div class="form-group">
                            <label class="col-sm-4 control-label">Kode Anggota</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="membercode" name="membercode" readonly>
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
                            <label class="col-sm-4 control-label">Jenis Identitas</label>
                            <div class="col-sm-6">
                                <select class="form-control input-sm select2" id="identitytype" name="identitytype" style="width:100%">
                                    <option value="0" selected>Silahkan Pilih...</option>
                                    <option value="1">KTP</option>
                                    <option value="2">SIM</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Nomor Identitas</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="identityid" name="identityid">
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

    $("#MemberTable").DataTable({
        dom: 'Bfrtip',
        lengthMenu: [
            [10, 25, 50, -1],
            ['10 rows', '25 rows', '50 rows', 'Show all']
        ],
        buttons: [
            'pageLength',
            {
                extend: 'excelHtml5',
                title: 'Anggota',
                exportOptions: {
                    columns: [0, 1, 2]
                }
            },
            {
                extend: 'pdfHtml5',
                title: 'Anggota',
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
                    url: '<?php echo site_url() ?>master/member/file_upload',
                    type: "post",
                    data: new FormData(this),
                    processData: false,
                    contentType: false,
                    cache: false,
                    async: false,
                    success: function(data) {
                        window.location.href = '<?php echo site_url() ?>master/member/import/' + filename;
                    }
                });
            } else {
                $("#WarningContent").replaceWith("<div id='WarningContent'>Only accept .xls excel file</div>");
                $('#WarningModal').modal('show');
            }
        });
    });

    function get_export() {
        var win = window.open('<?php echo site_url() ?>master/member/get_export', '_blank');
        if (win) {
            win.focus();
        } else {
            $("#WarningContent").replaceWith("<div id='WarningContent'>Please allow popups for this website</div>");
            $('#WarningModal').modal('show');
        }
    }

    $(function() {
        $('#btnConfirm').click(function(e) {
            var dataId = $('#dataId').val();
            $('#ConfirmModal').modal('hide');

            var success = true;
            $.ajax({
                type: 'POST',
                dataType: 'JSON',
                url: '<?php echo site_url() ?>master/member/delete',
                data: {
                    memberid: dataId
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

        $('#fullname').attr('disabled', false); //set button disable 
        $('#phone').attr('disabled', false); //set button disable 
        $('#email').attr('disabled', false); //set button disable 
        $('#address').attr('disabled', false); //set button disable 
        $('#identitytype').attr('disabled', false); //set button disable 
        $('#identityid').attr('disabled', false); //set button disable 
        $('#status').attr('disabled', false); //set button disable 

        $('#FormModal').modal('show'); // show bootstrap modal
        $('.modal-title').text('Tambah Anggota'); // Set Title to Bootstrap modal title
    }

    function view_data(memberid) {
        $('#formtype').val("view");
        $('#form')[0].reset(); // reset form on modals

        //Ajax Load data from ajax
        $.ajax({
            type: "POST",
            dataType: "JSON",
            url: "<?php echo site_url() ?>master/member/ajax_view",
            data: {
                id: memberid
            },
            success: function(data) {
                $('#memberid').val(memberid);
                $('#membercode').val(data.member_code);
                $('#fullname').val(data.fullname);
                $('#phone').val(data.phone);
                $('#email').val(data.email);
                $('#address').val(data.address);
                $('#identitytype').val(data.identity_type).change();
                $('#identityid').val(data.identity_id);
                $('#status').val(data.status).change();

                $('#fullname').attr('disabled', true); //set button disable 
                $('#phone').attr('disabled', true); //set button disable 
                $('#email').attr('disabled', true); //set button disable 
                $('#address').attr('disabled', true); //set button disable 
                $('#identitytype').attr('disabled', true); //set button disable 
                $('#identityid').attr('disabled', true); //set button disable 
                $('#status').attr('disabled', true); //set button disable 

                $('#FormModal').modal('show'); // show bootstrap modal
                $('.modal-title').text('Lihat Anggota'); // Set Title to Bootstrap modal title
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

    function edit_data(memberid) {
        $('#formtype').val("edit");
        $('#form')[0].reset(); // reset form on modals

        //Ajax Load data from ajax
        $.ajax({
            type: "POST",
            dataType: "JSON",
            url: "<?php echo site_url() ?>master/member/ajax_view",
            data: {
                id: memberid
            },
            success: function(data) {
                $('#memberid').val(memberid);
                $('#membercode').val(data.member_code);
                $('#fullname').val(data.fullname);
                $('#phone').val(data.phone);
                $('#email').val(data.email);
                $('#address').val(data.address);
                $('#identitytype').val(data.identity_type).change();
                $('#identityid').val(data.identity_id);
                $('#status').val(data.status).change();

                $('#fullname').attr('disabled', false); //set button disable 
                $('#phone').attr('disabled', false); //set button disable 
                $('#email').attr('disabled', false); //set button disable 
                $('#address').attr('disabled', false); //set button disable 
                $('#identitytype').attr('disabled', false); //set button disable 
                $('#identityid').attr('disabled', false); //set button disable 
                $('#status').attr('disabled', false); //set button disable 

                $('#FormModal').modal('show'); // show bootstrap modal
                $('.modal-title').text('Ubah Anggota'); // Set Title to Bootstrap modal title
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
            url = "<?php echo site_url() ?>master/member/ajax_add";
        } else {
            url = "<?php echo site_url() ?>master/member/ajax_update";
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
                        icon: 'success',
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

    function delete_data(membergroupid) {
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
                    url: "<?php echo site_url() ?>master/member/ajax_delete",
                    data: {
                        id: membergroupid
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
<?php
$this->load->view('template/footer');
?>