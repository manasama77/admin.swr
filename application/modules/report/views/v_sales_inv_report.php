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
    Sales Inventory Report
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Report</a></li>
        <li class="active">Sales Inventory Report</li>
    </ol>
</section>

<form class="form">
<section class="content">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">View Report</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Start Period</label>
                            <input type="text" class="form-control pull-right" id="datepicker" name="startperiod" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label>End Period</label>
                            <input type="text" class="form-control pull-right" id="datepicker2" name="endperiod" autocomplete="off">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Stock Item</label>
                            <select class="form-control select2" id="itemid" name="itemid" style="width: 100%;">
                                <option value='0'>ALL</option>    
                                <?php foreach($item->result() as $row) :?>
                                    <?php echo "<option value='". $row->item_id . "'>" . $row->item_code . " (" . $row->item_name . ")</option>"; ?>
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
                        <!--button class="btn btn-info" id="ExcelButton">Export to Excel</button>
                        <button class="btn btn-info" id="PdfButton">Export to PDF</button-->
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
            
            var win = window.open('<?php echo site_url() ?>report/sales_inv_report/get_report/'+from_period+'/'+to_period+'/'+itemid, '_blank');
            if (win) {
                //Browser has allowed it to be opened
                win.focus();
            } else {
                //Browser has blocked it
                alert('Please allow popups for this website');
            }
        }
    }

    function get_print(){
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
            
            var win = window.open('<?php echo site_url() ?>report/sales_inv_report/get_print/'+from_period+'/'+to_period+'/'+itemid, '_blank');
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
            
            var win = window.open('<?php echo site_url() ?>report/sales_inv_report/get_excel/'+from_period+'/'+to_period+'/'+itemid, '_blank');
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
            
            var win = window.open('<?php echo site_url() ?>report/sales_inv_report/get_pdf/'+from_period+'/'+to_period+'/'+itemid, '_blank');
            if (win) {
                //Browser has allowed it to be opened
                win.focus();
            } else {
                //Browser has blocked it
                alert('Please allow popups for this website');
            }
        }
    }
    
    function thousandmaker(x){
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

</script>
<?php
$this->load->view('template/footer');
?>