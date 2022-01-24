@extends('layouts/app', ['activePage' => 'sobre', 'title' => 'Sobre a Rocksay Store'])

@section('content')
    <section class="about">
        <div class="div-about">
            <div class="text-about">
                <i class="fas fa-fist-raised about-rock">
                </i>
                <h2 class="about-h2">{{ $about->title }}</h2>
                <?= $about->text ?>
            </div>
            <div class="about-div-button">
                <a class="about-button" title="Ver todos os produtos" href="{{ url('/produtos') }}">CONHECER PRODUTOS <i
                        class="fas fa-tshirt"></i></a>
            </div>

            <div class="pilares">
                @if(!empty($about->mission))
                <div class="pilares-item">
                    <i class="fas fa-crosshairs"></i>
                    <div class="pilares-text">
                        <h3>Missão</h3>
                        <p>
                            {{ $about->mission }}
                        </p>
                    </div>
                </div>
                @endif
                @if(!empty($about->vision))
                <div class="pilares-item">
                    <i class="fas fa-grin-tongue-squint"></i>
                    <div class="pilares-text">
                        <h3>Visão</h3>
                        <p>
                            {{ $about->vision }}
                        </p>
                    </div>
                </div>
                @endif
                @if(!empty($about->mission))
                <div class="pilares-item">
                    <i class="fas fa-gem"></i>
                    <div class="pilares-text">
                        <h3>Valores</h3>
                        <p>
                            {{ $about->values }}
                        </p>
                    </div>
                </div>
                @endif
            </div>

            @if($about_gallery->count() > 0)
            <div class="fg-gallery">
                <h2 class="about-gallery">
                    Galeria
                    <hr class="about-hr">
                </h2>
                <div class="container">
                    <div class="gallery" id="gallery">
                        @foreach ($about_gallery as $item)
                            <a href="{{ url('images/about/'.$item->image) }}" class="big"><img src="{{ url('images/about/'.$item->image) }}" alt="{{ $item->name }}"
                                title="{{ $item->name }}" /></a>
                        @endforeach
                        <div class="clear"></div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </section>
@endsection

@push('js')
    {{-- Js para galeria --}}
    <script src="{{ url('js/dependence/simple-lightbox.min.js?v2.4.1') }}"></script>
    {{-- Js utilizado apenas no about --}}
    <script src="{{ url('js/about.js') }}"></script>
@endpush