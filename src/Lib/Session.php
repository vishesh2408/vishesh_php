<?php
namespace App\Lib;

class Session{
	 public static function init(){
	 	if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
	 }
	 
	 public static function set($key, $val){
	 	$_SESSION[$key] = $val;
	 }

	 public static function get($key){
	 	if (isset($_SESSION[$key])) {
	 		return $_SESSION[$key];
	 	} else {
	 		return false;
	 	}
	 }
	 
	 public static function checkAdminSession(){
	 	self::init();
	 	if (self::get("login") == false || self::get("role") != 1) {
	 		// self::destroy(); // Don't destroy, just redirect if they are a regular user.
            // If they are not logged in, they go to login.
            if (self::get("login") == false) {
                 header("Location: /");
            } else {
                 header("Location: /exam"); // Redirect user to their dashboard
            }
            exit();
	 	}
	 }
	 
	 public static function checkAdminLogin(){
	 	self::init();
	 	if (self::get("adminLogin") == true) {
	 		header("Location: /admin/dashboard");
            exit();
	 	}
	 }

	 public static function checkSession(){
	 	self::init();
	 	if (self::get("login") == false) {
	 		self::destroy();
	 		header("Location: /");
            exit();
	 	}
	 }

	 public static function checkLogin(){
	 	self::init();
	 	if (self::get("login") == true) {
	 		header("Location: /exam");
            exit();
	 	}
	 }

	 public static function destroy(){
	 	session_destroy();
	 	session_unset();
	 }
}
