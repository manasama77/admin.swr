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
            Barang
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Data Utama</a></li>
            <li class="active">Barang</li>
        </ol>
    </section>

    <section class="content">
        <div class="box box-info">
            <div class="box-header with-border">
                <button onclick="add_data()" class="btn btn-primary bold"><i class="fa fa-plus-circle"></i> Tambah Data</button>
            </div>
            <div class="box-body">
                <table id="StockTable" class="table table-bordered table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>Kategori Barang</th>
                            <th>Merk Barang</th>
                            <th>Satuan Barang</th>
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th>Minimum</th>
                            <th>Keterangan</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($stockitem->result() as $row) : ?>
                            <tr>
                                <td><?php echo $row->stock_category_name; ?></td>
                                <td><?php echo $row->merk_name; ?></td>
                                <td><?php echo $row->unit_name; ?></td>
                                <td><?php echo $row->item_code; ?></td>
                                <td><?php echo $row->item_name; ?></td>
                                <td><?php echo $row->minimum_stock; ?></td>
                                <td><?php echo $row->keterangan; ?></td>
                                <td>
                                    <div class="btn-group">
                                        <button class="btn btn-sm btn-success bold" onclick="modal_print(<?= $row->item_id; ?>, '<?= $row->item_code; ?>')" title="Print Barcode"><i class="fa fa-barcode fa-fw"></i></button>
                                        <button class="btn btn-sm btn-warning bold" onclick="edit_data(<?= $row->item_id; ?>)"><i class="fa fa-pencil fa-fw"></i></button>
                                        <button class="btn btn-sm btn-danger bold" onclick="delete_data(<?= $row->item_id; ?>)"><i class="fa fa-ban fa-fw"></i></button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <div class="modal fade bd-example-modal-lg" id="FormModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" style="text-align:center;"><strong>Role Form</strong></h4>
                </div>
                <form action="#" id="form" class="form-horizontal">
                    <div class="modal-body">
                        <input type="hidden" class="form-control" id="formtype" name="formtype" value="">
                        <input type="hidden" class="form-control" id="itemid" name="itemid" value="0">

                        <input type="hidden" class="form-control" id="isfotofilename" name="isfotofilename" value="0">
                        <input type="hidden" class="form-control" id="strfotofilename" name="strfotofilename" value="">
                        <input type="hidden" class="form-control" id="strfotopreview" name="strfotopreview" value="">

                        <div class="form-group">
                            <label class="col-sm-4 control-label">Kode Barang / Barcode <span class="text-danger">*</span></label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="itemcode" name="itemcode" required>
                                <input type="hidden" id="olditemcode" name="olditemcode">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Kategori Barang <span class="text-danger">*</span></label>
                            <div class="col-sm-6">
                                <select class="form-control select2" id="stockcategoryid" name="stockcategoryid" style="width: 100%;" data-placeholder="Pilih Kategori" required>
                                    <option value=""></option>
                                    <?php foreach ($stockcategory->result() as $row) : ?>
                                        <?php echo "<option value='" . $row->stock_category_id . "'>(" . $row->stock_category_code . ") " . $row->stock_category_name . "</option>"; ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Merk Barang <span class="text-danger">*</span></label>
                            <div class="col-sm-6">
                                <select class="form-control select2" id="merk_id" name="merk_id" style="width: 100%;" data-placeholder="Pilih Merk" required>
                                    <option value='' selected></option>
                                    <?php foreach ($merk->result() as $row) : ?>
                                        <?php echo "<option value='" . $row->id . "'>" . $row->name . "</option>"; ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Satuan Barang <span class="text-danger">*</span></label>
                            <div class="col-sm-6">
                                <select class="form-control select2" id="unitid" name="unitid" style="width: 100%;" data-placeholder="Pilih Satuan" required>
                                    <option value=""></option>
                                    <?php foreach ($unit->result() as $row) : ?>
                                        <?php echo "<option value='" . $row->unit_id . "'>(" . $row->unit_code . ") " . $row->unit_name . "</option>"; ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Nama Barang <span class="text-danger">*</span></label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="itemname" name="itemname" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Minimum Stock <span class="text-danger">*</span></label>
                            <div class="col-sm-6">
                                <input type="number" class="form-control" id="minimum_stock" name="minimum_stock" min="0" required />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Keterangan Rak / Freezer</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="keterangan" name="keterangan">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Gambar Barang</label>
                            <div class="col-sm-6">
                                <input id="foto" name="foto" type="file">
                                <br />* Gambar dengan format .jpg / .jpeg / .png
                                <br />
                                <div id="fotopreview"></div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success pull-left" data-dismiss="modal">Batal</button>
                        <button type="submit" id="btnSave" class="btn btn-danger pull-right">Simpan</button>
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

<form id="form_print">
    <div class="modal fade" id="modal_print" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" style="text-align:center;"><strong>Print Barcode</strong></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label">Item Code</label>
                        <input type="text" class="form-control" id="item_code" name="item_code" placeholder="Item Code" required readonly />
                    </div>
                    <div class="form-group">
                        <label class="control-label">Jumlah Barcode</label>
                        <input type="number" class="form-control" id="jumlah" name="jumlah" placeholder="Jumlah Barcode" value="1" min="1" required />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success pull-left" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger pull-right">Print</button>
                </div>
            </div>
        </div>
    </div>
</form>

<?php
$this->load->view('template/js');
?>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(".select2").select2();

    $("#StockTable").DataTable({
        dom: 'Bfrtip',
        lengthMenu: [
            [10, 25, 50, -1],
            ['10 rows', '25 rows', '50 rows', 'Show all']
        ],
        buttons: [
            'pageLength',
            {
                extend: 'excelHtml5',
                title: 'Data Barang',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6]
                }
            },
            {
                extend: 'pdfHtml5',
                title: 'Data Barang',
                orientation: 'portrait',
                pageSize: 'A4',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6]
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
                    url: '<?php echo site_url() ?>master/stock_item/file_upload',
                    type: "post",
                    data: new FormData(this),
                    processData: false,
                    contentType: false,
                    cache: false,
                    async: false,
                    success: function(data) {
                        window.location.href = '<?php echo site_url() ?>master/stock_item/import/' + filename;
                    }
                });
            } else {
                $("#WarningContent").replaceWith("<div id='WarningContent'>Only accept .xls excel file</div>");
                $('#WarningModal').modal('show');
            }
        });

        $("#foto").change(function() {
            $('#isfotofilename').val(1);
        });

        $('#form').on('submit', e => {
            e.preventDefault()
            if ($('#formtype').val() != "edit") {
                save_data()
            }
        })

        $('#btnSave').on('click', e => {
            if ($('#formtype').val() == "edit") {
                if ($('#itemcode').val().length == 0) {
                    Swal.fire({
                        position: 'center',
                        icon: 'warning',
                        title: 'Kode Barang Wajib Diisi',
                        toast: true,
                        timer: 2000,
                        showConfirmButton: false,
                    }).then(e => {
                        $('#itemcode').focus()
                    })
                } else {
                    save_data()
                }
            }
        })

        $('#form_print').on('submit', e => {
            e.preventDefault()
            let item_code = $('#item_code').val()
            let jumlah = $('#jumlah').val()
            prosesPrint(item_code, jumlah)
        })
    });

    function get_export() {
        var win = window.open('<?php echo site_url() ?>master/stock_item/get_export', '_blank');
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
                url: '<?php echo site_url() ?>master/stock_item/delete',
                data: {
                    itemid: dataId
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
        $('#btnSave').attr('type', 'submit')
        $('#form')[0].reset(); // reset form on modals

        $('#supplierid').val(0).change();
        $('#stockcategoryid').val(0).change();
        $('#unitid').val(0).change();

        $('#supplierid').attr('disabled', false); //set button disable 
        $('#stockcategoryid').attr('disabled', false); //set button disable 
        $('#unitid').attr('disabled', false); //set button disable 
        $('#itemnama').attr('disabled', false); //set button disable 
        //$('#barcode').attr('disabled',false); //set button disable 
        //$('#minimumstock').attr('disabled',false); //set button disable 
        //$('#maximumstock').attr('disabled',false); //set button disable 

        $('#fotopreview').html('');
        /*
                var result           = '';
                var characters       = '0123456789';
                var charactersLength = characters.length;
                for ( var i = 0; i < 12; i++ ) {
                    result += characters.charAt(Math.floor(Math.random() * charactersLength));
                }
                $('#barcode').val(result);
        */
        $('#FormModal').modal('show'); // show bootstrap modal
        $('.modal-title').text('Tambah Data Barang'); // Set Title to Bootstrap modal title
        $('#FormModal').on('shown.bs.modal', function() {
            $('#itemcode').focus();
        })
    }

    function view_data(itemid) {
        $('#formtype').val("edit");

        //Ajax Load data from ajax
        $.ajax({
            type: "POST",
            dataType: "JSON",
            url: "<?php echo site_url() ?>master/stock_item/ajax_view",
            data: {
                id: itemid
            },
            success: function(data) {
                $('#itemid').val(itemid);
                $('#supplierid').val(data.supplier_id).change();
                $('#stockcategoryid').val(data.stock_category_id).change();
                $('#unitid').val(data.unit_id).change();
                $('#itemcode').val(data.item_code);
                $('#itemname').val(data.item_name);
                //$('#barcode').val(data.barcode);
                //$('#minimumstock').val(data.minimum_stock);
                //$('#maximumstock').val(data.maximum_stock);
                $('#fotopreview').html(data.foto_preview);

                var fotofilename = data.foto_filename;
                var fotopreview = data.foto_preview;
                if (fotofilename.length > 0) {
                    $('#isfotofilename').val(0);
                    $('#strfotofilename').val(fotofilename);
                    $('#strfotopreview').val(fotopreview);
                }

                $('#supplierid').attr('disabled', true); //set button disable 
                $('#stockcategoryid').attr('disabled', true); //set button disable 
                $('#unitid').attr('disabled', true); //set button disable 
                $('#itemname').attr('disabled', true); //set button disable 
                //$('#barcode').attr('disabled',true); //set button disable 
                //$('#minimumstock').attr('disabled',true); //set button disable 
                //$('#maximumstock').attr('disabled',true); //set button disable 

                $('#FormModal').modal('show'); // show bootstrap modal
                $('.modal-title').text('Lihat Data Barang'); // Set Title to Bootstrap modal title
            },
            error: function() {
                alert('Failed Lookup Data');
            }
        });
    }

    function edit_data(itemid) {
        $('#formtype').val("edit");
        $('#btnSave').attr('type', 'button')

        //Ajax Load data from ajax
        $.ajax({
            type: "POST",
            dataType: "JSON",
            url: "<?php echo site_url() ?>master/stock_item/ajax_view",
            data: {
                id: itemid
            },
            success: function(data) {
                $('#itemid').val(itemid);
                $('#supplierid').val(data.supplier_id).change();
                $('#stockcategoryid').val(data.stock_category_id).change();
                $('#unitid').val(data.unit_id).change();
                $('#itemcode').val(data.item_code);
                $('#olditemcode').val(data.item_code);
                $('#itemname').val(data.item_name);
                $('#merk_id').val(data.merk_id).trigger('change')
                $('#minimum_stock').val(data.minimum_stock)
                $('#keterangan').val(data.keterangan)
                //$('#barcode').val(data.barcode);
                //$('#minimumstock').val(data.minimum_stock);
                //$('#maximumstock').val(data.maximum_stock);
                $('#fotopreview').html(data.foto_preview);

                var fotofilename = data.foto_filename;
                var fotopreview = data.foto_preview;
                if (fotofilename.length > 0) {
                    $('#isfotofilename').val(0);
                    $('#strfotofilename').val(fotofilename);
                    $('#strfotopreview').val(fotopreview);
                }

                $('#supplierid').attr('disabled', false); //set button disable 
                $('#stockcategoryid').attr('disabled', false); //set button disable 
                $('#unitid').attr('disabled', false); //set button disable 
                $('#itemname').attr('disabled', false); //set button disable 
                //$('#barcode').attr('disabled',false); //set button disable 
                //$('#minimumstock').attr('disabled',false); //set button disable 
                //$('#maximumstock').attr('disabled',false); //set button disable 

                $('#FormModal').modal('show'); // show bootstrap modal
                $('.modal-title').text('Ubah Data Barang'); // Set Title to Bootstrap modal title
            },
            error: function() {
                alert('Failed Lookup Data');
            }
        });
    }

    function save_data() {
        var isfotofilename = $('#isfotofilename').val();
        var strfotopreview = $('#strfotopreview').val();

        var filename1 = $('#foto').val().replace(/.*(\/|\\)/, '');
        var extension1 = filename1.replace(/^.*\./, '');
        if (extension1 == filename1) {
            extension1 = '';
        } else {
            extension1 = extension1.toLowerCase();
        }

        var isvalid = false;
        if ((isfotofilename == 1) && ((extension1 == "jpg") || (extension1 == "jpeg") || (extension1 == "png"))) {
            isvalid = true;
        } else if (isfotofilename == 0) {
            isvalid = true;
        }

        if (!isvalid) {
            Swal.fire({
                position: 'center',
                icon: 'warning',
                title: 'Notifikasi',
                text: "Foto yang diupload tidak menggunakan format yang diharuskan",
            })
        } else {
            $('#btnSave').text('saving...'); //change button text
            $('#btnSave').attr('disabled', true); //set button disable 
            var url;
            var formtype = $('#formtype').val();

            if (formtype == 'add') {
                url = "<?php echo site_url() ?>master/stock_item/ajax_add";
            } else {
                url = "<?php echo site_url() ?>master/stock_item/ajax_update";
            }

            $('#formtype').val("");
            var frm = $('#form');
            // ajax adding data to database
            var frmData = new FormData(frm[0]);
            $.ajax({
                url: url,
                type: "POST",
                data: frmData,
                contentType: false,
                processData: false,
                dataType: "JSON",
                success: function(data) {
                    if (data.status) //if success close modal and reload ajax table
                    {
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Notifikasi',
                            text: data.message,
                            toast: true,
                            showConfirmButton: false,
                            timer: 2000
                        }).then(e => {
                            location.reload()
                        })
                    } else {
                        Swal.fire({
                            position: 'center',
                            icon: 'warning',
                            title: 'Notifikasi',
                            text: data.message,
                        }).then(e => {
                            $('#btnSave').text('save');
                            $('#btnSave').attr('disabled', false);
                        })
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    $('#btnSave').text('save');
                    $('#btnSave').attr('disabled', false);
                    Swal.fire({
                        position: 'center',
                        icon: 'warning',
                        title: 'Notifikasi',
                        text: "Gagal Memproses Data",
                    })
                }
            });
        }
    }

    function delete_data(itemid) {
        Swal.fire({
            icon: "question",
            title: "Apa anda yakin menghapus data ini?",
            text: "Semua data Barang yang terkait dengan Barang & Harga akan dihapus dan tidak dapat dikembalikan",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Hapus",
            cancelButtonText: "Batal",
            closeOnConfirm: false,
            closeOnCancel: false
        }).then(e => {
            if (e.isConfirmed) {
                $.ajax({
                    type: "POST",
                    dataType: "JSON",
                    url: "<?php echo site_url() ?>master/stock_item/ajax_delete",
                    data: {
                        id: itemid
                    },
                    success: function(data) {
                        console.log(data.status)
                        if (data.status === false) {
                            Swal.fire({
                                position: 'center',
                                icon: 'warning',
                                title: 'Notifikasi',
                                text: data.message,
                                toast: true,
                                timer: 2000,
                                showConfirmButton: false,
                            }).then(e => {
                                // location.reload();
                            })
                        } else {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Notifikasi',
                                text: data.message,
                                toast: true,
                                timer: 2000,
                                showConfirmButton: false,
                            }).then(e => {
                                location.reload();
                            })
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        Swal.fire({
                            position: 'center',
                            icon: 'warning',
                            title: 'Notifikasi',
                            text: "Gagal Memproses Data",
                            toast: true,
                            timer: 2000,
                            showConfirmButton: false,
                        })
                    }
                });
            }
        });
    }

    function modal_print(item_id, item_code) {
        $('#item_code').val(item_code)
        $('#modal_print').modal('show')
    }

    function prosesPrint(item_code, qty) {
        printPage(`<?= base_url(); ?>master/stock_item/print_barcode/${item_code}/${qty}`)
    }

    function closePrint() {
        document.body.removeChild(this.__container__);
    }

    function setPrint() {
        this.contentWindow.__container__ = this;
        this.contentWindow.onbeforeunload = closePrint;
        this.contentWindow.onafterprint = closePrint;
        this.contentWindow.focus(); // Required for IE
        this.contentWindow.print();
    }

    function printPage(sURL) {
        var oHideFrame = document.createElement("iframe");
        oHideFrame.onload = setPrint;
        oHideFrame.style.position = "fixed";
        oHideFrame.style.right = "0";
        oHideFrame.style.bottom = "0";
        oHideFrame.style.width = "0";
        oHideFrame.style.height = "0";
        oHideFrame.style.border = "0";
        oHideFrame.src = sURL;
        document.body.appendChild(oHideFrame);
    }
</script>
<?php
$this->load->view('template/footer');
?>