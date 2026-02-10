<!DOCTYPE html>
<html>
<head>
    <title>Your Myitronline Order Confirmation</title>
</head>
<body>
    <h1>Your Myitronline Order Confirmation</h1>
    <p>Dear {{ $order['first_name'] }} {{ $order['last_name'] }},</p>
    <p>Thank you for your order. Here are your order details:</p>
    <ul>
        <li>Order ID: {{ $order['order_id'] }}</li>
        <li>First Name: {{ $order['first_name'] }}</li>
        <li>Last Name: {{ $order['last_name'] }}</li>
        <li>Email: {{ $order['email'] }}</li>
        <li>father_name: {{ $order['father_name'] }}</li>
        <li>DOB: {{ $order['dob'] }}</li>
        <li>Pan Number: {{ $order['pan_number'] }}</li>
        <li>Full Address: {{ $order['full_address'] }}</li>
        <li>Account Number: {{ $order['account_number'] }}</li>
        <li>IFSC Code: {{ $order['ifsc_code'] }}</li>
        <li>Bank Name: {{ $order['bank_name'] }}</li>
        <li>Account Type: {{ $order['account_type'] }}</li>
        <li>pdfPassword: {{ $order['pdfPassword'] }}</li>
    </ul>
    <p>Is this correct?</p>
    <p>
        <a href="#">👍</a> <a href="#">👎</a>
    </p>
    <p>Please find your order confirmation attached.</p>
</body>
</html>
