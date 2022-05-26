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
            Riwayat Penjualan
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Transaction</a></li>
            <li class="active">Riwayat Penjualan</li>
        </ol>
    </section>

    <section class="content">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">List Data</h3>
            </div>
            <div class="box-body">
                <table id="SalesHistTable" class="table table-bordered table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>Cabang</th>
                            <th>Kasir</th>
                            <th>Nomor Penjualan</th>
                            <th>Tanggal Penjualan</th>
                            <th>Total Harga</th>
                            <th>Total Disc</th>
                            <th>Total Penjualan</th>
                            <th>Jenis Pembayaran</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($saleshist->result() as $row) : ?>
                            <tr>
                                <td><?php echo $row->branch_name; ?></td>
                                <td><?php echo $row->cashier_name; ?></td>
                                <td><?php echo $row->sales_number; ?></td>
                                <td><?php echo $row->sales_date; ?></td>
                                <td><?php echo number_format($row->total_price, 0, ",", "."); ?></td>
                                <td><?php echo number_format($row->total_disc, 0, ",", "."); ?></td>
                                <td><?php echo number_format($row->total_transaction, 0, ",", "."); ?></td>
                                <td><?php echo $row->payment_type; ?></td>
                                <td>
                                    <button class="btn btn-sm btn-success bold" onclick="view_data('<?php echo $row->sales_number; ?>')"><i class="fa fa-file-text-o"></i></button>
                                    &nbsp;
                                    <button class="btn btn-sm btn-danger bold" onclick="print_data('<?php echo $row->sales_number; ?>')"><i class="fa fa-print"></i></button>
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
                <form action="#" id="form" class="form">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Cabang</label>
                                    <input type="text" class="form-control" id="branch" name="branch" readonly>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Nama Kasir</label>
                                    <input type="text" class="form-control" id="cashier" name="cashier" readonly>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">No Nota</label>
                                    <input type="text" class="form-control" id="salesnumber" name="salesnumber" readonly>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Tanggal Penjualan</label>
                                    <input type="text" class="form-control" id="salesdate" name="salesdate" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Total Harga</label>
                                    <input type="text" class="form-control" id="totalprice" name="totalprice" readonly>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Total Disc</label>
                                    <input type="text" class="form-control" id="totaldisc" name="totaldisc" readonly>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Total Pembelian</label>
                                    <input type="text" class="form-control" id="totaltransaction" name="totaltransaction" readonly>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Pembayaran</label>
                                    <input type="text" class="form-control" id="payment" name="payment" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Jenis Pembayaran</label>
                                    <input type="text" class="form-control" id="paymenttype" name="paymenttype" readonly>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Bank</label>
                                    <input type="text" class="form-control" id="bank" name="bank" readonly>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Nama Pemegang Kartu</label>
                                    <input type="text" class="form-control" id="cardholder" name="cardholder" readonly>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Nomor Kartu</label>
                                    <input type="text" class="form-control" id="cardnumber" name="cardnumber" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <textarea style="width:100%" rows="4" id="notes" name="notes"></textarea>
                            </div>
                        </div>
                        <!--div class="form-group">
                        <label class="col-sm-4 control-label">Kembalian</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="exchange" name="exchange" readonly>
                        </div>
                    </div-->

                        <div id="detailview" class="row">
                            <div class="col-md-12">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th style="width:5%">No</th>
                                            <th style="width:55%">Jenis Barang</th>
                                            <th style="width:10%; text-align:right">Harga</th>
                                            <th style="width:10%; text-align:right">Jumlah</th>
                                            <th style="width:10%; text-align:right">Diskon</th>
                                            <th style="width:10%; text-align:right">Total</th>
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
    $("#SalesHistTable").DataTable({
        dom: 'Bfrtip',
        lengthMenu: [
            [10, 25, 50, -1],
            ['10 rows', '25 rows', '50 rows', 'Show all']
        ],
        buttons: [
            'pageLength',
            {
                extend: 'excelHtml5',
                title: 'Riwayat Penjualan',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7]
                }
            },
            {
                extend: 'pdfHtml5',
                title: 'Riwayat Penjualan',
                orientation: 'portrait',
                pageSize: 'A4',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7]
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
    });

    function get_export() {
        var win = window.open('<?php echo site_url() ?>sales/sales_hist/get_export', '_blank');
        if (win) {
            win.focus();
        } else {
            $("#WarningContent").replaceWith("<div id='WarningContent'>Please allow popups for this website</div>");
            $('#WarningModal').modal('show');
        }
    }

    $(function() {
        $('#btnClose').click(function(e) {
            $('#WarningModal').modal('hide');
            location.reload();
        });
    });

    function view_data(salesnumber) {
        //Ajax Load data from ajax
        $.ajax({
            type: "POST",
            dataType: "JSON",
            url: "<?php echo site_url() ?>sales/sales_hist/ajax_view",
            data: {
                salesnumber: salesnumber
            },
            success: function(data) {
                console.log(data);
                $('#branch').val(data.sales.branch_name);
                $('#cashier').val(data.sales.cashier);
                $('#salesnumber').val(data.sales.sales_number);
                $('#salesdate').val(data.sales.sales_date);
                $('#totalprice').val(thousandmaker(parseFloat(data.sales.total_price)));
                $('#totaldisc').val(thousandmaker(parseFloat(data.sales.total_disc)));
                $('#totaltransaction').val(thousandmaker(parseFloat(data.sales.total_transaction)));
                $('#paymenttype').val(data.sales.payment_type);
                $('#bank').val(data.sales.bank);
                $('#cardholder').val(data.sales.card_holder);
                $('#cardnumber').val(data.sales.card_number);
                $('#payment').val(thousandmaker(parseFloat(data.sales.payment)));
                $('#exchange').val(thousandmaker(parseFloat(data.sales.exchange)));
                $('#notes').val(data.sales.notes);

                var html = '';
                var ii = 1;
                $.each(data.salesdet, function(i, item) {
                    html += "<tr>" +
                        "<td style='width:5%' class='itemQty'>" + ii + "</td>" +
                        "<td style='width:55%' class='itemStockItem'>" + item.item_name + "</td>" +
                        "<td style='width:10%; text-align:right' class='itemQty'>" + thousandmaker(item.price) + "</td>" +
                        "<td style='width:10%; text-align:right' class='itemQty'>" + item.qty + "</td>" +
                        "<td style='width:10%; text-align:right' class='itemQty'>" + thousandmaker(item.extra_disc) + "</td>" +
                        "<td style='width:10%; text-align:right' class='itemQty'>" + thousandmaker(item.subtotal) + "</td>" +
                        "</tr>";
                    ii++;
                });
                $("#itemview").empty();
                $("#itemview").append(html);

                $('#FormModal').modal('show'); // show bootstrap modal
                $('.modal-title').text('Lihat Data Riwayat Penjualan'); // Set Title to Bootstrap modal title
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

    function print_data(salesnumber) {
        var win = window.open('<?php echo site_url() ?>sales/sales/get_print/' + salesnumber, '_blank');
        if (win) {
            //Browser has allowed it to be opened
            win.focus();
        } else {
            //Browser has blocked it
            alert('Please allow popups for this website');
        }
    }

    function thousandmaker(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }
</script>
<?php
$this->load->view('template/footer');
?>