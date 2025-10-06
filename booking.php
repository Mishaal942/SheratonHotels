<?php
include "db.php";

$room_id = $_GET['room_id'] ?? '';
$checkin = $_GET['checkin'] ?? '';
$checkout = $_GET['checkout'] ?? '';

if (!$room_id || !$checkin || !$checkout) {
    die("Invalid access. Missing parameters.");
}

$query = "SELECT rooms.*, hotels.name AS hotel_name 
          FROM rooms 
          JOIN hotels ON rooms.hotel_id = hotels.id 
          WHERE rooms.id = $room_id LIMIT 1";
$result = mysqli_query($conn, $query);
$room = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Book Room</title>
<style>
    body {
        margin: 0;
        font-family: Arial, sans-serif;
        background: #f2f2f2;
    }
    header {
        background: #1e2a41;
        padding: 20px;
        color: white;
        text-align: center;
        font-size: 24px;
        font-weight: bold;
    }
    .form-container {
        max-width: 600px;
        background: white;
        margin: 30px auto;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    input, button {
        width: 100%;
        padding: 12px;
        margin: 10px 0;
        font-size: 16px;
        border-radius: 6px;
        border: 1px solid #ccc;
    }
    button {
        background: #1e2a41;
        color: white;
        border: none;
        cursor: pointer;
    }
</style>
<script>
    function confirmBooking(roomId, checkin, checkout) {
        const name = document.getElementById("name").value;
        const email = document.getElementById("email").value;
        const phone = document.getElementById("phone").value;

        if (name && email && phone) {
            window.location.href = 
            `confirm.php?room_id=${roomId}&checkin=${checkin}&checkout=${checkout}&name=${name}&email=${email}&phone=${phone}`;
        } else {
            alert("Please enter all details.");
        }
    }
</script>
</head>
<body>

<header>Book: <?php echo $room['hotel_name'] . " - " . $room['room_type']; ?></header>

<div class="form-container">
    <label>Full Name</label>
    <input type="text" id="name" placeholder="Enter your full name">

    <label>Email</label>
    <input type="email" id="email" placeholder="Enter your email">

    <label>Phone Number</label>
    <input type="text" id="phone" placeholder="Enter your phone number">

    <button onclick="confirmBooking(<?php echo $room_id; ?>, '<?php echo $checkin; ?>', '<?php echo $checkout; ?>')">
        Confirm Booking
    </button>
</div>

</body>
</html>
