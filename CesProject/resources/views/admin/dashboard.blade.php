@extends('admin.layouts.app', ['activePage' => 'dashboard', 'title' => 'Painel de Controle - Gerenciar', 'navName' =>
'Painel de Controle', 'activeButton' => 'laravel'])

@section('content')
    <div class="content dashboard-content">
        <div class="container-fluid container-notes">
            <div class="row">
                <div class="col-md-12">
                    <div class="card ">
                        <div class="card-header ">
                            <h4 class="card-title"><i class="fas fa-sticky-note"></i> {{ __('Anotações Gerais') }}</h4>
                            <p class="card-category">
                                {{ __('Lembretes, anotações, atividades pendentes, contas a pagar...') }}</p>
                        </div>
                        <div class="card-body ">
                            <form method="post" action="{{ route('anotacoes.salvar') }}" autocomplete="off" enctype="multipart/form-data">
                                @csrf
                                <input type="text" hidden name="user_id" value="{{ auth()->user()->id }}">
                                <textarea class="form-control" name="notes" id="summary-ckeditor" placeholder="Here can be your nice text">{{ $notes->notes ?? old('notes') }}</textarea>
                                <br>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-success" title="Salvar Dados">Salvar</button>
                                    <button type="reset" class="btn btn-warning" title="Restaurar Dados">Restaurar</button>
                                </div>
                            </form>
                        </div>
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
