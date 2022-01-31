@extends('layouts/app', ['activePage' => 'feedback', 'title' => 'Feedback de Clientes - Cutie & Sweet'])

@section('content')
    <section class="feedback-section">

        <div class="feedback-title">
            <h2> Feedback </h2>
            <p>Aqui você pode acompanhar o feedback de alguns de nossos clientes!</p>
        </div>

        <div class="feedbacks-div">
            <div class="glide">
                <div class="glide__track" data-glide-el="track">
                    <ul class="glide__slides">
                        @foreach ($feedback as $feed)
                            @if(empty($feed->image))
                                <li>
                                    <div class="feedback-item">
                                        <div class="feedback-conteudo">
                                            <h3>{{ $feed->name }}</h3>
                                            <hr>
                                            <?= $feed->text ?>
                                        </div>
                                    </div>
                                </li>
                            @else
                                <li>
                                    <div class="feedback-item">
                                        <div class="feedback-conteudo">
                                            <h3>{{ $feed->name }}</h3>
                                            <div class="gallery" id="gallery">
                                                <a><img src="{{ url('images/feedback/'.$feed->image) }}" alt="Feedback da nossa cliente {{ $feed->name }}"
                                                        title="Feedback da nossa cliente {{ $feed->name }}" /></a>
                                            </div>
                                        </div>
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
        </div>
    </section>

    <br>
    <hr class="hr-wide">
    <br>

    @include('layouts.socials')
@endsection

@push('js')
    <!-- Glide pra usar uns sliders diferentes -->
    <script src="{{ url('js/dependence/glide.min.js') }}"></script>
    {{-- Js para galeria --}}
    <script src="{{ url('js/dependence/simple-lightbox.min.js?v2.4.1') }}"></script>
    {{-- Js utilizado apenas no feedback --}}
    <script src="{{ url('js/feedback.js') }}"></script>
@endpush