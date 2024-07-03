<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'config.php'; 

// Check if the user is logged in
if (!isset($_SESSION['userid'])) {
    header("Location: login.php");
    exit();
}

$userid = $_SESSION['userid'];
$role = $_SESSION['role'] ?? '';

// Handle approval and rejection
if ($role == 'admin' && $_SERVER["REQUEST_METHOD"] == "POST") {
    $booking_id = $_POST['booking_id'];
    $action = $_POST['action'];
    
    if ($action == 'approve') {
        $stmt = $conn->prepare("UPDATE approval SET status = 'approved' WHERE id = ?");
    } elseif ($action == 'reject') {
        $stmt = $conn->prepare("UPDATE approval SET status = 'rejected' WHERE id = ?");
    }
    $stmt->bind_param("i", $booking_id);
    $stmt->execute();
    $stmt->close();
}

// Fetch all booking requests for the logged-in user
$stmt = $conn->prepare("SELECT userid, username, studentid, email, phoneNo, type, checkin, checkout, reason, status FROM approval WHERE userid = ?");
$stmt->bind_param("i", $userid);
$stmt->execute();
$stmt->bind_result($id, $username, $studentid, $email, $phoneNo, $type, $checkin, $checkout, $reason, $status);
$bookings = [];
while ($stmt->fetch()) {
    $bookings[] = [
        'userid' => $userid,
        'username' => $username,
        'studentid' => $studentid,
        'email' => $email,
        'phoneNo' => $phoneNo,
        'type' => $type,
        'checkin' => $checkin,
        'checkout' => $checkout,
        'reason' => $reason,
        'status' => $status
    ];
}
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Room Approval</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <nav>
        <div class="container">
            <h1>Request Room Approval</h1>
            <div class="log-container">
                <a href="logout.php">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <h2>Booking Requests</h2>
        <?php if (empty($bookings)): ?>
            <p>No booking requests found.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Student ID</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Room Type</th>
                        <th>Check-in Date</th>
                        <th>Check-out Date</th>
                        <th>Reason</th>
                        <th>Status</th>
                        <?php if ($role == 'admin'): ?>
                            <th>Actions</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($bookings as $booking): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($booking['username']); ?></td>
                            <td><?php echo htmlspecialchars($booking['studentid']); ?></td>
                            <td><?php echo htmlspecialchars($booking['email']); ?></td>
                            <td><?php echo htmlspecialchars($booking['phoneNo']); ?></td>
                            <td><?php echo htmlspecialchars($booking['type']); ?></td>
                            <td><?php echo htmlspecialchars($booking['checkin']); ?></td>
                            <td><?php echo htmlspecialchars($booking['checkout']); ?></td>
                            <td><?php echo htmlspecialchars($booking['reason']); ?></td>
                            <td><?php echo htmlspecialchars($booking['status']); ?></td>
                            <?php if ($role == 'admin' && $booking['status'] == 'pending'): ?>
                                <td>
                                    <form method="POST" action="">
                                        <input type="hidden" name="booking_id" value="<?php echo $booking['id']; ?>">
                                        <button type="submit" name="action" value="approve">Approve</button>
                                        <button type="submit" name="action" value="reject">Reject</button>
                                    </form>
                                </td>
                            <?php elseif ($role == 'admin'): ?>
                                <td>
                                    <span><?php echo ucfirst($booking['status']); ?></span>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>

</html>
