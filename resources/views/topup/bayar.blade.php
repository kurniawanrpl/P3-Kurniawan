<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.clientKey') }}"></script>

<script type="text/javascript">
    window.onload = function () {
        snap.pay('{{ $snapToken }}', {
            onSuccess: function (result) {
                alert("Pembayaran berhasil!");
                window.location.href = "{{ route('topup.status', ['order_id' => $order_id]) }}";
            },
            onPending: function (result) {
                alert("Menunggu pembayaran...");
                window.location.href = "{{ route('topup.status', ['order_id' => $order_id]) }}";
            },
            onError: function (result) {
                alert("Pembayaran gagal.");
                console.log(result);
            }
        });
    };
</script>