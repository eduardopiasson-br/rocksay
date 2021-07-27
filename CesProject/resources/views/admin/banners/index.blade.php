@extends('admin.layouts.app', ['activePage' => 'banners', 'title' => 'Banners - Gerenciar', 'navName' => 'Gerenciar Banners', 'activeButton' => 'laravel'])

@section('content')                 
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card data-tables" style="flex-direction: inherit; flex-wrap: wrap">

                    <div class="card-header col-md-12">
                        <div class="row align-items-center">
                            <div class="col-6">
                                @if(!empty($banner->name))
                                    <h3 class="mt-0 top-title"><i class="fas fa-handshake"></i> Editar Banner <a href="{{ route('banners') }}" title="Voltar para cadastros" class="btn btn-ces"><i class="fas fa-undo"></i></a></h3>
                                @else
                                    <h3 class="mt-0 top-title"><i class="fas fa-handshake"></i> Cadastrar Banner</h3>
                                @endif
                            </div>
                            <div class="col-6">
                                <h3 class="mt-0 top-title"><i class="fas fa-clipboard-list"></i> 
                                    Banners Cadastrados
                                    <a href="{{ route('banners') }}" title="Recarregar Banners" class="btn btn-ces"><i class="fas fa-sync"></i></a>
                                </h3>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <form method="post" @if(!empty($banner->name)) action="{{ route('banners.atualizacao') }}" @else action="{{ route('banners.cadastro') }}" @endif autocomplete="off" enctype="multipart/form-data">
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

                        @if(!empty($banner->name))
                            <input type="text" name="id" value="{{ $banner->id ?? old('id') }}" hidden>
                            <input type="hidden" name="_method" value="put" />
                        @endif

                        <input type="text" hidden id="position" name="position" value="{{ $max_position ?? 1 }}">
                        <input type="text" name="user_id" value="{{ auth()->user()->id }}" hidden>
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label class="form-control-label" for="input-name">
                                    {{ __('Nome') }} <i class="text-danger">*</i>
                                </label>
                                <input type="text" name="name" id="input-name" class="form-control" value="{{ $banner->name ?? old('name') }}"  placeholder="Nome do parceiro ou da empresa promovida...">
                            </div>
                        </div> 
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label class="form-control-label" for="input-whatsapp">
                                    {{ __('WhatsApp') }}
                                </label>
                                <input type="textbtn btn-sm " name="whatsapp" id="input-whatsapp" maxlength="14" class="form-control" value="{{ $banner->whatsapp ?? old('whatsapp') }}"  placeholder="Ex: (45)99849-1539">
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="form-control-label" for="input-facebook">
                                    {{ __('Facebook') }}
                                </label>
                                <input type="url" name="facebook" id="input-facebook" class="form-control" value="{{ $banner->facebook ?? old('facebook') }}"  placeholder="Link para o Facebook">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label class="form-control-label" for="input-instagram">
                                    {{ __('Instagram') }}
                                </label>
                                <input type="url" name="instagram" id="input-instagram" class="form-control" value="{{ $banner->instagram ?? old('instagram') }}"  placeholder="Link para o Instagram">
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="form-control-label" for="input-site">
                                    {{ __('Site') }}
                                </label>
                                <input type="url" name="site" id="input-site" class="form-control" value="{{ $banner->site ?? old('site') }}" placeholder="Link para o Site">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label class="form-control-label" for="input-start_date">
                                    {{ __('Data Inicial') }} <i class="text-danger">*</i>
                                </label>
                                <input type="date" name="start_date" id="input-start_date" class="form-control" value="{{ $banner->start_date ?? old('start_date') }}"  placeholder="00/00/0000">
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="form-control-label" for="input-end_date">
                                    {{ __('Data Final') }}
                                </label>
                                <input type="date" name="end_date" id="input-end_date" class="form-control" value="{{ $banner->end_date ?? old('end_date') }}" placeholder="00/00/0000">
                            </div>
                        </div>
                        @if(!empty($banner->name))
                        <div class="row">
                            @if (!empty($banner->image_desktop))
                                <div class="col-md-6 form-group">
                                    <label class="form-control-label" for="input-start_date">
                                        {{ __('Imagem PC:') }} <i class="text-danger">*</i>
                                    </label><br>
                                    <img src="/images/banners/desktop/{{ $banner->image_desktop }}" style="max-width: 70%">
                                    <br><br>
                                    <input type="file" data-id="{{ $banner->id }}" id="bannerdesktopimage" name="bannerdesktopimage" class="form-control">
                                </div>
                            @endif
                            @if (!empty($banner->image_mobile))
                                <div class="col-md-6 form-group">
                                    <label class="form-control-label" for="input-end_date">
                                        {{ __('Imagem Celular:') }} <i class="text-danger">*</i>
                                    </label><br>
                                    <img src="/images/banners/mobile/{{ $banner->image_mobile }}" style="max-width: 100%">
                                    <br><br>
                                    <input type="file" data-id="{{ $banner->id }}" id="bannermobileimage" name="bannermobileimage" class="form-control">
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
                    
                    <div class="col-md-6 card-body table-full-width table-responsive table-ces">
                        <table class="table table-hover table-stripeds">
                            <thead>
                                <tr class="col-md-12">
                                    <td class="col-md-8"><b>Nome</b></td>
                                    <td style="display: block">
                                    </td>
                                </tr>
                            </thead>
                            <tbody id="tablecontents">
                                @foreach ($banners as $banner)
                                    <tr class="row1" data-id="{{ $banner->id }}" style="cursor: n-resize" title="Clique e arraste para reordenar...">
                                        @if (!$banner->image_desktop)
                                            <td class="table-center" title="{{ $banner->name }}">
                                                Banner PC: <input type="file" data-id="{{ $banner->id }}" id="bannerdesktopimage" name="bannerdesktopimage" class="form-control" placeholder="Imagem Padrão">
                                                @php $item_id = $banner->id @endphp
                                            </td>
                                        @elseif (!$banner->image_mobile)
                                            <td class="table-center" title="{{ $banner->name }}">
                                                Banner Celular: <input type="file" data-id="{{ $banner->id }}" id="bannermobileimage" name="bannermobileimage" class="form-control" placeholder="Imagem Padrão">
                                                @php $item_id = $banner->id @endphp
                                            </td>
                                        @else
                                            <td>{{ $banner->name }}</td>
                                        @endif
                                        <td class="d-flex justify-content-end">
                                            @if($banner->status == 1)                                            
                                                <a href="{{ route('banners.alternar', $banner->id) }}" title="Desativar Banner" class="btn btn-sm button-admin-toggle-success"><i class="fas fa-user-check"></i></a>
                                            @else
                                                <a href="{{ route('banners.alternar', $banner->id) }}" title="Ativar Banner" class="btn btn-sm button-admin-toggle-danger"><i class="fas fa-user-times"></i></a>
                                            @endif
                                            <input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}">
                                            <a href="{{ route('banners.edicao', $banner->id) }}" title="Editar Banner" class="btn btn-sm button-admin-edit"><i class="fas fa-marker"></i></a>
                                            <a href="{{ route('banners.deletar', $banner->id) }}" title="Deletar Banner" class="btn btn-sm delete-confirm button-admin-delete"><i class="fas fa-trash-alt"></i></a>
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
        $('#bannerdesktopimage').ijaboCropTool({
          preview : '.image-previewer',
          setRatio:400/600,
          allowedExtensions: ['jpg', 'jpeg','png'],
          buttonsText:['CORTAR E SALVAR','SAIR/CANCELAR'],
          buttonsColor:['#30bf7d','#ee5155', -15],
          processUrl:"{{ route('banners.cortar.desktop', $item_id) }}",
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
        // Crop image mobile
        $('#bannermobileimage').ijaboCropTool({
          preview : '.image-previewer',
          setRatio:500/200,
          allowedExtensions: ['jpg', 'jpeg','png'],
          buttonsText:['CORTAR E SALVAR','SAIR/CANCELAR'],
          buttonsColor:['#30bf7d','#ee5155', -15],
          processUrl:"{{ route('banners.cortar.mobile', $item_id) }}",
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
                title: 'Realmente deseja apagar este Banner?',
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
                    'Banner não deletada!',
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
            url: "{{ url('gerenciar/banners/reposicionar') }}",
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