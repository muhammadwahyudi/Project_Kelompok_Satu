<?php
// Fungsi header dengan mengirimkan raw data excel
header("Content-type: application/vnd-ms-excel");
 
// Mendefinisikan nama file ekspor "hasil-export.xls"
header("Content-Disposition: attachment; filename=data-report.xls");
 
// Tambahkan table
session_start();
include "auth.php";
$root = filter_input(INPUT_SERVER, "Root", FILTER_SANITIZE_URL);
$control = filter_input(INPUT_SERVER, "BaseControl", FILTER_SANITIZE_URL);
require_once $root . 'model/database_model.php';
//include controler
include $control . 'mail.php';
//obj
$o_mail = new MailControl();
$result = $o_mail->select_mail();
?>
<html>
    <head>
        <title>Export</title>
    </head>
    <body>
        <table>
            <th>
            <td>
                
            </td>
            </th>
        </table>
    </body>
</html>