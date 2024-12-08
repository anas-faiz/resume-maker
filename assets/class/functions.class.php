<?php
session_start(); // Ensure that the session is started

class functions {

    public function redirect($address) {
        header("Location: " . $address);
        exit; // Make sure to stop further code execution after redirect
    }

    public function setError($msg) {
        $_SESSION['error'] = $msg;
    }

    public function setAuth($data) {
        $_SESSION['AUTH'] = $data;
    }

    public function auth(){
        if(isset($_SESSION['AUTH'])){
            return $_SESSION['AUTH'];
        }else{
            return false;
        }
    }

    public function authPage(){
        if(!isset($_SESSION['AUTH'])){
            $this->redirect('login.php');
        }
    }

    public function setSession($key,$value){
        $_SESSION[$key]=$value;
    }

    public function getSession($key){
        $_SESSION[$key];
    }

    public function nonAuthPage(){
        if(isset($_SESSION['AUTH'])){
            $this->redirect('myresumes.php');
        }
    }


    public function error() {
        if (isset($_SESSION['error'])) {
            // Properly concatenate the error message into JavaScript
            echo " Swal.fire('','" . $_SESSION['error']."','error') ";
            unset($_SESSION['error']);
        }
    }

    public function setAlert($msg) {
        $_SESSION['alert'] = $msg;
    }

    public function alert() {
        if (isset($_SESSION['alert'])) {
            // Properly concatenate the alert message into JavaScript
            echo "Swal.fire('','" . $_SESSION['alert'] . "',')";
            unset($_SESSION['alert']);
        }
    }

    public function randomstr(){
        $string="0123456789abcdefghijklmnopqurstuvwxyz/.,;']\[-";
        $string=str_shuffle($string);
        return str_split($string,16)[0];
    }
}

$fn = new functions();
?>
