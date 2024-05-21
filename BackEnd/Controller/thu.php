<?php
session_start();
if (isset($_SESSION['savedProducts'])) {
    $products = $_SESSION['savedProducts'];
    echo "Saved Products: ";
    print_r($products);
} else {
    echo "No products found!";
}
?>
