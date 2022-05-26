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
            Rekap Penjualan
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Laporan</a></li>
            <li class="active">Rekap Penjualan</li>
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
                                        <th style="width:15%; text-align:center;">Kasir</th>
                                        <th style="width:15%; text-align:center;">Nomor Penjualan</th>
                                        <th style="width:20%; text-align:center;">Tanggal</th>
                                        <th style="width:15%; text-align:center;">Total Transaksi</th>
                                        <th style="width:15%; text-align:center;">Disc</th>
                                        <th style="width:15%; text-align:center;">Pembayaran</th>
                                        <th style="width:15%; text-align:center;"><i class="fa fa-cog"></i></th>
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
                url: '<?php echo site_url() ?>report/summary_sales_report/get_report',
                data: {
                    startperiod: startperiod,
                    endperiod: endperiod,
                    userid: userid,
                    branchid: branchid
                },
                success: function(data) {
                    console.log(data);
                    var obj = $.parseJSON(data);
                    var html = '';
                    var x;

                    var branchnameold = 'xx';
                    var branchnamenew = '';

                    var all_price = 0;
                    var all_disc = 0;
                    var all_trans = 0;

                    var grand_price = 0;
                    var grand_disc = 0;
                    var grand_trans = 0;

                    $.each(obj, function(i, item) {
                        branchnamenew = item.branch_name;

                        if (branchnameold != branchnamenew) {
                            x = 0;

                            if (branchnameold != 'xx') {

                                html += '<tr>' +
                                    '<td colspan="4" style="text-align:right;"><strong>Total ' + item.branch_name + ' : </strong></td>' +
                                    '<td style="text-align:right;"><strong>' + thousandmaker(all_price) + '</strong></td>' +
                                    '<td style="text-align:right;"><strong>' + thousandmaker(all_disc) + '</strong></td>' +
                                    '<td style="text-align:right;"><strong>' + thousandmaker(all_trans) + '</strong></td>' +
                                    '<td style="text-align:center;"><strong><button type="button" class="btn btn-info btn-sm" onclick="printStruk(\'' + item.sales_number + '\')" title="Print Struk"><i class="fa fa-print"></i></button></strong></td>' +
                                    '</tr>';

                                html += '<tr><td colspan="8"></td></tr>';
                            }

                            all_price = 0;
                            all_disc = 0;
                            all_trans = 0;

                            html += '<tr>' +
                                '<td style="text-align:left;" colspan="8"><strong>Cabang : (' + item.branch_code + ') ' + item.branch_name + '</strong></td>' +
                                '</tr>';

                        }

                        html += '<tr>' +
                            '<td style="text-align:center;">' + parseInt(x + 1) + '</td>' +
                            '<td style="text-align:center;">' + item.cashier_name + '</td>' +
                            '<td style="text-align:center;">' + item.sales_number + '</td>' +
                            '<td style="text-align:center;">' + item.sales_date + '</td>' +
                            '<td style="text-align:right;">' + thousandmaker(parseFloat(item.total_price)) + '</td>' +
                            '<td style="text-align:right;">' + thousandmaker(parseFloat(item.total_disc)) + '</td>' +
                            '<td style="text-align:right;">' + thousandmaker(parseFloat(item.total_transaction)) + '</td>' +
                            '<td style="text-align:center;"><strong><button type="button" class="btn btn-info btn-sm" onclick="printStruk(\'' + item.sales_number + '\')" title="Print Struk"><i class="fa fa-print"></i></button></strong></td>' +
                            '</tr>';

                        all_price = parseFloat(all_price) + parseFloat(item.total_price);
                        all_disc = parseFloat(all_disc) + parseFloat(item.total_disc);
                        all_trans = parseFloat(all_trans) + parseFloat(item.total_transaction);

                        grand_price = parseFloat(grand_price) + parseFloat(item.total_price);
                        grand_disc = parseFloat(grand_disc) + parseFloat(item.total_disc);
                        grand_trans = parseFloat(grand_trans) + parseFloat(item.total_transaction);

                        x++;
                        branchnameold = branchnamenew;
                    });

                    html += '<tr>' +
                        '<td colspan="4" style="text-align:right;"><strong>Total ' + branchnameold + ' : </strong></td>' +
                        '<td style="text-align:right;"><strong>' + thousandmaker(all_price) + '</strong></td>' +
                        '<td style="text-align:right;"><strong>' + thousandmaker(all_disc) + '</strong></td>' +
                        '<td style="text-align:right;"><strong>' + thousandmaker(all_trans) + '</strong></td>' +
                        '</tr>';

                    html += '<tr>' +
                        '<td colspan="4" style="text-align:right;"><strong>Grand Total : </strong></td>' +
                        '<td style="text-align:right;"><strong>' + thousandmaker(grand_price) + '</strong></td>' +
                        '<td style="text-align:right;"><strong>' + thousandmaker(grand_disc) + '</strong></td>' +
                        '<td style="text-align:right;"><strong>' + thousandmaker(grand_trans) + '</strong></td>' +
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

            var win = window.open('<?php echo site_url() ?>report/summary_sales_report/get_print/' + from_period + '/' + to_period + '/' + userid + '/' + branchid, '_blank');
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

            var win = window.open('<?php echo site_url() ?>report/summary_sales_report/get_excel/' + from_period + '/' + to_period + '/' + userid + '/' + branchid, '_blank');
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

            var win = window.open('<?php echo site_url() ?>report/summary_sales_report/get_pdf/' + from_period + '/' + to_period + '/' + userid + '/' + branchid, '_blank');
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


    function printStruk(sales_number) {
        window.open(`<?= URL_KASIR ?>/kasir/print/${sales_number}`)
    }
</script>
<?php
$this->load->view('template/footer');
?>