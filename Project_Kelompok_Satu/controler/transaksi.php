<?php

$root = filter_input(INPUT_SERVER, "Root", FILTER_SANITIZE_URL);
require_once $root . 'model/transaksi.php';

class transaksiControl {

    private $objtransaksi = "";

    public function __construct() {
        $this->objtransaksi = new transaksiModel();
    }

    private function get_result($result) {
        if ($result) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function select_transaksi() {
        $data = $this->objtransaksi->select_transaksi();
        return $data;
    }

    public function select_transaksikode() {
        $data = $this->objtransaksi->select_transaksikode();
        return $data;
    }

    public function insert_transaksi($kodetransaksi, $jenistransaksi, $tanggaltransaksi, $keterangan) {
        $data = $this->objtransaksi->insert_transaksi($kodetransaksi, $jenistransaksi, $tanggaltransaksi, $keterangan);
        return $data;
    }

    public function update_transaksi($id, $kodetransaksi, $jenistransaksi, $tanggaltransaksi, $keterangan) {
        $data = $this->objtransaksi->update_transaksi($id, $kodetransaksi, $jenistransaksi, $tanggaltransaksi, $keterangan);
        return $data;
    }
    public function select_transaksi_batch($batch) {
        $data = $this->objtransaksi->select_transaksi_batch($batch);
        return $data;
    }

    public function delete_transaksi($id) {
        $data = $this->objtransaksi->delete_transaksi($id);
        return $data;
    }

}

$i = "";
$o_transaksi = new transaksiControl();

if (isset($_GET['p'])) {
    session_start();
    if ($_GET['p'] == "beli") {

        $kodetransaksi = $_POST['kodetransaksi'];
        $jenistransaksi = $_POST['jenistransaksi'];
        $tanggaltransaksi = $_POST['tanggaltransaksi'];
        $keterangan = $_POST['keterangan'];
        $o_transaksi->insert_transaksi($kodetransaksi, $jenistransaksi, $tanggaltransaksi, $keterangan);
        $_SESSION['info'] = "beli";
        header("location:../view/trans_pembelian.php");
        echo $kodetransaksi."-".$jenistransaksi."-".$tanggaltransaksi."-".$keterangan;
        echo "beli";
    } else if ($_GET['p'] == "jual") {

        $kodetransaksi = $_POST['kodetransaksi'];
        $jenistransaksi = $_POST['jenistransaksi'];
        $tanggaltransaksi = $_POST['tanggaltransaksi'];
        $keterangan = $_POST['keterangan'];
        $o_transaksi->insert_transaksi($kodetransaksi, $jenistransaksi, $tanggaltransaksi, $keterangan);
        $_SESSION['info'] = "jual";
        header("location:../view/trans_penjualan.php");
        echo $kodetransaksi."-".$jenistransaksi."-".$tanggaltransaksi."-".$keterangan;
        echo "jual";
    }

    else if ($_GET['p'] == "update") {
        $kodetransaksi = $_POST['kodetransaksi'];
        $jenistransaksi = $_POST['jenistransaksi'];
        $tanggaltransaksi = $_POST['tanggaltransaksi'];
        $keterangan = $_POST['keterangan'];
        $id = $_POST['id'];
        $o_transaksi->update_transaksi($id, $jenistransaksi, $tanggaltransaksi, $keterangan);
        $_SESSION['info'] = "Mengedit";
        header("location:../view/transaksi.php");
        echo $id."-".$kodetransaksi."-".$jenistransaksi."-".$tanggaltransaksi."-".$keterangan;
        echo "Mengedit";
        $i = 2;
    } else if ($_GET['p'] == "hapus") {
        $id = $_GET['id'];
        $o_transaksi->delete_transaksi($id);
        $_SESSION['info'] = 'Menghapus';
        header("location:../view/transaksi.php");
        $i = 3;
    } else if ($_GET['p'] == "import") {
        include "excel_reader.php";
        $data = new Spreadsheet_Excel_Reader($_FILES['data']['tmp_name']);
        $baris = $data->rowcount($sheet_index = 0);
        $tanggaltransaksiData = 0;
        for ($i = 2; $i <= $baris; $i++) {
            $batch = $data->val($i, 1);

            $nama = $data->val($i, 2);

            $email = $data->val($i, 3);
            $cek=$o_transaksi->select_transaksi_batch($batch);
            $hitung=  count($cek);
            if($hitung==1){
                $id=$cek[0][0];
            $o_transaksi->update_transaksi($id, $batch, $nama, $email);    
            }else{
            $o_transaksi->insert_transaksi($batch, $nama, $email);
            }
            $tanggaltransaksiData++;
        }

        $_SESSION['info'] = "Mengimport " . $tanggaltransaksiData;
        echo "Mengimport " . $tanggaltransaksiData;
    }
}
?>