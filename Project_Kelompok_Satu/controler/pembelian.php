<?php

$root = filter_input(INPUT_SERVER, "Root", FILTER_SANITIZE_URL);
require_once $root . 'model/pembelian.php';

class pembelianControl {

    private $objpembelian = "";

    public function __construct() {
        $this->objpembelian = new pembelianModel();
    }

    private function get_result($result) {
        if ($result) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function select_pembelian() {
        $data = $this->objpembelian->select_pembelian();
        return $data;
    }

    public function insert_pembelian($kodetransaksi, $kodebarang, $jumlahmasuk, $tanggalmasuk) {
        $data = $this->objpembelian->insert_pembelian($kodetransaksi, $kodebarang, $jumlahmasuk, $tanggalmasuk);
        return $data;
    }

    public function update_pembelian($id, $kodebarang, $jumlahmasuk, $tanggalmasuk) {
        $data = $this->objpembelian->update_pembelian($id, $kodebarang, $jumlahmasuk, $tanggalmasuk);
        return $data;
    }
    public function select_pembelian_batch($batch) {
        $data = $this->objpembelian->select_pembelian_batch($batch);
        return $data;
    }

    public function delete_pembelian($id) {
        $data = $this->objpembelian->delete_pembelian($id);
        return $data;
    }

}

$i = "";
$o_pembelian = new pembelianControl();

if (isset($_GET['p'])) {
    session_start();
    if ($_GET['p'] == "tambah") {

        $kodetransaksi = $_POST['kodetransaksi'];
        $kodebarang = $_POST['kodebarang'];
        $jumlahmasuk = $_POST['jumlahmasuk'];
        $tanggalmasuk = $_POST['tanggalmasuk'];

        //fungsi kontrol jumlah barang
        $con = mysqli_connect('localhost','root','','db_pergudangan') OR die(mysql_error());
        $query = mysqli_query($con, "SELECT * from `barang` where kodebarang='$kodebarang'");
        $hasil1 = mysqli_fetch_array($query);
        $hasil = $hasil1[3];
        $hasil2 = $hasil+$jumlahmasuk;
        $update = mysqli_query($con, "UPDATE `barang` SET `jumlahbarang`=$hasil2 where kodebarang='$kodebarang'");
        //
        $o_pembelian->insert_pembelian($kodetransaksi, $kodebarang, $jumlahmasuk, $tanggalmasuk);
        $_SESSION['info'] = "Menambah";
        echo $kodetransaksi."-".$kodebarang."-".$jumlahmasuk."-".$tanggalmasuk;
        echo "Menambah";
    } else if ($_GET['p'] == "update") {
        
        $kodebarang = $_POST['kodebarang'];
        $jumlahmasuk = $_POST['jumlahmasuk'];
        $tanggalmasuk = $_POST['tanggalmasuk'];
        $id = $_POST['id'];

        //fungsi kontrol jumlah barang
        $con = mysqli_connect('localhost','root','','db_pergudangan') OR die(mysql_error());
        $query = mysqli_query($con, "SELECT * from `barang` where kodebarang='$kodebarang'");
        $hasil1 = mysqli_fetch_array($query);
        $hasil = $hasil1[3];
        $query = mysqli_query($con, "SELECT * from `pembelian` where id=$id");
        $hasil2 = mysqli_fetch_array($query);
        $hasil3 = $hasil2[3];
        $hasil4 = ($hasil-$hasil3)+$jumlahmasuk;
        $update = mysqli_query($con, "UPDATE `barang` SET `jumlahbarang`=$hasil4 where kodebarang='$kodebarang'");
        //
        $o_pembelian->update_pembelian($id, $kodebarang, $jumlahmasuk, $tanggalmasuk);
        $_SESSION['info'] = "Mengedit";
        echo $id."-".$kodetransaksi."-".$kodebarang."-".$jumlahmasuk."-".$tanggalmasuk;
        echo "Mengedit";
        $i = 2;
    } else if ($_GET['p'] == "hapus") {
        $id = $_GET['id'];
        $o_pembelian->delete_pembelian($id);
        $_SESSION['info'] = "Menghapus";
        header("location:../view/pembelian.php");
        $i = 3;
    } else if ($_GET['p'] == "import") {
        include "excel_reader.php";
        $data = new Spreadsheet_Excel_Reader($_FILES['data']['tmp_name']);
        $baris = $data->rowcount($sheet_index = 0);
        $jumlahmasukData = 0;
        for ($i = 2; $i <= $baris; $i++) {
            $batch = $data->val($i, 1);

            $nama = $data->val($i, 2);

            $email = $data->val($i, 3);
            $cek=$o_pembelian->select_pembelian_batch($batch);
            $hitung=  count($cek);
            if($hitung==1){
                $id=$cek[0][0];
            $o_pembelian->update_pembelian($id, $batch, $nama, $email);    
            }else{
            $o_pembelian->insert_pembelian($batch, $nama, $email);
            }
            $jumlahmasukData++;
        }

        $_SESSION['info'] = "Mengimport " . $jumlahmasukData;
        echo "Mengimport " . $jumlahmasukData;
    }
}
?>