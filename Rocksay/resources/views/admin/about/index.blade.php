@extends('admin.layouts.app', ['activePage' => 'about', 'title' => 'Sobre a C&S - Gerenciar', 'navName' => 'Sobre a Cutie & Sweet', 'activeButton' => 'laravel'])

@section('content')                 
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card data-tables full-admin-table">

                    <div class="card-header col-md-12">
                        <div class="row align-items-center">
                            <div class="col-12">
                                @if(!empty($about))
                                    <h3 class="mt-0 top-title"><i class="fas fa-heart"></i> Editar 'Sobre'</h3>
                                @else
                                    <h3 class="mt-0 top-title"><i class="fas fa-heart"></i> Cadastrar 'Sobre'</h3>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <form method="post" @if(!empty($about)) action="{{ route('sobre.atualizacao') }}" @else action="{{ route('sobre.cadastro') }}" @endif autocomplete="off" enctype="multipart/form-data">
                        @csrf

                        @if ($errors->any())
                            <div class="alert alert-danger" role="alert">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @if(!empty($about))
                            <input type="text" name="id" value="{{ $about->id ?? old('id') }}" hidden>
                            <input type="hidden" name="_method" value="put" />
                        @endif

                        <input type="text" name="user_id" value="{{ auth()->user()->id }}" hidden>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label class="form-control-label" for="title">{{ __('Título da Página') }} <i class="text-danger">*</i> </label>
                                <input type="text" name="title" id="title" class="form-control" value="{{ $about->title ?? old('title') }}" placeholder="Ex: Sobre a Cutie And Sweet">
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="form-control-label" for="title">&nbsp;</label>
                                <a href="{{ route('sobre.galeria') }}" title="Cadastrar Galeria de Imagens" class="btn btn-info form-control"><i class="far fa-images"></i> Galeria de Imagens</a></h3>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label class="form-control-label" for="text">{{ __('Descrição da Página') }} <i class="text-danger">*</i> </label>
                                <textarea type="text" name="text" id="summary-ckeditor" class="form-control" placeholder="Fale um pouco sobre a empresa, quando surgiu, porquê... Fale sobre você e seu amor por moda...">{{ $about->text ?? old('text') }}</textarea>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label class="form-control-label" for="mission">{{ __('Missão') }} </label>
                                <textarea type="text" name="mission" id="mission" class="form-control" placeholder="Crie uma breve Missão para a empresa.." rows="2">{{ $about->mission ?? old('mission') }}</textarea>
                            </div>
                            <div class="col-md-4 form-group">
                                <label class="form-control-label" for="vision">{{ __('Visão') }}</label>
                                <textarea type="text" name="vision" id="vision" class="form-control" placeholder="Crie uma breve Visão da empresa..." rows="2">{{ $about->vision ?? old('vision') }}</textarea>
                            </div>
                            <div class="col-md-4 form-group">
                                <label class="form-control-label" for="values">{{ __('Valores') }}</label>
                                <textarea type="text" name="values" id="values" class="form-control" placeholder="Informe os valores da empresa.." rows="2">{{ $about->values ?? old('values') }}</textarea>
                            </div>
                        </div>
                        <br><br>

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