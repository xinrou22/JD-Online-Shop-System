<?php
session_start();
include("connect/config.php");

if (isset($_SESSION["cusID"])) {
    $user_id = $_SESSION["cusID"];

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $data = json_decode(file_get_contents('php://input'), true);
        if ($data['action'] == 'update_quantity') {
            $index = intval($data['index']);
            $quantity = intval($data['quantity']);

            $query = "UPDATE cart_items SET quantity = $quantity WHERE user_id = $user_id AND id = $index";
            mysqli_query($conn, $query);
        } elseif ($data['action'] == 'remove_item') {
            $index = intval($data['index']);

            $query = "DELETE FROM cart_items WHERE user_id = $user_id AND id = $index";
            mysqli_query($conn, $query);
        }

        // Fetch the updated cart items
        $cart_query = "SELECT cart_items.*, products.name, products.description, products.price, products.img 
                       FROM cart_items 
                       JOIN products ON cart_items.product_id = products.id 
                       WHERE user_id = '$user_id'";
        $cart_result = mysqli_query($conn, $cart_query);
        $cart_items = [];
        while ($row = mysqli_fetch_assoc($cart_result)) {
            $cart_items[] = $row;
        }
        $_SESSION["cart"] = $cart_items;

        // Send the updated cart items back as JSON response
        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'cart' => $cart_items]);
        exit;
    }
}
?>
