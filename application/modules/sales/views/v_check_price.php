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

    <form id="frmSales" class="form-horizontal" action="#">

        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Cek Harga
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="#">Transaction</a></li>
                <li class="active">Cek Harga</li>
            </ol>
        </section>

        <section class="content">
            <div class="box box-solid">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Jenis Barang</label>
                                <div class="col-sm-9">
                                    <select class="form-control select2" id="itemid" name="itemid" style="width: 100%;">
                                        <option value='0' selected>Silahkan Pilih</option>
                                        <?php foreach ($item->result() as $row) : ?>
                                            <?php echo "<option value='" . $row->item_id . "'>(" . $row->barcode . ") " . $row->item_name . "</option>"; ?>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label"></label>
                                <div class="col-sm-10">
                                    <button type="button" id="btnReset" class="btn btn-success btn-flat">Reset</button>
                                    <button type="button" id="btnSearchPrice" class="btn btn-danger btn-flat">Cek Harga</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="searchpriceresult">
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Mulai Berlaku</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" id="searchstartdate" name="searchstartdate" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Harga Penjualan</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" id="searchsellingprice" name="searchsellingprice" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </form>

    <div class="clearfix"></div>

</div>

<?php
$this->load->view('template/js');
?>
<script type="text/javascript">
    //Initialize Select2 Elements
    $(".select2").select2();

    $(document).ready(function() {

        $('#btnReset').click(function() {
            $("#itemid").val(0).change();
            $("#searchstartdate").val('');
            $("#searchsellingprice").val('');
        });

        $('#btnSearchPrice').click(function() {
            search_price();
        });

    });

    function search_price() {
        var itemid = $("#itemid option:selected").val();
        console.log(itemid);
        $.ajax({
            type: 'POST',
            dataType: 'JSON',
            url: '<?php echo site_url() ?>sales/check_price/search_price',
            data: {
                itemid: itemid
            },
            success: function(data) {

                if (data.start_period != '') {
                    $("#searchstartdate").val(data.start_period);
                    $("#searchsellingprice").val(thousandmaker(data.selling_price));
                } else {
                    $("#searchstartdate").val('');
                    $("#searchsellingprice").val('');
                    Swal.fire({
                        icon: 'warning',
                        title: "Peringatan",
                        text: "Data Harga Barang tidak ditemukan. Silahkan Cek Master Data Harga Barang",
                    })
                }

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