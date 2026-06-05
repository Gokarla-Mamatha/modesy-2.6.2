<!DOCTYPE html>
<html>
<head>
    <title>Stripe Payment</title>
</head>
<body>

    <h2>Stripe Payment Gateway</h2>

   <form action="<?= base_url('stripe-checkout'); ?>" method="post">
    <button type="submit">Pay Now</button>
</form>

</body>
</html>