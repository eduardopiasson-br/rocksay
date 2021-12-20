@extends('admin.layouts.app', ['activePage' => 'products', 'title' => 'Cores do Produto - Gerenciar', 'navName' => 'Gerenciar Cores do Produto', 'activeButton' => 'laravel'])

@section('content')                 
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card data-tables" style="flex-direction: inherit; flex-wrap: wrap">

                    <div class="col-md-6">
                        <div class="col-12 card-body">
                            @if(!empty($color))
                                <h3 class="mt-0 top-title"> 
                                    <a href="{{ route('produtos') }}" title="Voltar para Produtos" class="btn btn-ces"><i class="fas fa-undo"></i></a>
                                    <i class="fas fa-palette"></i> Editar Cor 
                                    <a href="{{ route('produtos.cores', $product_id) }}" title="Voltar para cadastros" class="btn btn-ces"><i class="fas fa-undo"></i></a>
                                </h3>
                            @else
                                <h3 class="mt-0 top-title">
                                    <a href="{{ route('produtos') }}" title="Voltar para Produtos" class="btn btn-ces"><i class="fas fa-undo"></i></a>
                                    <i class="fas fa-palette"></i> Cadastrar Cor
                                </h3>
                            @endif
                        </div>
                        <form method="post" @if(!empty($color)) action="{{ route('produtos.cores.atualizacao', ['product_id' => $product_id]) }}" @else action="{{ route('produtos.cores.cadastro', ['product_id' => $product_id]) }}" @endif autocomplete="off" enctype="multipart/form-data">
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

                        @if(!empty($color))
                            <input type="text" name="id" value="{{ $color->id ?? old('id') }}" hidden>
                            <input type="hidden" name="_method" value="put" />
                        @endif

                        <input type="text" hidden name="product_id" value="{{ $product_id }}">
                        <input type="text" name="user_id" value="{{ auth()->user()->id }}" hidden>
                        <div class="row">
                            <div class="col-md-8 form-group">
                                <label class="form-control-label" for="input-name">
                                    {{ __('Nome para a Cor') }} <i class="text-danger">*</i>
                                </label>
                                <input type="text" name="name" id="input-name" class="form-control" value="{{ $color->name ?? old('name') }}"  placeholder="Ex: Novas tendências da próxima estação.">
                            </div>
                            <div class="col-md-4 form-group">
                                <label class="form-control-label" for="input-exa_color">
                                    {{ __('Exadecimal da Cor') }} <i class="text-danger">*</i>
                                </label>
                                <input type="color" name="exa_color" class="form-control" value="{{ $color->exa_color ?? old('exa_color') }}">
                            </div>
                        </div>
              
                        <div class="form-group d-flex justify-content-center">
                            <button type="submit" class="btn btn-success mr-1" title="Salvar Dados">Salvar</button>
                            <button type="reset" class="btn btn-warning ml-1" title="Restaurar Dados">Restaurar</button>
                        </div>
                        </form>
                    </div>
                    
                    <div class="col-md-6 table-full-width table-responsive table-ces">
                        <div class="col-12 card-body">
                            <h3 class="mt-0 top-title"><i class="fas fa-clipboard-list"></i> 
                                Cores Cadastradas
                                <a href="{{ route('produtos.cores', $product_id) }}" title="Recarregar Imagens" class="btn btn-ces"><i class="fas fa-sync"></i></a>
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
                                @foreach ($colors as $color)
                                    <tr>
                                        <td><i style="color: {{$color->exa_color}}" class="fas fa-palette"></i> {{ $color->name }}</td>
                                        <td class="d-flex justify-content-end">
                                            @if($color->status == 1)                                            
                                                <a href="{{ route('produtos.cores.alternar', ['product_id' => $product_id, 'image_id' => $color->id]) }}" title="Desativar Cor" class="btn btn-sm button-admin-toggle-success"><i class="fas fa-user-check"></i></a>
                                            @else
                                                <a href="{{ route('produtos.cores.alternar', ['product_id' => $product_id, 'image_id' => $color->id]) }}" title="Ativar Cor" class="btn btn-sm button-admin-toggle-danger"><i class="fas fa-user-times"></i></a>
                                            @endif
                                            <input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}">
                                            <a href="{{ route('produtos.cores.edicao', ['product_id' => $product_id, 'image_id' => $color->id]) }}" title="Editar Cor" class="btn btn-sm button-admin-edit"><i class="fas fa-marker"></i></a>
                                            <a href="{{ route('produtos.cores.deletar', ['product_id' => $product_id, 'image_id' => $color->id]) }}" title="Deletar Cor" class="btn btn-sm delete-confirm button-admin-delete"><i class="fas fa-trash-alt"></i></a>
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
                title: 'Realmente deseja apagar esta Cor?',
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
                    'Cor não deletada!',
                    'error'
                    )
                }
            });
        });
    </script>
@endpush