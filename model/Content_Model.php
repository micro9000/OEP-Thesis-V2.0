<?php
	
	require_once("database/Connection.php");

	class Content_Model extends Connection{

		public function __construct(){
			parent::__construct();
			date_default_timezone_set('Asia/Manila');
		}

		public function getAllSlideshow(){

			$slideshow = array();
			$slideshowData = array();

			if (! $this->conn->connect_error){

				$query = "SELECT * FROM Slideshow WHERE isDeleted=0 ORDER BY id DESC";

				$result = $this->conn->query($query);

				if (is_object($result) && !empty($result->num_rows)) {
					while ($row = $result->fetch_assoc()) {

						$slideshowData = array("id" => $row['id'],
										  "firstTitle" => $row['firstTitle'],
										  "secondTitle" => $row['secondTitle'],
										  "content" => $row['content'],
										  "imgServerFileName" => $row['imgServerFileName'],
										  "imgOrigFilename" => $row['imgOrigFilename'],
										  "userName" => $row['userName'],
										  "userId" => $row['userId'] 
										);

						array_push($slideshow, $slideshowData);
					}

					$result->free();

					return $slideshow;
				}
			}
			
			return $slideshow;
		}

		public function getEvents_Query($query){

			$events = array();
			$eventsData = array();

			if (! $this->conn->connect_error){

				$result = $this->conn->query($query);

				if (is_object($result) && !empty($result->num_rows)) {
					while ($row = $result->fetch_assoc()) {

						$eventsData = array("id" => $row['id'],
										  	"serviceID" => $row['serviceID'],
										  	"eventName" => $row['eventName'],
										  	"address" => $row['address'],
										  	"eventDate" => $row['eventDate'],
										  	"description" => $row['description'],
										  	"comments" => $row['comments'],
										  	"userName" => $row['userName'],
										  	"userId" => $row['userId'],
										  	"service" => $row['service']
										);

						array_push($events, $eventsData);
					}

					$result->free();

					return $events;
				}
			}
			
			return $events;
		}

		public function getEventsByFlag($all = true, $limit = 0){

			$events = array();
			

			$query = "";
			if ($all == true && $limit == 0){

				$query = "SELECT RE.*, S.service
					FROM RecentEvents As RE, Services As S
					WHERE RE.isDelete=0 AND RE.serviceID=S.id ORDER BY RE.id DESC";

			}else if ($all == false && $limit > 0){
				$query = "SELECT RE.*, S.service
					FROM RecentEvents As RE, Services As S
					WHERE RE.isDelete=0 AND RE.serviceID=S.id ORDER BY RE.id DESC LIMIT " . $limit;
			}

			$events = $this->getEvents_Query($query);

			return $events;
		}

		public function getEventInfoByID($eventID = 0){

			$events = array();
			
			$eventID = $this->sanitizeInput($eventID);

			$query = "SELECT RE.*, S.service
					FROM RecentEvents As RE, Services As S
					WHERE RE.isDelete=0 AND RE.serviceID=S.id AND RE.id=" . $eventID ;

			$events = $this->getEvents_Query($query);

			
			return $events;
		}


		public function getEventInfoByServiceID($serviceID = 0){

			$events = array();
			
			$serviceID = $this->sanitizeInput($serviceID);

			$query = "SELECT RE.*, S.service
					FROM RecentEvents As RE, Services As S
					WHERE RE.isDelete=0 AND RE.serviceID=S.id AND RE.serviceID=" . $serviceID ;

			$events = $this->getEvents_Query($query);

			
			return $events;
		}

		public function getEventOneImageByID($eventID){

			$imagesData = array();

			if (! $this->conn->connect_error){

				$eventID = $this->sanitizeInput($eventID);

				$query = "SELECT * FROM RecentEvents_Images WHERE isDelete=0 AND eventID=". $eventID ." LIMIT 1";

				$result = $this->conn->query($query);

				if (is_object($result) && !empty($result->num_rows)) {
					while ($row = $result->fetch_assoc()) {

						$imagesData = array("id" => $row['id'],
										  	"eventID" => $row['eventID'],
										  	"serverName" => $row['serverName'],
										  	"origName" => $row['origName']
										);

						$result->free();
						return $imagesData;
					}
				}
			}
			
			return $imagesData;
		}

		public function getEventImagesByID($eventID){

			$images = array();
			$imagesData = array();

			if (! $this->conn->connect_error){

				$eventID = $this->sanitizeInput($eventID);

				$query = "SELECT * FROM RecentEvents_Images WHERE isDelete=0 AND eventID=". $eventID;

				$result = $this->conn->query($query);

				if (is_object($result) && !empty($result->num_rows)) {
					while ($row = $result->fetch_assoc()) {

						$imagesData = array("id" => $row['id'],
										  	"eventID" => $row['eventID'],
										  	"serverName" => $row['serverName'],
										  	"origName" => $row['origName']
										);

						array_push($images, $imagesData);
					}

					$result->free();
					return $images;
				}
			}
			
			return $images;
		}

		public function getEventService($serviceID){

			$service = "NONE";

			if (! $this->conn->connect_error){

				$serviceID = $this->sanitizeInput($serviceID);

				$query = "SELECT service FROM Services WHERE id=" . $serviceID;

				$result = $this->conn->query($query);

				if (is_object($result) && !empty($result->num_rows)) {
					while ($row = $result->fetch_assoc()) {
						$service = $row['service'];
						return $service;
					}
				}
			}
			
			return $service;
		}

		public function getPartners_Query($query){

			$partners = array();
			$partnersData = array();

			if (! $this->conn->connect_error){

				$result = $this->conn->query($query);

				if (is_object($result) && !empty($result->num_rows)) {
					while ($row = $result->fetch_assoc()) {

						$partnersData = array("id" => $row['id'],
										  	  "partnerName" => $row['partnerName'],
										  	  "info" => $row['info'],
										  	  "contactSmart" => $row['contactSmart'],
										  	  "contactGlobe" => $row['contactGlobe'],
										  	  "contactEmail" => $row['contactEmail'],
										  	  "userName" => $row['userName'],
										  	  "userId" => $row['userId']
										);

						array_push($partners, $partnersData);
					}

					$result->free();

					return $partners;
				}
			}
			
			return $partners;
		}

		public function getAllPartners(){

			$partners = array();
		
			$query = "SELECT * FROM Partners WHERE isDeleted=0 ORDER BY id DESC";

			$partners = $this->getPartners_Query($query);

			return $partners;

		}

		public function getPartnerInfo($partnerID){

			$partners = array();

			$partnerID = $this->sanitizeInput($partnerID);
		
			$query = "SELECT * FROM Partners WHERE isDeleted=0 AND id=" . $partnerID;

			$partners = $this->getPartners_Query($query);

			return $partners;

		}

		public function getServices_Query($query){
			$services = array();

			if (! $this->conn->connect_error){

				$result = $this->conn->query($query);

				if (is_object($result) && !empty($result->num_rows)) {
					while ($row = $result->fetch_assoc()) {

						array_push($services, array("id" => $row['id'],
											"service" => $row['service']) );
					}

					$result->free();
					return $services;
				}
			}
			return $services;
		}

		public function getAllServices(){

			$services = array();
			$query = "SELECT * FROM Services WHERE isDeleted=0";

			$services = $this->getServices_Query($query);

			return $services;
		}

		public function getServiceMotifs_Query($query){

			$services = array();

			if (! $this->conn->connect_error){

				$result = $this->conn->query($query);

				if (is_object($result) && !empty($result->num_rows)) {
					while ($row = $result->fetch_assoc()) {

						array_push($services, array("id" => $row['id'],
											"service" => $row['service'],
											"motif" => $row['motif']));
					}

					$result->free();
					return $services;
				}
			}
			return $services;
		}

		public function getServiceMotifsByserviceID($serviceId){

			$services = array();

			$serviceId = $this->sanitizeInput($serviceId);

			$query = "SELECT SM.id, S.service, SM.motif
                                  FROM  Services as S, ServiceMotifs as SM
                                  WHERE SM.serviceID=S.id AND S.isDeleted=0 AND SM.isDeleted=0 AND S.id=" . $serviceId;

			$services = $this->getServiceMotifs_Query($query);
			
			return $services;
		}

		public function getAllVenues(){

			$venues = array();

			if (! $this->conn->connect_error){

				$query = "SELECT * FROM Venues WHERE isDeleted=0 ORDER BY id DESC";

				$result = $this->conn->query($query);

				if (is_object($result) && !empty($result->num_rows)) {
					while ($row = $result->fetch_assoc()) {

						array_push($venues, array("id" => $row['id'],
												 "venue" => $row['venue']));
					}

					$result->free();
					return $venues;
				}
			}
			return $venues;
		}

		public function getVenueNotes_isOutside($venueID){

			$notes = array();

			if (! $this->conn->connect_error){

				$venueID = $this->sanitizeInput($venueID);

				$query = "SELECT notes, isOutside FROM Venues WHERE isDeleted=0 AND id=". $venueID;

				$result = $this->conn->query($query);

				if (is_object($result) && !empty($result->num_rows)) {
					while ($row = $result->fetch_assoc()) {
						$notes = array("notes" => $row['notes'], 
										"isOutside" => $row['isOutside']);
					}

					$result->free();
				}
			}
			return $notes;
		}

		public function getAllBudgetRanges(){

			$budgets = array();

			if (! $this->conn->connect_error){

				$query = "SELECT * FROM BudgetRanges WHERE isDeleted=0 ORDER BY id DESC";

				$result = $this->conn->query($query);

				if (is_object($result) && !empty($result->num_rows)) {
					while ($row = $result->fetch_assoc()) {

						array_push($budgets, array("id" => $row['id'],
												 "budgetRange" => $row['budgetRange']));
					}

					$result->free();
					return $budgets;
				}
			}
			return $budgets;
		}

		public function sendInquiry($sender, $msg){
			$subject = "New Inquiry " . $sender;
			return $this->mail_utf8('onebuffetrncs2017@gmail.com', $subject, $msg);
		}

		public function insertNewInquiry($data = array()){

			if (sizeof($data) == 0){
				return 0;
			}

			if (! $this->conn->connect_error){

				$emailAdd = $this->sanitizeInput($data['emailAdd']);
				$inqName = $this->sanitizeInput($data['inqName']);
				$contactNo = $this->sanitizeInput($data['contactNo']);
				$typeOfEvent = $this->sanitizeInput($data['typeOfEvent']);
				$typeOfVenue = $this->sanitizeInput($data['typeOfVenue']);
				$venueAddress = $this->sanitizeInput($data['venueAddress']);
				$noOfGuest = $this->sanitizeInput($data['noOfGuest']);
				$inquiry = $this->sanitizeInput($data['inquiry']);

				$query = "INSERT INTO Inquiries(email, name, contactNo, event, venue, venueAddress, noOfGuests, inquiry) ";
				$query .= "VALUES('". $emailAdd ."','". $inqName ."','". $contactNo ."','". $typeOfEvent ."','". $typeOfVenue ."', '". $venueAddress ."', ". $noOfGuest .",'". $inquiry ."')";

				if ($this->conn->query($query) === TRUE){
                    return $this->conn->affected_rows;
                }
                return 0;
			}
		}

		public function getClientTag($email){
			$text = $email . date("l jS \of F Y h:i:s A");
			$textHash = hash('sha512', $text);
			return $textHash;
		}

		public function insertNewRegisteringEmail($emailAdd){

			if (! $this->conn->connect_error){

				$emailAdd = $this->sanitizeInput($emailAdd);
				$clientTag = $this->getClientTag($emailAdd);

				$isSent = $this->sendEmailConfirmation($emailAdd, $clientTag);

				// echo $isSent

				if ($isSent == true || $isSent == 1){
					$query = "INSERT INTO RegisteredEmails(email, uniqueTag) ";
					$query .= "VALUES('". $emailAdd ."', '". $clientTag ."')";

					// echo $query;

					if ($this->conn->query($query) === TRUE){
	                    return $this->conn->affected_rows;
	                }
				}

                return 0;
			}
		}

		// ######################################################################################################
		// ######################################################################################################
		// ######################################################################################################
		// Change the path
		// ######################################################################################################
		// ######################################################################################################
		public function sendEmailConfirmation($clientEmail, $clientTag){
			// $__headers = apache_request_headers();
			$domain = $_SERVER['HTTP_HOST'];//$__headers['Host'];

			$msg = "<p>Hi, Thank you for your Registration</p>";
			$msg .= "<p>Please click the link below to continue</p>";
			$msg .= "http://" . $domain ."/view/clientRegistration_phaseone.php?regTag=". $clientTag;

			$sendRes = $this->mail_utf8($clientEmail, 'Email Confirmation', $msg);

			return $sendRes;

			// if ($sendRes == true || $sendRes == 1){
			// 	return true;
			// }

			// return false;
		}

		public function sendEmailConfirmationForPassRec($clientEmail, $clientTag){
			// $__headers = apache_request_headers();
			$domain = $_SERVER['HTTP_HOST'];//$__headers['Host'];

			$msg = "<p>Password Recovery</p>";
			$msg .= "<p>Please click the link below to continue</p>";
			$msg .= "http://" . $domain ."/OEP/view/changeClientPass.php?tag=". $clientTag ."&email=" . $clientEmail;

			$sendRes = $this->mail_utf8($clientEmail, 'Password Recovery', $msg);

			return $sendRes;

		}

		public function checkEmailIsRegisteredByQuery($query){

			$emailID = 0;

			if (! $this->conn->connect_error){

				$result = $this->conn->query($query);

				if (is_object($result) && !empty($result->num_rows)) {
					while ($row = $result->fetch_assoc()) {
						$emailID = $row['id'];
					}
					$result->free();
				}
			}

			if ($emailID > 0 && $emailID != 0){
				return true;
			}
			return false;
		}

		public function isEmailIsRegistered($emailAdd){
			$emailAdd = $this->sanitizeInput($emailAdd);
			$query = "SELECT * FROM RegisteredEmails WHERE email='". $emailAdd ."' AND isConfirm=1 ORDER BY id DESC LIMIT 1";
			return $this->checkEmailIsRegisteredByQuery($query);
		}

		public function isUniqueTagIsRegistered($tag){
			$tag = $this->sanitizeInput($tag);

			if (strlen($tag) == 128){
				$query = "SELECT * FROM RegisteredEmails WHERE uniqueTag='". $tag ."' AND isConfirm=0 ORDER BY id DESC LIMIT 1";
				return $this->checkEmailIsRegisteredByQuery($query);
			}

			return false;
		}

		public function confirmNewRegisteringEmail($uniqueTag){

			if (! $this->conn->connect_error){

				$uniqueTag = $this->sanitizeInput($uniqueTag);

				$query = "UPDATE RegisteredEmails SET isConfirm=1 WHERE uniqueTag='". $uniqueTag ."'";

				if ($this->conn->query($query) === TRUE){
                    return $this->conn->affected_rows;
                }

                return 0;
			}
		}

		public function getClientEmail($uniqueTag){

			$email = "";

			if (! $this->conn->connect_error){

				$uniqueTag = $this->sanitizeInput($uniqueTag);

				$query = "SELECT email FROM RegisteredEmails WHERE uniqueTag='". $uniqueTag ."' ORDER BY id DESC LIMIT 1";

				$result = $this->conn->query($query);

				if (is_object($result) && !empty($result->num_rows)) {
					while ($row = $result->fetch_assoc()) {
						$email = $row['email'];
					}

					$result->free();
				}
			}
			return $email;
		}

		public function insertNewRegisteringClient($emailAdd, $regTag, $fullName, $contactNo, $password){

			if (! $this->conn->connect_error){

				$emailAdd = $this->sanitizeInput($emailAdd);
				$regTag = $this->sanitizeInput($regTag);
				$fullName = $this->sanitizeInput($fullName);
				$contactNo = $this->sanitizeInput($contactNo);
				$password = $this->sanitizeInput($password);

				$hashPass = hash('sha512', $password);
				
				$query = "INSERT INTO RegisteredClient(email, uniqueTag, fullName, contactNo, clientPass) ";
				$query .= "VALUES('". $emailAdd ."', '". $regTag ."', '". $fullName ."', '". $contactNo ."', '". $hashPass ."')";

				if ($this->conn->query($query) === TRUE){
                    return $this->conn->affected_rows;
                }

                return 0;
			}
		}

		public function isClientRegistered($emailAdd, $password){

			$clientInfo = array();

			if (! $this->conn->connect_error){

				$emailAdd = $this->sanitizeInput($emailAdd);
				$password = $this->sanitizeInput($password);
				$hashPass = hash('sha512', $password);

				$query = "SELECT * FROM RegisteredClient WHERE email='". $emailAdd ."' AND clientPass='". $hashPass ."' ORDER BY id DESC LIMIT 1 ";

				$result = $this->conn->query($query);

				if (is_object($result) && !empty($result->num_rows)) {
					while ($row = $result->fetch_assoc()) {

						$clientInfo = array(
										"id" => $row['id'],
										"email" => $row['email'],
										"uniqueTag" => $row['uniqueTag'],
										"fullName" => $row['fullName'],
										"contactNo" => $row['contactNo'],
										"dateReg" => $row['dateReg']
									);
					}
					$result->free();
				}
			}
			return $clientInfo;
		}

		public function isClientEmailRegistered($emailAdd){ // #######################################

			$clientInfo = array();

			if (! $this->conn->connect_error){

				$emailAdd = $this->sanitizeInput($emailAdd);

				$query = "SELECT * FROM RegisteredClient WHERE email='". $emailAdd ."' ORDER BY id DESC LIMIT 1 ";

				$result = $this->conn->query($query);

				if (is_object($result) && !empty($result->num_rows)) {
					while ($row = $result->fetch_assoc()) {

						$clientInfo = array(
										"id" => $row['id'],
										"email" => $row['email'],
										"uniqueTag" => $row['uniqueTag'],
										"fullName" => $row['fullName'],
										"contactNo" => $row['contactNo'],
										"dateReg" => $row['dateReg']
									);
					}
					$result->free();
				}
			}
			return $clientInfo;
		}

		public function insertClientEmailRecovered($emailAdd, $tag, $clientId){

			if (! $this->conn->connect_error){

				$emailAdd = $this->sanitizeInput($emailAdd);
				$tag = $this->sanitizeInput($tag);
				$clientId = $this->sanitizeInput($clientId);

				$query = "INSERT INTO Clients_RecoveredEmail(email_address, clientID, tag) ";
				$query .= "VALUES('". $emailAdd ."', ". $clientId .", '". $tag ."')";

				if ($this->conn->query($query) === TRUE){
                    return $this->conn->affected_rows;
                }

                return 0;
			}
		}

		public function client_login($emailAdd, $password){
			$clientInfo = $this->isClientRegistered($emailAdd, $password);

			if (sizeof($clientInfo) > 0){

				$_SESSION['client_ID'] = $clientInfo['id'];
				$_SESSION['client_Email'] = $emailAdd;
				$_SESSION['client_UniqueTag'] = $clientInfo['uniqueTag'];
				$_SESSION['client_FullName'] = $clientInfo['fullName'];
				$_SESSION['client_ContactNo'] = $clientInfo['contactNo'];
				$_SESSION['client_DateReg'] = $clientInfo['dateReg'];

				return true;
			}
			return false;
		}

		public function isClientLoggedIn(){
			if (
				isset($_SESSION['client_ID']) &&
				isset($_SESSION['client_Email']) &&
				isset($_SESSION['client_UniqueTag']) &&
				isset($_SESSION['client_FullName']) &&
				isset($_SESSION['client_ContactNo']) &&
				isset($_SESSION['client_DateReg'])
			){
				return true;
			}
			return false;
		}

		public function client_logout(){
			unset($_SESSION['client_ID']);
			unset($_SESSION['client_Email']);
			unset($_SESSION['client_UniqueTag']);
			unset($_SESSION['client_FullName']);
			unset($_SESSION['client_ContactNo']);
			unset($_SESSION['client_DateReg']);
		}

		public function getMaterial_Query($query){

			$materials = array();
			$materialData = array();

			if (! $this->conn->connect_error){

				$result = $this->conn->query($query);

				if (is_object($result) && !empty($result->num_rows)) {
					while ($row = $result->fetch_assoc()) {

						$materialData = array("id" => $row['id'],
											  "material" => $row['material'],
											  "userName" => $row['userName']
										);

						array_push($materials, $materialData);
					}

					$result->free();

					return $materials;
				}
			}
			
			return $materials;
		}

		public function getAllMaterials(){
			$materials = array();
			$query = "SELECT * FROM Materials WHERE isDeleted=0 ORDER BY id DESC";
			$materials = $this->getMaterial_Query($query);
			return $materials;
		}

		public function getMaterialByID($materialID){
			$materials = array();

			$materialID = $this->sanitizeInput($materialID);
			$query = "SELECT * FROM Materials WHERE isDeleted=0 AND id=" . $materialID;
			$materials = $this->getMaterial_Query($query);
			return $materials;
		}

		public function getThemesPerMaterialBy_Query($query){

			$themes = array();
			$themesData = array();

			if (! $this->conn->connect_error){

				$result = $this->conn->query($query);

				if (is_object($result) && !empty($result->num_rows)) {
					while ($row = $result->fetch_assoc()) {

						$themesData = array("id" => $row['id'],
											 "material" => $row['material'],
											 "theme" => $row['theme'],
											 "userName" => $row['userName']
										);

						array_push($themes, $themesData);
					}

					$result->free();

					return $themes;
				}
			}
			
			return $themes;
		}

		public function getThemesByMaterialID($materialID){

			$themes = array();

			$materialID = $this->sanitizeInput($materialID);

			$query = "SELECT MT.id, M.material, MT.theme, MT.userName, MT.userId
						  FROM Materials As M, MaterialThemes As MT
						  WHERE MT.materialID=M.id AND MT.isDeleted=0 AND M.isDeleted=0 AND MT.materialID=" . $materialID;

			$themes = $this->getThemesPerMaterialBy_Query($query);
			
			return $themes;
		}

		public function getThemes_Images_Query($query){

			$images = array();
			$imagesData = array();

			if (! $this->conn->connect_error){

				$result = $this->conn->query($query);

				if (is_object($result) && !empty($result->num_rows)) {
					while ($row = $result->fetch_assoc()) {

						$imagesData = array("id" => $row['id'],
											 "serverName" => $row['serverName'],
											 "origName" => $row['origName'],
											 "referenceNo" => $row['referenceNo'],
											 "price" => $row['price']
										);

						array_push($images, $imagesData);
					}

					$result->free();

					return $images;
				}
			}
			
			return $images;
		}

		public function getAllThemes_Images($themeID){

			$images = array();

			$themeID = $this->sanitizeInput($themeID);

			$query = "SELECT * FROM MaterialsTheme_images WHERE isDeleted=0 AND themeID=" . $themeID;

			$images = $this->getThemes_Images_Query($query);

			return $images;
		}

		public function getAllProductCategory(){

			$categories = array();
			$catData = array();

			if (! $this->conn->connect_error){

				$query = "SELECT * FROM PartnersProductCategory WHERE isDeleted=0 ORDER BY id DESC";

				$result = $this->conn->query($query);

				if (is_object($result) && !empty($result->num_rows)) {
					while ($row = $result->fetch_assoc()) {

						$catData = array("id" => $row['id'],
												"prodCat" => $row['prodCat']
										);

						array_push($categories, $catData);
					}

					$result->free();

					return $categories;
				}
			}
			
			return $categories;
		}

		public function getPartnersMotifsByProdCat($prodCatID){

			$motifs = array();

			if (! $this->conn->connect_error){

				$prodCatID = $this->sanitizeInput($prodCatID);

				$query = "SELECT PM.id, PM.theme, P.partnerName
						FROM PartnersMotif As PM,PartnersProductCategory As PPC, Partners as P
						WHERE PM.isDeleted=0 AND PM.partnerID=P.id AND PM.prodCatID=PPC.id AND PPC.id=" . $prodCatID;

				$result = $this->conn->query($query);

				if (is_object($result) && !empty($result->num_rows)) {
					while ($row = $result->fetch_assoc()) {

						$motifData = array("id" => $row['id'],
										  "theme" => $row['theme'],
										  "partnerName" => $row['partnerName']
										);

						array_push($motifs, $motifData);
					}

					$result->free();
				}
			}
			
			return $motifs;
		}

		public function getPartnersMotifImages_Query($query){

			$images = array();
			$imagesData = array();

			if (! $this->conn->connect_error){

				$result = $this->conn->query($query);

				if (is_object($result) && !empty($result->num_rows)) {
					while ($row = $result->fetch_assoc()) {

						$imagesData = array("id" => $row['id'],
											"motifID" => $row['motifID'],
											"serverName" => $row['serverName'],
											"origName" => $row['origName'],
											"imageRefNo" => $row['imageRefNo'],
											"price" => $row['price']
										);

						array_push($images, $imagesData);
					}

					$result->free();

					return $images;
				}
			}
			
			return $images;
		}

		public function getPartnerMotifsImages($motifID){

			$images = array();

			$motifID = $this->sanitizeInput($motifID);
		
			$query = "SELECT * FROM PartnersMotifImages WHERE isDelete=0 AND motifID=" . $motifID;

			$images = $this->getPartnersMotifImages_Query($query);

			return $images;
		}

		public function getMenus_Query($query){

			$menus = array();

			if (! $this->conn->connect_error){

				$result = $this->conn->query($query);

				if (is_object($result) && !empty($result->num_rows)) {
					while ($row = $result->fetch_assoc()) {

						array_push($menus, array("id" => $row['id'],
													"setTitle" => $row['setTitle'],
													"setPrice" => $row['setPrice'],
													"soup" => $row['soup'],
													"soupIsChangable" => $row['soupIsChangable'],
													"chicken" => $row['chicken'],
													"chickenIsChangable" => $row['chickenIsChangable'],
													"seafoods" => $row['seafoods'],
													"seafoodsIsChangable" => $row['seafoodsIsChangable'],
													"porkBeef" => $row['porkBeef'],
													"porkBeefIsChangable" => $row['porkBeefIsChangable'],
													"vegetable" => $row['vegetable'],
													"vegetableIsChangable" => $row['vegetableIsChangable'],
													"rice" => $row['rice'],
													"riceIsChangable" => $row['riceIsChangable'],
													"salad" => $row['salad'],
													"saladIsChangable" => $row['saladIsChangable'],
													"dessert" => $row['dessert'],
													"dessertIsChangable" => $row['dessertIsChangable'],
													"drinks" => $row['drinks'],
													"drinksIsChangable" => $row['drinksIsChangable']
											));
					}

					$result->free();
					return $menus;
				}
			}
			return $menus;
		}

		public function getAllMenus(){

			$menus = array();

			$query = "SELECT * FROM Menus WHERE isDeleted=0";

			$menus = $this->getMenus_Query($query);
			
			return $menus;
		}

		public function getMenuByID($id){

			$menus = array();

			$id = $this->sanitizeInput($id);

			$query = "SELECT * FROM Menus WHERE isDeleted=0 AND id=" . $id;

			$menus = $this->getMenus_Query($query);
			
			return $menus;
		}

		public function getMenuItem($column){

			$items = array();

			if (! $this->conn->connect_error){

				$column = $this->sanitizeInput($column);

				$query = "SELECT ". $column ." FROM Menus WHERE isDeleted=0";

				$result = $this->conn->query($query);

				if (is_object($result) && !empty($result->num_rows)) {
					while ($row = $result->fetch_assoc()) {

						array_push($items, array(
									"id" => "id",
									$column => $row[$column]
							));

					}

					$result->free();
				}
			}
			
			return $items;
		}

		public function getProperDate($dateStr){
			$dateTemp = strtotime($dateStr);
   			$properDate = date("Y-m-d", $dateTemp);

   			return $properDate;
		}

		public function isSelectedDateAlreadyUsed($selectedDate){

			$selectedDates = array();

			if (! $this->conn->connect_error){

				$selectedDate = $this->sanitizeInput($selectedDate);

				$query = "SELECT eventDate FROM ClientEvents WHERE isDeleted=0 AND eventDate='". $selectedDate ."'";

				$result = $this->conn->query($query);

				if (is_object($result) && !empty($result->num_rows)) {
					while ($row = $result->fetch_assoc()) {
						array_push($selectedDates, array("eventDate" => $row['eventDate']));
					}

					$result->free();

					if (sizeof($selectedDates) == 2){
						return true;
					}
				}
			}
			
			return false;
		}

		public function isSelectedDateValid($selectedDate){
			$selectedDate = $this->sanitizeInput($selectedDate);

			$selectedDate = $this->getProperDate($selectedDate);

			$today = date("Y-m-d");
			$todayPlsOneWeek = date("Y-m-d", strtotime($today . ' + 7 days'));

			$results = array("done" => "FALSE", "msg" => "Please enter the date");

			if ($selectedDate <= $todayPlsOneWeek){

				$results = array("done" => "FALSE", "msg" => "Invalid Date - it must be 1 week preparation before the event");
		
			}else{

				$isAlreadyUsed = $this->isSelectedDateAlreadyUsed($selectedDate);

				if ($isAlreadyUsed == true){
					$results = array("done" => "FALSE", "msg" => "The date is not available");
				}else if($isAlreadyUsed == false){
					$results = array("done" => "TRUE", "msg" => "The date is available");
				}else{
					$results = array("done" => "FALSE", "msg" => "Error!!!!");
				}
			}

			return $results;
		}

		public function isNewSelectedDateIsSameAsOld($selectedDate, $clientID, $eventID){
			$selectedDate = $this->sanitizeInput($selectedDate);
			$clientID = $this->sanitizeInput($clientID);
			$eventID = $this->sanitizeInput($eventID);

			$selectedDate = $this->getProperDate($selectedDate);

			$count = 0;

			if (! $this->conn->connect_error){

				$query = "SELECT COUNT(*) as count FROM ClientEvents WHERE eventDate='". $selectedDate  ."' AND clientInfoID=". $clientID ." AND id=".$eventID ;

				$result = $this->conn->query($query);

				if (is_object($result) && !empty($result->num_rows)) {
					while ($row = $result->fetch_assoc()) {
						$count = $row['count'];
					}

					$result->free();

					// echo $count;

					if ($count == 0 || $count == "0"){
						return false;
					}
				}
			}
			
			return true;
		}

		public function getAllSelectedDate(){

			$selectedDates = array();

			if (! $this->conn->connect_error){

				// $query = "SELECT count(eventDate) as count, eventDate FROM ClientEvents WHERE isDeleted=0 AND eventDate >= CURRENT_TIMESTAMP GROUP BY eventDate";

				$query = "SELECT count(eventDate) as count, eventDate FROM ClientEvents WHERE isDeleted=0 AND eventDate >= CURRENT_TIMESTAMP AND eventStatus > 1 GROUP BY eventDate";

				$result = $this->conn->query($query);

				if (is_object($result) && !empty($result->num_rows)) {
					while ($row = $result->fetch_assoc()) {
						array_push($selectedDates, array(
									"count" => $row['count'],
									"eventDate" => $row['eventDate'])
							);
					}

					$result->free();
				}
			}
			
			return $selectedDates;
		}

		// DeleteThisSlideshow
		public function insertClientEventPlanDetails($data = array()){

			if (sizeof($data) == 0){
				return 0;
			}

			if (! $this->conn->connect_error){

				$typeOfEvent = $this->sanitizeInput($data['typeOfEvent']);
				$serviceMotif = $this->sanitizeInput($data['serviceMotif']);
				$typeOfVenue = $this->sanitizeInput($data['typeOfVenue']);
				$eventDate = $this->sanitizeInput($data['eventDate']);
				$eventEstimateStartTime = $this->sanitizeInput($data['eventEstimateStartTime']);
				$eventEstimateEndTime = $this->sanitizeInput($data['eventEstimateEndTime']);
				$noOfGuests = $this->sanitizeInput($data['noOfGuests']);
				$venueAddress = $this->sanitizeInput($data['venueAddress']);

				$clientID = $_SESSION['client_ID'];

				$eventDate = $this->getProperDate($eventDate);

				// echo $eventsDate;

				$query = "INSERT INTO ClientEvents(clientInfoID, serviceID, serviceMotifID, 
							venueID, eventDate, eventStartTime, eventEndTime,noOfGuests, venueAddress) ";
				$query .= "VALUES(". $clientID .", ". $typeOfEvent .", ". $serviceMotif .", ". $typeOfVenue .",
							'". $eventDate ."', '". $eventEstimateStartTime ."', '". $eventEstimateEndTime ."', ". $noOfGuests .", '". $venueAddress ."')";

				if ($this->conn->query($query) === TRUE){
                    return $this->conn->insert_id;
                }
			}
			return 0;
		}

		public function isEventBelongsToClient($eventID, $clientID){

			$count = 0;

			if (! $this->conn->connect_error){

				$eventID = $this->sanitizeInput($eventID);
				 // = $_SESSION['client_ID'];

				$query = "SELECT COUNT(*) As count FROM ClientEvents WHERE id=". $eventID ." AND clientInfoID=". $clientID;

				// echo $query;

				$result = $this->conn->query($query);

				if (is_object($result) && !empty($result->num_rows)) {
					while ($row = $result->fetch_assoc()) {
						$count = $row['count'];
					}

					if ($count == 1 || $count == "1"){
						$result->free();
						return true;
					}
				}
			}

			return false;
		}

		public function updateClientEventPlanDetails($data = array()){

			if (sizeof($data) == 0){
				return 0;
			}

			if (! $this->conn->connect_error){

				$typeOfEvent = $this->sanitizeInput($data['typeOfEvent']);
				$serviceMotif = $this->sanitizeInput($data['serviceMotif']);
				$typeOfVenue = $this->sanitizeInput($data['typeOfVenue']);
				$eventDate = $this->sanitizeInput($data['eventDate']);
				$eventEstimateStartTime = $this->sanitizeInput($data['eventEstimateStartTime']);
				$eventEstimateEndTime = $this->sanitizeInput($data['eventEstimateEndTime']);
				$noOfGuests = $this->sanitizeInput($data['noOfGuests']);
				$venueAddress = $this->sanitizeInput($data['venueAddress']);
				$eventID = $this->sanitizeInput($data['eventID']);

				$clientID = $_SESSION['client_ID'];

				$eventDate = $this->getProperDate($eventDate);

				$query = "UPDATE ClientEvents SET serviceID=". $typeOfEvent .", serviceMotifID=". $serviceMotif .", ";
				$query .= "venueID=". $typeOfVenue .", eventDate='". $eventDate ."', ";
				$query .= "eventStartTime='". $eventEstimateStartTime ."', eventEndTime='". $eventEstimateEndTime ."', ";
				$query .= "noOfGuests=". $noOfGuests .", venueAddress='". $venueAddress ."', eventStatus=1, isDeleted=0 WHERE clientInfoID=". $clientID ." AND id=" . $eventID;

				// echo $query;

				if ($this->conn->query($query) === TRUE){
                    return $this->conn->affected_rows;
                }
			}
			return 0;
		}

		public function insertClientEventPlanMaterials($eventID, $materialID, $imgID){

			if (! $this->conn->connect_error){

				$eventID = $this->sanitizeInput($eventID);
				$materialID = $this->sanitizeInput($materialID);
				$imgID = $this->sanitizeInput($imgID);

				$query = "INSERT INTO EventsMaterials(eventID, materialID, materialMotifImgID) ";
				$query .= "VALUES(". $eventID .", ". $materialID .", ". $imgID .")";

				if ($this->conn->query($query) === TRUE){
                    return $this->conn->insert_id;
                }
			}
			return 0;
		}

		public function isMaterialExisting($eventID, $materialID, $materialMotifImgID){

			$count = 0;

			if (! $this->conn->connect_error){

				$eventID = $this->sanitizeInput($eventID);
				$materialID = $this->sanitizeInput($materialID);
				$materialMotifImgID = $this->sanitizeInput($materialMotifImgID);

				$query = "SELECT COUNT(*) as count FROM EventsMaterials WHERE isDeleted=0 AND 
						eventID=". $eventID ." AND materialID=". $materialID ." AND materialMotifImgID=". $materialMotifImgID;

				$result = $this->conn->query($query);

				if (is_object($result) && !empty($result->num_rows)) {
					while ($row = $result->fetch_assoc()) {
						$count = $row['count'];
					}

					$result->free();

					if ($count > 0){
						return true;
					}
				}
			}

			return false;
		}


		public function insertClientEventPlanFoodsEntertainment($eventID, $prodCatID, $imgID){

			if (! $this->conn->connect_error){

				$eventID = $this->sanitizeInput($eventID);
				$prodCatID = $this->sanitizeInput($prodCatID);
				$imgID = $this->sanitizeInput($imgID);

				$query = "INSERT INTO EventsFoodsEntertainments(eventID, prodCatID, PartnersMotifImgID) ";
				$query .= "VALUES(". $eventID .", ". $prodCatID .", ". $imgID .")";

				if ($this->conn->query($query) === TRUE){
                    return $this->conn->insert_id;
                }
			}
			return 0;
		}

		public function isFoodsEntertainmentExisting($eventID, $prodCatID, $imgID){

			$count = 0;

			if (! $this->conn->connect_error){

				$eventID = $this->sanitizeInput($eventID);
				$prodCatID = $this->sanitizeInput($prodCatID);
				$imgID = $this->sanitizeInput($imgID);

				$query = "SELECT COUNT(*) as count FROM EventsFoodsEntertainments WHERE isDeleted=0 AND eventID=". $eventID ." 
							AND prodCatID=". $prodCatID ." AND PartnersMotifImgID=" . $imgID;

				$result = $this->conn->query($query);

				if (is_object($result) && !empty($result->num_rows)) {
					while ($row = $result->fetch_assoc()) {
						$count = $row['count'];
					}

					$result->free();

					if ($count > 0){
						return true;
					}
				}
			}

			return false;
		}

		public function insertClientEventPlanSelectedMenu($data = array()){

			if (sizeof($data) == 0){
				return 0;
			}

			if (! $this->conn->connect_error){

				$soup = $this->sanitizeInput($data['selectedSoup']);
				$chicken = $this->sanitizeInput($data['selectedChicken']);
				$seafoods = $this->sanitizeInput($data['selectedSeafoods']);
				$porkBeef = $this->sanitizeInput($data['selectedPorkBeef']);
				$vegetable = $this->sanitizeInput($data['selectedVegetable']);
				$rice = $this->sanitizeInput($data['selectedRice']);
				$salad = $this->sanitizeInput($data['selectedSalad']);
				$dessert = $this->sanitizeInput($data['selectedDessert']);
				$drinks = $this->sanitizeInput($data['selectedDrinks']);
				$eventID = $this->sanitizeInput($data['eventID']);
				$menuID = $this->sanitizeInput($data['menuID']);

				$query = "INSERT INTO EventsSelectedMenu(eventID, setID, soup, chicken, 
								seafoods, porkBeef, vegetable, rice, salad, dessert, drinks) ";

				$query .= "VALUES(". $eventID .", ". $menuID .", '". $soup ."', '". $chicken ."', '". $seafoods ."',
									'". $porkBeef ."', '". $vegetable ."', '". $rice ."', '". $salad ."', '". $dessert ."',
									'". $drinks ."')";

				if ($this->conn->query($query) === TRUE){
                    return $this->conn->insert_id;
                }
			}
			return 0;
		}

		public function updateClientEventPlanSelectedMenu($data = array()){

			if (sizeof($data) == 0){
				return 0;
			}

			if (! $this->conn->connect_error){

				$soup = $this->sanitizeInput($data['selectedSoup']);
				$chicken = $this->sanitizeInput($data['selectedChicken']);
				$seafoods = $this->sanitizeInput($data['selectedSeafoods']);
				$porkBeef = $this->sanitizeInput($data['selectedPorkBeef']);
				$vegetable = $this->sanitizeInput($data['selectedVegetable']);
				$rice = $this->sanitizeInput($data['selectedRice']);
				$salad = $this->sanitizeInput($data['selectedSalad']);
				$dessert = $this->sanitizeInput($data['selectedDessert']);
				$drinks = $this->sanitizeInput($data['selectedDrinks']);
				$eventID = $this->sanitizeInput($data['eventID']);
				$menuID = $this->sanitizeInput($data['menuID']);

				$query = "UPDATE EventsSelectedMenu SET setID=". $menuID .", soup='". $soup ."', chicken='". $chicken ."', 
						seafoods='". $seafoods ."', porkBeef='". $porkBeef ."', vegetable='". $vegetable ."', rice='". $rice ."', 
						salad='". $salad ."', dessert='". $dessert ."', drinks='". $drinks ."' WHERE isDeleted=0 AND eventID=" . $eventID;

				if ($this->conn->query($query) === TRUE){
                    return $this->conn->affected_rows;
                }
			}
			return 0;
		}

		public function getEventsDetails_Query($query){

			$events = array();

			if (! $this->conn->connect_error){

				$result = $this->conn->query($query);

				if (is_object($result) && !empty($result->num_rows)) {
					while ($row = $result->fetch_assoc()) {

						array_push($events, array(
								"id" => $row['id'],
								"service" => $row['service'],
								"motif" => $row['motif'],
								"venue" => $row['venue'],
								"eventDate" => $row['eventDate'],
								"eventStartTime" => $row['eventStartTime'],
								"eventEndTime" => $row['eventEndTime'],
								"noOfGuests" => $row['noOfGuests'],
								"entryDate" => $row['entryDate'],
								"eventStatus" => $row['eventStatus'],
								"clientInfoID" => $row['clientInfoID'],
								"venueAddress" => $row['venueAddress']
						));
					}

					$result->free();
				}
			}

			return $events;
		}

		public function getEventByID($id){

			$id = $this->sanitizeInput($id);

			$query = "SELECT CE.id, CE.clientInfoID, S.service, SM.motif, V.venue, eventDate,";
			$query .= "eventStartTime, eventEndTime, noOfGuests, entryDate, eventStatus, CE.venueAddress ";
			$query .= "FROM ClientEvents As CE, Services As S, ServiceMotifs as SM, Venues as V ";
			$query .= "WHERE CE.serviceID=S.id AND CE.serviceMotifID=SM.id ";
			$query .= "AND CE.venueID=V.id AND CE.isDeleted=0 AND CE.id=" . $id;
			// $query .= " ORDER BY id DESC";

			$newEvents = $this->getEventsDetails_Query($query);

			return $newEvents;
		}

		public function getClientCurrentEvent(){

			$clientID = $_SESSION['client_ID'];

			$query = "SELECT CE.id, CE.clientInfoID, S.service, SM.motif, V.venue, eventDate,";
			$query .= "eventStartTime, eventEndTime, noOfGuests, entryDate, eventStatus, CE.venueAddress ";
			$query .= "FROM ClientEvents As CE, Services As S, ServiceMotifs as SM, Venues as V ";
			$query .= "WHERE CE.serviceID=S.id AND CE.serviceMotifID=SM.id ";
			$query .= "AND CE.venueID=V.id AND CE.clientInfoID=" . $clientID;
			$query .= " ORDER BY CE.id DESC LIMIT 1";

			// echo $query;

			$newEvents = $this->getEventsDetails_Query($query);

			return $newEvents;
		}

		public function getAllEventMaterialImgs($eventID){

			$materials = array();

			if (! $this->conn->connect_error){

				$eventID = $this->sanitizeInput($eventID);

				$query ="SELECT EM.id, MTI.serverName, MTI.referenceNo, MT.theme, M.material, MTI.price 
						FROM EventsMaterials as EM, MaterialsTheme_images MTI, MaterialThemes as MT, Materials as M
						WHERE EM.isDeleted=0 AND EM.materialMotifImgID=MTI.id AND MTI.themeID=MT.id AND EM.materialID=M.id
						AND EM.eventID=" . $eventID;

				$result = $this->conn->query($query);

				if (is_object($result) && !empty($result->num_rows)) {
					while ($row = $result->fetch_assoc()) {

						array_push($materials, array(
								"id" => $row['id'],
								"serverName" => $row['serverName'],
								"referenceNo" => $row['referenceNo'],
								"theme" => $row['theme'],
								"material" => $row['material'],
								"price" => $row['price']
						));
					}

					$result->free();
				}
			}

			return $materials;
		}

		public function getAllEventFoodsNEntertainment($eventID){

			$foodsEnter = array();

			if (! $this->conn->connect_error){

				$eventID = $this->sanitizeInput($eventID);

				$query ="SELECT EFE.id, PPC.prodCat, PMI.serverName, PMI.imageRefNo, PM.theme, PMI.price
						FROM EventsFoodsEntertainments as EFE, PartnersProductCategory as PPC, PartnersMotifImages as PMI, PartnersMotif as PM
						WHERE EFE.isDeleted=0 AND EFE.prodCatID=PPC.id AND EFE.PartnersMotifImgID=PMI.id AND PMI.motifID=PM.id AND EFE.eventID=" . $eventID;
				
				$result = $this->conn->query($query);

				if (is_object($result) && !empty($result->num_rows)) {
					while ($row = $result->fetch_assoc()) {

						array_push($foodsEnter, array(
								"id" => $row['id'],
								"prodCat" => $row['prodCat'],
								"serverName" => $row['serverName'],
								"imageRefNo" => $row['imageRefNo'],
								"theme" => $row['theme'],
								"price" => $row['price']
						));
					}

					$result->free();
				}
			}

			return $foodsEnter;
		}

		public function getEventMenuSelected($eventID){

			$foodsEnter = array();

			if (! $this->conn->connect_error){

				$eventID = $this->sanitizeInput($eventID);

				$query ="SELECT ESM.id, M.setTitle, M.setPrice, ESM.soup, ESM.chicken, ESM.seafoods, ESM.porkBeef, 
						ESM.vegetable,ESM.rice,ESM.salad,ESM.dessert,ESM.drinks
						FROM Menus as M, EventsSelectedMenu as ESM
						WHERE ESM.setID=M.id AND ESM.eventID=" . $eventID;

				$result = $this->conn->query($query);

				if (is_object($result) && !empty($result->num_rows)) {
					while ($row = $result->fetch_assoc()) {

						array_push($foodsEnter, array(
								"id" => $row['id'],
								"setTitle" => $row['setTitle'],
								"setPrice" => $row['setPrice'],
								"soup" => $row['soup'],
								"chicken" => $row['chicken'],
								"seafoods" => $row['seafoods'],
								"porkBeef" => $row['porkBeef'],
								"vegetable" => $row['vegetable'],
								"rice" => $row['rice'],
								"salad" => $row['salad'],
								"dessert" => $row['dessert'],
								"drinks" => $row['drinks']
						));
					}

					$result->free();
				}
			}

			return $foodsEnter;
		}

		public function getEventsDetailsActualDataBy_Query($query){

			$events = array();

			if (! $this->conn->connect_error){

				// $eventID = $this->sanitizeInput($eventID);

				$result = $this->conn->query($query);

				if (is_object($result) && !empty($result->num_rows)) {
					while ($row = $result->fetch_assoc()) {

						array_push($events, array(
								"id" => $row['id'],
								"serviceID" => $row['serviceID'],
								"serviceMotifID" => $row['serviceMotifID'],
								"venueID" => $row['venueID'],
								"eventDate" => $row['eventDate'],
								"eventStartTime" => $row['eventStartTime'],
								"eventEndTime" => $row['eventEndTime'],
								"noOfGuests" => $row['noOfGuests'],
								"venueAddress" => $row['venueAddress']
						));
					}

					$result->free();
				}
			}

			return $events;
		}

		public function getEventsDetailsActualDataByID($eventID){

			$eventID = $this->sanitizeInput($eventID);

			$query = "SELECT * FROM ClientEvents WHERE id=" . $eventID;

			$events = $this->getEventsDetailsActualDataBy_Query($query);

			return $events;
		}

		public function getClientRecentEvents_Query($query){

			$events = array();

			if (! $this->conn->connect_error){

				$result = $this->conn->query($query);

				if (is_object($result) && !empty($result->num_rows)) {
					while ($row = $result->fetch_assoc()) {

						array_push($events, array(
								"id" => $row['id'],
								"service" => $row['service'],
								"motif" => $row['motif'],
								"venue" => $row['venue'],
								"eventDate" => $row['eventDate'],
								"eventStartTime" => $row['eventStartTime'],
								"eventEndTime" => $row['eventEndTime'],
								"noOfGuests" => $row['noOfGuests'],
								"entryDate" => $row['entryDate'],
								"eventStatus" => $row['eventStatus'],
								"clientInfoID" => $row['clientInfoID']
						));
					}

					$result->free();
				}
			}

			return $events;
		}

		public function getAllClientRecentEvents(){

			$clientID = $_SESSION['client_ID'];

			$query = "SELECT CE.id, CE.clientInfoID, S.service, SM.motif, V.venue, eventDate,";
			$query .= "eventStartTime, eventEndTime, noOfGuests, entryDate, eventStatus ";
			$query .= "FROM ClientEvents As CE, Services As S, ServiceMotifs as SM, Venues as V ";
			$query .= "WHERE CE.serviceID=S.id AND CE.serviceMotifID=SM.id ";
			$query .= "AND CE.venueID=V.id AND CE.isDeleted=0 AND CE.eventStatus=5 AND ";
			$query .= " CE.clientInfoID=". $clientID ." ORDER BY id DESC";

			$events = $this->getClientRecentEvents_Query($query);

			return $events;
		}

		public function getEventsMaterialsID_ActualDataByID($eventID){

			$materialIDs = array();

			if (! $this->conn->connect_error){

				$eventID = $this->sanitizeInput($eventID);

				$query = "SELECT DISTINCT materialID FROM EventsMaterials WHERE isDeleted=0 AND eventID=" . $eventID;

				$result = $this->conn->query($query);

				if (is_object($result) && !empty($result->num_rows)) {
					while ($row = $result->fetch_assoc()) {

						array_push($materialIDs, array( "materialID" => $row['materialID'] ));
					}

					$result->free();
				}
			}

			return $materialIDs;
		}

		public function getEventsMaterialsMotifImgID_ActualDataByID($eventID){

			$materiaIDs = $this->getEventsMaterialsID_ActualDataByID($eventID);
			$materiaIDLen = sizeof($materiaIDs);

			$materislIDs_imgsIDs = array();

			if (! $this->conn->connect_error){

				$eventID = $this->sanitizeInput($eventID);
			
				for($i=0; $i<$materiaIDLen; $i++){

					$materialIDTemp = $materiaIDs[$i]['materialID'];

					$query = "SELECT DISTINCT materialMotifImgID FROM EventsMaterials WHERE isDeleted=0 AND materialID=". $materialIDTemp ." AND eventID=" . $eventID;

					$result = $this->conn->query($query);

					$materislMotifImgIds = array();

					if (is_object($result) && !empty($result->num_rows)) {
						while ($row = $result->fetch_assoc()) {

							array_push($materislMotifImgIds, $row['materialMotifImgID']);
						}

						array_push($materislIDs_imgsIDs, array(
								"materialID" => $materialIDTemp,
								"materialImgIds" => $materislMotifImgIds
						));
					}

					$result->free();
				}	

			}

			return $materislIDs_imgsIDs;
		}

		public function deleteEventMaterial($materialID = 0){

			if (! $this->conn->connect_error){

				$materialID = $this->sanitizeInput($materialID);

				$query = "UPDATE EventsMaterials SET isDeleted=1 WHERE id=" . $materialID;

				if ($this->conn->query($query) === TRUE){
                    return true;
                }
			}
			return false;
		}

		public function getEventsProdCatID_ActualDataByID($eventID){

			$prodCatIds = array();

			if (! $this->conn->connect_error){

				$eventID = $this->sanitizeInput($eventID);

				$query = "SELECT DISTINCT prodCatID FROM EventsFoodsEntertainments WHERE isDeleted=0 AND eventID=" . $eventID;

				$result = $this->conn->query($query);

				if (is_object($result) && !empty($result->num_rows)) {
					while ($row = $result->fetch_assoc()) {

						array_push($prodCatIds, array( "prodCatID" => $row['prodCatID'] ));
					}

					$result->free();
				}
			}

			return $prodCatIds;
		}

		public function getEventsProdCatPartnersMotifImgID_ActualDataByID($eventID){

			$prodCatIDs = $this->getEventsProdCatID_ActualDataByID($eventID);
			$prodCatIDLen = sizeof($prodCatIDs);

			$prodCatIDs_imgsIDs = array();

			if (! $this->conn->connect_error){

				$eventID = $this->sanitizeInput($eventID);
			
				for($i=0; $i<$prodCatIDLen; $i++){

					$prodCatIDTemp = $prodCatIDs[$i]['prodCatID'];

					$query = "SELECT DISTINCT PartnersMotifImgID FROM EventsFoodsEntertainments WHERE isDeleted=0 AND prodCatID=". $prodCatIDTemp ." AND eventID=" . $eventID;

					$result = $this->conn->query($query);

					$partnersMotifIDs = array();

					if (is_object($result) && !empty($result->num_rows)) {
						while ($row = $result->fetch_assoc()) {

							array_push($partnersMotifIDs, $row['PartnersMotifImgID']);
						}

						array_push($prodCatIDs_imgsIDs, array(
								"prodCatID" => $prodCatIDTemp,
								"partnersMotifIDs" => $partnersMotifIDs
						));
					}

					$result->free();
				}	

			}

			return $prodCatIDs_imgsIDs;
		}

		public function deleteEventFoodsEntertainment($foodsEnterID = 0){

			if (! $this->conn->connect_error){

				$foodsEnterID = $this->sanitizeInput($foodsEnterID);

				$query = "UPDATE EventsFoodsEntertainments SET isDeleted=1 WHERE id=" . $foodsEnterID;

				if ($this->conn->query($query) === TRUE){
                    return true;
                }
			}
			return false;
		}

		public function deleteEvent($eventID){

			if (! $this->conn->connect_error){

				$eventID = $this->sanitizeInput($eventID);
				$clientID = $_SESSION['client_ID'];

				$query = "UPDATE ClientEvents SET isDeleted=1 WHERE clientInfoID=". $clientID ." AND id=" . $eventID;

				if ($this->conn->query($query) === TRUE){
                    return true;
                }
			}
			return false;
		}

		public function getClientBills($eventID){

			$bills = array("id" => "0");

			if (! $this->conn->connect_error){

				$eventID = $this->sanitizeInput($eventID);

				$query = "SELECT * FROM ClientEventBills WHERE eventID=" . $eventID . " ORDER BY id DESC LIMIT 1";

				$result = $this->conn->query($query);

				if (is_object($result) && !empty($result->num_rows)) {
					while ($row = $result->fetch_assoc()) {
						
						$bills = array(
								"id" => $row['id'],
								"billFileServer" => $row['billFileServer'],
								"billOrigFilename" => $row['billOrigFilename'],
								"billAmount" => $row['billAmount'],
								"paymentMethod" => $row['paymentMethod'],
								"isPaid" => $row['isPaid']
							);
					}

					$result->free();
				}
			}

			return $bills;
		}

		public function updateClientBillPaymentStatus($paymentMethod, $isPaid, $eventID){

			if (! $this->conn->connect_error){

				$paymentMethod = $this->sanitizeInput($paymentMethod);
				$isPaid = $this->sanitizeInput($isPaid);
				$eventID = $this->sanitizeInput($eventID);

				$query = "UPDATE ClientEventBills SET paymentMethod=". $paymentMethod .", isPaid=". $isPaid ." WHERE id=" . $eventID;

				if ($this->conn->query($query) === TRUE){
                    return $this->conn->affected_rows;
                }
			}

			return 0;
		}

		public function send_download($file, $origFileName) {
            $basename = basename($origFileName);
            $length   = sprintf("%u", filesize($file));

            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . $basename . '"');
            header('Content-Transfer-Encoding: binary');
            header('Connection: Keep-Alive');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
            header('Content-Length: ' . $length);

            set_time_limit(0);
            readfile($file);
        }

        public function insertPaymentMethod($method, $eventID){

			if (! $this->conn->connect_error){

				$method = $this->sanitizeInput($method);
				$eventID = $this->sanitizeInput($eventID);

				$query = "INSERT INTO ClientEventBillsPaymentMethod(eventID, paymentMethod) ";
				$query .= "VALUES(". $eventID .", ". $method .")";

				if ($this->conn->query($query) === TRUE){
                    return $this->conn->affected_rows;
                }
			}

			return 0;
		}

		public function insertPayment($amount, $eventID){

			if (! $this->conn->connect_error){

				$amount = $this->sanitizeInput($amount);
				$eventID = $this->sanitizeInput($eventID);

				$query = "INSERT INTO ClientEventBillsPayments(eventID, amount) ";
				$query .= "VALUES(". $eventID .", ". $amount .")";

				if ($this->conn->query($query) === TRUE){
                    return $this->conn->affected_rows;
                }
			}

			return 0;
		}

		public function getPaymentMethod($eventID){

			$method = 0;

			if (! $this->conn->connect_error){

				$eventID = $this->sanitizeInput($eventID);

				$query = "SELECT paymentMethod FROM ClientEventBillsPaymentMethod WHERE eventID=". $eventID ." ORDER BY id DESC LIMIT 1";

				$result = $this->conn->query($query);

				if (is_object($result) && !empty($result->num_rows)) {
					while ($row = $result->fetch_assoc()) {
						$method = $row['paymentMethod'];
					}
					$result->free();
				}
			}

			return $method;
		}

		public function getAllPayments($eventID){

			$payments = array();

			if (! $this->conn->connect_error){

				$eventID = $this->sanitizeInput($eventID);

				$query = "SELECT * FROM ClientEventBillsPayments WHERE eventID=" . $eventID;

				$result = $this->conn->query($query);

				if (is_object($result) && !empty($result->num_rows)) {
					while ($row = $result->fetch_assoc()) {
						array_push($payments, array(
							"amount" => $row['amount'],
							"entryDate" => $row['entryDate']
						));
					}
					$result->free();
				}
			}

			return $payments;
		}

		public function getClientInfo_frm_passRecovery($email, $tag){

			$info = array();

			if (! $this->conn->connect_error){

				$email = $this->sanitizeInput($email);
				$tag = $this->sanitizeInput($tag);

				$query = "SELECT * FROM Clients_RecoveredEmail WHERE isDone=0 AND email_address='". $email ."' AND tag='". $tag ."' ORDER BY id DESC LIMIT 1";

				$result = $this->conn->query($query);

				if (is_object($result) && !empty($result->num_rows)) {
					while ($row = $result->fetch_assoc()) {
						array_push($info, array(
								"id" => $row['id'],
								"email_address" => $row['email_address'],
								"clientID" => $row['clientID'],
								"tag" => $row['tag'],
								"dateEntry" => $row['dateEntry']
						));
					}
					$result->free();
				}
			}

			return $info;
		}

		public function updateClientPassword($newPassword, $clientID, $clientEmail){

			if (! $this->conn->connect_error){

				$newPassword = $this->sanitizeInput($newPassword);
				$clientID = $this->sanitizeInput($clientID);
				$clientEmail = $this->sanitizeInput($clientEmail);

				$hashNewPassword = hash('sha512', $newPassword);

				$query = "UPDATE RegisteredClient SET clientPass='". $hashNewPassword ."' WHERE email='". $clientEmail ."' AND id=". $clientID;

				if ($this->conn->query($query) === TRUE){
                    return true;
                }
			}

			return false;
		}

		public function updateClients_RecoveredEmail_toDone($id, $tag, $clientID, $clientEmail){

			if (! $this->conn->connect_error){

				$id = $this->sanitizeInput($id);
				$tag = $this->sanitizeInput($tag);
				$clientID = $this->sanitizeInput($clientID);
				$clientEmail = $this->sanitizeInput($clientEmail);

				$query = "UPDATE Clients_RecoveredEmail SET isDone=1 WHERE id=". $id ." AND email_address='". $clientEmail ."' AND tag='". $tag ."' AND clientID=". $clientID;

				if ($this->conn->query($query) === TRUE){
                    return true;
                }
			}

			return false;
		}

		public function isSelectedDatesValid($start, $end){
			$phpStartTime = strtotime($start);
			$phpEndTime = strtotime($end);

			if ($phpEndTime <= $phpStartTime){
				return false;
			}

			return true;
		}

	}

?>
