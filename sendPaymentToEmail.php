<?php
session_start();
include_once "includes/db.php";

// Check for POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check for data in POST request
    if (isset($_POST['phone']) && isset($_POST['name']) && isset($_POST['email']) && isset($_POST['address']) && isset($_POST['city']) && isset($_POST['totalAmount']) && isset($_POST['products'])) {
        // Get order information
        $phone = $_POST['phone'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $address = $_POST['address'];
        $city = $_POST['city'];
        $totalAmount = $_POST['totalAmount'];
        $products = json_decode($_POST['products'], true);

        // Validate data (you can add more checks as needed)
        if (empty($phone) || empty($name) || empty($email) || empty($address) || empty($city) || empty($totalAmount) || empty($products)) {
            echo "Please fill in all fields.";
            exit();
        }

        // Insert order data into "paypal_orders" table
        $sql_insert_order = "INSERT INTO paypal_orders (phone, name, email, address, city, total_amount) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt_order = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt_order, $sql_insert_order)) {
            echo "Error preparing order insert statement: " . mysqli_error($conn);
            exit();
        } else {
            mysqli_stmt_bind_param($stmt_order, "sssssd", $phone, $name, $email, $address, $city, $totalAmount);
            mysqli_stmt_execute($stmt_order);
            $order_id = mysqli_insert_id($conn); // Get the last inserted order ID
            echo "Order ID: " . $order_id . "<br>";
        
            // Insert product data into "paypal_order_products" table
            foreach ($products as $product) {
                $product_name = $product['name'];
                $year = $product['year'];
                $quantity = $product['quantity'];
        
                $sql_insert_order_product = "INSERT INTO paypal_order_products (order_id, product_name, year, quantity) VALUES (?, ?, ?, ?)";
                $stmt_order_product = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt_order_product, $sql_insert_order_product)) {
                    echo "Error preparing product insert statement for order: " . mysqli_error($conn);
                    exit();
                } else {
                    mysqli_stmt_bind_param($stmt_order_product, "iiss", $order_id, $product_name, $year, $quantity);
                    mysqli_stmt_execute($stmt_order_product);
                }
            }
        
            echo "Order placed successfully!";
            
            // Send email confirmation
            $to = "sdimitrov482@gmail.com";
            $subject = "New Order Placed";
            $message = "A new order has been placed.\n\nOrder ID: " . $order_id . "\nName: " . $name . "\nEmail: " . $email . "\nPhone: " . $phone . "\nAddress: " . $address . "\nCity: " . $city . "\nTotal Amount: " . $totalAmount;
            $headers = "From: your_email@example.com"; // Change this to your email address
            mail($to, $subject, $message, $headers);
            
            exit();
        }
    } else {
        echo "Missing POST data.";
    }
} 

// If not a POST request, redirect to index.php
header("Location: ../index.php");
exit();
?>
