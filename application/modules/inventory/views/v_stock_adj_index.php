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
            Penyesuaian Stok
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Inventory</a></li>
            <li class="active">Penyesuaian Stok</li>
        </ol>
    </section>

    <section class="content">
        <div class="box box-info">
            <div class="box-header with-border">
                <button onclick="add_data()" class="btn btn-primary bold"><i class="fa fa-plus-circle"></i> Tambah Data</button>
            </div>
            <div class="box-body">
                <table id="StockAdjTable" class="table table-bordered table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>Cabang</th>
                            <th>Tanggal Penyesuaian</th>
                            <th>Jenis Barang</th>
                            <th>Jumlah Penyesuaian</th>
                            <th>Jenis Penyesuaian</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($stockadj->result() as $row) : ?>
                            <tr>
                                <td><?php echo $row->branch_name; ?></td>
                                <td><?php echo date('d M Y H:i:s', strtotime($row->adj_date)); ?></td>
                                <td><?php echo $row->item_name; ?></td>
                                <td><?php echo $row->adj_number; ?></td>
                                <td><?php echo $row->stradj_type; ?></td>
                                <td>
                                    <button class="btn btn-sm btn-success bold" onclick="view_data(<?php echo $row->stock_adj_id; ?>)"><i class="fa fa-file-text-o"></i></button>
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
                    <h4 class="modal-title" style="text-align:center;"><strong>Penjualan Form</strong></h4>
                </div>
                <form action="#" id="form" class="form-horizontal">
                    <div class="modal-body">
                        <input type="hidden" id="formtype" name="formtype" value="">
                        <input type="hidden" id="stockadjid" name="stockadjid" value="0">

                        <div class="form-group">
                            <label class="col-sm-4 control-label">Cabang</label>
                            <div class="col-sm-6">
                                <select class="form-control select2" id="branchid" name="branchid" style="width: 100%;">
                                    <option value='0' selected>Silahkan Pilih</option>
                                    <?php foreach ($branch->result() as $row) : ?>
                                        <?php echo "<option value='" . $row->branch_id . "'>(" . $row->branch_code . ") " . $row->branch_name . "</option>"; ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Jenis Barang</label>
                            <div class="col-sm-6">
                                <select class="form-control select2" id="itemid" name="itemid" style="width: 100%;">
                                    <option value='0' selected>Silahkan Pilih</option>
                                    <?php foreach ($item->result() as $row) : ?>
                                        <?php echo "<option value='" . $row->item_id . "'>(" . $row->barcode . ") " . $row->item_name . "</option>"; ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Jumlah Penyesuaian</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="adjqty" name="adjqty">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Jenis Penyesuaian</label>
                            <div class="col-sm-6">
                                <select class="form-control select2" id="adjtype" name="adjtype" style="width: 100%;">
                                    <option value='0' selected>Silahkan Pilih</option>
                                    <option value='1'>Penambahan</option>
                                    <option value='2'>Pengurangan</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Informasi</label>
                            <div class="col-sm-6">
                                <textarea style="width:100%" rows="4" id="description" name="description"></textarea>
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

    $("#StockAdjTable").DataTable({
        dom: 'Bfrtip',
        lengthMenu: [
            [10, 25, 50, -1],
            ['10 rows', '25 rows', '50 rows', 'Show all']
        ],
        buttons: [
            'pageLength',
            {
                extend: 'excelHtml5',
                title: 'Stok Masuk',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4]
                }
            },
            {
                extend: 'pdfHtml5',
                title: 'Stok Masuk',
                orientation: 'portrait',
                pageSize: 'A4',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4]
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

    function add_data() {
        $('#formtype').val("add");
        $('#form')[0].reset(); // reset form on modals

        $("#branchid").val(0).change();
        $("#itemid").val(0).change();

        $('#branchid').attr('disabled', false); //set button disable 
        $('#itemid').attr('disabled', false); //set button disable 
        $('#adjqty').attr('disabled', false); //set button disable 
        $('#adjtype').attr('disabled', false); //set button disable 
        $('#description').attr('disabled', false); //set button disable 

        $('#FormModal').modal('show'); // show bootstrap modal
        $('.modal-title').text('Tambah Data Penyesuaian Stok'); // Set Title to Bootstrap modal title
    }

    function view_data(stockadjid) {
        $('#formtype').val("view");

        //Ajax Load data from ajax
        $.ajax({
            type: "POST",
            dataType: "JSON",
            url: "<?php echo site_url() ?>inventory/stock_adj/ajax_view",
            data: {
                id: stockadjid
            },
            success: function(data) {
                $('#stockadjid').val(stockadjid);
                $('#branchid').val(data.branch_id).change();
                $('#itemid').val(data.item_id).change();
                $('#adjqty').val(data.adj_number);
                $('#adjtype').val(data.adj_type);
                $('#description').val(data.description);

                $('#branchid').attr('disabled', true); //set button disable 
                $('#itemid').attr('disabled', true); //set button disable 
                $('#adjqty').attr('disabled', true); //set button disable 
                $('#adjtype').attr('disabled', true); //set button disable 
                $('#description').attr('disabled', true); //set button disable 

                $('#FormModal').modal('show'); // show bootstrap modal
                $('.modal-title').text('Lihat Data Penyesuaian Stok'); // Set Title to Bootstrap modal title
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

    function save_data() {
        var branchid = $('#branchid option:selected').val();
        var itemid = $('#itemid option:selected').val();
        var adjtype = $('#adjtype option:selected').val();
        var isSave = true;

        if (branchid == 0) {
            isSave = false;
            Swal.fire({
                icon: 'warning',
                title: "Peringatan",
                text: "Silahkan pilih cabang terlebih dahulu",
            })
        } else if (itemid == 0) {
            isSave = false;
            Swal.fire({
                icon: 'warning',
                title: "Peringatan",
                text: "Silahkan pilih jenis barang terlebih dahulu",
            })
        } else if (adjtype == 0) {
            isSave = false;
            Swal.fire({
                icon: 'warning',
                title: "Peringatan",
                text: "Silahkan pilih jenis penyesuaian terlebih dahulu",
            })
        }

        if (isSave) {
            $('#btnSave').text('saving...'); //change button text
            $('#btnSave').attr('disabled', true); //set button disable 
            var url;
            var formtype = $('#formtype').val();

            if (formtype == 'add') {
                url = "<?php echo site_url() ?>inventory/stock_adj/ajax_add";
            } else {
                url = "<?php echo site_url() ?>inventory/stock_adj/ajax_update";
            }

            $('#formtype').val("");
            var frm = $('#form');
            // ajax adding data to database
            $.ajax({
                url: url,
                type: "POST",
                data: frm.serialize(),
                dataType: "JSON",
                success: function(data) {
                    console.log(data);
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
                            title: "Notifikasi",
                            text: data.message,
                        })
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    $('#btnSave').text('save');
                    $('#btnSave').attr('disabled', false);
                    Swal.fire({
                        icon: 'warning',
                        title: "Notifikasi",
                        text: "Gagal Memproses Data",
                    })
                }
            });
        }
    }
</script>
<?php
$this->load->view('template/footer');
?>