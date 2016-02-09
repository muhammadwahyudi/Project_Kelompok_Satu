<?php

$root = filter_input(INPUT_SERVER, "Root", FILTER_SANITIZE_URL);
require_once $root . 'model/database_model.php';

class barangModel extends Database {

    public function __construct() {
        parent::__construct();
    }
    public function select_barang() {
        $statement = "select * from barang";
        return parent::fetch($statement, "barang");
    }
    public function select_barangkode() {
        $statement = "select max(id) from barang";
        return parent::fetch($statement, "barang");
    }

    public function select_barangkode_mak($mak) {
        $statement = "select * from barang where id='$mak'";
        return parent::fetch($statement, "barang");
    }

    public function select_barang_limit($min,$max) {
        $statement = "select * from barang limit $min,$max";
        return parent::fetch($statement, "barang");
    }
    public function select_barang_batch($batch) {
        $statement = "select * from barang where batch='$batch'";
        return parent::fetch($statement, "barang");
    }
     public function select_barang_email($mail) {
        $statement = "select * from barang where email='$mail'";
        return parent::fetch($statement, "barang");
    }
    public function insert_barang($kodebarang, $namabarang, $jumlah, $satuan) {
        $statement = "insert INTO `barang`(`kodebarang`, `namabarang`, `jumlahbarang`, `satuan`) VALUES ('$kodebarang','$namabarang',$jumlah,'$satuan')";
         return parent::exec($statement);
    }
    public function update_barang($id,$kodebarang,$namabarang,$jumlah,$satuan) {
        $statement = "update `barang` SET `kodebarang`='$kodebarang',`namabarang`='$namabarang',`jumlahbarang`=$jumlah,`satuan`='$satuan' WHERE id=$id";
         return parent::exec($statement);
    }
     public function delete_barang($id) {
        $statement = "delete FROM `barang` WHERE id=$id";
         return parent::exec($statement);
    }


}

?>
