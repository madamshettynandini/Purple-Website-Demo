<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'login_register');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['product_image'])) {
    // Sanitize and validate form data
    $product_name = $conn->real_escape_string(trim($_POST['product_name']));
    $product_price = floatval($_POST['product_price']); // Cast to float for price validation
    $product_image = $_FILES['product_image'];

    if (empty($product_name) || $product_price <= 0) {
        die("Invalid product name or price.");
    }

    // Validate and upload the image
    $target_dir = "uploads/";
    $image_extension = strtolower(pathinfo($product_image['name'], PATHINFO_EXTENSION));
    $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
    $image_name = time() . '_' . uniqid() . '.' . $image_extension;
    $target_file = $target_dir . $image_name;

    if (!in_array($image_extension, $allowed_extensions)) {
        die("Invalid image format. Allowed formats: jpg, jpeg, png, gif.");
    }

    if ($product_image['size'] > 2 * 1024 * 1024) { // 2MB limit
        die("File size exceeds 2MB.");
    }

    if (move_uploaded_file($product_image['tmp_name'], $target_file)) {
        // Use a prepared statement to insert data into the database
        $stmt = $conn->prepare("INSERT INTO products (name, price, image) VALUES (?, ?, ?)");
        $stmt->bind_param("sds", $product_name, $product_price, $image_name);

        if ($stmt->execute()) {
            echo "Product added successfully.";
        } else {
            echo "Database error: " . $conn->error;
        }

        $stmt->close();
    } else {
        echo "Error uploading image.";
    }
} else {
    echo "Invalid request.";
}

$conn->close();

// Redirect to admin dashboard
header("Location: admin_dashboard.php");
exit;
?>
`
