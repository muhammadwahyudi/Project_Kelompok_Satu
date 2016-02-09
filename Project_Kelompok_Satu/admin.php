<?php

$root = filter_input(INPUT_SERVER, "Root", FILTER_SANITIZE_URL);
require_once $root . 'model/admin.php';
require_once $root . 'controler/encrypt.php';

class AdminControl {

    private $objAdmin = "";

    public function __construct() {
        $this->objAdmin = new AdminModel();
    }

    private function get_result($result) {
        if ($result) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function select_admin() {
        $data = $this->objAdmin->select_admin();
        return $data;
    }
    public function delete_admin($id) {
        $data = $this->objAdmin->delete_admin($id);
        return $data;
    }
     public function update_adminall($id, $username, $password, $email, $nama, $role, $h_e, $h_a) {
        $data = $this->objAdmin->update_adminall($id, $username, $password, $email, $nama, $role, $h_e, $h_a);
        return $data;
    }
    public function update_status($id, $aktif) {
        $data = $this->objAdmin->update_status($id, $aktif);
        return $data;
    }

    public function insert_admin($username, $password, $email, $nama, $role,$h_e,$h_a) {
        $data = $this->objAdmin->insert_admin($username, $password, $email, $nama, $role, $h_e, $h_a);
        return $data;
    }

    public function select_password_email2($email) {
        $data = $this->objAdmin->select_password_email2($email);
        return $data;
    }

    public function login_admin($username, $password) {

        $data = $this->objAdmin->login_admin($username, $password);
        $data2 = $this->objAdmin->login_admin2($username, $password);
        $response = 0;
        if (!is_null($data)) {
            session_start();
            for ($i = 0; $i < count($data); $i++) {
                $_SESSION['s_id'] = $data[$i][0];
                $_SESSION['s_username'] = $data[$i][1];
                $_SESSION['s_password'] = $data[$i][2];
                $_SESSION['s_email'] = $data[$i][3];
                $_SESSION['s_nama'] = $data[$i][4];
                $_SESSION['s_passwordmail'] = $data[$i][5];
                $_SESSION['s_role'] = $data[$i][6];
                $_SESSION['s_he'] = $data[$i][8];
                $_SESSION['s_ha'] = $data[$i][9];
            }
            $response = 1;
        } elseif (!is_null($data2)) {
            session_start();
            for ($i = 0; $i < count($data2); $i++) {
                $_SESSION['s_id'] = $data2[$i][0];
                $_SESSION['s_username'] = $data2[$i][1];
                $_SESSION['s_password'] = $data2[$i][2];
                $_SESSION['s_email'] = $data2[$i][3];
                $_SESSION['s_nama'] = $data2[$i][4];
                $_SESSION['s_passwordmail'] = $data2[$i][5];
                $_SESSION['s_role'] = $data2[$i][6];
                $_SESSION['s_he'] = $data2[$i][8];
                $_SESSION['s_ha'] = $data2[$i][9];
            }
        } else {
            header("location:../view/login.php?error=p");
        }
        return $response;
    }

    public function ganti($aksi) {
        session_start();
        $o_encrypt = new Encryption();
        if ($aksi == "edit_profile") {
            $id = $_POST['id'];
            $username = $_POST['username'];
            $email = $_POST['email'];
            $nama = $_POST['nama'];
            echo $id . '' . $username . '' . $email . '' . $nama;
            $this->objAdmin->update_admin($id, $username, $nama, $email);
            
            $_SESSION['s_username'] = $username;
            $_SESSION['s_email'] = $email;
            $_SESSION['s_nama'] = $nama;
            $_SESSION['info'] = "Akun";
            header("location:../view/profile.php");
        } else if ($aksi == "edit_password") {
            $id = $_POST['id'];
            $pass_lama = md5($_POST['password_lama']);
            $cek = $this->objAdmin->select_password($id, $pass_lama);
            $pass_baru = md5($_POST['password_baru']);
            if (count($cek) == 1) {
                $this->objAdmin->update_password_akun($id, $pass_baru);
                $_SESSION['s_password'] = $pass_baru;
                $_SESSION['info'] = "Password Akun";
                header("location:../view/profile.php");
            } else {
                $_SESSION['error'] = "Password Akun";
                header("location:../view/profile.php");
            }
        } else if ($aksi == "edit_password_email") {
            $id = $_POST['e_id'];
            $pass_akun = md5($_POST['password_akun']);
            $pass_lama = $o_encrypt->encode($_POST['password_lama']);
            $cek = $this->objAdmin->select_password_email($id, $pass_lama, $pass_akun);
            $cek2 = $this->objAdmin->select_password($id, $pass_akun);
            $pass_baru = $o_encrypt->encode($_POST['e_password_baru']);
            if (count($cek) == 1) {
                $this->objAdmin->update_password_email($id, $pass_baru);
                $_SESSION['s_passwordmail'] = $pass_baru;
                $_SESSION['info'] = "Password Akun";
                echo "1";
                header("location:../view/profile.php");
            } elseif (empty($_POST['password_lama']) && count($cek2) == 1) {
                echo "2";
                $this->objAdmin->update_password_email($id, $pass_baru);
                $_SESSION['s_passwordmail'] = $pass_baru;
                $_SESSION['info'] = "Password Akun";
                header("location:../view/profile.php");
            } else {
                $_SESSION['error'] = "Password Email";
                header("location:../view/profile.php");
            }
        }
    }

    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function kirim_email_password($email) {
        $status = "";
        require_once "PHPMailer-master/PHPMailerAutoload.php";
        $pass = $this->generateRandomString();
        $passmd5 = md5($pass);
        $this->objAdmin->update_password_akun2($email, $passmd5);
        try {
            $mail = new PHPMailer();
            $mail->IsSMTP(); // send via SMTP
            $mail->SMTPAuth = true; // turn on SMTP authentication
            $mail->Username = "muhammadmahruszain@gmail.com"; // Enter your SMTP username
            $mail->Password = "mahruszain1927"; // SMTP password
            $webmaster_email = "muhammadmahruszain@gmail.com"; //Add reply-to email address
            $email = $email; // Add recipients email address
            $name = "Admin"; // Add Your Recipient’s name
            $mail->From = $webmaster_email;
            $mail->FromName = "KKMC - Admin";
            $mail->AddAddress($email, $name);
            $mail->AddReplyTo($webmaster_email, "Webmaster");
            $mail->IsHTML(true); // send as HTML
            $mail->Subject = $subject;
            $mail->Body = 'Gunakan Password ' . $pass . ' untuk melakukan login ke Sistem ';      //HTML Body
            $mail->AltBody = $isi_email;     //Plain Text Body
            $mail->Send();
            $status = "terkirim";
        } catch (phpmailerException $e) {
            $status = "Erorr " . $e->errorMessage(); //Pretty error messages from PHPMailer
        } catch (Exception $e) {
            $status = "Erorr " . $e->getMessage(); //Boring error messages from anything else!
        }
    }

}

$o_admin = new AdminControl();
if (isset($_GET['aksi'])) {
    $o_admin->ganti($_GET['aksi']);
} else if (isset($_POST['kirim_password'])) {
    $email = $_POST['email'];
    $o_admin->kirim_email_password($email);
    $_SESSION['info'] = "Password Terkirim Ke email";
    header("location:../view/login.php?errorr=p");
} else if (isset($_GET['aktif'])) {
    $aktif = $_GET['aktif'];
    $id = $_GET['id'];
    $o_admin->update_status($id, $aktif);
    header("location:../view/admin.php");
} else if (isset($_GET['p'])) {
    session_start();
    if ($_GET['p'] == "tambah") {
        $email2 = $_POST['email2'];
        $anggota = $_POST['anggota'];
        $h_e=implode(",",$email2);
        $h_a=implode(",",$anggota);
        $username = $_POST['username'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        $nama = $_POST['nama'];
        $role = $_POST['role'];
        $o_admin->insert_admin($username, $password, $email, $nama, $role, $h_e, $h_a);
        $_SESSION['info'] = "Menambah";
        echo "Menambah";
    }else if ($_GET['p'] == "update") {
         $email2 = $_POST['email2'];
        $anggota = $_POST['anggota'];
           $id = $_POST['id'];
        $h_e=implode(",",$email2);
        $h_a=implode(",",$anggota);
        $username = $_POST['username'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        $nama = $_POST['nama'];
        $role = $_POST['role'];
        $o_admin->update_adminall($id, $username, $password, $email, $nama, $role, $h_e, $h_a);
        $_SESSION['info'] = "Mengedit";
        echo "Mengedit";
    } else if ($_GET['p'] == "hapus") {
        $id = $_GET['id'];
        $o_admin->delete_admin($id);
        $_SESSION['info'] = "Menghapus";
        header("location:../view/admin.php");
        $i = 3;
    }
}
?>