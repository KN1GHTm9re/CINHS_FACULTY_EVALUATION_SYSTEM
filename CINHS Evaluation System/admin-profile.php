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
    <title>Admin Profile</title>
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
<body id="admin-body">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark p-3">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Admin</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a id="nav-admin-dashboard" class="nav-link" href="admin-dashboard.php">DASHBOARD</a>
                </li>
                <li class="nav-item">
                    <a id="nav-admin" class="nav-link" href="listofadmins.php">ADMIN</a>
                </li>
                <li class="nav-item">
                    <a id="nav-faculty" class="nav-link" href="listoffaculties.php">FACULTY</a>
                </li>
                <li class="nav-item">
                    <a id="nav-student" class="nav-link" href="listofstudents.php">STUDENT</a>
                </li>
                <li class="nav-item">
                        <a id="nav-section" class="nav-link" href="listofsections.php">SECTION</a>
                </li>
                <li class="nav-item">
                    <a id="nav-questionnaire" class="nav-link" href="questionnaire.php">QUESTIONNAIRE</a>
                </li>
                <li class="nav-item">
                    <button id="nav-profile" class="nav-link" href="admin-profile.php">PROFILE</button>
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

    <div class="admin-profile-main-content-con">
        <div class="admin-profile-main-content">
            <!-- Button trigger modal -->
            <p type="button" class="bi bi-pencil-square text-end" data-bs-toggle="modal" data-bs-target="#editAdminProfile" id="btnEditAdminProfile" 
            style="
            <?php                             
            
            $query = "SELECT status FROM evaluation_status";
            $executeQuery = mysqli_query($connect, $query);
            $result = mysqli_fetch_assoc($executeQuery);
            $status = $result["status"];
            
            echo $status == 0 ? 'color: white;' : 'pointer-events: none; color: gray;'  ?>">Edit Profile</p>
        <?php
            $user_id = $_SESSION['user_id'];
            $query = "SELECT * FROM Admin WHERE admin_id = '$user_id'";
            $result = mysqli_query($connect, $query);

            foreach($result as $row)
            {
        ?>
            <ul style='list-style-type: none; padding: 20px'>
                <li style='text-align: center'><img src='<?php echo "admin-images/" .$row['photo']; ?>' height='150px' style='margin-bottom: 30px;'></li>
                <li><p><b style='color: gold;'>ID: </b><?php echo $row['admin_id']; ?></p></li>
                <li><p><b style='color: gold;'>Name: </b><?php echo $row['firstName'] . " " . $row['lastName']; ?></p></li>
                <li><p><b style='color: gold;'>Gender: </b><?php echo $row['gender']; ?></p></li>
                <li><p><b style='color: gold;'>Contact Number: </b><?php echo $row['contactNumber']; ?></p></li>
                <li><p><b style='color: gold;'>Email: </b><?php echo $row['email']; ?></p></li>
                <li><p><b style='color: gold;'>Password: </b><?php echo $row['password']; ?></p></li>
            </ul>
        <?php
                $currentPassword = $row["password"];
            }
        ?>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="editAdminProfile" tabindex="-1" aria-labelledby="editAdminProfileLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editAdminProfileLabel">Edit Profile</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center p-4">
                    <form action="admin-profile.php" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div>
                                <div class="editadmin-photo-con">
                                    <img src='<?php echo 'admin-images/' . $row['photo']?>' height='200px'> <br> <br>
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
                                    <input type="hidden" name="currentAdminId" id="currentAdminId" value="<?php echo $row["admin_id"]; ?>">
                                    <input type="text" class="addadmin-adminid form-control" placeholder="ID" aria-label="Recipient's username" aria-describedby="button-addon2" name="txtAdminId" value="<?php echo $row['admin_id']; ?>" autocomplete="off" required> 
                                </div>
                            </div>
                            <div class="col-6">
                                <h6 class="text-start">First Name</h6>
                                <div class="input-group mb-3">    
                                    <input type="text" class="editadmin-firstname form-control" placeholder="First Name" aria-label="Recipient's username" aria-describedby="button-addon2" name="txtFirstName" value="<?php echo $row['firstName']; ?>" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-6">
                                <h6 class="text-start">Last Name</h6>
                                <div class="input-group mb-3">
                                    <input type="text" class="editadmin-lastname form-control" placeholder="Last Name" aria-label="Recipient's username" aria-describedby="button-addon2" name="txtLastName" value="<?php echo $row['lastName']; ?>" autocomplete="off">
                                </div>
                            </div>
                            <div>
                                <div class="row">
                                    <div class="col-3">
                                        <div class="row text-start mb-3">
                                            <h6>Gender<span style="color: red;"> *<span></h6>
                                            <label><input type="radio" name="rdoGender" value="Male" required> Male</label>
                                            <label><input type="radio" name="rdoGender" value="Female" required> Female</label>
                                            <script>
                                                $(document).ready(function(){
                                                    $("#btnEditAdminProfile").on("click", function(){
                                                        const gender = "<?php echo $row["gender"] ?>";
                                                        $('#editAdminProfile [name="rdoGender"][value="'+ gender +'"]').prop('checked', true);
                                                    });
                                                });
                                            </script>
                                        </div>
                                    </div>
                                    <div class="col-9">
                                        <h6 class="text-start">Contact Number (Optional)</h6>
                                        <div class="input-group mb-3">
                                            <input type="hidden" name="currentContactNumber" id="currentContactNumber" value="<?php echo $row["contactNumber"]; ?>">
                                            <input type="text" class="addadmin-contactnumber form-control" placeholder="Contact Number" aria-label="Recipient's username" aria-describedby="button-addon2" name="txtContactNumber" value="<?php echo $row['contactNumber']; ?>" autocomplete="new-contact">
                                        </div>
                                    </div>
                                </div>
                                <h6 class="text-start">Email</h6>
                                <div class="input-group mb-3">
                                    <input type="hidden" name="currentEmail" id="currentEmail" value="<?php echo $row["email"]; ?>">
                                    <input type="text" class="editadmin-email form-control" placeholder="Email" aria-label="Recipient's username" aria-describedby="button-addon2" name="txtEmail" value="<?php echo $row['email']; ?>" autocomplete="off">
                                </div>
                                <h6 class="text-start">Password</h6>
                                <div class="input-group mb-3">
                                    <input type="password" id="txtPasswordEditProfile" class="editadmin-password form-control" placeholder="Password" aria-label="Recipient's username" aria-describedby="button-addon2" name="txtPassword" value="<?php echo $row['password']; ?>" autocomplete="off">
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>

<?php
if(isset($_POST["btnSaveChanges"])) {
    $currentAdminId = $_POST["currentAdminId"];
    $newAdminId = $_POST["txtAdminId"];
    $newFirstName = $_POST["txtFirstName"];
    $newLastName = $_POST["txtLastName"];
    $newGender = $_POST["rdoGender"];
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

    $query = "SELECT * FROM Admin";
    $result = mysqli_query($connect, $query);

    while($row = mysqli_fetch_assoc($result))
    {
        if($newAdminId != $currentAdminId)
        {
            if($newAdminId != "" && $newAdminId == $row['admin_id'])
            {
                echo "<script>alert('Admin ID is already existing.');</script>";
                $editProfileAllowed = false;
                break;
            }
        }
        else if($newContactNumber != $currentContactNumber)
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
            $query = $connect->prepare("UPDATE Admin SET admin_id = ?, firstName = ?, lastName = ?, gender = ?, contactNumber = ?, email = ?, password = ? WHERE admin_id = ?");
            $query->bind_param("ssssssss", $newAdminId, $newFirstName, $newLastName, $newGender, $newContactNumber, $newEmail, $newPassword, $currentAdminId);
        } else if ($newImageName == 'default-profile.png') {   
            if ($old_image != 'default-profile.png') {
                unlink('admin-images/'.$old_image);
            }
            $query = $connect->prepare("UPDATE Admin SET  admin_id = ?, firstName = ?, lastName = ?, gender = ?, contactNumber = ?, photo = ?, email = ?, password = ? WHERE admin_id = ?");
            $query->bind_param("sssssssss", $newAdminId, $newFirstName, $newLastName, $newGender, $newContactNumber, $newImageName, $newEmail, $newPassword, $currentAdminId);
        } else {
            $validImageExtension = ['jpg', 'jpeg', 'png'];
            $imageExtension = explode(".", $newImageName);
            $imageExtension = strtolower(end($imageExtension));
    
            if (!in_array($imageExtension, $validImageExtension)) {
                echo "<script>alert('Invalid image extension');</script>";
            } else {
                $updatedAdminImage = uniqid() . '.' . $imageExtension;
                move_uploaded_file($newImageTmpPath, 'admin-images/' . $updatedAdminImage);
    
                if ($old_image != 'default-profile.png') {
                    unlink('admin-images/'.$old_image);
                }
    
                $query = $connect->prepare("UPDATE Admin SET admin_id = ?, firstName = ?, lastName = ?, gender = ?, contactNumber = ?, photo = ?, email = ?, password = ? WHERE admin_id = ?");
                $query->bind_param("sssssssss", $newAdminId, $newFirstName, $newLastName, $newGender, $newContactNumber, $updatedAdminImage, $newEmail, $newPassword, $currentAdminId);
            }
        }

        // Fetch the current password before making updates
        $newQuery = "SELECT password FROM Admin WHERE admin_id = ?";
        $stmt = $connect->prepare($newQuery);
        $stmt->bind_param("s", $currentAdminId);
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
                echo "<script>window.location.href='admin-profile.php'</script>";
            }
        } else {
            echo "<script>alert('Failed to update Profile');</script>";
            echo "<script>window.location.href='admin-profile.php'</script>";
        }
    } 
}
?>
