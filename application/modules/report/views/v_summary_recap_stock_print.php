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
            <label style="font-size:24px; display:block; width:x; height:y;">Rekap Barang</label>
            <label style="display:block; width:x; height:y;">Period : <?php echo $header->startperiod; ?> - <?php echo $header->endperiod; ?></label>
        </p>
        <table class="table table-bordered">
            <thead>
                <tr style="background-color:#99c0ff; color:white;">
                    <th style="width:5%; text-align:center;">No</th>
                    <th style="width:15%; text-align:center;">Kode Cabang</th>
                    <th style="width:40%; text-align:center;">Nama Cabang</th>
                    <th style="width:10%; text-align:center;">Jumlah Awal</th>
                    <th style="width:10%; text-align:center;">Jumlah Masuk</th>
                    <th style="width:10%; text-align:center;">Jumlah Keluar</th>
                    <th style="width:10%; text-align:center;">Jumlah Tersisa</th>
                </tr>
            </thead>
            <tbody>

                <?php $i = 1; ?>
                
                <?php $itemcodeold = 'xx'; ?>
                <?php $itemcodenew = ''; ?>

                <?php $totalbeginingqty = 0; ?>
                <?php $totalstockin = 0; ?>
                <?php $totalstockout = 0; ?>
                <?php $totaltotalqty = 0; ?>

                <?php foreach($report->result() as $row) :?>

                    <?php $itemcodenew = $row->item_code; ?>

                    <?php if($itemcodeold != $itemcodenew){ ?>
                        <?php $i = 1; ?>

                        <?php if($itemcodeold != 'xx'){ ?>
                            <tr>
                                <td style="text-align:right;" colspan="3"><strong>Total : </strong></td>
                                <td style="text-align:center;"><?php echo $totalbeginingqty ?></strong></td>
                                <td style="text-align:center;"><?php echo $totalstockin ?></strong></td>
                                <td style="text-align:center;"><?php echo $totalstockout ?></strong></td>
                                <td style="text-align:center;"><?php echo $totaltotalqty ?></strong></td>
                            </tr>
                            
                            <?php $totalbeginingqty = 0; ?>
                            <?php $totalstockin = 0; ?>
                            <?php $totalstockout = 0; ?>
                            <?php $totaltotalqty = 0; ?>
                        <?php } ?>
                        
                        <tr>
                            <td style="text-align:left;" colspan="7"><strong>Kategori Barang : <?php echo $row->stock_category_name ?> / Jenis Barang : (<?php echo $row->barcode ?>) <?php echo $row->item_name ?></strong></td>
                        </tr>

                    <?php } ?>
						
                    <tr>
                        <td style="text-align:center;"><?php echo $i ?></td>
                        <td style="text-align:center;"><?php echo $row->branch_code; ?></td>
                        <td style="text-align:left;"><?php echo $row->branch_name; ?></td>
                        <td style="text-align:center;"><?php echo $row->begining_qty; ?></td>
                        <td style="text-align:center;"><?php echo $row->stock_in; ?></td>
                        <td style="text-align:center;"><?php echo $row->stock_out; ?></td>
                        <td style="text-align:center;"><?php echo $row->total_qty; ?></td>
                    </tr>

                    <?php $totalbeginingqty = $totalbeginingqty + $row->begining_qty; ?>
                    <?php $totalstockin = $totalstockin + $row->stock_in; ?>
                    <?php $totalstockout = $totalstockout + $row->stock_out; ?>
                    <?php $totaltotalqty = $totaltotalqty + $row->total_qty; ?>
                            
                    <?php $itemcodeold = $itemcodenew; ?>

                    <?php $i = $i + 1; ?>

                <?php endforeach; ?>

                    <tr>
                        <td style="text-align:right;" colspan="3"><strong>Total : </strong></td>
                        <td style="text-align:center;"><?php echo $totalbeginingqty ?></strong></td>
                        <td style="text-align:center;"><?php echo $totalstockin ?></strong></td>
                        <td style="text-align:center;"><?php echo $totalstockout ?></strong></td>
                        <td style="text-align:center;"><?php echo $totaltotalqty ?></strong></td>
                    </tr>
            </tbody>
        </table>
    </body>
</html>