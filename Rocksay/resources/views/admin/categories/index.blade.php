@extends('admin.layouts.app', ['activePage' => 'categories', 'title' => 'Categorias - Gerenciar', 'navName' => 'Gerenciar Categorias de Produtos', 'activeButton' => 'laravel'])

@section('content')                 
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card data-tables" style="flex-direction: inherit; flex-wrap: wrap">

                    {{-- Formulário de Cadastro/Atualização --}}
                    <div class="col-md-6">
                        <div class="col-12 card-body">
                            @if(!empty($category))
                                <h3 class="mt-0 top-title"><i class="fab fa-pied-piper-hat"></i> Editar Categoria <a href="{{ route('categorias') }}" title="Voltar para cadastros" class="btn btn-ces"><i class="fas fa-undo"></i></a></h3>
                            @else
                                <h3 class="mt-0 top-title"><i class="fab fa-pied-piper-hat"></i> Cadastrar Categoria</h3>
                            @endif
                        </div>
                        <form method="post" @if(!empty($category)) action="{{ route('categorias.atualizacao') }}" @else action="{{ route('categorias.cadastro') }}" @endif autocomplete="off" enctype="multipart/form-data">
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

                        @if(!empty($category))
                            <input type="text" name="id" value="{{ $category->id ?? old('id') }}" hidden>
                            <input type="hidden" name="_method" value="put" />
                        @endif
                        <input type="text" name="user_id" value="{{ auth()->user()->id }}" hidden>
                        <input type="text" hidden id="position" name="position" value="{{ $max_position ?? 1 }}">

                        {{-- Título e texto --}}
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label class="form-control-label" for="input-name">
                                    {{ __('Nome da Categoria') }} <i class="text-danger">*</i>
                                </label>
                                <input type="text" name="name" id="input-name" class="form-control" value="{{ $category->name ?? old('name') }}" placeholder="Calças, Blusas, Cintos...">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label class="form-control-label" for="input-abstract">
                                    {{ __('Resumo da Categoria') }} <i class="text-danger">*</i>
                                </label>
                                <input type="text" name="abstract" id="input-abstract" class="form-control" value="{{ $category->abstract ?? old('abstract') }}" placeholder="Conheça nossa linha completa de Calças">
                            </div>
                        </div>

                        @if(!empty($category))
                            <div class="row">
                                @if (!empty($category->image))
                                    <div class="col-md-6 form-group">
                                        <label class="form-control-label" for="input-start_date">
                                            {{ __('Imagem:') }} <i class="text-danger">*</i>
                                        </label><br>
                                        <img src="/images/categories/{{ $category->image }}" style="max-width: 100%">
                                        <br><br>
                                        <input type="file" data-id="{{ $category->id }}" id="categoryimage" name="categoryimage" class="form-control">
                                    </div>
                                @endif
                            </div>
                        @endif

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
                                Categorias Cadastrados
                                <a href="{{ route('categorias') }}" title="Recarregar Categorias" class="btn btn-ces"><i class="fas fa-sync"></i></a>
                            </h3>
                        </div>
                        <table class="table table-hover table-stripeds">
                            <thead>
                                <tr class="col-md-12">
                                    <td class="col-md-8"><b>Nome</b></td>
                                    <td style="display: block">
                                    </td>
                                </tr>
                            </thead>
                            <tbody id="tablecontents">
                                @foreach ($categories as $item)
                                    <tr class="row1" data-id="{{ $item->id }}" style="cursor: n-resize" title="Clique e arraste para reordenar...">
                                        @if (!$item->image)
                                            <td class="table-center" title="{{ $item->name }}">
                                                Imagem : <input type="file" data-id="{{ $item->id }}" id="categoryimage" name="categoryimage" class="form-control">
                                                @php $item_id = $item->id @endphp
                                            </td>
                                        @else
                                            <td>{{ $item->name }}</td>
                                        @endif
                                        <td class="d-flex justify-content-end">                                            
                                            @if($item->status == 1)                                            
                                                <a href="{{ route('categorias.alternar', $item->id) }}" title="Desativar Categoria" class="btn btn-sm button-admin-toggle-success"><i class="fas fa-user-check"></i></a>
                                            @else
                                                <a href="{{ route('categorias.alternar', $item->id) }}" title="Ativar Categoria" class="btn btn-sm button-admin-toggle-danger"><i class="fas fa-user-times"></i></a>
                                            @endif
                                            <input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}">
                                            <a href="{{ route('categorias.edicao', $item->id) }}" title="Editar Categoria" class="btn btn-sm button-admin-edit"><i class="fas fa-marker"></i></a>
                                            <a href="{{ route('categorias.deletar', $item->id) }}" title="Deletar Categoria" class="btn btn-sm delete-confirm button-admin-delete"><i class="fas fa-trash-alt"></i></a>
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
        $('#categoryimage').ijaboCropTool({
          preview : '.image-previewer',
          setRatio:400/400,
          allowedExtensions: ['jpg', 'jpeg','png'],
          buttonsText:['CORTAR E SALVAR','SAIR/CANCELAR'],
          buttonsColor:['#30bf7d','#ee5155', -15],
          processUrl:"{{ route('categorias.cortar', $item_id) }}",
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
                title: 'Realmente deseja apagar esta Categoria?',
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
                    'Categoria não deletada!',
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
               url: "{{ url('gerenciar/categorias/reposicionar') }}",
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