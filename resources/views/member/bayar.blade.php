@extends('admin/index')
@section('content')

<div class="container mt-5">
    <div class="card shadow rounded">
        <div class="card-body text-center">
            
            <h3 class="card-title mb-4">Pembayaran Pendaftaran Member</h3>
           
            <p class="mb-4"><strong>Nominal:</strong> Rp 50.000</p>

            <button id="pay-button" class="btn btn-primary btn-lg">
                <i class="bi bi-credit-card-fill me-2"></i> Bayar Sekarang
            </button>
        </div>
    </div>
</div>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script type="text/javascript">
    document.getElementById('pay-button').onclick = function () {
        snap.pay('{{ $snapToken }}', {
            onSuccess: function(result) {
                window.location.href = "/member/sukses?order_id={{ $member->midtrans_order_id }}";
            },
            onPending: function(result) {
                alert("Menunggu pembayaran...");
            },
            onError: function(result) {
                alert("Pembayaran gagal.");
            },
        });
    };
</script>
@endsection
