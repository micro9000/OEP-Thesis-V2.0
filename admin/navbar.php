 <header>
     <nav class="topbar">
        <div class="siteTitle">
            <h3>Admin Panel</h3>
        </div>
        <ul>
            <li><a href="main.php" class="homePage">Home</a></li>
            <li><a href="inquiries.php" class="inquiriesPage">Inquiries</a></li>
            <li><a href="slideshow.php" class="slideshowPage">Slideshow</a></li>
            <li><a href="recent_events.php" class="recentEventPage">Recent Events Images</a></li>
            <li><a href="partnersProductCategory.php" class="partnersProdCatPage">Product Categories</a></li>
            <li><a href="partners.php" class="partnersPage">Partners</a></li>
            <li><a href="materials.php" class="materialsPage">Materials</a></li>
            <li><a href="services.php" class="servicesPage">Services</a></li>
            <li><a href="venues.php" class="venuePage">Venues</a></li>
            <li><a href="menus.php" class="menusPage">Menus</a></li>
			
			<?php if ($_SESSION['user_type'] == 1): ?>
				<li><a href="users.php" class="usersPage">Users Settings</a></li>
			<?php endif; ?>
			
            <li><a href="client_list.php" class="clientListPage">Client List</a></li>
			
			<?php if ($_SESSION['user_type'] == 1): ?>
				<li><a href="auditTrail.php" class="auditTrail">Audit Trail</a></li>
			<?php endif; ?>
			
            <li style="float:right"><a href="logout.php">Signout</a></li>
        </ul>
     </nav>
 </header>
