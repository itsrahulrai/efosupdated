<script src="https://sdk.cashfree.com/js/v3/cashfree.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {

        const cashfree = Cashfree({
            mode: "{{ $cashfreeMode }}"
        });

        function startPayment() {
            cashfree.checkout({
                paymentSessionId: "{{ $paymentSessionId }}",
                redirectTarget: "_self"
            }).catch(function(error) {
                console.error("Checkout error:", error);
                alert("Payment initialization failed. Please try again.");
            });
        }

        // Auto trigger
        startPayment();

        const btn = document.getElementById("payBtn");
        if (btn) {
            btn.addEventListener("click", startPayment);
        }

    });
</script>
