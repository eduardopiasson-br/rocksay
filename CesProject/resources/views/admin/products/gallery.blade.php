@extends('admin.layouts.app', ['activePage' => 'products', 'title' => 'Galeria do Produto - Gerenciar', 'navName' =>
'Gerenciar Galeria do Produto', 'activeButton' => 'laravel'])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card data-tables" style="flex-direction: inherit; flex-wrap: wrap">

                        <div class="col-md-6">
                            <div class="col-12 card-body">
                                <h3 class="mt-0 top-title">
                                    <a href="{{ route('produtos') }}" title="Voltar para Produtos"
                                        class="btn btn-ces"><i class="fas fa-undo"></i></a>
                                    <i class="far fa-images"></i> Cadastrar Imagens
                                </h3>
                            </div>
                            <form id="multiple-image-preview-ajax" method="POST" action="javascript:void(0)"
                                accept-charset="utf-8" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12 form-group">
                                        <label class="form-control-label" for="name">
                                            {{ __('Nome para imagem') }}
                                        </label>
                                        <input type="text" name="name" id="name" maxlength="100" class="form-control"
                                            value="{{ $image->name ?? old('name') }}"
                                            placeholder="T-shirt Tananana Rocket Line super fashion e taus...">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input type="file" name="images[]" id="images" placeholder="Choose images"
                                                multiple>
                                        </div>
                                        @error('images')
                                            <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mt-1 text-center">
                                            <div class="show-multiple-image-preview"> </div>
                                        </div>
                                    </div>                                    
                                </div>
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-success" id="submit">Salvar</button>
                                </div>
                            </form>
                        </div>

                        <div class="col-md-6 table-full-width table-responsive table-ces">
                            <div class="col-12 card-body">
                                <h3 class="mt-0 top-title"><i class="fas fa-clipboard-list"></i>
                                    Imagens da Galeria
                                    <a href="{{ route('produtos.galeria', $product_id) }}" title="Recarregar Imagens"
                                        class="btn btn-ces"><i class="fas fa-sync"></i></a>
                                </h3>
                            </div>
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
                                        <tr class="row1" data-id="{{ $image->id }}" style="cursor: n-resize"
                                            title="Clique e arraste para reordenar...">
                                            <td>@if(!empty($image->name)){{ $image->name }}@else <i>* Sem Nome</i> @endif</td>
                                            <td title="{{ $image->name }}"><img
                                                    src="/images/products/gallery/{{ $image->image }}" width="100px">
                                            </td>
                                            <td class="d-flex justify-content-end">
                                                @if ($image->status == 1)
                                                    <a href="{{ route('produtos.galeria.alternar', ['product_id' => $product_id, 'image_id' => $image->id]) }}"
                                                        title="Desativar Imagem"
                                                        class="btn btn-sm button-admin-toggle-success"><i
                                                            class="fas fa-user-check"></i></a>
                                                @else
                                                    <a href="{{ route('produtos.galeria.alternar', ['product_id' => $product_id, 'image_id' => $image->id]) }}"
                                                        title="Ativar Imagem"
                                                        class="btn btn-sm button-admin-toggle-danger"><i
                                                            class="fas fa-user-times"></i></a>
                                                @endif
                                                <input type="hidden" id="_token" name="_token"
                                                    value="{{ csrf_token() }}">
                                                <a href="{{ route('produtos.galeria.deletar', ['product_id' => $product_id, 'image_id' => $image->id]) }}"
                                                    title="Deletar Imagem"
                                                    class="btn btn-sm delete-confirm button-admin-delete"><i
                                                        class="fas fa-trash-alt"></i></a>
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
        $('.delete-confirm').on('click', function(event) {
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
        $(function() {
            $("#tablecontents").sortable({
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
                $('tr.row1').each(function(index, element) {
                    order.push({
                        id: $(this).attr('data-id'),
                        position: index + 1
                    });
                });

                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "{{ url('gerenciar/produtos/' . $product_id . '/galeria/reposicionar') }}",
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
        $(document).ready(function(e) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $(function() {
                // Multiple images preview with JavaScript
                var ShowMultipleImagePreview = function(input, imgPreviewPlaceholder) {
                    if (input.files) {
                        var filesAmount = input.files.length;
                        for (i = 0; i < filesAmount; i++) {
                            var reader = new FileReader();
                            reader.onload = function(event) {
                                $($.parseHTML('<img>')).attr('src', event.target.result).appendTo(
                                    imgPreviewPlaceholder);
                            }
                            reader.readAsDataURL(input.files[i]);
                        }
                    }
                };
                $('#images').on('change', function() {
                    ShowMultipleImagePreview(this, 'div.show-multiple-image-preview');
                });
            });
            $('#multiple-image-preview-ajax').submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                let TotalImages = $('#images')[0].files.length; //Total Images
                let images = $('#images')[0];
                for (let i = 0; i < TotalImages; i++) {
                    formData.append('images' + i, images.files[i]);
                }
                formData.append('TotalImages', TotalImages);
                $.ajax({
                    type: 'POST',
                    url: "{{ url('gerenciar/produtos/' . $product_id . '/galeria/cadastro') }}",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: (data) => {
                        location.reload();
                        toast('Imagem cadastrada com sucesso!', 'success');
                        $('.show-multiple-image-preview').html("")
                    },
                    error: function(data) {
                        location.reload();
                        console.log(data);
                    }
                });
            });
        });
    </script>
@endpush
