<?php

$root = filter_input(INPUT_SERVER, "Root", FILTER_SANITIZE_URL);
require_once $root . 'model/database_model.php';

class pembelianModel extends Database {

    public function __construct() {
        parent::__construct();
    }
    public function select_pembelian() {
        $statement = "select * from pembelian";
        return parent::fetch($statement, "pembelian");
    }
    public function select_pembelian_limit($min,$max) {
        $statement = "select * from pembelian limit $min,$max";
        return parent::fetch($statement, "pembelian");
    }
    public function select_pembelian_batch($batch) {
        $statement = "select * from pembelian where batch='$batch'";
        return parent::fetch($statement, "pembelian");
    }
     public function select_pembelian_email($mail) {
        $statement = "select * from pembelian where email='$mail'";
        return parent::fetch($statement, "pembelian");
    }
    public function insert_pembelian($kodetransaksi, $kodebarang, $jumlahmasuk, $tanggalmasuk) {
        $statement = "insert INTO `pembelian`(`kodetransaksi`, `kodebarang`, `jumlahmasuk`, `tanggalmasuk`) VALUES ('$kodetransaksi','$kodebarang',$jumlahmasuk,'$tanggalmasuk')";
         return parent::exec($statement);
    }
    public function update_pembelian($id,$kodebarang,$jumlahmasuk,$tanggalmasuk) {
        $statement = "update `pembelian` SET `kodebarang`='$kodebarang',`jumlahmasuk`=$jumlahmasuk,`tanggalmasuk`='$tanggalmasuk' WHERE id=$id";
         return parent::exec($statement);
    }
     public function delete_pembelian($id) {
        $statement = "delete FROM `pembelian` WHERE id=$id";
         return parent::exec($statement);
    }


}

?>
