<?php
$secret = '8gBm/:&EnhH.1/q'; // eSewa test secret key
$transaction_uuid = uniqid(); // Unique transaction ID
$total_amount = 110;
$amount = 100;
$tax_amount = 10;
$product_code = 'EPAYTEST';

// Match order in signed_field_names exactly
$message = "total_amount=$total_amount,transaction_uuid=$transaction_uuid,product_code=$product_code";

// Generate and assign the signature
$signature = base64_encode(hash_hmac('sha256', $message, $secret, true));
?>


<form action="https://rc-epay.esewa.com.np/api/epay/main/v2/form" method="POST">
  <input type="hidden" name="amount" value="<?= $amount ?>">
  <input type="hidden" name="tax_amount" value="<?= $tax_amount ?>">
  <input type="hidden" name="total_amount" value="<?= $total_amount ?>">
  <input type="hidden" name="transaction_uuid" value="<?= $transaction_uuid ?>">
  <input type="hidden" name="product_code" value="<?= $product_code ?>">
  <input type="hidden" name="product_service_charge" value="0">
  <input type="hidden" name="product_delivery_charge" value="0">
  <input type="hidden" name="success_url" value="https://yourdomain.com/success.php">
  <input type="hidden" name="failure_url" value="https://yourdomain.com/failure.php">
  <input type="hidden" name="signed_field_names" value="total_amount,transaction_uuid,product_code">
  <input type="hidden" name="signature" value="<?= $signature ?>">
  <input type="submit" value="Pay with eSewa">
</form>
