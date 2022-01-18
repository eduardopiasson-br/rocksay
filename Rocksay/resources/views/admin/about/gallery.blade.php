@extends('admin.layouts.app', ['activePage' => 'about', 'title' => 'Galeria do Sobre - Gerenciar', 'navName' => 'Gerenciar Galeria Sobre', 'activeButton' => 'laravel'])

@section('content')                 
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card data-tables" style="flex-direction: inherit; flex-wrap: wrap">

                    <div class="card-header col-md-12">
                        <div class="row align-items-center">
                            <div class="col-12">
                                @if(!empty($image))
                                    <h3 class="mt-0 top-title"><i class="far fa-images"></i> Editar Imagem <a href="{{ route('sobre.galeria') }}" title="Voltar para cadastros" class="btn btn-ces"><i class="fas fa-undo"></i></a></h3>
                                @else
                                    <h3 class="mt-0 top-title"><i class="far fa-images"></i> Cadastrar Imagens</h3>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <form method="post" @if(!empty($image)) action="{{ route('sobre.galeria.atualizacao') }}" @else action="{{ route('sobre.galeria.cadastro') }}" @endif autocomplete="off" enctype="multipart/form-data">
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

                        <input type="text" hidden id="position" name="position" value="{{ $max_position ?? 1 }}">
                        <input type="text" name="user_id" value="{{ auth()->user()->id }}" hidden>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label class="form-control-label" for="input-name">
                                    {{ __('Nome para a Imagem') }} <i class="text-danger">*</i>
                                </label>
                                <input type="text" name="name" id="input-name" class="form-control" value="{{ $image->name ?? old('name') }}"  placeholder="Ex: Começo dos Negócios, Primeira Confraternização da C&S...">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Imagem <i class="text-danger">*</i> :</label>
                                <input type="file" id="image" name="image" class="form-control" placeholder="Imagem Inauguraçao C&S">
                            </div>
                        </div>
                        @if(!empty($image))
                            <div class="row">
                                <div class="col-md-3"></div>
                                <div class="col-md-6 form-group div-image-about">
                                <img src="/images/about/{{ $image->image }}" width="400px">
                                </div>
                                <div class="col-md-3"></div>
                            </div>
                        @endif                
                        <div class="form-group d-flex justify-content-center">
                            <button type="submit" class="btn btn-success mr-1" title="Salvar Dados"><i class="fas fa-save"></i> Salvar</button>
                            <button type="reset" class="btn btn-warning ml-1" title="Restaurar Dados"><i class="fas fa-undo-alt"></i> Restaurar</button>
                        </div>
                        </form>
                    </div>
                    <hr class="hr-ces">

                    <div class="card-header col-md-12">
                        <div class="row align-items-center">
                            <div class="col-12">
                                <h3 class="mt-0 top-title"><i class="fas fa-clipboard-list"></i> 
                                    Imagens da Galeria
                                    <a href="{{ route('sobre.galeria') }}" title="Recarregar Imagens" class="btn btn-ces"><i class="fas fa-sync"></i></a>
                                </h3>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-12 card-body table-full-width table-responsive table-ces">
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
                                        <td>@if(!empty($image->name)){{ $image->name }}@else <i>* Sem Nome</i> @endif</td>
                                        <td title="{{ $image->name }}" ><img src="/images/about/{{ $image->image }}" width="100px"></td>
                                        <td class="d-flex justify-content-end">
                                            @if($image->status == 1)                                            
                                                <a href="{{ route('sobre.galeria.alternar', $image->id) }}" title="Desativar Imagem" class="btn btn-sm button-admin-toggle-success"><i class="fas fa-user-check"></i></a>
                                            @else
                                                <a href="{{ route('sobre.galeria.alternar', $image->id) }}" title="Ativar Imagem" class="btn btn-sm button-admin-toggle-danger"><i class="fas fa-user-times"></i></a>
                                            @endif
                                            <input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}">
                                            <a href="{{ route('sobre.galeria.edicao', $image->id) }}" title="Editar Imagem" class="btn btn-sm button-admin-edit"><i class="fas fa-marker"></i></a>
                                            <a href="{{ route('sobre.galeria.deletar', $image->id) }}" title="Deletar Imagem" class="btn btn-sm delete-confirm button-admin-delete"><i class="fas fa-trash-alt"></i></a>
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
            url: "{{ url('gerenciar/sobre/galeria/reposicionar') }}",
                data: {
                    _token: token,
                    order: order,
            },
            success: function(response) {
                location.reload();
            }
          });
        }
      });
    </script>
@endpush