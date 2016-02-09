<?php

$root = filter_input(INPUT_SERVER, "Root", FILTER_SANITIZE_URL);
require_once $root . 'model/database_model.php';

class AdminModel extends Database {

    public function __construct() {
        parent::__construct();
    }
    public function select_admin() {
        $statement = "select * from admin";
        return parent::fetch($statement, "admin");
    }
    public function select_password_email2($mail) {
        $statement = "select * from admin where email='$mail'";
        return parent::fetch($statement, "admin");
    }
    public function login_admin($username,$password) {
        $statement = "select * from admin where username='$username' AND password='$password' AND status='1'";
        return parent::fetch($statement, "admin");
    }
    public function login_admin2($username,$password) {
        $statement = "select * from admin where `email`='$username' AND password='$password'";
        return parent::fetch($statement, "admin");
    }
     public function update_admin($id,$username,$nama,$email) {
        $statement = "update `admin` SET `username`='$username',`email`='$email',`nama`='$nama' WHERE id=$id";
         return parent::exec($statement);
    } 
    public function update_status($id,$aktif) {
        $statement = "update `admin` SET `status`=$aktif WHERE id=$id";
         return parent::exec($statement);
    }
     public function delete_admin($id) {
        $statement = "delete FROM `admin` WHERE id=$id";
         return parent::exec($statement);
    }
     public function insert_admin($username,$password, $email, $nama, $role,$h_e,$h_a) {
         $pass=  md5($password);
        $statement = "insert INTO `admin`(`username`, `password`, `email`, `nama`, `password_email`, `role`, `status`,`hak_email`, `hak_anggota`) VALUES ('$username','$pass','$email','$nama','','$role',1,'$h_e','$h_a')";
         return parent::exec($statement);
    }
    public function update_adminall($id,$username,$password, $email, $nama, $role,$h_e,$h_a) {
        if(!empty($password)){
         $pass=  md5($password);
        $statement = "update `admin` SET `username`='$username',`password`='$pass',`email`='$email',`nama`='$nama',`role`='$role',`hak_email`='$h_e',`hak_anggota`='$h_a' WHERE id=$id";
         return parent::exec($statement);
        }else{
        $statement = "update `admin` SET `username`='$username',`email`='$email',`nama`='$nama',`role`='$role',`hak_email`='$h_e',`hak_anggota`='$h_a' WHERE id=$id";
         return parent::exec($statement);
        }
    }
    public function update_password_akun($id,$pass) {
        $statement = "update `admin` SET `password`='$pass' WHERE id=$id";
         return parent::exec($statement);
    }
    public function update_password_akun2($email,$pass) {
        $statement = "update `admin` SET `password`='$pass' WHERE email='$email'";
         return parent::exec($statement);
    }
    public function update_password_email($id,$pass) {
        $statement = "update `admin` SET `password_email`='$pass' WHERE id=$id";
         return parent::exec($statement);
    }
    public function select_password($id,$pass) {
        $statement = "select * from admin where id=$id AND password='$pass'";
        return parent::fetch($statement, "admin");
    }
     public function select_password_email($id,$pass,$pass_akun) {
        $statement = "select * from admin where id=$id AND password_email='$pass' AND password='$pass_akun'";
        return parent::fetch($statement, "admin");
    }

}
//$o_admin = new AdminModel();
//$o_admin->update_admin(2, 'a', 'b', 'x');
?>
