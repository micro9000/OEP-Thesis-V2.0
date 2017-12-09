<?php
   class Admin_Connection{

        private $serverName = "127.0.0.1";
        private $username = "root";
        private $password = "";
        private $database = "OEPDb";

        public $conn;

        public function __construct(){

            // if (session_status() == PHP_SESSION_NONE) {
            //     session_start();
            // }

            $this->conn = new mysqli($this->serverName, $this->username, $this->password, $this->database);

            // logout user and approver after the given time expire
            // $timeNow = time();
            // if (isset($_SESSION['discard_after']) && $timeNow > $_SESSION['discard_after']) {
            //     // this session has worn out its welcome; kill it and start a brand new one
            //     $this->logoutUser();
            //     $this->logoutApprover();
            // }
            // $_SESSION['discard_after'] = $timeNow + 18000 ; // 1 hr = 3600

            // echo $this->mail_utf8('raniel garcia<ranielgarcia2596@gmail.com>', 'HEY', 'HEY');
        }

        public function getAdminID(){
            return isset($_SESSION['admin_userID']) ? $_SESSION['admin_userID'] : 0;
        }

        public function getAdminUsername(){
            return isset($_SESSION['admin_username']) ? $_SESSION['admin_username'] : "";
        }

        public static function logoutUser(){
            // session_start();

            unset($_SESSION['admin_loggedIn']);
            unset($_SESSION['admin_userID']);
            unset($_SESSION['admin_email_address']);
            unset($_SESSION['admin_username']);
            unset($_SESSION['user_type']);
        }

        public function isUserType_Admin(){
            if (isset($_SESSION['user_type']) && ($_SESSION['user_type'] == 1 || $_SESSION['user_type'] == "1")){
                return true;
            }
            return false;
        }

        public function isAdminLoggedIn(){
            // session_start();

            if(isset($_SESSION['admin_userID']) && isset($_SESSION['admin_email_address']) &&
                 isset($_SESSION['admin_loggedIn']) && $_SESSION['admin_loggedIn'] == true){
                return true;
            }
            return false;
        }

        public function sanitizeInput($input){
            $inputTemp = "";

            $inputTemp = htmlspecialchars($input, ENT_QUOTES);
            $inputTemp = filter_var($inputTemp, FILTER_SANITIZE_STRING);
            $inputTemp = $this->conn->real_escape_string($inputTemp);

            return $inputTemp;
        }

        public function reArrayFilesMultiple(&$files) {
            $uploads = array();
            foreach($_FILES as $key0=>$FILES) {
                foreach($FILES as $key=>$value) {
                    foreach($value as $key2=>$value2) {
                        $uploads[$key0][$key2][$key] = $value2;
                    }
                }
            }
            $files = $uploads;
            return $uploads; // prevent misuse issue
        }

        public function mail_utf8($to, $subject = '(No subject)', $message = ''){
            // $withCC = true
            $sender = "ranielgarcia101@gmail.com";
            $from_user = "SAMPLE";

            $from_user = "=?UTF-8?B?".base64_encode($from_user)."?=";
            $subject = "=?UTF-8?B?".base64_encode($subject)."?=";

            $headers = "From: $sender <$sender> \r\n";
            // if($withCC === true){
            //     $headers .= "CC: $this->admins_ToNotify_ONNewTMAdded_config \r\n";
            // }
            $headers .= "MIME-Version: 1.0" . " \r\n" ;
            $headers .= "Content-type: text/html; charset=UTF-8 \r\n";

            return mail($to, $subject, $message, $headers);
        }
    }

 ?>
