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
            header("Content-Disposition: attachment; filename=RangkumanRekapBarang.xls");

            $table = '<table>
                    <tr>
                        <th colspan="7" style="text-align:center;">Rekap Barang</td>
                    </tr>
                    <tr>
                        <th colspan="7" style="text-align:center;">Periode : ' . $header->startperiod . ' - ' . $header->endperiod . '</td>
                    </tr>
                    <tr>
                        <td colspan="7" style="text-align:center;">&nbsp;</td>
                    </tr>
                    <thead>
                        <tr>
                            <th style="width:5%; text-align:center;">No</th>
                            <th style="width:15%; text-align:center;">Kode Cabang</th>
                            <th style="width:40%; text-align:center;">Nama Cabang</th>
                            <th style="width:10%; text-align:center;">Jumlah Awal</th>
                            <th style="width:10%; text-align:center;">Jumlah Masuk</th>
                            <th style="width:10%; text-align:center;">Jumlah Keluar</th>
                            <th style="width:10%; text-align:center;">Jumlah Tersisa</th>
                        </tr>
                    </thead>
                    <tbody>';

            $i = 1;
            $itemcodeold = 'xx';
            $itemcodenew = '';

            $totalbeginingqty = 0;
            $totalstockin = 0;
            $totalstockout = 0;
            $totaltotalqty = 0;

            foreach($report->result() as $row) :
                $itemcodenew = $row->item_code;
                
                if($itemcodeold != $itemcodenew){
                    $i = 1;

                    if($itemcodeold != 'xx'){
                        $table .= '<tr>
                            <td style="text-align:right;" colspan="3"><strong>Total : </strong></td>
                            <td style="text-align:center;">' . $totalbeginingqty . '</strong></td>
                            <td style="text-align:center;">' . $totalstockin . '</strong></td>
                            <td style="text-align:center;">' . $totalstockout . '</strong></td>
                            <td style="text-align:center;">' . $totaltotalqty . '</strong></td>
                            </tr>';

                        $totalbeginingqty = 0;
                        $totalstockin = 0;
                        $totalstockout = 0;
                        $totaltotalqty = 0;
                    }
                    
                    $table .= '<tr>
                        <td style="text-align:left;" colspan="7"><strong>Kategori Barang : ' . $row->stock_category_name . ' / Jenis Barang : (' . $row->barcode . ') ' . $row->item_name . '</strong></td>
                        </tr>';

                }
                
                $table .= '<tr>
                    <td style="text-align:center;">' . $i . '</td>
                    <td style="text-align:center;">' . $row->branch_code . '</td>
                    <td style="text-align:left;">' . $row->branch_name . '</td>
                    <td style="text-align:center;">' . $row->begining_qty . '</td>
                    <td style="text-align:center;">' . $row->stock_in . '</td>
                    <td style="text-align:center;">' . $row->stock_out . '</td>
                    <td style="text-align:center;">' . $row->total_qty . '</td>
                </tr>';
                
                $totalbeginingqty = $totalbeginingqty + $row->begining_qty;
                $totalstockin = $totalstockin + $row->stock_in;
                $totalstockout = $totalstockout + $row->stock_out;
                $totaltotalqty = $totaltotalqty + $row->total_qty;
                        
                $itemcodeold = $itemcodenew;
                $i = $i + 1;
            endforeach;

            $table .= '<tr>
                <td style="text-align:right;" colspan="3"><strong>Total : </strong></td>
                <td style="text-align:center;">' . $totalbeginingqty . '</strong></td>
                <td style="text-align:center;">' . $totalstockin . '</strong></td>
                <td style="text-align:center;">' . $totalstockout . '</strong></td>
                <td style="text-align:center;">' . $totaltotalqty . '</strong></td>
                </tr>';

            $table .= '</tbody>
                </table>';

            echo $table;

        ?>
    </body>
</html>