<?php
include 'connect.php';  // Include your DB connection file

if (isset($_POST['action'])) {
    $action = $_POST['action'];

    // Fetch the current status
    $query = "SELECT status FROM evaluation_status WHERE id = 1";
    $result = mysqli_query($connect, $query);
    $row = mysqli_fetch_assoc($result);
    $status = $row['status'];

    if ($action == 'start' && $status == 0) {
        // Update status to 1 to start the evaluation
        $query1 = "UPDATE evaluation_status SET status = 1 WHERE id = 1";
        if (mysqli_query($connect, $query1)) {
            echo 'success';
        } else {
            echo 'error: ' . mysqli_error($connect);
        }
    } elseif ($action == 'stop' && $status == 1) {
        // Update status to 0 to stop the evaluation
        $query1 = "UPDATE evaluation_status SET status = 0 WHERE id = 1";
        if (mysqli_query($connect, $query1)) {
            echo 'success';
        } else {
            echo 'error: ' . mysqli_error($connect);
        }
    } else {
        echo 'error: Invalid action or status';
    }
}
?>
