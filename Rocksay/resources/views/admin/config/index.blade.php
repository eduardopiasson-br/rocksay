@extends('admin.layouts.app', ['activePage' => 'config', 'title' => 'Configurações - Gerenciar', 'navName' => 'Configurações Gerais', 'activeButton' => 'laravel'])

@section('content')                 
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card data-tables full-admin-table">

                    <div class="card-header col-md-12">
                        <div class="row align-items-center">
                            <div class="col-12">
                                @if(!empty($config))
                                    <h3 class="mt-0 top-title"><i class="fas fa-cogs"></i> Editar Configurações</h3>
                                @else
                                    <h3 class="mt-0 top-title"><i class="fas fa-cogs"></i> Cadastrar Configurações</h3>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <form method="post" @if(!empty($config)) action="{{ route('configuracoes.atualizacao') }}" @else action="{{ route('configuracoes.cadastro') }}" @endif autocomplete="off" enctype="multipart/form-data">
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
                        @if(!empty($config))
                            <input type="text" name="id" value="{{ $config->id ?? old('id') }}" hidden>
                            <input type="hidden" name="_method" value="put" />
                        @endif

                        <input type="text" name="user_id" value="{{ auth()->user()->id }}" hidden>
                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label class="form-control-label" for="owner">{{ __('Nome da Proprietária') }}</label>
                                <input type="text" name="owner" id="owner" class="form-control" value="{{ $config->owner ?? old('owner') }}"  placeholder="Nome da Proprietária">
                            </div>
                            <div class="col-md-4 form-group">
                                <label class="form-control-label" for="cnpj">{{ __('CNPJ') }} <i class="text-danger">*</i> </label>
                                <input type="text" name="cnpj" id="cnpj" class="form-control" value="{{ $config->cnpj ?? old('cnpj') }}"  placeholder="CNPJ da Empresa">
                            </div>
                            <div class="col-md-4 form-group">
                                <label class="form-control-label" for="address">{{ __('Endereço') }} <i class="text-danger">*</i> </label>
                                <input type="text" name="address" id="address" class="form-control" value="{{ $config->address ?? old('address') }}"  placeholder="Ex: Avenida Getúlio Vargas, 657, centro, Matelândia - PR">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3 form-group">
                                <label class="form-control-label" for="link_address"><i class="fas fa-map-marked-alt"></i> {{ __('Localização (Maps)') }}</label>
                                <input type="text" name="link_address" id="link_address" class="form-control" value="{{ $config->link_address ?? old('link_address') }}"  placeholder="Url/Link do Google Maps">
                            </div>
                            <div class="col-md-3 form-group">
                                <label class="form-control-label" for="phone"><i class="fas fa-phone-square"></i> {{ __('Telefone') }}</label>
                                <input type="text" name="phone" id="phone" class="form-control" value="{{ $config->phone ?? old('phone') }}"  placeholder="(45) 99999-9999" onkeypress="mask(this, mphone);" onblur="mask(this, mphone);">
                            </div>
                            <div class="col-md-3 form-group">
                                <label class="form-control-label" for="whatsapp"><i class="fab fa-whatsapp-square"></i> {{ __('WhatsApp') }}</label>
                                <input type="text" name="whatsapp" id="whatsapp" class="form-control" value="{{ $config->whatsapp ?? old('whatsapp') }}" placeholder="(45) 99999-9999" onkeypress="mask(this, mphone);" onblur="mask(this, mphone);">
                            </div>
                            <div class="col-md-3 form-group">
                                <label class="form-control-label" for="telegram"><i class="fab fa-telegram"></i> {{ __('Telegram') }}</label>
                                <input type="text" name="telegram" id="telegram" class="form-control" value="{{ $config->telegram ?? old('telegram') }}" placeholder="(45) 99999-9999" onkeypress="mask(this, mphone);" onblur="mask(this, mphone);">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3 form-group">
                                <label class="form-control-label" for="instagram"><i class="fab fa-instagram-square"></i> {{ __('Instagram') }}</label>
                                <input type="url" name="instagram" id="instagram" class="form-control" value="{{ $config->instagram ?? old('instagram') }}"  placeholder="Link Conta do Instagram">
                            </div>
                            <div class="col-md-3 form-group">
                                <label class="form-control-label" for="facebook"><i class="fab fa-facebook-square"></i> {{ __('Facebook') }}</label>
                                <input type="url" name="facebook" id="facebook" class="form-control" value="{{ $config->facebook ?? old('facebook') }}"  placeholder="Link Página do Facebook">
                            </div>
                            <div class="col-md-3 form-group">
                                <label class="form-control-label" for="email"><i class="fas fa-envelope-square"></i> {{ __('Email') }} <i class="text-danger">*</i> </label>
                                <input type="email" name="email" id="email" class="form-control" value="{{ $config->email ?? old('email') }}"  placeholder="Email Profissional">
                            </div>
                            <div class="col-md-3 form-group">
                                <label class="form-control-label" for="email_two"><i class="fas fa-envelope-square"></i> {{ __('Email Secundário') }}</label>
                                <input type="email" name="email_two" id="email_two" class="form-control" value="{{ $config->email_two ?? old('email_two') }}"  placeholder="Email Secundário">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label class="form-control-label" for="footer_text">{{ __('Texto de Rodapé') }} <i class="text-danger">*</i> </label>
                                <textarea type="text" name="footer_text" id="footer_text" class="form-control" placeholder="Texto do final da página, no lado esquerdo..." rows="2">{{ $config->footer_text ?? old('footer_text') }}</textarea>
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="form-control-label" for="wellcome_message">{{ __('Mensagem de Boas Vindas') }}</label>
                                <textarea type="text" name="wellcome_message" id="wellcome_message" class="form-control" placeholder="Mensagem de boas vindas da página inicial.." rows="2">{{ $config->wellcome_message ?? old('wellcome_message') }}</textarea>
                            </div>
                        </div>
                        @if(!empty($config))
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <strong>Imagem Padrão <i class="text-danger">*</i> :</strong>
                                <input type="file" id="configimage" name="configimage" class="form-control" placeholder="Imagem Padrão">
                                @if (session()->has('message_image'))
                                    <div class="alert alert-success message-image">
                                        {{ session('message_image') }}
                                    </div>
                                @endif
                                @if(!empty($config))<br><img style="max-width: 100%;" src="{{ $config->image }}" width="400px">@endif
                            </div>
                        </div>
                        @endif
                        <br><br>

                        <div class="form-group">
                            <button type="submit" class="btn btn-success" title="Salvar Dados"><i class="fas fa-save"></i> Salvar</button>
                            <button type="reset" class="btn btn-warning" title="Restaurar Dados"><i class="fas fa-undo-alt"></i> Restaurar</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
    <script type="text/javascript">
    // Crop image
        $('#configimage').ijaboCropTool({
          preview : '.image-previewer',
          setRatio:1200/627,
          allowedExtensions: ['jpg', 'jpeg','png'],
          buttonsText:['CORTAR E SALVAR','SAIR/CANCELAR'],
          buttonsColor:['#30bf7d','#ee5155', -15],
          processUrl:'{{ route("configuracoes.cortar") }}',
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
            )){window.location.reload();}
          }
       });
    </script>
    <script type="text/javascript">
        function mask(o, f) {
        setTimeout(function() {
            var v = mphone(o.value);
            if (v != o.value) {
            o.value = v;
            }
        }, 1);
        }

        function mphone(v) {
        var r = v.replace(/\D/g, "");
        r = r.replace(/^0/, "");
        if (r.length > 10) {
            r = r.replace(/^(\d\d)(\d{5})(\d{4}).*/, "($1) $2-$3");
        } else if (r.length > 5) {
            r = r.replace(/^(\d\d)(\d{4})(\d{0,4}).*/, "($1) $2-$3");
        } else if (r.length > 2) {
            r = r.replace(/^(\d\d)(\d{0,5})/, "($1) $2");
        } else {
            r = r.replace(/^(\d*)/, "($1");
        }
        return r;
        }
    </script>
@endpush