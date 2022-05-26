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
            Pindah Stok
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Inventory</a></li>
            <li class="active">Pindah Stok</li>
        </ol>
    </section>

    <section class="content">
        <div class="box box-info">
            <div class="box-header with-border">
                <button onclick="add_data()" class="btn btn-primary bold"><i class="fa fa-plus-circle"></i> Tambah Data</button>
            </div>
            <div class="box-body">
                <table id="StockSwitchTable" class="table table-bordered table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>Cabang Asal</th>
                            <th>Cabang Tujuan</th>
                            <th>Tanggal Pindah</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($stockswitch->result() as $row) : ?>
                            <tr>
                                <td><?php echo $row->branch_origin; ?></td>
                                <td><?php echo $row->branch_destination; ?></td>
                                <td><?php echo date('d M Y', strtotime($row->switch_date)); ?></td>
                                <td>
                                    <button class="btn btn-sm btn-success bold" onclick="view_data(<?php echo $row->stock_switch_id; ?>)"><i class="fa fa-file-text-o"></i></button>
                                    <!--?php if($row->status == 0){ ?>
                                    &nbsp;
                                    <button class="btn btn-sm btn-warning bold" onclick="edit_data(<php echo $row->stock_switch_id; ?>)"><i class="fa fa-pencil"></i></button>
                                        &nbsp;
                                    <button class="btn btn-sm btn-danger bold" onclick="delete_data(<php echo $row->stock_switch_id; ?>)"><i class="fa fa-ban"></i></button>
                                <php } ?-->
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
                    <h4 class="modal-title" style="text-align:center;"><strong>Penjualan Form</strong></h4>
                </div>
                <form action="#" id="form" class="form-horizontal">
                    <div class="modal-body">
                        <input type="hidden" id="formtype" name="formtype" value="">
                        <input type="hidden" id="noitem" name="noitem" value="0">
                        <input type="hidden" id="orderitemedit" name="orderitemedit" value="0">
                        <input type="hidden" id="stockswitchid" name="stockswitchid" value="0">

                        <div class="form-group">
                            <label class="col-sm-4 control-label">Cabang Asal</label>
                            <div class="col-sm-6">
                                <select class="form-control select2" id="branchorigin" name="branchorigin" style="width: 100%;">
                                    <option value='0' selected>Silahkan Pilih</option>
                                    <?php foreach ($branchorigin->result() as $row) : ?>
                                        <?php echo "<option value='" . $row->branch_id . "'>(" . $row->branch_code . ") " . $row->branch_name . "</option>"; ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Cabang Tujuan</label>
                            <div class="col-sm-6">
                                <select class="form-control select2" id="branchdestination" name="branchdestination" style="width: 100%;">
                                    <option value='0' selected>Silahkan Pilih</option>
                                    <?php foreach ($branchdestination->result() as $row) : ?>
                                        <?php echo "<option value='" . $row->branch_id . "'>(" . $row->branch_code . ") " . $row->branch_name . "</option>"; ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Tanggal Pindah</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="datepicker" name="switchdate">
                            </div>
                        </div>
                        <!--div class="form-group">
                        <label class="col-sm-4 control-label">Status</label>
                        <div class="col-sm-6">
                        <select class="form-control select2" id="status" name="status" style="width: 100%;">
                            <option value='0' selected>Draft</option>
                            <option value='1'>Final</option>
                        </select>
                        </div>
                    </div-->
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Informasi</label>
                            <div class="col-sm-6">
                                <textarea style="width:100%" rows="4" id="description" name="description"></textarea>
                            </div>
                        </div>

                        <div id="inputdetail" class="row">
                            <div class="col-md-12">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th style="width:55%">Jenis Barang</th>
                                            <th style="width:15%">Jumlah Tersedia</th>
                                            <th style="width:15%">Jumlah Pindah</th>
                                            <th style="width:15%"></th>
                                        </tr>
                                    </thead>
                                    <tr>
                                        <td style="width:55%">
                                            <select class="form-control select2" id="itemid" name="itemid" style="width: 100%;">
                                                <option value='0' selected>Silahkan Pilih</option>
                                                <?php foreach ($item->result() as $row) : ?>
                                                    <?php echo "<option value='" . $row->item_id . "'>(" . $row->barcode . ") " . $row->item_name . "</option>"; ?>
                                                <?php endforeach; ?>
                                            </select>
                                        </td>
                                        <td style="width:15%">
                                            <input type="text" class="form-control" id="qtyavailable" name="qtyavailable" value="0" readonly>
                                        </td>
                                        <td style="width:15%">
                                            <input type="text" class="form-control" id="qtyswitch" name="qtyswitch" value="0">
                                        </td>
                                        <td style="width:15%">
                                            <button type="button" class="form-control btn btn-info btn-flat" id="AddDetail">Tambah Data</button>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div id="detailadd" class="row">
                            <div class="col-md-12">
                                <table class="table table-striped">
                                    <tbody id="itemadd"></tbody>
                                </table>
                            </div>
                        </div>

                        <div id="detailview" class="row">
                            <div class="col-md-12">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th style="width:55%">Jenis Barang</th>
                                            <th style="width:15%">Jumlah Tersedia</th>
                                            <th style="width:30%">Jumlah Pindah</th>
                                        </tr>
                                    </thead>
                                    <tbody id="itemview"></tbody>
                                </table>
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
                                <font color="red">* Only excel file accepted</font>
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

    $('#datepicker').datepicker({
        autoclose: true,
        startDate: new Date()
    });

    $("#StockSwitchTable").DataTable({
        dom: 'Bfrtip',
        lengthMenu: [
            [10, 25, 50, -1],
            ['10 rows', '25 rows', '50 rows', 'Show all']
        ],
        buttons: [
            'pageLength',
            {
                extend: 'excelHtml5',
                title: 'Pindah Stok',
                exportOptions: {
                    columns: [0, 1, 2]
                }
            },
            {
                extend: 'pdfHtml5',
                title: 'Pindah Stok',
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

    $("tbody#itemadd").on("click", "#edit", function() {
        var OrderItemEdit = $(this).parent().parent().find('#orderitem').val();
        $('#orderitemedit').val(OrderItemEdit);

        var itemStockItemVal = $(this).parent().parent().find('#itemStockItem' + OrderItemEdit).val();
        $('#itemid').val(itemStockItemVal).change();

        $('#qtyavailable').val($(this).parent().parent().find('.itemQtyAvailable').html());
        $('#qtyswitch').val($(this).parent().parent().find('.itemQtySwitch').html());

    });

    $("tbody#itemadd").on("click", "#hapus", function() {
        var OrderItemDelete = $(this).parent().parent().find('#orderitem').val();
        $("#StockSwitch" + OrderItemDelete).remove();
    });

    $(document).ready(function() {

        $("#branchorigin").change(function() {
            get_qty_available();
        });

        $("#itemid").change(function() {
            get_qty_available();
        });

        $('#AddDetail').click(function(e) {

            var itemid = $("#itemid option:selected").val();
            var itemname = $("#itemid option:selected").text();
            var qtyavailable = $("#qtyavailable").val();
            var qtyswitch = $("#qtyswitch").val();

            var noitem = $("#noitem").val();
            var orderitemedit = $("#orderitemedit").val();

            if (itemid == '') {
                Swal.fire({
                    icon: 'warning',
                    title: "Peringatan",
                    text: "Mohon pilih Jenis Barang",
                })
            } else if (qtyswitch <= 0) {
                Swal.fire({
                    icon: 'warning',
                    title: "Peringatan",
                    text: "Mohon isi Jumlah Pindah",
                })
            } else {
                if (orderitemedit > 0) {
                    noitem = orderitemedit;

                    $("#StockSwitch" + noitem + " td.itemStockItem").html(itemname);
                    $("#itemStockItem" + noitem).val(itemid);

                    $("#StockSwitch" + noitem + " td.itemQtyAvailable").html(qty);
                    $("#itemQtyAvailable" + noitem).val(qty);

                    $("#StockSwitch" + noitem + " td.itemQtySwitch").html(qty);
                    $("#itemQtySwitch" + noitem).val(qty);

                    $('#itemid').val(0).change();
                    $('#qtyavailable').val(0);
                    $('#qtyswitch').val(0);
                    $("#orderitemedit").val(0);

                } else {
                    noitem = parseInt(noitem) + 1;
                    var items = "";
                    items += "<tr id='StockSwitch" + noitem + "'>" +
                        "<td style='width:55%' class='itemStockItem'>" + itemname + "</td>" +
                        "<td style='width:15%' class='itemQtyAvailable'>" + qtyavailable + "</td>" +
                        "<td style='width:15%' class='itemQtySwitch'>" + qtyswitch + "</td>" +
                        "<td style='width:15%'>" +
                        "<input type='hidden' id='orderitem' name='orderitem' value='" + noitem + "'> " +
                        "<input type='hidden' id='itemStockItem" + noitem + "' name='item[itemStockItem][]' value='" + itemid + "'> " +
                        "<input type='hidden' id='itemQtyAvailable" + noitem + "' name='item[itemQtyAvailable][]' value='" + qtyavailable + "'> " +
                        "<input type='hidden' id='itemQtySwitch" + noitem + "' name='item[itemQtySwitch][]' value='" + qtyswitch + "'> " +
                        "<button type='button' class='btn btn-sm btn-white' id='edit'><i class='fa fa-pencil'></i></button> <button type='button' class='btn btn-sm btn-white' id='hapus'><i class='fa fa-trash'></i></button> " +
                        "</td>" +
                        "</tr>";

                    $("#itemadd").append(items);

                    $('#itemid').val(0).change();
                    $('#qtyavailable').val(0);
                    $('#qtyswitch').val(0);
                    $("#noitem").val(noitem);

                }
            }
        });

    });

    function get_qty_available() {
        var branchorigin = $("#branchorigin option:selected").val();
        var itemid = $("#itemid option:selected").val();

        if ((branchorigin > 0) && (itemid > 0)) {
            $.ajax({
                type: "POST",
                dataType: "JSON",
                url: "<?php echo site_url() ?>inventory/stock_switch/get_qty_available",
                data: {
                    branchorigin: branchorigin,
                    itemid: itemid
                },
                success: function(data) {
                    if (data.qty_available > 0) {
                        $('#qtyavailable').val(data.qty_available);
                        $('#qtyswitch').val(0);
                        $('#qtyswitch').attr('disabled', false); //set button disable 
                    } else {
                        $('#qtyavailable').val(data.qty_available);
                        $('#qtyswitch').val(0);
                        $('#qtyswitch').attr('disabled', true); //set button disable 
                    }
                },
                error: function() {
                    alert('Gagal ambil data');
                }
            });
        }
    };

    function add_data() {
        $('#formtype').val("add");
        $('#form')[0].reset(); // reset form on modals

        $("#branchorigin").val(0).change();
        $("#branchdestination").val(0).change();
        $("#itemid").val(0).change();
        $("#itemadd").empty();

        $("#inputdetail").show();
        $("#detailadd").show();
        $("#detailview").hide();

        $('#branchorigin').attr('disabled', false); //set button disable 
        $('#branchdestination').attr('disabled', false); //set button disable 
        $('#switchdate').attr('disabled', false); //set button disable 
        //$('#status').attr('disabled',false); //set button disable 
        $('#description').attr('disabled', false); //set button disable 

        $('#FormModal').modal('show'); // show bootstrap modal
        $('.modal-title').text('Tambah Data Pindah Stok'); // Set Title to Bootstrap modal title
    }

    function view_data(stockswitchid) {
        $('#formtype').val("view");

        //Ajax Load data from ajax
        $.ajax({
            type: "POST",
            dataType: "JSON",
            url: "<?php echo site_url() ?>inventory/stock_switch/ajax_view",
            data: {
                id: stockswitchid
            },
            success: function(data) {
                $('#stockswitchid').val(stockswitchid);
                $('#branchorigin').val(data.stockswitch.branch_origin).change();
                $('#branchdestination').val(data.stockswitch.branch_destination).change();
                $('#datepicker').val(data.stockswitch.switch_date);
                //$('#status').val(data.stockswitch.status).change();
                $('#description').val(data.stockswitch.description);

                var noitem = 0;
                var html = '';
                var i;
                $.each(data.stockswitchdet, function(i, item) {
                    noitem = i + noitem;
                    html += "<tr id='StockSwitch" + noitem + "'>" +
                        "<td style='width:55%' class='itemStockItem'>" + item.item_name + "</td>" +
                        "<td style='width:15%' class='itemQtyAvailable'>" + item.qty_available + "</td>" +
                        "<td style='width:30%' class='itemQtySwitch'>" + item.qty_switch + "</td>" +
                        "</tr>";
                });
                $("#itemview").empty();
                $("#itemview").append(html);
                $('#noitem').val(noitem);

                $("#inputdetail").hide();
                $("#detailadd").hide();
                $("#detailview").show();

                $('#branchorigin').attr('disabled', true); //set button disable 
                $('#branchdestination').attr('disabled', true); //set button disable 
                $('#datepicker').attr('disabled', true); //set button disable 
                //$('#status').attr('disabled',true); //set button disable 
                $('#description').attr('disabled', true); //set button disable 

                $('#FormModal').modal('show'); // show bootstrap modal
                $('.modal-title').text('Lihat Data Pindah Stok'); // Set Title to Bootstrap modal title
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

    function edit_data(stockswitchid) {
        $('#formtype').val("edit");

        //Ajax Load data from ajax
        $.ajax({
            type: "POST",
            dataType: "JSON",
            url: "<?php echo site_url() ?>inventory/stock_switch/ajax_view",
            data: {
                id: stockswitchid
            },
            success: function(data) {
                $('#stockswitchid').val(stockswitchid);
                $('#branchorigin').val(data.stockswitch.branch_id).change();
                $('#branchdestination').val(data.stockswitch.supplier_id).change();
                $('#datepicker').val(data.stockswitch.stock_date);
                //$('#status').val(data.stockswitch.status).change();
                $('#description').val(data.stockswitch.description);

                var noitem = 0;
                var html = '';
                var i;
                $.each(data.stockswitchdet, function(i, item) {
                    noitem = i + noitem;
                    html += "<tr id='StockSwitch" + noitem + "'>" +
                        "<td style='width:55%' class='itemStockItem'>" + item.item_name + "</td>" +
                        "<td style='width:15%' class='itemQtyAvailable'>" + item.qty_available + "</td>" +
                        "<td style='width:15%' class='itemQtySwitch'>" + item.qty_switch + "</td>" +
                        "<td style='width:15%'>" +
                        "<input type='hidden' id='orderitem' name='orderitem' value='" + noitem + "'> " +
                        "<input type='hidden' id='itemStockItem" + noitem + "' name='item[itemStockItem][]' value='" + item.item_id + "'> " +
                        "<input type='hidden' id='itemQtyAvailable" + noitem + "' name='item[itemQtyAvailable][]' value='" + item.qty_available + "'> " +
                        "<input type='hidden' id='itemQtySwitch" + noitem + "' name='item[itemQtySwitch][]' value='" + item.qty_switch + "'> " +
                        "<button type='button' class='btn btn-sm btn-white' id='edit'><i class='fa fa-pencil'></i></button> <button type='button' class='btn btn-sm btn-white' id='hapus'><i class='fa fa-trash'></i></button> " +
                        "</td>" +
                        "</tr>";
                });
                $("#itemadd").empty();
                $("#itemadd").append(html);
                $('#noitem').val(noitem);

                $("#inputdetail").show();
                $("#detailadd").show();
                $("#detailview").hide();

                $('#branchorigin').attr('disabled', true); //set button disable 
                $('#branchdestination').attr('disabled', true); //set button disable 
                $('#datepicker').attr('disabled', true); //set button disable 
                //$('#status').attr('disabled',false); //set button disable 
                $('#description').attr('disabled', false); //set button disable 

                $('#FormModal').modal('show'); // show bootstrap modal
                $('.modal-title').text('Lihat Data Pindah Stok'); // Set Title to Bootstrap modal title
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
        var branchorigin = $('#branchorigin option:selected').val();
        var branchdestination = $('#branchdestination option:selected').val();
        var noitem = $('#noitem').val();
        var isSave = true;

        if (branchorigin == 0) {
            isSave = false;
            Swal.fire({
                icon: 'warning',
                title: "Peringatan",
                text: "Silahkan pilih cabang asal terlebih dahulu",
            })
        } else if (branchdestination == 0) {
            isSave = false;
            Swal.fire({
                icon: 'warning',
                title: "Peringatan",
                text: "Silahkan pilih cabang tujuan terlebih dahulu",
            })
        } else if (noitem == 0) {
            isSave = false;
            Swal.fire({
                icon: 'warning',
                title: "Peringatan",
                text: "Silahkan pilih jenis barang terlebih dahulu",
            })
        }

        if (isSave) {
            $('#btnSave').text('saving...'); //change button text
            $('#btnSave').attr('disabled', true); //set button disable 
            var url;
            var formtype = $('#formtype').val();

            if (formtype == 'add') {
                url = "<?php echo site_url() ?>inventory/stock_switch/ajax_add";
            } else {
                url = "<?php echo site_url() ?>inventory/stock_switch/ajax_update";
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
                    //console.log(data);
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
                error: function(data) {
                    //console.log(data);
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

    function delete_data(idbiaya) {
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
                    url: "<?php echo site_url() ?>inventory/stock_switch/ajax_delete",
                    data: {
                        id: idbiaya
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

    function thousandmaker(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }
</script>
<?php
$this->load->view('template/footer');
?>