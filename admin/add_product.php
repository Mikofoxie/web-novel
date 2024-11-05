<?php
include './config/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];

    $sql = "INSERT INTO products (name) VALUES ('$name')";
    mysqli_query($conn, $sql);
    header('Location: index.php'); 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Product</title>
    <link rel="stylesheet" href="">
</head>
<body>
    <h1>Add New Product</h1>
    <form method="POST" action="">
        <label for="name">Product Name:</label>
        <input type="text" name="name" required>
        <input type="submit" value="Add Product">
    </form>
    <a href="index.php">Back to Product List</a>
</body>
</html>
