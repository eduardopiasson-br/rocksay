@extends('admin.layouts.app', ['activePage' => 'feedback', 'title' => 'Feedback - Gerenciar', 'navName' => 'Gerenciar Feedback', 'activeButton' => 'laravel'])

@section('content')                 
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card data-tables" style="flex-direction: inherit; flex-wrap: wrap">

                    <div class="card-header col-md-12">
                        <div class="row align-items-center">
                            <div class="col-12">
                                @if(!empty($feed->name))
                                    <h3 class="mt-0 top-title"><i class="fas fa-comments"></i> Editar Feedback <a href="{{ route('feedback') }}" title="Voltar para cadastros" class="btn btn-ces"><i class="fas fa-undo"></i></a></h3>
                                @else
                                    <h3 class="mt-0 top-title"><i class="fas fa-comments"></i> Cadastrar Feedback</h3>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <form method="post" @if(!empty($feed->name)) action="{{ route('feedback.atualizacao') }}" @else action="{{ route('feedback.cadastro') }}" @endif autocomplete="off" enctype="multipart/form-data">
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

                        @if(!empty($feed->name))
                            <input type="text" name="id" value="{{ $feed->id ?? old('id') }}" hidden>
                            <input type="hidden" name="_method" value="put" />
                        @endif

                        <input type="text" hidden id="position" name="position" value="{{ $max_position ?? 1 }}">
                        <input type="text" name="user_id" value="{{ auth()->user()->id }}" hidden>
                        <div class="row">
                            <div class="col-md-3 form-group">
                                <label class="form-control-label" for="input-name">
                                    {{ __('Nome') }} <i class="text-danger">*</i>
                                </label>
                                <input type="text" name="name" id="input-name" class="form-control" value="{{ $feed->name ?? old('name') }}"  placeholder="Nome da pessoa que mandou o feedback...">
                            </div>
                            @if(empty($feed->image))
                                <div class="col-md-9 form-group">
                                    <label class="form-control-label" for="input-text">
                                        {{ __('Feedback Texto') }}
                                    </label>
                                    <textarea type="text" id="text" name="text" class="form-control" maxlength="300" placeholder="Feedback descritivo...">{{ $feed->text ?? old('text') }}</textarea>
                                </div>
                            @endif
                            @if(!empty($feed->image))
                                <div class="col-md-9 form-group div-image-about">
                                    <label>Imagem Cadastrada:</label>
                                    <img src="/images/feedback/{{ $feed->image }}" width="400px">
                                </div>
                            @endif
                        </div>         
                        <div class="form-group d-flex justify-content-center">
                            <button type="submit" class="btn btn-success mr-1" title="Salvar Dados">Salvar</button>
                            <button type="reset" class="btn btn-warning ml-1" title="Restaurar Dados">Restaurar</button>
                        </div>
                        </form>
                    </div>
                    <hr class="hr-ces">

                    <div class="card-header col-md-12">
                        <div class="row align-items-center">
                            <div class="col-12">
                                <h3 class="mt-0 top-title"><i class="fas fa-clipboard-list"></i> 
                                    Feedback's Cadastrados
                                    <a href="{{ route('feedback') }}" title="Recarregar Feedback's" class="btn btn-ces"><i class="fas fa-sync"></i></a>
                                </h3>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-2"></div>
                    <div class="col-md-8 card-body table-full-width table-responsive table-ces">
                        <table class="table table-hover table-stripeds">
                            <thead>
                                <tr class="col-md-12">
                                    <td class="col-md-3"><b>Nome</b></td>
                                    <td class="col-md-6 table-center"><b>Texto/Imagem</b></td>
                                    <td style="display: block">
                                    </td>
                                </tr>
                            </thead>
                            <tbody id="tablecontents">
                                @foreach ($feedback as $feed)
                                    <tr class="row1" data-id="{{ $feed->id }}" style="cursor: n-resize" title="Clique e arraste para reordenar...">
                                        <td>{{ $feed->name }}</td>
                                        @if($feed->image != NULL)
                                            <td title="{{ $feed->name }}"class="table-center"><img src="/images/feedback/{{ $feed->image }}" width="100px"></td>
                                        @elseif ($feed->text != NULL)
                                            <td class="limit-text">{{$feed->text}}</td>
                                        @else
                                            <td class="table-center">
                                                <input type="file" data-id="{{ $feed->id }}" id="feedbackimage" name="feedbackimage" class="form-control" placeholder="Imagem Padrão">
                                                @php $item_id = $feed->id @endphp
                                            </td>
                                        @endif
                                        <td class="d-flex justify-content-end">
                                            @if($feed->status == 1)                                            
                                                <a href="{{ route('feedback.alternar', $feed->id) }}" title="Desativar Feedback" class="btn btn-sm button-admin-toggle-success"><i class="fas fa-user-check"></i></a>
                                            @else
                                                <a href="{{ route('feedback.alternar', $feed->id) }}" title="Ativar Feedback" class="btn btn-sm button-admin-toggle-danger"><i class="fas fa-user-times"></i></a>
                                            @endif
                                            <input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}">
                                            <a href="{{ route('feedback.edicao', $feed->id) }}" title="Editar Feedback" class="btn btn-sm button-admin-edit"><i class="fas fa-marker"></i></a>
                                            <a href="{{ route('feedback.deletar', $feed->id) }}" title="Deletar Feedback" class="btn btn-sm delete-confirm button-admin-delete"><i class="fas fa-trash-alt"></i></a>
                                        </td>                       
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-2"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
    <script type="text/javascript">
    // Crop image
        $('#feedbackimage').ijaboCropTool({
          preview : '.image-previewer',
          setRatio:1080/720,
          allowedExtensions: ['jpg', 'jpeg','png'],
          buttonsText:['CORTAR E SALVAR','SAIR/CANCELAR'],
          buttonsColor:['#30bf7d','#ee5155', -15],
          processUrl:"{{ route('feedback.cortar', $item_id) }}",
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
                title: 'Realmente deseja apagar este Feedback?',
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
                    'Feedback não deletada!',
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
            url: "{{ url('gerenciar/feedback/reposicionar') }}",
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