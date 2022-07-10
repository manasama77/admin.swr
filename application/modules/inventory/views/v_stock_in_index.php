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
            Stok Masuk
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Inventory</a></li>
            <li class="active">Stok Masuk</li>
        </ol>
    </section>

    <section class="content">
        <div class="box box-info">
            <div class="box-header with-border">
                <button onclick="add_data()" class="btn btn-primary bold"><i class="fa fa-plus-circle"></i> Tambah Data</button>
            </div>
            <div class="box-body">
                <table id="StockInTable" class="table table-bordered table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>Cabang</th>
                            <th>Supplier</th>
                            <th>Nomor Dokumen</th>
                            <th>Tanggal Masuk</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($stockin->result() as $row) : ?>
                            <tr>
                                <td><?php echo $row->branch_name; ?></td>
                                <td><?php echo $row->supplier_name; ?></td>
                                <td><?php echo $row->doc_number; ?></td>
                                <td><?php echo date('Y-m-d', strtotime($row->stock_date)); ?></td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <button class="btn btn-sm btn-success bold" onclick="view_data(<?php echo $row->stock_in_id; ?>)"><i class="fa fa-file-text-o"></i></button>
                                        <!-- <button class="btn btn-sm btn-danger bold" onclick="delete_data(<?php echo $row->stock_in_id; ?>)"><i class="fa fa-ban"></i></button> -->
                                    </div>
                                    <!--php if($row->status == 0){ ?>
                                    &nbsp;
                                    <button class="btn btn-sm btn-warning bold" onclick="edit_data(<php echo $row->stock_in_id; ?>)"><i class="fa fa-pencil"></i></button>
                                        &nbsp;
                                    <button class="btn btn-sm btn-danger bold" onclick="delete_data(<php echo $row->stock_in_id; ?>)"><i class="fa fa-ban"></i></button>
                                <php } ?-->
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <div class="modal fade bd-example-modal-lg" id="modal_add" data-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" style="text-align:center;"><strong>Tambah Data Stock Masuk</strong></h4>
                </div>
                <form action="#" id="form" class="form-horizontal">
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Cabang <span class="text-danger">*</span></label>
                            <div class="col-sm-6">
                                <select class="form-control select2" id="branchid" name="branchid" style="width: 100%;" data-placeholder="Pilih Cabang" required>
                                    <option value=""></option>
                                    <?php foreach ($branch->result() as $row) : ?>
                                        <?php echo "<option value='" . $row->branch_id . "'>(" . $row->branch_code . ") " . $row->branch_name . "</option>"; ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Supplier <span class="text-danger">*</span></label>
                            <div class="col-sm-6">
                                <select class="form-control select2" id="supplierid" name="supplierid" style="width: 100%;" data-placeholder="Pilih Supplier" required>
                                    <option value=""></option>
                                    <?php foreach ($supplier->result() as $row) : ?>
                                        <?php echo "<option value='" . $row->supplier_id . "'>(" . $row->supplier_code . ") " . $row->supplier_name . "</option>"; ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Nomor Dokumen <span class="text-danger">*</span></label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="docnumber" name="docnumber" placeholder="Masukan Nomor Dokumen / Faktur / Invoice" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Tanggal Masuk <span class="text-danger">*</span></label>
                            <div class="col-sm-6">
                                <input type="date" class="form-control" id="stockdate" name="stockdate" required>
                            </div>
                        </div>
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
                                            <th style="width:70%">Jenis Barang</th>
                                            <th style="width:15%">Jumlah Barang</th>
                                            <th style="width:15%"></th>
                                        </tr>
                                    </thead>
                                    <tr>
                                        <td style="width:70%">
                                            <select class="form-control select2" id="itemid" name="itemid" style="width: 100%;" data-placeholder="Pilih Barang">
                                                <option value=""></option>
                                                <?php foreach ($item->result() as $row) : ?>
                                                    <?php echo "<option value='" . $row->item_id . "' data-rak='" . $row->keterangan . "'>(" . $row->barcode . ") " . $row->item_name . "</option>"; ?>
                                                <?php endforeach; ?>
                                            </select>
                                        </td>
                                        <td style="width:15%">
                                            <input type="number" class="form-control" id="qty" />
                                        </td>
                                        <td style="width:15%">
                                            <button type="button" class="form-control btn btn-info btn-flat" id="AddDetail">Tambah Data</button>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div id="detailview" class="row">
                            <div class="col-md-12">
                                <table class="table table-bordered table-striped">
                                    <thead class="bg-primary">
                                        <tr>
                                            <th style="width:70%">Jenis Barang</th>
                                            <th style="width:20%">Jumlah Barang</th>
                                            <th style="width:10%" class="text-center">
                                                <i class="fa fa-cog"></i>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody id="itemview"></tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <input type="hidden" id="total_item" name="total_item" value="0">
                        <button type="button" class="btn btn-success pull-left" data-dismiss="modal">Batal</button>
                        <button type="submit" id="btnSave" class="btn btn-danger pull-right">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade bd-example-modal-lg" id="modal_view" data-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" style="text-align:center;"><strong>View Data - <span id="v_judul"></span></strong></h4>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Cabang</th>
                                    <th id="v_cabang"></th>
                                </tr>
                                <tr>
                                    <th>Supplier</th>
                                    <th id="v_supplier"></th>
                                </tr>
                                <tr>
                                    <th>Nomor Dokumen</th>
                                    <th id="v_no_dokumen"></th>
                                </tr>
                                <tr>
                                    <th>Tanggal Masuk</th>
                                    <th id="v_tgl_masuk"></th>
                                </tr>
                                <tr>
                                    <th>Informasi</th>
                                    <th id="v_informasi"></th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <hr />
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="bg-primary">
                                <tr>
                                    <th>Jenis Barang</th>
                                    <th>Jumlah Barang</th>
                                </tr>
                            </thead>
                            <tbody id="v_body"></tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success pull-left" data-dismiss="modal">Batal</button>
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
        endDate: new Date()
    });

    $("#StockInTable").DataTable({
        dom: 'Bfrtip',
        lengthMenu: [
            [10, 25, 50, -1],
            ['10 rows', '25 rows', '50 rows', 'Show all']
        ],
        columnDefs: [{
            targets: [4],
            orderable: false
        }],
        buttons: [
            'pageLength',
            {
                extend: 'excelHtml5',
                title: 'Stok Masuk',
                exportOptions: {
                    columns: [0, 1, 2, 3]
                }
            },
            {
                extend: 'pdfHtml5',
                title: 'Stok Masuk',
                orientation: 'portrait',
                pageSize: 'A4',
                exportOptions: {
                    columns: [0, 1, 2, 3]
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

        $('#qty').val($(this).parent().parent().find('.itemQty').html());
    });

    $("tbody#itemadd").on("click", "#hapus", function() {
        var OrderItemDelete = $(this).parent().parent().find('#orderitem').val();
        $("#StockIn" + OrderItemDelete).remove();
    });

    $(document).ready(function() {
        let seq = 0;
        $('#AddDetail').click(function(e) {
            let itemid = $("#itemid option:selected").val();
            let itemname = $("#itemid option:selected").text();
            let itemdesc = $("#itemid option:selected").data('rak');
            let qty = $("#qty").val();
            let total_item = parseInt($("#total_item").val());

            if (itemid == '') {
                Swal.fire({
                    icon: 'warning',
                    title: "Peringatan",
                    text: "Mohon pilih Jenis Barang",
                })
            } else if (qty <= 0) {
                Swal.fire({
                    icon: 'warning',
                    title: "Peringatan",
                    text: "Mohon isi Jumlah Barang",
                })
            } else {
                seq += 1
                total_item += 1

                let html = `
                <tr id="group_${seq}">
                    <td>
                        ${itemname}<br/>
                        <em>${itemdesc}</em>
                    </td>
                    <td>${qty}</td>
                    <td class="text-center">
                        <input type="hidden" name="item_id[]" value="${itemid}" />
                        <input type="hidden" name="item_qty[]" value="${qty}" />
                        <button type="button" class="btn btn-danger btn-sm" onclick="hapus_item(${seq})">
                            <i class="fa fa-trash"></i>
                        </button>
                    </td>
                </tr>
                `
                console.log(html)

                $("#itemview").append(html)
                $('#itemid').val('').trigger('change')
                $('#qty').val(0)
                $('#total_item').val(total_item)
            }
        });

        $('#form').on('submit', e => {
            e.preventDefault()
            save_data()
        })

    });

    function hapus_item(seq) {
        $(`#group_${seq}`).remove()
    }

    function add_data() {
        $("#branchid").val('').trigger('change');
        $("#supplierid").val('').trigger('change');
        $("#itemid").val('').trigger('change');
        $("#itemadd").val('');
        $('#modal_add').modal('show');
        $("#itemview").html('')
    }

    function view_data(stockinid) {
        $.ajax({
            type: "POST",
            dataType: "JSON",
            url: "<?php echo site_url() ?>inventory/stock_in/ajax_view",
            data: {
                id: stockinid
            },
            success: function(data) {
                console.log(data)
                $('#v_judul').text(data.stockin.doc_number)
                $('#v_cabang').text(data.stockin.branch_name)
                $('#v_supplier').text(data.stockin.supplier_name)
                $('#v_no_dokumen').text(data.stockin.doc_number)
                $('#v_tgl_masuk').text(data.stockin.stock_date)
                $('#v_informasi').text(data.stockin.description)

                let htmlnya = "";
                $.each(data.stockindet, (i, k) => {
                    htmlnya += `
                    <tr>
                        <td>
                            ${k.item_name}<br/>
                            <em>${(k.keterangan == null) ? "" : k.keterangan}</em>
                        </td>
                        <td>${k.qty}</td>
                    </tr>
                    `
                })

                $('#v_body').html(htmlnya)
                $('#modal_view').modal('show')
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

    function edit_data(stockinid) {
        $('#formtype').val("edit");

        //Ajax Load data from ajax
        $.ajax({
            type: "POST",
            dataType: "JSON",
            url: "<?php echo site_url() ?>inventory/stock_in/ajax_view",
            data: {
                id: stockinid
            },
            success: function(data) {
                $('#stockinid').val(stockinid);
                $('#branchid').val(data.stockin.branch_id).change();
                $('#supplierid').val(data.stockin.supplier_id).change();
                $('#docnumber').val(data.stockin.doc_number);
                $('#datepicker').val(data.stockin.stock_date);
                //$('#status').val(data.stockin.status).change();
                $('#description').val(data.stockin.description);

                var noitem = 0;
                var html = '';
                var i;
                $.each(data.stockindet, function(i, item) {
                    noitem = i + noitem;
                    html += "<tr id='StockIn" + noitem + "'>" +
                        "<td style='width:70%' class='itemStockItem'>" + item.item_name + "</td>" +
                        "<td style='width:15%' class='itemQty'>" + item.qty + "</td>" +
                        "<td style='width:15%'>" +
                        "<input type='hidden' id='orderitem' name='orderitem' value='" + noitem + "'> " +
                        "<input type='hidden' id='itemStockItem" + noitem + "' name='item[itemStockItem][]' value='" + item.item_id + "'> " +
                        "<input type='hidden' id='itemQty" + noitem + "' name='item[itemQty][]' value='" + item.qty + "'> " +
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

                $('#branchid').attr('disabled', true); //set button disable 
                $('#supplierid').attr('disabled', true); //set button disable 
                $('#docnumber').attr('disabled', true); //set button disable 
                $('#datepicker').attr('disabled', true); //set button disable 
                //$('#status').attr('disabled',false); //set button disable 
                $('#description').attr('disabled', false); //set button disable 

                $('#FormModal').modal('show'); // show bootstrap modal
                $('.modal-title').text('Lihat Data Stok Masuk'); // Set Title to Bootstrap modal title
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
        let isSafe = false;
        let total_item = $('#total_item').val();
        if (total_item == 0) {
            Swal.fire({
                icon: 'warning',
                title: "Peringatan",
                text: "Silahkan pilih jenis barang terlebih dahulu",
            })
        } else {
            isSafe = true;
        }

        if (isSafe === true) {
            // ajax adding data to database
            $.ajax({
                url: "<?php echo site_url() ?>inventory/stock_in/ajax_add",
                type: "POST",
                data: $('#form').serialize(),
                dataType: "JSON",
                beforeSend: () => {
                    $('#btnSave').text('saving...');
                    $('#btnSave').attr('disabled', true);
                },
                success: function(data) {
                    console.log(data);
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
                    url: "<?php echo site_url() ?>inventory/stock_in/ajax_delete",
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