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
            Promo & Bundling
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Data Utama</a></li>
            <li class="active">Promo & Bundling</li>
        </ol>
    </section>

    <section class="content">
        <div class="box box-info">
            <div class="box-header with-border">
                <button onclick="add_data()" class="btn btn-primary bold"><i class="fa fa-plus-circle"></i> Tambah Data</button>
            </div>
            <div class="box-body">
                <table id="BundlingTable" class="table table-bordered table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>Bundling Name</th>
                            <th>Start Period</th>
                            <th>End Period</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($bundling->result() as $row) : ?>
                            <tr>
                                <td><?php echo $row->bundling_name; ?></td>
                                <td><?php echo date('d M Y', strtotime($row->start_period)); ?></td>
                                <td><?php echo date('d M Y', strtotime($row->end_period)); ?></td>
                                <td><?php echo $row->strstatus; ?></td>
                                <td>
                                    <button class="btn btn-sm btn-success bold" onclick="view_data(<?php echo $row->item_bundling_id; ?>)"><i class="fa fa-file-text-o"></i></button>
                                    &nbsp;
                                    <button class="btn btn-sm btn-warning bold" onclick="edit_data(<?php echo $row->item_bundling_id; ?>)"><i class="fa fa-pencil"></i></button>
                                    &nbsp;
                                    <button class="btn btn-sm btn-danger bold" onclick="delete_data(<?php echo $row->item_bundling_id; ?>)"><i class="fa fa-ban"></i></button>
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
                    <h4 class="modal-title" style="text-align:center;"><strong>Role Form</strong></h4>
                </div>
                <form action="#" id="form" class="form-horizontal">
                    <div class="modal-body">
                        <input type="hidden" class="form-control" id="formtype" name="formtype" value="">
                        <input type="hidden" class="form-control" id="promoid" name="promoid" value="0">

                        <div class="form-group">
                            <label class="col-sm-4 control-label">Promo & Bundling Code</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="bundlingcode" name="bundlingcode" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Cabang</label>
                            <div class="col-sm-6">
                                <select class="form-control select2" id="branchid" name="branchid" style="width: 100%;">
                                    <option value='0' selected>Silahkan Pilih</option>
                                    <option value='-1'>Semua Cabang</option>
                                    <?php foreach ($branch->result() as $row) : ?>
                                        <?php echo "<option value='" . $row->branch_id . "'>(" . $row->branch_code . ") " . $row->branch_name . "</option>"; ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Promo & Bundling Name</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="bundlingname" name="bundlingname">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Start Period</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control pull-right" id="datepicker" name="startperiod" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">End Period</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control pull-righ" id="datepicker2" name="endperiod" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Customer Type</label>
                            <div class="col-sm-6">
                                <select class="form-control select2" id="customertype" name="customertype" style="width: 100%;">
                                    <option value='1'>Public & Member</option>
                                    <option value='2'>Public</option>
                                    <option value='3'>Member</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Status</label>
                            <div class="col-sm-6">
                                <select class="form-control select2" id="status" name="status" style="width: 100%;">
                                    <option value='0'>Draft</option>
                                    <option value='1'>Active</option>
                                    <option value='2'>InActive</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Information</label>
                            <div class="col-sm-6">
                                <textarea class="form-control" rows="5" id="information" name="information"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Promo Object</label>
                            <div class="col-sm-6">
                                <select class="form-control select2" id="promoobject" name="promoobject" style="width: 100%;">
                                    <option value='0' selected>Please Choose...</option>
                                    <option value='1'>Total Transaction</option>
                                    <option value='2'>Product</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Promo Gift</label>
                            <div class="col-sm-6">
                                <select class="form-control select2" id="promogift" name="promogift" style="width: 100%;">

                                </select>
                            </div>
                        </div>

                        <div id="ObjectTransaction" style="display: none;">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Min Trans Amount</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="mintransamount" name="mintransamount" value="0">
                                </div>
                            </div>
                        </div>
                        <div id="ObjectProduct" style="display: none;">
                            <div class="form-group">
                                <label class="col-sm-2 control-label"></label>
                                <div class="col-sm-4">
                                    <label>
                                        <input type="checkbox" class="flat-red" checked>&nbsp;&nbsp; Is Multiply
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Object Product Type</label>
                                <div class="col-sm-4">
                                    <select class="form-control select2" id="objectproducttype" name="objectproducttype" style="width: 100%;">
                                        <option value=''>Please Choose...</option>
                                        <option value='1'>Single</option>
                                        <option value='2'>Multi</option>
                                    </select>
                                </div>
                            </div>
                            <div id="ObjectProductSingle" style="display: none;">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Product Item</label>
                                    <div class="col-sm-4">
                                        <select class="form-control select2" id="itempromo" name="itempromo" style="width: 100%;">
                                            <option value='0'>Please Choose...</option>
                                            <?php foreach ($item->result() as $row) : ?>
                                                <?php echo "<option value='" . $row->item_id . "'>" . $row->item_code . " (" . $row->item_name . ")</option>"; ?>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Qty</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="qtysingle" name="qtysingle">
                                    </div>
                                </div>
                            </div>
                            <div id="ObjectProductMulti" style="display: none;">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Remark</th>
                                            <th>Product</th>
                                            <th>Qty</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tablepromo">
                                        <tr>
                                            <td style="width:15%">
                                                <select class="form-control select2" id="remarkpromo" name="remarkpromo" style="width: 100%;">
                                                    <option value=''>Please Choose...</option>
                                                    <option value='AND'>AND</option>
                                                    <option value='OR'>OR</option>
                                                </select>
                                            </td>
                                            <td style="width:60%">
                                                <select class="form-control select2" id="itempromo" name="itempromo" style="width: 100%;">
                                                    <option value='0'>Please Choose...</option>
                                                    <?php foreach ($item->result() as $row) : ?>
                                                        <?php echo "<option value='" . $row->item_id . "'>" . $row->item_code . " (" . $row->item_name . ")</option>"; ?>
                                                    <?php endforeach; ?>
                                                </select>
                                            </td>
                                            <td style="width:15%">
                                                <input type="text" class="form-control" id="qtypromo" name="qtypromo" value="0">
                                            </td>
                                            <td style="width:10%">
                                                <button type="button" class="btn btn-block btn-success" id="AddPromoButton">Add</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div id="GiftFixPrice" style="display: none;">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Fix Price</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="fixprice" name="fixprice" value="0">
                                </div>
                            </div>
                        </div>
                        <div id="GiftDiscount" style="display: none;">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Discount Percentage</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="discountpercentage" name="discountpercentage" value="0">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Discount Amount</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="discountamount" name="discountamount" value="0">
                                </div>
                            </div>
                        </div>
                        <div id="GiftCashback" style="display: none;">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Cashback Amount</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="cashback" name="cashback" value="0">
                                </div>
                            </div>
                        </div>
                        <div id="GiftProduct" style="display: none;">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Gift Product Type</label>
                                <div class="col-sm-4">
                                    <select class="form-control select2" id="giftproducttype" name="giftproducttype" style="width: 100%;">
                                        <option value=''>Please Choose...</option>
                                        <option value='1'>Single</option>
                                        <option value='2'>Multi</option>
                                    </select>
                                </div>
                            </div>
                            <div id="GiftProductSingle" style="display: none;">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Product Item</label>
                                    <div class="col-sm-4">
                                        <select class="form-control select2" id="itempromo" name="itempromo" style="width: 100%;">
                                            <option value='0'>Please Choose...</option>
                                            <?php foreach ($item->result() as $row) : ?>
                                                <?php echo "<option value='" . $row->item_id . "'>" . $row->item_code . " (" . $row->item_name . ")</option>"; ?>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Qty</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="bundlingname" name="bundlingname">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Disc Type</label>
                                    <div class="col-sm-4">
                                        <select class="form-control select2" id="disctype" name="disctype" style="width: 100%;">
                                            <option value=''>Please Choose...</option>
                                            <option value='1'>Percentage</option>
                                            <option value='2'>Cashback</option>
                                            <option value='3'>Fix Price</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div id="GiftProductMulti" style="display: none;">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Remark</th>
                                            <th>Product</th>
                                            <th>Qty</th>
                                            <th>Disc Percent</th>
                                            <th>Disc Amount</th>
                                            <th>Fix Price</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tableprize">
                                        <tr>
                                            <td style="width:10%">
                                                <select class="form-control select2" id="remarkprize" name="remarkprize" style="width: 100%;">
                                                    <option value=''>Please Choose...</option>
                                                    <option value='AND'>AND</option>
                                                    <option value='OR'>OR</option>
                                                </select>
                                            </td>
                                            <td style="width:40%">
                                                <select class="form-control select2" id="itemprize" name="itemprize" style="width: 100%;">
                                                    <option value='0'>Please Choose...</option>
                                                    <?php foreach ($item->result() as $row) : ?>
                                                        <?php echo "<option value='" . $row->item_id . "'>" . $row->item_code . " (" . $row->item_name . ")</option>"; ?>
                                                    <?php endforeach; ?>
                                                </select>
                                            </td>
                                            <td style="width:10%">
                                                <input type="text" class="form-control" id="qtyprize" name="qtyprize" value="0">
                                            </td>
                                            <td style="width:10%">
                                                <input type="text" class="form-control" id="discpercent" name="discpercent" value="0">
                                            </td>
                                            <td style="width:10%">
                                                <input type="text" class="form-control" id="discamount" name="discamount" value="0">
                                            </td>
                                            <td style="width:10%">
                                                <input type="text" class="form-control" id="fixprice" name="fixprice" value="0">
                                            </td>
                                            <td style="width:10%">
                                                <button type="button" class="btn btn-block btn-success" id="AddPrizeButton">Add</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success pull-left" data-dismiss="modal">Batal</button>
                        <button type="button" id="btnSave" onclick="save_data()" class="btn btn-danger pull-right">Simpan</button>
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

    $('#datepicker').datepicker({
        autoclose: true,
        startDate: new Date()
    }).on('changeDate', function() {
        $('#datepicker2').datepicker('setStartDate', new Date($(this).val()));
    });

    $('#datepicker2').datepicker({
        autoclose: true,
        startDate: new Date()
    }).on('changeDate', function() {
        $('#datepicker').datepicker('setEndDate', new Date($(this).val()));
    });

    $("#BundlingTable").DataTable({
        dom: 'Bfrtip',
        lengthMenu: [
            [10, 25, 50, -1],
            ['10 rows', '25 rows', '50 rows', 'Show all']
        ],
        buttons: [
            'pageLength',
            {
                extend: 'excelHtml5',
                title: 'Promo Barang',
                exportOptions: {
                    columns: [0, 1, 2]
                }
            },
            {
                extend: 'pdfHtml5',
                title: 'Promo Barang',
                orientation: 'portrait',
                pageSize: 'A4',
                exportOptions: {
                    columns: [0, 1, 2]
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

    $("tbody#tablepromo").on("click", "#hapus", function() {
        $(this).parent().parent().remove();
    });

    $("tbody#tableprize").on("click", "#hapus", function() {
        $(this).parent().parent().remove();
    });

    $(document).ready(function() {
        $("#promoobject").change(function() {
            var promoobject = $('#promoobject option:selected').val();
            if (promoobject == "1") {
                $('#promogift')
                    .empty()
                    .append('<option value="">Please Choose...</option>')
                    .append('<option value="3">Cashback</option>')
                    .append('<option value="4">Product</option>')

                $("#ObjectTransaction").show();
                $("#ObjectProduct").hide();

                $("#GiftFixPrice").hide();
                $("#GiftDiscount").hide();
                $("#GiftProduct").hide();
            } else if (promoobject == "2") {
                $('#promogift')
                    .empty()
                    .append('<option value="">Please Choose...</option>')
                    .append('<option value="1">Fix Price</option>')
                    .append('<option value="2">Discount</option>')
                    .append('<option value="4">Product</option>')

                $("#ObjectTransaction").hide();
                $("#ObjectProduct").show();

                $("#GiftFixPrice").hide();
                $("#GiftDiscount").hide();
                $("#GiftProduct").hide();
            }
        });

        $("#promogift").change(function() {
            var promogift = $('#promogift option:selected').val();
            if (promogift == "1") {
                $("#GiftFixPrice").show();
                $("#GiftDiscount").hide();
                $("#GiftCashback").hide();
                $("#GiftProduct").hide();
            } else if (promogift == "2") {
                $("#GiftFixPrice").hide();
                $("#GiftDiscount").show();
                $("#GiftCashback").hide();
                $("#GiftProduct").hide();
            } else if (promogift == "3") {
                $("#GiftFixPrice").hide();
                $("#GiftDiscount").hide();
                $("#GiftCashback").show();
                $("#GiftProduct").hide();
            } else if (promogift == "4") {
                $("#GiftFixPrice").hide();
                $("#GiftDiscount").hide();
                $("#GiftCashback").hide();
                $("#GiftProduct").show();
            }
        });

        $("#objectproducttype").change(function() {
            var objectproducttype = $('#objectproducttype option:selected').val();
            if (objectproducttype == "1") {
                $("#ObjectProductSingle").show();
                $("#ObjectProductMulti").hide();
            } else if (objectproducttype == "2") {
                $("#ObjectProductSingle").hide();
                $("#ObjectProductMulti").show();
            }
        });

        $("#giftproducttype").change(function() {
            var giftproducttype = $('#giftproducttype option:selected').val();
            if (giftproducttype == "1") {
                $("#GiftProductSingle").show();
                $("#GiftProductMulti").hide();
            } else if (giftproducttype == "2") {
                $("#GiftProductSingle").hide();
                $("#GiftProductMulti").show();
            }
        });

        $("#promogift").change(function() {
            get_member();
        });

        $('#AddPromoButton').click(function(e) {
            e.preventDefault();
            var remarkpromo = $("#remarkpromo option:selected").val();
            var itemidpromo = $("#itempromo option:selected").val();
            var itemnamepromo = $("#itempromo option:selected").text();
            var qtypromo = $("#qtypromo").val();

            if (itemidpromo == "0") {
                alert("Please Choose Product first");
            } else if (qtypromo <= "0") {
                alert("Qty product cannot 0");
            } else {
                var items = "";
                items += "<tr>";
                items += "<td style='width:10%'><input type='hidden' name='listpromo[remarkpromo][]' value='" + remarkpromo + "'>" + remarkpromo + "</td>";
                items += "<td style='width:35%'><input type='hidden' name='listpromo[itemidpromo][]' value='" + itemidpromo + "'>" + itemnamepromo + "</td>";
                items += "<td style='width:10%'><input type='hidden' name='listpromo[qtypromo][]' value='" + qtypromo + "'>" + qtypromo + "</td>";
                items += "<td style='width:5%'><a href='javascript:void(0);' id='hapus'>Remove</a></td>";
                items += "</tr>";

                $("#tablepromo").append(items);
                $("#itempromo option:selected").remove();
                $("#remarkpromo").val("").change();
                $("#itempromo").val("0").change();
                $("#qtypromo").val("0");
            }
        });

        $('#AddPrizeButton').click(function(e) {
            e.preventDefault();
            var remarkprize = $("#remarkprize option:selected").val();
            var itemidprize = $("#itemprize option:selected").val();
            var itemnameprize = $("#itemprize option:selected").text();
            var qtyprize = $("#qtyprize").val();
            var discpercent = $("#discpercent").val();
            var discamount = $("#discamount").val();
            var fixprice = $("#fixprice").val();

            if ((discpercent <= 0) && (discamount <= 0) && (fixprice <= 0)) {
                alert("Please Set Promo");
            } else {
                var items = "";
                items += "<tr>";
                items += "<td style='width:10%'><input type='hidden' name='listprize[remarkprize][]' value='" + remarkprize + "'>" + remarkprize + "</td>";
                items += "<td style='width:25%'><input type='hidden' name='listprize[itemidprize][]' value='" + itemidprize + "'>" + itemnameprize + "</td>";
                items += "<td style='width:10%'><input type='hidden' name='listprize[qtyprize][]' value='" + qtyprize + "'>" + qtyprize + "</td>";
                items += "<td style='width:10%'><input type='hidden' name='listprize[discpercent][]' value='" + discpercent + "'>" + discpercent + "</td>";
                items += "<td style='width:10%'><input type='hidden' name='listprize[discamount][]' value='" + discamount + "'>" + discamount + "</td>";
                items += "<td style='width:10%'><input type='hidden' name='listprize[fixprice][]' value='" + fixprice + "'>" + fixprice + "</td>";
                items += "<td style='width:5%'><a href='javascript:void(0);' id='hapus'>Remove</a></td>";
                items += "</tr>";

                $("#tableprize").append(items);
                $("#itemprize option:selected").remove();
                $("#remarkprize").val("").change();
                $("#itemprize").val("0").change();
                $("#qtyprize").val("0");
                $("#discpercent").val("0");
                $("#discamount").val("0");
                $("#fixprice").val("0");
            }
        });
    });

    function add_data() {
        $('#formtype').val("add");
        $('#form')[0].reset(); // reset form on modals

        $('#branchid').val(0).change();

        $('#branchid').attr('disabled', false); //set button disable 

        $('#FormModal').modal('show'); // show bootstrap modal
        $('.modal-title').text('Tambah Data Bundling'); // Set Title to Bootstrap modal title
    }

    function view_data(promoid) {
        $('#formtype').val("edit");

        //Ajax Load data from ajax
        $.ajax({
            type: "POST",
            dataType: "JSON",
            url: "<?php echo site_url() ?>master/promo/ajax_view",
            data: {
                id: promoid
            },
            success: function(data) {
                $('#promoid').val(promoid);
                $('#branchid').val(data.branch_id).change();
                $('#itemid').val(data.item_id).change();
                $('#datepicker').val(data.start_period);
                $('#datepicker2').val(data.end_period);
                $('#discpercentage').val(data.disc_percentage);
                $('#discamount').val(data.disc_amount);

                $('#branchid').attr('disabled', true); //set button disable 
                $('#itemid').attr('disabled', true); //set button disable 
                $('#datepicker').attr('disabled', true); //set button disable 
                $('#datepicker2').attr('disabled', true); //set button disable 
                $('#discpercentage').attr('disabled', true); //set button disable 
                $('#discamount').attr('disabled', true); //set button disable 

                $('#FormModal').modal('show'); // show bootstrap modal
                $('.modal-title').text('Lihat Data Harga Barang'); // Set Title to Bootstrap modal title
            },
            error: function() {
                alert('Failed Lookup Data');
            }
        });
    }

    function edit_data(promoid) {
        $('#formtype').val("edit");

        //Ajax Load data from ajax
        $.ajax({
            type: "POST",
            dataType: "JSON",
            url: "<?php echo site_url() ?>master/promo/ajax_view",
            data: {
                id: promoid
            },
            success: function(data) {
                $('#promoid').val(promoid);
                $('#branchid').val(data.branch_id).change();
                $('#itemid').val(data.item_id).change();
                $('#datepicker').val(data.start_period);
                $('#datepicker2').val(data.end_period);
                $('#discpercentage').val(data.disc_percentage);
                $('#discamount').val(data.disc_amount);

                $('#branchid').attr('disabled', true); //set button disable 
                $('#itemid').attr('disabled', true); //set button disable 
                $('#datepicker').attr('disabled', true); //set button disable 
                $('#datepicker2').attr('disabled', false); //set button disable 
                $('#discpercentage').attr('disabled', true); //set button disable 
                $('#discamount').attr('disabled', true); //set button disable 

                $('#FormModal').modal('show'); // show bootstrap modal
                $('.modal-title').text('Ubah Data Harga Barang'); // Set Title to Bootstrap modal title
            },
            error: function() {
                alert('Failed Lookup Data');
            }
        });
    }

    function save_data() {
        var itemid = $('#itemid').val();
        var startperiod = $('#datepicker').val();
        var endperiod = $('#datepicker2').val();
        var discpercentage = parseFloat($('#discpercentage').val());
        var discamount = parseFloat($('#discamount').val());

        var isvalid = true;
        if ((discpercentage != 0) && (discamount != 0)) {
            alert("Disc Percentage and Amount cannot 0");
            isvalid = false;
        }
        if ((discpercentage != 0) && (discamount != 0)) {
            alert("Disc Percentage and Amount cannot be set together");
            isvalid = false;
        }
        if ((discpercentage < 0) && (discpercentage > 0)) {
            alert("Disc Percentage out of range");
            isvalid = false;
        }
        if (discamount < 0) {
            alert("Disc Amount cannot less than 0");
            isvalid = false;
        }

        if (isvalid) {
            $('#btnSave').text('saving...'); //change button text
            $('#btnSave').attr('disabled', true); //set button disable 
            var url;
            var formtype = $('#formtype').val();

            if (formtype == 'add') {
                url = "<?php echo site_url() ?>master/promo/ajax_add";
            } else {
                url = "<?php echo site_url() ?>master/promo/ajax_update";
            }

            $('#formtype').val("");
            var frm = $('#form');
            // ajax adding data to database
            var frmData = new FormData(frm[0]);
            $.ajax({
                url: url,
                type: "POST",
                data: frmData,
                contentType: false,
                processData: false,
                dataType: "JSON",
                success: function(data) {
                    if (data.status) //if success close modal and reload ajax table
                    {
                        Swal.fire({
                            icon: 'success',
                            title: "Notifikasi",
                            text: data.message,
                        }).then(() => {
                            location.reload();
                        })
                    } else {
                        Swal.fire({
                            icon: 'warning',
                            text: data.message,
                            type: "warning"
                        })
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    $('#btnSave').text('save');
                    $('#btnSave').attr('disabled', false);
                    Swal.fire({
                        icon: 'warning',
                        title: "Peringatan",
                        text: "Gagal Memproses Data",
                    })
                }
            });
        }
    }

    function delete_data(itemid) {
        Swal.fire({
            icon: 'warning',
            title: "Hapus Data",
            text: "Apa anda yakin menghapus data ini?",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Hapus",
            cancelButtonText: "Batal",
            closeOnConfirm: false,
            closeOnCancel: false
        }).then(e => {
            if (e.isConfirm) {
                $.ajax({
                    type: "POST",
                    dataType: "JSON",
                    url: "<?php echo site_url() ?>master/promo/ajax_delete",
                    data: {
                        id: itemid
                    },
                    success: function(data) {
                        Swal.fire({
                            icon: 'success',
                            title: "Notifikasi",
                            text: data.message,
                        }).then(() => {
                            location.reload();
                        })
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        Swal.fire({
                            icon: 'warning',
                            title: "Peringatan",
                            text: "Gagal Memproses Data",
                        })
                    }
                });
            }
        })
    }
</script>
<?php
$this->load->view('template/footer');
?>