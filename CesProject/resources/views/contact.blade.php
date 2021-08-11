@extends('layouts/app', ['activePage' => 'contatos', 'title' => 'Contatos - Cutie & Sweet'])

@section('content')
    <section class="contact">
        <i class="fas fa-address-card contact-i"></i>
        <div class="div-contact">

            <div class="contact-principal-title">
                <h2>NOSSOS PRINCIPAIS CONTATOS</h2>
                <p>Entre em contato quando quiser, no horário que quiser, atenderemos assim que for possível!</p>
            </div>

            <div class="div-div-contact">
                @if(!empty($config->instagram))
                <div class="contact-social instagram">
                    <div class="div-social">
                        <div class="text-social">
                            <p class="p-social">
                                Nosso perfil
                            </p>
                            <h2 class="h2-social">
                                Instagram
                            </h2>
                        </div>
                        <i class="fab fa-instagram icon-social-contact"></i>
                    </div>
                    <div class="div-buttom-social">
                        <a class="button-social" title="Ver nossa loja no Instagram" target="_blank" href="{{ $config->instagram }}">Acessar Instagram</a>
                    </div>
                </div>
                @endif
                @if(!empty($config->whatsapp))
                <div class="contact-social whatsapp">
                    <div class="div-social">
                        <div class="text-social">
                            <p class="p-social">
                                Fale conosco
                            </p>
                            <h2 class="h2-social">
                                Whatsapp
                            </h2>
                        </div>
                        <i class="fab fa-whatsapp icon-social-contact"></i>
                    </div>
                    <div class="div-buttom-social">
                        <a class="button-social" title="Nos mande uma mensagem no WhatsApp..." target="_blank" href="https://api.whatsapp.com/send?phone=55{{ $config->whatsapp }}">Enviar Mensagem</a>
                    </div>
                </div>
                @endif
                @if(!empty($config->telegram))
                <div class="contact-social telegram">
                    <div class="div-social">
                        <div class="text-social">
                            <p class="p-social">
                                Mande uma mensagem
                            </p>
                            <h2 class="h2-social">
                                Telegram
                            </h2>
                        </div>
                        <i class="fab fa-telegram icon-social-contact"></i>
                    </div>
                    <div class="div-buttom-social">
                        <a class="button-social" title="Nos mande uma mensagem no Telegram..." target="_blank" href="https://telegram.me/{{ $config->telegram }}">Enviar Mensagem</a>
                    </div>
                </div>
                @endif
                @if(!empty($config->facebook))
                <div class="contact-social facebook">
                    <div class="div-social">
                        <div class="text-social">
                            <p class="p-social">
                                Nossa Página
                            </p>
                            <h2 class="h2-social">
                                Facebook
                            </h2>
                        </div>
                        <i class="fab fa-facebook-square icon-social-contact"></i>
                    </div>
                    <div class="div-buttom-social">
                        <a class="button-social" title="Ver nossa loja no Facebook" target="_blank" href="{{ $config->facebook }}">Acessar Página</a>
                    </div>
                </div>
                @endif
                @if(!empty($config->email))
                <div class="contact-social email">
                    <div class="div-social">
                        <div class="text-social">
                            <p class="p-social">
                                Correio eletrônico
                            </p>
                            <h2 class="h2-social">
                                E-mail
                            </h2>
                        </div>
                        <i class="far fa-envelope icon-social-contact"></i>
                    </div>
                    <div class="div-buttom-social">
                        <a class="button-social" title="Envie-nos um E-mail..." href="mailto:{{ $config->email }}">Enviar E-mail</a>
                    </div>
                </div>
                @endif
                @if(!empty($config->phone))
                <div class="contact-social phone">
                    <div class="div-social">
                        <div class="text-social">
                            <p class="p-social">
                                Número
                            </p>
                            <h2 class="h2-social">
                                Telefone
                            </h2>
                        </div>
                        <i class="fas fa-phone icon-social-contact"></i>
                    </div>
                    <div class="div-buttom-social">
                        <a class="button-social" title="Ver nossa loja no Instagram" href="tel:+55{{ $config->phone }}">Ligar Agora</a>
                    </div>
                </div>
                @endif
            </div>

            @if(!empty($config->link_address))
            <div class="contact-principal-title">
                <h2 class="h2-2">NOSSA LOCALIZAÇÃO</h2>
                <p>Não somos uma loja fisica, mas estamos sempre disponíveis caso queira conferir ou buscar os produtos
                    pessoalmente...</p>
            </div>

            <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d7217.625760540926!2d-53.9866812!3d-25.2432267!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x239208d5dd7b691!2sCutie%20and%20Sweet%20(C%26S)!5e0!3m2!1spt-PT!2sbr!4v1627582488969!5m2!1spt-PT!2sbr" class="iframe-maps" loading="lazy"></iframe>
            @endif

        </div>
        <div class="contact-div-button">
            <a class="contact-button" title="Ver todos os produtos" href="{{ url('/produtos') }}">CONHEÇA NOSSOS PRODUTOS <i
                    class="fas fa-tshirt"></i></a>
        </div>
    </section>
@endsection
