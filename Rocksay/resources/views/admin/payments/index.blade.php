@extends('admin.layouts.app', ['activePage' => 'payments', 'title' => 'Formas de Pagamentos - Gerenciar', 'navName' =>
'Gerenciar Formas de Pagamentos', 'activeButton' => 'laravel'])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card data-tables" style="flex-direction: inherit; flex-wrap: wrap">

                        <div class="col-md-6">
                            <div class="col-12 card-body">
                                @if (!empty($payment))
                                    <h3 class="mt-0 top-title"><i class="fas fa-hand-holding-usd"></i> Editar Pagamento <a
                                            href="{{ route('pagamentos') }}" title="Voltar para cadastros"
                                            class="btn btn-ces"><i class="fas fa-hand-holding-usd"></i></a></h3>
                                @else
                                    <h3 class="mt-0 top-title"><i class="fas fa-hand-holding-usd"></i> Cadastrar Pagamento</h3>
                                @endif
                            </div>
                            <form method="post" @if (!empty($payment)) action="{{ route('pagamentos.atualizacao') }}" @else action="{{ route('pagamentos.cadastro') }}" @endif autocomplete="off" enctype="multipart/form-data">
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

                                @if (!empty($payment))
                                    <input type="text" name="id" value="{{ $payment->id ?? old('id') }}" hidden>
                                    <input type="hidden" name="_method" value="put" />
                                @endif

                                <input type="text" hidden id="position" name="position" value="{{ $max_position ?? 1 }}">
                                <input type="text" name="user_id" value="{{ auth()->user()->id }}" hidden>
                                <div class="row">
                                    <div class="col-md-12 form-group">
                                        <label class="form-control-label" for="input-title">
                                            {{ __('Titulo da Forma de Pagamento') }} <i class="text-danger">*</i>
                                        </label>
                                        <input type="text" name="title" id="input-title"
                                            value="{{ $payment->title ?? old('title') }}" class="form-control"
                                            placeholder="Título para forma de pagamento...">
                                    </div>
                                </div>
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
                                            value="{{ $payment->icon ?? old('icon') }}" class="form-control"
                                            placeholder="Escolha o icone no link acima">                            
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 form-group">
                                        <label class="form-control-label" for="input-text">
                                            {{ __('Descrição da Entrega') }} <i class="text-danger">*</i>
                                        </label>
                                        <textarea type="text" name="text" id="input-text" class="form-control"
                                            placeholder="Descreva a forma de entrega...">{{ $payment->text ?? old('text') }}</textarea>
                                    </div>
                                </div>
                                <br>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-success mr-1" title="Salvar Dados">Salvar</button>
                                    <button type="reset" class="btn btn-warning ml-1"
                                        title="Restaurar Dados">Restaurar</button>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-6 table-full-width table-responsive table-ces">
                            <div class="col-12 card-body">
                                <h3 class="mt-0 top-title"><i class="fas fa-clipboard-list"></i>
                                    Tipos de Pagamentos
                                    <a href="{{ route('pagamentos') }}" title="Recarregar Pagamentos"
                                        class="btn btn-ces"><i class="fas fa-sync"></i></a>
                                </h3>
                            </div>
                            @if(!empty($payments[0]))
                                <table class="table table-hover table-stripeds">
                                    <thead>
                                        <tr class="col-md-12">
                                            <td></td>
                                            <td class="col-md-8"><b>Título</b></td>
                                            <td style="display: block">
                                            </td>
                                        </tr>
                                    </thead>
                                    <tbody id="tablecontents">
                                        @foreach ($payments as $payment)
                                            <tr class="row1" data-id="{{ $payment->id }}" style="cursor: n-resize"
                                                title="Clique e arraste para reordenar...">
                                                <td class="limit-icon"><?= $payment->icon ?></td>
                                                <td class="limit-text">{{ $payment->title }}</td>
                                                <td class="d-flex justify-content-end">
                                                    @if ($payment->status == 1)
                                                        <a href="{{ route('pagamentos.alternar', $payment->id) }}"
                                                            title="Desativar Pagamento" class="btn btn-sm button-admin-toggle-success"><i
                                                                class="fas fa-user-check"></i></a>
                                                    @else
                                                        <a href="{{ route('pagamentos.alternar', $payment->id) }}"
                                                            title="Ativar Pagamento" class="btn btn-sm button-admin-toggle-danger"><i
                                                                class="fas fa-user-times"></i></a>
                                                    @endif
                                                    <input type="hidden" id="_token" name="_token"
                                                        value="{{ csrf_token() }}">
                                                    <a href="{{ route('pagamentos.edicao', $payment->id) }}"
                                                        title="Editar Pagamento" class="btn btn-sm button-admin-edit"><i class="fas fa-marker"></i></a>
                                                    <a href="{{ route('pagamentos.deletar', $payment->id) }}"
                                                        title="Deletar Pagamento" class="btn btn-sm delete-confirm button-admin-delete"><i
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
                title: 'Realmente deseja apagar este Pagamento?',
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
                        'Pagamento não deletado!',
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
                    url: "{{ url('gerenciar/pagamentos/reposicionar') }}",
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
