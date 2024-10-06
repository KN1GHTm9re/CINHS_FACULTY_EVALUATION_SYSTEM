<?php 

session_start();

include_once 'connect.php';

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="commenceLogout.js"></script>
    <script src="ShowAndHidePassword.js"></script>
    <title>Student Profile</title>
    <style>
        #nav-profile{
            color: gray;
            pointer-events: none;
        }
        img{
            border: 4px solid black;
            border-radius: 50%;
        }
        .edit:hover{
            cursor: pointer;
        }
    </style>
</head>
<body id="student-body">
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
    <div class="student-profile-main-content-con">
        <div class="student-profile-main-content">
        <?php

        $user_id = $_SESSION['user_id'];
        $query = "SELECT * FROM Student WHERE student_id = '$user_id'";
        $result = mysqli_query($connect, $query);
        $row = mysqli_fetch_assoc($result);

        ?>
        <!-- Button trigger modal -->
        <p type="button" id="btnEditStudentProfile" class="bi bi-pencil-square text-end" data-bs-toggle="modal" data-bs-target="#editStudentProfileModal" data-gradeLevel="<?php echo $row["gradeLevel"]; ?>" data-sectionName="<?php echo $row["sectionName"]; ?>">Edit Profile</p>

        <ul style='list-style-type: none; padding: 20px'>
            <li style='text-align: center'><img src='<?php echo "student-images/" .$row['photo']; ?>' height='150px' style='margin-bottom: 30px;'></li>
            <li><p><b style='color: gold;'>ID: </b><?php echo $row['student_id']; ?></p></li>
            <li><p><b style='color: gold;'>Name: </b><?php echo $row['firstName'] . " " . $row['lastName']; ?></p></li>
            <li><p><b style='color: gold;'>Gender: </b><?php echo $row['gender']; ?></p></li>
            <li><p><b style='color: gold;'>Contact Number: </b><?php echo $row['contactNumber']; ?></p></li>
            <li><p><b style='color: gold;'>Grade Level: </b><?php echo $row['gradeLevel']; ?></p></li>
            <li><p><b style='color: gold;'>Section: </b><?php echo $row['sectionName']; ?></p></li>
            <li><p><b style='color: gold;'>Email: </b><?php echo $row['email']; ?></p></li>
            <li><p><b style='color: gold;'>Password: </b><?php echo $row['password']; ?></p></li>
        </ul>
        <?php
                $currentPassword = $row["password"];
            
        ?>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="editStudentProfileModal" tabindex="-1" aria-labelledby="editStudentProfileModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editStudentProfileLabel">Edit Profile</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center p-4">
                    <form action="student-profile.php" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div>
                                <div class="editstudent-photo-con">
                                    <img src='<?php echo 'student-images/' . $row['photo']?>' height='200px'> <br> <br>
                                    <h6 class="text-start">Change Profile</h6>
                                    <div class="input-group mb-3">
                                        <input type="file" name="new-image" class="form-control" id="inputGroupFile02" accept=".jpg, .jpeg, .png" disabled>
                                    </div>
                                    <input type='hidden' name='old-image' value='<?php echo $row['photo']; ?>'> <br>                              
                                </div>
                            </div>
                            <div class="col-12">
                                <h6 class="text-start">ID</h6>
                                <div class="input-group mb-3 w-50">    
                                    <input type="hidden" name="currentStudentId" id="currentStudentId" value="<?php echo $row["student_id"]; ?>">
                                    <input type="text" class="addstudent-studentid form-control" placeholder="ID" aria-label="Recipient's username" aria-describedby="button-addon2" name="txtStudentId" value="<?php echo $row['student_id']; ?>" autocomplete="off" disabled> 
                                </div>
                            </div>
                            <div class="col-6">
                                <h6 class="text-start">First Name</h6>
                                <div class="input-group mb-3">    
                                    <input type="text" class="editstudent-firstname form-control" placeholder="First Name" aria-label="Recipient's username" aria-describedby="button-addon2" name="txtFirstName" value="<?php echo $row['firstName']; ?>" autocomplete="off" disabled>
                                </div>
                            </div>
                            <div class="col-6">
                                <h6 class="text-start">Last Name</h6>
                                <div class="input-group mb-3">
                                    <input type="text" class="editstudent-lastname form-control" placeholder="Last Name" aria-label="Recipient's username" aria-describedby="button-addon2" name="txtLastName" value="<?php echo $row['lastName']; ?>" autocomplete="off" disabled>
                                </div>
                            </div>
                            <div>
                                <div class="row">
                                    <div class="col-3">
                                        <div class="row text-start mb-3">
                                            <h6>Gender<span style="color: red;"> *<span></h6>
                                            <label><input type="radio" name="rdoGender" value="Male" disabled> Male</label>
                                            <label><input type="radio" name="rdoGender" value="Female" disabled> Female</label>
                                            <script>
                                                $(document).ready(function(){
                                                    $("#btnEditStudentProfile").on("click", function(){
                                                        const gender = "<?php echo $row["gender"] ?>";
                                                        $('#editStudentProfile [name="rdoGender"][value="'+ gender +'"]').prop('checked', true);
                                                    });
                                                });
                                            </script>
                                        </div>
                                    </div>
                                    <div class="col-9">
                                        <h6 class="text-start">Contact Number (Optional)</h6>
                                        <div class="input-group mb-3">
                                            <input type="hidden" name="currentContactNumber" id="currentContactNumber" value="<?php echo $row["contactNumber"]; ?>">
                                            <input type="text" class="addstudent-contactnumber form-control" placeholder="Contact Number" aria-label="Recipient's username" aria-describedby="button-addon2" name="txtContactNumber" value="<?php echo $row['contactNumber']; ?>" autocomplete="new-contact">
                                        </div>
                                    </div>
                                </div>
                                <div class="row my-2">
                                    <div class="col-6">
                                        <div class="addstudent-gradeLevel-con">
                                            <label for="gradeLevel" class="addstudent-label">Grade Level: </label><span style="color: red"> *</span>
                                            <select name="gradeLevel" id="gradeLevel" disabled>
                                                <option value="11">11</option>
                                                <option value="12">12</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <div class="addstudent-section-con">
                                            <label for="section" class="addstudent-label">Section: </label><span style="color: red"> *</span>
                                            <select name="section" id="section" disabled>
                                                <script>
                                                    $(document).ready(function() {
                                                        // Function to load sections based on the selected grade level
                                                        function loadSectionsForEditStudentProfile(gradeLevel) {
                                                            $.ajax({
                                                                url: 'fetchSections.php',          // PHP script to fetch sections
                                                                type: 'POST',                      // Send data as POST
                                                                data: { gradeLevel: gradeLevel },  // Send the selected grade level
                                                                success: function(data) {
                                                                    $('#section').html(data);    // Populate the section dropdown
                                                                },
                                                                error: function(xhr, status, error) {
                                                                    console.log('AJAX error: ' + error);  // Log errors
                                                                }
                                                            });
                                                        }

                                                        // When the modal opens, load sections based on the current grade level
                                                        $('#editStudentProfileModal').on('shown.bs.modal', function () {
                                                            var gradeLevel = $('#gradeLevel').val();  // Get selected grade level
                                                            loadSectionsForEditStudentProfile(gradeLevel);  // Load sections when modal is shown
                                                        });

                                                        // Optionally, you can also handle changes in the grade level
                                                        $('#gradeLevel').change(function() {
                                                            var gradeLevel = $(this).val();
                                                            loadSectionsForEditStudentProfile(gradeLevel);  // Load sections when grade level changes
                                                        });
                                                    });
                                                </script>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <h6 class="text-start">Email</h6>
                                <div class="input-group mb-3">
                                    <input type="hidden" name="currentEmail" id="currentEmail" value="<?php echo $row["email"]; ?>">
                                    <input type="text" class="editstudent-email form-control" placeholder="Email" aria-label="Recipient's username" aria-describedby="button-addon2" name="txtEmail" value="<?php echo $row['email']; ?>" autocomplete="off">
                                </div>
                                <h6 class="text-start">Password</h6>
                                <div class="input-group mb-3">
                                    <input type="password" id="txtPasswordEditProfile" class="editstudent-password form-control" placeholder="Password" aria-label="Recipient's username" aria-describedby="button-addon2" name="txtPassword" value="<?php echo $row['password']; ?>" autocomplete="off">
                                    <button id="btnShowPasswordEditProfile" type="button" onclick="showPasswordForEditProfile(this)">SHOW</button>		
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-success" name="btnSaveChanges">Save changes</button>
                            </div>
                        </div>             
                    </form> 
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
        const btnEditStudentProfile = document.querySelector("#btnEditStudentProfile");
        
        btnEditStudentProfile.addEventListener('click', () => {
            const gradeLevel = btnEditStudentProfile.getAttribute('data-gradeLevel');
            const sectionName = btnEditStudentProfile.getAttribute('data-sectionName');


            document.querySelector('#editStudentProfileModal [name="gradeLevel"]').value = gradeLevel;

            // After setting the grade level, load the sections
            loadSectionsForEditStudentProfile(gradeLevel);  // Manually trigger the AJAX call to fetch sections

            // Set the section after it is populated
            setTimeout(() => {
                document.querySelector('#editStudentProfileModal [name="section"]').value = sectionName;
            }, 500);  // Delay to ensure section options are loaded
        });
        
        // AJAX function to load sections based on the selected grade level for updating student
        function loadSectionsForEditStudentProfile(gradeLevel) {
            $.ajax({
                url: 'fetchSections.php',          // PHP script to fetch sections
                type: 'POST',                      // Send data as POST
                data: { gradeLevel: gradeLevel },  // Send the selected grade level
                success: function(data) {
                    $('#editStudentProfileModal #section').html(data);  // Populate the section dropdown
                },
                error: function(xhr, status, error) {
                    console.log('AJAX error: ' + error);  // Log errors
                }
            });
        }
    });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>
</html>

<?php
if(isset($_POST["btnSaveChanges"])) {
    $currentStudentId = $_POST["currentStudentId"];
    $currentContactNumber = $_POST["currentContactNumber"];
    $newContactNumber = $_POST["txtContactNumber"];
    $currentEmail = $_POST["currentEmail"];
    $newEmail = $_POST["txtEmail"];
    $newPassword = $_POST["txtPassword"];
    $editProfileAllowed = true;

    if($newContactNumber != "" && !preg_match("/^09[0-9]{9}$/", $newContactNumber)) {
        echo "<script>alert('Invalid Contact Number. It should start with 09 and be 11 digits long.');</script>";
        $editProfileAllowed = false;
    } else if($newEmail != "" && !filter_var($newEmail, FILTER_VALIDATE_EMAIL)){
        echo "<script>alert('Invalid Email');</script>";
        $editProfileAllowed = false;
    }  

    // Password validation
    if (!preg_match('/[A-Z]/', $newPassword)) {
        echo "<script>alert('Password must contain at least one uppercase letter.');</script>";
        $editProfileAllowed = false;
    } elseif (!preg_match('/[a-z]/', $newPassword)) {
        echo "<script>alert('Password must contain at least one lowercase letter.');</script>";
        $editProfileAllowed = false;
    } elseif (!preg_match('/[0-9]/', $newPassword)) {
        echo "<script>alert('  must contain at least one number.');</script>";
        $editProfileAllowed = false;
    } 

    $query = "SELECT * FROM Student";
    $result = mysqli_query($connect, $query);

    while($row = mysqli_fetch_assoc($result))
    {
        if($newContactNumber != $currentContactNumber)
        {
            if($newContactNumber != "" && $newContactNumber == $row['contactNumber']) 
            {
                echo "<script>alert('Contact Number is already existing.');</script>";
                $editProfileAllowed = false;
                break;
            } 
        }
        else if($newEmail != $currentEmail) 
        {
            if($newEmail != "" && $newEmail == $row['email']) 
            {
                echo "<script>alert('Email is already existing.');</script>";
                $editProfileAllowed = false;
                break;
            } 
        } 
    }

    if($editProfileAllowed){
        $query = $connect->prepare("UPDATE Student SET contactNumber = ?, email = ?, password = ? WHERE student_id = ?");
        $query->bind_param("ssss", $newContactNumber, $newEmail, $newPassword, $currentStudentId);

        // Fetch the current password before making updates
        $newQuery = "SELECT password FROM Student WHERE student_id = ?";
        $stmt = $connect->prepare($newQuery);
        $stmt->bind_param("s", $currentStudentId);
        $stmt->execute();
        $stmt->bind_result($currentPassword);
        $stmt->fetch();
        $stmt->close();

        if ($query->execute()) {
            if($newPassword != $currentPassword) {
                session_destroy(); // Invalidate the session
                echo "<script>alert('Profile updated successfully.');</script>";
                echo "<script>alert('Password has been changed, please relogin.');</script>";
                echo "<script>window.location.href='login-form.php'</script>";
            } else {
                echo "<script>alert('Profile updated successfully.');</script>";
                echo "<script>window.location.href='student-profile.php'</script>";
            }
        } else {
            echo "<script>alert('Failed to update Profile');</script>";
            echo "<script>window.location.href='student-profile.php'</script>";
        } 
    }
}
?>
