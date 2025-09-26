  SET NAMES utf8mb4;
  SET FOREIGN_KEY_CHECKS=0;

  -- Drop tables (reverse dependency order)
  DROP TABLE IF EXISTS tour_guide_map;
  DROP TABLE IF EXISTS tour_guides;
  DROP TABLE IF EXISTS tour_reviews;
  DROP TABLE IF EXISTS tour_drops;
  DROP TABLE IF EXISTS tour_pickups;

  DROP TABLE IF EXISTS order_items;
  DROP TABLE IF EXISTS orders;
  DROP TABLE IF EXISTS cart_items;
  DROP TABLE IF EXISTS carts;

  DROP TABLE IF EXISTS flight_details;
  DROP TABLE IF EXISTS flights;

  DROP TABLE IF EXISTS tour_inclusions;
  DROP TABLE IF EXISTS tour_itineraries;
  DROP TABLE IF EXISTS tour_images;
  DROP TABLE IF EXISTS tours;

  DROP TABLE IF EXISTS room_images;
  DROP TABLE IF EXISTS hotel_rooms;
  DROP TABLE IF EXISTS room_types;
  DROP TABLE IF EXISTS hotel_amenities;
  DROP TABLE IF EXISTS amenities;
  DROP TABLE IF EXISTS hotel_images;
  DROP TABLE IF EXISTS hotels;

  DROP TABLE IF EXISTS location_images;
  DROP TABLE IF EXISTS locations;

  DROP TABLE IF EXISTS service_fees;
  DROP TABLE IF EXISTS users;
  DROP TABLE IF EXISTS blogs;
  DROP TABLE IF EXISTS faqs;

  SET FOREIGN_KEY_CHECKS=1;

  -- =========================
  -- 1. CORE TABLES
  -- =========================
  CREATE TABLE locations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    slug VARCHAR(120) NOT NULL UNIQUE,
    name VARCHAR(120) NOT NULL UNIQUE,
    country VARCHAR(120) DEFAULT 'India',
    description TEXT,
    latitude DECIMAL(9,6),
    longitude DECIMAL(9,6),
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    INDEX idx_locations_name (name),
    INDEX idx_locations_slug (slug)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

  INSERT INTO locations (name, slug, country, description, latitude, longitude, created_at, updated_at)
  VALUES
  ('Goa', 'goa', 'India', 'Famous beach destination in India.', 15.2993, 74.1240, NOW(), NOW()),
  ('Mumbai', 'mumbai', 'India', 'Financial capital of India.', 19.0760, 72.8777, NOW(), NOW()),
  ('Delhi', 'delhi', 'India', 'Capital city of India.', 28.6139, 77.2090, NOW(), NOW()),
  ('Bangalore', 'bangalore', 'India', 'IT hub of India.', 12.9716, 77.5946, NOW(), NOW()),
  ('Chennai', 'chennai', 'India', 'Cultural hub in South India.', 13.0827, 80.2707, NOW(), NOW()),
  ('Kolkata', 'kolkata', 'India', 'City of joy in East India.', 22.5726, 88.3639, NOW(), NOW()),
  ('Hyderabad', 'hyderabad', 'India', 'Famous for its technology and cuisine.', 17.3850, 78.4867, NOW(), NOW()),
  ('Pune', 'pune', 'India', 'Educational and IT center in Maharashtra.', 18.5204, 73.8567, NOW(), NOW()),
  ('Jaipur', 'jaipur', 'India', 'The Pink City of India.', 26.9124, 75.7873, NOW(), NOW()),
  ('Ahmedabad', 'ahmedabad', 'India', 'Largest city in Gujarat.', 23.0225, 72.5714, NOW(), NOW()),
  ('Lucknow', 'lucknow', 'India', 'City of Nawabs in Uttar Pradesh.', 26.8467, 80.9462, NOW(), NOW()),
  ('Varanasi', 'varanasi', 'India', 'Holy city on the banks of Ganges.', 25.3176, 82.9739, NOW(), NOW()),
  ('Kochi', 'kochi', 'India', 'Major port city in Kerala.', 9.9312, 76.2673, NOW(), NOW()),
  ('Mysore', 'mysore', 'India', 'Famous for palaces and silk.', 12.2958, 76.6394, NOW(), NOW()),
  ('Udaipur', 'udaipur', 'India', 'City of Lakes in Rajasthan.', 24.5854, 73.7125, NOW(), NOW());
  ('Dehradun', 'dehradun', 'India', 'Nestled in the Doon Valley in Uttarakhand, Dehradun is a scenic city surrounded by the Himalayas and Shivalik ranges, known for its pleasant weather, lush greenery, and gateways to hill stations like Mussoorie and pilgrimages like Haridwar and Rishikesh.', 30.3165, 78.0322, NOW(), NOW()),

  CREATE TABLE location_images (
    id INT AUTO_INCREMENT PRIMARY KEY,
    location_id INT NOT NULL,
    url VARCHAR(255) NOT NULL,
    alt VARCHAR(150),
    is_primary TINYINT(1) DEFAULT 0,
    FOREIGN KEY (location_id) REFERENCES locations(id) ON DELETE CASCADE
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

  CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

  CREATE TABLE service_fees (
    id INT AUTO_INCREMENT PRIMARY KEY,
    service ENUM('hotel','tour','flight') NOT NULL UNIQUE,
    percent DECIMAL(5,2) NOT NULL DEFAULT 10.00,
    fixed DECIMAL(10,2) NOT NULL DEFAULT 99.00
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

  -- =========================
  -- 2. HOTELS
  -- =========================
  CREATE TABLE hotels (
    id INT AUTO_INCREMENT PRIMARY KEY,
    location_id INT NOT NULL,
    slug VARCHAR(150) NOT NULL UNIQUE,
    name VARCHAR(150) NOT NULL,
    description TEXT,
    property_highlight Text, -- json format highlight heading will be key and on value will be description
    star_rating TINYINT UNSIGNED DEFAULT 0,
    avg_rating DECIMAL(3,2) DEFAULT 0.00,
    address VARCHAR(255),
    latitude DECIMAL(9,6),
    longitude DECIMAL(9,6),
    official_website VARCHAR(255),
    contact_name VARCHAR(100),
    contact_email VARCHAR(100),
    contact_phone VARCHAR(20),
    checkin_time VARCHAR(20) DEFAULT '14:00',
    checkout_time VARCHAR(20) DEFAULT '11:00',
    policies text, 
    is_pet_allowed bool DEFAULT 0,
    is_breakfast_included bool DEFAULT 0,
    is_parking_included bool DEFAULT 0,
    is_wifi_included bool DEFAULT 0,
    check_in_instruction TEXT, -- json format the heading will be key and on value will be description
    cancelation_policy TEXT, -- json format the heading will be key and on value will be description
    is_parking_lot_included bool DEFAULT 0,
    is_airport_pickup_included bool DEFAULT 0,
    is_airport_drop_included bool DEFAULT 0,
    nearest_landmarks VARCHAR(255),
    is_featured bool DEFAULT 0,
    scrapped_page_url varchar(255),
    faqs TEXT,  -- will be json on key will be question and on value will be answer
    amenities TEXT,  -- json on key will be amenity and on value will be font awesome 5 icon class 
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (location_id) REFERENCES locations(id) ON DELETE CASCADE
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

  CREATE TABLE hotel_images (
    id INT AUTO_INCREMENT PRIMARY KEY,
    hotel_id INT NOT NULL,
    url VARCHAR(255) NOT NULL,
    alt VARCHAR(150),
    is_primary TINYINT(1) DEFAULT 0,
    FOREIGN KEY (hotel_id) REFERENCES hotels(id) ON DELETE CASCADE
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

  CREATE TABLE hotel_rooms (
    id INT AUTO_INCREMENT PRIMARY KEY,
    hotel_id INT NOT NULL,
    room_type varchar(100) NOT NULL,
    name VARCHAR(150) NOT NULL,
    description TEXT,
    price_per_night DECIMAL(10,2) NOT NULL,
    max_adults TINYINT UNSIGNED DEFAULT 2,
    max_children TINYINT UNSIGNED DEFAULT 1,
    refundable TINYINT(1) DEFAULT 1,
    breakfast_included TINYINT(1) DEFAULT 0,
    available_inventory INT UNSIGNED DEFAULT 10,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (hotel_id) REFERENCES hotels(id) ON DELETE CASCADE,
    FOREIGN KEY (room_type_id) REFERENCES room_types(id) ON DELETE RESTRICT
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

  CREATE TABLE room_images (
    id INT AUTO_INCREMENT PRIMARY KEY,
    room_id INT NOT NULL,
    url VARCHAR(255) NOT NULL,
    alt VARCHAR(150),
    is_primary TINYINT(1) DEFAULT 0,
    FOREIGN KEY (room_id) REFERENCES hotel_rooms(id) ON DELETE CASCADE
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

  -- =========================
  -- 3. TOURS
  -- =========================
  CREATE TABLE tours (
    id INT AUTO_INCREMENT PRIMARY KEY,
    location_id INT NOT NULL,
    name VARCHAR(150) NOT NULL,
    full_description TEXT,
    tour_itinerary TEXT, --json format the heading will be key and on value will be description and while showing we will put increment with day 1 so every new key we will show as new day
    Inclusions TEXT, -- json format the heading will be the heading and on value will be font awesome 5 icon classes
    Exclusions TEXT, - json format the heading will be the heading and on value will be font awesome 5 icon classes
    highlights TEXT, --json format the heading will be key and on value will be description
    Important information TEXT, --json format the heading will be key and on value will be description
    tour_guide TEXT, --json format the heading will be key and on value will be description
    meeting_point TEXT, --json format the heading will be key and on value will be description
    duration_days INT NOT NULL,
    Not suitable for TEXT --json format the heading will be key and on value will be description
    duration_nights INT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    rating DECIMAL(2,1) DEFAULT 0.0,
    main_image VARCHAR(255),
    scrapped_url varchar(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (location_id) REFERENCES locations(id) ON DELETE CASCADE
  );

  CREATE TABLE tour_images (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tour_id INT NOT NULL,
    url VARCHAR(255) NOT NULL,
    FOREIGN KEY (tour_id) REFERENCES tours(id) ON DELETE CASCADE
  );

  CREATE TABLE tour_reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tour_id INT NOT NULL,
    user_id INT NOT NULL,
    rating DECIMAL(2,1) NOT NULL,
    review TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (tour_id) REFERENCES tours(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


  -- =========================
  -- 4. FLIGHTS
  -- =========================
  CREATE TABLE flights (
    id INT AUTO_INCREMENT PRIMARY KEY,
    source_location_id INT NOT NULL,
    destination_location_id INT NOT NULL,
    airline VARCHAR(100) NOT NULL,
    flight_number VARCHAR(50) NOT NULL,
    departure_time DATETIME NOT NULL,
    arrival_time DATETIME NOT NULL,
    duration VARCHAR(50),
    price DECIMAL(10,2) NOT NULL,
    stops INT DEFAULT 0,
    rating DECIMAL(2,1) DEFAULT 0.0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (source_location_id) REFERENCES locations(id) ON DELETE CASCADE,
    FOREIGN KEY (destination_location_id) REFERENCES locations(id) ON DELETE CASCADE
  );

  CREATE TABLE flight_details (
    id INT AUTO_INCREMENT PRIMARY KEY,
    flight_id INT NOT NULL,
    baggage_policy VARCHAR(255),
    cabin_class ENUM('Economy','Premium Economy','Business','First') DEFAULT 'Economy',
    fare_rules TEXT,
    FOREIGN KEY (flight_id) REFERENCES flights(id) ON DELETE CASCADE
  );

  -- =========================
  -- 5. CART & ORDERS
  -- =========================
  CREATE TABLE carts (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    session_id VARCHAR(120) NOT NULL,
    user_id BIGINT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY uniq_cart_session (session_id)
  );

  CREATE TABLE cart_items (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    cart_id BIGINT NOT NULL,
    item_type ENUM('hotel_room','tour','flight') NOT NULL,
    item_id BIGINT NOT NULL,
    name VARCHAR(200) NOT NULL,
    meta JSON,
    qty INT UNSIGNED DEFAULT 1,
    unit_price DECIMAL(10,2) NOT NULL,
    total_price DECIMAL(10,2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (cart_id) REFERENCES carts(id) ON DELETE CASCADE
  );

  CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    total DECIMAL(10,2),
    discount DECIMAL(10,2),
    final_total DECIMAL(10,2),
    coupon VARCHAR(50),
    payment_method VARCHAR(20),
    status VARCHAR(20) DEFAULT 'pending',
    created_at DATETIME,
    updated_at DATETIME
  );

  CREATE TABLE order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    item_type VARCHAR(50),
    item_id INT,
    name VARCHAR(255),
    meta JSON,
    qty INT,
    unit_price DECIMAL(10,2),
    total_price DECIMAL(10,2),
    created_at DATETIME,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE
  );

  -- =========================
  -- 6. CONTENT
  -- =========================
  CREATE TABLE blogs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    author VARCHAR(255) NOT NULL,
    image_url VARCHAR(255),
    published_at DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
  );

  CREATE TABLE faqs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    question VARCHAR(255) NOT NULL,
    answer TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
  );