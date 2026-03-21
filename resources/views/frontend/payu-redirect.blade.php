<!DOCTYPE html>
<html>

<head>
    <title>Redirecting to Payment</title>
</head>

<body>

    <form id="payuForm" method="post" action="{{ env('PAYU_BASE_URL') }}/_payment">
        <input type="hidden" name="mid" value="7087537">
        <input type="hidden" name="service_provider" value="payu_paisa">
        <input type="hidden" name="key" value="{{ $key }}">
        <input type="hidden" name="txnid" value="{{ $txnId }}">
        <input type="hidden" name="amount" value="{{ $amount }}">
        <input type="hidden" name="productinfo" value="{{ $productInfo }}">
        <input type="hidden" name="firstname" value="{{ $firstname }}">
        <input type="hidden" name="email" value="{{ $email }}">
        <input type="hidden" name="phone" value="{{ $phone }}">

        <input type="hidden" name="surl" value="{{ route('payment.success') }}">
        <input type="hidden" name="furl" value="{{ route('payment.failure') }}">

        <input type="hidden" name="udf1" value="{{ $udf1 }}">
        <input type="hidden" name="udf2" value="{{ $udf2 }}">
        <input type="hidden" name="udf3" value="{{ $udf3 }}">
        <input type="hidden" name="udf4" value="{{ $udf4 }}">
        <input type="hidden" name="udf5" value="{{ $udf5 }}">

        <input type="hidden" name="hash" value="{{ $hash }}">

        <center style="margin-top:100px">
            <h2>Redirecting to Secure Payment Gateway...</h2>
            <p>Please wait. Do not refresh.</p>
            <button type="submit">Click if not redirected</button>
        </center>

    </form>

    <script>
        window.onload = function() {
            document.getElementById('payuForm').submit();
        };
    </script>

</body>

</html>
