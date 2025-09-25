<div class="container">
    <div class="container__inner">
        <p>{{ $listing->buyer->name }}さんが商品「{{ $listing->product->name }}」の取引を評価しました。</p>
        <p>取引画面を開いて評価を行ってください。</p>
    </div>
    <div class="transaction-view">
        <a href="{{ route('transaction.show', $listing->id) }}">取引画面を開く</a>
    </div>
</div>