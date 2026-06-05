<!DOCTYPE html>
<html>
<head>
    <title>Stripe Bank Account Verification</title>
    <style <?= csp_style_nonce() ?>>
        body { font-family: sans-serif; max-width: 560px; margin: 40px auto; padding: 0 16px; }
        h2 { margin-bottom: 4px; }
        p.hint { color: #666; margin-top: 0; font-size: 14px; }
        label { display: block; margin-top: 14px; font-weight: 600; font-size: 14px; }
        input { width: 100%; padding: 8px; box-sizing: border-box; font-size: 14px; }
        .row { display: flex; gap: 12px; }
        .row > div { flex: 1; }
        button { margin-top: 18px; padding: 10px 18px; font-size: 14px; cursor: pointer; }
        pre { background: #f4f4f4; padding: 12px; overflow: auto; font-size: 12px; }
        .ok { color: #0a7a2f; }
        .err { color: #b00020; }
    </style>
</head>
<body>

    <h2>Verify Customer Bank Account</h2>
    <p class="hint">
        Calls Stripe <code>POST /v1/customers/{customer}/sources/{bank_account}/verify</code>
        with the two micro-deposit amounts (in cents).
    </p>

    <form id="verifyForm">
        <?= csrf_field() ?>

        <label for="customer_id">Customer ID</label>
        <input type="text" id="customer_id" name="customer_id" placeholder="cus_..." required>

        <label for="bank_account_id">Bank Account ID</label>
        <input type="text" id="bank_account_id" name="bank_account_id" placeholder="ba_..." required>

        <div class="row">
            <div>
                <label for="amount_1">Amount 1 (cents)</label>
                <input type="number" id="amount_1" name="amount_1" min="1" placeholder="32" required>
            </div>
            <div>
                <label for="amount_2">Amount 2 (cents)</label>
                <input type="number" id="amount_2" name="amount_2" min="1" placeholder="45" required>
            </div>
        </div>

        <button type="submit">Verify</button>
    </form>

    <h3>Response</h3>
    <pre id="result">—</pre>

    <script <?= csp_script_nonce() ?>>
        const form = document.getElementById('verifyForm');
        const result = document.getElementById('result');

        form.addEventListener('submit', async function (e) {
            e.preventDefault();
            result.textContent = 'Verifying...';
            result.className = '';

            const data = new FormData(form);
            try {
                const res = await fetch('<?= base_url('stripe/verify-bank-account') ?>', {
                    method: 'POST',
                    body: data
                });
                const json = await res.json();
                result.textContent = JSON.stringify(json, null, 2);
                result.className = json.success ? 'ok' : 'err';
            } catch (err) {
                result.textContent = 'Request failed: ' + err.message;
                result.className = 'err';
            }
        });
    </script>

</body>
</html>
