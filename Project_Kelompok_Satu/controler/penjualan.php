<?php

$root = filter_input(INPUT_SERVER, "Root", FILTER_SANITIZE_URL);
require_once $root . 'model/penjualan.php';


class penjualanControl {

    private $objpenjualan = "";

    public function __construct() {
        $this->objpenjualan = new penjualanModel();
    }

    private function get_result($result) {
        if ($result) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function select_penjualan() {
        $data = $this->objpenjualan->select_penjualan();
        return $data;
    }

    public function select_penjualankode() {
        $data = $this->objpenjualan->select_penjualankode();
        //return $data;
    }

    public function select_penjualankode_mak($mak) {
        $data = $this->objpenjualan->select_penjualankode_mak($mak);
        return $data;
    }

    public function insert_penjualan($kodetransaksi, $kodebarang, $jumlahkeluar, $tanggalkeluar) {
        $data = $this->objpenjualan->insert_penjualan($kodetransaksi, $kodebarang, $jumlahkeluar, $tanggalkeluar);
        return $data;
    }

    public function update_penjualan($id, $kodebarang, $jumlahkeluar, $tanggalkeluar) {
        $data = $this->objpenjualan->update_penjualan($id, $kodebarang, $jumlahkeluar, $tanggalkeluar);
        return $data;
    }
    public function select_penjualan_batch($batch) {
        $data = $this->objpenjualan->select_penjualan_batch($batch);
        return $data;
    }

    public function delete_penjualan($id) {
        $data = $this->objpenjualan->delete_penjualan($id);
        return $data;
    }

}

$i = "";
$o_penjualan = new penjualanControl();

if (isset($_GET['p'])) {
    session_start();
    if ($_GET['p'] == "tambah") {

        $kodetransaksi = $_POST['kodetransaksi'];
        $kodebarang = $_POST['kodebarang'];
        $jumlahkeluar = $_POST['jumlahkeluar'];
        $tanggalkeluar = $_POST['tanggalkeluar'];
        //fungsi kontrol jumlah barang
        $con = mysqli_connect('localhost','root','','db_pergudangan') OR die(mysql_error());
        $query = mysqli_query($con, "SELECT * from `barang` where kodebarang='$kodebarang'");
        $hasil1 = mysqli_fetch_array($query);
        $hasil = $hasil1[3];
        $hasil2 = $hasil-$jumlahkeluar;
        $update = mysqli_query($con, "UPDATE `barang` SET `jumlahbarang`=$hasil2 where kodebarang='$kodebarang'");
        //
        $o_penjualan->insert_penjualan($kodetransaksi, $kodebarang, $jumlahkeluar, $tanggalkeluar);
        $_SESSION['info'] = "Menambah";
        echo $kodetransaksi."-".$kodebarang."-".$jumlahkeluar."-".$tanggalkeluar."-".$hasil2;
        echo "Menambah";
    } else if ($_GET['p'] == "update") {
        
        $kodebarang = $_POST['kodebarang'];
        $jumlahkeluar = $_POST['jumlahkeluar'];
        $tanggalkeluar = $_POST['tanggalkeluar'];
        $id = $_POST['id'];

        //fungsi kontrol jumlah barang
        $con = mysqli_connect('localhost','root','','db_pergudangan') OR die(mysql_error());
        $query = mysqli_query($con, "SELECT * from `barang` where kodebarang='$kodebarang'");
        $hasil1 = mysqli_fetch_array($query);
        $hasil = $hasil1[3];
        $query = mysqli_query($con, "SELECT * from `penjualan` where id=$id");
        $hasil2 = mysqli_fetch_array($query);
        $hasil3 = $hasil2[3];
        $hasil4 = $hasil+($hasil3-$jumlahkeluar);
        $update = mysqli_query($con, "UPDATE `barang` SET `jumlahbarang`=$hasil4 where kodebarang='$kodebarang'");
        //

        $o_penjualan->update_penjualan($id, $kodebarang, $jumlahkeluar, $tanggalkeluar);
        $_SESSION['info'] = "Mengedit";
        //echo $id."-".$kodetransaksi."-".$kodebarang."-".$jumlahkeluar."-".$tanggalkeluar;
        echo "Mengedit";
        $i = 2;
    } else if ($_GET['p'] == "hapus") {
        $id = $_GET['id'];
        $o_penjualan->delete_penjualan($id);
        $_SESSION['info'] = "Menghapus";
        header("location:../view/penjualan.php");
        $i = 3;
    } else if ($_GET['p'] == "import") {
        include "excel_reader.php";
        $data = new Spreadsheet_Excel_Reader($_FILES['data']['tmp_name']);
        $baris = $data->rowcount($sheet_index = 0);
        $jumlahkeluarData = 0;
        for ($i = 2; $i <= $baris; $i++) {
            $batch = $data->val($i, 1);

            $nama = $data->val($i, 2);

            $email = $data->val($i, 3);
            $cek=$o_penjualan->select_penjualan_batch($batch);
            $hitung=  count($cek);
            if($hitung==1){
                $id=$cek[0][0];
            $o_penjualan->update_penjualan($id, $batch, $nama, $email);    
            }else{
            $o_penjualan->insert_penjualan($batch, $nama, $email);
            }
            $jumlahkeluarData++;
        }

        $_SESSION['info'] = "Mengimport " . $jumlahkeluarData;
        echo "Mengimport " . $jumlahkeluarData;
    }
}
?>