<section class="section-contact">

    <div class="div-contact" id="contact">
        <h2 class="h2-contact">Contatos</h2>
        <p class="p-contact">Vai ser um prazer conversar com você!</p>
        <p class="p-contact">Entre em contato, fale conosco, nos mande um e-mail, tire suas dúvidas... Fique a
            vontade!</p>
        <div class="social-contacts">
            @if(!empty($config->whatsapp))
                <div class="social-item whatsapp">
                    <a rel="noopener" target="_blank" href="https://api.whatsapp.com/send?phone=55{{ Str::of($config->whatsapp)->replaceMatches('/[^A-Za-z0-9]++/', '') }}">
                        <h2><i class="fab fa-whatsapp"></i><br> Whatsapp</h2>
                    </a>
                </div>
            @endif
            @if(!empty($config->telegram))
                <div class="social-item telegram">
                    <a rel="noopener" target="_blank" href="https://telegram.me/{{ Str::of($config->telegram)->replaceMatches('/[^A-Za-z0-9]++/', '') }}">
                        <h2><i class="fab fa-telegram"></i><br> Telegram</h2>
                    </a>
                </div>
            @endif
            @if(!empty($config->instagram))
                <div class="social-item instagram">
                    <a rel="noopener" target="_blank" href="{{ $config->instagram }}">
                        <h2><i class="fab fa-instagram"></i><br> Instagram</h2>
                    </a>
                </div>
            @endif
            @if(!empty($config->facebook))
                <div class="social-item facebook">
                    <a rel="noopener" target="_blank" href="{{ $config->facebook }}">
                        <h2><i class="fab fa-facebook-square"></i><br> Facebook</h2>
                    </a>
                </div>
            @endif
            @if(!empty($config->email))
                <div class="social-item email">
                    <a target="_blank" href="mailto:{{ $config->email }}">
                        <h2><i class="fas fa-envelope-open-text"></i><br> E-mail</h2>
                    </a>
                </div>
            @endif
            @if(!empty($config->phone))
                <div class="social-item telefone">
                    <a target="_blank" href="tel:{{ Str::of($config->phone)->replaceMatches('/[^A-Za-z0-9]++/', '') }}">
                        <h2><i class="fas fa-phone-square"></i><br> Telefone</h2>
                    </a>
                </div>
            @endif
        </div>
    </div>

</section>