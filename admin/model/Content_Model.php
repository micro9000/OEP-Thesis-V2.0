<?php
	
	require_once("database/Admin_Connection.php");

	class Content_Model extends Admin_Connection{

		public function __construct(){
			parent::__construct();
		}
		
		public function getProperDate($dateStr){
			$dateTemp = strtotime($dateStr);
   			$properDate = date("Y-m-d", $dateTemp);

   			return $properDate;
		}

		public function insertNewSlideshow($data = array()){

			if (sizeof($data) == 0){
				return 0;
			}

			if (! $this->conn->connect_error){

				$adminID = $this->getAdminID(); // connection
				$adminUsername = $this->getAdminUsername();

				$firstTitle = $this->sanitizeInput($data['firstTitle']);
				$secondTitle = $this->sanitizeInput($data['secondTitle']);
				$content = $this->sanitizeInput($data['content']);
				$imgServerFilename = $this->sanitizeInput($data['imgServerFilename']);
				$imgOrigFilename = $this->sanitizeInput($data['imgOrigFilename']);

				$query = "INSERT INTO Slideshow(firstTitle, secondTitle, content, 
							imgServerFileName, imgOrigFilename, userName, userId) ";
				$query .= "VALUES('". $firstTitle ."', '". $secondTitle ."', '". $content ."',
							'". $imgServerFilename ."', '". $imgOrigFilename ."', '". $adminUsername ."'
							, ". $adminID .")";

				if ($this->conn->query($query) === TRUE){
                    return $this->conn->affected_rows;
                }
                return 0;
			}
		}

		public function updateSlideshow($data = array()){

			if (sizeof($data) == 0){
				return 0;
			}

			if (! $this->conn->connect_error){

				$adminID = $this->getAdminID(); // connection
				$adminUsername = $this->getAdminUsername();

				$firstTitle = $this->sanitizeInput($data['firstTitle']);
				$secondTitle = $this->sanitizeInput($data['secondTitle']);
				$content = $this->sanitizeInput($data['content']);
				$imgServerFilename = $this->sanitizeInput($data['imgServerFilename']);
				$imgOrigFilename = $this->sanitizeInput($data['imgOrigFilename']);

				$slideID = $this->sanitizeInput($data['slideID']);

				$query = "UPDATE Slideshow SET firstTitle='". $firstTitle ."', secondTitle='". $secondTitle ."', 
						 content='". $content ."', imgServerFileName='". $imgServerFilename ."', 
						 imgOrigFilename='". $imgOrigFilename ."', userName='". $adminUsername ."', userId=". $adminID ." 
						 WHERE id=" . $slideID;

				if ($this->conn->query($query) === TRUE){
                    return $this->conn->affected_rows;
                }
                return 0;
			}
		}

		public function getSlideshow_Query($query){

			$slideshow = array();
			$slideshowData = array();

			if (! $this->conn->connect_error){
				$result = $this->conn->query($query);

				if (is_object($result) && !empty($result->num_rows)) {
					while ($row = $result->fetch_assoc()) {

						$slideshowData = array("id" => $row['id'],
										  "firstTitle" => $row['firstTitle'],
										  "secondTitle" => $row['secondTitle'],
										  "content" => $row['content'],
										  "imgServerFileName" => $row['imgServerFileName'],
										  "imgOrigFilename" => $row['imgOrigFilename'],
										  "userName" => $row['userName']
										);

						array_push($slideshow, $slideshowData);
					}

					$result->free();

					return $slideshow;
				}
			}
			
			return $slideshow;
		}

		public function getAllSlideshow(){
			$query = "SELECT * FROM Slideshow WHERE isDeleted=0 ORDER BY id DESC";
			$slideshow = $this->getSlideshow_Query($query);
			return $slideshow;
		}

		public function getSlideshowByID($id){

			$id = $this->sanitizeInput($id);

			$query = "SELECT * FROM Slideshow WHERE isDeleted=0 AND id=" . $id;
			$slideshow = $this->getSlideshow_Query($query);
			return $slideshow;
		}

		public function DeleteThisSlideshow($slideID = 0){

			if ($slideID == 0){
				return false;
			}

			if (! $this->conn->connect_error){

				$slideID = $this->sanitizeInput($slideID);

				$query = "UPDATE Slideshow SET isDeleted=1 WHERE id=" . $slideID;

				if ($this->conn->query($query) === TRUE){
                    return true;
                }
                return false;
			}
		}

		// Recent Events

		public function insertNewRecentEvent($data = array()){

			if (sizeof($data) == 0){
				return 0;
			}

			if (! $this->conn->connect_error){

				$adminID = $this->getAdminID(); // connection
				$adminUsername = $this->getAdminUsername();

				$eventCategory = $this->sanitizeInput($data['eventCategory']);
				$eventName = $this->sanitizeInput($data['eventName']);
				$eventAddress = $this->sanitizeInput($data['eventAddress']);
				$eventDate = $this->sanitizeInput($data['eventDate']);
				$eventDescription = $this->sanitizeInput($data['eventDescription']);
				$eventComments = $this->sanitizeInput($data['eventComments']);

				// $eventDateTemp = strtotime($eventDate);
                // $eventDate = date("Y-m-d", $eventDateTemp);

                $eventDate = $this->getProperDate($eventDate);

				$query = "INSERT INTO RecentEvents(serviceID, eventName, address, 
								eventDate, description, comments, userName, userId) ";
				$query .= "VALUES(". $eventCategory .", '". $eventName ."', '". $eventAddress ."', 
							'". $eventDate ."', '". $eventDescription ."','". $eventComments ."' ,
							'". $adminUsername ."', ". $adminID .")";

				if ($this->conn->query($query) === TRUE){
                    return $this->conn->insert_id;
                }
                return 0;
			}
		}

		public function updateRecentEvent($data = array()){

			if (! $this->conn->connect_error){

				$adminID = $this->getAdminID(); // connection
				$adminUsername = $this->getAdminUsername();

				$eventCategory = $this->sanitizeInput($data['eventCategory']);
				$eventName = $this->sanitizeInput($data['eventName']);
				$eventAddress = $this->sanitizeInput($data['eventAddress']);
				$eventDate = $this->sanitizeInput($data['eventDate']);
				$eventDescription = $this->sanitizeInput($data['eventDescription']);
				$eventComments = $this->sanitizeInput($data['eventComments']);
				$eventID = $this->sanitizeInput($data['eventID']);

                $eventDate = $this->getProperDate($eventDate);

				$query = "UPDATE RecentEvents SET serviceID=". $eventCategory .", eventName='". $eventName . "',";
				$query .= " address='". $eventAddress ."', eventDate='". $eventDate ."', description='". $eventDescription ."',";
				$query .= " comments='". $eventComments ."', userName='". $adminUsername ."', userId=". $adminID ." WHERE id=" . $eventID;

				if ($this->conn->query($query) === TRUE){
                    return $this->conn->affected_rows;
                    exit();
                } 
			}
			return 0;
			exit();
		}

		public function deleteEvent($eventID){

			if (! $this->conn->connect_error){

				$eventID = $this->sanitizeInput($eventID);

				$query = "UPDATE RecentEvents SET isDelete=1 WHERE id=" . $eventID;

				if ($this->conn->query($query) === TRUE){

					$query = "UPDATE RecentEvents_Images SET isDelete=1 WHERE eventID=" . $eventID;

					if ($this->conn->query($query) === TRUE){
						return $this->conn->affected_rows;
					}
                }
                return 0;
			}

		}

		public function insertNewRecentEvent_Image($eventID, $serverName, $origName){

			if (! $this->conn->connect_error){

				$eventID = $this->sanitizeInput($eventID);
				$serverName = $this->sanitizeInput($serverName);
				$origName = $this->sanitizeInput($origName);

				$query = "INSERT INTO RecentEvents_Images(eventID, serverName, origName) ";
				$query .= "VALUES(". $eventID .", '". $serverName ."', '". $origName ."')";

				if ($this->conn->query($query) === TRUE){
                    return true;
                }
                return false;
			}
		}

		public function DeleteRecentEvent_Image($imageID){

			if (! $this->conn->connect_error){

				$imageID = $this->sanitizeInput($imageID);

				$query = "UPDATE RecentEvents_Images SET isDelete=1 WHERE id=" . $imageID;

				if ($this->conn->query($query) === TRUE){
                    return true;
                }
                return false;
			}
		}

		public function getEvent_Query($query){

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

		public function getAllEvents(){

			$events = array();

			$query = "SELECT RE.*, S.service
					FROM RecentEvents As RE, Services As S
					WHERE RE.isDelete=0 AND RE.serviceID=S.id ORDER BY RE.id DESC";

			$events = $this->getEvent_Query($query);
		
			return $events;
		}

		public function getThisEventInfo($eventID){

			$events = array();
			
			$eventID = $this->sanitizeInput($eventID);	

			$query = "SELECT RE.*, S.service
					FROM RecentEvents As RE, Services As S
					WHERE RE.isDelete=0 AND RE.serviceID=S.id AND RE.id=" . $eventID;

			$events = $this->getEvent_Query($query);

			return $events;
		}

		public function searchEvent($serviceID = 0, $startDate = "", $endDate = ""){

			$events = array();
			
			$serviceID = $this->sanitizeInput($serviceID);
			$startDate = $this->sanitizeInput($startDate);
			$endDate = $this->sanitizeInput($endDate);

			$query = "";

			if ($serviceID != 0 && $startDate == "" && $endDate == ""){

				$query = "SELECT RE.*, S.service
					FROM RecentEvents As RE, Services As S
					WHERE RE.isDelete=0 AND RE.serviceID=S.id AND RE.serviceID=" . $serviceID;

			}else if ($startDate != "" && $endDate != "" && $serviceID == 0){

				$startDate = $this->getProperDate($startDate);
				$endDate = $this->getProperDate($endDate);

				$query = "SELECT RE.*, S.service
					FROM RecentEvents As RE, Services As S
					WHERE RE.isDelete=0 AND RE.serviceID=S.id AND RE.eventDate BETWEEN 
					'". $startDate ."' AND '". $endDate ."'";

			}else if ($startDate != "" && $endDate != "" && $serviceID != 0){

				$startDate = $this->getProperDate($startDate);
				$endDate = $this->getProperDate($endDate);

				$query = "SELECT RE.*, S.service
					FROM RecentEvents As RE, Services As S
					WHERE RE.isDelete=0 AND RE.serviceID=S.id AND RE.eventDate BETWEEN 
					'". $startDate ."' AND '". $endDate ."' AND RE.serviceID=" . $serviceID;

			}else{

				$query = "SELECT RE.*, S.service
					FROM RecentEvents As RE, Services As S
					WHERE RE.isDelete=0 AND RE.serviceID=S.id ORDER BY RE.id DESC";

			}

			$events = $this->getEvent_Query($query);

			return $events;
		}

		public function getEventImages_Query($query){

			$images = array();
			$imagesData = array();

			if (! $this->conn->connect_error){

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

		public function getEventImages($eventID){

			$images = array();
			
			$eventID = $this->sanitizeInput($eventID);

			$query = "SELECT * FROM RecentEvents_Images WHERE isDelete=0 AND eventID=". $eventID;

			$images = $this->getEventImages_Query($query);

			return $images;
		}

		public function getEventImageByID($eventID, $imageID){

			$images = array();
			
			$eventID = $this->sanitizeInput($eventID);
			$imageID = $this->sanitizeInput($imageID);

			$query = "SELECT * FROM RecentEvents_Images WHERE isDelete=0 AND eventID=". $eventID . " AND id=" . $imageID;

			$images = $this->getEventImages_Query($query);

			return $images;

		}

		public function insertNewProductCategory($category){

			if (! $this->conn->connect_error){

				$category = $this->sanitizeInput($category);

				$query = "INSERT INTO PartnersProductCategory(prodCat) ";
				$query .= "VALUES('". $category ."')";

				if ($this->conn->query($query) === TRUE){
                    return $this->conn->affected_rows;
                }
                return 0;
			}
		}
		
		public function deleteProductCategory($categoryID){

			if (! $this->conn->connect_error){

				$categoryID = $this->sanitizeInput($categoryID);

				$query = "UPDATE PartnersProductCategory SET isDeleted=1 WHERE id=" . $categoryID;

				if ($this->conn->query($query) === TRUE){
                    return $this->conn->affected_rows;
                }
                return 0;
			}
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

		public function insertNewPartner($data = array()){

			if (sizeof($data) == 0){
				return 0;
			}

			if (! $this->conn->connect_error){

				$adminID = $this->getAdminID(); // connection
				$adminUsername = $this->getAdminUsername();

				$partnerName = $this->sanitizeInput($data['partnerName']);
				$partnerInfo = $this->sanitizeInput($data['partnerInfo']);
				$contactSmart = $this->sanitizeInput($data['contactSmart']);
				$contactGlobe = $this->sanitizeInput($data['contactGlobe']);
				$contactEmail = $this->sanitizeInput($data['contactEmail']);

				$query = "INSERT INTO Partners(partnerName, info, contactSmart, contactGlobe, contactEmail, userName, userId) ";
				$query .= "VALUES('". $partnerName ."', '". $partnerInfo ."',
						 '". $contactSmart ."', '". $contactGlobe ."', '". $contactEmail  ."', '". $adminUsername ."', ". $adminID .")";

				if ($this->conn->query($query) === TRUE){
                    return $this->conn->affected_rows;
                }
                return 0;
			}
		}

		public function updatePartner($data = array()){

			if (sizeof($data) == 0){
				return 0;
			}

			if (! $this->conn->connect_error){

				$adminID = $this->getAdminID(); // connection
				$adminUsername = $this->getAdminUsername();

				$partnerName = $this->sanitizeInput($data['partnerName']);
				$partnerInfo = $this->sanitizeInput($data['partnerInfo']);
				$contactSmart = $this->sanitizeInput($data['contactSmart']);
				$contactGlobe = $this->sanitizeInput($data['contactGlobe']);
				$contactEmail = $this->sanitizeInput($data['contactEmail']);
				$partnerID = $this->sanitizeInput($data['partnerID']);

				$query = "UPDATE Partners SET partnerName='". $partnerName ."', info='". $partnerInfo ."', ";
				$query .= "contactSmart='". $contactSmart ."', contactGlobe='". $contactGlobe ."', contactEmail='". $contactEmail ."', ";
				$query .= "userName='". $adminUsername ."', userId=". $adminID ." WHERE id=" . $partnerID;

				if ($this->conn->query($query) === TRUE){
                    return $this->conn->affected_rows;
                }
                return 0;
			}
		}

		public function deletePartnerInfo($partnerID = 0){

			if ($partnerID == 0){
				return 0;
			}

			if (! $this->conn->connect_error){

				$partnerID = $this->sanitizeInput($partnerID);

				$query = "UPDATE Partners SET isDeleted=1 WHERE id=" . $partnerID;

				if ($this->conn->query($query) === TRUE){
                    return $this->conn->affected_rows;
                }
                return 0;
			}
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
										  	  "userName" => $row['userName']
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

		public function insertPartnerNewMotif($theme = "", $partnerID = 0, $prodCatID){

			if ($theme == "" && $partnerID == 0){
				return 0;
			}

			if (! $this->conn->connect_error){

				$adminID = $this->getAdminID(); // connection
				$adminUsername = $this->getAdminUsername();

				$theme = $this->sanitizeInput($theme);
				$partnerID = $this->sanitizeInput($partnerID);
				$prodCatID = $this->sanitizeInput($prodCatID);

				$query = "INSERT INTO PartnersMotif(partnerID, theme, prodCatID, userName, userId) ";
				$query .= "VALUES(". $partnerID .", '". $theme ."', ". $prodCatID .", '". $adminUsername ."', ". $adminID .")";

				if ($this->conn->query($query) === TRUE){
                    return $this->conn->insert_id;
                }
                return 0;
			}
		}

		public function DeletePartnerMotif($motifID){

			if (! $this->conn->connect_error){

				$motifID = $this->sanitizeInput($motifID);

				$query = "UPDATE PartnersMotif SET isDeleted=1 WHERE id=" . $motifID;

				if ($this->conn->query($query) === TRUE){
                    return $this->conn->affected_rows;
                }
                return 0;
			}
		}

		public function insertPartnerMotifImage($motifID, $serverName, $origName, $refNo){

			if (! $this->conn->connect_error){

				$motifID = $this->sanitizeInput($motifID);
				$serverName = $this->sanitizeInput($serverName);
				$origName = $this->sanitizeInput($origName);
				$refNo = $this->sanitizeInput($refNo);

				$query = "INSERT INTO PartnersMotifImages(motifID, serverName, origName, imageRefNo) ";
				$query .= "VALUES(". $motifID .", '". $serverName ."', '". $origName ."', ". $refNo .")";

				if ($this->conn->query($query) === TRUE){
                    return true;
                }
                return false;
			}
		}

		public function DeletePartnerMotif_Image($imageID){

			if (! $this->conn->connect_error){

				$imageID = $this->sanitizeInput($imageID);

				$query = "UPDATE PartnersMotifImages SET isDelete=1 WHERE id=" . $imageID;

				if ($this->conn->query($query) === TRUE){
                    return $this->conn->affected_rows;
                }
                return 0;
			}
		}

		public function getPartnersMotif_Query($query){

			$partnersMotif = array();
			$partnersMotifData = array();

			if (! $this->conn->connect_error){

				$result = $this->conn->query($query);

				if (is_object($result) && !empty($result->num_rows)) {
					while ($row = $result->fetch_assoc()) {

						$partnersMotifData = array("id" => $row['id'],
													"partnerID" => $row['partnerID'],
										  	 		"theme" => $row['theme'],
										  	 		"prodCatID" => $row['prodCatID'],
										  	 		"userName" => $row['userName'],
										  	 		"prodCat" => $row['prodCat']
										);

						array_push($partnersMotif, $partnersMotifData);
					}

					$result->free();

					return $partnersMotif;
				}
			}
			
			return $partnersMotif;
		}

		public function getPartnerMotifs($partnerID){

			$partners = array();

			$partnerID = $this->sanitizeInput($partnerID);
			
			// SELECT PM.*, PPC.prodCat FROM PartnersMotif As PM, PartnersProductCategory as PPC WHERE PM.prodCatID=PPC.id AND PPC.isDeleted=0 AND PM.isDeleted=0 AND PM.partnerID=15

			// SELECT PM.* FROM PartnersMotif As PM WHERE PM.isDeleted=0 AND PM.partnerID=

			$query = "SELECT PM.*, PPC.prodCat FROM PartnersMotif As PM, PartnersProductCategory as PPC WHERE 
					PM.prodCatID=PPC.id AND PPC.isDeleted=0 AND PM.isDeleted=0 AND PM.partnerID=" . $partnerID;

			$partners = $this->getPartnersMotif_Query($query);

			return $partners;
		}

		public function getPartnerMotifByID($partnerID, $motifID){

			$partners = array();

			$partnerID = $this->sanitizeInput($partnerID);
			$motifID = $this->sanitizeInput($motifID);
			
			$query = "SELECT PM.*, PPC.prodCat FROM PartnersMotif As PM, PartnersProductCategory as PPC WHERE 
					PM.prodCatID=PPC.id AND PPC.isDeleted=0 AND PM.isDeleted=0 AND PM.partnerID=" . $partnerID ." AND PM.id=" . $motifID;

			// $query = "SELECT * FROM PartnersMotif WHERE isDeleted=0 AND partnerID=" . $partnerID . " AND id=" . $motifID;

			$partners = $this->getPartnersMotif_Query($query);

			return $partners;
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

		public function getPartnerMotifsOneImage($imageID){

			$images = array();

			$imageID = $this->sanitizeInput($imageID);
		
			$query = "SELECT * FROM PartnersMotifImages WHERE isDelete=0 AND id=" . $imageID;

			$images = $this->getPartnersMotifImages_Query($query);

			return $images;
		}

		public function insertNewMaterial($material){

			if (! $this->conn->connect_error){

				$adminID = $this->getAdminID(); // inside connection
				$adminUsername = $this->getAdminUsername();

				$material = $this->sanitizeInput($material);

				$query = "INSERT INTO Materials(material, userName, userId) ";
				$query .= "VALUES('". $material ."', '". $adminUsername ."', ". $adminID .")";

				if ($this->conn->query($query) === TRUE){
                    return $this->conn->insert_id;
                }
                return 0;
			}
		}
		public function deleteMaterial($id){

			if (! $this->conn->connect_error){

				$id = $this->sanitizeInput($id);

				$query = "UPDATE Materials SET isDeleted=1 WHERE id=" . $id;

				if ($this->conn->query($query) === TRUE){
                    return $this->conn->affected_rows;
                }
                return 0;
			}
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

		public function insertMaterialTheme($theme, $materialID){

			if (! $this->conn->connect_error){

				$adminID = $this->getAdminID(); // inside connection
				$adminUsername = $this->getAdminUsername();

				$theme = $this->sanitizeInput($theme);
				$materialID = $this->sanitizeInput($materialID);

				$query = "INSERT INTO MaterialThemes(materialID, theme, userName, userId) ";
				$query .= "VALUES(". $materialID .", '". $theme ."', '". $adminUsername ."', ". $adminID .")";

				if ($this->conn->query($query) === TRUE){
                    return $this->conn->insert_id;
                }

                return 0;
			}
		}

		public function deleteMaterialTheme($themeID){

			if (! $this->conn->connect_error){

				$themeID = $this->sanitizeInput($themeID);

				$query = "UPDATE MaterialThemes SET isDeleted=1 WHERE id=" . $themeID;

				if ($this->conn->query($query) === TRUE){
                    return $this->conn->affected_rows;
                }

                return 0;
			}
		}

		public function insertMaterialThemeImage($themeID, $serverName, $origName, $refNo){

			if (! $this->conn->connect_error){

				$themeID = $this->sanitizeInput($themeID);
				$serverName = $this->sanitizeInput($serverName);
				$origName = $this->sanitizeInput($origName);
				$refNo = $this->sanitizeInput($refNo);

				$query = "INSERT INTO MaterialsTheme_images(themeID, serverName, origName, referenceNo) ";
				$query .= "VALUES(". $themeID .", '". $serverName ."', '". $origName ."', ". $refNo .")";

				if ($this->conn->query($query) === TRUE){
                    return true;
                }

                return false;
			}
		}

		public function deleteMaterialThemeImage($imageID){

			if (! $this->conn->connect_error){

				$imageID = $this->sanitizeInput($imageID);

				$query = "UPDATE MaterialsTheme_images SET isDeleted=1 WHERE id=" . $imageID;

				if ($this->conn->query($query) === TRUE){
                    return $this->conn->affected_rows;
                }

                return 0;
			}
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

		public function getAllThemesPerMaterial(){

			$themes = array();

			$query = "SELECT MT.id, M.material, MT.theme, MT.userName, MT.userId
						  FROM Materials As M, MaterialThemes As MT
						  WHERE MT.materialID=M.id AND MT.isDeleted=0 AND M.isDeleted=0";

			$themes = $this->getThemesPerMaterialBy_Query($query);
			
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

		public function getThemesPerMaterialByThemeID($themeID){

			$themes = array();

			$themeID = $this->sanitizeInput($themeID);

			$query = "SELECT MT.id, M.material, MT.theme, MT.userName, MT.userId
						  FROM Materials As M, MaterialThemes As MT
						  WHERE MT.materialID=M.id AND MT.isDeleted=0 AND M.isDeleted=0 AND MT.id=" . $themeID;

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

		public function getThemes_ImagesByID($imageID){

			$images = array();

			$imageID = $this->sanitizeInput($imageID);

			$query = "SELECT * FROM MaterialsTheme_images WHERE isDeleted=0 AND id=" . $imageID;

			$images = $this->getThemes_Images_Query($query);

			return $images;
		}

		public function insertNewService($service){

			if (! $this->conn->connect_error){

				$service = $this->sanitizeInput($service);

				$query = "INSERT INTO Services(service) VALUES('". $service ."')";

				if ($this->conn->query($query) === TRUE){
                    return $this->conn->insert_id;
                }

                return 0;
			}
		}

		public function deleteService($serviceID){

			if (! $this->conn->connect_error){

				$serviceID = $this->sanitizeInput($serviceID);

				$query = "UPDATE Services SET isDeleted=1 WHERE id=" . $serviceID;

				if ($this->conn->query($query) === TRUE){
                    return $this->conn->affected_rows;
                }

                return 0;
			}
		}

		public function insertNewServiceMotif($serviceID, $motif){

			if (! $this->conn->connect_error){

				$serviceID = $this->sanitizeInput($serviceID);
				$motif = $this->sanitizeInput($motif);

				$query = "INSERT INTO ServiceMotifs(serviceID, motif) VALUES(".$serviceID.", '". $motif ."')";

				if ($this->conn->query($query) === TRUE){
                    return $this->conn->affected_rows;
                }

                return 0;
			}
		}

		public function deleteServiceMotif($motifID){

			if (! $this->conn->connect_error){

				$motifID = $this->sanitizeInput($motifID);

				$query = "UPDATE ServiceMotifs SET isDeleted=1 WHERE id=" . $motifID;

				if ($this->conn->query($query) === TRUE){
                    return $this->conn->affected_rows;
                }

                return 0;
			}
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

		public function getServiceByID($id){

			$services = array();

			$id = $this->sanitizeInput($id);

			$query = "SELECT * FROM Services WHERE isDeleted=0 AND id=". $id;

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

		public function getAllServiceMotifs(){

			$services = array();
			$query = "SELECT SM.id, S.service, SM.motif
							FROM  Services as S, ServiceMotifs as SM
							WHERE SM.serviceID=S.id AND S.isDeleted=0 AND SM.isDeleted=0";

			$services = $this->getServiceMotifs_Query($query);
			
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

		public function getServiceMotifsBymotifID($motifID){

			$services = array();

			$motifID = $this->sanitizeInput($motifID);

			$query = "SELECT SM.id, S.service, SM.motif
							FROM  Services as S, ServiceMotifs as SM
							WHERE SM.serviceID=S.id AND S.isDeleted=0 AND SM.isDeleted=0 AND SM.id=" . $motifID;

			$services = $this->getServiceMotifs_Query($query);
			
			return $services;
		}

		public function insertMenu($data){

			if (! $this->conn->connect_error){

				$setTitle = $this->sanitizeInput($data['setTitle']);
				$setPrice = $this->sanitizeInput($data['setPrice']);
				$soup = $this->sanitizeInput($data['soup']);
				$soup_changable = $this->sanitizeInput($data['soup_changable']);
				$chicken = $this->sanitizeInput($data['chicken']);
				$chicken_changable = $this->sanitizeInput($data['chicken_changable']);
				$seafoods = $this->sanitizeInput($data['seafoods']);
				$seafoods_changable = $this->sanitizeInput($data['seafoods_changable']);
				$pork_beef = $this->sanitizeInput($data['pork_beef']);
				$pork_beef_changable = $this->sanitizeInput($data['pork_beef_changable']);
				$vegetable = $this->sanitizeInput($data['vegetable']);
				$vegetable_changable = $this->sanitizeInput($data['vegetable_changable']);
				$rice = $this->sanitizeInput($data['rice']);
				$rice_changable = $this->sanitizeInput($data['rice_changable']);
				$salad = $this->sanitizeInput($data['salad']);
				$salad_changable = $this->sanitizeInput($data['salad_changable']);
				$dessert = $this->sanitizeInput($data['dessert']);
				$dessert_changable = $this->sanitizeInput($data['dessert_changable']);
				$drinks = $this->sanitizeInput($data['drinks']);
				$drinks_changable = $this->sanitizeInput($data['drinks_changable']);

				$query = "INSERT INTO Menus(setTitle, setPrice, soup, soupIsChangable, chicken, chickenIsChangable,
										seafoods, seafoodsIsChangable, porkBeef, porkBeefIsChangable, vegetable, 
										vegetableIsChangable, rice, riceIsChangable, salad, saladIsChangable, 
										dessert, dessertIsChangable, drinks, drinksIsChangable) ";
				$query .= "VALUES('". $setTitle ."', ". $setPrice .", '". $soup ."', ". $soup_changable .", '". $chicken ."',
									". $chicken_changable .", '". $seafoods ."', ". $seafoods_changable .", '". $pork_beef ."',
									". $pork_beef_changable .", '". $vegetable ."', ". $vegetable_changable .", '". $rice ."',
									". $rice_changable .", '". $salad ."', ". $salad_changable .", '". $dessert ."', ". $dessert_changable .",
									'". $drinks ."', ". $drinks_changable .")";

				if ($this->conn->query($query) === TRUE){
                    return $this->conn->affected_rows;
                }

                return 0;
			}
		}

		public function updateMenu($data){

			if (! $this->conn->connect_error){

				$setTitle = $this->sanitizeInput($data['setTitle']);
				$setPrice = $this->sanitizeInput($data['setPrice']);
				$soup = $this->sanitizeInput($data['soup']);
				$soup_changable = $this->sanitizeInput($data['soup_changable']);
				$chicken = $this->sanitizeInput($data['chicken']);
				$chicken_changable = $this->sanitizeInput($data['chicken_changable']);
				$seafoods = $this->sanitizeInput($data['seafoods']);
				$seafoods_changable = $this->sanitizeInput($data['seafoods_changable']);
				$pork_beef = $this->sanitizeInput($data['pork_beef']);
				$pork_beef_changable = $this->sanitizeInput($data['pork_beef_changable']);
				$vegetable = $this->sanitizeInput($data['vegetable']);
				$vegetable_changable = $this->sanitizeInput($data['vegetable_changable']);
				$rice = $this->sanitizeInput($data['rice']);
				$rice_changable = $this->sanitizeInput($data['rice_changable']);
				$salad = $this->sanitizeInput($data['salad']);
				$salad_changable = $this->sanitizeInput($data['salad_changable']);
				$dessert = $this->sanitizeInput($data['dessert']);
				$dessert_changable = $this->sanitizeInput($data['dessert_changable']);
				$drinks = $this->sanitizeInput($data['drinks']);
				$drinks_changable = $this->sanitizeInput($data['drinks_changable']);
				$id = $this->sanitizeInput($data['id']);

				$query = "UPDATE Menus SET setTitle='". $setTitle ."', setPrice='". $setPrice ."', soup='". $soup ."', ";
				$query .= "soupIsChangable=". $soup_changable .", chicken='". $chicken ."', chickenIsChangable=". $chicken_changable .", ";
				$query .= "seafoods='". $seafoods ."', seafoodsIsChangable=". $seafoods_changable .", porkBeef='". $pork_beef ."', ";
				$query .= "porkBeefIsChangable=". $pork_beef_changable .", vegetable='". $vegetable ."', vegetableIsChangable=". $vegetable_changable .", ";
				$query .= "rice='". $rice ."', riceIsChangable=". $rice_changable .", salad='". $salad ."', saladIsChangable=". $salad_changable .", ";
				$query .= "dessert='". $dessert ."', dessertIsChangable=". $dessert_changable .", drinks='". $drinks ."', drinksIsChangable=". $drinks_changable ." ";
				$query .= "WHERE id=" . $id;

				if ($this->conn->query($query) === TRUE){
                    return $this->conn->affected_rows;
                }

                return 0;
			}
		}

		public function deleteMenu($id){

			if (! $this->conn->connect_error){

				$id = $this->sanitizeInput($id);

				$query = "UPDATE Menus SET isDeleted=1 WHERE id=" . $id;

				if ($this->conn->query($query) === TRUE){
                    return $this->conn->affected_rows;
                }

                return 0;
			}
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

		public function insertNewVenue($venue, $notes, $isOutsideVenue){

			if (! $this->conn->connect_error){

				$venue = $this->sanitizeInput($venue);
				$notes = $this->sanitizeInput($notes);
				$isOutsideVenue = $this->sanitizeInput($isOutsideVenue);

				$query = "INSERT INTO Venues(venue, notes, isOutside) VALUES('". $venue ."', '". $notes ."', ". $isOutsideVenue .")";

				if ($this->conn->query($query) === TRUE){
                    return $this->conn->affected_rows;
                }
                return 0;
			}
		}

		public function getAllVenues(){

			$venues = array();

			if (! $this->conn->connect_error){

				$query = "SELECT * FROM Venues WHERE isDeleted=0 ORDER BY id DESC";

				$result = $this->conn->query($query);

				if (is_object($result) && !empty($result->num_rows)) {
					while ($row = $result->fetch_assoc()) {

						array_push($venues, array("id" => $row['id'],
												 "venue" => $row['venue'],
												 "notes" => $row['notes'],
												 "isOutside" => $row['isOutside']
												));
					}

					$result->free();
					return $venues;
				}
			}
			return $venues;
		}

		public function deleteVenue($venueID){

			if (! $this->conn->connect_error){

				$venueID = $this->sanitizeInput($venueID);

				$query = "UPDATE Venues SET isDeleted=1 WHERE id=" . $venueID;

				if ($this->conn->query($query) === TRUE){
                    return $this->conn->affected_rows;
                }
                return 0;
			}
		}

		public function insertNewBudgetRange($budgetRange){

			if (! $this->conn->connect_error){

				$budgetRange = $this->sanitizeInput($budgetRange);

				$query = "INSERT INTO BudgetRanges(budgetRange) VALUES('". $budgetRange ."')";

				if ($this->conn->query($query) === TRUE){
                    return $this->conn->affected_rows;
                }
                return 0;
			}
		}

		public function deleteBudgetRange($budgetRangeID){

			if (! $this->conn->connect_error){

				$budgetRangeID = $this->sanitizeInput($budgetRangeID);

				$query = "UPDATE BudgetRanges SET isDeleted=1 WHERE id=" . $budgetRangeID;

				if ($this->conn->query($query) === TRUE){
                    return $this->conn->affected_rows;
                }
                return 0;
			}
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

		public function getInquiries_Query($query){

			$inquiries = array();

			if (! $this->conn->connect_error){

				$result = $this->conn->query($query);

				if (is_object($result) && !empty($result->num_rows)) {
					while ($row = $result->fetch_assoc()) {

						array_push($inquiries, array("id" => $row['id'],
													"email" => $row['email'],
													"name" => $row['name'],
													"contactNo" => $row['contactNo'],
													"event" => $row['event'],
													"venue" => $row['venue'],
													"venueAddress" => $row['venueAddress'],
													"noOfGuests" => $row['noOfGuests'],
													"inquiry" => $row['inquiry'],
													"dateInq" => $row['dateInq']
												));
					}

					$result->free();
					return $inquiries;
				}
			}

			return $inquiries;
		}

		public function getAllInquiries(){
			$query = "SELECT * FROM Inquiries ORDER BY id DESC";
			$inquiries = $this->getInquiries_Query($query);
			return $inquiries;
		}

		public function getInquiryBYID($id){
			$id = $this->sanitizeInput($id);
			$query = "SELECT * FROM Inquiries WHERE id=". $id;
			$inquiries = $this->getInquiries_Query($query);
			return $inquiries;
		}
	
		public function deleteInquiry($id){

			if (! $this->conn->connect_error){

				$id = $this->sanitizeInput($id);

				$query = "DELETE FROM Inquiries WHERE id=" . $id;
				
				if ($this->conn->query($query) === TRUE){
                    return $this->conn->affected_rows;
                }
                return 0;
			}
		}
	
		public function getEvents_Query($query){

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

		public function getAllEventsByStatus($status){

			$status = $this->sanitizeInput($status);

			$query = "SELECT CE.id, CE.clientInfoID, S.service, SM.motif, V.venue, CE.eventDate, ";
			$query .= "CE.eventStartTime, CE.eventEndTime, CE.noOfGuests, CE.entryDate, CE.eventStatus, CE.venueAddress ";
			$query .= "FROM ClientEvents As CE, Services As S, ServiceMotifs as SM, Venues as V ";
			$query .= "WHERE CE.serviceID=S.id AND CE.serviceMotifID=SM.id ";
			$query .= "AND CE.venueID=V.id AND CE.isDeleted=0 AND CE.eventStatus=" . $status;
			$query .= " ORDER BY CE.id DESC";

			$newEvents = $this->getEvents_Query($query);

			return $newEvents;
		}

		public function getAllCancelEvents(){

			$query = "SELECT CE.id, CE.clientInfoID, S.service, SM.motif, V.venue, CE.eventDate, ";
			$query .= "CE.eventStartTime, CE.eventEndTime, CE.noOfGuests, CE.entryDate, CE.eventStatus, CE.venueAddress ";
			$query .= "FROM ClientEvents As CE, Services As S, ServiceMotifs as SM, Venues as V ";
			$query .= "WHERE CE.serviceID=S.id AND CE.serviceMotifID=SM.id ";
			$query .= "AND CE.venueID=V.id AND CE.isDeleted=1 ORDER BY CE.id DESC LIMIT 250";

			$newEvents = $this->getEvents_Query($query);

			return $newEvents;
		}

		public function getEventByID($id){

			$id = $this->sanitizeInput($id);

			$query = "SELECT CE.id, CE.clientInfoID, S.service, SM.motif, V.venue, CE.eventDate,";
			$query .= "CE.eventStartTime, CE.eventEndTime, CE.noOfGuests, CE.entryDate, CE.eventStatus, CE.venueAddress ";
			$query .= "FROM ClientEvents As CE, Services As S, ServiceMotifs as SM, Venues as V ";
			$query .= "WHERE CE.serviceID=S.id AND CE.serviceMotifID=SM.id ";
			$query .= "AND CE.venueID=V.id AND CE.isDeleted=0 AND CE.id=" . $id;
			$query .= " ORDER BY CE.id DESC";

			$newEvents = $this->getEvents_Query($query);

			return $newEvents;
		}

		public function getAllEventMaterialImgs($eventID){

			$materials = array();

			if (! $this->conn->connect_error){

				$eventID = $this->sanitizeInput($eventID);

				$query ="SELECT MTI.serverName, MTI.referenceNo, MT.theme, M.material, MTI.price
						FROM EventsMaterials as EM, MaterialsTheme_images MTI, MaterialThemes as MT, Materials as M
						WHERE EM.isDeleted=0 AND EM.materialMotifImgID=MTI.id AND MTI.themeID=MT.id AND EM.materialID=M.id
						AND EM.eventID=" . $eventID;

				$result = $this->conn->query($query);

				if (is_object($result) && !empty($result->num_rows)) {
					while ($row = $result->fetch_assoc()) {

						array_push($materials, array(
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

				$query ="SELECT PPC.prodCat, PMI.serverName, PMI.imageRefNo, PM.theme, PMI.price
						FROM EventsFoodsEntertainments as EFE, PartnersProductCategory as PPC, PartnersMotifImages as PMI, PartnersMotif as PM
						WHERE EFE.isDeleted=0 AND EFE.prodCatID=PPC.id AND EFE.PartnersMotifImgID=PMI.id AND PMI.motifID=PM.id AND EFE.eventID=" . $eventID;

				$result = $this->conn->query($query);

				if (is_object($result) && !empty($result->num_rows)) {
					while ($row = $result->fetch_assoc()) {

						array_push($foodsEnter, array(
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

		public function getClientInfo($clientID){

			$infos = array();

			if (! $this->conn->connect_error){

				$clientID = $this->sanitizeInput($clientID);

				$query ="SELECT email, fullName, contactNo, dateReg FROM RegisteredClient WHERE id=" . $clientID;

				$result = $this->conn->query($query);

				if (is_object($result) && !empty($result->num_rows)) {
					while ($row = $result->fetch_assoc()) {

						array_push($infos, array(
								"email" => $row['email'],
								"fullName" => $row['fullName'],
								"contactNo" => $row['contactNo'],
								"dateReg" => $row['dateReg']
						));
					}

					$result->free();
				}
			}

			return $infos;
		}

		public function getEventStatus($eventID){

			$status = 0;

			if (! $this->conn->connect_error){

				$eventID = $this->sanitizeInput($eventID);

				$query ="SELECT eventStatus FROM ClientEvents WHERE id=" . $eventID;

				$result = $this->conn->query($query);

				if (is_object($result) && !empty($result->num_rows)) {
					while ($row = $result->fetch_assoc()) {
						$status = $row['eventStatus'];
					}

					$result->free();
				}
			}

			return $status;
		}
		
		public function getEventDetails($eventID){

			$time = array();

			if (! $this->conn->connect_error){

				$eventID = $this->sanitizeInput($eventID);

				$query ="SELECT clientInfoID, eventDate, eventStartTime, eventEndTime FROM ClientEvents WHERE id=" . $eventID;

				$result = $this->conn->query($query);

				if (is_object($result) && !empty($result->num_rows)) {
					while ($row = $result->fetch_assoc()) {
						$time = array("start" => $row['eventStartTime'], 
									"end" => $row['eventEndTime'], 
									"date" => $row['eventDate'],
									"clientID" => $row['clientInfoID']);
					}

					$result->free();
				}
			}

			return $time;
		}
		
		public function getClientEmailAdd($clientID){

			$email = array();

			if (! $this->conn->connect_error){

				$clientID = $this->sanitizeInput($clientID);

				$query ="SELECT email FROM RegisteredClient WHERE id=" . $clientID;
				
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
		
		public function checkIfEventSchedIsApplicable($start, $end, $date){

			$count = 0;
			
			if (! $this->conn->connect_error){

				$start = $this->sanitizeInput($start);
				$end = $this->sanitizeInput($end);
				$date = $this->sanitizeInput($date);
				
				$date = $this->getProperDate($date);

				$query ="SELECT COUNT(*) as count FROM clientevents WHERE ((eventStartTime BETWEEN '". $start ."' AND '". $end ."') 
				OR (eventEndTime BETWEEN '". $start ."' AND '". $end ."')) AND eventStatus=2 and eventDate='". $date ."' AND isDeleted=0";

				$result = $this->conn->query($query);

				if (is_object($result) && !empty($result->num_rows)) {
					while ($row = $result->fetch_assoc()) {
						$count = $row['count'];
					}

					$result->free();
				}
			}

			return $count;
		}
		

		public function changeEventStatus($status, $eventID){

			if (! $this->conn->connect_error){

				$status = $this->sanitizeInput($status);
				$eventID = $this->sanitizeInput($eventID);

				$query = "UPDATE ClientEvents SET eventStatus=". $status ." WHERE id=" . $eventID;

				if ($this->conn->query($query) === TRUE){
                    return $this->conn->affected_rows;
                }
                return 0;
			}
		}

		public function getRegisteredClients_Query($query){

			$clientInfos = array();

			if (! $this->conn->connect_error){

				$result = $this->conn->query($query);

				if (is_object($result) && !empty($result->num_rows)) {
					while ($row = $result->fetch_assoc()) {
						array_push($clientInfos, array(
								"id" => $row['id'],
								"email" => $row['email'],
								"fullName" => $row['fullName'],
								"contactNo" => $row['contactNo'],
								"dateReg" => $row['dateReg']
						));
					}

					$result->free();
				}
			}

			return $clientInfos;
		}

		public function getAllRegisteredClients(){
			$query ="SELECT * FROM RegisteredClient ORDER BY id DESC";
			$clients = $this->getRegisteredClients_Query($query);
			return $clients;
		}

		public function searchRegisteredClients($searchStr){

			$searchStr = $this->sanitizeInput($searchStr);

			$query ="SELECT * FROM RegisteredClient WHERE email LIKE '". $searchStr ."%' 
						OR fullName LIKE '". $searchStr ."%' OR contactNo LIKE '". $searchStr ."%'";

			$clients = $this->getRegisteredClients_Query($query);
			return $clients;
		}

		public function searchRegisteredClientsByDateReg($startDate, $endDate){

			$startDate = $this->sanitizeInput($startDate);
			$endDate = $this->sanitizeInput($endDate);

			$startDate = $this->getProperDate($startDate);
			$endDate = $this->getProperDate($endDate);

			$query ="SELECT * FROM RegisteredClient WHERE dateReg BETWEEN '". $startDate ."' AND '". $endDate ."' ";
						
			$clients = $this->getRegisteredClients_Query($query);
			return $clients;
		}

		public function insertClientEventBill($billServerName, $billOrigFilename, $billAmount, $eventID){

			if (! $this->conn->connect_error){

				$billServerName = $this->sanitizeInput($billServerName);
				$billAmount = $this->sanitizeInput($billAmount);
				$eventID = $this->sanitizeInput($eventID);
				$billOrigFilename = $this->sanitizeInput($billOrigFilename);

				$query = "INSERT INTO ClientEventBills(eventID, billFileServer, billOrigFilename, billAmount) ";
				$query .= "VALUES(". $eventID .", '". $billServerName ."', '". $billOrigFilename ."', ". $billAmount .")";

				if ($this->conn->query($query) === TRUE){
                    return $this->conn->insert_id;
                }
                return 0;
			}
		}

		public function getClientBills($eventID){

			$bills = array();

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

		public function updateMaterialPrice($imageID, $price){

			if (! $this->conn->connect_error){

				$imageID = $this->sanitizeInput($imageID);
				$price = $this->sanitizeInput($price);

				$query = "UPDATE MaterialsTheme_images SET price=". $price ." WHERE id=".$imageID;

				if ($this->conn->query($query) === TRUE){
                    return $this->conn->affected_rows;
                }
			}
			
			return 0;
		}

		public function updatePartnersMotifItemPrice($imageID, $price){

			if (! $this->conn->connect_error){

				$imageID = $this->sanitizeInput($imageID);
				$price = $this->sanitizeInput($price);

				$query = "UPDATE PartnersMotifImages SET price=". $price ." WHERE id=".$imageID;

				if ($this->conn->query($query) === TRUE){
                    return $this->conn->affected_rows;
                }
			}
			
			return 0;
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

		public function insertUserAction($action){

			if (! $this->conn->connect_error){

				$currUser = $_SESSION['admin_username'];
				$action = $this->sanitizeInput($action);

				$query = "INSERT INTO AuditTrail(currUser, action) ";
				$query .= "VALUES('". $currUser ."', '". $action ."')";

				if ($this->conn->query($query) === TRUE){
                    return $this->conn->affected_rows;
                }
			}

			return 0;
		}


		public function getAuditTrail_Query($query){

			$logs = array();

			if (! $this->conn->connect_error){

				$result = $this->conn->query($query);

				if (is_object($result) && !empty($result->num_rows)) {
					while ($row = $result->fetch_assoc()) {
						array_push($logs, array(
							"currUser" => $row['currUser'],
							"action" => $row['action'],
							"dateEntry" => $row['dateEntry']
						));
					}
					$result->free();
				}
			}

			return $logs;
		}

		public function getLast100AuditTrails(){
			$query ="SELECT * FROM AuditTrail ORDER BY id DESC LIMIT 100";
			$logs = $this->getAuditTrail_Query($query);
			return $logs;
		}

		public function getAuditTrailByDate($startDate, $endDate){

			$startDate = $this->sanitizeInput($startDate);
			$endDate = $this->sanitizeInput($endDate);

			$startDate = $this->getProperDate($startDate);
			$endDate = $this->getProperDate($endDate);

			$query ="SELECT * FROM AuditTrail WHERE dateEntry BETWEEN '". $startDate ."' AND '". $endDate ."'";
			$logs = $this->getAuditTrail_Query($query);
			return $logs;
		}

		public function deleteClientEvent($eventID){

			if (! $this->conn->connect_error){

				$eventID = $this->sanitizeInput($eventID);

				$query = "UPDATE ClientEvents SET isDeleted=1 WHERE id=" . $eventID;

				if ($this->conn->query($query) === TRUE){
                    return true;
                }
			}
			return false;
		}
		

	}

?>