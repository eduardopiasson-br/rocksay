@extends('admin.layouts.app', ['activePage' => 'dashboard', 'title' => 'Painel de Controle - Gerenciar', 'navName' =>
'Painel de Controle', 'activeButton' => 'laravel'])

@section('content')
    <div class="content dashboard-content">
        <div class="container-fluid container-notes">
            <div class="row">
                <div class="col-md-4">
                    <div class="infos-dash-rock">
                        <p class="info-dr-title mb-0"><i class="fas fa-tshirt"></i> Produtos Cadastrados</p>
                        <p class="info-dr-count mb-0">{{$products}}</p>
                        <button class="btn info-dr-button">Ver Produtos</button>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="infos-dash-rock">
                        <p class="info-dr-title mb-0"><i class="fas fa-window-close"></i> Produtos Sem Estoque</p>
                        <p class="info-dr-count mb-0">{{$products_sem_estoque}}</p>
                        <button class="btn info-dr-button"> Ver Produtos</button>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="infos-dash-rock">
                        <p class="info-dr-title mb-0"><i class="fab fa-blogger-b"></i> Posts Blog </p>
                        <p class="info-dr-count mb-0">{{$blogs}}</p>
                        <button class="btn info-dr-button"> Ver Posts</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script type="text/javascript">
        CKEDITOR.replace( 'summary-ckeditor' );
    </script>
@endpush
