<?php
namespace App\Controllers;

use App\Models\User;

class AuthController {
    public function showRegister() {
        include __DIR__ . '/../../views/register.php';
    }
    
    public function login() {
        $user = new User();
        // Since we are not using a full Request object, we access $_POST directly
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
             $email    = $_POST['email'];
             $password = $_POST['password'];
        
             // Returns echo output directly as per original logic
             $user->userLogin($email, $password);
        }
    }

     public function register() {
          $user = new User();
          if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $name     = $_POST['name'];
                $userName = $_POST['userName'];
                $password = $_POST['password'];
                $email    = $_POST['email'];
                $institution = isset($_POST['institution']) ? $_POST['institution'] : '';
                $institution_id = isset($_POST['institution_id']) ? $_POST['institution_id'] : '';
         
                $user->userRegistion($name, $userName, $password, $email, $institution, $institution_id);
          }
     }

    public function showForgot() {
    	include __DIR__ . '/../../views/forgot.php';
    }

    public function handleForgot() {
    	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    		$email = $_POST['email'];
    		$user = new \App\Models\User();
    		// Generate pseudo-random token
    		$token = bin2hex(random_bytes(16));
    		if ($user->setResetToken($email, $token)) {
    			echo "success|$token";
    		} else {
    			echo "error";
    		}
    	}
    }

    public function showReset() {
    	include __DIR__ . '/../../views/reset.php';
    }
    
    public function handleReset() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $token = $_POST['token'];
            $password = $_POST['password'];
            $user = new \App\Models\User();
            if ($user->resetPassword($token, $password)) {
                echo "success";
            } else {
                echo "error";
            }
        }
    }
}
