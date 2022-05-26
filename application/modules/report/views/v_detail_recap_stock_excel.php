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
            header("Content-Disposition: attachment; filename=DetailRekapBarang.xls");

            $table = '<table>
                    <tr>
                        <th colspan="7" style="text-align:center;">Detail Rekap Barang</td>
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
                            <th style="width:25%; text-align:center;">Tanggal</th>
                            <th style="width:25%; text-align:center;">Jenis Transaksi</th>
                            <th style="width:25%; text-align:center;">Nomor Dokumen</th>
                            <th style="width:20%; text-align:center;">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>';

            $i = 1;
            $totalqty = 0;
            $itemold = 'xx';
            $itemnew = '';

            foreach($report->result() as $row) :

                $itemnew = $row->item_code;

                if($itemold != $itemnew){
                    $i = 1;
                    
                    if($itemold != 'xx'){
                        $table .= '<tr>
                        <td style="text-align:right;" colspan="4"><strong>Total : </strong></td>
                        <td style="text-align:center;"><strong>' . $totalqty . '</td>
                        </tr>
                        <tr><td colspan="5"></td></tr>';
                    }

                    $totalqty = 0;
                    
                    $table .= '<tr>
                    <td style="text-align:left;" colspan="5"><strong>Cabang : (' . $row->branch_code . ') ' . $row->branch_name . ' | Barang : (' . $row->item_code . ') ' . $row->item_name . '</strong></td>
                    </tr>';
                }
                
                $table .= '<tr>
                    <td style="text-align:center;">' . $i . '</td>
                    <td style="text-align:center;">' . $row->created_date . '</td>
                    <td style="text-align:center;">' . $row->trans_type . '</td>
                    <td style="text-align:center;">' . $row->doc_number . '</td>
                    <td style="text-align:center;">' . $row->qty . '</td>
                </tr>';

                $totalqty = $totalqty + $row->qty;
                $itemold = $itemnew;
                $i = $i + 1;

            endforeach;

            $table .= '<tr>
                    <td style="text-align:right;" colspan="4"><strong>Total : </strong></td>
                    <td style="text-align:center;"><strong>' . $totalqty . '</td>
                    </tr>
                    <tr><td colspan="5"></td></tr>';

            echo $table;

        ?>
    </body>
</html>