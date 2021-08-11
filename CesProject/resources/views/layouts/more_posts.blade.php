@if(!empty($blog_general))
<div class="more-posts" id="blog">
    <h2 class="more-h2">Veja também</h2>
    <div class="glide-post">
        <div class="glide__track" data-glide-el="track">
            <ul class="glide__slides">

                @foreach ($blog_general as $blog)                        
                    <li>
                        <a class="a-post-more" href="{{ url('post', ['post_id' => $blog->id, 'post_name' => Str::of($blog->title)->slug('-')]) }}"
                            title="Clique aquie e saiba mais!">
                            <img class="img-post-others" src="{{ url('images/blogs/posts/'. $blog->image) }}"
                                alt="{{ $blog->title }}">
                            <h2 class="h2-post">{{ $blog->title }}</h2>
                            <span class="button-post">Ver Mais</span>
                        </a>
                    </li>
                @endforeach

            </ul>
        </div>
        <div class="glide__arrows ga-2" data-glide-el="controls">
            <button class="glide__arrow glide__arrow--left button-slide-left" title="Anteriores"
                data-glide-dir="<"><i class="fas fa-angle-double-left i-slide"></i></button>
            <button class="glide__arrow glide__arrow--right button-slide-right" title="Próximas"
                data-glide-dir=">"><i class="fas fa-angle-double-right i-slide"></i></button>
        </div>
    </div>
</div>
@endif