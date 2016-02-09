<?php
session_start();
include "auth_2.php";
$root = filter_input(INPUT_SERVER, "Root", FILTER_SANITIZE_URL);
$control = filter_input(INPUT_SERVER, "BaseControl", FILTER_SANITIZE_URL);
require_once $root . 'model/database_model.php';
//include controler
include $control . 'penjualan.php';
include $control . 'transaksi.php';
include $control . 'barang.php';
//obj
$o_penjualan = new penjualanControl();
$o_transaksi = new transaksiControl();
$o_barang = new barangControl();
//$result = $o_penjualan->select_penjualan();

function set_progress($val = 0) {

    $data = "<div class='progress-container' style='display:none'>
            
                <div class='progress'>
                      <div class='progress-bar progress-bar-info progress-bar-striped active' role='progressbar' aria-valuenow='0' aria-valuemin='0' aria-valuemax='100' style='width: " . $val . "%'>
                      </div>
                </div>

            </div>";

    return $data;
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
        <meta name="author" content="Coderthemes">

        <link rel="shortcut icon" href="images/logo.png">

        <title><?php print $_SERVER['Title']; ?></title>

        <!-- Base Css Files -->
        <link href="css/bootstrap.min.css" rel="stylesheet" />

        <!-- Font Icons -->
        <link href="assets/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
        <link href="assets/ionicon/css/ionicons.min.css" rel="stylesheet" />
        <link href="css/material-design-iconic-font.min.css" rel="stylesheet">

        <!-- animate css -->
        <link href="css/animate.css" rel="stylesheet" />

        <!-- Waves-effect -->
        <link href="css/waves-effect.css" rel="stylesheet">
        <!-- Plugins css -->
        <link href="assets/notifications/notification.css" rel="stylesheet" />
        

        <!-- Custom Files -->
        <link href="css/helper.css" rel="stylesheet" type="text/css" />
        <link href="css/style.css" rel="stylesheet" type="text/css" />
        <!-- Plugin Css-->
        <link rel="stylesheet" href="assets/magnific-popup/magnific-popup.css" />
        <link rel="stylesheet" href="assets/jquery-datatables-editable/datatables.css" />


        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->

        <script src="js/modernizr.min.js"></script>
                            <script type="text/javascript">
        var tableToExcel = (function() {
                var uri = 'data:application/vnd.ms-excel;base64,'
        , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'
                                    , base64 = function(s) {
                                    return window.btoa(unescape(encodeURIComponent(s)))
                  }
, format = function(s, c) {
return s.replace(/{(\w+)}/g, function(m, p) {
    return c[p];
})
}
return function(table, name) {
if (!table.nodeType)
    table = document.getElementById(table)
var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}
window.location.href = uri + base64(format(template, ctx))
}
})()
        </script>
    </head>



    <body class="fixed-left">

        <!-- Begin page -->
        <div id="wrapper">

            <?php include "header_menu.php"; ?>



            <?php include "menu_admin.php"; ?>


            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->                      
            <div class="content-page">
                <!-- Start content -->
                <div class="content">
                    <div class="container">

                        <div class="panel">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="m-b-30">
                                            <?php
                                                            $con = mysqli_connect('localhost','root','','db_pergudangan') OR die(mysql_error());
                                                            $query = mysqli_query($con, "SELECT MAX(id) from transaksi");
                                                            $row1 = mysqli_fetch_array($query);
                                                            $max = $row1[0];
                                                            ?>
                                                            <?php
                                                            $con = mysqli_connect('localhost','root','','db_pergudangan') OR die(mysql_error());
                                                            $query = mysqli_query($con, "SELECT * from transaksi where id=$max");
                                                            $row1 = mysqli_fetch_array($query);
                                                            $hasil = $row1[1];
                                                            ?>
                                                            
                                                            
                                            <button class="btn btn-primary waves-effect waves-light" data-id='0' data-toggle="modal" data-target="#tambah-data"><i class="fa fa-plus"></i> Tambah penjualan</button>
                                            <div class="btn btn-primary waves-effect waves-light" data-id='0' data-toggle="modal" data-target=""><i class="fa "></i>transaksi <?php echo $row1[1];?></div>
                                            

                                            <!--<button class="btn btn-pink waves-effect waves-light" data-id='0' data-toggle="modal" data-target="#import"><i class="md md-attach-file"></i> Import File</button>-->
                                            <!--<div class="btn-group">
                                                <button class="btn btn-purple dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bars"></i> Export Data</button>
                                                <ul class="dropdown-menu">
                                                    <li><a href="#" onClick ="$('#datatable-editable').tableExport({type: 'json', escape: 'false'});"><img src='images/icons/json.png' width="24"/> JSON</a></li>
                                                    <li><a href="#" onClick ="$('#datatable-editable').tableExport({type: 'json', escape: 'false', ignoreColumn: '[2,3]'});"><img src='images/icons/json.png' width="24"/> JSON (ignoreColumn)</a></li>
                                                    <li><a href="#" onClick ="$('#datatable-editable').tableExport({type: 'json', escape: 'true'});"><img src='images/icons/json.png' width="24"/> JSON (with Escape)</a></li>
                                                    <li class="divider"></li>
                                                    <li><a href="#" onClick ="$('#datatable-editable').tableExport({type: 'xml', escape: 'false'});"><img src='images/icons/xml.png' width="24"/> XML</a></li>
                                                    <li><a href="#" onClick ="$('#datatable-editable').tableExport({type: 'sql'});"><img src='images/icons/sql.png' width="24"/> SQL</a></li>
                                                    <li class="divider"></li>
                                                    <li><a href="#" onClick ="$('#datatable-editable').tableExport({type: 'csv', escape: 'false'});"><img src='images/icons/csv.png' width="24"/> CSV</a></li>
                                                    <li><a href="#" onClick ="$('#datatable-editable').tableExport({type: 'txt', escape: 'false'});"><img src='images/icons/txt.png' width="24"/> TXT</a></li>
                                                    <li class="divider"></li>
                                                    <li><a href="#" onClick ="$('#datatable-editable').tableExport({type: 'excel', escape: 'false'});"><img src='images/icons/xls.png' width="24"/> XLS</a></li>
                                                    <li><a href="#" onClick ="$('#datatable-editable').tableExport({type: 'doc', escape: 'false'});"><img src='images/icons/word.png' width="24"/> Word</a></li>
                                                    <li><a href="#" onClick ="$('#datatable-editable').tableExport({type: 'powerpoint', escape: 'false'});"><img src='images/icons/ppt.png' width="24"/> PowerPoint</a></li>
                                                    <li class="divider"></li>
                                                    <li><a href="#" onClick ="$('#datatable-editable').tableExport({type: 'png', escape: 'false'});"><img src='images/icons/png.png' width="24"/> PNG</a></li>
                                                    <li><a href="#" onClick ="$('#datatable-editable').tableExport({type: 'pdf', escape: 'false'});"><img src='images/icons/pdf.png' width="24"/> PDF</a></li>
                                                </ul>
                                            </div> -->

                                        </div>
                                    </div>
                                </div>

                                <table class="table table-bordered table-striped" id="datatable-editable">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Kode transaksi</th>
                                            <th>kode barang</th>
                                            <th>jumlah keluar</th>
                                            <th>tanggal keluar</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 0;
                                        
                                            $con = mysqli_connect('localhost','root','','db_pergudangan') OR die(mysql_error());
                                            $ambil = mysqli_query($con, "SELECT * from `penjualan` where kodetransaksi='$hasil'");
                                            
                                            //$max = $row1[0];
                                                            
                                            while ($masuk = mysqli_fetch_array($ambil)) {
                                            $no++;
                                            ?>
                                            <tr class="gradeX">
                                                <td><?php print $no; ?></td>
                                                <td><?php echo $masuk[1]; ?></td>
                                                <td><?php echo $masuk[2]; ?></td>
                                                <td><?php echo $masuk[3]; ?></td>
                                                <td><?php echo $masuk[4]; ?></td>
                                                <td class="actions">                                                
                                                    <a  class="btn btn-xs btn-warning" href="javascript:;"
                                                        data-id="<?php echo $masuk[0]; ?>"
                                                        data-kodetransaksi="<?php echo $masuk[1]; ?>"
                                                        data-kodebarang="<?php echo $masuk[2]; ?>"
                                                        data-jumlahkeluar="<?php echo $masuk[3]; ?>"
                                                        data-tanggalkeluar="<?php echo $masuk[4]; ?>"
                                                        data-toggle="modal" data-target="#edit-data">

                                                        <i class="ion ion-edit"></i> Edit

                                                    </a>
                                                    <a class="btn btn-xs btn-danger" href="javascript:;" data-id="<?php echo $result[$i][0]; ?>" data-toggle="modal" data-target="#modal-konfirmasi"><i class="ion ion-trash-a"></i> Hapus</a>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                                <table align="right"><tr><td><a href="penjualan.php"><button class="btn btn-primary waves-effect waves-light" data-id='0' data-toggle="modal" data-target="penjualan.php"><i class="fa "></i> selesai</button></a></td></tr></table>
                            </div>
                            <!-- end: page -->


                        </div> <!-- end Panel -->

                    </div> <!-- container -->

                </div> <!-- content -->


                <footer class="footer text-right" style="z-index:100000">
                    2015 ©s
                </footer>

            </div>
            <!-- ============================================================== -->
            <!-- End Right content here -->
            <!-- ============================================================== -->


            <!-- Modal tambah data -->
            <div id="tambah-data" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <form id="form-data" method="post" action="../controler/penjualan.php?p=tambah">

                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Tambah Data</h4>
                            </div>

                            <div class="modal-body">

                                <fieldset>

                                    <div class="control-group">
                                        <span class="label label-success">kode transaksi</span>
                                        <!--<div class="controls">
                                            <input type="text" name="kodetransaksi" class="form-control" id="kodetransaksi">
                                        </div>-->
                                        <div class="controls">
                                                        <select name="kodetransaksi" id="kodetransaksi" class="form-control select2" style="width: 100%">
                                                            <!--<option value="0">--Pilih kode--</option>-->
                                                            
                                                                <option value="<?php echo $row1[1]; ?>"><?php echo $row1[1]; ?></option>
                                                            
                                                            
                                                        </select>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="control-group">
                                        <span class="label label-success">kode barang</span>
                                        <!--<div class="controls">
                                            <input type="text" name="kodebarang" class="form-control" name="kodebarang" id="kodebarang">
                                        </div>-->
                                        <div class="controls">
                                                        <select name="kodebarang" id="kodebarang" class="form-control select2" style="width: 100%">
                                                            <!--<option value="0">--Pilih kode--</option>-->.
                                                            <?php
                                                            $result = $o_barang->select_barang();
                                                            for ($i = 0; $i < count($result); $i++) {
                                                                ?> 
                                                                <option value="<?php echo $result[$i][1]; ?>"><?php echo $result[$i][1]; ?></option>
                                                            <?php } ?>
                                                        </select>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="control-group">
                                        <span class="label label-success">jumlah keluar</span>
                                        <div class="controls">
                                            <input type="number" name="jumlahkeluar" class="form-control" id="jumlahkeluar">
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <span class="label label-success">tanggalkeluar</span>
                                        <div class="controls">
                                            <input type="date" name="tanggalkeluar" class="form-control" id="tanggalkeluar">
                                        </div>
                                    </div>

                                </fieldset>

                                <?php echo set_progress(); ?>

                            </div>

                            <div class="modal-footer">
                                <button class="btn btn-info btn-submit"><i class="fa fa-save"></i> Simpan</button>
                                <button class="btn btn-default" data-dismiss="modal"><i class="fa fa-close"></i> Batal</button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>



            <!-- Modal edit data -->
            <div id="edit-data" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <form id="form-data" class="form-edit" method="post" action="../controler/penjualan.php?p=update">

                            <input type="hidden" name="id" id="id">

                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Edit Data</h4>
                            </div>

                            <div class="modal-body">

                                <fieldset>
                                    <!--<div class="control-group">
                                        <span class="label label-success">kode transaksi</span>
                                        <!--<div class="controls">
                                            <input type="text" name="kodetransaksi" class="form-control" id="kodetransaksi">
                                        </div>
                                        <div class="controls">
                                                        <select name="kodetransaksi" id="kodetransaksi" class="form-control select2" style="width: 100%">
                                                            <option value="0">--Pilih kode--</option>
                                                            <?php
                                                            //$transaksi = $o_transaksi->select_transaksi();
                                                            //for ($i = 0; $i < //count($transaksi); $i++) {
                                                                ?> 
                                                                <option value="<?php //echo $transaksi[$i][1]; ?>"><?php //echo $transaksi[$i][1]; ?></option>
                                                            //<?php //} ?>
                                                        </select>
                                        </div>
                                    </div>-->
                                    <br>
                                    <div class="control-group">
                                        <span class="label label-success">kode barang</span>
                                        <!--<div class="controls">
                                            <input type="text" name="kodebarang" class="form-control" name="kodebarang" id="kodebarang">
                                        </div>-->
                                        <div class="controls">
                                                        <select name="kodebarang" id="kodebarang" class="form-control select2" style="width: 100%">
                                                            <!--<option value="0">--Pilih kode--</option>-->
                                                            <?php
                                                            $kodebarang = $o_barang->select_barang();
                                                            for ($i = 0; $i < count($kodebarang); $i++) {
                                                                ?> 
                                                                <option value="<?php echo $kodebarang[$i][1]; ?>"><?php echo $kodebarang[$i][1]; ?></option>
                                                            <?php } ?>
                                                        </select>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="control-group">
                                        <span class="label label-success">jumlah keluar</span>
                                        <div class="controls">
                                            <input type="number" name="jumlahkeluar" class="form-control" id="jumlahkeluar">
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <span class="label label-success">tanggalkeluar</span>
                                        <div class="controls">
                                            <input type="date" name="tanggalkeluar" class="form-control" id="tanggalkeluar">
                                        </div>
                                    </div>



                                </fieldset>

                                <?php echo set_progress(); ?>

                            </div>

                            <div class="modal-footer">
                                <button class="btn btn-info btn-submit"><i class="fa fa-save"></i> Simpan</button>
                                <button class="btn btn-default" data-dismiss="modal"><i class="fa fa-close"></i> Batal</button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>


            <!-- modal konfirmasi-->
            <div id="modal-konfirmasi" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content p-0 b-0">
                        <div class="panel panel-color panel-danger">
                            <div class="panel-heading"> 
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button> 
                                <h3 class="panel-title">Hapus Data</h3> 
                            </div> 
                            <div class="modal-body" style="">
                                &nbsp;&nbsp;<i class="fa fa-warning"></i><strong> Apakah Anda yakin ingin menghapus data ini?</strong>
                            </div>
                            <?php echo set_progress(); ?>
                            <div class="modal-footer">

                                <a href="javascript:;" class="btn btn-danger" id="hapus-true">Ya</a>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Tidak</button>
                                <br><br>
                            </div>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->

            <!-- Modal tambah data -->
            <div id="import" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <form id="form-data" method="post" action="../controler/penjualan.php?p=import" enctype="multipart/form-data">

                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Import Data</h4>
                            </div>

                            <div class="modal-body">

                                <fieldset>

                                    <div class="control-group">
                                        <span class="label label-success">Pilih File Excel dengan format .xls</span>
                                        <div class="controls">
                                            <input type="file" name="data" id="batch" class="form-control">
                                        </div>

                                </fieldset>

                                <?php echo set_progress(); ?>

                            </div>

                            <div class="modal-footer">
                                <button class="btn btn-info btn-submit"><i class="fa fa-save"></i> Simpan</button>
                                <button class="btn btn-default" data-dismiss="modal"><i class="fa fa-close"></i> Batal</button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>




        </div>
        <!-- END wrapper -->

        <script>
                                            var resizefunc = [];</script>

        <!-- jQuery  -->

        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/jquery.form.js"></script>
        <script src="js/waves.js"></script>
        <script src="js/wow.min.js"></script>
        <script src="js/jquery.nicescroll.js" type="text/javascript"></script>
        <script src="js/jquery.scrollTo.min.js"></script>
        <script src="assets/jquery-detectmobile/detect.js"></script>
        <script src="assets/fastclick/fastclick.js"></script>
        <script src="assets/jquery-slimscroll/jquery.slimscroll.js"></script>
        <script src="assets/jquery-blockui/jquery.blockUI.js"></script>
        <script src="assets/jquery-blockui/jquery.blockUI.js"></script>
        <!-- CUSTOM JS -->
        <script src="js/jquery.app.js"></script>
        <!-- Examples -->
        <script src="assets/notifications/notify.min.js"></script>
        <script src="assets/notifications/notify-metro.js"></script>
        <script src="assets/notifications/notifications.js"></script>

        <script src="assets/magnific-popup/magnific-popup.js"></script>
        <script src="assets/jquery-datatables-editable/jquery.dataTables.js"></script> 
        <script src="assets/datatables/dataTables.bootstrap.js"></script>
        <script src="assets/jquery-datatables-editable/datatables.editable.init.js"></script>
        <script>
<?php if (!empty($_SESSION['info'])) { ?>
                                        $.Notification.autoHideNotify('success', 'buttom right', 'Berhasil <?php echo $_SESSION['info']; ?> data');
                                                // Fungsi untuk pengiriman form baca dokumentasinya di https://github.com/malsup/form/
    <?php
}
?>
                                    function set_ajax(identifier) {

                                    var options = {
                                    beforeSend: function() {

                                    $(".progress-container").show();
                                            $(".btn-submit").attr("disabled", ""); // Membuat button submit jadi tidak bisa terklik

                                    },
                                            uploadProgress: function(event, position, total, percentComplete) {

                                            $(".progress-bar").attr('style', 'width' + percentComplete + '%');
                                            },
                                            success: function(data, textStatus, jqXHR, ui) {

                                            if (data.trim() == "Menambah" || data.trim() == "Menghapus" || data.trim() == "Mengedit" || data.trim() == data.trim()) {

                                            $(".progress-bar").attr('style', 'width:100%');
                                                    setTimeout(function() {
                                                    window.location.replace("trans_penjualan.php")
                                                    }, 500);
                                            } else {

                                            $(".progress-container").hide();
                                                    $("#pesan-required-field").html(data);
                                                    $("#modal-peringatan").modal('show');
                                                    $(".btn-submit").removeAttr('disabled', '');
                                            }

                                            },
                                            error: function(jqXHR, textStatus, errorThrown) {

                                            $(".progress-container").hide();
                                                    $("#pesan-required-field").html('Gagal Memproses data<br/> textStatus=' + textStatus + ', errorThrown=' + errorThrown);
                                                    $("#modal-peringatan").modal('show');
                                            }

                                    };
                                            // kirim form dengan opsi yang telah dibuat diatas
                                            $("#" + identifier).ajaxForm(options);
                                    }

                                    $(function() {

                                    // Untuk pengiriman form tambah
                                    set_ajax('tambah-data');
                                            // Untuk pengiriman form sunting
                                            set_ajax('edit-data');
                                            // Hapus

                                            set_ajax('import');
                                            $('#modal-konfirmasi').on('show.bs.modal', function(event) {
                                    var div = $(event.relatedTarget) // Tombol dimana modal di tampilkan

                                            // Untuk mengambil nilai dari data-id="" yang telah kita tempatkan pada link hapus
                                            var id = div.data('id')

                                            var modal = $(this)

                                            // Mengisi atribut href pada tombol ya yang kita berikan id hapus-true pada modal.
                                            modal.find('#hapus-true').attr("href", "../controler/penjualan.php?p=hapus&id=" + id);
                                    });
                                            // Untuk sunting
                                            $('#edit-data').on('show.bs.modal', function(event) {
                                    var div = $(event.relatedTarget) // Tombol dimana modal di tampilkan

                                            var id = div.data('id');
                                            var kodetransaksi = div.data('kodetransaksi');
                                            var kodebarang = div.data('kodebarang');
                                            var jumlahkeluar = div.data('jumlahkeluar');
                                            var tanggalkeluar = div.data('tanggalkeluar');
                                            var modal = $(this)

                                            // Isi nilai pada field
                                            modal.find('#id').attr("value", id);
                                            modal.find('#kodetransaksi').attr("value", kodetransaksi);
                                            modal.find('#kodebarang').attr("value", kodebarang);
                                            modal.find('#jumlahkeluar').attr("value", jumlahkeluar);
                                            modal.find('#tanggalkeluar').attr("value", tanggalkeluar);
                                    });
                                    });</script>

        <script type="text/javascript" src="assets/tableexport/tableExport.js"></script>
        <script type="text/javascript" src="assets/tableexport/jquery.base64.js"></script>
        <script type="text/javascript" src="assets/tableexport/html2canvas.js"></script>
        <script type="text/javascript" src="assets/tableexport/jspdf/libs/sprintf.js"></script>
        <script type="text/javascript" src="assets/tableexport/jspdf/jspdf.js"></script>
        <script type="text/javascript" src="assets/tableexport/jspdf/libs/base64.js"></script> 
        <!--form validation init-->
        <script type="text/javascript" src="assets/jquery.validate/jquery.validate.min.js"></script>
        <script type="text/javascript">
                                            !function($) {
                                            "use strict";
                                                    var FormValidator = function() {
                                                    this.$loginForm = $("#form-data");
                                                    };
                                                    //init
                                                    FormValidator.prototype.init = function() {
                                                    //validator plugin
                                                    $.validator.setDefaults({
                                                    submitHandler: function() {
                                                    window.location("");
                                                    }
                                                    });
                                                            // validate signup form on keyup and submit
                                                            this.$loginForm.validate({
                                                            rules: {
                                                            batch: {
                                                            required: true,
                                                                    minlength: 6
                                                            },
                                                                    nama: {
                                                                    required: true,
                                                                            minlength: 6,
                                                                            karakter: true
                                                                    },
                                                                    email: {
                                                                    required: true,
                                                                            minlength: 6,
                                                                            email: true
                                                                    }
                                                            },
                                                                    messages: {
                                                                    nama: {
                                                                    required: "Nama Tidak Boleh Kosong",
                                                                            minlength: "Nama Harus Lebih Dari 6 Karakter"
                                                                    },
                                                                            batch: {
                                                                            required: "Batch Tidak Boleh Kosong",
                                                                                    minlength: "Badge Harus Lebih Dari 6 Karakter"
                                                                            },
                                                                            email: {
                                                                            required: "Email Tidak Boleh Kosong",
                                                                                    minlength: "Email Harus Lebih Dari 6 Karakter",
                                                                                      email: "Format Email Tidak Sesuai contoh : blabla@gmail.com"
                                                                            }
                                                                    }
                                                            });
                                                    },
                                                    //init
                                                    $.FormValidator = new FormValidator, $.FormValidator.Constructor = FormValidator
                                            }(window.jQuery),
//initializing 
                                            function($) {
                                            "use strict";
                                                    $.FormValidator.init()
                                            }(window.jQuery);</script>
        
        <script type="text/javascript">
                                            !function($) {
                                            "use strict";
                                                    var FormValidator = function() {
                                                    this.$loginForm = $(".form-edit");
                                                    };
                                                    //init
                                                    FormValidator.prototype.init = function() {
                                                    //validator plugin
                                                    $.validator.setDefaults({
                                                    submitHandler: function() {
                                                    window.location("");
                                                    }
                                                    });
                                                            // validate signup form on keyup and submit
                                                            this.$loginForm.validate({
                                                            rules: {
                                                            batch: {
                                                            required: true,
                                                                    minlength: 6
                                                            },
                                                                    nama: {
                                                                    required: true,
                                                                            minlength: 6,
                                                                            karakter: true
                                                                    },
                                                                    email: {
                                                                    required: true,
                                                                            minlength: 6,
                                                                            email: true
                                                                    }
                                                            },
                                                                    messages: {
                                                                    nama: {
                                                                    required: "Nama Tidak Boleh Kosong",
                                                                            minlength: "Nama Harus Lebih Dari 6 Karakter"
                                                                    },
                                                                            batch: {
                                                                            required: "Batch Tidak Boleh Kosong",
                                                                                    minlength: "Batch Harus Lebih Dari 6 Karakter"
                                                                            },
                                                                            email: {
                                                                            required: "Email Tidak Boleh Kosong",
                                                                                    minlength: "Email Harus Lebih Dari 6 Karakter",
                                                                                      email: "Format Email Tidak Sesuai contoh : blabla@gmail.com"
                                                                            }
                                                                    }
                                                            });
                                                    },
                                                    //init
                                                    $.FormValidator = new FormValidator, $.FormValidator.Constructor = FormValidator
                                            }(window.jQuery),
//initializing 
                                            function($) {
                                            "use strict";
                                                    $.FormValidator.init()
                                            }(window.jQuery);</script>
        
    </body>
</html>
<?php $_SESSION['info'] = ""; ?>