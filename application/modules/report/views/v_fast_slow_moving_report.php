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
    Penjualan Barang
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Laporan</a></li>
        <li class="active">Penjualan Barang</li>
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
                        <div class="form-group">
                            <label>Awal Periode</label>
                            <input type="text" class="form-control" id="datepicker" name="startperiod">
                        </div>
                        <div class="form-group">
                            <label>Akhir Periode</label>
                            <input type="text" class="form-control" id="datepicker2" name="endperiod">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Cabang</label>
                            <select class="form-control select2" id="branchid" name="branchid" style="width: 100%;">
                                <?php foreach($branch->result() as $row) :?>
                                    <?php echo "<option value='". $row->branch_id . "'>(" . $row->branch_code . ") " . $row->branch_name . "</option>"; ?>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Jenis Barang</label>
                            <select class="form-control select2" id="itemid" name="itemid" style="width: 100%;">
                                <option value='0'>Semua Barang</option>
                                <?php foreach($item->result() as $row) :?>
                                    <?php echo "<option value='". $row->item_id . "'>(" . $row->barcode . ") " . $row->item_name . "</option>"; ?>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <br/>
                <div class="row">
                    <div class="col-md-12">
                        <button class="btn btn-info" id="GenerateButton">Preview Report</button>
                        <button class="btn btn-info" id="PrintButton">Print Report</button>
                        <button class="btn btn-info" id="ExcelButton">Export to Excel</button>
                        <!--button class="btn btn-info" id="PdfButton">Export to PDF</button-->
                    </div>
                </div>
                <br/>
                <div id="mydata" style="display:none" class="row">
                    <div class="col-md-12 table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr style="background-color:#99c0ff; color:white;">
                                    <th style="width:50%; text-align:center;">Jenis Barang</th>
                                    <th style="width:10%; text-align:center;">Harga Modal</th>
                                    <th style="width:10%; text-align:center;">Harga Jual</th>
                                    <th style="width:10%; text-align:center;">Selisih</th>
                                    <th style="width:10%; text-align:center;">Jumlah</th>
                                    <th style="width:10%; text-align:center;">Keuntungan</th>
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

    $(document).ready(function(){
        $('#GenerateButton').click(function (e) {
            e.preventDefault();
            get_report();
        });

        $('#PrintButton').click(function (e) {
            get_print();
        });

        $('#ExcelButton').click(function (e) {
            get_excel();
        });

        $('#PdfButton').click(function (e) {
            get_pdf();
        });
    });

    function get_report(){
        var startperiod = $('#datepicker').val();
        var endperiod = $('#datepicker2').val();
        var branchid = $('#branchid').val();
        var itemid = $('#itemid').val();
        
        if((startperiod == "") || (endperiod == "")){
            alert("Start Period or End Period cannot empty");
        }
        else if(startperiod > endperiod){
            alert("Start Period cannot more than End Period");
        }
        else{
            $('#show_data').empty();
            $.ajax({
                type  : 'POST',
                datatype : 'JSON',
                url   : '<?php echo site_url() ?>report/fast_slow_moving_report/get_report',
                data: {
                    startperiod: startperiod,
                    endperiod: endperiod,
                    branchid: branchid,
                    itemid: itemid
                },
                success : function(data){
                    var obj = $.parseJSON(data);
                    var html = '';
                    var i;
					var x = 0;
					var itemcodeold = 'xx';
                    var itemcodenew = '';

                    var totalbeginingqty = 0;
                    var totalstockin = 0;
                    var totalstockout = 0;
                    var totaltotalqty = 0;

                    $.each(obj, function (i, item) {
						itemcodenew = item.item_code;
						
						if(itemcodeold != itemcodenew){
							x = 0;

                            if(itemcodeold != 'xx'){
                                html += '<tr>'+
                                    '<td style="text-align:right;" colspan="3"><strong>Total : </strong></td>'+
                                    '<td style="text-align:center;">'+totalbeginingqty+'</strong></td>'+
                                    '<td style="text-align:center;">'+totalstockin+'</strong></td>'+
                                    '<td style="text-align:center;">'+totalstockout+'</strong></td>'+
                                    '<td style="text-align:center;">'+totaltotalqty+'</strong></td>'+
                                    '</tr>';

                                totalbeginingqty = 0;
                                totalstockin = 0;
                                totalstockout = 0;
                                totaltotalqty = 0;
                            }
							
                            html += '<tr>'+
                                '<td style="text-align:left;" colspan="7"><strong>Kategori Barang : '+item.stock_category_name+' / Jenis Barang : ('+item.item_code+') '+item.item_name+'</strong></td>'+
                                '</tr>';

						}
						
                        html += '<tr>'+
                                '<td style="text-align:center;">'+parseInt(x+1)+'</td>'+
                                '<td style="text-align:center;">'+item.branch_code+'</td>'+
                                '<td style="text-align:left;">'+item.branch_name+'</td>'+
                                '<td style="text-align:center;">'+item.begining_qty+'</td>'+
                                '<td style="text-align:center;">'+item.stock_in+'</td>'+
                                '<td style="text-align:center;">'+item.stock_out+'</td>'+
                                '<td style="text-align:center;">'+item.total_qty+'</td>'+
                                '</tr>';

                        totalbeginingqty = parseInt(totalbeginingqty) + parseInt(item.begining_qty);
                        totalstockin = parseInt(totalstockin) + parseInt(item.stock_in);
                        totalstockout = parseInt(totalstockout) + parseInt(item.stock_out);
                        totaltotalqty = parseInt(totaltotalqty) + parseInt(item.total_qty);
								
                        itemcodeold = itemcodenew;
						x = x + 1;
                    });

                    html += '<tr>'+
                                '<td style="text-align:right;" colspan="3"><strong>Total : </strong></td>'+
                                '<td style="text-align:center;">'+totalbeginingqty+'</strong></td>'+
                                '<td style="text-align:center;">'+totalstockin+'</strong></td>'+
                                '<td style="text-align:center;">'+totalstockout+'</strong></td>'+
                                '<td style="text-align:center;">'+totaltotalqty+'</strong></td>'+
                                '</tr>';

                    $('#show_data').append(html);
                    $('#mydata').show()
                }
            });
        }
    }

    function get_print(){
        var startperiod = new Date($('#datepicker').val());
        var endperiod = new Date($('#datepicker2').val());
        var branchid = $('#branchid').val();
        var itemid = $('#itemid').val();

        if((startperiod == "") || (endperiod == "")){
            alert("Start Period or End Period cannot empty");
        }
        else if(startperiod > endperiod){
            alert("Start Period cannot more than End Period");
        }
        else{
            var from_date = startperiod.getDate();
            var from_month = startperiod.getMonth()+1;
            var from_year = startperiod.getFullYear();
            var from_period = from_year+"-"+from_month+"-"+from_date;

            var to_date = endperiod.getDate();
            var to_month = endperiod.getMonth()+1;
            var to_year = endperiod.getFullYear();
            var to_period = to_year+"-"+to_month+"-"+to_date;
            
            var win = window.open('<?php echo site_url() ?>report/fast_slow_moving_report/get_print/'+from_period+'/'+to_period+'/'+branchid+'/'+itemid, '_blank');
            if (win) {
                //Browser has allowed it to be opened
                win.focus();
            } else {
                //Browser has blocked it
                alert('Please allow popups for this website');
            }
        }
    }

function get_excel(){
    var startperiod = new Date($('#datepicker').val());
    var endperiod = new Date($('#datepicker2').val());
    var branchid = $('#branchid').val();
    var itemid = $('#itemid').val();

    if((startperiod == "") || (endperiod == "")){
        alert("Start Period or End Period cannot empty");
    }
    else if(startperiod > endperiod){
        alert("Start Period cannot more than End Period");
    }
    else{
        var from_date = startperiod.getDate();
        var from_month = startperiod.getMonth()+1;
        var from_year = startperiod.getFullYear();
        var from_period = from_year+"-"+from_month+"-"+from_date;

        var to_date = endperiod.getDate();
        var to_month = endperiod.getMonth()+1;
        var to_year = endperiod.getFullYear();
        var to_period = to_year+"-"+to_month+"-"+to_date;
        
        var win = window.open('<?php echo site_url() ?>report/fast_slow_moving_report/get_excel/'+from_period+'/'+to_period+'/'+branchid+'/'+itemid, '_blank');
        if (win) {
            //Browser has allowed it to be opened
            win.focus();
        } else {
            //Browser has blocked it
            alert('Please allow popups for this website');
        }
    }
}

    function get_pdf(){
        var startperiod = new Date($('#datepicker').val());
        var endperiod = new Date($('#datepicker2').val());
        var itemid = $('#itemid').val();

        if((startperiod == "") || (endperiod == "")){
            alert("Start Period or End Period cannot empty");
        }
        else if(startperiod > endperiod){
            alert("Start Period cannot more than End Period");
        }
        else{
            var from_date = startperiod.getDate();
            var from_month = startperiod.getMonth()+1;
            var from_year = startperiod.getFullYear();
            var from_period = from_year+"-"+from_month+"-"+from_date;

            var to_date = endperiod.getDate();
            var to_month = endperiod.getMonth()+1;
            var to_year = endperiod.getFullYear();
            var to_period = to_year+"-"+to_month+"-"+to_date;
            
            var win = window.open('<?php echo site_url() ?>report/summary_recap_stock_report/get_pdf/'+from_period+'/'+to_period+'/'+itemid, '_blank');
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