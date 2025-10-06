<?php
include "db.php";

$room_id = $_GET['room_id'] ?? '';
$name = $_GET['name'] ?? '';
$email = $_GET['email'] ?? '';
$phone = $_GET['phone'] ?? '';
$checkin = $_GET['checkin'] ?? '';
$checkout = $_GET['checkout'] ?? '';

if (!$room_id || !$name || !$email || !$phone || !$checkin || !$checkout) {
    die("Missing booking details.");
}

// Insert user
$insertUser = "INSERT INTO users (name, email, phone) VALUES ('$name', '$email', '$phone')";
mysqli_query($conn, $insertUser);
$user_id = mysqli_insert_id($conn);

// Get price
$getRoom = "SELECT price_per_night FROM rooms WHERE id = $room_id";
$rData = mysqli_query($conn, $getRoom);
$room = mysqli_fetch_assoc($rData);

$start = strtotime($checkin);
$end = strtotime($checkout);
$days = ($end - $start) / (60 * 60 * 24);
$total = $room['price_per_night'] * $days;

// Insert booking
$insertBooking = "INSERT INTO bookings (user_id, room_id, check_in, check_out, total_price, status)
                  VALUES ($user_id, $room_id, '$checkin', '$checkout', $total, 'confirmed')";
mysqli_query($conn, $insertBooking);

// Mark room unavailable
mysqli_query($conn, "UPDATE rooms SET availability='no' WHERE id=$room_id");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Booking Confirmed</title>
<style>
    body {
        margin: 0;
        font-family: Arial, sans-serif;
        background: #eef1f4;
        text-align: center;
    }
    .box {
        max-width: 600px;
        margin: 50px auto;
        background: white;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    h2 {
        color: #1e2a41;
    }
    .btn {
        background: #1e2a41;
        color: #fff;
        padding: 12px 18px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        text-decoration: none;
        font-size: 16px;
        display: inline-block;
        margin-top: 20px;
    }
</style>
</head>
<body>
<div class="box">
    <h2>Your Booking is Confirmed!</h2>
    <p><strong>Name:</strong> <?php echo $name; ?></p>
    <p><strong>Email:</strong> <?php echo $email; ?></p>
    <p><strong>Phone:</strong> <?php echo $phone; ?></p>
    <p><strong>Check-in:</strong> <?php echo $checkin; ?></p>
    <p><strong>Check-out:</strong> <?php echo $checkout; ?></p>
    <p><strong>Total Price:</strong> $<?php echo $total; ?></p>
    <a href="index.php" class="btn">Back to Home</a>
</div>
</body>
</html>
