@extends('layouts/app', ['activePage' => 'inicio', 'title' => 'Rocksay Store'])

@section('content')
@if($categories->count() > 0)
<section class="section-categories">
    <div class="glide">
        <div class="glide__track" data-glide-el="track">
            <ul class="glide__slides">
                @foreach ($categories as $k => $category)
                    @if ($k % 2 == 0)
                        <li>
                            <a class="a-category-1" href="{{ url('produtos?categoria='.Str::of($category->name)->slug('-')) }}" title="Conheça todos os produtos da categoria {{ $category->name }}">
                                <div class="category-1">
                                    <div class="image">
                                        <img src="{{ url('images/categories/'.$category->image) }}" class="category-img" alt="{{ $category->name }}" title="{{ $category->name }}">
                                    </div>
                                    <hr>
                                    <div class="category-text">
                                        <h2 class="category-title">{{ $category->name }}</h2>
                                        <p class="category-p">{{ $category->abstract }}</p>
                                        <a class="category-button" href="{{ url('produtos?categoria='.Str::of($category->name)->slug('-')) }}"
                                            title="Conheça todos os produtos da categoria!">
                                            <i class="fas fa-external-link-alt"></i>
                                            VER TUDO
                                        </a>
                                    </div>
                                </div>
                            </a>
                        </li>
                    @else                
                        <li>
                            <a class="a-category-2" href="{{ url('produtos?categoria='.Str::of($category->name)->slug('-')) }}" title="Conheça todos os produtos da categoria {{ $category->name }}">
                                <div class="category-2">
                                    <div class="image">
                                        <img src="{{ url('images/categories/'.$category->image) }}" class="category-img" alt="{{ $category->name }}" title="{{ $category->name }}">
                                    </div>
                                    <hr>
                                    <div class="category-text">
                                        <h2 class="category-title-2">{{ $category->name }}</h2>
                                        <p class="category-p-2">{{ $category->abstract }}</p>
                                        <a class="category-button-2" href="{{ url('produtos?categoria='.Str::of($category->name)->slug('-')) }}"
                                            title="Conheça todos os produtos da categoria!">
                                            <i class="fas fa-external-link-alt"></i>
                                            VER TUDO
                                        </a>
                                    </div>
                                </div>
                            </a>
                        </li>
                    @endif
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
<section class="all-category">
    <a href="{{ url('produtos') }}" title="Ver todos os produtos" class="category-button">VER TODOS OS PRODUTOS <i class="fas fa-external-link-alt"></i></a>
</section>
@endif

@if(!empty($config->wellcome_message))
<section class="wellcome-section">
    <div class="wellcome-div">
        <hr class="hr-short">
        <hr class="hr-wide">
        <h2 class="wellcome-h2">Bem vindos a <span class="wellcome-span">Rocksay Store</span>!!!</h2>
        <hr class="wellcome-hr">
        <p class="wellcome-p">{{ $config->wellcome_message }}</p>
        <hr class="hr-wide">
        <hr class="hr-short" >
    </div>
</section>
@endif

@include('layouts.socials')

@if($blog->count() > 0)
<section class="news">
    <div class="title-news">
        <h1>Blog - Rocksay</h1>
        <p>Conheça as novidades da loja e saiba mais sobre o estilo Rocksay!</p>
    </div>

    @foreach ($blog as $k => $post)
        @if ($k % 2 == 0)
            <div class="new">
                <a title="{{ $post->title }}" href="{{ url('post', ['post_id' => $post->id, 'post_name' => Str::of($post->title)->slug('-')]) }}"><img loading="lazy" class="new-img" src="{{ url('images/blogs/posts/'.$post->image) }}" alt="{{ $post->title }}" title="{{ $post->title }}"
                        loading="lazy"></a>
                <div class="new-div">
                    <h2 class="new-h2" title="{{ $post->title }}"><i class="fas fa-star"></i>
                        {{ $post->title }}
                    </h2>
                    <div class="new-div-p"><?= $post->text ?></div>
                    <div class="new-div-buttom">
                        <a type="button" class="new-button category-button" href="{{ url('post', ['post_id' => $post->id, 'post_name' => Str::of($post->title)->slug('-')]) }}" title="Ler mais sobre {{ $post->title }}">
                            <i class="fas fa-star"></i>Saiba Mais
                        </a>
                    </div>
                </div>
            </div>
        
            <hr class="div">
        @else
            <div class="new">
                <a title="{{ $post->title }}" href="{{ url('post', ['post_id' => $post->id, 'post_name' => Str::of($post->title)->slug('-')]) }}"><img loading="lazy" class="new-img-hidden"  src="{{ url('images/blogs/posts/'.$post->image) }}" alt="{{ $post->title }} title="{{ $post->title }}"
                        loading="lazy"></a>
                <div class="new-div-2">
                    <h2 class="new-h2-2" title="{{ $post->title }}">
                        {{ $post->title }} <i class="fas fa-star"></i>
                    </h2>
                    <div class="new-div-p"><?= $post->text ?></div>
                    <div class="new-div-buttom">
                        <a type="button" class="new-button category-button" href="{{ url('post', ['post_id' => $post->id, 'post_name' => Str::of($post->title)->slug('-')]) }}" title="Ler mais sobre {{ $post->title }}">
                            Saiba Mais <i class="fas fa-star"></i>
                        </a>
                    </div>
                </div>
                <a title="{{ $post->title }}" href="{{ url('post', ['post_id' => $post->id, 'post_name' => Str::of($post->title)->slug('-')]) }}"><img loading="lazy" class="new-img-2"  src="{{ url('images/blogs/posts/'.$post->image) }}" alt="{{ $post->title }}" title="{{ $post->title }}"
                        loading="lazy"></a>
            </div>
        
            <hr class="div">
        @endif        
    @endforeach
</section>
@endif

@endsection

@push('js')
    <!-- Glide pra usar uns sliders diferentes -->
    <script src="js/dependence/glide.min.js"></script>
    {{-- Js utilizado apenas na index --}}
    <script src="js/index.js"></script>
@endpush