<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>POS Apps</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- Bootstrap 3.3.2 -->
        <link href="<?php echo base_url('assets/adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css') ?>" rel="stylesheet" type="text/css" />
        <style type="text/css" media="print">
            @page { 
                size: landscape;
            }
        </style>
    </head>
    <body onload="window.print();">
        <p style="text-align:center;">
            <label style="font-size:24px; display:block; width:x; height:y;">Detail Rekap Barang</label>
            <label style="display:block; width:x; height:y;">Period : <?php echo $header->startperiod; ?> - <?php echo $header->endperiod; ?></label>
        </p>
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
            <tbody>
                <?php $i = 1; ?>
                <?php $itemnew = ""; ?>
                <?php $itemold = "xx"; ?>
                <?php $totalqty = 0; ?>
                <?php foreach($report->result() as $row) :?>
                    <?php $itemnew = $row->item_code; ?>

                    <?php if($itemnew != $itemold){ ?>
                        <?php $i = 1; ?>
                        <?php if($itemold != "xx"){ ?>
                            <tr>
                                <td style="text-align:right;" colspan="4"><strong>Total : </strong></td>
                                <td style="text-align:center;"><strong><?php echo intval($totalqty) ?></strong></td>
                            </tr>
                            <tr><td colspan="5"></td></tr>
                        <?php } ?>

                        <?php $totalqty = 0; ?>

                        <tr>
                            <td style="text-align:left;" colspan="5"><strong>Cabang : (<?php echo $row->branch_code; ?>) <?php echo $row->branch_name; ?> | Barang : (<?php echo $row->item_code; ?>) <?php echo $row->item_name; ?></strong></td>
                        </tr>
                    <?php } ?>

                    <tr>
                        <td style="text-align:center;"><?php echo $i ?></td>
                        <td style="text-align:center;"><?php echo $row->created_date; ?></td>
                        <td style="text-align:center;"><?php echo $row->trans_type; ?></td>
                        <td style="text-align:center;"><?php echo $row->doc_number; ?></td>
                        <td style="text-align:center;"><?php echo $row->qty; ?></td>
                    </tr>

                    <?php $totalqty = intval($totalqty) + intval($row->qty); ?>
                    <?php $itemold = $itemnew; ?>
                    <?php $i = $i + 1; ?>
                <?php endforeach; ?>
                <tr>
                    <td style="text-align:right;" colspan="4"><strong>Total : </strong></td>
                    <td style="text-align:center;"><strong><?php echo intval($totalqty) ?></strong></td>
                </tr>
            </tbody>
        </table>
    </body>
</html>