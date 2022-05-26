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
            Harga Barang
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Data Utama</a></li>
            <li class="active">Harga Barang</li>
        </ol>
    </section>

    <section class="content">
        <div class="box box-info">
            <div class="box-header with-border">
                <button onclick="add_data()" class="btn btn-primary bold"><i class="fa fa-plus-circle"></i> Tambah Data</button>
            </div>
            <div class="box-body">
                <table id="PriceTable" class="table table-bordered table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>Barang</th>
                            <th>Mulai Berlaku</th>
                            <th>Harga Beli</th>
                            <th>Harga Jual</th>
                            <th>Keuntungan</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <div id="loading_sign_form" class="overlay">
                <i class="fa fa-refresh fa-spin"></i>
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
                        <input type="hidden" class="form-control" id="priceid" name="priceid" value="0">

                        <div class="form-group">
                            <label class="col-sm-4 control-label">Cabang</label>
                            <div class="col-sm-6">
                                <select class="form-control select2" id="branchid" name="branchid" style="width: 100%;">
                                    <option value='0' selected>Silahkan Pilih</option>
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
                            <label class="col-sm-4 control-label">Mulai Berlaku</label>
                            <div class="col-sm-6">
                                <input type="date" class="form-control pull-right" id="startperiod" name="startperiod" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Harga Beli Barang</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="buyingprice" name="buyingprice" value="0" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Harga Jual</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="sellingprice" name="sellingprice" value="0" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Keuntungan</label>
                            <div class="col-sm-6">
                                <h5 style="font-weight: bold; text-align: left;" id="v_keuntungan">0 (0%)</h5>
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

<!-- Modal -->
<div class="modal fade" id="modal_view" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" style="text-align:center; font-weight: bold;">Lihat Data Harga Barang</h4>
            </div>
            <div class="modal-body" id="v_view"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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

    $("#PriceTable").DataTable({
        "processing": true,
        "serverSide": true,
        "pagingType": "full_numbers",
        "ajax": {
            "url": "<?php echo site_url() ?>master/price/get_all_price",
            "type": "POST"
        },
        dom: 'Bftrip',
        lengthMenu: [
            [10, 25, 50, -1],
            ['10 rows', '25 rows', '50 rows', 'Show all']
        ],
        buttons: [
            'pageLength',
            {
                extend: 'excelHtml5',
                title: 'Harga Barang',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4]
                }
            },
            {
                extend: 'pdfHtml5',
                title: 'Harga Barang',
                orientation: 'portrait',
                pageSize: 'A4',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4]
                },
                customize: function(doc) {
                    doc.content[1].table.widths =
                        Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                }
            }, 'print'
        ],
        "columns": [{
                "data": "item_name"
            },
            {
                "data": "period"
            },
            {
                "data": "buying_price",
                render: $.fn.dataTable.render.number(',', '.', 0),
            },
            {
                "data": "selling_price",
                render: $.fn.dataTable.render.number(',', '.', 0),
            },
            {
                "data": "profit",
            },
            {
                "data": "action"
            },
        ],
        columnDefs: [{
            className: 'text-center',
            orderable: false,
            targets: -1
        }],
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
        prepare_data();

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
                    url: '<?php echo site_url() ?>master/price/file_upload',
                    type: "post",
                    data: new FormData(this),
                    processData: false,
                    contentType: false,
                    cache: false,
                    async: false,
                    success: function(data) {
                        window.location.href = '<?php echo site_url() ?>master/price/import/' + filename;
                    }
                });
            } else {
                $("#WarningContent").replaceWith("<div id='WarningContent'>Only accept .xls excel file</div>");
                $('#WarningModal').modal('show');
            }
        });

        $('#buyingprice').on('keyup', e => {
            e.preventDefault()
            if ($('#buyingprice').val() != '' && $('#sellingprice').val() != '') {
                generatePersen()
            }
        })

        $('#sellingprice').on('keyup', e => {
            e.preventDefault()
            if ($('#buyingprice').val() != '' && $('#sellingprice').val() != '') {
                generatePersen()
            }
        })
    });

    function generatePersen() {
        let buy = $('#buyingprice').val()
        let sell = $('#sellingprice').val()
        let keuntungan = sell - buy
        let persen = (keuntungan / buy) * 100
        let htmlnya = `${keuntungan} (${persen}%)`
        $('#v_keuntungan').html(htmlnya)
    }

    function prepare_data() {
        $('#loading_sign_form').show();
        $.ajax({
            type: 'POST',
            dataType: 'JSON',
            url: '<?php echo site_url() ?>master/price/prepare_data',
            success: function(data) {

                var html = '';
                $.each(data.branch, function(i, item) {
                    html += '<option value="' + item.branch_id + '">(' + item.branch_code + ') ' + item.branch_name + '</option>';
                });

                $('#branchid').empty();
                $('#branchid').append('<option value="0" selected>Silahkan Pilih</option>');
                $('#branchid').append(html);

                html = '';
                $.each(data.item, function(i, item) {
                    html += '<option value="' + item.item_id + '">(' + item.barcode + ') ' + item.item_name + '</option>';
                });

                $('#itemid').empty();
                $('#itemid').append('<option value="0" selected>Silahkan Pilih</option>');
                $('#itemid').append(html);
            },
        });
        $('#loading_sign_form').hide();
    }

    function get_export() {
        var win = window.open('<?php echo site_url() ?>master/price/get_export', '_blank');
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
                url: '<?php echo site_url() ?>master/price/delete',
                data: {
                    itempriceid: dataId
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
        $('#itemid').val(0).change();

        $('#branchid').attr('disabled', false); //set button disable 
        $('#itemid').attr('disabled', false); //set button disable 
        $('#datepicker').attr('disabled', false); //set button disable 
        $('#buyingprice').attr('disabled', false); //set button disable 
        $('#sellingprice').attr('disabled', false); //set button disable 

        $('#FormModal').modal('show'); // show bootstrap modal
        $('.modal-title').text('Tambah Data Harga Barang'); // Set Title to Bootstrap modal title
    }

    function view_data(itemid) {
        $.ajax({
            type: "POST",
            dataType: "JSON",
            url: "<?php echo site_url() ?>master/price/ajax_view",
            data: {
                id: itemid
            },
            success: function(data) {
                let htmlnya = `
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th>Cabang</th>
                            <td>${data.branch_name}</td>
                        </tr>
                        <tr>
                            <th>Jenis Barang</th>
                            <td>${data.item_name}</td>
                        </tr>
                        <tr>
                            <th>Mulai Berlaku</th>
                            <td>${data.start_period}</td>
                        </tr>
                        <tr>
                            <th>Harga Beli</th>
                            <td>${data.buying_price}</td>
                        </tr>
                        <tr>
                            <th>Harga Jual</th>
                            <td>${data.selling_price}</td>
                        </tr>
                        <tr>
                            <th>Keuntungan</th>
                            <td>${data.keuntungan} (${data.persen}%)</td>
                        </tr>
                    </thead>
                </table>
                `
                $('#v_view').html(htmlnya)
                $('#modal_view').modal('show'); // show bootstrap modal
            },
            error: function() {
                alert('Failed Lookup Data');
            }
        });
    }

    function edit_data(priceid) {
        $('#formtype').val("edit");

        //Ajax Load data from ajax
        $.ajax({
            type: "POST",
            dataType: "JSON",
            url: "<?php echo site_url() ?>master/price/ajax_view",
            data: {
                id: priceid
            },
            success: function(data) {
                $('#priceid').val(priceid);
                $('#branchid').val(data.branch_id).change();
                $('#itemid').val(data.item_id).change();
                // $('#datepicker').val(data.start_period);
                $('#startperiod').val(data.start_period);
                $('#buyingprice').val(data.buying_price_plain);
                $('#sellingprice').val(data.selling_price_plain);

                $('#branchid').attr('disabled', true); //set button disable 
                $('#itemid').attr('disabled', true); //set button disable 
                $('#datepicker').attr('disabled', false); //set button disable 
                $('#buyingprice').attr('disabled', false).trigger('keyup'); //set button disable 
                $('#sellingprice').attr('disabled', false); //set button disable 

                $('#FormModal').modal('show'); // show bootstrap modal
                $('.modal-title').text('Ubah Data Harga Barang'); // Set Title to Bootstrap modal title
            },
            error: function() {
                alert('Failed Lookup Data');
            }
        });
    }

    function save_data() {
        $('#btnSave').text('saving...'); //change button text
        $('#btnSave').attr('disabled', true); //set button disable 
        var url;
        var formtype = $('#formtype').val();

        if (formtype == 'add') {
            url = "<?php echo site_url() ?>master/price/ajax_add";
        } else {
            url = "<?php echo site_url() ?>master/price/ajax_update";
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
                        title: data.message,
                        toast: true,
                        timer: 2000,
                        showConfirmButton: false,
                    }).then(e => {
                        location.reload();
                    })
                } else {
                    Swal.fire({
                        position: 'center',
                        icon: 'warning',
                        title: data.message,
                        toast: true,
                        timer: 2000,
                        showConfirmButton: false,
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

    function delete_data(itemid) {
        Swal.fire({
            title: "Hapus Data",
            text: "Apa anda yakin menghapus data ini?",
            icon: "warning",
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
                    url: "<?php echo site_url() ?>master/price/ajax_delete",
                    data: {
                        id: itemid
                    },
                    success: function(data) {
                        Swal.fire({
                            position: 'center',
                            icon: 'warning',
                            title: "Notifikasi",
                            text: data.message,
                            toast: true,
                            timer: 2000,
                            showConfirmButton: false,
                        }).then(() => {
                            location.reload();
                        })
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        Swal.fire({
                            position: 'center',
                            icon: 'warning',
                            title: "Peringatan",
                            text: "Gagal Memproses Data",
                            toast: true,
                            timer: 2000,
                            showConfirmButton: false,
                        }).then(() => {
                            location.reload();
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