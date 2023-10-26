<?php
    class Panel {
        public static function isLogged() {
            return (isset($_SESSION['myblog-login'])) ? true : false;
        }

        public static function logout() {
            session_destroy();
            header('Location: '.INCLUDE_PATH_ADMIN);
    }

        public static function getRole($id) {
            $roles = ['Administrador', 'Usuário'];
            return $roles[$i];
        }
    }
?>
