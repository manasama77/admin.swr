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
            Detail Rekap Barang
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Laporan</a></li>
            <li class="active">Detail Rekap Barang</li>
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
                                        <th style="width:5%; text-align:center;">No</th>
                                        <th style="width:25%; text-align:center;">Tanggal</th>
                                        <th style="width:25%; text-align:center;">Jenis Transaksi</th>
                                        <th style="width:25%; text-align:center;">Nomor Dokumen</th>
                                        <th style="width:20%; text-align:center;">Jumlah</th>
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
                type: 'POST',
                datatype: 'JSON',
                url: '<?php echo site_url() ?>report/detail_recap_stock_report/get_report',
                data: {
                    startperiod: startperiod,
                    endperiod: endperiod,
                    branchid: branchid,
                    itemid: itemid
                },
                success: function(data) {
                    var obj = $.parseJSON(data);
                    var htmlhead = '';
                    var htmltotal = '';
                    var html = '';
                    var i;
                    var x = 0;
                    var totalqty = 0;
                    var itemold = 'xx';
                    var itemnew = '';

                    $.each(obj, function(i, item) {
                        itemnew = item.item_code;
                        htmltotal = '';
                        htmlhead = '';

                        if (itemold != itemnew) {
                            x = 0;

                            if (itemold != 'xx') {
                                htmltotal = '<tr>' +
                                    '<td style="text-align:right;" colspan="4"><strong>Total : </strong></td>' +
                                    '<td style="text-align:center;"><strong>' + totalqty + '</td>' +
                                    '</tr>';
                            }

                            totalqty = 0;

                            htmlhead = '<tr>' +
                                '<td style="text-align:left;" colspan="5"><strong>Cabang : (' + item.branch_code + ') ' + item.branch_name + ' | Barang : (' + item.barcode + ') ' + item.item_name + '</strong></td>' +
                                '</tr>';
                        }

                        html = html + htmltotal + htmlhead;

                        html += '<tr>' +
                            '<td style="text-align:center;">' + parseInt(x + 1) + '</td>' +
                            '<td style="text-align:center;">' + item.created_date + '</td>' +
                            '<td style="text-align:center;">' + item.trans_type + '</td>' +
                            '<td style="text-align:center;">' + item.doc_number + '</td>' +
                            '<td style="text-align:center;">' + item.qty + '</td>' +
                            '</tr>';
                        totalqty = parseInt(totalqty) + parseInt(item.qty);

                        itemold = itemnew;
                        x = x + 1;
                    });

                    htmltotal = '<tr>' +
                        '<td style="text-align:right;" colspan="4"><strong>Total : </strong></td>' +
                        '<td style="text-align:center;"><strong>' + totalqty + '</td>' +
                        '</tr>';

                    html = html + htmltotal;

                    $('#show_data').append(html);
                    $('#mydata').show();
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

            var win = window.open('<?php echo site_url() ?>report/detail_recap_stock_report/get_print/' + from_period + '/' + to_period + '/' + branchid + '/' + itemid, '_blank');
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

            var win = window.open('<?php echo site_url() ?>report/detail_recap_stock_report/get_excel/' + from_period + '/' + to_period + '/' + branchid + '/' + itemid, '_blank');
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

            var win = window.open('<?php echo site_url() ?>report/detail_recap_stock_report/get_pdf/' + from_period + '/' + to_period + '/' + itemid, '_blank');
            if (win) {
                //Browser has allowed it to be opened
                win.focus();
            } else {
                //Browser has blocked it
                alert('Please allow popups for this website');
            }
        }
    }
</script>
<?php
$this->load->view('template/footer');
?>