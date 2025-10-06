<?php
include "db.php";
$location = $_GET['location'] ?? '';
$checkin = $_GET['checkin'] ?? '';
$checkout = $_GET['checkout'] ?? '';
$guests = $_GET['guests'] ?? '2';

if(!$location) {
    header("Location: index.php");
    exit();
}

// Calculate number of nights
$nights = 1;
if($checkin && $checkout) {
    $date1 = new DateTime($checkin);
    $date2 = new DateTime($checkout);
    $nights = $date1->diff($date2)->days;
}

$hotelQuery = "SELECT * FROM hotels WHERE location LIKE '%$location%'";
$hotelResult = mysqli_query($conn, $hotelQuery);
$hotelCount = mysqli_num_rows($hotelResult);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Hotels in <?php echo htmlspecialchars($location); ?> - Sheraton</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        color: #333;
        line-height: 1.6;
    }
    
    /* Navigation */
    nav {
        background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
        padding: 0;
        box-shadow: 0 4px 20px rgba(0,0,0,0.2);
        position: sticky;
        top: 0;
        z-index: 1000;
    }
    
    .nav-container {
        max-width: 1400px;
        margin: 0 auto;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 30px;
    }
    
    .logo {
        font-size: 28px;
        font-weight: bold;
        color: #fff;
        display: flex;
        align-items: center;
        gap: 10px;
        text-decoration: none;
    }
    
    .logo i {
        color: #ffd700;
        font-size: 32px;
    }
    
    .back-btn {
        background: rgba(255,255,255,0.15);
        color: white;
        padding: 10px 20px;
        text-decoration: none;
        border-radius: 8px;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s;
        font-weight: 500;
    }
    
    .back-btn:hover {
        background: rgba(255,255,255,0.25);
        transform: translateX(-5px);
    }
    
    /* Search Summary Banner */
    .search-summary {
        background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
        color: white;
        padding: 30px 20px;
        margin-bottom: 30px;
    }
    
    .summary-content {
        max-width: 1400px;
        margin: 0 auto;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 20px;
    }
    
    .search-info {
        display: flex;
        gap: 30px;
        flex-wrap: wrap;
    }
    
    .info-item {
        display: flex;
        align-items: center;
        gap: 10px;
        background: rgba(255,255,255,0.1);
        padding: 10px 20px;
        border-radius: 10px;
    }
    
    .info-item i {
        font-size: 20px;
        color: #ffd700;
    }
    
    .info-label {
        font-size: 12px;
        opacity: 0.8;
    }
    
    .info-value {
        font-size: 16px;
        font-weight: 600;
    }
    
    .modify-search-btn {
        background: linear-gradient(135deg, #ffd700 0%, #ffed4e 100%);
        color: #1e3c72;
        padding: 12px 25px;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s;
    }
    
    .modify-search-btn:hover {
        transform: scale(1.05);
        box-shadow: 0 6px 20px rgba(255,215,0,0.4);
    }
    
    /* Main Container */
    .main-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 20px 40px;
        display: grid;
        grid-template-columns: 280px 1fr;
        gap: 30px;
    }
    
    /* Sidebar Filters */
    .sidebar {
        background: white;
        padding: 25px;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        height: fit-content;
        position: sticky;
        top: 100px;
    }
    
    .sidebar h3 {
        font-size: 20px;
        margin-bottom: 20px;
        color: #1e3c72;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .filter-section {
        margin-bottom: 30px;
        padding-bottom: 25px;
        border-bottom: 2px solid #f0f0f0;
    }
    
    .filter-section:last-child {
        border-bottom: none;
    }
    
    .filter-section h4 {
        font-size: 16px;
        margin-bottom: 15px;
        color: #333;
    }
    
    .filter-option {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 12px;
        cursor: pointer;
    }
    
    .filter-option input[type="checkbox"] {
        width: 18px;
        height: 18px;
        cursor: pointer;
    }
    
    .filter-option label {
        cursor: pointer;
        flex: 1;
        display: flex;
        justify-content: space-between;
    }
    
    .price-range {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    
    .price-inputs {
        display: flex;
        gap: 10px;
    }
    
    .price-inputs input {
        width: 100%;
        padding: 8px;
        border: 2px solid #e0e0e0;
        border-radius: 6px;
        font-size: 14px;
    }
    
    .rating-filter {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    
    .rating-option {
        padding: 10px;
        border: 2px solid #e0e0e0;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s;
        text-align: center;
    }
    
    .rating-option:hover {
        border-color: #1e3c72;
        background: #f8f9fa;
    }
    
    .rating-option.active {
        background: #1e3c72;
        color: white;
        border-color: #1e3c72;
    }
    
    /* Results Section */
    .results-section {
        min-height: 500px;
    }
    
    .results-header {
        background: white;
        padding: 20px 25px;
        border-radius: 12px;
        margin-bottom: 25px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
    }
    
    .results-count {
        font-size: 18px;
        font-weight: 600;
        color: #1e3c72;
    }
    
    .sort-options {
        display: flex;
        align-items: center;
        gap: 15px;
    }
    
    .sort-options label {
        font-weight: 500;
        color: #666;
    }
    
    .sort-options select {
        padding: 10px 15px;
        border: 2px solid #e0e0e0;
        border-radius: 8px;
        font-size: 14px;
        cursor: pointer;
        outline: none;
    }
    
    /* Hotel Block */
    .hotel-block {
        background: white;
        border-radius: 15px;
        padding: 0;
        margin-bottom: 25px;
        box-shadow: 0 10px 35px rgba(0,0,0,0.1);
        overflow: hidden;
        transition: all 0.3s;
    }
    
    .hotel-block:hover {
        box-shadow: 0 15px 45px rgba(0,0,0,0.15);
        transform: translateY(-5px);
    }
    
    .hotel-header {
        display: flex;
        gap: 25px;
        padding: 20px;
        border-bottom: 2px solid #f5f5f5;
    }
    
    .hotel-image-container {
        position: relative;
        width: 280px;
        height: 200px;
        flex-shrink: 0;
        border-radius: 12px;
        overflow: hidden;
    }
    
    .hotel-image-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s;
    }
    
    .hotel-block:hover .hotel-image-container img {
        transform: scale(1.1);
    }
    
    .hotel-badge {
        position: absolute;
        top: 12px;
        left: 12px;
        background: linear-gradient(135deg, #ffd700 0%, #ffed4e 100%);
        color: #1e3c72;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
        box-shadow: 0 4px 12px rgba(0,0,0,0.2);
    }
    
    .hotel-rating {
        position: absolute;
        top: 12px;
        right: 12px;
        background: white;
        padding: 6px 12px;
        border-radius: 15px;
        display: flex;
        align-items: center;
        gap: 5px;
        font-weight: 700;
        box-shadow: 0 4px 12px rgba(0,0,0,0.2);
    }
    
    .hotel-rating i {
        color: #ffd700;
    }
    
    .hotel-info {
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 12px;
    }
    
    .hotel-info h3 {
        font-size: 26px;
        color: #1e3c72;
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 5px;
    }
    
    .hotel-location {
        color: #666;
        font-size: 15px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .hotel-description {
        color: #555;
        font-size: 14px;
        line-height: 1.6;
        margin-top: 8px;
    }
    
    .hotel-amenities {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
        margin-top: 10px;
    }
    
    .amenity-badge {
        background: #f0f4f8;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 13px;
        color: #1e3c72;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    
    .amenity-badge i {
        font-size: 14px;
    }
    
    /* Rooms Section */
    .rooms-container {
        padding: 20px;
    }
    
    .rooms-header {
        font-size: 18px;
        font-weight: 600;
        color: #1e3c72;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .room-card {
        background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
        padding: 20px;
        border-radius: 12px;
        margin-bottom: 15px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        border: 2px solid #e8e8e8;
        transition: all 0.3s;
    }
    
    .room-card:hover {
        border-color: #1e3c72;
        box-shadow: 0 8px 20px rgba(30,60,114,0.1);
        transform: translateX(5px);
    }
    
    .room-details {
        flex: 1;
    }
    
    .room-type {
        font-size: 18px;
        font-weight: 600;
        color: #1e3c72;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .room-features {
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
        margin-top: 10px;
    }
    
    .room-feature {
        font-size: 13px;
        color: #666;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    
    .room-feature i {
        color: #1e3c72;
    }
    
    .room-pricing {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 8px;
    }
    
    .price-original {
        text-decoration: line-through;
        color: #999;
        font-size: 14px;
    }
    
    .price-current {
        font-size: 32px;
        font-weight: 700;
        color: #1e3c72;
    }
    
    .price-current span {
        font-size: 14px;
        font-weight: 400;
        color: #666;
    }
    
    .price-total {
        font-size: 13px;
        color: #666;
    }
    
    .book-btn {
        background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
        color: white;
        padding: 14px 28px;
        text-decoration: none;
        border-radius: 10px;
        font-size: 15px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s;
        border: none;
        cursor: pointer;
        margin-top: 10px;
    }
    
    .book-btn:hover {
        background: linear-gradient(135deg, #2a5298 0%, #1e3c72 100%);
        transform: scale(1.05);
        box-shadow: 0 8px 25px rgba(30,60,114,0.3);
    }
    
    /* No Results */
    .no-results {
        background: white;
        padding: 60px 40px;
        border-radius: 15px;
        text-align: center;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    
    .no-results i {
        font-size: 80px;
        color: #ccc;
        margin-bottom: 20px;
    }
    
    .no-results h3 {
        font-size: 28px;
        color: #333;
        margin-bottom: 15px;
    }
    
    .no-results p {
        font-size: 16px;
        color: #666;
        margin-bottom: 30px;
        line-height: 1.8;
    }
    
    .suggestions {
        background: #f8f9fa;
        padding: 25px;
        border-radius: 10px;
        margin-top: 25px;
        text-align: left;
    }
    
    .suggestions h4 {
        font-size: 18px;
        margin-bottom: 15px;
        color: #1e3c72;
    }
    
    .suggestions ul {
        list-style: none;
        padding: 0;
    }
    
    .suggestions li {
        padding: 10px 0;
        display: flex;
        align-items: center;
        gap: 10px;
        color: #555;
    }
    
    .suggestions li i {
        color: #1e3c72;
        font-size: 16px;
    }
    
    /* Responsive */
    @media (max-width: 1024px) {
        .main-container {
            grid-template-columns: 1fr;
        }
        
        .sidebar {
            position: static;
        }
        
        .hotel-header {
            flex-direction: column;
        }
        
        .hotel-image-container {
            width: 100%;
            height: 250px;
        }
    }
    
    @media (max-width: 768px) {
        .room-card {
            flex-direction: column;
            align-items: stretch;
        }
        
        .room-pricing {
            align-items: flex-start;
        }
        
        .search-info {
            gap: 15px;
        }
        
        .info-item {
            flex: 1 1 calc(50% - 10px);
        }
    }
</style>
</head>
<body>
<!-- Navigation -->
<nav>
    <div class="nav-container">
        <a href="index.php" class="logo">
            <i class="fas fa-hotel"></i>
            Sheraton Hotels
        </a>
        <a href="index.php" class="back-btn">
            <i class="fas fa-arrow-left"></i> Back to Home
        </a>
    </div>
</nav>

<!-- Search Summary -->
<div class="search-summary">
    <div class="summary-content">
        <div class="search-info">
            <div class="info-item">
                <i class="fas fa-map-marker-alt"></i>
                <div>
                    <div class="info-label">Location</div>
                    <div class="info-value"><?php echo htmlspecialchars($location); ?></div>
                </div>
            </div>
            <?php if($checkin && $checkout): ?>
            <div class="info-item">
                <i class="fas fa-calendar-alt"></i>
                <div>
                    <div class="info-label">Check-in - Check-out</div>
                    <div class="info-value"><?php echo date('M d', strtotime($checkin)) . ' - ' . date('M d', strtotime($checkout)); ?></div>
                </div>
            </div>
            <div class="info-item">
                <i class="fas fa-moon"></i>
                <div>
                    <div class="info-label">Nights</div>
                    <div class="info-value"><?php echo $nights; ?> Night<?php echo $nights > 1 ? 's' : ''; ?></div>
                </div>
            </div>
            <?php endif; ?>
            <div class="info-item">
                <i class="fas fa-users"></i>
                <div>
                    <div class="info-label">Guests</div>
                    <div class="info-value"><?php echo htmlspecialchars($guests); ?> Guest<?php echo $guests > 1 ? 's' : ''; ?></div>
                </div>
            </div>
        </div>
        <button class="modify-search-btn" onclick="window.location.href='index.php'">
            <i class="fas fa-edit"></i> Modify Search
        </button>
    </div>
</div>

<!-- Main Container -->
<div class="main-container">
    <!-- Sidebar Filters -->
    <aside class="sidebar">
        <h3><i class="fas fa-filter"></i> Filters</h3>
        
        <div class="filter-section">
            <h4>Price Range (per night)</h4>
            <div class="price-range">
                <div class="price-inputs">
                    <input type="number" placeholder="Min" value="0">
                    <input type="number" placeholder="Max" value="500">
                </div>
            </div>
        </div>
        
        <div class="filter-section">
            <h4>Star Rating</h4>
            <div class="rating-filter">
                <div class="rating-option">
                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i> 5 Stars
                </div>
                <div class="rating-option">
                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i> 4+ Stars
                </div>
                <div class="rating-option">
                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i> 3+ Stars
                </div>
            </div>
        </div>
        
        <div class="filter-section">
            <h4>Amenities</h4>
            <div class="filter-option">
                <input type="checkbox" id="wifi">
                <label for="wifi">
                    <span><i class="fas fa-wifi"></i> Free WiFi</span>
                    <span>(<?php echo $hotelCount; ?>)</span>
                </label>
            </div>
            <div class="filter-option">
                <input type="checkbox" id="pool">
                <label for="pool">
                    <span><i class="fas fa-swimming-pool"></i> Swimming Pool</span>
                    <span>(<?php echo $hotelCount; ?>)</span>
                </label>
            </div>
            <div class="filter-option">
                <input type="checkbox" id="parking">
                <label for="parking">
                    <span><i class="fas fa-parking"></i> Free Parking</span>
                    <span>(<?php echo $hotelCount; ?>)</span>
                </label>
            </div>
            <div class="filter-option">
                <input type="checkbox" id="gym">
                <label for="gym">
                    <span><i class="fas fa-dumbbell"></i> Fitness Center</span>
                    <span>(<?php echo $hotelCount; ?>)</span>
                </label>
            </div>
            <div class="filter-option">
                <input type="checkbox" id="restaurant">
                <label for="restaurant">
                    <span><i class="fas fa-utensils"></i> Restaurant</span>
                    <span>(<?php echo $hotelCount; ?>)</span>
                </label>
            </div>
        </div>
    </aside>
    
    <!-- Results Section -->
    <div class="results-section">
        <div class="results-header">
            <div class="results-count">
                <i class="fas fa-building"></i> <?php echo $hotelCount; ?> propert<?php echo $hotelCount != 1 ? 'ies' : 'y'; ?> found
            </div>
            <div class="sort-options">
                <label>Sort by:</label>
                <select>
                    <option>Recommended</option>
                    <option>Price: Low to High</option>
                    <option>Price: High to Low</option>
                    <option>Rating: High to Low</option>
                    <option>Star Rating</option>
                </select>
            </div>
        </div>
        
        <?php
        if($hotelCount > 0) {
            while($hotel = mysqli_fetch_assoc($hotelResult)) {
                $hotel_id = $hotel['id'];
                $roomQuery = "SELECT * FROM rooms WHERE hotel_id = $hotel_id AND availability = 'yes'";
                $rooms = mysqli_query($conn, $roomQuery);
                $roomCount = mysqli_num_rows($rooms);
                
                echo "<div class='hotel-block'>";
                echo "<div class='hotel-header'>";
                echo "<div class='hotel-image-container'>";
                echo "<img src='{$hotel['image']}' alt='" . htmlspecialchars($hotel['name']) . "'>";
                echo "<div class='hotel-badge'><i class='fas fa-fire'></i> Popular Choice</div>";
                echo "<div class='hotel-rating'><i class='fas fa-star'></i> {$hotel['rating']}</div>";
                echo "</div>";
                
                echo "<div class='hotel-info'>";
                echo "<h3><i class='fas fa-hotel'></i> {$hotel['name']}</h3>";
                echo "<div class='hotel-location'><i class='fas fa-map-marker-alt'></i> {$hotel['location']}</div>";
                
                if(!empty($hotel['description'])) {
                    echo "<div class='hotel-description'>{$hotel['description']}</div>";
                }
                
                echo "<div class='hotel-amenities'>";
                echo "<span class='amenity-badge'><i class='fas fa-wifi'></i> Free WiFi</span>";
                echo "<span class='amenity-badge'><i class='fas fa-swimming-pool'></i> Pool</span>";
                echo "<span class='amenity-badge'><i class='fas fa-parking'></i> Parking</span>";
                echo "<span class='amenity-badge'><i class='fas fa-utensils'></i> Restaurant</span>";
                echo "<span class='amenity-badge'><i class='fas fa-dumbbell'></i> Gym</span>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
                
                echo "<div class='rooms-container'>";
                
                if($roomCount > 0) {
                    echo "<div class='rooms-header'><i class='fas fa-door-open'></i> Available Rooms ($roomCount room" . ($roomCount > 1 ? 's' : '') . ")</div>";
                    
                    while($room = mysqli_fetch_assoc($rooms)) {
                        $pricePerNight = $room['price_per_night'];
                        $totalPrice = $pricePerNight * $nights;
                        $originalPrice = $pricePerNight * 1.2; // Show 20% discount
                        
                        echo "<div class='room-card'>";
                        echo "<div class='room-details'>";
                        echo "<div class='room-type'><i class='fas fa-bed'></i> {$room['room_type']}</div>";
                        echo "<div class='room-features'>";
                        echo "<span class='room-feature'><i class='fas fa-user'></i> 2 Guests</span>";
                        echo "<span class='room-feature'><i class='fas fa-ruler-combined'></i> 25 m²</span>";
                        echo "<span class='room-feature'><i class='fas fa-wifi'></i> Free WiFi</span>";
                        echo "<span class='room-feature'><i class='fas fa-coffee'></i> Breakfast Included</span>";
                        echo "</div>";
                        echo "</div>";
                        
                        echo "<div class='room-pricing'>";
                        echo "<div class='price-original'>$" . number_format($originalPrice, 0) . "/night</div>";
                        echo "<div class='price-current'>$" . number_format($pricePerNight, 0) . "<span>/night</span></div>";
                        if($nights > 1) {
                            echo "<div class='price-total'>Total: $" . number_format($totalPrice, 0) . " for $nights night" . ($nights > 1 ? 's' : '') . "</div>";
                        }
                        echo "<a href='booking.php?room_id={$room['id']}&checkin=$checkin&checkout=$checkout&guests=$guests' class='book-btn'>";
                        echo "<i class='fas fa-check-circle'></i> Book Now";
                        echo "</a>";
                        echo "</div>";
                        echo "</div>";
                    }
                } else {
                    echo "<p style='text-align:center; padding: 20px; color: #999;'><i class='fas fa-info-circle'></i> No rooms currently available in this hotel.</p>";
                }
                
                echo "</div>";
                echo "</div>";
            }
        } else {
            echo "<div class='no-results'>";
            echo "<i class='fas fa-search'></i>";
            echo "<h3>No Hotels Found in " . htmlspecialchars($location) . "</h3>";
            echo "<p>We couldn't find any hotels matching your search criteria in this location. This might be because:</p>";
            echo "<div class='suggestions'>";
            echo "<h4><i class='fas fa-lightbulb'></i> Suggestions:</h4>";
            echo "<ul>";
            echo "<li><i class='fas fa-check'></i> Try searching for a nearby city or popular destination</li>";
            echo "<li><i class='fas fa-check'></i> Check your spelling - make sure the location name is correct</li>";
            echo "<li><i class='fas fa-check'></i> Try different dates - hotels might be fully booked</li>";
            echo "<li><i class='fas fa-check'></i> Browse our homepage for featured hotels in other locations</li>";
            echo "<li><i class='fas fa-check'></i> Contact our support team for personalized recommendations</li>";
            echo "</ul>";
            echo "</div>";
            echo "<button class='book-btn' onclick=\"window.location.href='index.php'\" style='margin-top: 25px;'>";
            echo "<i class='fas fa-search'></i> Search Again";
            echo "</button>";
            echo "</div>";
        }
        ?>
    </div>
</div>

<!-- Footer -->
<footer style="background: #1a1a2e; color: white; padding: 40px 20px 20px; margin-top: 60px;">
    <div style="max-width: 1400px; margin: 0 auto; text-align: center;">
        <div style="display: flex; justify-content: center; gap: 30px; margin-bottom: 25px; flex-wrap: wrap;">
            <a href="#" style="color: #ccc; text-decoration: none; transition: color 0.3s;">About Us</a>
            <a href="#" style="color: #ccc; text-decoration: none; transition: color 0.3s;">Contact</a>
            <a href="#" style="color: #ccc; text-decoration: none; transition: color 0.3s;">Terms of Service</a>
            <a href="#" style="color: #ccc; text-decoration: none; transition: color 0.3s;">Privacy Policy</a>
            <a href="#" style="color: #ccc; text-decoration: none; transition: color 0.3s;">Help Center</a>
        </div>
        <div style="border-top: 1px solid rgba(255,255,255,0.1); padding-top: 20px; color: #999;">
            <p>&copy; 2025 Sheraton Hotels. All rights reserved. | Designed with <i class="fas fa-heart" style="color: #ff6b6b;"></i> for travelers</p>
        </div>
    </div>
</footer>

<script>
    // Filter functionality
    document.querySelectorAll('.rating-option').forEach(option => {
        option.addEventListener('click', function() {
            document.querySelectorAll('.rating-option').forEach(o => o.classList.remove('active'));
            this.classList.add('active');
        });
    });
    
    // Smooth scroll to top
    window.addEventListener('scroll', function() {
        if (window.pageYOffset > 300) {
            if (!document.querySelector('.scroll-top-btn')) {
                const scrollBtn = document.createElement('button');
                scrollBtn.className = 'scroll-top-btn';
                scrollBtn.innerHTML = '<i class="fas fa-arrow-up"></i>';
                scrollBtn.style.cssText = `
                    position: fixed;
                    bottom: 30px;
                    right: 30px;
                    background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
                    color: white;
                    border: none;
                    width: 50px;
                    height: 50px;
                    border-radius: 50%;
                    cursor: pointer;
                    box-shadow: 0 4px 15px rgba(0,0,0,0.3);
                    transition: all 0.3s;
                    z-index: 999;
                    font-size: 18px;
                `;
                scrollBtn.onmouseover = () => scrollBtn.style.transform = 'scale(1.1)';
                scrollBtn.onmouseout = () => scrollBtn.style.transform = 'scale(1)';
                scrollBtn.onclick = () => window.scrollTo({ top: 0, behavior: 'smooth' });
                document.body.appendChild(scrollBtn);
            }
        } else {
            const btn = document.querySelector('.scroll-top-btn');
            if (btn) btn.remove();
        }
    });
</script>

</body>
</html>
