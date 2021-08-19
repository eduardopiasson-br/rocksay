    <meta itemprop="name" content="{{ $product_selected->title ?? $title }}">
    <meta itemprop="description" content="@if(!empty($product_selected->abstract))<?= $product_selected->abstract ?>@endif">
    <meta itemprop="image" content="{{ url($config->image) }}">
    <meta name="twitter:data1" content="@if(!empty($product_selected->price_promo)) {{ $product_selected->price_promo }} @else {{ $product_selected->price }}@endif">
    <meta name="twitter:label1" content="Preço">
    <meta name="twitter:data2" content="@if($product_selected->colors->count() > 0) @foreach($product_selected->colors as $color) {{ $color->name }} @endforeach @endif">
    <meta name="twitter:label2" content="@if($product_selected->colors->count() > 0) Cores @endif">
    <meta name="twitter:data3" content="@if(!empty($product_selected->new_sizes)) @foreach($product_selected->new_sizes as $size) {{ $size }} @endforeach @endif">
    <meta name="twitter:label3" content="@if(!empty($product_selected->new_sizes)) Tamanhos @endif">
    <meta property="og:price:amount" content="@if(!empty($product_selected->price_promo)) {{ $product_selected->price_promo }} @else {{ $product_selected->price }}@endif" />
