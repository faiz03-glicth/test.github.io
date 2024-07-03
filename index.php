<?php
session_start();
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
include 'config.php'; 
include 'function.php';

if (!isset($_SESSION['userid'])) {
    header("Location: login.php");
    exit();
}
// Fetch user data
$userid = $_SESSION['userid'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>University Event</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <nav>
        <div class="container">
            <h1>University Event</h1>
        </div>
    </nav>

    <div class="user-box">
        <a href="user.php">
            <img src="User.png" alt="User" class="user-icon">
        </a>
    </div>

    <!-- New small box for logout button -->
    <div class="logout-box">
        <a href="logout.php"><img src= "logout.jpg" alt ="Logout" class="logout-icon">
        </a>
    </div>

    
    <div class="floating-box">
        <a href="view_room_availability.php">View Room</a>
        <a href="Approval.php">Request Approval</a>
    </div>

    <div class="container">
        <h1>University Event: Festival Cuti Raya Haji</h1>

        <div class="event-details">
            <h2>9/6/2024 - 16/6/2024</h2>
            <p>10.00 am - 12.00 am</p>

            <h2>Location</h2>
            <p>University Technology Malaysia, Padang Kawad UTM</p>

            <h2>Description</h2>
            <p>Join us for a fun-filled festival to celebrate Raya Haji with various activities, food stalls, and performances. Bring your family and friends and make the most out of this festive occasion!</p>

            <h2>Contact</h2>
            <p>Contact Person: adam.iskandar@graduate.utm.my</p>

            <h2>Registration</h2>
            <p>No registration required. COME AND JOIN THE FESTIVITIES!!!!!</p>
        </div>
    </div>

    <div class="container">
        <h1>Student Room Booking</h1>
        <button onclick="location.href='room_booking.php'">Book a Room</button>
    </div>

    <div class="container main-content">
        <div class="contact-info">
            <h2>Contact Us</h2>
            <form action="contact.php" method="post">
                <div>
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div>
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div>
                    <label for="message">Message:</label>
                    <textarea id="message" name="message" required></textarea>
                </div>
                <div>
                    <input type="submit" value="Send Message">
                </div>
            </form>
        </div>

        <div class="chatbot">
            <h2>Chatbot</h2>
            <div class="chatbot-box" id="chatbot-box"></div>
            <input type="text" id="chat-input" class="chat-input" placeholder="Type your message here..." onkeypress="message(event)">
        </div>
    </div>

    <footer>
        <p>&copy; 2024 Universiti Teknologi Malaysia</p>
    </footer>

</body>

</html>
