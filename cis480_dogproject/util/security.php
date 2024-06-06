<?php
class Security {
    
    //Function to Log out.
    public static function logout() {
        unset($_SESSION);

        unset($_POST);

        $_SESSION['logout_msg'] = 'Successfully logged out.';
        header('Location: ../index.php');
        exit();
    }
    //Function for denying access to unauthorized users.
    public static function checkAuthority($auth) {
        if (!isset($_SESSION[$auth]) || !$_SESSION[$auth]) {
            $_SESSION['logout_msg'] =
                'Current login unauthorized for this page.';
            header('Location: ../index.php');
            exit();
        }
    }
}
?>