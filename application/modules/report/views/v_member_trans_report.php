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
    Member Transaction Report
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Report</a></li>
        <li class="active">Member Transaction Report</li>
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
                            <input type="text" class="form-control pull-right" id="datepicker" name="startperiod">
                        </div>
                        <div class="form-group">
                            <label>End Period</label>
                            <input type="text" class="form-control pull-right" id="datepicker2" name="endperiod">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Member</label>
                            <select class="form-control select2" id="memberid" name="memberid" style="width: 100%;">
                                <option value='-1'>ALL</option>
								<option value='0'>Public</option>
                                <?php foreach($member->result() as $row) :?>
                                    <?php echo "<option value='". $row->member_id . "'>" . $row->member_code . " (" . $row->fullname . ")</option>"; ?>
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
                        <button class="btn btn-info" id="PdfButton">Export to PDF</button>
                    </div>
                </div>
                <br/>
                <div id="mydata" style="display:none" class="row">
                    <div class="col-md-12 table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr style="background-color:#99c0ff; color:white;">
                                    <th style="width:5%; text-align:center;">No</th>
                                    <th style="width:30%; text-align:center;">Date</th>
                                    <th style="width:30%; text-align:center;">Doc Number</th>
                                    <th style="width:35%; text-align:center;">Total Transaction</th>
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
        var memberid = $('#memberid').val();

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
                url   : '<?php echo site_url() ?>report/member_trans_report/get_report',
                data: {
                    startperiod: startperiod,
                    endperiod: endperiod,
                    memberid: memberid
                },
                success : function(data){
                    var obj = $.parseJSON(data);
                    var html = '';
                    var i;
                    var x = 0;
                    var memberold = 'xx';
                    var membernew = '';
                    var currentlimit = 0;
                    
                    $.each(obj, function (i, item) {
                        membernew = item.member_code;

                        if(memberold != membernew){
                            x = 0;

                            if(memberold != 'xx'){
                                html += '<tr>'+
                                    '<td style="text-align:right;" colspan="3"><strong>Current Limit : </strong></td>'+
                                    '<td style="text-align:right;"><strong>'+thousandmaker(currentlimit.replace(".", ","))+'</td>'+
                                    '</tr>'+
                                    '<tr><td colspan="4"></td></tr>';
                            }
                            
                            html += '<tr>'+
                                '<td style="text-align:left;" colspan="4"><strong>Member : '+item.member_code+' ('+item.fullname+')</strong></td>'+
                                '</tr>'+
                                '<tr>'+
                                '<td style="text-align:left;" colspan="4"><strong>Limit Transaction : '+thousandmaker(item.limit_transaction.replace(".", ","))+'</strong></td>'+
                                '</tr>';
                        }
                        
                        html += '<tr>'+
                                '<td style="text-align:center;">'+parseInt(x+1)+'</td>'+
                                '<td style="text-align:center;">'+item.created_date+'</td>'+
                                '<td style="text-align:center;">'+item.sales_number+'</td>'+
                                '<td style="text-align:right;">'+thousandmaker(item.total_transaction.replace(".", ","))+'</td>'+
                                '</tr>';

                        memberold = membernew;
                        currentlimit = item.current_limit;
                        x = x + 1;
                    });

                    html += '<tr>'+
                            '<td style="text-align:right;" colspan="3"><strong>Current Limit : </strong></td>'+
                            '<td style="text-align:right;"><strong>'+thousandmaker(currentlimit.replace(".", ","))+'</td>'+
                            '</tr>'+
                            '<tr><td colspan="4"></td></tr>';

                    $('#show_data').append(html);
                    $('#mydata').show();
                }
            });
        }
    }

    function get_print(){
        var startperiod = new Date($('#datepicker').val());
        var endperiod = new Date($('#datepicker2').val());
        var memberid = $('#memberid').val();

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
            
            var win = window.open('<?php echo site_url() ?>report/member_trans_report/get_print/'+from_period+'/'+to_period+'/'+memberid, '_blank');
            if (win) {
                win.focus();
            } else {
                alert('Please allow popups for this website');
            }
        }
    }
    
    function get_excel(){
        var startperiod = new Date($('#datepicker').val());
        var endperiod = new Date($('#datepicker2').val());
        var memberid = $('#memberid').val();

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
            
            var win = window.open('<?php echo site_url() ?>report/member_trans_report/get_excel/'+from_period+'/'+to_period+'/'+memberid, '_blank');
            if (win) {
                win.focus();
            } else {
                alert('Please allow popups for this website');
            }
        }
    }
    
    function get_pdf(){
        var startperiod = new Date($('#datepicker').val());
        var endperiod = new Date($('#datepicker2').val());
        var memberid = $('#memberid').val();

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
            
            var win = window.open('<?php echo site_url() ?>report/member_trans_report/get_pdf/'+from_period+'/'+to_period+'/'+memberid, '_blank');
            if (win) {
                win.focus();
            } else {
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