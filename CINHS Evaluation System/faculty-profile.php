<?php 

session_start();

include_once 'connect.php';

$faculty_id = $_SESSION["user_id"];

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
    <title>Faculty Profile</title>
    <style>
        #nav-profile{
            color: gray;
            pointer-events: none;
        }
        img{
            border: 8px solid black;
            border-radius: 50%;
        }
    </style>
</head>
<body id="faculty-body">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark p-3">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Faculty</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a id="nav-faculty-dashboard" class="nav-link" href="faculty-dashboard.php">DASHBOARD</a>
                    </li>
                    <!-- <li class="nav-item">
                        <a id="nav-evaluate" class="nav-link" href="evaluate-faculties.php">EVALUATE</a>
                    </li> -->
                    <li class="nav-item">
                        <a id="nav-profile" class="nav-link" href="faculty-profile.php">PROFILE</a>
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
    <div class="faculty-profile-main-content-con">
        <div class="faculty-profile-main-content">
            <div class="row p-0">
                <div>
                    <!-- Button trigger modal -->
                    <p type="button" class="bi bi-pencil-square text-end" data-bs-toggle="modal" data-bs-target="#editFacultyProfile" id="btnEditFacultyProfile">Edit Profile</p>
                <?php
                    $query = "SELECT * FROM Faculty WHERE faculty_id = '$faculty_id'";
                    $result = mysqli_query($connect, $query);

                    foreach($result as $row)
                    {
                ?>
                    <ul style='list-style-type: none; padding: 20px'>
                        <li style='text-align: center'><img src='<?php echo "faculty-images/" .$row['photo']; ?>' height='150px' style='margin-bottom: 30px;'></li>
                        <li><p><b style='color: gold;'>ID: </b><?php echo $row['faculty_id']; ?></p></li>
                        <li><p><b style='color: gold;'>Name: </b><?php echo $row['firstName'] . " " . $row['lastName']; ?></p></li>
                        <li><p><b style='color: gold;'>Gender: </b><?php echo $row['gender']; ?></p></li>
                        <li><p><b style='color: gold;'>Contact Number: </b><?php echo $row['contactNumber']; ?></p></li>
                        <li><p><b style='color: gold;'>Email: </b><?php echo $row['email']; ?></p></li>
                        <li><p><b style='color: gold;'>Password: </b><?php echo $row['password']; ?></p></li>
                    </ul>
                <?php
                    }
                ?>        
                </div>
                <div class="row text-center">  
                    <?php 
                    
                    $query = "SELECT s.gradeLevel, s.section_id, s.sectionName, sf.section_id, sf.faculty_id
                            FROM section s
                            INNER JOIN sections_faculties sf ON s.section_id = sf.section_id
                            WHERE sf.faculty_id = $faculty_id";
                    $executeQuery = mysqli_query($connect, $query);

                    ?>
                    <div class="col-12">
                        <h5 class="p-2" style="color: gold;">Sections</h5>
                    </div>
                    <div class="col-6 text-start">
                        <h6 class="p-2 text-center">Grade 11</h6>
                        <?php
                        
                        while($row = mysqli_fetch_assoc($executeQuery)){
                            if($row["gradeLevel"] == "11"){
                        ?>
                            <ul>
                                <li><?php echo $row["section_id"] . " - " . $row["sectionName"]; ?></li>
                            </ul>
                        <?php
                            }
                        }

                        ?>
                    </div>
                    <div class="col-6 text-start">
                        <h6 class="p-2 text-center">Grade 12</h6>
                        <?php 
                        
                        // Fetch the results again for Grade 12 or reset the data pointer
                        mysqli_data_seek($executeQuery, 0);  // Reset the pointer to the beginning
                        
                        while($row = mysqli_fetch_assoc($executeQuery)){
                            if($row["gradeLevel"] == "12"){
                        ?>
                            <ul>
                                <li><?php echo $row["section_id"] . " - " . $row["sectionName"]; ?></li>
                            </ul>
                        <?php
                            }
                        }
                        
                        ?>
                    </div>
                </div>
            </div>       
        </div>
    </div>
    <!-- Modal -->
    <?php

    $query = "SELECT * FROM Faculty WHERE faculty_id = $faculty_id";
    $executeQuery = mysqli_query($connect, $query);
    $result = mysqli_fetch_assoc($executeQuery);
    $row = $result;

    ?>
    <div class="modal fade" id="editFacultyProfile" tabindex="-1" aria-labelledby="editFacultyProfileLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editFacultyProfileLabel">Edit Profile</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center p-4">
                    <form action="faculty-profile.php" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div>
                                <div class="editfaculty-photo-con">
                                    <img src='<?php echo 'faculty-images/' . $row['photo']?>' height='200px'> <br> <br>
                                    <h6 class="text-start">Change Profile</h6>
                                    <div class="input-group mb-3">
                                        <input type="file" name="new-image" class="form-control" id="inputGroupFile02" accept=".jpg, .jpeg, .png">
                                    </div>
                                    <input type='hidden' name='old-image' value='<?php echo $row['photo']; ?>'> <br>                              
                                </div>
                            </div>
                            <div class="col-12">
                                <h6 class="text-start">ID<span style="color: red;"> *<span></h6>
                                <div class="input-group mb-3 w-50">    
                                    <input type="hidden" name="currentFacultyId" id="currentFacultyId" value="<?php echo $row["faculty_id"]; ?>">
                                    <input type="text" class="addfaculty-facultyid form-control" placeholder="ID" aria-label="Recipient's username" aria-describedby="button-addon2" name="txtFacultyId" value="<?php echo $row['faculty_id']; ?>" autocomplete="off" disabled> 
                                </div>
                            </div>
                            <div class="col-6">
                                <h6 class="text-start">First Name</h6>
                                <div class="input-group mb-3">    
                                    <input type="text" class="editfaculty-firstname form-control" placeholder="First Name" aria-label="Recipient's username" aria-describedby="button-addon2" name="txtFirstName" value="<?php echo $row['firstName']; ?>" autocomplete="off" disabled>
                                </div>
                            </div>
                            <div class="col-6">
                                <h6 class="text-start">Last Name</h6>
                                <div class="input-group mb-3">
                                    <input type="text" class="editfaculty-lastname form-control" placeholder="Last Name" aria-label="Recipient's username" aria-describedby="button-addon2" name="txtLastName" value="<?php echo $row['lastName']; ?>" autocomplete="off" disabled>
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
                                                    $("#btnEditFacultyProfile").on("click", function(){
                                                        const gender = "<?php echo $row["gender"] ?>";
                                                        $('#editFacultyProfile [name="rdoGender"][value="'+ gender +'"]').prop('checked', true);
                                                    });
                                                });
                                            </script>
                                        </div>
                                    </div>
                                    <div class="col-9">
                                        <h6 class="text-start">Contact Number (Optional)</h6>
                                        <div class="input-group mb-3">
                                            <input type="hidden" name="currentContactNumber" id="currentContactNumber" value="<?php echo $row["contactNumber"]; ?>">
                                            <input type="text" class="addfaculty-contactnumber form-control" placeholder="Contact Number" aria-label="Recipient's username" aria-describedby="button-addon2" name="txtContactNumber" value="<?php echo $row['contactNumber']; ?>" autocomplete="new-contact">
                                        </div>
                                    </div>
                                </div>
                                <h6 class="text-start">Email</h6>
                                <div class="input-group mb-3">
                                    <input type="hidden" name="currentEmail" id="currentEmail" value="<?php echo $row["email"]; ?>">
                                    <input type="text" class="editfaculty-email form-control" placeholder="Email" aria-label="Recipient's username" aria-describedby="button-addon2" name="txtEmail" value="<?php echo $row['email']; ?>" autocomplete="off">
                                </div>
                                <h6 class="text-start">Password</h6>
                                <div class="input-group mb-3">
                                    <input type="password" id="txtPasswordEditProfile" class="editfaculty-password form-control" placeholder="Password" aria-label="Recipient's username" aria-describedby="button-addon2" name="txtPassword" value="<?php echo $row['password']; ?>" autocomplete="off">
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

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>
</html>
<?php
if(isset($_POST["btnSaveChanges"])) {
    $currentFacultyId = $_POST["currentFacultyId"];
    $currentContactNumber = $_POST["currentContactNumber"];
    $newContactNumber = $_POST["txtContactNumber"];
    $newImageName = $_FILES['new-image']['name'];
    $newImageSize = $_FILES['new-image']['tmp_name'];
    $newImageTmpPath = $_FILES['new-image']['tmp_name'];
    $old_image = $_POST['old-image'];
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

    $query = "SELECT * FROM Faculty";
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
        if ($newImageName == '') {
            $query = $connect->prepare("UPDATE Faculty SET contactNumber = ?, email = ?, password = ? WHERE faculty_id = ?");
            $query->bind_param("ssss", $newContactNumber, $newEmail, $newPassword, $currentFacultyId);
        } else if ($newImageName == 'default-profile.png') {   
            if ($old_image != 'default-profile.png') {
                unlink('faculty-images/'.$old_image);
            }
            $query = $connect->prepare("UPDATE Faculty SET contactNumber = ?, photo = ?, email = ?, password = ? WHERE faculty_id = ?");
            $query->bind_param("sssss", $newContactNumber, $newImageName, $newEmail, $newPassword, $currentFacultyId);
        } else {
            $validImageExtension = ['jpg', 'jpeg', 'png'];
            $imageExtension = explode(".", $newImageName);
            $imageExtension = strtolower(end($imageExtension));
    
            if (!in_array($imageExtension, $validImageExtension)) {
                echo "<script>alert('Invalid image extension');</script>";
            } else {
                $updatedFacultyImage = uniqid() . '.' . $imageExtension;
                move_uploaded_file($newImageTmpPath, 'faculty-images/' . $updatedFacultyImage);
    
                if ($old_image != 'default-profile.png') {
                    unlink('faculty-images/'.$old_image);
                }
    
                $query = $connect->prepare("UPDATE Faculty SET contactNumber = ?, photo = ?, email = ?, password = ? WHERE faculty_id = ?");
                $query->bind_param("sssss", $newContactNumber, $updatedFacultyImage, $newEmail, $newPassword, $currentFacultyId);
            }
        }

        // Fetch the current password before making updates
        $newQuery = "SELECT password FROM Faculty WHERE faculty_id = ?";
        $stmt = $connect->prepare($newQuery);
        $stmt->bind_param("s", $currentFacultyId);
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
                echo "<script>window.location.href='faculty-profile.php'</script>";
            }
        } else {
            echo "<script>alert('Failed to update Profile');</script>";
            echo "<script>window.location.href='faculty-profile.php'</script>";
        }
    } 
}
?>
