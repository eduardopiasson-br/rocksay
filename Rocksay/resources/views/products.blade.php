@extends('layouts/app', ['activePage' => 'produtos', 'title' => 'Nossos Produtos - Cutie & Sweet'])
@section('content')
<section class="products">
    <div class="top-product">
        <h2>Conheça nossos produtos</h2>
        <p>Todos os produtos são selecionados com muito carinho para atender seus gostos e necessidades</p>
    </div>
    @if($categories->count() > 0)
        <div class="redirects" id="products">
            <h3 class="redirects-title">Procure por categoria: </h3>
                <a href="#todos" class="redirects-button" title="Ver todos os Produtos"
                    data-categoria="todos">
                    <i class="fas fa-reply-all"></i> Todos
                </a>
                @foreach ($categories as $category)
                    <a href="#{{ Str::of($category->name)->slug('-') }}" class="redirects-button" title="Ver apenas produtos da categoria {{ $category->name }}"
                        data-categoria="{{ Str::of($category->name)->slug('-') }}">
                        <i class="fab fa-slack-hash"></i> {{ $category->name }}
                    </a>
                @endforeach
        </div>
    @endif
    @if($products->count() > 0)
        <div class="div-products">
            @foreach($products as $product)
                <a class="a-product todos @foreach ($product->categories as $cat) {{ Str::of($cat->name)->slug('-') }} @endforeach" href="{{ url('produto', ['product_id' => $product->id, 'product_name' => Str::of($product->title)->slug('-')]) }}" title="Clique para ver detalhes do produto!">
                    <img class="img-product" src="{{ url('images/products/product/'. $product->image) }}" alt="{{ $product->title }}">
                    @if ($product->units == 0)
                        <p class="indisponivel">Indisponível</p>
                    @elseif(!empty($product->price_promo))
                        <p class="price-discount">De {{ $product->price }} por <span class="discount">{{ $product->price_promo }}</span></p>
                    @else
                        <p class="price"> {{ $product->price }} </p>
                    @endif
                    <h2 class="h2-product"> {{ $product->title }} </h2>
                    <span class="button-product">Ver Detalhes</span>
                </a>
            @endforeach
            <div class="paginate">
                {{ $products->links() }}
            </div>
        </div>
    @endif
</section>

@include('layouts.payments_delivery')

@endsection

@push('js')
    <!-- Js utilizado apenas nessa página -->
    <script src="js/products.js"></script>
@endpush