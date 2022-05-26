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
            Stok Barang
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Inventory</a></li>
            <li class="active">Stok Barang</li>
        </ol>
    </section>

    <section class="content">
        <div class="box box-info">
            <div class="box-body">
                <table id="ItemStockTable" class="table table-bordered table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>Nama Cabang</th>
                            <th>Kategori Barang</th>
                            <th>Barcode</th>
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th>Satuan</th>
                            <th>Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($itemstock->result() as $row) : ?>
                            <tr>
                                <td><?php echo $row->branch_name; ?></td>
                                <td><?php echo $row->stock_category_name; ?></td>
                                <td><?php echo $row->barcode; ?></td>
                                <td><?php echo $row->item_code; ?></td>
                                <td><?php echo $row->item_name; ?></td>
                                <td><?php echo $row->unit_name; ?></td>
                                <td><?php echo $row->qty; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </section><!-- /.content -->

</div>

<?php $this->load->view('template/js'); ?>

<script>
    $("#ItemStockTable").DataTable({
        dom: 'Bfrtip',
        lengthMenu: [
            [10, 25, 50, -1],
            ['10 rows', '25 rows', '50 rows', 'Show all']
        ],
        buttons: [
            'pageLength',
            {
                extend: 'excelHtml5',
                title: 'Stock Barang',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6]
                }
            },
            {
                extend: 'pdfHtml5',
                title: 'Stock Barang',
                orientation: 'portrait',
                pageSize: 'A4',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6]
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
</script>

<?php $this->load->view('template/footer'); ?>