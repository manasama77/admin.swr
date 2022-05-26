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
            Detail Penjualan
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Laporan</a></li>
            <li class="active">Detail Penjualan</li>
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
                                <label>Awal Transaksi</label>
                                <input type="text" class="form-control" id="datepicker" name="startperiod" autocomplete="off">
                            </div>
                            <br>
                            <div class="form-group">
                                <label>Akhir Transaksi</label>
                                <input type="text" class="form-control" id="datepicker2" name="endperiod" autocomplete="off">
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
                                <label>Kasir</label>
                                <select class="form-control select2" id="userid" name="userid" style="width: 100%;">
                                    <option value='0'>Semua Kasir</option>
                                    <?php foreach ($user->result() as $row) : ?>
                                        <?php echo "<option value='" . $row->user_id . "'>" . $row->fullname . "</option>"; ?>
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
                                        <th style="width:5%; text-align:center;">No</th>
                                        <th style="width:55%; text-align:center;">Nama Barang</th>
                                        <th style="width:10%; text-align:center;">Harga</th>
                                        <th style="width:10%; text-align:center;">Diskon</th>
                                        <th style="width:10%; text-align:center;">Jumlah</th>
                                        <th style="width:10%; text-align:center;">Total</th>
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
    $('#datepicker').datepicker({
        autoclose: true
    });

    //Date picker
    $('#datepicker2').datepicker({
        autoclose: true
    });

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
        var userid = $('#userid').val();
        var branchid = $('#branchid').val();

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
                type: 'POST',
                datatype: 'JSON',
                url: '<?php echo site_url() ?>report/detail_sales_report/get_report',
                data: {
                    startperiod: startperiod,
                    endperiod: endperiod,
                    userid: userid,
                    branchid: branchid
                },
                success: function(data) {
                    var obj = $.parseJSON(data);
                    var htmlhead = '';
                    var html = '';
                    var i;
                    var x = 0;
                    var salesnumberold = 'xx';
                    var salesnumbernew = '';
                    var totalprice = '';
                    var totaldisc = '';
                    var totaltransaction = '';
                    $.each(obj, function(i, item) {
                        salesnumbernew = item.sales_number;

                        if (salesnumberold != salesnumbernew) {
                            x = 0;

                            if (salesnumberold != 'xx') {

                                html += '<tr>' +
                                    '<td style="text-align:right;" colspan="5"><strong>Total Transaksi : </strong></td><td style="text-align:right;">' + totalprice + '</td>' +
                                    '</tr>' +
                                    '<tr>' +
                                    '<td style="text-align:right;" colspan="5"><strong>Total Disc : </strong></td><td style="text-align:right;">' + totaldisc + '</td>' +
                                    '</tr>' +
                                    '<tr>' +
                                    '<td style="text-align:right;" colspan="5"><strong>Total Penjualan : </strong></td><td style="text-align:right;">' + totaltransaction + '</td>' +
                                    '</tr>';

                            }

                            html += '<tr>' +
                                '<td style="text-align:left;" colspan="7"><strong>Tanggal Penjualan : ' + item.sales_date + ' / Nomor Penjualan : ' + item.sales_number + ' / Cabang : (' + item.branch_code + ') ' + item.branch_name + ' / Kasir : ' + item.cashier_name + '</strong></td>' +
                                '</tr>';

                        }

                        html += '<tr>' +
                            '<td style="text-align:center;">' + parseInt(x + 1) + '</td>' +
                            '<td style="text-align:left;">(' + item.barcode + ') ' + item.item_name + '</td>' +
                            '<td style="text-align:right;">' + thousandmaker(parseFloat(item.price)) + '</td>' +
                            '<td style="text-align:right;">' + thousandmaker(parseFloat(item.extra_disc)) + '</td>' +
                            '<td style="text-align:center;">' + item.qty + '</td>' +
                            '<td style="text-align:right;">' + thousandmaker(parseFloat(item.subtotal)) + '</td>' +
                            '</tr>';

                        salesnumberold = salesnumbernew;
                        totalprice = thousandmaker(parseFloat(item.total_price));
                        totaldisc = thousandmaker(parseFloat(item.total_disc));
                        totaltransaction = thousandmaker(parseFloat(item.total_transaction));
                        x = x + 1;
                    });

                    html += '<tr>' +
                        '<td style="text-align:right;" colspan="5"><strong>Total Transaksi : </strong></td><td style="text-align:right;">' + totalprice + '</td>' +
                        '</tr>' +
                        '<tr>' +
                        '<td style="text-align:right;" colspan="5"><strong>Total Disc : </strong></td><td style="text-align:right;">' + totaldisc + '</td>' +
                        '</tr>' +
                        '<tr>' +
                        '<td style="text-align:right;" colspan="5"><strong>Total Penjualan : </strong></td><td style="text-align:right;">' + totaltransaction + '</td>' +
                        '</tr>';

                    $('#show_data').append(html);
                    $('#mydata').show();
                }
            });
        }
    }

    function get_print() {
        var startperiod = new Date($('#datepicker').val());
        var endperiod = new Date($('#datepicker2').val());
        var userid = $('#userid').val();
        var branchid = $('#branchid').val();

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

            var win = window.open('<?php echo site_url() ?>report/detail_sales_report/get_print/' + from_period + '/' + to_period + '/' + userid + '/' + branchid, '_blank');
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
        var userid = $('#userid').val();
        var branchid = $('#branchid').val();

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

            var win = window.open('<?php echo site_url() ?>report/detail_sales_report/get_excel/' + from_period + '/' + to_period + '/' + userid + '/' + branchid, '_blank');
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
        var userid = $('#userid').val();
        var branchid = $('#branchid').val();

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

            var win = window.open('<?php echo site_url() ?>report/detail_sales_report/get_pdf/' + from_period + '/' + to_period + '/' + userid + '/' + branchid, '_blank');
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