@extends('layouts/app', ['activePage' => 'blog', 'title' => 'Blog Rocksay'])

@section('content')
    <section class="blog-section">
        <div class="blog-title">
            <h2><i class="fas fa-blog"></i> Blog - Rocksay</h2>
            <p>Confira as novidades da loja, estilo rocksay e muito mais por aqui!</p>
        </div>

        <div class="conteudo">
            @include('layouts.banners.left')

            <div class="news">
                @foreach($blog_general as $post)
                <div class="new">
                    <a class="a-image" title="{{ $post->title }}" href="{{ url('post', ['post_id' => $post->id, 'post_name' => Str::of($post->title)->slug('-')]) }}">
                        <div class="img">
                            <img src="{{ url('images/blogs/posts/'.$post->image) }}" alt="{{ $post->title }}">
                        </div>
                    </a>
                    <div class="new-title-p">
                        <span>{{ date('d/m/Y', strtotime($post->start_post)) }}</span>
                        <a href="{{ url('post', ['post_id' => $post->id, 'post_name' => Str::of($post->title)->slug('-')]) }}" title="Ler: {{ $post->title }}">
                            <h3>{{ $post->title }}</h3>
                        </a>
                        <div class="new-title-p-p"><?= $post->text ?></div>
                    </div>
                    <a class="a-button" title="Ler conteúdo completo" href="{{ url('post', ['post_id' => $post->id, 'post_name' => Str::of($post->title)->slug('-')]) }}">Saiba Mais <i class="far fa-newspaper"></i></a>
                </div>
                <hr class="hr-new">
                @endforeach
                <div class="paginate">
                    {{ $blog_general->links() }}
                </div>
            </div>
            
            @include('layouts.banners.right')
        </div>

    </section>
@endsection

@push('js')
    <!-- Glide pra usar uns sliders diferentes -->
    <script src="js/dependence/glide.min.js"></script>
    <!-- Js utilizado no blog -->
    <script src="js/blog.js"></script>
    <!-- Bootstrap -->
    <script src="js/dependence/bootstrap.bundle.min.js"></script>
@endpush