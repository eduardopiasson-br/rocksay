@if($payments->count() > 0 || $deliverys->count() > 0)
<section class="shipping">
    <div class="div-shipping">
        @if($payments->count() > 0)
        <div class="shipping-payment" id="payment">
            <h2><i class="fas fa-hand-holding-usd"></i> Formas de Pagamento</h2>
            @foreach ($payments as $payment)                
                <button class="accordion" aria-label="Clique para saber os detalhes da ferramenta">
                    <?= $payment->icon ?> {{ $payment->title }} <i
                        class="fas fa-caret-down i-right"></i>
                </button>
                <div class="panel">
                    <p> {{ $payment->text }} </p>
                </div>
            @endforeach
        </div>
        <br>
        <hr class="hr-shipping">
        @endif
        @if($deliverys->count() > 0)
        <div class="shipping-p" id="shipping">
            <h2><i class="fas fa-shipping-fast"></i> Entregas e Envios</h2>
            @foreach ($deliverys as $delivery)
                <p><?= $delivery->icon ?> {{ $delivery->text }}</p>
            @endforeach
        </div>
        @endif
    </div>
</section>
@endif
