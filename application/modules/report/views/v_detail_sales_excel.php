<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>POS Apps</title>
    <link href="<?php echo base_url('assets/adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css') ?>" rel="stylesheet" type="text/css" />
</head>

<body>
    <?php
    header("Content-type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename=DetailPenjualan.xls");
    ?>
    <table style="width: 100%;">
        <thead>
            <tr>
                <th colspan="6" style="text-align:center;">Detail Penjualan</th>
            </tr>
            <tr>
                <th colspan="6" style="text-align:center;">Periode : <?= $header->startperiod; ?> - <?= $header->endperiod; ?></th>
            </tr>
            <tr>
                <!-- <th colspan="6" style="text-align:left;">Grand Total Transaksi: <?= $report['grand_total_transaksi']; ?></th> -->
                <th colspan="6" style="text-align:left;">Grand Total Transaksi: <?= (int)$report['grand_total_transaksi_unformated']; ?></th>
            </tr>
            <tr>
                <!-- <th colspan="6" style="text-align:left;">Grand Total Diskon: <?= $report['grand_total_diskon']; ?></th> -->
                <th colspan="6" style="text-align:left;">Grand Total Diskon: <?= (int)$report['grand_total_diskon_unformated']; ?></th>
            </tr>
            <tr>
                <!-- <th colspan="6" style="text-align:left;">Grand Total Penjualan: <?= $report['grand_total_penjualan']; ?></th> -->
                <th colspan="6" style="text-align:left;">Grand Total Penjualan: <?= (int)$report['grand_total_penjualan_unformated']; ?></th>
            </tr>
            <tr>
                <td colspan="6" style="text-align:center;">&nbsp;</td>
            </tr>
            <tr>
                <th style="width:5%; text-align:center;">No</th>
                <th style="width:55%; text-align:center;">Barang</th>
                <th style="width:10%; text-align:right;">Harga</th>
                <th style="width:10%; text-align:right;">Diskon</th>
                <th style="width:10%; text-align:right;">Jumlah</th>
                <th style="width:10%; text-align:right;">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($report['data'] as $key) { ?>
                <tr>
                    <th colspan="6" style="text-align:left;">
                        Tanggal Penjualan: <?= $key['tanggal_penjualan']; ?> / Nomor Penjualan: <?= $key['nomor_penjualan']; ?> / Cabang: <small>(<?= $key['kode_cabang']; ?>)</small> <?= $key['nama_cabang']; ?> / Kasir: <?= $key['nama_kasir']; ?>
                    </th>
                </tr>
                <?php
                if (count($key['product']) > 0) {
                    $i = 1;
                ?>
                    <?php foreach ($key['product'] as $p) { ?>
                        <tr>
                            <td style="text-align:center;"><?= $i++; ?></td>
                            <td style="text-align:left;"><small>(<?= $p['item_code']; ?>)</small> <?= $p['item_name']; ?></th>
                                <!-- <td style="text-align:right;"><?= $p['price']; ?></td> -->
                            <td style="text-align:right;"><?= $p['price_unformated']; ?></td>
                            <!-- <td style="text-align:right;"><?= $p['disc']; ?></th> -->
                            <td style="text-align:right;"><?= $p['disc_unformated']; ?></th>
                                <!-- <td style="text-align:right;"><?= $p['qty']; ?></th> -->
                            <td style="text-align:right;"><?= $p['qty_unformated']; ?></th>
                                <!-- <td style="text-align:right;"><?= $p['subtotal']; ?></td> -->
                            <td style="text-align:right;"><?= $p['subtotal_unformated']; ?></td>
                        </tr>
                    <?php } ?>
                <?php } ?>
                <tr>
                    <th colspan="5" style="text-align:right;">
                        Total Transaksi:
                    </th>
                    <th style="text-align:right;">
                        <!-- <?= $key['total_transaksi']; ?> -->
                        <?= $key['total_transaksi_unformated']; ?>
                    </th>
                </tr>
                <tr>
                    <th colspan="5" style="text-align:right;">
                        Total Disc:
                    </th>
                    <th style="text-align:right;">
                        <!-- <?= $key['total_diskon']; ?> -->
                        <?= $key['total_diskon_unformated']; ?>
                    </th>
                </tr>
                <tr>
                    <th colspan="5" style="text-align:right;">
                        Total Penjualan:
                    </th>
                    <th style="text-align:right;">
                        <!-- <?= $key['total_penjualan']; ?> -->
                        <?= $key['total_penjualan_unformated']; ?>
                    </th>
                </tr>
                <tr>
                    <td colspan="6" style="text-align:center;">&nbsp;</td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>

</html>