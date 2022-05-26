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

    <form id="frmSales" class="form">

        <section class="content">
            <div id="sales_form" class="box box-solid">
                <div class="box-header with-border">
                    <button type="button" class="btn bg-navy btn-flat btn-lg" id="CheckStockButton">Cek Stok Barang</button>
                    <button type="button" class="btn bg-navy btn-flat btn-lg" id="CancelButton">Batal</button>
                    <button type="button" class="btn bg-navy btn-flat btn-lg pull-right" id="PaymentButton">Simpan</button>
                </div>
                <div class="box-body">
                    <div class="row">
                        <input type="hidden" class="form-control" id="totaltrans" name="totaltrans" value="0">
                        <input type="hidden" class="form-control" id="totalqty" name="totalqty" value="0">
                        <input type="hidden" class="form-control" id="payment" name="payment" value="0">
                        <input type="hidden" class="form-control" id="noitem" name="noitem" value="0">
                        <input type="hidden" class="form-control" id="salesexchangelimit" name="salesexchangelimit" value="0">
                        <input type="hidden" class="form-control" id="datediff" name="datediff" value="0">
                        <input type="hidden" class="form-control" id="cashierid" name="cashierid" value="">

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">No. Nota Tukar Barang</label>
                                <input type="text" class="form-control" id="salesexchangenumber" name="salesexchangenumber" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Tanggal Tukar Barang</label>
                                <input type="text" class="form-control" id="salesexchangedate" name="salesexchangedate" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Nomor Penjualan</label>
                                <input type="text" class="form-control" id="salesnumbersearch" name="salesnumbersearch">
                            </div>
                        </div>
                    </div>
                    <div id="showData">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Cabang</label>
                                    <input type="text" class="form-control" id="branch" name="branch" readonly>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Nomor Penjualan</label>
                                    <input type="text" class="form-control" id="salesnumber" name="salesnumber" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Tanggal Penjualan</label>
                                    <input type="text" class="form-control" id="salesdate" name="salesdate" readonly>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Nama Kasir</label>
                                    <input type="text" class="form-control" id="cashier" name="cashier" readonly>
                                </div>
                            </div>
                            <!--div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label">Total Harga</label>
                        <input type="text" class="form-control" id="totalprice" name="totalprice" readonly>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Total Diskon</label>
                        <input type="text" class="form-control" id="totaldisc" name="totaldisc" readonly>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Total Penjualan</label>
                        <input type="text" class="form-control" id="totaltransaction" name="totaltransaction" readonly>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Jenis Pembayaran</label>
                        <input type="text" class="form-control" id="paymenttype" name="paymenttype" readonly>
                    </div>
				</div-->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Catatan</label>
                                    <textarea style="width:100%" rows="5" id="description" name="description"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="direct-chat-messages">
                                    <table class="table">
                                        <thead>
                                            <tr style="font-weight:bold">
                                                <td style="width:30%">Barang Pembelian</td>
                                                <td style="width:5%; text-align:right">Harga</td>
                                                <td style="width:5%; text-align:center">Jml Beli</td>
                                                <td style="width:5%; text-align:right">Diskon</td>
                                                <td style="width:5%; text-align:center">Telah Tukar</td>
                                                <td style="width:30%">Barang Tukar</td>
                                                <td style="width:5%; text-align:center">Jml Tukar</td>
                                                <td style="width:5%; text-align:right">Tambah Bayar</td>
                                                <td style="width:10%; text-align:center">Action</td>
                                            </tr>
                                        </thead>
                                        <tbody id="itemlist">

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="loading_sign_form" class="overlay">
                    <i class="fa fa-refresh fa-spin"></i>
                </div>
            </div>
        </section>
    </form>

    <div class="modal fade" id="EditModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" style="text-align:center;"><strong>Set Tukar Barang</strong></h4>
                </div>
                <form class="form-horizontal">
                    <div class="modal-body">
                        <input type="hidden" class="form-control" id="orderitemmodal" name="orderitemmodal" value="0">
                        <input type="hidden" class="form-control" id="itemexchangeprice" name="itemexchangeprice" value="0">
                        <input type="hidden" class="form-control" id="buyingprice" name="buyingprice" value="0">

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Barang Pembelian</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="itembuying" name="itembuying" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Harga Beli Satuan</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="strbuyingprice" name="strbuyingprice" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Jumlah Pembelian</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="buyingqty" name="buyingqty" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Telah Tukar</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="qtyexchange" name="qtyexchange" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Barang Tukar</label>
                            <div class="col-sm-9">
                                <select class="form-control select2" id="itemexchange" name="itemexchange" style="width: 100%;">
                                    <option value='0' selected>Silahkan Pilih</option>
                                    <?php foreach ($itemexchange->result() as $row) : ?>
                                        <?php echo "<option value='" . $row->item_id . "'>(" . $row->barcode . ") " . $row->item_name . "</option>"; ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Jumlah Stok</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="stockqty" name="stockqty" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Jumlah Tukar</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="exchangeqty" name="exchangeqty" value="0">
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success pull-left" data-dismiss="modal">Batal</button>
                        <button type="button" id="btnChange" class="btn btn-danger pull-right">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="PaymentModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" style="text-align:center;"><strong>Pembayaran</strong></h4>
                </div>
                <form class="form-horizontal">
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Nomor Nota</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="nomornota" name="nomornota" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Tanggal</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="tanggalnota" name="tanggalnota" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Total Tambah Bayar</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="total" name="total" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Pembayaran</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="modalpayment" name="modalpayment" value="0">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success pull-left" data-dismiss="modal">Batal</button>
                        <button type="button" id="btnSave" class="btn btn-danger pull-right">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade bd-example-modal-lg" id="CheckStockModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" style="text-align:center;"><strong>Cek Stok Barang</strong></h4>
                </div>
                <form action="#" id="form" class="form-horizontal">
                    <div class="modal-body">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Jenis Barang</label>
                                <select class="form-control select2" id="searchstockitemid" name="searchstockitemid" style="width: 100%;">
                                    <option value='0' selected>Silahkan Pilih</option>
                                    <?php foreach ($item->result() as $row) : ?>
                                        <?php echo "<option value='" . $row->item_id . "'>(" . $row->barcode . ") " . $row->item_name . "</option>"; ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <button type="button" class="btn btn-success" data-dismiss="modal">Kembali</button>
                                <button type="button" id="btnSearchStock" class="btn btn-danger">Cari</button>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th style="width:80%">Cabang</th>
                                            <th style="width:20%">Jumlah</th>
                                        </tr>
                                    </thead>
                                    <tbody id="itemSearchStock"></tbody>
                                </table>
                            </div>
                        </div>

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

    $("tbody#itemlist").on("click", "#edit", function() {
        var noitem = $(this).parent().parent().find('#orderitem').val();
        $('#orderitemmodal').val($(this).parent().parent().find('#orderitem').val());

        $('#itembuying').val($(this).parent().parent().find('.itemBuyingItem').html());
        $('#buyingprice').val($(this).parent().parent().find('#itemBuyingPrice' + noitem).val());
        $('#buyingqty').val($(this).parent().parent().find('.itemBuyingQty').html());
        $('#qtyexchange').val($(this).parent().parent().find('.itemQtyExchange').html());
        $('#strbuyingprice').val($(this).parent().parent().find('.itemBuyingPrice').html());

        $('#EditModal').modal('show');
    });

    $("tbody#itemlist").on("click", "#hapus", function() {
        var OrderItemDelete = $(this).parent().parent().find('#orderitem').val();
        //$("#SalesExchange"+OrderItemDelete).remove();

        $("#SalesExchange" + OrderItemDelete + " td.itemExchangeItem").html('');
        $("#itemExchangeItem" + OrderItemDelete).val(0);

        $("#itemStockQty" + OrderItemDelete).val(0);

        $("#SalesExchange" + OrderItemDelete + " td.itemExchangeQty").html('');
        $("#itemExchangeQty" + OrderItemDelete).val(0);

        $("#SalesExchange" + OrderItemDelete + " td.itemExtraPayment").html('');
        $("#itemExtraPayment" + OrderItemDelete).val(0);
    });

    $(document).ready(function() {
        prepare_page();

        $("#logincode").on('keydown', function(e) {
            var logincode = $('#logincode').val();
            logincode = logincode.trim();
            if ((e.keyCode == 9) || (e.keyCode == 13)) {
                if ((logincode != "") && (logincode.length >= 0)) {
                    validate_logincode();
                }
            }
        });

        $('#CheckStockButton').click(function(e) {
            $('#CheckStockModal').modal('show');
        });

        $('#btnSearchStock').click(function() {
            search_stock();
        });

        $('#CancelButton').click(function(e) {
            location.reload();
        });

        $("#salesnumbersearch").on('keydown', function(e) {
            var salesnumbersearch = $('#salesnumbersearch').val();
            salesnumbersearch = salesnumbersearch.trim();
            if ((e.keyCode == 9) || (e.keyCode == 13)) {
                if ((salesnumbersearch != "") && (salesnumbersearch.length >= 0)) {
                    get_sales_data();
                }
            }
        });

        $("#itemexchange").change(function() {
            get_qty_available();
        });

        $('#btnChange').click(function(e) {

            var noitem = $("#orderitemmodal").val();
            var itemexchangeprice = $("#itemexchangeprice").val();
            var buyingprice = $("#buyingprice").val();

            var itemexchangeid = $("#itemexchange option:selected").val();
            var itemexchangename = $("#itemexchange option:selected").text();

            var qtyexchange = parseInt($("#qtyexchange").val());
            var stockqty = parseInt($("#stockqty").val());
            var buyingqty = parseInt($("#buyingqty").val());
            var exchangeqty = parseInt($("#exchangeqty").val());

            if (itemexchangeid == '') {
                Swal.fire({
                    icon: 'warning',
                    title: "Peringatan",
                    text: "Mohon pilih Barang Tukar",
                })
            } else if (exchangeqty <= 0) {
                Swal.fire({
                    icon: 'warning',
                    title: "Peringatan",
                    text: "Mohon isi Jumlah Barang yang ditukar",
                })
            } else if (exchangeqty > stockqty) {
                Swal.fire({
                    icon: 'warning',
                    title: "Peringatan",
                    text: "Jumlah Barang yang ditukar tidak boleh melebihi Jumlah Stok",
                })
            } else if (exchangeqty > (buyingqty - qtyexchange)) {
                Swal.fire({
                    icon: 'warning',
                    title: "Peringatan",
                    text: "Jumlah Barang yang ditukar tidak boleh melebihi Jumlah Barang yang dibeli",
                })
            } else {
                totalbuying = exchangeqty * buyingprice;
                totalexchange = exchangeqty * itemexchangeprice;
                extrapayment = totalexchange - totalbuying;
                if (extrapayment < 0) {
                    extrapayment = 0;
                }

                var totaltrans = $('#totaltrans').val();
                totaltrans = parseFloat(totaltrans) + parseFloat(extrapayment);
                $('#totaltrans').val(totaltrans);

                var totalqty = parseInt($('#totalqty').val());
                totalqty = totalqty + exchangeqty;
                $('#totalqty').val(totalqty);

                $("#SalesExchange" + noitem + " td.itemExchangeItem").html(itemexchangename);
                $("#itemExchangeItem" + noitem).val(itemexchangeid);

                $("#SalesExchange" + noitem + " td.itemStockQty").html(stockqty);
                $("#itemStockQty" + noitem).val(stockqty);

                $("#SalesExchange" + noitem + " td.itemExchangeQty").html(exchangeqty);
                $("#itemExchangeQty" + noitem).val(exchangeqty);

                $("#SalesExchange" + noitem + " td.itemExtraPayment").html(thousandmaker(extrapayment));
                $("#itemExtraPayment" + noitem).val(extrapayment);

                $('#orderitemmodal').val(0);
                $('#itemexchangeprice').val(0);
                $('#itembuying').val('');
                $('#buyingqty').val(0);
                $('#qtyexchange').val(0);
                $('#buyingprice').val(0);
                $('#buyingprice').val(0);
                $('#itemexchange').val(0).change();
                $('#stockqty').val(0);
                $('#exchangeqty').val(0);

                $('#EditModal').modal('hide');
            }
        });

        $('#PaymentButton').click(function(e) {
            var tottrans = $("#totaltrans").val();
            $("#total").val(thousandmaker(tottrans));

            var totalqty = $("#totalqty").val();
            if (totalqty > 0) {
                $('#PaymentModal').modal('show');
            }
        });

        $('#btnSave').click(function() {
            var frm = $('#frmSales');
            var tottrans = $("#totaltrans").val();
            var modalpayment = $('#modalpayment').val();
            var salesexchangenumber = $('#salesexchangenumber').val();

            $('#PaymentModal').modal('hide');

            if (parseFloat(tottrans) > parseFloat(modalpayment)) {
                Swal.fire({
                    icon: 'warning',
                    title: "Peringatan",
                    text: "Pembayaran kurang dari Total Tambah Bayar",
                })
            } else {
                $('#loading_sign_form').show();
                $('#payment').val(modalpayment);

                $.ajax({
                    type: 'POST',
                    url: '<?php echo site_url() ?>sales/sales_exchange/create_post',
                    dataType: 'JSON',
                    data: frm.serialize(),
                    success: function(data) {
                        console.log(data);
                        if (data != "-1") {
                            var win = window.open('<?php echo site_url() ?>sales/sales_exchange/get_print/' + salesexchangenumber, '_blank');
                            if (win) {
                                //Browser has allowed it to be opened
                                win.focus();
                            } else {
                                //Browser has blocked it
                                alert('Please allow popups for this website');
                            }
                            location.reload();
                        } else {
                            Swal.fire({
                                icon: 'warning',
                                title: "Peringatan",
                                text: "Gagal menyimpan data transaksi penjualan",
                            })
                        }
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'warning',
                            title: "Peringatan",
                            text: "Gagal menyimpan data transaksi penjualan",
                        })
                    }
                });

                $('#loading_sign_form').hide();
            }
        });
    });

    function prepare_page() {
        $('#loading_sign_form').show();
        var logincode = $('#logincode').val();
        $.ajax({
            type: 'POST',
            dataType: 'JSON',
            url: '<?php echo site_url() ?>sales/sales_exchange/validate_logincode',
            success: function(data) {
                var userid = Number(data.userid);
                if (userid > 0) {
                    $('#cashierid').val(userid);

                    $('#salesexchangenumber').val(data.transnumber);
                    $('#salesexchangedate').val(data.transdate);

                    $('#nomornota').val(data.transnumber);
                    $('#tanggalnota').val(data.transdate);

                    $("#CheckStockButton").prop('disabled', false);
                    $("#CancelButton").prop('disabled', false);
                    $("#PaymentButton").prop('disabled', false);

                    $('#sales_form').show();
                    $('#login_form').hide();

                    $("#salesnumbersearch").val("");
                    $("#salesnumbersearch").focus();
                } else {
                    Swal.fire({
                        icon: 'warning',
                        title: "Peringatan",
                        text: "Nametag Barcode yang diinput tidak terdaftar pada sistem",
                    })
                }
            },
        });
        $('#loading_sign_form').hide();
    }

    function get_sales_data() {
        var salesnumbersearch = $("#salesnumbersearch").val();

        if (salesnumbersearch.length > 0) {
            $.ajax({
                type: "POST",
                dataType: "JSON",
                url: "<?php echo site_url() ?>sales/sales_exchange/get_sales_data",
                data: {
                    salesnumber: salesnumbersearch
                },
                success: function(data) {
                    var salesexchangelimit = data.sales.sales_exchange_limit;
                    var datediff = data.sales.date_diff;

                    $('#branch').val(data.sales.branch_name);
                    $('#salesnumber').val(data.sales.sales_number);
                    $('#salesdate').val(data.sales.created_date);
                    $('#paymenttype').val(data.sales.str_payment_type);
                    $('#cashier').val(data.sales.fullname);
                    $('#salesexchangelimit').val(salesexchangelimit);

                    $('#totalprice').val(thousandmaker(parseFloat(data.sales.total_price)));
                    $('#totaldisc').val(thousandmaker(parseFloat(data.sales.total_disc)));
                    $('#totaltransaction').val(thousandmaker(parseFloat(data.sales.total_transaction)));
                    $('#salespayment').val(thousandmaker(parseFloat(data.sales.payment)));
                    $('#exchange').val(thousandmaker(parseFloat(data.sales.exchange)));

                    var noitem = 1;
                    var html = '';
                    var i;
                    $.each(data.sales_det, function(i, item) {
                        noitem = i + noitem;
                        html += "<tr id='SalesExchange" + noitem + "'>" +
                            "<td style='width:30%' class='itemBuyingItem'>" + item.item_name + "</td>" +
                            "<td style='width:5%; text-align:right;' class='itemBuyingPrice'>" + thousandmaker(parseFloat(item.price)) + "</td>" +
                            "<td style='width:5%; text-align:center;' class='itemBuyingQty'>" + item.qty + "</td>" +
                            "<td style='width:5%; text-align:right;' class='itemBuyingDisc'>" + thousandmaker(parseFloat(item.extra_disc)) + "</td>" +
                            "<td style='width:5%; text-align:center;' class='itemQtyExchange'>" + item.qty_exchange + "</td>" +
                            "<td style='width:30%' class='itemExchangeItem'></td>" +
                            "<td style='width:5%; text-align:center;' class='itemExchangeQty'></td>" +
                            "<td style='width:5%; text-align:right;' class='itemExtraPayment'></td>" +
                            "<td style='width:10%; text-align:center;'>";

                        if ((parseInt(datediff) <= parseInt(salesexchangelimit)) && (parseInt(item.qty_exchange) < parseInt(item.qty))) {
                            html += "<input type='hidden' id='orderitem' name='orderitem' value='" + noitem + "'> " +
                                "<input type='hidden' id='itemSalesDetId" + noitem + "' name='item[itemSalesDetId][]' value='" + item.sales_det_id + "'> " +
                                "<input type='hidden' id='itemBuyingItemId" + noitem + "' name='item[itemBuyingItemId][]' value='" + item.item_id + "'> " +
                                "<input type='hidden' id='itemBuyingPrice" + noitem + "' name='item[itemBuyingPrice][]' value='" + parseFloat(item.price) + "'> " +
                                "<input type='hidden' id='itemBuyingQty" + noitem + "' name='item[itemBuyingQty][]' value='" + item.qty + "'> " +
                                "<input type='hidden' id='itemBuyingDisc" + noitem + "' name='item[itemBuyingDisc][]' value='" + parseFloat(item.extra_disc) + "'> " +
                                "<input type='hidden' id='itemQtyExchange" + noitem + "' name='item[itemQtyExchange][]' value='" + item.qty_exchange + "'> " +
                                "<input type='hidden' id='itemExchangeItem" + noitem + "' name='item[itemExchangeItem][]' value='0'> " +
                                "<input type='hidden' id='itemStockQty" + noitem + "' name='item[itemStockQty][]' value='0'> " +
                                "<input type='hidden' id='itemExchangeQty" + noitem + "' name='item[itemExchangeQty][]' value='0'> " +
                                "<input type='hidden' id='itemExtraPayment" + noitem + "' name='item[itemExtraPayment][]' value='0'> " +
                                "<button type='button' class='btn btn-sm btn-white' id='edit'><i class='fa fa-pencil'></i></button> <button type='button' class='btn btn-sm btn-white' id='hapus'><i class='fa fa-trash'></i></button> ";
                        }

                        html += "</td>" +
                            "</tr>";
                    });
                    $("#itemlist").empty();
                    $("#itemlist").append(html);

                    $('#showData').show();

                    if (parseInt(datediff) <= parseInt(salesexchangelimit)) {
                        $('#PaymentButton').attr('disabled', false);
                    } else {
                        $('#PaymentButton').attr('disabled', true);
                        Swal.fire({
                            icon: 'warning',
                            title: "Peringatan",
                            text: "Tanggal Pembelian sudah melewati batas waktu penukaran barang",
                        })
                    }

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
    }

    function get_qty_available() {
        var itemexchange = $("#itemexchange option:selected").val();

        if (itemexchange > 0) {
            $.ajax({
                type: "POST",
                dataType: "JSON",
                url: "<?php echo site_url() ?>sales/sales_exchange/get_qty_available",
                data: {
                    itemexchange: itemexchange
                },
                success: function(data) {
                    if (data.qty.qty_available > 0) {
                        $('#stockqty').val(data.qty.qty_available);
                        $('#itemexchangeprice').val(data.price.selling_price);
                        $('#exchangeqty').attr('disabled', false); //set button disable 
                    } else {
                        $('#stockqty').val(data.qty.qty_available);
                        $('#exchangeqty').val(data.qty.qty_available);
                        $('#itemexchangeprice').val(data.price.selling_price);
                        $('#exchangeqty').attr('disabled', true); //set button disable 
                    }
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
    };

    function search_stock() {
        var itemid = $("#searchstockitemid option:selected").val();
        $.ajax({
            type: 'POST',
            dataType: 'JSON',
            url: '<?php echo site_url() ?>sales/sales/search_stock',
            data: {
                itemid: itemid
            },
            success: function(data) {
                var html = '';
                $.each(data, function(i, item) {
                    html += "<tr>" +
                        "<td style='width:80%' class='itemStockItem'>" + item.branch_name + "</td>" +
                        "<td style='width:20%' class='itemQty'>" + item.qty + "</td>" +
                        "</tr>";
                });
                $("#itemSearchStock").empty();
                $("#itemSearchStock").append(html);

            },
            error: function(data) {}
        });
    }

    function thousandmaker(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }
</script>
<?php
$this->load->view('template/footer');
?>