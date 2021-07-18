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
                                    <h3 class="mt-0">Editar Usuário <a href="{{ route('usuarios') }}" title="Voltar para cadastros" class="btn btn-info">Voltar</a></h3>
                                @else
                                    <h3 class="mt-0">Cadastrar Usuários</h3>
                                @endif
                            </div>
                            <div class="col-6">
                                <h3 class="mt-0">Listagem de Usuários</h3>
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
                        @if (session()->has('message'))
                            <div class="alert alert-success" style="text-align:center">
                                {{ session('message') }}
                            </div>
                        @endif

                        @if(!empty($user))
                            <input type="text" name="id" value="{{ $user->id ?? old('id') }}" hidden>
                            <input type="hidden" name="_method" value="put" />
                        @endif

                        <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                            <label class="form-control-label" for="input-name">
                                {{ __('Nome') }}
                            </label>
                            <input type="text" name="name" id="input-name" class="form-control" value="{{ $user->name ?? old('name') }}"  placeholder="Nome do Usuário">
                        </div>
                        <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                            <label class="form-control-label" for="input-email">
                                {{ __('Email') }}
                            </label>
                            <input type="text" name="email" id="input-email" class="form-control" value="{{ $user->email ?? old('email') }}"  placeholder="Email do Usuário">
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                              <label for="password">Senha </label>
                              <input type="password" class="form-control" id="password" name="password" placeholder="Nova senha">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="password_confirmation">Repetir Senha </label>
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
                        <table class="table table-hover table-striped table-bordered">
                            <thead>
                                <tr class="col-md-12">
                                    <th class="col-md-4">Nome</th>
                                    <th class="col-md-4">Email</th>
                                    <th style="display: block"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td class="d-flex justify-content-end">
                                            @if($user->status == 1)                                            
                                                <a href="{{ route('usuarios.alternar', $user->id) }}" title="Desativar Usuário" style="margin: 0 5px; color:rgb(0, 109, 0)"><i class="fas fa-user-check"></i></a>
                                            @else
                                                <a href="{{ route('usuarios.alternar', $user->id) }}" title="Ativar Usuário" style="margin: 0 5px; color:rgb(196, 0, 0)"><i class="fas fa-user-times"></i></a>
                                            @endif
                                            <a href="{{ route('usuarios.edicao', $user->id) }}" style="margin: 0 5px; color:rgb(177, 177, 0)"><i class="fa fa-edit"></i></a>
                                            <a href="#" data-href="{{ route('usuarios.deletar', $user->id) }}" style="margin: 0 5px; color:rgb(138, 0, 0)" data-toggle="modal" data-target="#confirm-delete"><i class="fas fa-trash-alt"></i></a>
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
<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                Deletar Usuário
            </div>
            <div class="modal-body">
                Tem certeza que deseja deletar este usuário?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <a class="btn btn-danger btn-ok">Deletar</a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
    <script type="text/javascript">
        // $(document).ready(function() {
        //     // Javascript method's body can be found in assets/js/demos.js
        //     demo.initDashboardPageCharts();

        //     demo.showNotification();

        // });
        $('#confirm-delete').on('show.bs.modal', function(e) {
    $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
});
    </script>
@endpush