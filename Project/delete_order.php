<?php
$conn = mysqli_connect('localhost', 'root', '', 'leelas_store') or die('Connection failed');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['orderId'])) {
    $orderId = filter_var($_POST['orderId'], FILTER_SANITIZE_NUMBER_INT);

    if (!empty($orderId)) {
        $conn->begin_transaction();

        try {
            $stmtItems = $conn->prepare("DELETE FROM order_items WHERE order_id = ?");
            $stmtItems->bind_param('i', $orderId);
            $stmtItems->execute();
            $stmtItems->close();

            $stmtOrder = $conn->prepare("DELETE FROM orders WHERE id = ?");
            $stmtOrder->bind_param('i', $orderId);
            $stmtOrder->execute();
            $stmtOrder->close();
            $conn->commit();

          
            header('Location: admin_orders.php'); 
            exit();
        } catch (Exception $e) {

            $conn->rollback();
            echo 'Failed to delete order: ' . $e->getMessage();
        }
    } else {
        echo 'Invalid order ID.';
    }
}

$conn->close();
?>
