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

    <section class="content-header">
        <h1>
            Keuntungan Penjualan
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Laporan</a></li>
            <li class="active">Keuntungan Penjualan</li>
        </ol>
    </section>

    <form class="form">
        <section class="content">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Lihat Laporan</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <br>
                            <div class="form-group">
                                <label>Awal Periode</label>
                                <input type="date" class="form-control" id="datepicker" name="startperiod" autocomplete="off">
                            </div>
                            <br>
                            <div class="form-group">
                                <label>Akhir Periode</label>
                                <input type="date" class="form-control" id="datepicker2" name="endperiod" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <br>
                            <div class="form-group">
                                <label>Cabang</label>
                                <select class="form-control select2" id="branchid" name="branchid" style="width: 100%;">
                                    <?php foreach ($branch->result() as $row) : ?>
                                        <?php echo "<option value='" . $row->branch_id . "'>(" . $row->branch_code . ") " . $row->branch_name . "</option>"; ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <br>
                            <div class="form-group">
                                <label>Jenis Barang</label>
                                <select class="form-control select2" id="itemid" name="itemid" style="width: 100%;">
                                    <option value='0'>Semua Barang</option>
                                    <?php foreach ($item->result() as $row) : ?>
                                        <?php echo "<option value='" . $row->item_id . "'>(" . $row->barcode . ") " . $row->item_name . "</option>"; ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <br />
                    <div class="row">
                        <div class="col-md-12">
                            <button class="btn btn-info" id="GenerateButton">Preview Report</button>
                            <button class="btn btn-info" id="PrintButton">Print Report</button>
                            <button class="btn btn-info" id="ExcelButton">Export to Excel</button>
                            <!--button class="btn btn-info" id="PdfButton">Export to PDF</button-->
                        </div>
                    </div>
                    <br />
                    <div id="mydata" style="display:none" class="row">
                        <div class="col-md-12 table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr style="background-color:#99c0ff; color:white;">
                                        <th style="width:15%; text-align:center;">Tgl Transaksi</th>
                                        <th style="width:10%; text-align:center;">No Transaksi</th>
                                        <th style="width:35%; text-align:center;">Barang</th>
                                        <th style="width:10%; text-align:center;">Jumlah</th>
                                        <th style="width:10%; text-align:center;">Harga Modal</th>
                                        <th style="width:10%; text-align:center;">Harga Jual</th>
                                        <th style="width:10%; text-align:center;">Keuntungan</th>
                                        <!-- <th style="width:10%; text-align:center;">Pajak</th> -->
                                    </tr>
                                </thead>
                                <tbody id="show_data">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </form>

</div>

<?php
$this->load->view('template/js');
?>
<script type="text/javascript">
    //Initialize Select2 Elements
    $(".select2").select2();

    //Date picker
    // $('#datepicker').datepicker({
    //     autoclose: true
    // });

    //Date picker
    // $('#datepicker2').datepicker({
    //     autoclose: true
    // });

    $(document).ready(function() {
        $('#GenerateButton').click(function(e) {
            e.preventDefault();
            get_report();
        });

        $('#PrintButton').click(function(e) {
            get_print();
        });

        $('#ExcelButton').click(function(e) {
            get_excel();
        });

        $('#PdfButton').click(function(e) {
            get_pdf();
        });
    });

    function get_report() {
        var startperiod = $('#datepicker').val();
        var endperiod = $('#datepicker2').val();
        var branchid = $('#branchid').val();
        var itemid = $('#itemid').val();

        var d1 = new Date($('#datepicker').val());
        var d2 = new Date($('#datepicker2').val());

        if ((startperiod == "") || (endperiod == "")) {
            $('#show_data').empty();
            $('#mydata').hide();
            alert("Start Period or End Period cannot empty");
        } else if (d1 > d2) {
            $('#show_data').empty();
            $('#mydata').hide();
            alert("Start Period cannot more than End Period");
        } else {
            $('#show_data').empty();
            $.ajax({
                type: 'GET',
                datatype: 'JSON',
                url: '<?php echo site_url() ?>report/profit_report/get_report',
                data: {
                    startperiod: startperiod,
                    endperiod: endperiod,
                    branchid: branchid,
                    itemid: itemid
                },
                success: function(data) {
                    var obj = $.parseJSON(data);
                    var html = '';

                    var branchold = 'xx';
                    var branchnew = '';

                    var subtotalhpp = 0;
                    var subtotalsellprice = 0;
                    var subtotalprofit = 0;
                    var subtotalpajak = 0;

                    var totalhpp = 0;
                    var totalsellprice = 0;
                    var totalprofit = 0;
                    var totalpajak = 0;

                    $.each(obj, function(i, item) {
                        branchnew = item.branch_code;

                        if (branchold != branchnew) {

                            if (branchold != 'xx') {
                                html += '<tr>' +
                                    '<td style="text-align:right;" colspan="4"><strong>Total : </strong></td>' +
                                    '<td style="text-align:right;">' + thousandmaker(subtotalhpp) + '</strong></td>' +
                                    '<td style="text-align:right;">' + thousandmaker(subtotalsellprice) + '</strong></td>' +
                                    '<td style="text-align:right;">' + thousandmaker(subtotalprofit) + '</strong></td>' +
                                    // '<td style="text-align:right;">' + thousandmaker(subtotalpajak) + '</strong></td>' +
                                    '</tr>';

                                subtotalhpp = 0;
                                subtotalsellprice = 0;
                                subtotalprofit = 0;
                                subtotalpajak = 0;
                            }

                            html += '<tr>' +
                                '<td style="text-align:left;" colspan="8"><strong>Cabang : (' + item.branch_code + ') ' + item.branch_name + '</strong></td>' +
                                '</tr>';

                        }

                        html += '<tr>' +
                            '<td style="text-align:center;">' + item.created_date + '</td>' +
                            '<td style="text-align:center;">' + item.trans_number + '</td>' +
                            '<td style="text-align:left;">' + item.item_name + '</td>' +
                            '<td style="text-align:center;">' + item.qty_now + '</td>' +
                            '<td style="text-align:right;">' + thousandmaker((item.tot_hpp == null) ? 0 : parseInt(item.tot_hpp)) + '</td>' +
                            '<td style="text-align:right;">' + thousandmaker(parseFloat(item.tot_sell_price)) + '</td>' +
                            '<td style="text-align:right;">' + thousandmaker((item.profit == null) ? 0 : parseInt(item.profit)) + '</td>' +
                            // '<td style="text-align:right;">' + thousandmaker(parseFloat(item.pajak)) + '</td>' +
                            '</tr>';

                        subtotalhpp += (item.tot_hpp == null) ? 0 : parseInt(item.tot_hpp);
                        subtotalsellprice = parseInt(subtotalsellprice) + parseInt(item.tot_sell_price);
                        subtotalprofit += (item.profit == null) ? 0 : parseInt(item.profit);
                        subtotalpajak = parseInt(subtotalpajak) + parseInt(item.pajak);

                        totalhpp += (item.tot_hpp == null) ? 0 : parseInt(item.tot_hpp);
                        totalsellprice = parseInt(totalsellprice) + parseInt(item.tot_sell_price);
                        totalprofit += (item.profit == null) ? 0 : parseInt(item.profit);
                        totalpajak = parseInt(totalpajak) + parseInt(item.pajak);

                        branchold = branchnew;
                    });

                    html += '<tr>' +
                        '<td style="text-align:right;" colspan="4"><strong>Total : </strong></td>' +
                        '<td style="text-align:right;">' + thousandmaker(subtotalhpp) + '</strong></td>' +
                        '<td style="text-align:right;">' + thousandmaker(subtotalsellprice) + '</strong></td>' +
                        '<td style="text-align:right;">' + thousandmaker(subtotalprofit) + '</strong></td>' +
                        // '<td style="text-align:right;">' + thousandmaker(subtotalpajak) + '</strong></td>' +
                        '</tr>';

                    html += '<tr>' +
                        '<td style="text-align:right;" colspan="4"><strong>Grand Total : </strong></td>' +
                        '<td style="text-align:right;">' + thousandmaker(totalhpp) + '</strong></td>' +
                        '<td style="text-align:right;">' + thousandmaker(totalsellprice) + '</strong></td>' +
                        '<td style="text-align:right;">' + thousandmaker(totalprofit) + '</strong></td>' +
                        // '<td style="text-align:right;">' + thousandmaker(totalpajak) + '</strong></td>' +
                        '</tr>';

                    $('#show_data').append(html);
                    $('#mydata').show()
                }
            });
        }
    }

    function get_print() {
        var startperiod = new Date($('#datepicker').val());
        var endperiod = new Date($('#datepicker2').val());
        var branchid = $('#branchid').val();
        var itemid = $('#itemid').val();

        if ((startperiod == "") || (endperiod == "")) {
            alert("Start Period or End Period cannot empty");
        } else if (startperiod > endperiod) {
            alert("Start Period cannot more than End Period");
        } else {
            var from_date = startperiod.getDate();
            var from_month = startperiod.getMonth() + 1;
            var from_year = startperiod.getFullYear();
            var from_period = from_year + "-" + from_month + "-" + from_date;

            var to_date = endperiod.getDate();
            var to_month = endperiod.getMonth() + 1;
            var to_year = endperiod.getFullYear();
            var to_period = to_year + "-" + to_month + "-" + to_date;

            var win = window.open('<?php echo site_url() ?>report/profit_report/get_print/' + from_period + '/' + to_period + '/' + branchid + '/' + itemid, '_blank');
            if (win) {
                //Browser has allowed it to be opened
                win.focus();
            } else {
                //Browser has blocked it
                alert('Please allow popups for this website');
            }
        }
    }

    function get_excel() {
        var startperiod = new Date($('#datepicker').val());
        var endperiod = new Date($('#datepicker2').val());
        var branchid = $('#branchid').val();
        var itemid = $('#itemid').val();

        if ((startperiod == "") || (endperiod == "")) {
            alert("Start Period or End Period cannot empty");
        } else if (startperiod > endperiod) {
            alert("Start Period cannot more than End Period");
        } else {
            var from_date = startperiod.getDate();
            var from_month = startperiod.getMonth() + 1;
            var from_year = startperiod.getFullYear();
            var from_period = from_year + "-" + from_month + "-" + from_date;

            var to_date = endperiod.getDate();
            var to_month = endperiod.getMonth() + 1;
            var to_year = endperiod.getFullYear();
            var to_period = to_year + "-" + to_month + "-" + to_date;

            var win = window.open('<?php echo site_url() ?>report/profit_report/get_excel/' + from_period + '/' + to_period + '/' + branchid + '/' + itemid, '_blank');
            if (win) {
                //Browser has allowed it to be opened
                win.focus();
            } else {
                //Browser has blocked it
                alert('Please allow popups for this website');
            }
        }
    }

    function get_pdf() {
        var startperiod = new Date($('#datepicker').val());
        var endperiod = new Date($('#datepicker2').val());
        var itemid = $('#itemid').val();

        if ((startperiod == "") || (endperiod == "")) {
            alert("Start Period or End Period cannot empty");
        } else if (startperiod > endperiod) {
            alert("Start Period cannot more than End Period");
        } else {
            var from_date = startperiod.getDate();
            var from_month = startperiod.getMonth() + 1;
            var from_year = startperiod.getFullYear();
            var from_period = from_year + "-" + from_month + "-" + from_date;

            var to_date = endperiod.getDate();
            var to_month = endperiod.getMonth() + 1;
            var to_year = endperiod.getFullYear();
            var to_period = to_year + "-" + to_month + "-" + to_date;

            var win = window.open('<?php echo site_url() ?>report/summary_recap_stock_report/get_pdf/' + from_period + '/' + to_period + '/' + itemid, '_blank');
            if (win) {
                //Browser has allowed it to be opened
                win.focus();
            } else {
                //Browser has blocked it
                alert('Please allow popups for this website');
            }
        }
    }

    function thousandmaker(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }
</script>
<?php
$this->load->view('template/footer');
?>