CREATE DATABASE IF NOT EXISTS library;
USE library;

-- Users Table (Only for authentication)
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    -- Store hashed passwords for security
    role ENUM('admin', 'staff', 'member') NOT NULL
);
-- Members Table (Contains user details)
CREATE TABLE IF NOT EXISTS members (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNIQUE,
    -- Links to users if they register for login
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    phone VARCHAR(20),
    
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE
    SET NULL
);
ALTER TABLE members ADD COLUMN photo VARCHAR(255) DEFAULT "default.png";

-- Books Table
CREATE TABLE IF NOT EXISTS books (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    author VARCHAR(100),
    publisher VARCHAR(100),
    isbn VARCHAR(20) UNIQUE,
    category VARCHAR(100),
    total_copies INT NOT NULL DEFAULT 1,
    available_copies INT NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
-- Borrow Records Table
CREATE TABLE IF NOT EXISTS borrow_records (
    id INT AUTO_INCREMENT PRIMARY KEY,
    member_id INT NOT NULL,
    -- Changed from user_id to member_id
    book_id INT NOT NULL,
    borrow_date DATE NOT NULL,
    return_date DATE NOT NULL,
    actual_return_date DATE,
    status ENUM('borrowed', 'returned', 'overdue') NOT NULL DEFAULT 'borrowed',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (member_id) REFERENCES members(id),
    FOREIGN KEY (book_id) REFERENCES books(id) 
);
-- Reservations Table
CREATE TABLE IF NOT EXISTS reservations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    member_id INT NOT NULL,

    book_id INT NOT NULL,
    reservation_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status ENUM('pending', 'approved', 'cancelled') NOT NULL DEFAULT 'pending',
    expires_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (book_id) REFERENCES books(id)
);
-- Categories Table (for normalized book categorization)
CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) UNIQUE NOT NULL
);
-- Modify the books table
ALTER TABLE books DROP COLUMN category,
    -- Remove the old 'category' column
ADD COLUMN category_id INT NOT NULL,
    -- Add the category_id column
ADD CONSTRAINT fk_category FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE;
-- Fines Table
CREATE TABLE IF NOT EXISTS fines (
    id INT AUTO_INCREMENT PRIMARY KEY,
    member_id INT NOT NULL,
    -- Changed from user_id to member_id
    borrow_id INT NOT NULL,
    amount DECIMAL(10, 2) NOT NULL,
    paid BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (member_id) REFERENCES members(id),
    FOREIGN KEY (borrow_id) REFERENCES borrow_records(id)
);
-- Notifications Table
CREATE TABLE IF NOT EXISTS notifications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    member_id INT NOT NULL,
    -- Changed from user_id to member_id
    message TEXT,
    read_status BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (member_id) REFERENCES members(id)
);
INSERT INTO users (username, password, role)
VALUES (
        'admin1',
        '$2y$10$sKtCoesFYsG7Rj4XNjnco.GTizmPCRImNgH3TwVSTogLdtOInd4CS',
        'admin'
    ),
    (
        'staff1',
        '$2y$10$pi1An0HWibbuEkIyk5iIAunRKiIiBnpQ0q9RDeYGmMguzWfjmz5fO',
        'staff'
    ),
    (
        'member',
        '$2y$10$Fh5M76AT3RfgBgSRxP1EOu2.kji0oZvX3PEnUXpeR4d.CnC33wsnC',
        'member'
    );
-- Payments Table
CREATE TABLE IF NOT EXISTS payments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    member_id INT NOT NULL,
    fine_id INT DEFAULT NULL,       -- Link to a fine if payment is for it
    book_id INT DEFAULT NULL,       -- Optional: track which book payment is related to
    amount DECIMAL(10,2) NOT NULL,
    payment_method VARCHAR(50),     -- 'cash', 'card', 'online', etc.
    payment_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    reference_number VARCHAR(100),  -- Optional for transaction tracking
    notes TEXT,

    FOREIGN KEY (member_id) REFERENCES members(id) ON DELETE CASCADE,
    FOREIGN KEY (fine_id) REFERENCES fines(id) ON DELETE SET NULL,
    FOREIGN KEY (book_id) REFERENCES books(id) ON DELETE SET NULL
);
-- Issues Table
CREATE TABLE IF NOT EXISTS issues (
    id INT AUTO_INCREMENT PRIMARY KEY,
    member_id INT NOT NULL,
    book_id INT DEFAULT NULL,       -- Optional: link issue to a specific book
    subject VARCHAR(255) NOT NULL,
    description TEXT,
    status ENUM('open', 'in_progress', 'resolved') DEFAULT 'open',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (member_id) REFERENCES members(id) ON DELETE CASCADE,
    FOREIGN KEY (book_id) REFERENCES books(id) ON DELETE SET NULL
);
-- Feedback Table
CREATE TABLE IF NOT EXISTS feedback (
    id INT AUTO_INCREMENT PRIMARY KEY,
    member_id INT NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (member_id) REFERENCES members(user_id) ON DELETE CASCADE
);
-- Create the members table if it does not exist
CREATE TABLE IF NOT EXISTS staff (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNIQUE,  -- Nullable by default; needed for ON DELETE SET NULL
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    phone VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    photo VARCHAR(255) DEFAULT 'default.png',
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);
CREATE TABLE verify (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    otp VARCHAR(10) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
CREATE TABLE IF NOT EXISTS admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNIQUE,  -- Nullable by default; needed for ON DELETE SET NULL
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    phone VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    photo VARCHAR(255) DEFAULT 'default.png',
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);

-- $sql = "
-- SELECT 
--     m.user_id,
--     m.name,
--     m.email,
--     m.phone,
--     m.created_at,
--     m.photo,

--     br.book_id AS borrowed_book_id,
--     bb.title AS borrowed_book_title,
--     br.borrow_date,
--     br.return_date,

--     r.book_id AS reserved_book_id,
--     rb.title AS reserved_book_title,
--     r.reservation_date,

--     f.amount,
--     f.paid

-- FROM member m

-- LEFT JOIN borrow_records br ON m.user_id = br.user_id
-- LEFT JOIN books bb ON br.book_id = bb.id

-- LEFT JOIN reservation r ON m.user_id = r.user_id
-- LEFT JOIN books rb ON r.book_id = rb.id

-- LEFT JOIN fines f ON m.user_id = f.user_id

-- ORDER BY m.user_id DESC
-- ";
