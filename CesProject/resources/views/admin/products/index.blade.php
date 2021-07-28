@extends('admin.layouts.app', ['activePage' => 'products', 'title' => 'Produtos - Gerenciar', 'navName' => 'Gerenciar Produtos da Loja', 'activeButton' => 'laravel'])

@section('content')                 
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card data-tables" style="flex-direction: inherit; flex-wrap: wrap">

                    {{-- Títulos para os campos da página --}}
                    <div class="card-header col-md-12">
                        <div class="row align-items-center">
                            <div class="col-6">
                                @if(!empty($item->title))
                                    <h3 class="mt-0 top-title"><i class="fas fa-tshirt"></i> Editar Produto <a href="{{ route('produtos') }}" title="Voltar para cadastros" class="btn btn-ces"><i class="fas fa-undo"></i></a></h3>
                                @else
                                    <h3 class="mt-0 top-title"><i class="fas fa-tshirt"></i> Cadastrar Produto</h3>
                                @endif
                            </div>
                            <div class="col-6">
                                <h3 class="mt-0 top-title"><i class="fas fa-clipboard-list"></i> 
                                    Produtos Cadastrados
                                    <a href="{{ route('produtos') }}" title="Recarregar Produtos" class="btn btn-ces"><i class="fas fa-sync"></i></a>
                                </h3>
                            </div>
                        </div>
                    </div>

                    {{-- Formulário de Cadastro/Atualização --}}
                    <div class="col-md-6">
                        <form method="post" @if(!empty($item->title)) action="{{ route('produtos.atualizacao') }}" @else action="{{ route('produtos.cadastro') }}" @endif autocomplete="off" enctype="multipart/form-data">
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

                        {{-- Título e preços --}}
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label class="form-control-label" for="input-title">
                                    {{ __('Título do Produto') }} <i class="text-danger">*</i>
                                </label>
                                <input type="text" name="title" id="input-title" maxlength="100" class="form-control" value="{{ $item->title ?? old('title') }}" placeholder="T-shirt Tananana Rocket Line super fashion e taus...">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label class="form-control-label" for="input-price">
                                    {{ __('Preço do Produto') }} <i class="text-danger">*</i>
                                </label>
                                <input value="{{ $item->price ?? old('price') }}" maxlength="45" type="text" name="price" class="form-control" placeholder="Ex: R$120,90">
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="form-control-label" for="input-price_promo">
                                    {{ __('Preço Promocional') }}
                                </label>
                                <input value="{{ $item->price_promo ?? old('price_promo') }}" maxlength="45" type="text" name="price_promo"class="form-control" placeholder="Ex: R$105,90">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label class="form-control-label" for="input-prazo">
                                    {{ __('Valor a Prazo') }}
                                </label>
                                <input value="{{ $item->prazo ?? old('prazo') }}" maxlength="50" type="text" name="prazo" class="form-control" placeholder="Ex: Ou parcele em até 3x de 39,90 no cartão de crédito...">
                            </div>
                        </div>
                        {{-- Resumo --}}
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label class="form-control-label" for="input-abstract">
                                    {{ __('Resumo sobre o Produto') }}
                                </label>
                                <input value="{{ $item->abstract ?? old('abstract') }}" maxlength="250" type="text" id="summary-ckeditor" name="abstract" class="form-control" placeholder="Ex: Este lindo modelo pode ser combinado com...">
                            </div>
                        </div>

                        {{-- Tamanhos e Autor da Foto Principal --}}
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label class="form-control-label" for="input-sizes">
                                    {{ __('Tamanhos Disponíveis') }}
                                </label>
                                <input type="text" name="sizes" id="input-sizes" class="form-control" value="{{ $item->sizes ?? old('sizes') }}"  placeholder="U, PP, P, M, G, GG...">
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="form-control-label" for="input-photo_name">
                                    {{ __('Autor da Foto') }}
                                </label>
                                <input type="text" maxlength="150" name="photo_name" id="input-photo_name" class="form-control" value="{{ $item->photo_name ?? old('photo_name') }}"  placeholder="Ex: Kamila P. B. Muller">
                            </div>
                        </div>
                        <div class="row">
                            @if(!empty($item->title))
                                @if (!empty($item->image))
                                    <div class="col-md-6 form-group">
                                        <label class="form-control-label" for="input-start_date">
                                            {{ __('Imagem:') }} <i class="text-danger">*</i>
                                        </label><br>
                                        <img src="/images/products/product/{{ $item->image }}" style="max-width: 100%">
                                        <br><br>
                                        <input type="file" data-id="{{ $item->id }}" id="productimage" name="productimage" class="form-control">
                                    </div>
                                @endif
                            @endif
                        </div>

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
                                    <td class="col-md-5"><b>Título</b></td>
                                    <td class="col-md-3"><b>Imagem</b></td>
                                    <td style="display: block">
                                    </td>
                                </tr>
                            </thead>
                            <tbody id="tablecontents">
                                @foreach ($itens as $item)
                                    <tr class="row1" data-id="{{ $item->id }}">
                                        @if (!$item->image)
                                            <td>{{$item->title}}</td>
                                            <td class="table-center" title="{{ $item->title }}">
                                                Imagem : <input type="file" data-id="{{ $item->id }}" id="productimage" name="productimage" class="form-control">
                                                @php $item_id = $item->id @endphp
                                            </td>
                                        @else
                                            <td>{{$item->title}}</td>
                                            <td title="{{ $item->name }}" ><img src="/images/products/product/{{ $item->image }}" width="80px"></td>
                                        @endif
                                        <td style="display: block">                                            
                                            @if($item->highlight == 1)                                            
                                                <a href="{{ route('produtos.destaque', $item->id) }}" title="Remover Destaque" class="btn btn-sm button-admin-highlight-true"><i class="fas fa-star"></i></a>
                                            @else
                                                <a href="{{ route('produtos.destaque', $item->id) }}" title="Destacar Produto" class="btn btn-sm button-admin-highlight-false"><i class="fas fa-tshirt"></i></a>
                                            @endif
                                            @if($item->status == 1)                                            
                                                <a href="{{ route('produtos.alternar', $item->id) }}" title="Desativar Produto" class="btn btn-sm button-admin-toggle-success"><i class="fas fa-user-check"></i></a>
                                            @else
                                                <a href="{{ route('produtos.alternar', $item->id) }}" title="Ativar Produto" class="btn btn-sm button-admin-toggle-danger"><i class="fas fa-user-times"></i></a>
                                            @endif
                                            <input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}">
                                            <a href="{{ route('produtos.cores', $item->id) }}" title="Cadastrar Cores para este Produto" class="btn btn-sm button-admin-colors"><i class="fas fa-palette"></i></a><br>
                                            <a href="{{ route('produtos.galeria', $item->id) }}" title="Cadastrar Galeria para este Produto" class="btn btn-sm button-admin-gallery"><i class="fas fa-image"></i></a>
                                            <a href="{{ route('produtos.edicao', $item->id) }}" title="Editar Produto" class="btn btn-sm button-admin-edit"><i class="fas fa-marker"></i></a>
                                            <a href="{{ route('produtos.deletar', $item->id) }}" title="Deletar Produto" class="btn btn-sm delete-confirm button-admin-delete"><i class="fas fa-trash-alt"></i></a>
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
        $('#productimage').ijaboCropTool({
          preview : '.image-previewer',
          setRatio:1400/1400,
          allowedExtensions: ['jpg', 'jpeg','png'],
          buttonsText:['CORTAR E SALVAR','SAIR/CANCELAR'],
          buttonsColor:['#30bf7d','#ee5155', -15],
          processUrl:"{{ route('produtos.cortar', $item_id) }}",
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
                title: 'Realmente deseja apagar este Produto?',
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
                    'Produto não deletado!',
                    'error'
                    )
                }
            });
        });
    </script>
@endpush