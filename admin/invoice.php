<?php
include("inc/config.php"); // Include your DB config
require_once '../vendor/autoload.php'; // DomPDF autoload

use Dompdf\Dompdf;

if (!isset($_GET['payment_id'])) {
    die('Payment ID is required.');
}

$payment_id = $_GET['payment_id'];

// Fetch payment data
$statement = $pdo->prepare("SELECT * FROM tbl_payment WHERE payment_id = ?");
$statement->execute([$payment_id]);
$payment = $statement->fetch(PDO::FETCH_ASSOC);

if (!$payment) {
    die('Invalid payment ID.');
}

// Fetch order items
$statement = $pdo->prepare("SELECT * FROM tbl_order WHERE payment_id = ?");
$statement->execute([$payment_id]);
$orders = $statement->fetchAll(PDO::FETCH_ASSOC);

// Build invoice HTML
$html = '
<h1 style="text-align: center;">Invoice</h1>
<hr>
<h3>Customer Info</h3>
<b>Name:</b> ' . $payment['customer_name'] . '<br>
<b>Email:</b> ' . $payment['customer_email'] . '<br><br>

<h3>Payment Info</h3>
<b>Payment ID:</b> ' . $payment['payment_id'] . '<br>
<b>Date:</b> ' . $payment['payment_date'] . '<br>
<b>Method:</b> ' . $payment['payment_method'] . '<br>
<b>Status:</b> ' . $payment['payment_status'] . '<br>
<b>Paid Amount:</b> $' . $payment['paid_amount'] . '<br><br>

<h3>Order Details</h3>
<table width="100%" border="1" cellspacing="0" cellpadding="5">
    <tr>
        <th>Product</th>
        <th>Size</th>
        <th>Color</th>
        <th>Quantity</th>
        <th>Unit Price</th>
        <th>Total</th>
    </tr>';

foreach ($orders as $item) {
    $total = $item['quantity'] * $item['unit_price'];
    $html .= '
    <tr>
        <td>' . $item['product_name'] . '</td>
        <td>' . $item['size'] . '</td>
        <td>' . $item['color'] . '</td>
        <td>' . $item['quantity'] . '</td>
        <td>$' . number_format($item['unit_price'], 2) . '</td>
        <td>$' . number_format($total, 2) . '</td>
    </tr>';
}

$html .= '</table>
<br><br><p style="text-align: center;">Thank you for your purchase!</p>';

// Generate PDF
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

// Output to browser
$dompdf->stream('invoice_' . $payment_id . '.pdf', ['Attachment' => false]);
?>
