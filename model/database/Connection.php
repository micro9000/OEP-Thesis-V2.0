<?php
	class Connection{

		private $server = "127.0.0.1";
		private $username = "root";
		private $password = "";
		private $database = "OEPDb";

		public $conn;

		public function __construct(){

			$this->conn = new mysqli($this->server, $this->username, $this->password, $this->database);

			// echo $this->mail_utf8('ranielgarcia2596@gmail.com', 'HEY', 'Sample email');
		}

		public function sanitizeInput($input){
            $inputTemp = "";

            $inputTemp = htmlspecialchars($input, ENT_QUOTES);
            $inputTemp = filter_var($inputTemp, FILTER_SANITIZE_STRING);
            $inputTemp = $this->conn->real_escape_string($inputTemp);

            return $inputTemp;
        }

        public function mail_utf8($to, $subject = '(No subject)', $message = ''){
        	// $withCC = true
            // onebuffetrncs2017@gmail.com
            // Welcome2017OneBuffet
            $sender = "onebuffetrncs101@gmail.com";
            $from_user = "One Buffet Restaurant & Catering Services";

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
