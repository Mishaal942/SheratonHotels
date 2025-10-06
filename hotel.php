<?php
include "db.php";

if (!isset($_GET['hotel_id'])) {
    die("Hotel not found.");
}

$hotel_id = $_GET['hotel_id'];

// Fetch hotel details
$hotelQuery = "SELECT * FROM hotels WHERE id = $hotel_id";
$hotelResult = mysqli_query($conn, $hotelQuery);
$hotel = mysqli_fetch_assoc($hotelResult);

if (!$hotel) {
    die("Hotel not found in database.");
}

// Fetch rooms
$roomQuery = "SELECT * FROM rooms WHERE hotel_id = $hotel_id AND availability = 'yes'";
$rooms = mysqli_query($conn, $roomQuery);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title><?php echo $hotel['name']; ?> - Details</title>
<style>
    body {
        margin: 0;
        font-family: Arial, sans-serif;
        background: #f5f5f5;
    }
    .container {
        max-width: 1000px;
        margin: 40px auto;
        background: white;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
    .hotel-header {
        display: flex;
        gap: 20px;
    }
    .hotel-header img {
        width: 350px;
        height: 250px;
        object-fit: cover;
        border-radius: 10px;
    }
    .details h2 {
        margin: 0;
    }
    hr {
        margin: 25px 0;
    }
    .room {
        background: #fafafa;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 15px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 2px 6px rgba(0,0,0,0.08);
    }
    .book-btn {
        background: #1e2a41;
        color: white;
        padding: 10px 15px;
        text-decoration: none;
        border-radius: 6px;
        font-size: 15px;
    }
    .back-btn {
        display: inline-block;
        margin-bottom: 20px;
        text-decoration: none;
        background: #1e2a41;
        color: white;
        padding: 10px 15px;
        border-radius: 6px;
    }
</style>
</head>
<body>

<div class="container">
    <a href="index.php" class="back-btn">← Back</a>

    <div class="hotel-header">
        <img src="<?php echo $hotel['image']; ?>" alt="Hotel Image">
        <div class="details">
            <h2><?php echo $hotel['name']; ?></h2>
            <p><strong>Location:</strong> <?php echo $hotel['location']; ?></p>
            <p><strong>Rating:</strong> <?php echo $hotel['rating']; ?> ⭐</p>
            <p><strong>Description:</strong> <?php echo $hotel['description']; ?></p>
            <p><strong>Amenities:</strong> <?php echo $hotel['amenities']; ?></p>
        </div>
    </div>

    <hr>

    <h3>Available Rooms</h3>
    <?php
    if (mysqli_num_rows($rooms) > 0) {
        while ($row = mysqli_fetch_assoc($rooms)) {
            echo "
            <div class='room'>
                <div>
                    <strong>Type:</strong> {$row['room_type']} <br>
                    <strong>Price per Night:</strong> $ {$row['price_per_night']}
                </div>
                <a href='booking.php?room_id={$row['id']}' class='book-btn'>Book Now</a>
            </div>";
        }
    } else {
        echo "<p>No rooms available at the moment.</p>";
    }
    ?>
</div>

</body>
</html>
