@extends('layouts/app', ['activePage' => 'produtos', 'title' => $product_selected->title . ' - Rocksay'])

@section('content')
    <section class="product-detail">
        <h2 class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
        </h2>
        <div class="redirects">
            <a href="{{ url('produtos') }}" class="redirects-button" title="Ir para todos os produtos">
                <i class="fas fa-reply-all"></i> Todos os Produtos
            </a>
            @if($product_selected->gallery->count() > 0)
                <a href="#gallery" class="redirects-button" title="Ir para galeria de fotos do produto">
                    <i class="fab fa-slack-hash"></i> Mais Fotos
                </a>
            @endif
            @if($payments->count() > 0)
                <a href="#payment" class="redirects-button" title="Ir para formas de pagamento...">
                    <i class="fab fa-slack-hash"></i> Formas de Pagamento
                </a>
            @endif
            @if($deliverys->count() > 0)
                <a href="#shipping" class="redirects-button" title="Ir para formas de envio e entregas...">
                    <i class="fab fa-slack-hash"></i> Entregas e Envios
                </a>
            @endif
            @if($products->count() > 0)
                <a href="#products" class="redirects-button" title="Ir para mais produtos relacionados">
                    <i class="fab fa-slack-hash"></i> Mais Produtos
                </a>
            @endif
            <a href="#contact" class="redirects-button" title="Ir para nossos contatos">
                <i class="fab fa-slack-hash"></i> Contatos
            </a>
        </div>

        @if($product_selected->out_stock == 1)
            <div class="danger">
                <h2 class="danger-message-h2"><i class="far fa-frown"></i> PRODUTO INDISPONÍVEL NO MOMENTO...</h2>
                <p class="danger-message">
                    Trabalhamos com produtos mais variados e bastante novidades então os produtos não ficam 
                    disponíveis muito tempo. Mas você pode fazer seu pedido conosco, escolhemos de acordo com 
                    seu tamanho e cor, do jeitinho que preferir!
                    <a  title="Fazer pedido pelo WhatsApp agora!" href="https://api.whatsapp.com/send?phone=55{{ Str::of($config->whatsapp)->replaceMatches('/[^A-Za-z0-9]++/', '') }}&text=Olá, gostaria de fazer um pedido do produto: *{{ $product_selected->title }}*!">
                    <i class="fab fa-whatsapp"></i> Fazer Pedido</a>
                </p>
            </div>
        @endif

        <div class="product">
            <div class="image-product">
                <img src="{{ url('images/products/product/'. $product_selected->image) }}" alt="{{ $product_selected->title }}" class="img-product">
                @if(!empty($product_selected->photo_name))<p class="img-autor"> Fotos por: <b>{{ $product_selected->photo_name }}</b></p>@endif
            </div>
            <div class="product-info">                
                <h2 class="product-info-h2">{{ $product_selected->title }}</h2>
                <div class="product-price-div">
                    <div class="product-div-request-price">
                        @if(!empty($product_selected->price_promo))
                            <p class="product-discount">{{ $product_selected->price_promo }}</p>
                            <p class="product-price-p">{{ $product_selected->price }}</p>
                        @else
                            <p class="product-price-p-2">{{ $product_selected->price }}</p>
                        @endif
                        @if(!empty($product_selected->prazo))
                            <p class="product-price-prazo">Ou 3x de R$29,90 no cartão</p>
                        @endif
                    </div>
                    <div class="product-div-request">
                        @if(!empty($product_selected->units))<p class="product-request">Estoque: {{ $product_selected->units }}</p>@endif
                    </div>
                </div>
                @if(!empty($product_selected->abstract))
                    <div class="product-info-p"><?= $product_selected->abstract ?></p></div>
                @endif
                <div class="caracteres">
                    @if(!empty($product_selected->new_sizes))
                        <div class="size-caracteres">
                            <p class="product-info-size">Tamanhos:</p>
                            <div class="sizes">
                                @foreach ($product_selected->new_sizes as $size)
                                    <p class="size">{{ $size }}</p>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    @if($product_selected->colors->count() > 0)
                        <div class="color-caracteres">
                            <p class="product-info-size">Cores disponíveis:</p>
                            <div class="colors">
                                @foreach ($product_selected->colors as $color)
                                    <p class="color" aria-label="{{ $color->name }}" style="background-color: {{$color->exa_color}}"></p>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
                @if(!empty($product_selected->categories))
                <div class="categories">
                    <p class="product-info-size">Categorias:</p>
                    <div class="categories-item">
                        @foreach ($product_selected->categories as $category)
                            <a href="{{ url('produtos?categoria='.Str::of($category->name)->slug('-')) }}" title="Ver mais produtos da categoria {{ $category->name }}">#{{ $category->name }}</a>
                        @endforeach     
                    </div>
                </div>
                @endif
                <div class="shop">
                    <a id="comprar" class="button-shop blinking" target="_blank" title="Fazer o pedido agora pelo WhatsApp" 
                    href="https://api.whatsapp.com/send?phone=55{{ Str::of($config->whatsapp)->replaceMatches('/[^A-Za-z0-9]++/', '') }}&text=Olá, gostaria de saber mais sobre *{{ $product_selected->title }}*!"><i
                            class="fab fa-whatsapp"></i> Comprar Agora</a>
                    <div class="shop-p">
                        <p> Você pode fazer o pedido por esse botão que te leva direto para o nosso 
                            whatsapp, mas fique a vontade para nos chamar por qualquer outro meio social!
                        </p>
                    </div>
                </div>

            </div>

        </div>

        @if($product_selected->gallery->count() > 0)
            <div class="container">
                <div class="gallery" id="gallery">
                    <h3 class="gallery-info">Confira mais fotos do produto <i class="fas fa-level-down-alt"></i></h3>
                    @foreach($product_selected->gallery as $image)
                        <a href="{{ url('images/products/gallery/'. $image->image) }}" class="big"><img src="{{ url('images/products/gallery/'. $image->image) }}" alt="{{ $image->name ?? $product_selected->title }}"
                            title="{{ $image->name }}"/></a>
                    @endforeach
                    <div class="clear"></div>
                </div>
            </div>
        @endif

    </section>

    @include('layouts.payments_delivery')

    @if(!empty($products[0]))
    <section class="more-products" id="products">
        <h2 class="more-h2">Conheça também</h2>
        <hr class="more-hr">
        <div class="glide">
            <div class="glide__track" data-glide-el="track">
                <ul class="glide__slides">

                    @foreach ($products as $product)                        
                        <li>
                            <a class="a-product-more" href="{{ url('produto', ['product_id' => $product->id, 'product_name' => Str::of($product->title)->slug('-')]) }}"
                                title="Clique para ver detalhes do produto!">
                                <img class="img-product-others" src="{{ url('images/products/product/'. $product->image) }}"
                                    alt="{{ $product->title }}">
                                @if(!empty($product->price_promo))
                                    <p class="price-discount"> {{ $product->price }} <span class="discount">{{ $product->price_promo }}</span></p>
                                @else
                                    <p class="price"> {{ $product->price }} </p>
                                @endif
                                <h2 class="h2-product">{{ $product->title }}</h2>
                                <span class="button-product">Ver Detalhes</span><br>
                            </a>
                        </li>
                    @endforeach

                </ul>
            </div>
            <div class="glide__arrows" data-glide-el="controls">
                <button class="glide__arrow glide__arrow--left button-slide-left" title="Anteriores"
                    data-glide-dir="<"><i class="fas fa-angle-double-left i-slide"></i></button>
                <button class="glide__arrow glide__arrow--right button-slide-right" title="Próximas"
                    data-glide-dir=">"><i class="fas fa-angle-double-right i-slide"></i></button>
            </div>
        </div>
    </section>
    @endif

    @include('layouts.socials')
    <hr class="hr-wide">
    
@endsection

@push('js')
    <!-- Glide pra usar uns sliders diferentes -->
    <script src="{{ url('js/dependence/glide.min.js') }}"></script>
    {{-- Js para galeria --}}
    <script src="{{ url('js/dependence/simple-lightbox.min.js?v2.4.1') }}"></script>
    <!-- Js utilizado apenas nos detalhes do produto -->
    <script src="{{ url('js/product_detail.js') }}"></script>
@endpush