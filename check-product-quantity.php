<?php
// Database connection
require_once '../db-connector.php';

// Retrieve the product details from the database
$query = "SELECT product_name, product_quantity FROM products WHERE product_quantity <= 0";
$result = mysqli_query($connection, $query);

while ($row = mysqli_fetch_assoc($result)) {
    $productName = $row['product_name'];

    // Send email to admin
    sendEmailToAdmin($productName);
}

// Function to send email to admin
function sendEmailToAdmin($productName) {
    $adminEmail = 'test@gmail.com';
    $subject = 'Low Stock Alert: ' . $productName;
    $message = 'The product "' . $productName . '" has reached or fallen below 0 quantity. Please take necessary action.';

    // Set the email headers
    $headers = 'From: your-email@example.com' . "\r\n" .
        'Reply-To: your-email@example.com' . "\r\n" .
        'X-Mailer: PHP/' . phpversion();

    // Send the email
    if (mail($adminEmail, $subject, $message, $headers)) {
        echo 'Email sent to admin.';
    } else {
        echo 'Failed to send email.';
    }
}
?>
