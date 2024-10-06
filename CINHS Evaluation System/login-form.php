<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="style.css">
	<script src="ShowAndHidePassword.js"></script>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
	<title>CINHS Faculty Evaluation System</title>
	<style>
		.login-password-txt-con{
			margin-top: 8px;
		}

		#login-show-password{
			display: inline;
			border: none;
		}

		/* Specific styling for smaller screens */
		@media (max-width: 1399px) {
			.login-main-container {
				text-align: center;
				flex-direction: column;
				justify-content: center; /* Align items at the top */
				align-items: center;
				padding: 48px;
			}

			.login-logo-con{
				margin-bottom: 48px;
			}

			.login-logo-con h1{
				font-size: 28px;
			}

			.login-logo-con h2{
				font-size: 24px;
			}
			
			#cinhs-logo{
				height: 150px; /* Smaller logo */
				width: 150px;
			}

			.login-con{
				display: flex;
				justify-content: center;
			}

			.login-items{
				width: 400px;
			}
		}
	</style>
</head>
<body id="login-body">
	<div class="container-fluid">
		<div class="login-main-container row align-items-center">
			<div class="col-sm-12 col-md-12 col-lg-12 col-xl-8 col-xxl-8 text-center">
				<div class="login-logo-con">
					<img id="cinhs-logo" src="cinhs-logo.png">
					<h1>CABUYAO INTEGRATED NATIONAL HIGH SCHOOL</h1>
					<h2>Evaluation System</h2>
				</div>		
			</div>
			<div class="col-sm-12 col-md-12 col-lg-12 col-xl-4 col-xxl-4 text-center">
				<div class="login-con">
					<div class="login-items">		
						<div class="login-header-con">
							<h1 id="login-header">Login</h1>
						</div>
						<form method="post" autocomplete="off">
							<div class="login-userId-con">
								<span id="login-userId-label">ID <span style="color: red"></span></span>
								<input id="login-userId-txt" type="text" name="txtUserId" placeholder="Enter your ID number"required>
							</div>
							<div class="login-password-con">
								<span id="login-password-label">Password <span style="color: red"></span></span>
								<div class="login-password-txt-con">
									<input id="txtPasswordLogin" type="password" name="txtPassword" placeholder="Enter your password" required>
									<button id="btnShowPasswordLogin" type="button" onclick="showPasswordForLogin(this)">SHOW</button>		
								</div>		
							</div>
							<div class="login-btn-con">
								<input id="login-btn" type="submit" value="LOGIN" name="btnLogin">
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>

<?php
// Start the session
session_start();

include_once 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["btnLogin"])) {
    $userId = $_POST["txtUserId"];
    $password = $_POST["txtPassword"];
    $existingUserId = false;
    $matchedPassword = false;
    $userType = "";
	$evaluationIsOngoing = false;

    // Check in Admin table
    $stmt = $connect->prepare("SELECT * FROM Admin WHERE admin_id = ?");
    $stmt->bind_param('s', $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $existingUserId = true;
        $userType = "Admin";
        if ($password == $row["password"]) {
            $matchedPassword = true;
            $_SESSION['user_id'] = urlencode($row['admin_id']);

			$query = "SELECT * FROM evaluation_records";
			$executeQuery = mysqli_query($connect, $query);
			$result = mysqli_num_rows($executeQuery);
			
			if($result > 0){
				$evaluationIsOngoing = true;
			}

			// Store the evaluation status in the session
            $_SESSION['evaluation_is_ongoing'] = $evaluationIsOngoing;
        }
    }

    // If not found in Admin, check in Faculty table
    if (!$existingUserId) {
        $stmt = $connect->prepare("SELECT * FROM Faculty WHERE faculty_id = ?");
        $stmt->bind_param('s', $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            $existingUserId = true;
            $userType = "Faculty";
            if ($password == $row["password"]) {
                $matchedPassword = true;
                $_SESSION['user_id'] = urlencode($row['faculty_id']);
            }
        }
    }

    // If not found in Faculty, check in Student table
    if (!$existingUserId) {
        $stmt = $connect->prepare("SELECT * FROM Student WHERE student_id = ?");
        $stmt->bind_param('s', $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            $existingUserId = true;
            $userType = "Student";
            if ($password == $row["password"]) {
                $matchedPassword = true;
                $_SESSION['user_id'] = urlencode($row['student_id']);
            }
        }
    }

    // Handle login results
    if ($existingUserId == false) {
        echo "<script>alert('Unknown User.')</script>";
        echo "<script>window.location.href='login-form.php'</script>"; 
    } elseif ($existingUserId == true && $matchedPassword == false) {
        echo "<script>alert('Password didn\'t match.')</script>";
        echo "<script>window.location.href='login-form.php'</script>"; 
    } elseif ($existingUserId == true && $matchedPassword == true) {
        if ($userType == "Admin") {
            echo "<script>alert('Login Successful. Welcome Admin.')</script>";
            echo "<script>window.location.href='admin-dashboard.php'</script>"; 
		}
		else if ($userType == "Admin") {
            echo "<script>alert('Login Successful. Welcome Admin.')</script>";
            echo "<script>window.location.href='admin-dashboard.php'</script>"; 

		} elseif ($userType == "Faculty") {
            echo "<script>alert('Login Successful. Welcome Faculty.')</script>";
            echo "<script>window.location.href='faculty-dashboard.php'</script>"; 
        } elseif ($userType == "Student") {
            echo "<script>alert('Login Successful. Welcome Student.')</script>";
            echo "<script>window.location.href='student-dashboard.php'</script>"; 
        }
    }
}
?>
