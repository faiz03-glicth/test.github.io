hp
Copy code
<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'config.php'; 



if (!isset($_SESSION['userid'])) {
    header("Location: login.php");
    exit();
}

//fetch user data
$userid = $_SESSION['userid'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userid = $_SESSION['userid'];
    $username = $_POST['username'];
    $studentid = $_POST['studentid'];
    $email = $_POST['email'];
    $phoneNo = $_POST['phoneNo'];
    $type = $_POST['type'];
    $checkin = $_POST['checkin'];
    $checkout = $_POST['checkout'];
    $reason = $_POST['reason'];
    $status = 'pending';

    $stmt = $conn->prepare("INSERT INTO approval (username, studentid, email, phoneNo, type, checkin, checkout, reason, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    if (!$stmt) {
        echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;
    }
    $stmt->bind_param("sssssssss", $username, $studentid, $email, $phoneNo, $type, $checkin, $checkout, $reason, $status);

    if ($stmt->execute()) {
        echo "Booking request submitted.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Room Booking</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="container">
        <h1>Student Room Booking</h1>
        <div class="student">
            <form action="room_booking.php" method="POST">
                <div class="elem-group">
                    <label for="name">Your Name</label>
                    <input type="text" id="name" name="username" placeholder="Adam Faiz Nesh" pattern="[A-Z\sa-z]{3,20}" required>
                </div>
                <div class="elem-group">
                    <label for="student-id">Student ID</label>
                    <input type="text" id="student-id" name="studentid" placeholder="B20EC5009" required>
                </div>
                <div class="elem-group">
                    <label for="email">Your E-mail</label>
                    <input type="email" id="email" name="email" placeholder="nesh.r@graduate.utm.my" required>
                </div>
                <div class="elem-group">
                    <label for="phone">Your Phone</label>
                    <input type="tel" id="phone" name="phoneNo" placeholder="498-348-3872"  required>
                </div>
                <hr>
                <div class="elem-group inlined">
                    <label for="room-type">Room Type</label>
                    <select id="room-type" name="type" required>
                        <option value="">Select a Room Type</option>
                        <option value="single">Single</option>
                        <option value="double">Double</option>
                        <option value="suite">Suite</option>
                    </select>
                </div>
                <div class="elem-group inlined">
                    <label for="checkin-date">Check-in Date</label>
                    <input type="date" id="checkin-date" name="checkin" required>
                </div>
                <div class="elem-group inlined">
                    <label for="checkout-date">Check-out Date</label>
                    <input type="date" id="checkout-date" name="checkout" required>
                </div>
                <div class="elem-group">
                    <label for="reason">Reason for Booking</label>
                    <textarea id="reason" name="reason" placeholder="Explain why you need this booking" required></textarea>
                </div>
                <hr>
                <button type="submit">Book The Room</button>
            </form>
        </div>
    </div>
</body>

</html>
