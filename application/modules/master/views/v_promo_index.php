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
            Promo Harga
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Data Utama</a></li>
            <li class="active">Promo Harga</li>
        </ol>
    </section>

    <section class="content">
        <div class="box box-info">
            <div class="box-header with-border">
                <button onclick="add_data()" class="btn btn-primary bold"><i class="fa fa-plus-circle"></i> Tambah Data</button>
            </div>
            <div class="box-body">
                <table id="PromoTable" class="table table-bordered table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>Nama Promo</th>
                            <th>Cabang</th>
                            <th>Kategori Barang</th>
                            <th>Jenis Barang</th>
                            <th>Periode Awal</th>
                            <th>Periode Akhir</th>
                            <th>Disc</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($promo->result() as $row) : ?>
                            <tr>
                                <td><?php echo $row->promo_name; ?></td>
                                <td><?php echo $row->branch_name; ?></td>
                                <td><?php echo $row->stock_category_name; ?></td>
                                <td><?php echo $row->item_name; ?></td>
                                <td><?php echo date('d M Y', strtotime($row->start_period)); ?></td>
                                <td><?php echo date('d M Y', strtotime($row->end_period)); ?></td>
                                <td>
                                    <?php if ($row->disc_percentage > 0) { ?>
                                        <?php echo number_format($row->disc_percentage, 2, ",", ".") . ' %' ?>
                                    <?php } ?>
                                    <?php if ($row->disc_amount > 0) { ?>
                                        <?php echo 'Rp. ' . number_format($row->disc_amount, 2, ",", ".") ?>
                                    <?php } ?>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-success bold" onclick="view_data(<?php echo $row->item_promo_id; ?>)"><i class="fa fa-file-text-o"></i></button>
                                    &nbsp;
                                    <button class="btn btn-sm btn-warning bold" onclick="edit_data(<?php echo $row->item_promo_id; ?>)"><i class="fa fa-pencil"></i></button>
                                    &nbsp;
                                    <button class="btn btn-sm btn-danger bold" onclick="delete_data(<?php echo $row->item_promo_id; ?>)"><i class="fa fa-ban"></i></button>
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
                        <input type="hidden" class="form-control" id="promoid" name="promoid" value="0">

                        <div class="form-group">
                            <label class="col-sm-4 control-label">Kode Promo</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="promocode" name="promocode" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Nama Promo</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="promoname" name="promoname">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Cabang</label>
                            <div class="col-sm-6">
                                <select class="form-control select2" id="branchid" name="branchid" style="width: 100%;">
                                    <option value='0' selected>Silahkan Pilih</option>
                                    <?php foreach ($branch->result() as $row) : ?>
                                        <?php echo "<option value='" . $row->branch_id . "'>(" . $row->branch_code . ") " . $row->branch_name . "</option>"; ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Kategori Barang</label>
                            <div class="col-sm-6">
                                <select class="form-control select2" id="stockcategoryid" name="stockcategoryid" style="width: 100%;">
                                    <option value='0' selected>Silahkan Pilih</option>
                                    <option value='-1'>Semua Kategori Barang</option>
                                    <?php foreach ($stockcategory->result() as $row) : ?>
                                        <?php echo "<option value='" . $row->stock_category_id . "'>(" . $row->stock_category_code . ") " . $row->stock_category_name . "</option>"; ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Jenis Barang</label>
                            <div class="col-sm-6">
                                <select class="form-control select2" id="itemid" name="itemid" style="width: 100%;">
                                    <option value='0' selected>Silahkan Pilih</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Periode Awal</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control pull-right" id="datepicker" name="startperiod" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Periode Akhir</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control pull-righ" id="datepicker2" name="endperiod" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Disc. Persen</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="discpercentage" name="discpercentage" value="0">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Disc. Nominal</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="discamount" name="discamount" value="0">
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

</div>

<?php
$this->load->view('template/js');
?>
<script>
    $(".select2").select2();

    $('#datepicker').datepicker({
        autoclose: true,
        startDate: new Date()
    }).on('changeDate', function() {
        $('#datepicker2').datepicker('setStartDate', new Date($(this).val()));
    });

    $('#datepicker2').datepicker({
        autoclose: true,
        startDate: new Date()
    }).on('changeDate', function() {
        $('#datepicker').datepicker('setEndDate', new Date($(this).val()));
    });

    $("#PromoTable").DataTable({
        dom: 'Bfrtip',
        lengthMenu: [
            [10, 25, 50, -1],
            ['10 rows', '25 rows', '50 rows', 'Show all']
        ],
        buttons: [
            'pageLength',
            {
                extend: 'excelHtml5',
                title: 'Promo Barang',
                exportOptions: {
                    columns: [0, 1, 2]
                }
            },
            {
                extend: 'pdfHtml5',
                title: 'Promo Barang',
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

    $(document).ready(function() {
        $('#ExportButton').click(function(e) {
            get_export();
        });

        $('#ImportButton').click(function(e) {
            get_import();
        });

        $("#stockcategoryid").change(function() {
            get_item();
        });
    });

    function get_item() {
        var stockcategoryid = $('#stockcategoryid option:selected').val();
        if (stockcategoryid > 0) {
            $.ajax({
                type: "POST",
                dataType: "JSON",
                url: "<?php echo site_url() ?>master/promo/get_item",
                data: {
                    stockcategoryid: stockcategoryid
                },
                success: function(data) {
                    $('#itemid').empty();
                    $('#itemid').append('<option value="0" selected>Silahkan Pilih...</option>');
                    $('#itemid').append('<option value="-1">Semua Jenis Barang</option>');

                    $.each(data, function(i, item) {
                        $('#itemid').append('<option value="' + item.item_id + '">(' + item.barcode + ') ' + item.item_name + '</option>');
                    });
                },
                error: function() {
                    alert('Gagal ambil data');
                }
            });
        } else if (stockcategoryid == -1) {
            $('#itemid').empty();
            $('#itemid').append('<option value="-1" selected>Semua Jenis Barang</option>');
        }
    }

    function get_export() {
        var win = window.open('<?php echo site_url() ?>master/promo/get_export', '_blank');
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
                url: '<?php echo site_url() ?>master/promo/delete',
                data: {
                    itempromoid: dataId
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

        $('#branchid').val(0).change();
        $('#stockcategoryid').val(0).change();
        $('#itemid').val(0).change();

        $('#promoname').attr('disabled', false); //set button disable 
        $('#branchid').attr('disabled', false); //set button disable 
        $('#stockcategoryid').attr('disabled', false); //set button disable 
        $('#itemid').attr('disabled', false); //set button disable 
        $('#datepicker').attr('disabled', false); //set button disable 
        $('#datepicker2').attr('disabled', false); //set button disable 
        $('#discpercentage').attr('disabled', false); //set button disable 
        $('#discamount').attr('disabled', false); //set button disable 

        $('#FormModal').modal('show'); // show bootstrap modal
        $('.modal-title').text('Tambah Data Promo'); // Set Title to Bootstrap modal title
    }

    function view_data(promoid) {
        $('#formtype').val("edit");

        //Ajax Load data from ajax
        $.ajax({
            type: "POST",
            dataType: "JSON",
            url: "<?php echo site_url() ?>master/promo/ajax_view",
            data: {
                id: promoid
            },
            success: function(data) {
                $('#promoid').val(promoid);
                $('#promocode').val(data.promo_code);
                $('#promoname').val(data.promo_name);
                $('#branchid').val(data.branch_id).change();
                $('#stockcategoryid').val(data.stock_category_id).change();
                $('#itemid').val(data.item_id).change();
                $('#datepicker').val(data.start_period);
                $('#datepicker2').val(data.end_period);
                $('#discpercentage').val(data.disc_percentage);
                $('#discamount').val(data.disc_amount);

                $('#promoname').attr('disabled', true); //set button disable 
                $('#branchid').attr('disabled', true); //set button disable 
                $('#stockcategoryid').attr('disabled', true); //set button disable 
                $('#itemid').attr('disabled', true); //set button disable 
                $('#datepicker').attr('disabled', true); //set button disable 
                $('#datepicker2').attr('disabled', true); //set button disable 
                $('#discpercentage').attr('disabled', true); //set button disable 
                $('#discamount').attr('disabled', true); //set button disable 

                $('#FormModal').modal('show'); // show bootstrap modal
                $('.modal-title').text('Lihat Data Harga Barang'); // Set Title to Bootstrap modal title
            },
            error: function() {
                alert('Failed Lookup Data');
            }
        });
    }

    function edit_data(promoid) {
        $('#formtype').val("edit");

        //Ajax Load data from ajax
        $.ajax({
            type: "POST",
            dataType: "JSON",
            url: "<?php echo site_url() ?>master/promo/ajax_view",
            data: {
                id: promoid
            },
            success: function(data) {
                $('#promoid').val(promoid);
                $('#promocode').val(data.promo_code);
                $('#promoname').val(data.promo_name);
                $('#branchid').val(data.branch_id).change();
                $('#stockcategoryid').val(data.stock_category_id).change();
                $('#itemid').val(data.item_id).change();
                $('#datepicker').val(data.start_period);
                $('#datepicker2').val(data.end_period);
                $('#discpercentage').val(data.disc_percentage);
                $('#discamount').val(data.disc_amount);

                $('#promoname').attr('disabled', false); //set button disable 
                $('#branchid').attr('disabled', true); //set button disable 
                $('#stockcategoryid').attr('disabled', true); //set button disable 
                $('#itemid').attr('disabled', true); //set button disable 
                $('#datepicker').attr('disabled', true); //set button disable 
                $('#datepicker2').attr('disabled', false); //set button disable 
                $('#discpercentage').attr('disabled', true); //set button disable 
                $('#discamount').attr('disabled', true); //set button disable 

                $('#FormModal').modal('show'); // show bootstrap modal
                $('.modal-title').text('Ubah Data Harga Barang'); // Set Title to Bootstrap modal title
            },
            error: function() {
                alert('Failed Lookup Data');
            }
        });
    }

    function save_data() {
        var itemid = $('#itemid').val();
        var startperiod = $('#datepicker').val();
        var endperiod = $('#datepicker2').val();
        var discpercentage = parseFloat($('#discpercentage').val());
        var discamount = parseFloat($('#discamount').val());

        var isvalid = true;
        if ((discpercentage != 0) && (discamount != 0)) {
            alert("Disc Percentage and Amount cannot 0");
            isvalid = false;
        }
        if ((discpercentage != 0) && (discamount != 0)) {
            alert("Disc Percentage and Amount cannot be set together");
            isvalid = false;
        }
        if ((discpercentage < 0) && (discpercentage > 0)) {
            alert("Disc Percentage out of range");
            isvalid = false;
        }
        if (discamount < 0) {
            alert("Disc Amount cannot less than 0");
            isvalid = false;
        }

        if (isvalid) {
            $('#btnSave').text('saving...'); //change button text
            $('#btnSave').attr('disabled', true); //set button disable 
            var url;
            var formtype = $('#formtype').val();

            if (formtype == 'add') {
                url = "<?php echo site_url() ?>master/promo/ajax_add";
            } else {
                url = "<?php echo site_url() ?>master/promo/ajax_update";
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
                            timer: 2000,
                            showConfirmButton: false,
                        }).then(e => {
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
    }

    function delete_data(itemid) {
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
                    url: "<?php echo site_url() ?>master/promo/ajax_delete",
                    data: {
                        id: itemid
                    },
                    success: function(data) {
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