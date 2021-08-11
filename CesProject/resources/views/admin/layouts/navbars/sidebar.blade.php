<div class="sidebar">
    <!--
Tip 1: You can change the color of the sidebar using: data-color="purple | blue | green | orange | red"

Tip 2: you can also add an image using data-image tag
-->
    <div class="sidebar-wrapper">
        <div class="logo">
            <a href="{{ url('/') }}" class="simple-text">
                {{ __("Cutie & Sweet") }}
            </a>
        </div>
        <div class="dropdown user-mobile">
            <button class="btn dropdown-toggle user-button" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-user-cog"></i> {{ auth()->user()->name }}
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="nav-link text-warning" href=" {{ route('usuarios.edicao', auth()->user()->id) }} ">
                    <i class="fas fa-pen-square"></i> {{ __('Editar Dados') }}
                </a>
                <form class="nav-link" id="logout-form" action="{{ route('logout') }}" method="POST">
                    @csrf
                    <a class="text-danger" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i> {{ __('Desconectar') }} 
                    </a>
                </form>
            </div>
        </div>
        <ul class="nav">
            <li class="nav-item @if($activePage == 'dashboard') active @endif">
                <a class="nav-link" href="{{ route('painel-de-controle') }}">
                    <i class="fas fa-laptop-house"></i>
                    <p>{{ __("Painel de Controle") }}</p>
                </a>
            </li>
            <li class="nav-item @if($activePage == 'users') active @endif">
                <a class="nav-link" href="{{ route('usuarios') }}">
                    <i class="fas fa-users"></i>
                    <p>{{ __("Usuários") }}</p>
                </a>
            </li>
            <li class="nav-item @if($activePage == 'config') active @endif">
                <a class="nav-link" href="{{ route('configuracoes') }}">
                    <i class="fas fa-cogs"></i>
                    <p>{{ __("Configurações") }}</p>
                </a>
            </li>
            <li class="nav-item @if($activePage == 'about') active @endif">
                <a class="nav-link" href="{{ route('sobre') }}">
                    <i class="fas fa-heart"></i>
                    <p>{{ __("Sobre a C&S") }}</p>
                </a>
            </li>
            <li class="nav-item @if($activePage == 'categories') active @endif">
                <a class="nav-link" href="{{ route('categorias') }}">
                    <i class="fab fa-pied-piper-hat"></i>
                    <p>{{ __("Categorias") }}</p>
                </a>
            </li>
            <li class="nav-item @if($activePage == 'products') active @endif">
                <a class="nav-link nav-product" href="{{ route('produtos') }}">
                    <i class="fas fa-tshirt"></i>
                    <p>{{ __("Produtos") }}</p>
                </a>
            </li>
            <li class="nav-item @if($activePage == 'blogs') active @endif">
                <a class="nav-link" href="{{ route('blog') }}">
                    <i class="fas fa-blog"></i>
                    <p>{{ __("Blog da C&S") }}</p>
                </a>
            </li>
            <li class="nav-item @if($activePage == 'banners') active @endif">
                <a class="nav-link" href="{{ route('banners') }}">
                    <i class="fas fa-handshake"></i>
                    <p>{{ __("Banners Parceiros") }}</p>
                </a>
            </li>
            <li class="nav-item @if($activePage == 'feedback') active @endif">
                <a class="nav-link" href="{{ route('feedback') }}">
                    <i class="fas fa-comments"></i>
                    <p>{{ __("Feedback's") }}</p>
                </a>
            </li>
            <li class="nav-item @if($activePage == 'payments') active @endif">
                <a class="nav-link" href="{{ route('pagamentos') }}">
                    <i class="fas fa-hand-holding-usd"></i>
                    <p>{{ __("Pagamentos") }}</p>
                </a>
            </li>
            <li class="nav-item @if($activePage == 'deliverys') active @endif">
                <a class="nav-link" href="{{ route('entregas') }}">
                    <i class="fas fa-truck"></i>
                    <p>{{ __("Entregas e Envios") }}</p>
                </a>
            </li>
        </ul>
    </div>
</div>
