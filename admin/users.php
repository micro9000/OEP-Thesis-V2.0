<?php session_start();
	require_once("model/database/Admin_Connection.php");

	$admin_con = new Admin_Connection();

	if (! $admin_con->isAdminLoggedIn()){
		header("Location: index.php");
	}
?>

<?php require_once("header.php"); ?>

<style type="text/css">
	.usersPage{
		border-bottom: 2px solid white;
	}
</style>

<?php require_once("navbar.php"); ?>
	
	<div class="inputFlds">
		<div class="inputFlds_header">
			<h4>Users</h4>
		</div>
		<div class="inputFlds_body">
			<table class="changeUserNameTb">
				<thead>
					<tr>
						<th colspan="2" style="text-align:center">Change Username</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td class="inputFldTitle">New Username</td>
						<td><input type="text" class="inputFld newUsername"></td>
					</tr>
					<tr>
						<td class="inputFldTitle">Enter password</td>
						<td><input type="password" class="inputFld curPassword_username"></td>
					</tr>
					<tr>
						<td colspan="2" style="text-align:center">
							<input type="submit" class="btn btnChangeUsername" value="Change">
							<br/>
							<p class="changeUsernameMsg"></p>
						</td>
					</tr>
				</tbody>
			</table>

			<table class="changePasswordTb">
				<thead>
					<tr>
						<th colspan="2" style="text-align:center">Change Password</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td class="inputFldTitle">New Password</td>
						<td><input type="password" class="inputFld newPassword"></td>
					</tr>
					<tr>
						<td class="inputFldTitle">Enter password</td>
						<td><input type="password" class="inputFld curPassword_password"></td>
					</tr>
					<tr>
						<td colspan="2" style="text-align:center">
							<input type="submit" class="btn btnChangePassword" value="Change">
							<br/>
							<p class="changePasswordMsg"></p>
						</td>
					</tr>
				</tbody>
			</table>

			<div class="clear_both"></div>
		</div>
	</div>

	<div class="inputFlds">
		<?php if(isset($_GET['uTag'])): ?>
			<a href="users.php"><< Back</a>
		<?php endif; ?>

		<div class="inputFlds_header">
			<h4>Add new user</h4>
		</div>
		<div class="inputFlds_body">
			<table class="addUserTb">
				<tr>
					<td class="inputFldTitle">Username</td>
					<td><input type="text" class="inputFld username"></td>
				</tr>
				<tr>
					<td class="inputFldTitle">Email Address</td>
					<td><input type="text" class="inputFld emailAdd"></td>
				</tr>
				<tr>
					<td class="inputFldTitle">Password</td>
					<td><input type="password" class="inputFld password"></td>
				</tr>
				<tr>
					<td class="inputFldTitle">User type</td>
					<td>
						<select class="inputFld userType">
							<option value=""></option>
							<option value="0">Employee</option>
							<option value="1">Admin</option>
						</select>
					</td>
				</tr>
				<tr>
					<td colspan="2" style="text-align:center">
						<?php if(isset($_GET['uTag'])): ?>
							<input type="submit" class="btn btnUpdateUser" value="Update">
							<input type="submit" class="btn btnDeleteUser" value="Delete">
						<?php else: ?>
							<input type="submit" class="btn btnAddNewUser" value="Add">
						<?php endif; ?>
						
						<br/>
						<p class="addUserMsg"></p>
					</td>
				</tr>
			</table>
		</div>
	</div>


	<div class="inputFlds">
		<div class="inputFlds_header">
			<h4>List of Users</h4>
		</div>
		<div class="inputFlds_body">
			<table class="usersListTb">
				<thead>
					<tr>
						<th>Username</th>
						<th>Email Address</th>
						<th>User type</th>
						<th>View</th>
					</tr>
				</thead>
				<tbody class="usersList"></tbody>
			</table>
		</div>
	</div>

<script type="text/javascript">
		
	var uTag = "<?php echo isset($_GET['uTag']) ? $_GET['uTag'] : 0; ?>";

</script>
<script type="text/javascript" src="assets/js/users.js"></script>
<?php require_once("footer.php"); ?>