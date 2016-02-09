<?php

$root = filter_input(INPUT_SERVER, "Root", FILTER_SANITIZE_URL);
require_once $root . 'model/barang.php';


class barangControl {

    private $objbarang = "";

    public function __construct() {
        $this->objbarang = new barangModel();
    }

    private function get_result($result) {
        if ($result) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function select_barang() {
        $data = $this->objbarang->select_barang();
        return $data;
    }

    public function select_barangkode() {
        $data = $this->objbarang->select_barangkode();
        return $data;
    }

    public function select_barangkode_mak($mak) {
        $data = $this->objbarang->select_barangkode_mak($mak);
        return $data;
    }

    public function insert_barang($kodebarang, $namabarang, $jumlah, $satuan) {
        $data = $this->objbarang->insert_barang($kodebarang, $namabarang, $jumlah, $satuan);
        return $data;
    }

    public function update_barang($id, $kodebarang, $namabarang, $jumlah, $satuan) {
        $data = $this->objbarang->update_barang($id, $kodebarang, $namabarang, $jumlah, $satuan);
        return $data;
    }
    public function select_barang_batch($batch) {
        $data = $this->objbarang->select_barang_batch($batch);
        return $data;
    }

    public function delete_barang($id) {
        $data = $this->objbarang->delete_barang($id);
        return $data;
    }

}

$i = "";
$o_barang = new barangControl();

if (isset($_GET['p'])) {
    session_start();
    if ($_GET['p'] == "tambah") {

        $kodebarang = $_POST['kodebarang'];
        $namabarang = $_POST['namabarang'];
        $jumlah = $_POST['jumlah'];
        $satuan = $_POST['satuan'];
        $o_barang->insert_barang($kodebarang, $namabarang, $jumlah, $satuan);
        $_SESSION['info'] = "Menambah";
        echo $kodebarang."-".$namabarang."-".$jumlah."-".$satuan;
        echo "Menambah";
    } else if ($_GET['p'] == "update") {
        $kodebarang = $_POST['kodebarang'];
        $namabarang = $_POST['namabarang'];
        $jumlah = $_POST['jumlah'];
        $satuan = $_POST['satuan'];
        $id = $_POST['id'];
        $o_barang->update_barang($id, $kodebarang, $namabarang, $jumlah, $satuan);
        $_SESSION['info'] = "Mengedit";
        echo $id."-".$kodebarang."-".$namabarang."-".$jumlah."-".$satuan;
        echo "Mengedit";
        $i = 2;
    } else if ($_GET['p'] == "hapus") {
        $id = $_GET['id'];
        $o_barang->delete_barang($id);
        $_SESSION['info'] = "Menghapus";
        header("location:../view/barang.php");
        $i = 3;
    } else if ($_GET['p'] == "import") {
        include "excel_reader.php";
        $data = new Spreadsheet_Excel_Reader($_FILES['data']['tmp_name']);
        $baris = $data->rowcount($sheet_index = 0);
        $jumlahData = 0;
        for ($i = 2; $i <= $baris; $i++) {
            $batch = $data->val($i, 1);

            $nama = $data->val($i, 2);

            $email = $data->val($i, 3);
            $cek=$o_barang->select_barang_batch($batch);
            $hitung=  count($cek);
            if($hitung==1){
                $id=$cek[0][0];
            $o_barang->update_barang($id, $batch, $nama, $email);    
            }else{
            $o_barang->insert_barang($batch, $nama, $email);
            }
            $jumlahData++;
        }

        $_SESSION['info'] = "Mengimport " . $jumlahData;
        echo "Mengimport " . $jumlahData;
    }
}
?>