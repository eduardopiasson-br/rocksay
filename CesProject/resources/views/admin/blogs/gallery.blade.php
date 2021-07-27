@extends('admin.layouts.app', ['activePage' => 'blogs', 'title' => 'Galeria do Post - Gerenciar', 'navName' => 'Gerenciar Galeria do Blog', 'activeButton' => 'laravel'])

@section('content')                 
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card data-tables" style="flex-direction: inherit; flex-wrap: wrap">

                    <div class="card-header col-md-12">
                        <div class="row align-items-center">
                            <div class="col-6">
                                @if(!empty($image))
                                    <h3 class="mt-0 top-title"> 
                                        <a href="{{ route('blog') }}" title="Voltar para Blog (Posts)" class="btn btn-ces"><i class="fas fa-undo"></i></a>
                                        <i class="far fa-images"></i> Editar Imagem 
                                        <a href="{{ route('blog.galeria', $blog_id) }}" title="Voltar para cadastros" class="btn btn-ces"><i class="fas fa-undo"></i></a>
                                    </h3>
                                @else
                                    <h3 class="mt-0 top-title">
                                        <a href="{{ route('blog') }}" title="Voltar para Blog (Posts)" class="btn btn-ces"><i class="fas fa-undo"></i></a>
                                        <i class="far fa-images"></i> Cadastrar Imagens
                                    </h3>
                                @endif
                            </div>
                            <div class="col-6">
                                <h3 class="mt-0 top-title"><i class="fas fa-clipboard-list"></i> 
                                    Imagens da Galeria
                                    <a href="{{ route('blog.galeria', $blog_id) }}" title="Recarregar Imagens" class="btn btn-ces"><i class="fas fa-sync"></i></a>
                                </h3>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <form method="post" @if(!empty($image)) action="{{ route('blog.galeria.atualizacao', ['blog_id' => $blog_id]) }}" @else action="{{ route('blog.galeria.cadastro', ['blog_id' => $blog_id]) }}" @endif autocomplete="off" enctype="multipart/form-data">
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

                        @if(!empty($image))
                            <input type="text" name="id" value="{{ $image->id ?? old('id') }}" hidden>
                            <input type="hidden" name="_method" value="put" />
                        @endif

                        <input type="text" hidden name="blog_id" value="{{ $blog_id }}">
                        <input type="text" hidden id="position" name="position" value="{{ $max_position ?? 1 }}">
                        <input type="text" name="user_id" value="{{ auth()->user()->id }}" hidden>
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label class="form-control-label" for="input-name">
                                    {{ __('Nome para a Imagem') }} <i class="text-danger">*</i>
                                </label>
                                <input type="text" name="name" id="input-name" class="form-control" value="{{ $image->name ?? old('name') }}"  placeholder="Ex: Novas tendências da próxima estação.">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label>Imagem <i class="text-danger">*</i> :</label>
                                <input type="file" id="image" name="image" class="form-control" placeholder="Imagem Inauguraçao C&S">
                            </div>
                        </div>
                        @if(!empty($image))
                            <div class="row">
                                <div class="col-md-6 form-group div-image-about">
                                <img src="/images/blogs/gallery/{{ $image->image }}" width="400px">
                                </div>
                            </div>
                        @endif
                        <div class="col-md-12 form-group ml-3">
                            <input type="checkbox" class="form-check-input" name="in_text" id="mycheckbox" value="1" @if(!empty($image) && $image->in_text == 1) checked @endif>
                            <label for="in_text">Imagem no Meio do Texto</label>
                        </div>
                        <div class="row" id="mycheckboxdiv" @if(!empty($image) && $image->in_text == 1) style="display:block" @else style="display:none" @endif>
                            <div class="form-group ml-3 mr-3">
                                <label class="form-control-label" for="input-text_top">
                                    {{ __('Texto Acima da Imagem') }}
                                </label>
                                <textarea type="text" name="text_top" id="summary-text-top" class="form-control" placeholder="Ex: Caso a imagem vá aparecer em meio ao texto, é possível adicionar um texto antes de aparecer a imagem...">{{ $image->text_top ?? old('text_top') }}</textarea>
                            </div>
                            <div class="form-group ml-3 mr-3">
                                <label class="form-control-label" for="input-text_bottom">
                                    {{ __('Texto Abaixo da Imagem') }}
                                </label>
                                <textarea type="text" name="text_bottom" id="summary-text-bottom" class="form-control" placeholder="Ex: Caso a imagem vá aparecer em meio ao texto, é possível adicionar um texto depois da imagem...">{{ $image->text_bottom ?? old('text_bottom') }}</textarea>
                            </div>
                        </div>               
                        <div class="form-group d-flex justify-content-center">
                            <button type="submit" class="btn btn-success mr-1" title="Salvar Dados">Salvar</button>
                            <button type="reset" class="btn btn-warning ml-1" title="Restaurar Dados">Restaurar</button>
                        </div>
                        </form>
                    </div>
                    
                    <div class="col-md-6 card-body table-full-width table-responsive table-ces">
                        <table class="table table-hover table-stripeds">
                            <thead>
                                <tr class="col-md-12">
                                    <td class="col-md-6"><b>Nome</b></td>
                                    <td class="col-md-3"><b>Imagem</b></td>
                                    <td style="display: block">
                                    </td>
                                </tr>
                            </thead>
                            <tbody id="tablecontents">
                                @foreach ($gallery as $image)
                                    <tr class="row1" data-id="{{ $image->id }}" style="cursor: n-resize" title="Clique e arraste para reordenar...">
                                        <td>{{ $image->name }}</td>
                                        <td title="{{ $image->name }}" ><img src="/images/blogs/gallery/{{ $image->image }}" width="100px"></td>
                                        <td class="d-flex justify-content-end">
                                            @if($image->status == 1)                                            
                                                <a href="{{ route('blog.galeria.alternar', ['blog_id' => $blog_id, 'image_id' => $image->id]) }}" title="Desativar Imagem" class="btn btn-sm button-admin-toggle-success"><i class="fas fa-user-check"></i></a>
                                            @else
                                                <a href="{{ route('blog.galeria.alternar', ['blog_id' => $blog_id, 'image_id' => $image->id]) }}" title="Ativar Imagem" class="btn btn-sm button-admin-toggle-danger"><i class="fas fa-user-times"></i></a>
                                            @endif
                                            <input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}">
                                            <a href="{{ route('blog.galeria.edicao', ['blog_id' => $blog_id, 'image_id' => $image->id]) }}" title="Editar Imagem" class="btn btn-sm button-admin-edit"><i class="fas fa-marker"></i></a>
                                            <a href="{{ route('blog.galeria.deletar', ['blog_id' => $blog_id, 'image_id' => $image->id]) }}" title="Deletar Imagem" class="btn btn-sm delete-confirm button-admin-delete"><i class="fas fa-trash-alt"></i></a>
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
                title: 'Realmente deseja apagar esta imagem?',
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
                    'Imagem não deletada!',
                    'error'
                    )
                }
            });
        });
    </script>
    <script>
        // Script TextArea
        CKEDITOR.replace( 'summary-text-top' );
    </script>
    <script>
        // Script TextArea
        CKEDITOR.replace( 'summary-text-bottom' );
    </script>
    <!-- Main row -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
    <script type="text/javascript">
      $(function () {
        $( "#tablecontents" ).sortable({
          items: "tr",
          cursor: 'move',
          opacity: 0.6,
          update: function() {
              sendOrderToServer();
          }
        });

        function sendOrderToServer() {
          var order = [];
          var token = $('meta[name="csrf-token"]').attr('content');
          $('tr.row1').each(function(index,element) {
            order.push({
              id: $(this).attr('data-id'),
              position: index+1
            });
          });

          $.ajax({
            type: "POST",
            dataType: "json",
            url: "{{ url('gerenciar/blog/'.$blog_id.'/galeria/reposicionar') }}",
                data: {
                    _token: token,
                    order: order,
            },
            success: function(response) {
                if (response.status == "success") {
                  console.log(response);
                } else {
                  console.log(response);
                }
            }
          });
        }
      });
    </script>
    <script type="text/javascript">
        $('#mycheckbox').change(function() {
            $('#mycheckboxdiv').toggle();
        });
    </script>
@endpush