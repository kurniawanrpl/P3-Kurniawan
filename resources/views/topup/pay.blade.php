<!DOCTYPE html>
<html>
<head>
    <title>Proses Pembayaran</title>
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
</head>
<body>
    <h3>Mohon tunggu, sedang mengarahkan ke pembayaran...</h3>
    <script>
        window.snap.pay('{{ $snapToken }}', {
            onSuccess: function(result) {
                alert("Pembayaran Berhasil!");
                window.location.href = "{{ route('topups.index') }}";
            },
            onPending: function(result) {
                alert("Pembayaran sedang diproses.");
                window.location.href = "{{ route('topups.index') }}";
            },
            onError: function(result) {
                alert("Pembayaran gagal.");
                window.location.href = "{{ route('topups.index') }}";
            }
        });
    </script>
</body>
</html>
