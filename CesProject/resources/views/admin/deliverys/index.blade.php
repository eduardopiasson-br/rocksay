@extends('admin.layouts.app', ['activePage' => 'deliverys', 'title' => 'Entregas e Envios - Gerenciar', 'navName' => 'Gerenciar Formas de Entregas', 'activeButton' => 'laravel'])

@section('content')                 
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card data-tables" style="flex-direction: inherit; flex-wrap: wrap">

                    <div class="card-header col-md-12">
                        <div class="row align-items-center">
                            <div class="col-6">
                                @if(!empty($delivery))
                                    <h3 class="mt-0 top-title"><i class="fas fa-truck"></i> Editar Entrega/Envio <a href="{{ route('entregas') }}" title="Voltar para cadastros" class="btn btn-ces"><i class="fas fa-undo"></i></a></h3>
                                @else
                                    <h3 class="mt-0 top-title"><i class="fas fa-truck"></i> Cadastrar Entrega/Envio</h3>
                                @endif
                            </div>
                            <div class="col-6">
                                <h3 class="mt-0 top-title"><i class="fas fa-clipboard-list"></i> 
                                    Tipos de Entrega e Envios
                                    <a href="{{ route('entregas') }}" title="Recarregar Entregas" class="btn btn-ces"><i class="fas fa-sync"></i></a>
                                </h3>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <form method="post" @if(!empty($delivery)) action="{{ route('entregas.atualizacao') }}" @else action="{{ route('entregas.cadastro') }}" @endif autocomplete="off" enctype="multipart/form-data">
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

                        @if(!empty($delivery))
                            <input type="text" name="id" value="{{ $delivery->id ?? old('id') }}" hidden>
                            <input type="hidden" name="_method" value="put" />
                        @endif

                        <input type="text" hidden id="position" name="position" value="{{ $max_position ?? 1 }}">
                        <input type="text" name="user_id" value="{{ auth()->user()->id }}" hidden>
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label class="form-control-label" for="input-icon">
                                    Ícone <i class="text-danger">*</i>
                                    <a href="https://fontawesome.com/v5.15/icons?d=gallery&p=1&m=free"
                                        title="Clique para ver a lista de icones">
                                        Selecionar Ícone <i class="fas fa-external-link-alt"></i>
                                    </a>
                                </label>
                                <input type="text" name="icon" id="input-icon"
                                    value="{{ $delivery->icon ?? old('icon') }}" class="form-control"
                                    placeholder="Escolha o icone no link acima">                            
                            </div>
                        </div>      
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label class="form-control-label" for="input-name">
                                    {{ __('Descrição da Entrega') }} <i class="text-danger">*</i>
                                </label>
                                <textarea type="text" name="text" id="input-text" class="form-control" placeholder="Descreva a forma de entrega...">{{ $delivery->text ?? old('text') }}</textarea>
                            </div>
                        </div>      
                        <br>   
                        <div class="form-group">
                            <button type="submit" class="btn btn-success mr-1" title="Salvar Dados">Salvar</button>
                            <button type="reset" class="btn btn-warning ml-1" title="Restaurar Dados">Restaurar</button>
                        </div>
                        </form>
                    </div>                    
                    <div class="col-md-6 card-body table-full-width table-responsive table-ces">
                        <table class="table table-hover table-stripeds">
                            <thead>
                                <tr class="col-md-12">
                                    <td></td>
                                    <td class="col-md-9"><b>Descrição</b></td>
                                    <td style="display: block">
                                    </td>
                                </tr>
                            </thead>
                            <tbody id="tablecontents">
                                @foreach ($deliverys as $delivery)
                                    <tr class="row1" data-id="{{ $delivery->id }}" style="cursor: n-resize" title="Clique e arraste para reordenar...">
                                        <td class="limit-icon"><?= $delivery->icon ?></td>
                                        <td class="limit-text">{{$delivery->text}}</td>
                                        <td class="d-flex justify-content-end">
                                            @if($delivery->status == 1)                                            
                                                <a href="{{ route('entregas.alternar', $delivery->id) }}" title="Desativar Entrega" class="btn btn-sm button-admin-toggle-success"><i class="fas fa-user-check"></i></a>
                                            @else
                                                <a href="{{ route('entregas.alternar', $delivery->id) }}" title="Ativar Entrega" class="btn btn-sm button-admin-toggle-danger"><i class="fas fa-user-times"></i></a>
                                            @endif
                                            <input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}">
                                            <a href="{{ route('entregas.edicao', $delivery->id) }}" title="Editar Entrega" class="btn btn-sm button-admin-edit"><i class="fas fa-marker"></i></a>
                                            <a href="{{ route('entregas.deletar', $delivery->id) }}" title="Deletar Entrega" class="btn btn-sm delete-confirm button-admin-delete"><i class="fas fa-trash-alt"></i></a>
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
                title: 'Realmente deseja apagar esta Entrega?',
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
                    'Entrega não deletada!',
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
            url: "{{ url('gerenciar/entregas/reposicionar') }}",
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
@endpush