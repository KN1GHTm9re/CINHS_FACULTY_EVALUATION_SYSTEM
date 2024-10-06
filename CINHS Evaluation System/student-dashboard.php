<?php

session_start();

include_once 'connect.php';

$student_id = $_SESSION['user_id'];
$query = "SELECT * FROM Student WHERE student_id = $student_id";
$result = mysqli_query($connect, $query);
$row = mysqli_fetch_assoc($result);
$firstName = $row['firstName'];
$lastName = $row['lastName'];

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="style.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<script src="commenceLogout.js"></script>
	<title>Student Dashboard</title>
	<style>
		#nav-student-dashboard{
            color: gray;
            pointer-events: none;
        }

		*{
			padding: 0;
			margin: 0;
		}

		.student-dashboard-con{
			text-align: center;
			display: grid;
			grid-template-columns: 1fr;		 
			grid-template-rows: repeat(2, minmax(150px, auto));
		}

		section{
			background-color: green;
			grid-column: 1/3;
			grid-row: 1/2;
			display: grid;
			grid-template-rows: repeat(2, minmax(150px, auto));
		}

		section h1{
			grid-row: 1/3;
			margin: auto;
		}

		.content1{
			background-color: red;
		}
		
		.content1 div{
			margin: auto;
		}
	</style>
</head>
<body id="student-dashboard-body">
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark p-3">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Student</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a id="nav-student-dashboard" class="nav-link" href="student-dashboard.php">DASHBOARD</a>
                    </li>
                    <li class="nav-item">
                        <a id="nav-evaluate" class="nav-link" href="evaluate-faculties.php">EVALUATE</a>
                    </li>
                    <li class="nav-item">
                        <a id="nav-profile" class="nav-link" href="student-profile.php">PROFILE</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a id="nav-logout" class="nav-link" href="#" onclick="commenceLogout()">LOGOUT</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
	<div class='student-dashboard-con'>
		<!--
		<section>
			<h1>Welcome to the evaluation system of CINHS, <?php echo $firstName . " " . $lastName ?>!</h1>
		</section>
		<div class='content1'>
			<p>awit</p>
			<p>The percentage marks your evaluation progress.</p>
		</div>
		-->
	</div>
</body>
</html>