<?php
// 获取用户提交的信息
$customer_name = $_POST['customer_name'] ?? '';
$customer_address = $_POST['customer_address'] ?? '';
$customer_zip = $_POST['customer_zip'] ?? '';
$payment_method = $_POST['payment_method'] ?? '';

// 存储用户购买信息到文件中
if (!empty($customer_name)) {
  $order_info = "{$customer_name} has bought {$_POST['Web technology']} books and paid {$_POST['total_cost']} by {$payment_method}.\n";
  file_put_contents('orders.txt', $order_info, FILE_APPEND);
}

// 计算总花费
$total_cost = 0;
$order_table = '<table><tr><th>Book</th><th>Publisher</th><th>Price</th><th>Quantity</th><th>Total Cost</th></tr>';
foreach ($_POST as $key => $value) {
  if (strpos($key, 'quantity_') !== false && $value > 0) {
    $book_key = str_replace('quantity_', '', $key);
    $book_name = $_POST[$book_key];
    $book_publisher = $_POST["{$book_key}_publisher"];
    $book_price = $_POST["{$book_key}_price"];
    $book_quantity = $value;
    $book_total_cost = $book_price * $book_quantity;
    $total_cost += $book_total_cost;
    $order_table .= "<tr><td>{$book_name}</td><td>{$book_publisher}</td><td>{$book_price}</td><td>{$book_quantity}</td><td>{$book_total_cost}</td></tr>";
  }
}
$order_table .= '</table>';

// 显示用户购买信息
printf("<p>%s has bought %d books.</p>", $customer_name, count($_POST) - 4);
printf("<p>%s paid %.2f.</p>", $customer_name, $total_cost);
printf("<p>Paid by %s.</p>", $payment_method);
echo $order_table;
?>
