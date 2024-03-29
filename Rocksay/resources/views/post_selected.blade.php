@extends('layouts/app', ['activePage' => 'blog', 'title' => $post_selected->title . ' | Blog Rocksay'])

@section('content')
    <section class="blog-section">
        <div class="blog-title">
            <p>post completo <i class="fas fa-level-down-alt"></i></p>
            <h2> {{ $post_selected->title }} </h2>
        </div>

        <div class="conteudo">
            @include('layouts.banners.left')            

            <div class="news">
                <div class="blog-title blog-title-mobile">
                    <p>post completo <i class="fas fa-level-down-alt"></i></p>
                    <h2> {{ $post_selected->title }} </h2>
                </div>
                <div class="new">
                    <div class="img">
                        <img src="{{ url('images/blogs/posts/'.$post_selected->image) }}" alt="{{ $post_selected->title }}">
                    </div>
                    <div class="new-title-p">
                        <div class="date-share">
                            <span>{{ date('d/m/Y', strtotime($post_selected->start_post)) }}</span>
                            <div class="share">
                                <span> Compartilhe:</span>
                                <a target="_blank" href="https://www.facebook.com/sharer.php?u={{ \URL::current() }}"><i class="fab fa-facebook-square"></i></a>
                                <a target="_blank" href="https://twitter.com/intent/tweet?url={{ \URL::current() }}&text={{ $post_selected->title }}"><i class="fab fa-twitter-square"></i></a>
                                <a target="_blank" href="https://www.linkedin.com/shareArticle?mini=true&url={{ \URL::current() }}&title={{ $post_selected->title }}&source={{ \URL::current() }}"><i class="fab fa-linkedin"></i></a>
                                <a target="_blank" href="https://api.whatsapp.com/send?text={{ \URL::current() }}"><i class="fab fa-whatsapp-square"></i></a>
                            </div>
                        </div>
                        <?= $post_selected->text ?>                        
                        @foreach ($post_selected->gallery as $imagem)
                            @if($imagem->in_text)
                                @if(!empty($imagem->text_top))<?= $imagem->text_top ?>@endif
                                <img class="imagem-text" src="{{ url('images/blogs/gallery/'. $imagem->image) }}" alt="{{ $imagem->name ?? $post_selected->title }}" title="{{ $imagem->name  ?? $post_selected->title }}"/>
                                @if(!empty($imagem->name)) <p class="imagem-nome">{{ $imagem->name }}</p> @endif
                                @if(!empty($imagem->text_bottom))<?= $imagem->text_bottom ?>@endif
                            @endif
                        @endforeach
                    </div>

                    @if(!empty($post_selected->font) || !empty($post_selected->autor))
                        <div class="autor-post">
                            <p>
                                Fonte:
                                @if(!empty($post_selected->font) && !empty($post_selected->autor))
                                    {{ $post_selected->font }} - {{ $post_selected->autor }}
                                @elseif(!empty($post_selected->font) && empty($post_selected->autor))
                                    {{ $post_selected->font }}
                                @elseif(empty($post_selected->font) && !empty($post_selected->autor))
                                    {{ $post_selected->autor }}
                                @endif
                                @if(!empty($post_selected->font_link)) - <a class="autor-post-a" href="{{ $post_selected->font_link }}" title="Ir para a fonte"><i class="fas fa-external-link-alt"></i></a>@endif
                            </p>
                        </div>
                    @endif 

                    @if($post_selected->gallery->count() > 0)
                        <div class="container">
                            <h3>Mais Imagens</h3>
                            <div class="gallery" id="gallery">
                                @foreach($post_selected->gallery as $image)
                                    <a href="{{ url('images/blogs/gallery/'. $image->image) }}" class="big"><img src="{{ url('images/blogs/gallery/'. $image->image) }}" alt="{{ $image->name ?? $post_selected->title }}"
                                        title="{{ $image->name }}"/></a>
                                @endforeach
                                <div class="clear"></div>
                            </div>
                        </div>
                    @endif

                    @if(!empty($post_selected->video))
                        <iframe src="https://www.youtube.com/embed/{{ $post_selected->video }}" frameborder="2"></iframe>
                    @endif

                    @if(!empty($post_selected->button_text) && !empty($post_selected->button) && !empty($post_selected->button_link))
                        <div class="related">
                            <p>{{ $post_selected->button_text }}</p>
                            <a href="{{ $post_selected->button_link }}" target="_blank" title="Relacionado">{{ $post_selected->button }}</a>
                        </div>
                    @endif
                    <div class="date-share date-share-2">
                        <div class="share new-share">
                            <span> Compartilhe:</span>
                            <a target="_blank" href="https://www.facebook.com/sharer.php?u={{ \URL::current() }}"><i class="fab fa-facebook-square"></i></a>
                            <a target="_blank" href="https://twitter.com/intent/tweet?url={{ \URL::current() }}&text={{ $post_selected->title }}"><i class="fab fa-twitter-square"></i></a>
                            <a target="_blank" href="https://www.linkedin.com/shareArticle?mini=true&url={{ \URL::current() }}&title={{ $post_selected->title }}&source={{ \URL::current() }}"><i class="fab fa-linkedin"></i></a>
                            <a target="_blank" href="https://api.whatsapp.com/send?text={{ \URL::current() }}"><i class="fab fa-whatsapp-square"></i></a>
                        </div>
                    </div>
                    <hr class="hr-new"> 
                </div>
                @include('layouts.more_posts')                            
            </div>
            
            @include('layouts.banners.right')
        </div>

    </section>

@endsection

@push('js')
    <!-- Glide pra usar uns sliders diferentes -->
    <script src="{{ url('js/dependence/glide.min.js') }}"></script>
    {{-- Js para galeria --}}
    <script src="{{ url('js/dependence/simple-lightbox.min.js?v2.4.1') }}"></script>
    <!-- Js utilizado no blog -->
    <script src="{{ url('js/blog.js') }}"></script>
    <script src="{{ url('js/post_detail.js') }}"></script>
@endpush