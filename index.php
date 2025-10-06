<?php include "db.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Sheraton Hotels - Luxury Accommodations Worldwide</title>
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
    
    /* Navigation Bar */
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
        font-size: 32px;
        font-weight: bold;
        color: #fff;
        display: flex;
        align-items: center;
        gap: 12px;
        letter-spacing: 1px;
    }
    
    .logo i {
        color: #ffd700;
        font-size: 36px;
    }
    
    .nav-links {
        display: flex;
        gap: 35px;
        align-items: center;
    }
    
    .nav-links a {
        color: #fff;
        text-decoration: none;
        font-size: 16px;
        font-weight: 500;
        transition: all 0.3s;
        padding: 8px 16px;
        border-radius: 6px;
    }
    
    .nav-links a:hover {
        background: rgba(255,255,255,0.15);
        transform: translateY(-2px);
    }
    
    .nav-links .login-btn {
        background: linear-gradient(135deg, #ffd700 0%, #ffed4e 100%);
        color: #1e3c72;
        padding: 10px 24px;
        border-radius: 25px;
        font-weight: 600;
    }
    
    .nav-links .login-btn:hover {
        background: linear-gradient(135deg, #ffed4e 0%, #ffd700 100%);
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(255,215,0,0.4);
    }
    
    /* Hero Section */
    .hero {
        background: linear-gradient(rgba(30,60,114,0.7), rgba(42,82,152,0.7)), 
                    url('https://images.unsplash.com/photo-1566073771259-6a8506099945?w=1600') center/cover;
        padding: 120px 20px 80px;
        text-align: center;
        color: white;
        position: relative;
        overflow: hidden;
    }
    
    .hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: radial-gradient(circle at 50% 50%, rgba(255,215,0,0.1) 0%, transparent 70%);
    }
    
    .hero-content {
        position: relative;
        z-index: 1;
        max-width: 900px;
        margin: 0 auto;
    }
    
    .hero h1 {
        font-size: 56px;
        margin-bottom: 20px;
        font-weight: 700;
        text-shadow: 2px 2px 10px rgba(0,0,0,0.3);
        animation: fadeInDown 1s;
    }
    
    .hero p {
        font-size: 22px;
        margin-bottom: 40px;
        opacity: 0.95;
        animation: fadeInUp 1s;
    }
    
    @keyframes fadeInDown {
        from { opacity: 0; transform: translateY(-30px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    /* Search Box */
    .search-container {
        max-width: 1100px;
        margin: -50px auto 60px;
        position: relative;
        z-index: 10;
        padding: 0 20px;
    }
    
    .search-box {
        background: white;
        padding: 40px;
        border-radius: 20px;
        box-shadow: 0 15px 50px rgba(0,0,0,0.2);
        display: grid;
        grid-template-columns: 1fr 1fr 1fr 1fr auto;
        gap: 20px;
        align-items: end;
        transition: transform 0.3s;
    }
    
    .search-box:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 60px rgba(0,0,0,0.25);
    }
    
    .input-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }
    
    .input-group label {
        font-size: 14px;
        font-weight: 600;
        color: #555;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .input-group label i {
        color: #1e3c72;
    }
    
    .search-box input, .search-box select {
        padding: 14px 16px;
        font-size: 16px;
        border-radius: 10px;
        border: 2px solid #e0e0e0;
        outline: none;
        transition: all 0.3s;
        font-family: inherit;
    }
    
    .search-box input:focus, .search-box select:focus {
        border-color: #1e3c72;
        box-shadow: 0 0 0 3px rgba(30,60,114,0.1);
    }
    
    .search-box button {
        background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
        color: white;
        cursor: pointer;
        border: none;
        padding: 16px 35px;
        font-size: 16px;
        font-weight: 600;
        border-radius: 10px;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        gap: 10px;
        justify-content: center;
    }
    
    .search-box button:hover {
        background: linear-gradient(135deg, #2a5298 0%, #1e3c72 100%);
        transform: scale(1.05);
        box-shadow: 0 8px 25px rgba(30,60,114,0.4);
    }
    
    /* Features Section */
    .features {
        max-width: 1400px;
        margin: 60px auto;
        padding: 0 20px;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 30px;
    }
    
    .feature-card {
        background: white;
        padding: 35px;
        border-radius: 15px;
        text-align: center;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        transition: all 0.3s;
        position: relative;
        overflow: hidden;
    }
    
    .feature-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(30,60,114,0.05), transparent);
        transition: left 0.5s;
    }
    
    .feature-card:hover::before {
        left: 100%;
    }
    
    .feature-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 40px rgba(0,0,0,0.15);
    }
    
    .feature-card i {
        font-size: 48px;
        color: #1e3c72;
        margin-bottom: 20px;
        display: block;
    }
    
    .feature-card h3 {
        font-size: 22px;
        margin-bottom: 12px;
        color: #1e3c72;
    }
    
    .feature-card p {
        color: #666;
        font-size: 15px;
    }
    
    /* Hotels Section */
    .section-header {
        text-align: center;
        margin: 80px 0 50px;
        padding: 0 20px;
    }
    
    .section-header h2 {
        font-size: 42px;
        color: #1e3c72;
        margin-bottom: 15px;
        position: relative;
        display: inline-block;
    }
    
    .section-header h2::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
        width: 80px;
        height: 4px;
        background: linear-gradient(90deg, #ffd700, #1e3c72);
        border-radius: 2px;
    }
    
    .section-header p {
        font-size: 18px;
        color: #666;
        max-width: 700px;
        margin: 20px auto 0;
    }
    
    .filter-bar {
        max-width: 1400px;
        margin: 0 auto 40px;
        padding: 0 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 20px;
    }
    
    .filter-options {
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
    }
    
    .filter-btn {
        padding: 10px 20px;
        background: white;
        border: 2px solid #e0e0e0;
        border-radius: 25px;
        cursor: pointer;
        transition: all 0.3s;
        font-size: 15px;
        font-weight: 500;
    }
    
    .filter-btn:hover, .filter-btn.active {
        background: #1e3c72;
        color: white;
        border-color: #1e3c72;
    }
    
    .view-toggle {
        display: flex;
        gap: 10px;
    }
    
    .view-toggle button {
        padding: 10px 15px;
        background: white;
        border: 2px solid #e0e0e0;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s;
        font-size: 18px;
    }
    
    .view-toggle button:hover, .view-toggle button.active {
        background: #1e3c72;
        color: white;
        border-color: #1e3c72;
    }
    
    .hotels-grid {
        max-width: 1400px;
        margin: 0 auto 80px;
        padding: 0 20px;
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
        gap: 35px;
    }
    
    .hotel-card {
        background: white;
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 10px 35px rgba(0,0,0,0.1);
        transition: all 0.4s;
        position: relative;
    }
    
    .hotel-card:hover {
        transform: translateY(-12px);
        box-shadow: 0 20px 50px rgba(0,0,0,0.2);
    }
    
    .hotel-image-container {
        position: relative;
        overflow: hidden;
        height: 250px;
    }
    
    .hotel-card img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s;
    }
    
    .hotel-card:hover img {
        transform: scale(1.1);
    }
    
    .hotel-badge {
        position: absolute;
        top: 15px;
        left: 15px;
        background: linear-gradient(135deg, #ffd700 0%, #ffed4e 100%);
        color: #1e3c72;
        padding: 8px 16px;
        border-radius: 25px;
        font-size: 13px;
        font-weight: 700;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }
    
    .hotel-rating {
        position: absolute;
        top: 15px;
        right: 15px;
        background: white;
        padding: 8px 14px;
        border-radius: 20px;
        display: flex;
        align-items: center;
        gap: 5px;
        font-weight: 700;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }
    
    .hotel-rating i {
        color: #ffd700;
    }
    
    .hotel-details {
        padding: 25px;
    }
    
    .hotel-details h3 {
        font-size: 24px;
        margin-bottom: 12px;
        color: #1e3c72;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .hotel-location {
        color: #666;
        font-size: 15px;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .hotel-amenities {
        display: flex;
        gap: 15px;
        margin-bottom: 20px;
        flex-wrap: wrap;
    }
    
    .amenity-tag {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 13px;
        color: #555;
        background: #f5f5f5;
        padding: 6px 12px;
        border-radius: 15px;
    }
    
    .amenity-tag i {
        color: #1e3c72;
    }
    
    .hotel-price-section {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 20px;
        border-top: 2px solid #f0f0f0;
    }
    
    .hotel-price {
        display: flex;
        flex-direction: column;
    }
    
    .price-label {
        font-size: 13px;
        color: #888;
    }
    
    .price-amount {
        font-size: 28px;
        font-weight: 700;
        color: #1e3c72;
    }
    
    .price-amount span {
        font-size: 16px;
        font-weight: 400;
        color: #888;
    }
    
    .view-btn {
        background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
        color: #fff;
        padding: 14px 28px;
        text-decoration: none;
        border-radius: 10px;
        font-size: 15px;
        font-weight: 600;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    
    .view-btn:hover {
        background: linear-gradient(135deg, #2a5298 0%, #1e3c72 100%);
        transform: scale(1.05);
        box-shadow: 0 6px 20px rgba(30,60,114,0.3);
    }
    
    /* Newsletter Section */
    .newsletter {
        background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
        padding: 80px 20px;
        text-align: center;
        color: white;
        margin-top: 60px;
    }
    
    .newsletter h2 {
        font-size: 38px;
        margin-bottom: 15px;
    }
    
    .newsletter p {
        font-size: 18px;
        margin-bottom: 35px;
        opacity: 0.9;
    }
    
    .newsletter-form {
        max-width: 600px;
        margin: 0 auto;
        display: flex;
        gap: 15px;
    }
    
    .newsletter-form input {
        flex: 1;
        padding: 16px 20px;
        border-radius: 10px;
        border: none;
        font-size: 16px;
        outline: none;
    }
    
    .newsletter-form button {
        background: linear-gradient(135deg, #ffd700 0%, #ffed4e 100%);
        color: #1e3c72;
        padding: 16px 40px;
        border: none;
        border-radius: 10px;
        font-size: 16px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s;
    }
    
    .newsletter-form button:hover {
        transform: scale(1.05);
        box-shadow: 0 8px 25px rgba(255,215,0,0.4);
    }
    
    /* Footer */
    footer {
        background: #1a1a2e;
        color: white;
        padding: 60px 20px 30px;
    }
    
    .footer-content {
        max-width: 1400px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 40px;
        margin-bottom: 40px;
    }
    
    .footer-section h3 {
        font-size: 20px;
        margin-bottom: 20px;
        color: #ffd700;
    }
    
    .footer-section ul {
        list-style: none;
    }
    
    .footer-section ul li {
        margin-bottom: 12px;
    }
    
    .footer-section ul li a {
        color: #ccc;
        text-decoration: none;
        transition: color 0.3s;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .footer-section ul li a:hover {
        color: #ffd700;
    }
    
    .social-links {
        display: flex;
        gap: 15px;
        margin-top: 20px;
    }
    
    .social-links a {
        width: 45px;
        height: 45px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 20px;
        transition: all 0.3s;
    }
    
    .social-links a:hover {
        background: #ffd700;
        color: #1e3c72;
        transform: translateY(-5px);
    }
    
    .footer-bottom {
        text-align: center;
        padding-top: 30px;
        border-top: 1px solid rgba(255,255,255,0.1);
        color: #999;
    }
    
    /* Responsive Design */
    @media (max-width: 1200px) {
        .search-box {
            grid-template-columns: 1fr 1fr;
        }
        
        .hotels-grid {
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        }
    }
    
    @media (max-width: 768px) {
        .nav-links {
            gap: 15px;
            font-size: 14px;
        }
        
        .hero h1 {
            font-size: 38px;
        }
        
        .search-box {
            grid-template-columns: 1fr;
            padding: 25px;
        }
        
        .features {
            grid-template-columns: 1fr;
        }
        
        .hotels-grid {
            grid-template-columns: 1fr;
        }
        
        .filter-bar {
            flex-direction: column;
            align-items: stretch;
        }
        
        .newsletter-form {
            flex-direction: column;
        }
    }
</style>
<script>
    function goToListing() {
        const location = document.getElementById("location").value;
        const checkin = document.getElementById("checkin").value;
        const checkout = document.getElementById("checkout").value;
        const guests = document.getElementById("guests").value;
        
        if(location && checkin && checkout && guests){
            window.location.href = `listings.php?location=${location}&checkin=${checkin}&checkout=${checkout}&guests=${guests}`;
        } else {
            alert("Please fill all fields before searching.");
        }
    }
    
    // Set minimum date for check-in (today)
    document.addEventListener('DOMContentLoaded', function() {
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('checkin').setAttribute('min', today);
        
        // Update checkout min date when checkin changes
        document.getElementById('checkin').addEventListener('change', function() {
            document.getElementById('checkout').setAttribute('min', this.value);
        });
    });
</script>
</head>
<body>
<!-- Navigation -->
<nav>
    <div class="nav-container">
        <div class="logo">
            <i class="fas fa-hotel"></i>
            Sheraton Hotels
        </div>
        <div class="nav-links">
            <a href="index.php"><i class="fas fa-home"></i> Home</a>
            <a href="listings.php"><i class="fas fa-building"></i> Hotels</a>
            <a href="#"><i class="fas fa-compass"></i> Destinations</a>
            <a href="#"><i class="fas fa-ticket-alt"></i> Deals</a>
            <a href="#" class="login-btn"><i class="fas fa-user"></i> Sign In</a>
        </div>
    </div>
</nav>

<!-- Hero Section -->
<div class="hero">
    <div class="hero-content">
        <h1>Discover Your Perfect Stay</h1>
        <p>Explore luxury hotels and resorts around the world with unbeatable prices</p>
    </div>
</div>

<!-- Search Section -->
<div class="search-container">
    <div class="search-box">
        <div class="input-group">
            <label><i class="fas fa-map-marker-alt"></i> Location</label>
            <input type="text" id="location" placeholder="Where are you going?">
        </div>
        <div class="input-group">
            <label><i class="fas fa-calendar-check"></i> Check-in</label>
            <input type="date" id="checkin">
        </div>
        <div class="input-group">
            <label><i class="fas fa-calendar-times"></i> Check-out</label>
            <input type="date" id="checkout">
        </div>
        <div class="input-group">
            <label><i class="fas fa-users"></i> Guests</label>
            <select id="guests">
                <option value="1">1 Guest</option>
                <option value="2" selected>2 Guests</option>
                <option value="3">3 Guests</option>
                <option value="4">4 Guests</option>
                <option value="5+">5+ Guests</option>
            </select>
        </div>
        <button onclick="goToListing()">
            <i class="fas fa-search"></i> Search
        </button>
    </div>
</div>

<!-- Features Section -->
<div class="features">
    <div class="feature-card">
        <i class="fas fa-shield-alt"></i>
        <h3>Best Price Guarantee</h3>
        <p>We guarantee you'll get the lowest prices for your bookings</p>
    </div>
    <div class="feature-card">
        <i class="fas fa-clock"></i>
        <h3>24/7 Support</h3>
        <p>Round-the-clock customer service for all your needs</p>
    </div>
    <div class="feature-card">
        <i class="fas fa-thumbs-up"></i>
        <h3>Easy Booking</h3>
        <p>Book your perfect hotel in just a few simple clicks</p>
    </div>
    <div class="feature-card">
        <i class="fas fa-star"></i>
        <h3>Verified Reviews</h3>
        <p>Real reviews from real travelers you can trust</p>
    </div>
</div>

<!-- Section Header -->
<div class="section-header">
    <h2>Featured Hotels</h2>
    <p>Handpicked luxury accommodations from around the world</p>
</div>

<!-- Filter Bar -->
<div class="filter-bar">
    <div class="filter-options">
        <button class="filter-btn active">All</button>
        <button class="filter-btn"><i class="fas fa-star"></i> Popular</button>
        <button class="filter-btn"><i class="fas fa-dollar-sign"></i> Budget</button>
        <button class="filter-btn"><i class="fas fa-gem"></i> Luxury</button>
    </div>
    <div class="view-toggle">
        <button class="active"><i class="fas fa-th-large"></i></button>
        <button><i class="fas fa-list"></i></button>
    </div>
</div>

<!-- Hotels Grid -->
<div class="hotels-grid">
    <?php
    $query = "SELECT * FROM hotels LIMIT 12";
    $result = mysqli_query($conn, $query);
    
    // Sample amenities for hotels
    $amenities_list = [
        ['wifi', 'pool', 'gym'],
        ['wifi', 'restaurant', 'spa'],
        ['wifi', 'parking', 'pool'],
        ['wifi', 'gym', 'restaurant']
    ];
    
    if(mysqli_num_rows($result) > 0) {
        $index = 0;
        while($row = mysqli_fetch_assoc($result)) {
            $hotelId = $row['id'];
            $amenities = $amenities_list[$index % 4];
            $index++;
            
            // Generate random price
            $price = rand(89, 399);
            
            echo "
            <div class='hotel-card'>
                <div class='hotel-image-container'>
                    <img src='{$row['image']}' alt='{$row['name']}'>
                    <div class='hotel-badge'><i class='fas fa-fire'></i> Popular</div>
                    <div class='hotel-rating'>
                        <i class='fas fa-star'></i> {$row['rating']}
                    </div>
                </div>
                <div class='hotel-details'>
                    <h3><i class='fas fa-hotel'></i> {$row['name']}</h3>
                    <div class='hotel-location'>
                        <i class='fas fa-map-marker-alt'></i> {$row['location']}
                    </div>
                    <div class='hotel-amenities'>
                        " . (in_array('wifi', $amenities) ? "<span class='amenity-tag'><i class='fas fa-wifi'></i> Free WiFi</span>" : "") . "
                        " . (in_array('pool', $amenities) ? "<span class='amenity-tag'><i class='fas fa-swimming-pool'></i> Pool</span>" : "") . "
                        " . (in_array('gym', $amenities) ? "<span class='amenity-tag'><i class='fas fa-dumbbell'></i> Gym</span>" : "") . "
                        " . (in_array('spa', $amenities) ? "<span class='amenity-tag'><i class='fas fa-spa'></i> Spa</span>" : "") . "
                        " . (in_array('restaurant', $amenities) ? "<span class='amenity-tag'><i class='fas fa-utensils'></i> Restaurant</span>" : "") . "
                        " . (in_array('parking', $amenities) ? "<span class='amenity-tag'><i class='fas fa-parking'></i> Parking</span>" : "") . "
                    </div>
                    <div class='hotel-price-section'>
                        <div class='hotel-price'>
                            <span class='price-label'>Starting from</span>
                            <div class='price-amount'>$$price<span>/night</span></div>
                        </div>
                        <a href='hotel.php?hotel_id=$hotelId' class='view-btn'>
                            View Details <i class='fas fa-arrow-right'></i>
                        </a>
                    </div>
                </div>
            </div>";
        }
    } else {
        echo "<p style='text-align:center; grid-column: 1/-1; font-size: 18px; color: #666;'>No hotels found in database.</p>";
    }
    ?>
</div>

<!-- Newsletter Section -->
<div class="newsletter">
    <h2><i class="fas fa-envelope"></i> Subscribe to Our Newsletter</h2>
    <p>Get exclusive deals and travel tips delivered straight to your inbox</p>
    <form class="newsletter-form" onsubmit="return false;">
        <input type="email" placeholder="Enter your email address" required>
        <button type="submit"><i class="fas fa-paper-plane"></i> Subscribe</button>
    </form>
</div>

<!-- Footer -->
<footer>
    <div class="footer-content">
        <div class="footer-section">
            <h3>About Sheraton</h3>
            <p style="color: #ccc; line-height: 1.8;">Your trusted partner in finding the perfect accommodation worldwide. We connect travelers with exceptional hotels and resorts.</p>
            <div class="social-links">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-linkedin-in"></i></a>
            </div>
        </div>
        <div class="footer-section">
            <h3>Quick Links</h3>
            <ul>
                <li><a href="#"><i class="fas fa-chevron-right"></i> About Us</a></li>
                <li><a href="#"><i class="fas fa-chevron-right"></i> Destinations</a></li>
                <li><a href="#"><i class="fas fa-chevron-right"></i> Special Offers</a></li>
                <li><a href="#"><i class="fas fa-chevron-right"></i> Career</a></li>
                <li><a href="#"><i class="fas fa-chevron-right"></i> Blog</a></li>
            </ul>
        </div>
        <div class="footer-section">
            <h3>Support</h3>
            <ul>
                <li><a href="#"><i class="fas fa-chevron-right"></i> Help Center</a></li>
                <li><a href="#"><i class="fas fa-chevron-right"></i> Contact Us</a></li>
                <li><a href="#"><i class="fas fa-chevron-right"></i> Privacy Policy</a></li>
                <li><a href="#"><i class="fas fa-chevron-right"></i> Terms of Service</a></li>
                <li><a href="#"><i class="fas fa-chevron-right"></i> FAQs</a></li>
            </ul>
        </div>
        <div class="footer-section">
            <h3>Contact Info</h3>
            <ul>
                <li style="color: #ccc; display: flex; align-items: start; gap: 10px; margin-bottom: 15px;">
                    <i class="fas fa-map-marker-alt" style="margin-top: 4px;"></i>
                    <span>123 Hotel Street, Tourism City, TC 12345</span>
                </li>
                <li style="color: #ccc; display: flex; align-items: center; gap: 10px; margin-bottom: 15px;">
                    <i class="fas fa-phone"></i>
                    <span>+1 (555) 123-4567</span>
                </li>
                <li style="color: #ccc; display: flex; align-items: center; gap: 10px;">
                    <i class="fas fa-envelope"></i>
                    <span>info@sheraton.com</span>
                </li>
            </ul>
        </div>
    </div>
    <div class="footer-bottom">
        <p>&copy; 2025 Sheraton Hotels. All rights reserved. | Designed with <i class="fas fa-heart" style="color: #ff6b6b;"></i> for travelers</p>
    </div>
</footer>

</body>
</html>
