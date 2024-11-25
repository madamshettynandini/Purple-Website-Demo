<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'login_register');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch products
$sql = "SELECT * FROM products";
$result = $conn->query($sql);

// Error message variable
$message = '';

// Handle product addition
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['product_image'])) {
    $productName = htmlspecialchars($_POST['product_name']);
    $productPrice = floatval($_POST['product_price']);
    $productImage = $_FILES['product_image'];

    // Validate product price
    if ($productPrice <= 0) {
        $message = "Please enter a valid price.";
    } else {
        // Handle image upload
        $imageName = time() . '_' . basename($productImage['name']);
        $targetDir = 'uploads/';
        $targetFile = $targetDir . $imageName;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Validate image file type (only allow images)
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($imageFileType, $allowedTypes)) {
            $message = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        } else if ($productImage['size'] > 2000000) { // Check for file size limit (2MB)
            $message = "Sorry, your file is too large.";
        } else {
            if (move_uploaded_file($productImage['tmp_name'], $targetFile)) {
                // Insert new product into the database
                $stmt = $conn->prepare("INSERT INTO products (name, price, image) VALUES (?, ?, ?)");
                $stmt->bind_param("sss", $productName, $productPrice, $imageName);
                if ($stmt->execute()) {
                    $message = "Product added successfully!";
                } else {
                    $message = "Error adding product.";
                }
                $stmt->close();
            } else {
                $message = "Sorry, there was an error uploading your file.";
            }
        }
    }
}

// Handle product deletion
if (isset($_POST['delete_product'])) {
    $productId = $_POST['product_id'];
    $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
    $stmt->bind_param("i", $productId);
    if ($stmt->execute()) {
        $message = "Product deleted successfully!";
    } else {
        $message = "Error deleting product.";
    }
    $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Basic Reset and Additional Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            display: flex;
            transition: margin-left 0.3s ease;
        }

        .topbar {
            position: fixed;
            top: 0;
            width: 100%;
            height: 60px;
            background-color: #333;
            color: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
            z-index: 1000;
        }

        .topbar h1 {
            font-size: 20px;
            margin-left: 10px;
        }

        .toggle-btn {
            background: none;
            border: none;
            cursor: pointer;
            padding: 10px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: center;
            width: 50px;
            height: 40px;
        }

        .bar {
            display: block;
            width: 100%;
            height: 4px;
            background-color: white;
            border-radius: 2px;
            transition: 0.3s;
        }

        /* Sidebar Styling */
        .sidebar {
            width: 200px;
            height: 100vh;
            background-color: #2196f3cc;
            padding-top: 80px;
            position: fixed;
            left: -200px;
            transition: left 0.3s ease;
        }

        .sidebar.open {
            left: 0;
        }

        .sidebar a {
            display: block;
            color: white;
            padding: 15px;
            text-decoration: none;
            font-size: 16px;
        }

        .sidebar a:hover {
            back
