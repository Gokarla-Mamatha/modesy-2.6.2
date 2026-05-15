<?php if (!empty($initPaymentGateway) && !empty($paymentGateway) && !empty($checkout)): ?>

    <?php switch ($paymentGateway->name_key):
        case 'paypal':
            echo '<script src="https://www.paypal.com/sdk/js?client-id=' . esc($paymentGateway->public_key) . '&currency=' . esc($checkout->currency_code) . '" ' . csp_script_nonce() . '></script>';
            break;

        case 'paystack':
            echo '<script src="https://js.paystack.co/v1/inline.js" ' . csp_script_nonce() . '></script>';
            break;

        case 'razorpay':
            echo '<script src="https://checkout.razorpay.com/v1/checkout.js" ' . csp_script_nonce() . '></script>';
            break;

        case 'flutterwave':
            echo '<script src="https://checkout.flutterwave.com/v3.js" ' . csp_script_nonce() . '></script>';
            break;

        case 'midtrans':
            $snapJsUrl = ($paymentGateway->environment === 'production') ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js';
            echo '<script type="text/javascript" src="' . $snapJsUrl . '" data-client-key="' . escJs($paymentGateway->public_key) . '" ' . csp_script_nonce() . '></script>';
            break;

        case 'mercado_pago':
            echo '<script src="https://sdk.mercadopago.com/js/v2" ' . csp_script_nonce() . '></script>';
            break;

    endswitch; ?>
    <script src="<?= base_url('assets/js/payment.js'); ?>" <?= csp_script_nonce() ?>></script>

<?php endif; ?>