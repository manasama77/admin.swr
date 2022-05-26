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
            Stok Keluar
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Inventory</a></li>
            <li class="active">Stok Keluar</li>
        </ol>
    </section>

    <section class="content">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">List Data</h3>
            </div>
            <div class="box-body">
                <table id="StockOutTable" class="table table-bordered table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>Cabang</th>
                            <th>Doc Number</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($stockout->result() as $row) : ?>
                            <tr>
                                <td><?php echo $row->branch_name; ?></td>
                                <td><?php echo $row->doc_number; ?></td>
                                <td><?php echo date('d M Y H:i:s', strtotime($row->stock_date)); ?></td>
                                <td><?php echo $row->strstatus; ?></td>
                                <td>
                                    <button class="btn btn-sm btn-success bold" onclick="view_data(<?php echo $row->stock_out_id; ?>)"><i class="fa fa-file-text-o"></i></button>
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
                        <input type="hidden" id="stockinid" name="stockoutid" value="0">

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
                            <label class="col-sm-4 control-label">Nomor Dokumen</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="docnumber" name="docnumber">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Tanggal Keluar</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="stockdate" name="stockdate">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Status</label>
                            <div class="col-sm-6">
                                <select class="form-control select2" id="status" name="status" style="width: 100%;">
                                    <option value='0' selected>Draft</option>
                                    <option value='1'>Final</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Informasi</label>
                            <div class="col-sm-6">
                                <textarea style="width:100%" rows="4" id="description" name="description">
                            </textarea>
                            </div>
                        </div>

                        <div id="detailview" class="row">
                            <div class="col-md-12">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th style="width:85%">Jenis Barang</th>
                                            <th style="width:15%">Jumlah</th>
                                        </tr>
                                    </thead>
                                    <tbody id="itemview"></tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success pull-left" data-dismiss="modal">Keluar</button>
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
    $("#StockOutTable").DataTable({
        dom: 'Bfrtip',
        lengthMenu: [
            [10, 25, 50, -1],
            ['10 rows', '25 rows', '50 rows', 'Show all']
        ],
        buttons: [
            'pageLength',
            {
                extend: 'excelHtml5',
                title: 'Stok Keluar',
                exportOptions: {
                    columns: [0, 1, 2, 3]
                }
            },
            {
                extend: 'pdfHtml5',
                title: 'Stok Keluar',
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

    function view_data(stockoutid) {
        $('#formtype').val("view");

        //Ajax Load data from ajax
        $.ajax({
            type: "POST",
            dataType: "JSON",
            url: "<?php echo site_url() ?>inventory/stock_out/ajax_view",
            data: {
                id: stockoutid
            },
            success: function(data) {
                $('#stockoutid').val(stockoutid);
                $('#branchid').val(data.stockout.branch_id).change();
                $('#docnumber').val(data.stockout.doc_number);
                $('#stockdate').val(data.stockout.stock_date);
                $('#status').val(data.stockout.status).change();
                $('#description').val(data.stockout.description);

                var noitem = 0;
                var html = '';
                var i;
                $.each(data.stockoutdet, function(i, item) {
                    noitem = i + noitem;
                    html += "<tr id='StockOut" + noitem + "'>" +
                        "<td style='width:85%' class='itemStockItem'>" + item.item_name + "</td>" +
                        "<td style='width:15%' class='itemQty'>" + item.qty + "</td>" +
                        "</tr>";
                });
                $("#itemview").empty();
                $("#itemview").append(html);
                $('#noitem').val(noitem);

                $('#branchid').attr('disabled', true); //set button disable 
                $('#docnumber').attr('disabled', true); //set button disable 
                $('#stockdate').attr('disabled', true); //set button disable 
                $('#status').attr('disabled', true); //set button disable 
                $('#description').attr('disabled', true); //set button disable 

                $('#FormModal').modal('show'); // show bootstrap modal
                $('.modal-title').text('Lihat Data Stok Keluar'); // Set Title to Bootstrap modal title
            },
            error: function(data) {
                Swal.fire({
                    icon: 'warning',
                    title: "Peringatan",
                    text: "Gagal Memproses Data",
                })
            }
        });
    }
</script>
<?php
$this->load->view('template/footer');
?>