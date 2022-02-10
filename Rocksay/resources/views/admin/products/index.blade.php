@extends('admin.layouts.app', ['activePage' => 'products', 'title' => 'Produtos - Gerenciar', 'navName' => 'Gerenciar
Produtos da Loja', 'activeButton' => 'laravel'])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card data-tables" style="flex-direction: inherit; flex-wrap: wrap">

                        {{-- Formulário de Cadastro/Atualização --}}
                        <div class="col-md-12" id="div-form">
                            <div class="col-12 card-body">
                                @if (!empty($item->title))
                                    <h3 class="mt-0 top-title"><i class="fas fa-tshirt"></i> Editar Produto <a
                                            href="{{ route('produtos') }}" title="Voltar para cadastros"
                                            class="btn btn-ces"><i class="fas fa-undo"></i></a></h3>
                                @else
                                    <h3 class="mt-0 top-title"><i class="fas fa-tshirt"></i> Cadastrar Produto
                                        <button class="btn btn-secondary" id="cancelar-cadastro">Cancelar</button>
                                    </h3>
                                @endif
                            </div>
                            <form method="post" @if (!empty($item->title)) action="{{ route('produtos.atualizacao') }}" @else action="{{ route('produtos.cadastro') }}" @endif autocomplete="off" id="form"
                                enctype="multipart/form-data">
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

                                @if (!empty($item->title))
                                    <input type="text" name="id" value="{{ $item->id ?? old('id') }}" hidden>
                                    <input type="hidden" name="_method" value="put" />
                                @endif
                                <input type="text" name="user_id" value="{{ auth()->user()->id }}" hidden>

                                {{-- Título e preços --}}
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label class="form-control-label" for="input-title">
                                            {{ __('Título do Produto') }} <i class="text-danger">*</i>
                                        </label>
                                        <input type="text" name="title" id="input-title" maxlength="100"
                                            class="form-control" value="{{ $item->title ?? old('title') }}"
                                            placeholder="T-shirt Tananana Rocket Line super fashion e taus...">
                                    </div>
                                    <div class="col-md-2 form-group">
                                        <label class="form-control-label" for="input-units">
                                            {{ __('Unidades') }} <i class="text-danger">*</i>
                                        </label>
                                        <input value="{{ $item->units ?? old('units') }}" type="number" name="units"
                                            class="form-control" placeholder="Ex: 3">
                                    </div>
                                    <div class="col-md-2 form-group">
                                        <label class="form-control-label" for="input-price">
                                            {{ __('Preço do Produto') }} <i class="text-danger">*</i>
                                        </label>
                                        <input value="{{ $item->price ?? old('price') }}" maxlength="45" type="text"
                                            name="price" class="form-control" placeholder="Ex: R$120,90">
                                    </div>
                                    <div class="col-md-2 form-group">
                                        <label class="form-control-label" for="input-price_promo">
                                            {{ __('Preço Promocional') }}
                                        </label>
                                        <input value="{{ $item->price_promo ?? old('price_promo') }}" maxlength="45"
                                            type="text" name="price_promo" class="form-control"
                                            placeholder="Ex: R$105,90">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 form-group">
                                        <label class="form-control-label" for="input-prazo">
                                            {{ __('Valor a Prazo') }}
                                        </label>
                                        <input value="{{ $item->prazo ?? old('prazo') }}" maxlength="50" type="text"
                                            name="prazo" class="form-control"
                                            placeholder="Ex: Ou parcele em até 3x de 39,90 no cartão de crédito...">
                                    </div>
                                    <div class="col-md-8 form-group">
                                        <label class="form-control-label" for="input-abstract">
                                            {{ __('Resumo sobre o Produto') }}
                                        </label>
                                        <textarea maxlength="250" type="text" name="abstract" class="form-control"
                                            placeholder="Ex: Este lindo modelo pode ser combinado com...">{{ $item->abstract ?? old('abstract') }}</textarea>
                                    </div>
                                </div>

                                {{-- Tamanhos e Autor da Foto Principal --}}
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label class="form-control-label" for="input-sizes">
                                            {{ __('Tamanhos Disponíveis') }}
                                        </label>
                                        <input type="text" name="sizes" id="input-sizes" class="form-control"
                                            value="{{ $item->sizes ?? old('sizes') }}"
                                            placeholder="U, PP, P, M, G, GG...">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="form-control-label" for="input-photo_name">
                                            {{ __('Autor da Foto') }}
                                        </label>
                                        <input type="text" maxlength="150" name="photo_name" id="input-photo_name"
                                            class="form-control" value="{{ $item->photo_name ?? old('photo_name') }}"
                                            placeholder="Ex: Kamila P. B. Muller">
                                    </div>
                                </div>
                                <div class="row">
                                    @if (!empty($item->title))
                                        @if (!empty($item->image))
                                            <div class="col-md-6 form-group">
                                                <label class="form-control-label" for="input-start_date">
                                                    {{ __('Imagem:') }} <i class="text-danger">*</i>
                                                </label><br>
                                                <img src="/images/products/product/{{ $item->image }}"
                                                    style="max-width: 100%">
                                                <br><br>
                                                <input type="file" data-id="{{ $item->id }}" id="productimage"
                                                    name="productimage" class="form-control">
                                            </div>
                                        @else 
                                            <div class="col-md-6">
                                                <td class="table-center" title="{{ $item->title }}">
                                                    Imagem : <input type="file" data-id="{{ $item->id }}"
                                                        id="productimage" name="productimage" class="form-control">
                                                </td>
                                            </div>
                                        @endif
                                    @endif
                                    @if (!empty($item->title))
                                        @if (!empty($item->measurements))
                                            <div class="col-md-6 form-group">
                                                <label class="form-control-label" for="input-start_date">
                                                    {{ __('Imagem:') }} <i class="text-danger">*</i>
                                                </label><br>
                                                <img src="/images/products/measurements/{{ $item->measurements }}"
                                                    style="max-width: 100%">
                                                <br><br>
                                                <input type="file" data-id="{{ $item->id }}" id="measurements"
                                                    name="measurements" class="form-control">
                                            </div>
                                        @else 
                                            <div class="col-md-6">
                                                <td class="table-center" title="{{ $item->title }}">
                                                    Imagem : <input type="file" data-id="{{ $item->id }}"
                                                        id="measurements" name="measurements" class="form-control">
                                                </td>
                                            </div>
                                        @endif
                                    @endif
                                </div>
                                {{-- Categorias --}}
                                @if ($categories->count() > 0)
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label class="form-control-label" for="input">
                                                {{ __('Marque as Categorias Relacionadas') }}<br><br>
                                                @foreach ($categories as $category)
                                                    <div class="div-checkbox">
                                                        <input type="checkbox" class="checkbox-admin" name="categories[]"
                                                            id="categories{{ $category->id }}"
                                                            value="{{ $category->id }}" @if (!empty($item))
                                                        {{ in_array($category->id, old('categories', $item->categories->pluck('id')->toArray())) ? ' checked' : '' }}
                                                @endif
                                                > &nbsp <label class="checkbox-name-admin"
                                                    for="categories{{ $category->id }}">{{ $category->name }}</label>
                                        </div>
                                @endforeach
                                </label>
                        </div>
                    </div>
                    @endif

                    <hr class="hr-ces">
                    <div class="form-group">
                        <button type="submit" class="btn btn-success mr-1" title="Salvar Dados">Salvar</button>
                        <button type="reset" class="btn btn-warning ml-1" title="Restaurar Dados">Restaurar</button>
                    </div>
                    </form>
                </div>

                <div class="col-md-12 table-full-width table-responsive table-ces" id="listagem">
                    <div class="col-12 card-body">
                        <h3 class="mt-0 top-title"><i class="fas fa-clipboard-list"></i>
                            Produtos Cadastrados
                            @if (!empty($itens[0]))<a href="{{ route('produtos') }}" title="Recarregar Produtos" class="btn btn-ces"><i class="fas fa-sync"></i></a>@endif
                            @if (empty($item->title)) <button class="btn btn-primary" id="cadastrar-product">Cadastrar Produto</button>@endif
                        </h3>
                    </div>
                    @if (!empty($itens[0]))
                        <table id="products" class="table table-hover table-stripeds" style="width:100%!important">
                            <thead>
                                <tr class="col-md-12">
                                    <td class="col-md-1 text-center"><b>#</b></td>
                                    <td class="col-md-5"><b>Título</b></td>
                                    <td class="col-md-1 text-center"><b>Preço</b></td>
                                    <td class="col-md-1 text-center"><b>Estoque</b></td>
                                    <td class="col-md-1 text-center"><b>Imagem</b></td>
                                    <td class="col-md-2">
                                    </td>
                                </tr>
                            </thead>
                            <tbody id="tablecontents">
                                @foreach ($itens as $index => $product)
                                    <tr class="row1" data-id="{{ $product->id }}">
                                        <td class="text-center">{{ $index }}</td>
                                        <td>{{ $product->title }}</td>
                                        <td class="text-center">{{ !empty($product->price_promo) ? trim($product->price_promo) : $product->price }}</td>
                                        <td class="text-center">{{ $product->units }}</td>
                                        @if (!$product->image)
                                            <td class="table-center text-danger" title="{{ $product->title }}">
                                                Cadastre a Imagem do Produto
                                            </td>
                                        @else
                                            <td style="text-align: center" title="{{ $product->title }}"><img
                                                    src="/images/products/product/{{ $product->image }}" width="80px">
                                            </td>
                                        @endif
                                        <td style="display: block; float: right;">
                                            @if ($product->status == 1)
                                                <a href="{{ route('produtos.alternar', $product->id) }}"
                                                    title="Desativar Produto"
                                                    class="btn btn-sm button-admin-toggle-success"><i
                                                        class="fas fa-user-check"></i></a>
                                            @else
                                                <a @if(!empty($product->image)) href="{{ route('produtos.alternar', $product->id) }}" @else href="" @endif
                                                    @if (!$product->image) disabled @endif
                                                    title="Ativar Produto" class="btn btn-sm button-admin-toggle-danger"><i
                                                        class="fas fa-user-times"></i></a>
                                            @endif
                                            <input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}">
                                            <a href="{{ route('produtos.cores', $product->id) }}"
                                                title="Cadastrar Cores para este Produto"
                                                class="btn btn-sm button-admin-colors"><i class="fas fa-palette"></i></a>
                                            <a href="{{ route('produtos.edicao', $product->id) }}" title="Editar Produto"
                                                class="btn btn-sm button-admin-edit"><i class="fas fa-marker"></i></a>
                                            <br>
                                            @if ($product->units != 0)
                                                <a href="{{ route('produtos.estoque', $product->id) }}"
                                                    title="Marcar como 'Sem Estoque'"
                                                    class="btn btn-sm button-admin-highlight-true"><i
                                                        class="fas fa-box-open"></i></a>
                                            @else
                                                <a disabled title="Edite o produto e informe a quantidade disponível"
                                                    class="btn btn-sm button-admin-highlight-false"><i
                                                        class="fas fa-exclamation-triangle"></i></a>
                                            @endif
                                            <a href="{{ route('produtos.galeria', $product->id) }}"
                                                title="Cadastrar Galeria para este Produto"
                                                class="btn btn-sm button-admin-gallery"><i class="fas fa-image"></i></a>
                                            <a href="{{ route('produtos.deletar', $product->id) }}"
                                                title="Deletar Produto"
                                                class="btn btn-sm delete-confirm button-admin-delete"><i
                                                    class="fas fa-trash-alt"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="alert alert-secondary text-center">
                            <i class="fas fa-info pr-2"></i> Nenhum item cadastrado!
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
@endsection

@push('js')
    @if (!empty($item->title))
        <script type="text/javascript">
            $('#div-form').show();
        </script>
    @else
        <script type="text/javascript">
            console.log('teste');
            $('#div-form').hide();
            $('#cadastrar-product').on('click', function(event) {
                $('#div-form').show(500);
                $('#cadastrar-product').hide(500);
            });
            $('#cancelar-cadastro').on('click', function(event) {
                $('#div-form').hide(500);
                $('#form')[0].reset();
                $('#cadastrar-product').show(500);
            });
        </script>
    @endif
    <script type="text/javascript">
        // Crop image desktop
        $('#productimage').ijaboCropTool({
            item_id : 2,
            preview: '.image-previewer',
            setRatio: 1400 / 1400,
            allowedExtensions: ['jpg', 'jpeg', 'png'],
            buttonsText: ['CORTAR E SALVAR', 'SAIR/CANCELAR'],
            buttonsColor: ['#30bf7d', '#ee5155', -15],
            processUrl: "{{ route('produtos.cortar', $item_id) }}",
            withCSRF: ['_token', '{{ csrf_token() }}'],
            onSuccess: function(message, element, status) {
                if (Toast.fire({
                        icon: 'success',
                        title: message
                    })) {
                    window.location.reload();
                }
            },
            onError: function(message, element, status) {
                if (Toast.fire({
                        icon: 'danger',
                        title: message
                    })) {}
            }
        });
        $('#measurements').ijaboCropTool({
            item_id : 2,
            preview: '.image-previewer',
            setRatio: 1000 / 1000,
            allowedExtensions: ['jpg', 'jpeg', 'png'],
            buttonsText: ['CORTAR E SALVAR', 'SAIR/CANCELAR'],
            buttonsColor: ['#30bf7d', '#ee5155', -15],
            processUrl: "{{ route('produtos.medidas', $item_id) }}",
            withCSRF: ['_token', '{{ csrf_token() }}'],
            onSuccess: function(message, element, status) {
                if (Toast.fire({
                        icon: 'success',
                        title: message
                    })) {
                    window.location.reload();
                }
            },
            onError: function(message, element, status) {
                if (Toast.fire({
                        icon: 'danger',
                        title: message
                    })) {}
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
        $('.delete-confirm').on('click', function(event) {
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

    <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#products').DataTable({
                "order": [
                    [0, "asc"]
                ],
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.10.25/i18n/Portuguese-Brasil.json"
                }
            });
        });
    </script>
@endpush
