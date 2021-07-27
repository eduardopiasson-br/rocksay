@extends('admin.layouts.app', ['activePage' => 'users', 'title' => 'Gerenciar Usuários - Gerenciar', 'navName' => 'Gerenciar Usuários', 'activeButton' => 'laravel'])

@section('content')                 
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card data-tables" style="flex-direction: inherit; flex-wrap: wrap">

                    <div class="card-header col-md-12">
                        <div class="row align-items-center">
                            <div class="col-6">
                                @if(!empty($user))
                                    <h3 class="mt-0 top-title"><i class="fas fa-users"></i> Editar Usuário <a href="{{ route('usuarios') }}" title="Voltar para cadastros" class="btn btn-info">Voltar</a></h3>
                                @else
                                    <h3 class="mt-0 top-title"><i class="fas fa-users"></i> Cadastrar Usuários</h3>
                                @endif
                            </div>
                            <div class="col-6">
                                <h3 class="mt-0 top-title"><i class="fas fa-clipboard-list"></i> Listagem de Usuários</h3>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <form method="post" @if(!empty($user)) action="{{ route('usuarios.atualizacao') }}" @else action="{{ route('usuarios.cadastro') }}" @endif autocomplete="off" enctype="multipart/form-data">
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

                        @if(!empty($user))
                            <input type="text" name="id" value="{{ $user->id ?? old('id') }}" hidden>
                            <input type="hidden" name="_method" value="put" />
                        @endif

                        <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                            <label class="form-control-label" for="input-name">
                                {{ __('Nome') }}<i class="text-danger">*</i>
                            </label>
                            <input type="text" name="name" id="input-name" class="form-control" value="{{ $user->name ?? old('name') }}"  placeholder="Nome do Usuário">
                        </div>
                        <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                            <label class="form-control-label" for="input-email">
                                {{ __('Email') }}<i class="text-danger">*</i>
                            </label>
                            <input type="text" name="email" id="input-email" class="form-control" value="{{ $user->email ?? old('email') }}"  placeholder="Email do Usuário">
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                              <label for="password">Senha <i class="text-danger">*</i></label>
                              <input type="password" class="form-control" id="password" name="password" placeholder="Nova senha">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="password_confirmation">Repetir Senha <i class="text-danger">*</i></label>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Repetir senha">
                              </div>
                          </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success" title="Salvar Dados">Salvar</button>
                            <button type="reset" class="btn btn-warning" title="Restaurar Dados">Restaurar</button>
                        </div>
                        </form>
                    </div>
                    
                    <div class="col-md-6 card-body table-full-width table-responsive">
                        <table class="table table-hover table-stripeds">
                            <thead>
                                <tr class="col-md-12">
                                    <td class="col-md-8"><b>Nome</b></td>
                                    <td style="display: block"></td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $user->name }}</td>
                                        <td class="d-flex justify-content-end">
                                            @if($user->status == 1)                                            
                                                <a href="{{ route('usuarios.alternar', $user->id) }}" title="Desativar Usuário" class="btn btn-sm button-admin-toggle-success"><i class="fas fa-user-check"></i></a>
                                            @else
                                                <a href="{{ route('usuarios.alternar', $user->id) }}" title="Ativar Usuário" class="btn btn-sm button-admin-toggle-danger"><i class="fas fa-user-times"></i></a>
                                            @endif
                                            <a href="{{ route('usuarios.edicao', $user->id) }}" title="Editar Usuário" class="btn btn-sm button-admin-edit"><i class="fas fa-marker"></i></a>
                                            <a href="{{ route('usuarios.deletar', $user->id) }}" title="Deletar Usuário" class="btn btn-sm delete-confirm button-admin-delete"><i class="fas fa-trash-alt"></i></a>
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
                    /* Read more about handling dismissals below */
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
@endpush