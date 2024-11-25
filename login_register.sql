-- Admins Table
CREATE TABLE `admins` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `full_name` VARCHAR(128) NOT NULL,
  `email` VARCHAR(255) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL, -- Updated to store hashed passwords
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `admins` (`id`, `full_name`, `email`, `password`) VALUES
(1, 'Admin User', 'admin@example.com', '$2y$10$e2j0aWjzQPLQ1UQj0PMZdu1E8X5kVndN5YjKCePxH.K8M3SxZf0YS');

-- Products Table
CREATE TABLE `products` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `price` DECIMAL(10,2) NOT NULL,
  `image` VARCHAR(255) NOT NULL, -- Increased varchar length to 255 for longer file paths
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Users Table
CREATE TABLE `users` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `full_name` VARCHAR(128) NOT NULL,
  `email` VARCHAR(255) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL, -- Passwords are hashed
  `email_verified` TINYINT(1) NOT NULL DEFAULT 0, -- Flag for email verification
  `phone` VARCHAR(15) DEFAULT NULL, -- Optional phone number for verification
  `phone_verified` TINYINT(1) NOT NULL DEFAULT 0, -- Flag for phone verification
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `users` (`id`, `full_name`, `email`, `password`, `email_verified`, `phone_verified`) VALUES
(1, 'Aktar', 'aktar@gmail.com', '$2y$10$Jmf9Xk2y8m.fo3c/ZgKmzOrdIRkU05KSGLI0picKLEtr68ll7hjB.', 0, 0);

-- Addresses Table
CREATE TABLE `addresses` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) NOT NULL,
  `address_line1` VARCHAR(255) NOT NULL,
  `address_line2` VARCHAR(255) DEFAULT NULL,
  `city` VARCHAR(100) NOT NULL,
  `state` VARCHAR(100) NOT NULL,
  `postal_code` VARCHAR(20) NOT NULL,
  `country` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Example of inserting address data for a user
INSERT INTO `addresses` (`user_id`, `address_line1`, `address_line2`, `city`, `state`, `postal_code`, `country`) VALUES
(1, '123 Main St', 'Apt 4B', 'New York', 'NY', '10001', 'USA');
