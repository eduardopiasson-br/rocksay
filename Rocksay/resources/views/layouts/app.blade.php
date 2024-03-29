<!DOCTYPE html>
<html lang="pt-BR" @if(!empty($meta_product)) itemscope itemtype=”http://schema.org/Product” @endif>

<head>
    <!-- Metadata -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Icon title-->
    <link rel="shortcut icon" href="{{ url('images/favicon.png') }}" />
    <link rel="apple-touch-icon" sizes="76x76" href="{{ url('images/favicon.png') }}">
    <link rel="icon" type="image/png" href="{{ url('images/favicon.png') }}">

    {{-- Meta Tags Share SEO --}}
    @include('layouts.meta.meta_default')
    <meta name="keywords" content="Rocksay Store, Loja Online de Roupas, {{ $site_keys }}">
    @if(!empty($meta_product))@include('layouts.meta.meta_product')@endif

    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans+Narrow:wght@400;700&display=swap" rel="stylesheet">

    <!-- Css Geral -->
    <link href="{{ url('css/dependence/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ url('css/default.css') }}">
    @if(!empty($index_css))<link rel="stylesheet" href="{{ url('css/index.css') }}">@endif
    @if(!empty($about_css))<link rel="stylesheet" href="{{ url('css/about.css') }}">@endif
    @if(!empty($glide1_css))<link rel="stylesheet" href="{{ url('css/dependence/glide.core.min.css') }}">@endif
    @if(!empty($glide2_css))<link rel="stylesheet" href="{{ url('css/dependence/glide.theme.min.css') }}">@endif
    @if(!empty($simple_css))<link rel="stylesheet" href="{{ url('css/dependence/simple-lightbox.min.css') }}">@endif
    @if(!empty($feedback_css))<link rel="stylesheet" href="{{ url('css/feedback.css') }}">@endif
    @if(!empty($contact_css))<link rel="stylesheet" href="{{ url('css/contact.css') }}">@endif
    @if(!empty($blog_css))<link rel="stylesheet" href="{{ url('css/blog.css') }}">@endif
    @if(!empty($products_css))<link rel="stylesheet" href="{{ url('css/products.css') }}">@endif
    @if(!empty($product_detail_css))<link rel="stylesheet" href="{{ url('css/product_detail.css') }}">@endif
    @if(!empty($post_detail_css))<link rel="stylesheet" href="{{ url('css/post_detail.css') }}">@endif
    @if(!empty($banners_css))<link rel="stylesheet" href="{{ url('css/banners.css') }}">@endif
    @if(!empty($erro_css))<link rel="stylesheet" href="{{ url('css/erro.css') }}">@endif

    <!-- Title -->
    <title>{{ $title }}</title>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-0SYK75GXEZ"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-0SYK75GXEZ');
    </script>
</head>

<body>
    <header>
        <div class="top-header">
            @if(!empty($config->address))
            <a class="top-localization" rel="noopener" target="_blank" href="{{ $config->link_address ?? '#' }}" title="Ver localização no mapa">
                <span class="top-icon-map"><i class="fas fa-map-marked-alt"></i></span>
                {{ $config->address }}
            </a>
            @endif
            <div class="top-social">
                @if(!empty($config->instagram))
                <a href="{{ $config->instagram }}" rel="noopener" target="_blank" title="Conheça nossa loja no Instagram">
                    <i class="top-icon fab fa-instagram"></i>
                </a>
                @endif
                @if(!empty($config->facebook))
                <a href="{{ $config->facebook }}" rel="noopener" target="_blank" title="Curta nossa página no Facebook!">
                    <i class="top-icon fab fa-facebook-square"></i>
                </a>
                @endif
                @if(!empty($config->whatsapp))
                <a rel="noopener" href="https://api.whatsapp.com/send?phone=55{{ Str::of($config->whatsapp)->replaceMatches('/[^A-Za-z0-9]++/', '') }}" target="_blank" title="Entre em contato pelo WhatsApp">
                    <i class="top-icon fab fa-whatsapp"></i>
                </a>
                @endif
                @if(!empty($config->telegram))
                <a rel="noopener" href="https://telegram.me/{{ Str::of($config->telegram)->replaceMatches('/[^A-Za-z0-9]++/', '') }}" target="_blank" title="Entre em contato pelo Telegram">
                    <i class="top-icon fab fa-telegram"></i>
                </a>
                @endif
                @if(!empty($config->phone))
                <a href="tel:+55{{ Str::of($config->phone)->replaceMatches('/[^A-Za-z0-9]++/', '') }}" target="_blank" title="Fale conosco">
                    <i class="top-icon fas fa-phone-square-alt"></i>
                </a>
                @endif
                @if(!empty($config->email))
                <a href="mailto:{{ $config->email }}" target="_blank"
                    title="Entre em contato através do e-mail">
                    <i class="top-icon fas fa-envelope-square"></i>
                </a>
                @endif
            </div>
        </div>
        <nav class="navbar-expand-lg navbar-light nav-menu">
            <a href="{{ url('/') }}" class="div-logo" title="Pagina Inicial">
                <img src="{{ url('/images/logo_large_colors.png') }}" alt="Rocksay Store Logo">
            </a>
            <div class="div-menu collapse navbar-collapse" id="myLinks">
                <ul class="navbar-nav mr-auto ul-menu">
                    <li class="li-menu"><a class="link-menu @if($activePage == 'contatos') active @endif" href="{{ url('/contatos') }}" title="Entre em contato">CONTATO</a>
                    </li>
                    @if(!empty($feedback))
                    <li class="li-menu"><a class="link-menu @if($activePage == 'feedback') active @endif" href="{{ url('/feedback') }}"
                            title="Veja o feedback de nossos clientes">FEEDBACK</a></li>
                    @endif
                    @if(!empty($blog_general))
                    <li class="li-menu"><a class="link-menu @if($activePage == 'blog') active @endif" href="{{ url('/blog-rocksay') }}"
                            title="Saiba mais sobre os nossos conteudos!">BLOG</a></li>
                    @endif
                    @if(!empty($products))
                    <li class="li-menu"><a class="link-menu @if($activePage == 'produtos') active @endif" href="{{ url('/produtos') }}"
                            title="Conheça nossos produtos!">PRODUTOS</a></li>
                    @endif
                    @if(!empty($about))
                    <li class="li-menu"><a class="link-menu @if($activePage == 'sobre') active @endif" href="{{ url('/sobre-a-loja') }}" title="Saiba mais sobre nós...">SOBRE</a>
                    </li>
                    @endif
                    <li class="li-menu"><a class="link-menu @if($activePage == 'inicio') active @endif" href="{{ url('/') }}"
                            title="Ir para a Página Inicial">INICIO</a></li>
                </ul>
            </div>
        </nav>
    </header>
    <div class="div-menu-responsive">
        <a href="#" class="menu" id="toggle"><span><i class="fas fa-bars"></i> MENU</span></a>

        <div class="show-menu-options">
            <ul class="menu-ul">
                <a href="{{ url('/') }}"><li class="menu-li">INICIO</li></a>
                @if(!empty($about))
                    <a href="{{ url('/sobre-a-loja') }}"><li class="menu-li">SOBRE</li></a>
                @endif
                @if(!empty($products))
                    <a href="{{ url('/produtos') }}"><li class="menu-li">PRODUTOS</li></a>
                @endif
                @if(!empty($blog_general))
                    <a href="{{ url('/blog-rocksay') }}"><li class="menu-li">BLOG</li></a>
                @endif
                @if(!empty($feedback))
                    <a href="{{ url('/feedback') }}"><li class="menu-li">FEEDBACK</li></a>
                @endif
                <a href="{{ url('/contatos') }}"><li class="menu-li">CONTATOS</li></a>
            </ul>
        </div>
    </div>

    <body>
          
        <div class="wrapper @if (!auth()->check() || request()->route()->getName() == "") wrapper-full-page @endif">
            @php use Illuminate\Support\Str; @endphp

            <div class="div-content  @if (auth()->check() && request()->route()->getName() != "") main-panel @endif">
                @yield('content')
            </div>

        </div>

    <footer>
        <section class="footer">
            <a class="top-link hide" title="Ir para o topo" href="" id="js-top">
                <i class="fas fa-arrow-up"></i>
            </a>
            @if(!empty($config->whatsapp))
            <a rel="noopener" class="top-link show top-link-2" title="Fale conosco!" target="_blank" href="https://api.whatsapp.com/send?phone=55{{ Str::of($config->whatsapp)->replaceMatches('/[^A-Za-z0-9]++/', '') }}">
                <i class="fab fa-whatsapp fa-wpp"></i>
            </a>
            @endif
    
            <div class="div-footer footer-right">
                <a href="{{ url('/') }}" class="div-logo-footer" title="Pagina Inicial">
                    <img src="{{ url('/images/logo_large_colors.png') }}" alt="Rocksay Store Logo">
                </a>
                @if(!empty($config->footer_text))<p class="footer-p">{{ $config->footer_text }}</p>@endif
            </div>
            <hr class="hr-responsive">
            <div class="div-footer">
                <h3>Entre em Contato:</h3>
                <div class="footer-social">
                    @if(!empty($config->instagram))
                    <a rel="noopener" href="{{ $config->instagram }}" target="_blank" title="Nos acompanhe no Instagram">
                        <i class="fab fa-instagram"></i> @rocksay.store
                    </a>
                    @endif
                    @if(!empty($config->facebook))
                    <a rel="noopener" href="{{ $config->facebook }}" target="_blank"
                        title="Curta nossa página no Facebook">
                        <i class="fab fa-facebook"></i> Rocksay Store Page
                    </a>
                    @endif
                    @if(!empty($config->whatsapp))
                    <a rel="noopener" href="https://api.whatsapp.com/send?phone=55{{ Str::of($config->whatsapp)->replaceMatches('/[^A-Za-z0-9]++/', '') }}" target="_blank" title="Mande uma mensagem em nosso WhatsApp">
                        <i class="fab fa-whatsapp"></i> {{ $config->whatsapp }}
                    </a>
                    @endif
                    @if(!empty($config->telegram))
                    <a rel="noopener" href="https://telegram.me/{{ Str::of($config->telegram)->replaceMatches('/[^A-Za-z0-9]++/', '') }}" target="_blank" title="Mande uma mensagem em nosso Telegram">
                        <i class="fab fa-telegram"></i> {{ $config->telegram }}
                    </a>
                    @endif
                    @if(!empty($config->phone))
                    <a href="tel:+55{{ Str::of($config->phone)->replaceMatches('/[^A-Za-z0-9]++/', '') }}" target="_blank" title="Fale conosco">
                        <i class="fas fa-phone-square-alt"></i> {{ $config->phone }}
                    </a>
                    @endif
                    @if(!empty($config->email))
                    <a href="mailto:{{ $config->email }}" target="_blank"
                        title="Entre em contato através do e-mail">
                        <i class="far fa-envelope"></i> {{ $config->email }}
                    </a>
                    @endif
                    @if(!empty($config->email_two))
                    <a href="mailto:{{ $config->email_two }}" target="_blank"
                        title="Entre em contato através do e-mail">
                        <i class="far fa-envelope"></i> {{ $config->email_two }}
                    </a>
                    @endif
                </div>
            </div>
            <hr class="hr-responsive">
            <div class="div-footer">
                <div class="footer-categories">
                    <div class="footer-category">
                        <a href="{{ url('/') }}" class="category" title="Página inicial">
                            <h2><i class="fas fa-home"></i></h2>
                        </a>
                        @if(!empty($products))
                            <a href="{{ url('/produtos') }}" class="category" title="Confira todos os nossos produtos...">
                                <h2><i class="fas fa-shopping-bag"></i></h2>
                            </a>
                        @endif
                        @if(!empty($about))
                            <a href="{{ url('/sobre-a-loja') }}" class="category" title="Saiba mais sobre nossa loja!">
                                <h2><i class="fas fa-heart"></i></h2>
                            </a>
                        @endif
                        <a href="{{ url('/contatos') }}" class="category" title="Nossos contatos">
                            <h2><i class="fas fa-id-card"></i></h2>
                        </a>
                        @if(!empty($config->link_address))
                            <a rel="noopener" href="{{ $config->link_address }}" target="_blank" class="category" title="Nossa localização">
                                <h2><i class="fas fa-map-marker-alt"></i></h2>
                            </a>
                        @endif
                        @if(!empty($config->email))
                            <a href="mailto:{{ $config->email }}" target="_blank" class="category"
                                title="Nos envie uma e-mail de contato">
                                <h2><i class="far fa-envelope"></i></h2>
                            </a>
                        @endif
                        @if(!empty($config->whatsapp))
                            <a rel="noopener" href="https://api.whatsapp.com/send?phone=55{{ Str::of($config->whatsapp)->replaceMatches('/[^A-Za-z0-9]++/', '') }}" target="_blank" class="category" title="Fale conosco pelo whatsapp">
                                <h2><i class="fab fa-whatsapp"></i></h2>
                            </a>
                        @endif
                        @if(!empty($config->instagram))
                            <a rel="noopener" href="{{ $config->instagram }}" target="_blank" class="category" title="Conheça nossa loja no instagram!">
                                <h2><i class="fab fa-instagram"></i></h2>
                            </a>
                        @endif
                        @if(!empty($config->facebook))
                            <a rel="noopener" href="{{ $config->facebook }}" target="_blank" class="category" title="Curta nossa página no Facebook!">
                                <h2><i class="fab fa-facebook-square"></i></h2>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    
        <div class="copyright-div">
            <p>Copyright © @php echo date('Y') @endphp - Rocksay Store</p>
            @if(!empty($config->cnpj))<p>Cnpj: {{ $config->cnpj }}</p>@endif
            @if(!empty($config->owner))<p>Proprietária: {{ $config->owner }}</p>@endif
        </div>
    
        <!-- Start Scripts -->
    
        <!-- jQuery porque tudo depende disso -->
        <script src="{{ url('js/dependence/jQuery.js') }}"></script>
        <!-- Js utilizado por tudo -->
        <script src="{{ url('js/default.js') }}"></script>
        <!-- Fontawesome pra intupir o site com icones -->
        <script src="{{ url('https://kit.fontawesome.com/372739c0b1.js') }}" crossorigin="anonymous"></script>
    
        <!-- End Scripts -->
    
    </footer>
    @stack('js')
    </body>

</html>