<div class="banner-lateral">
    @if($banners->count() > 1)
        <i class="far fa-heart banner-lateral-i"></i>
        <h4>Conheça nossos<br><span>PARCEIROS</span></h4>
        <i class="far fa-heart banner-lateral-i"></i>
        @foreach($banners as $k => $banner)
            @if ($k % 2 == 0)
            @else
                <div class="banner-img">
                    <img class="desktop" src="{{ url('images/banners/desktop/'.$banner->image_desktop) }}" alt="{{ $banner->name }}" title="{{ $banner->name }}">
                    <div class="banner-button-div">
                        @if(!empty($banner->whatsapp))
                            <a class="banner-button button-wpp" href="https://api.whatsapp.com/send?phone=55{{ Str::of($banner->whatsapp)->replaceMatches('/[^A-Za-z0-9]++/', '') }}&text=Olá, estou entrando em contato pelo site da Cutie and Sweet." target="_blank" title="Entre em contato pelo Whatsapp!"><i class="fab fa-whatsapp-square"></i></a>
                        @endif
                        @if(!empty($banner->instagram))
                        <a class="banner-button button-insta" href="{{ $banner->instagram }}" target="_blank" title="Ver perfil no Instagram..."><i class="fab fa-instagram-square"></i></a>
                        @endif
                        @if(!empty($banner->facebook))
                        <a class="banner-button button-face" href="{{ $banner->facebook }}" target="_blank" title="Ver perfil no Facebook"><i class="fab fa-facebook-square"></i></a>
                        @endif
                        @if(!empty($banner->site))
                        <a class="banner-button button-site" href="{{ $banner->site }}" target="_blank" title="Visite o site!"><i class="fas fa-external-link-square-alt"></i></a>
                        @endif
                    </div>
                </div>
                <img class="img-hr" src="{{ url('images/hr-white.png') }}" alt="hr">
            @endif
        @endforeach

        <div class="glide glide-2 to-mobile">
            <div class="glide__track" data-glide-el="track">
                <ul class="glide__slides">
                    @foreach($banners as $k => $banner)
                        @if ($k % 2 == 0)
                        @else
                            <li class="slide">
                                <img src="{{ url('images/banners/mobile/'.$banner->image_mobile) }}" alt="{{ $banner->name }}">
                                <div class="banner-button-div">
                                    @if(!empty($banner->whatsapp))
                                        <a class="banner-button button-wpp" href="https://api.whatsapp.com/send?phone=55{{ Str::of($banner->whatsapp)->replaceMatches('/[^A-Za-z0-9]++/', '') }}&text=Olá, estou entrando em contato pelo site da Cutie and Sweet." target="_blank" title="Entre em contato pelo Whatsapp!"><i class="fab fa-whatsapp-square"></i></a>
                                    @endif
                                    @if(!empty($banner->instagram))
                                        <a class="banner-button button-insta" href="{{ $banner->instagram }}" target="_blank" title="Ver perfil no Instagram..."><i class="fab fa-instagram-square"></i></a>
                                    @endif
                                    @if(!empty($banner->facebook))
                                        <a class="banner-button button-face" href="{{ $banner->facebook }}" target="_blank" title="Ver perfil no Facebook"><i class="fab fa-facebook-square"></i></a>
                                    @endif
                                    @if(!empty($banner->site)) 
                                        <a class="banner-button button-site" href="{{ $banner->site }}" target="_blank" title="Visite o site!"><i class="fas fa-external-link-square-alt"></i></a>
                                    @endif
                                </div>
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
        <img class="img-hr to-mobile" src="{{ url('images/hr-white.png') }}" alt="hr">

        <p class="parceiro-p">Entre em contato e seja também um de nossos parceiros!</p>
        <a class="a-button-contact" title="Fale conosco pelo WhatsApp" href="https://api.whatsapp.com/send?phone=55{{ Str::of($config->whatsapp)->replaceMatches('/[^A-Za-z0-9]++/', '') }}">Fale Conosco <i class="fab fa-whatsapp"></i></a>
    @endif
</div>
