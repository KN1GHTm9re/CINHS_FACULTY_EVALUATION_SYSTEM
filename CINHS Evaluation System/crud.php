<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="style.css">
	<script src="commenceLogout.js"></script>
	<title>Book Haven Account Login</title>
</head>
<body id="crud-body">
	<nav class="nav-bar">
		<div class="nav-items">			
			<a id="nav-home" class="nav-items" href="admin-dashboard.php">DASHBOARD</a>
			<a id="nav-register" class="nav-items" href="listofadmins.php">ADMIN</a>
			<a id="nav-about" class="nav-items" href="#">FACULTY</a>
			<a id="nav-contact" class="nav-items" href="listofstudents.php">STUDENTS</a>
			<a id="nav-profle" class="nav-items" href="admin-profile.php">PROFILE</a>	
			<a id="nav-logout" class="nav-items" onclick="commenceLogout()">LOGOUT</a>	
		</div>
	</nav>
	<div class="crud-items">
		<div class="crud-con">
			<a id="crud-add" class="crud-items" href="addstudent-form.php">ADD A STUDENT</a>
			<a id="crud-update" class="crud-items" href="listofstudents.php">UPDATE A STUDENT INFO</a>
			<a id="crud-delete" class="crud-items" href="listofstudents.php">DELETE A STUDENT</a>
			<a id="crud-list" class="crud-items" href="listofstudents.php">LIST OF STUDENTS</a>
			<a id="crud-list" class="crud-items" href="listofadmins.php">LIST OF ADMINS</a>
		</div>
	</div>
</body>
</html>