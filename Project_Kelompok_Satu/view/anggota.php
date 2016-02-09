<?php
session_start();
include "auth.php";
$root = filter_input(INPUT_SERVER, "Root", FILTER_SANITIZE_URL);
$control = filter_input(INPUT_SERVER, "BaseControl", FILTER_SANITIZE_URL);
require_once $root . 'model/database_model.php';
//include controler
include $control . 'anggota.php';
//obj
$o_anggota = new AnggotaControl();
$result = $o_anggota->select_anggota();

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



            <?php include "menu.php"; ?>


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
                                            <?php if($ha_tambah==TRUE){?>
                                            <button class="btn btn-primary waves-effect waves-light" data-id='0' data-toggle="modal" data-target="#tambah-data"><i class="fa fa-plus"></i> Tambah</button> 
                                            <button class="btn btn-pink waves-effect waves-light" data-id='0' data-toggle="modal" data-target="#import"><i class="md md-attach-file"></i> Import File</button>
                                            <?php } ?>

                                            <div class="btn-group">
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
                                            </div> 

                                        </div>
                                    </div>
                                </div>

                                <table class="table table-bordered table-striped" id="datatable-editable">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Badge</th>
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 0;
                                        for ($i = 0; $i < count($result); $i++) {
                                            $no++;
                                            ?>
                                            <tr class="gradeX">
                                               <?php if($ha_select==TRUE){?>
                                                <td><?php print $no; ?></td>
                                                <td><?php echo $result[$i][1]; ?></td>
                                                <td><?php echo $result[$i][2]; ?></td>
                                                <td><?php echo $result[$i][3]; ?></td>
                                                <td class="actions">                                                
                                                    <?php
                                               }if($ha_edit==TRUE){?>
                                                    <a  class="btn btn-xs btn-warning" href="javascript:;"
                                                        data-id="<?php echo $result[$i][0]; ?>"
                                                        data-batch="<?php echo $result[$i][1]; ?>"
                                                        data-nama="<?php echo $result[$i][2]; ?>"
                                                        data-email="<?php echo $result[$i][3]; ?>"
                                                        data-toggle="modal" data-target="#edit-data">

                                                        <i class="ion ion-edit"></i> Edit

                                                    </a>
                                                    <?php
                                                }if($ha_hapus==TRUE){?>
                                                    <a class="btn btn-xs btn-danger" href="javascript:;" data-id="<?php echo $result[$i][0]; ?>" data-toggle="modal" data-target="#modal-konfirmasi"><i class="ion ion-trash-a"></i> Hapus</a>
                                                            <?php }?>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- end: page -->

                        </div> <!-- end Panel -->

                    </div> <!-- container -->

                </div> <!-- content -->


                <footer class="footer text-right" style="z-index:100000">
                    2015 © KKMC - By : Muhammad Mahrus Zain, Politeknik Caltex Riau
                </footer>

            </div>
            <!-- ============================================================== -->
            <!-- End Right content here -->
            <!-- ============================================================== -->


            <!-- Modal tambah data -->
            <div id="tambah-data" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <form id="form-data" method="post" action="../controler/anggota.php?p=tambah">

                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Tambah Data</h4>
                            </div>

                            <div class="modal-body">

                                <fieldset>

                                    <div class="control-group">
                                        <span class="label label-success">Badge</span>
                                        <div class="controls">
                                            <input type="text" name="batch" class="form-control" id="batch">
                                        </div>
                                    </div>
                                    <br>
                                    <div class="control-group">
                                        <span class="label label-success">Nama</span>
                                        <div class="controls">
                                            <input type="text" name="nama" class="form-control" name="nama" id="nama">
                                        </div>
                                    </div>
                                    <br>
                                    <div class="control-group">
                                        <span class="label label-success">Email</span>
                                        <div class="controls">
                                            <input type="text" name="email" class="form-control" id="email">
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

                        <form id="form-data" class="form-edit" method="post" action="../controler/anggota.php?p=update">

                            <input type="hidden" name="id" id="id">

                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Edit Data</h4>
                            </div>

                            <div class="modal-body">

                                <fieldset>
                                    <div class="control-group">
                                        <span class="label label-success">Badge</span>
                                        <div class="controls">
                                            <input type="text" name="batch" id="batch" class="form-control">
                                        </div>
                                        <br>
                                        <div class="control-group">
                                            <span class="label label-success">Nama</span>
                                            <div class="controls">
                                                <input type="text" id="nama" name="nama" class="form-control">
                                            </div>
                                        </div>
                                        <br>
                                        <div class="control-group">
                                            <span class="label label-success">Email</span>
                                            <div class="controls">
                                                <input type="text" id="email" name="email" class="form-control">
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

                        <form id="form-data" method="post" action="../controler/anggota.php?p=import" enctype="multipart/form-data">

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
                                                    window.location.replace("anggota.php")
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
                                            modal.find('#hapus-true').attr("href", "../controler/anggota.php?p=hapus&id=" + id);
                                    });
                                            // Untuk sunting
                                            $('#edit-data').on('show.bs.modal', function(event) {
                                    var div = $(event.relatedTarget) // Tombol dimana modal di tampilkan

                                            var id = div.data('id');
                                            var batch = div.data('batch');
                                            var nama = div.data('nama');
                                            var email = div.data('email');
                                            var modal = $(this)

                                            // Isi nilai pada field
                                            modal.find('#id').attr("value", id);
                                            modal.find('#batch').attr("value", batch);
                                            modal.find('#nama').attr("value", nama);
                                            modal.find('#email').attr("value", email);
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