<?php

$root = filter_input(INPUT_SERVER, "Root", FILTER_SANITIZE_URL);
require_once $root . 'model/database_model.php';

class transaksiModel extends Database {

    public function __construct() {
        parent::__construct();
    }
    public function select_transaksi() {
        $statement = "select * from transaksi";
        return parent::fetch($statement, "transaksi");
    }
    public function select_transaksikode() {
        $statement = "select max(id) from transaksi";
        return parent::fetch($statement, "transaksi");
    }
    public function select_transaksi_limit($min,$max) {
        $statement = "select * from transaksi limit $min,$max";
        return parent::fetch($statement, "transaksi");
    }
    public function select_transaksi_batch($batch) {
        $statement = "select * from transaksi where batch='$batch'";
        return parent::fetch($statement, "transaksi");
    }
     public function select_transaksi_email($mail) {
        $statement = "select * from transaksi where email='$mail'";
        return parent::fetch($statement, "transaksi");
    }
    public function insert_transaksi($kodetransaksi, $jenistransaksi, $tanggaltransaksi, $keterangan) {
        $statement = "insert INTO `transaksi`(`kodetransaksi`, `jenistransaksi`, `tanggaltransaksi`, `keterangan`) VALUES ('$kodetransaksi','$jenistransaksi','$tanggaltransaksi','$keterangan')";
         return parent::exec($statement);
    }
    public function update_transaksi($id,$jenistransaksi,$tanggaltransaksi,$keterangan) {
        $statement = "update `transaksi` SET `jenistransaksi`='$jenistransaksi',`tanggaltransaksi`='$tanggaltransaksi',`keterangan`='$keterangan' WHERE id=$id";
         return parent::exec($statement);
    }
     public function delete_transaksi($id) {
        $statement = "delete FROM `transaksi` WHERE id=$id";
         return parent::exec($statement);
    }


}

?>
