@extends('admin.layouts.app', ['activePage' => 'blogs', 'title' => 'Blog C&S - Gerenciar', 'navName' => 'Gerenciar Posts do Blog', 'activeButton' => 'laravel'])

@section('content')                 
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card data-tables" style="flex-direction: inherit; flex-wrap: wrap">

                    {{-- Formulário de Cadastro/Atualização --}}
                    <div class="col-md-6">
                        <div class="col-12 card-body">
                            @if(!empty($item->title))
                                <h3 class="mt-0 top-title"><i class="fas fa-blog"></i> Editar Post <a href="{{ route('blog') }}" title="Voltar para cadastros" class="btn btn-ces"><i class="fas fa-undo"></i></a></h3>
                            @else
                                <h3 class="mt-0 top-title"><i class="fas fa-blog"></i> Cadastrar Post</h3>
                            @endif
                        </div>
                        <form method="post" @if(!empty($item->title)) action="{{ route('blog.atualizacao') }}" @else action="{{ route('blog.cadastro') }}" @endif autocomplete="off" enctype="multipart/form-data">
                        @csrf

                        {{-- Retorno de Erros --}}
                        @if ($errors->any())
                            <div class="alert alert-danger" role="alert">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if(!empty($item->title))
                            <input type="text" name="id" value="{{ $item->id ?? old('id') }}" hidden>
                            <input type="hidden" name="_method" value="put" />
                        @endif
                        <input type="text" name="user_id" value="{{ auth()->user()->id }}" hidden>

                        {{-- Título e texto --}}
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label class="form-control-label" for="input-title">
                                    {{ __('Título do Post') }} <i class="text-danger">*</i>
                                </label>
                                <input type="text" name="title" id="input-title" class="form-control" value="{{ $item->title ?? old('title') }}" placeholder="Destaques para a próxima estação!">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label class="form-control-label" for="input-text">
                                    {{ __('Texto da Publicação') }} <i class="text-danger">*</i>
                                </label>
                                <textarea type="text" name="text" id="summary-ckeditor" class="form-control" placeholder="Descrição para o post...">{{ $item->text ?? old('text') }}</textarea>
                            </div>
                        </div>
                        {{-- Datas --}}
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label class="form-control-label" for="input-start_post">
                                    {{ __('Data Inicial') }} <i class="text-danger">*</i>
                                </label>
                                <input type="date" name="start_post" id="input-start_post" class="form-control" value="{{ $item->start_post ?? old('start_post') }}"  placeholder="00/00/0000">
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="form-control-label" for="input-end_post">
                                    {{ __('Data Final') }}
                                </label>
                                <input type="date" name="end_post" id="input-end_post" class="form-control" value="{{ $item->end_post ?? old('end_post') }}" placeholder="00/00/0000">
                            </div>
                        </div>
                        {{-- Caso tenha alguma fonte --}}
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label class="form-control-label" for="input-autor">
                                    {{ __('Autor da Matéria') }}
                                </label>
                                <input type="text" maxlength="150" name="autor" id="input-autor" class="form-control" value="{{ $item->autor ?? old('autor') }}"  placeholder="Fulano de Tal">
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="form-control-label" for="input-font">
                                    {{ __('Fonte da Matéria') }}
                                </label>
                                <input type="text" maxlength="150" name="font" id="input-font" class="form-control" value="{{ $item->font ?? old('font') }}"  placeholder="O Globo, UOL, Moda Fashion Oficial...">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label class="form-control-label" for="input-font_link">
                                    {{ __('Link da Fonte da Matéria') }}
                                </label>
                                <input type="url" name="font_link" id="input-font_link" class="form-control" value="{{ $item->font_link ?? old('font_link') }}"  placeholder="Link para a fonte da matéria">
                            </div>
                        </div>
                        {{-- Caso esteja vinculado a algum outro conteúdo do site --}}
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label class="form-control-label" for="input-button">
                                    {{ __('Nome do Botão') }}
                                </label>
                                <input type="text" maxlength="100" name="button" id="input-button" class="form-control" value="{{ $item->button ?? old('button') }}"  placeholder="Ex: Conhecer os Produtos">
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="form-control-label" for="input-button_link">
                                    {{ __('Link para o Botão') }}
                                </label>
                                <input type="text" name="button_link" id="input-button_link" class="form-control" value="{{ $item->button_link ?? old('button_link') }}"  placeholder="Link para o botão cadastrado">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label class="form-control-label" for="input-button_text">
                                    {{ __('Texto Explicativo para o Botão') }}
                                </label>
                                <input type="text" name="button_text" id="input-button_text" class="form-control" value="{{ $item->button_text ?? old('button_text') }}"  placeholder="Ex: Clique no botão abaixo para ser redirecionada aos produtos mencionados no 'post'...">
                            </div>
                        </div>

                        <div class="row">
                            @if(!empty($item->title))
                                @if (!empty($item->image))
                                    <div class="col-md-6 form-group">
                                        <label class="form-control-label" for="input-start_date">
                                            {{ __('Imagem PC:') }} <i class="text-danger">*</i>
                                        </label><br>
                                        <img src="/images/blogs/posts/{{ $item->image }}" style="max-width: 100%">
                                        <br><br>
                                        <input type="file" data-id="{{ $item->id }}" id="blogimage" name="blogimage" class="form-control">
                                    </div>
                                @endif
                            @endif
                            <div class="col-md-6">
                                <label class="form-control-label" for="input-video">
                                    {{ __('Cadastrar Vídeo') }}
                                </label><br>
                                <div class="d-flex">
                                    <input type="text" name="video" id="txtUrl" value="{{ $item->video ?? old('video') }}" class="col-md-8 form-control">
                                    <input type="button" id="btnPlay" value="Ver" class="btn" style="margin-left: 3px">
                                </div>
                                <iframe id="video" style="max-width: 100%;display: none" frameborder="0"
                                    allowfullscreen></iframe>
                            </div>
                        </div>

                        <hr class="hr-ces">
                        <div class="form-group">
                            <button type="submit" class="btn btn-success mr-1" title="Salvar Dados">Salvar</button>
                            <button type="reset" class="btn btn-warning ml-1" title="Restaurar Dados">Restaurar</button>
                        </div>
                        </form>
                    </div>
                    
                    <div class="col-md-6 table-full-width table-responsive table-ces">
                        <div class="col-12 card-body">
                            <h3 class="mt-0 top-title"><i class="fas fa-clipboard-list"></i> 
                                Posts Cadastrados
                                <a href="{{ route('blog') }}" title="Recarregar Posts" class="btn btn-ces"><i class="fas fa-sync"></i></a>
                            </h3>
                        </div>

                        <table id="blogtable" class="table table-hover table-stripeds">
                            <thead>
                                <tr class="col-md-12">
                                    <td class="col-md-1"><b>#</b></td>
                                    <td class="col-md-8"><b>Título</b></td>
                                    <td style="display: block">
                                    </td>
                                </tr>
                            </thead>
                            <tbody id="tablecontents">
                                @foreach ($itens as $k => $item)
                                    <tr class="row1" data-id="{{ $item->id }}">
                                        <td>{{ $k }}</td>
                                        @if (!$item->image)
                                            <td class="table-center" title="{{ $item->title }}">
                                                Imagem : <input type="file" data-id="{{ $item->id }}" id="blogimage" name="blogimage" class="form-control">
                                                @php $item_id = $item->id @endphp
                                            </td>
                                        @else
                                            <td title="{{ $item->start_post }}">{{ $item->title }}</td>
                                        @endif
                                        <td class="d-flex justify-content-end">                                            
                                            @if($item->highlight == 1)                                            
                                                <a href="{{ route('blog.destaque', $item->id) }}" title="Remover Destaque" class="btn btn-sm button-admin-highlight-true"><i class="fas fa-star"></i></a>
                                            @else
                                                <a href="{{ route('blog.destaque', $item->id) }}" title="Destacar Post" class="btn btn-sm button-admin-highlight-false"><i class="fas fa-blog"></i></a>
                                            @endif
                                            @if($item->status == 1)                                            
                                                <a href="{{ route('blog.alternar', $item->id) }}" title="Desativar Post" class="btn btn-sm button-admin-toggle-success"><i class="fas fa-user-check"></i></a>
                                            @else
                                                <a href="{{ route('blog.alternar', $item->id) }}" title="Ativar Post" class="btn btn-sm button-admin-toggle-danger"><i class="fas fa-user-times"></i></a>
                                            @endif
                                            <input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}">
                                            <a href="{{ route('blog.galeria', $item->id) }}" title="Cadastrar Galeria para este Post" class="btn btn-sm button-admin-gallery"><i class="fas fa-image"></i></a>
                                            <a href="{{ route('blog.edicao', $item->id) }}" title="Editar Post" class="btn btn-sm button-admin-edit"><i class="fas fa-marker"></i></a>
                                            <a href="{{ route('blog.deletar', $item->id) }}" title="Deletar Post" class="btn btn-sm delete-confirm button-admin-delete"><i class="fas fa-trash-alt"></i></a>
                                        </td>                       
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
    <script type="text/javascript">
    // Crop image desktop
        $('#blogimage').ijaboCropTool({
          preview : '.image-previewer',
          setRatio:700/400,
          allowedExtensions: ['jpg', 'jpeg','png'],
          buttonsText:['CORTAR E SALVAR','SAIR/CANCELAR'],
          buttonsColor:['#30bf7d','#ee5155', -15],
          processUrl:"{{ route('blog.cortar', $item_id) }}",
          withCSRF:['_token','{{ csrf_token() }}'],
          onSuccess:function(message, element, status){
            if(Toast.fire({
                icon: 'success',
                title: message
                }))
                {window.location.reload();}
          },
          onError:function(message, element, status){
            if(Toast.fire({
                icon: 'danger',
                title: message
            }                
            )){}
          }
       });
    </script>
    <script>
        // Script TextArea
        CKEDITOR.replace( 'summary-ckeditor' );
    </script>
    <script type="text/javascript">
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success ml-2 mr-2',
                cancelButton: 'btn btn-danger ml-2 mr-2'
            },
            buttonsStyling: false
        })
        $('.delete-confirm').on('click', function (event) {
            event.preventDefault();
            const url = $(this).attr('href');
            swalWithBootstrapButtons.fire({
                title: 'Realmente deseja apagar este Post?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Confirmar!',
                cancelButtonText: 'Cancelar!',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    swalWithBootstrapButtons.fire(
                    'Cancelado',
                    'Post não deletado!',
                    'error'
                    )
                }
            });
        });
    </script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script type="text/javascript">
        $("body").on("click", "#btnPlay", function () {
            var url = $("#txtUrl").val();
            $("#video")[0].src = "https://www.youtube.com/embed/" + url;
            $("#video").show();
        });
    </script>

    <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript">
    $(document).ready(function() {
        $('#blogtable').DataTable( {
            "order": [[ 0, "desc" ]],
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.10.25/i18n/Portuguese-Brasil.json"
            }
        } );
    } );
    </script>
@endpush