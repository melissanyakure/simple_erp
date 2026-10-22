<?php
function createSale($pdo, $customerId, $userId, $items) {
    try {
        $pdo->beginTransaction();

        // 1. Create the order
        $stmt = $pdo->prepare("INSERT INTO sales_orders (customer_id, user_id) VALUES (?, ?)");
        $stmt->execute([$customerId, $userId]);
        $orderId = $pdo->lastInsertId();

        $total = 0;

        // 2. Go through each product being sold
        foreach ($items as $item) {
            $p = $pdo->prepare("SELECT name, price, stock_qty FROM products WHERE id = ? FOR UPDATE");
            $p->execute([$item['product_id']]);
            $product = $p->fetch(PDO::FETCH_ASSOC);

            if (!$product) {
                throw new Exception("Product not found.");
            }

            if ($product['stock_qty'] < $item['quantity']) {
                throw new Exception("Not enough stock for " . $product['name'] . " (only " . $product['stock_qty'] . " left).");
            }

            // Save the item
            $pdo->prepare("INSERT INTO sales_order_items (order_id, product_id, quantity, unit_price) VALUES (?, ?, ?, ?)")
                ->execute([$orderId, $item['product_id'], $item['quantity'], $product['price']]);

            // Reduce the stock
            $pdo->prepare("UPDATE products SET stock_qty = stock_qty - ? WHERE id = ?")
                ->execute([$item['quantity'], $item['product_id']]);

            $total += $product['price'] * $item['quantity'];
        }

        // 3. Save the order total
        $pdo->prepare("UPDATE sales_orders SET total = ? WHERE id = ?")->execute([$total, $orderId]);

        $pdo->commit();
        return $orderId;

    } catch (Exception $e) {
        $pdo->rollBack();
        throw $e;
    }
}