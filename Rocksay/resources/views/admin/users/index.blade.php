@extends('admin.layouts.app', ['activePage' => 'users', 'title' => 'Gerenciar Usuários - Gerenciar', 'navName' =>
'Gerenciar Usuários', 'activeButton' => 'laravel'])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card data-tables" style="flex-direction: inherit; flex-wrap: wrap">

                        <div class="col-md-12" id="cadastrar-item">
                            <div class="col-12 card-body">
                                <h3 class="mt-0 mb-0"><i class="fas fa-users"></i> Cadastrar Usuários</h3>
                            </div>
                            <form method="post" id="form" autocomplete="off" enctype="multipart/form-data">
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

                                <input type="hidden" id="id" name="id" hidden>
                                <input type="hidden" name="_method">

                                <div class="row">
                                    <div class="form-group col-md-6 {{ $errors->has('name') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-name">
                                            {{ __('Nome') }}<i class="text-danger">*</i>
                                        </label>
                                        <input type="text" name="name" id="input-name" class="form-control"
                                            value="{{ $user->name ?? old('name') }}" placeholder="Nome do Usuário">
                                    </div>
                                    <div class="form-group col-md-6 {{ $errors->has('email') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-email">
                                            {{ __('Email') }}<i class="text-danger">*</i>
                                        </label>
                                        <input type="text" name="email" id="input-email" class="form-control"
                                            value="{{ $user->email ?? old('email') }}" placeholder="Email do Usuário">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="password">Senha <i class="text-danger">*</i></label>
                                        <input type="password" class="form-control" id="password" name="password"
                                            placeholder="Nova senha">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="password_confirmation">Repetir Senha <i
                                                class="text-danger">*</i></label>
                                        <input type="password" class="form-control" id="password_confirmation"
                                            name="password_confirmation" placeholder="Repetir senha">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-success" title="Salvar Dados"><i
                                            class="fas fa-save"></i> Salvar</button>
                                    <button type="reset" class="btn btn-warning" title="Restaurar Dados"><i
                                            class="fas fa-undo-alt"></i> Restaurar</button>
                                    <button type="button" id="cancel-cadastrar-item" class="btn btn-rocksay"
                                        onclick="this.form.reset();"><i class="far fa-window-close"></i> Cancelar</button>
                                </div>
                            </form>
                        </div>

                        <div class="col-md-12 table-responsive">
                            <div class="col-12 card-body d-flex">
                                <h3 class="mt-0 top-title mr-3"><i class="fas fa-clipboard-list"></i> Listagem de Usuários
                                </h3>
                                <button id="cadastrar-button-item" class="btn btn-secondary"><i
                                        class="fas fa-user-plus"></i> Cadastrar Usuarios</button>
                            </div>
                            @if (!empty($users[0]))
                                <table class="table table-hover table-stripeds">
                                    <thead>
                                        <tr class="col-md-12">
                                            <td class="col-md-4 td-title"><b>Nome</b></td>
                                            <td class="col-md-4 td-title"><b>E-mail</b></td>
                                            <td style="display: block"></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $user)
                                            <tr>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td class="d-flex justify-content-end">
                                                    @if ($user->status == 1)
                                                        <a href="{{ route('usuarios.alternar', $user->id) }}"
                                                            title="Desativar Usuário"
                                                            class="btn btn-sm button-admin-toggle-success"><i
                                                                class="fas fa-user-check"></i></a>
                                                    @else
                                                        <a href="{{ route('usuarios.alternar', $user->id) }}"
                                                            title="Ativar Usuário"
                                                            class="btn btn-sm button-admin-toggle-danger"><i
                                                                class="fas fa-user-times"></i></a>
                                                    @endif
                                                    <button onclick="editarItem({{ $user->id }})"
                                                        title="Editar Usuário" class="btn btn-sm button-admin-edit"><i
                                                            class="fas fa-marker"></i></button>
                                                    <a href="{{ route('usuarios.deletar', $user->id) }}"
                                                        title="Deletar Usuário"
                                                        class="btn btn-sm delete-confirm button-admin-delete"><i
                                                            class="fas fa-trash-alt"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <div class="alert alert-secondary text-center">
                                    <i class="fas fa-info pr-2"></i> Nenhum usuario cadastrado!
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
                title: 'Realmente deseja apagar este usuário?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Confirmar!',
                cancelButtonText: 'Cancelar!',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                } else if (
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    swalWithBootstrapButtons.fire(
                        'Cancelado',
                        'Usuário não deletado!',
                        'error'
                    )
                }
            });
        });
    </script>
    <script>
        $("#cadastrar-button-item").click(function() {
            $('#form').attr('action', "{{ route('usuarios.cadastro') }}");
            $("input[name=_method]").val('post');
            $('#cadastrar-item').show(500);
            $('#cadastrar-button-item').hide(500);
            $('#cancel-cadastrar-item').show(500);
        });
        $("#cancel-cadastrar-item").click(function() {
            $('#form').attr('action', "");
            $("input[name=id]").val('');
            $('#form')[0].reset();
            $('#cadastrar-item').hide(500);
            $('#cadastrar-button-item').show(500);
            $('#cancel-cadastrar-item').hide(500);
        });

        function editarItem(item_id) {
            url = window.location.href + '/edicao/' + item_id;
            console.log(item_id);
            $.get(url, function(data) {
                $("input[name=id]").val(data.id);
                $("input[name=name]").val(data.name);
                $("input[name=email]").val(data.email);
                console.log(data.name)
            });
            $('#form').attr('action', "{{ route('usuarios.atualizacao') }}");
            $("input[name=_method]").val('put');
            $('#cadastrar-item').show(500);
            $('#cadastrar-button-item').hide(500);
            $('#cancel-cadastrar-item').show(500);
        };
    </script>
@endpush
