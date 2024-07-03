<?php
session_start();
include 'config.php'; 

if (!isset($_SESSION['userid'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['userid'];

// Fetch user data
$stmt = $conn->prepare("SELECT userid, username, email, password FROM user WHERE userid = ?");
$stmt->bind_param("i", $userid);
$stmt->execute();
$stmt->bind_result($userid, $username, $email, $password);
$stmt->fetch();
$stmt->close();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['update'])) {
        $new_username = $_POST['username'];
        $new_email = $_POST['email'];

        $stmt = $conn->prepare("UPDATE user SET username = ?, email = ? WHERE userid = ?");
        $stmt->bind_param("ssi", $new_username, $new_email, $userid);

        if ($stmt->execute()) {
            echo "Information updated successfully.";
        } else {
            echo "Error updating information: " . $stmt->error;
        }
        $stmt->close();
    } elseif (isset($_POST['delete'])) {
        $stmt = $conn->prepare("DELETE FROM users WHERE userid = ?");
        $stmt->bind_param("i", $userid);

        if ($stmt->execute()) {
            session_destroy();
            header("Location: login.php");
            exit();
        } else {
            echo "Error deleting account: " . $stmt->error;
        }
        $stmt->close();
    }
    header("Location: user.php"); // Refresh the page after update or delete
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>User Profile</h2>
        <div id="user-info">
            <p><strong>Username:</strong> <?php echo htmlspecialchars($username); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
            <button onclick="showEditForm()">Edit Profile</button>
        </div>
        <form id="edit-form" method="POST" action="user.php" style="display:none;">
            <div class="elem-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>" required>
            </div>
            <div class="elem-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
            </div>
            <button type="submit" name="update">Update Information</button>
            <button type="submit" name="delete" onclick="return confirm('Are you sure you want to delete your account?');">Delete Account</button>
        </form>
        <button > <a href= "index.php">Back</a> </button>
    </div>

    <script>
        function showEditForm() {
            document.getElementById('user-info').style.display = 'none';
            document.getElementById('edit-form').style.display = 'block';
        }
    </script>
</body>
</html>
