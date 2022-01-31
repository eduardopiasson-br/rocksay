<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <!-- Metadata -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Icon title-->
    <link rel="shortcut icon" href="{{ url('images/favicon.png') }}" />
    <link rel="apple-touch-icon" sizes="76x76" href="{{ url('images/favicon.png') }}">
    <link rel="icon" type="image/png" href="{{ url('images/favicon.png') }}">

    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans+Narrow:wght@400;700&display=swap" rel="stylesheet">

    <!-- Css Geral -->
    <link href="{{ url('css/dependence/bootstrap.min.css') }}" rel="stylesheet">
    <title>404 Pagina não Encontrada</title>
    <style>
        body {
            background-color: #000;
            padding: 0px;
            margin: 0px;
            text-align: center;
        }
        .div-error {
            margin: 100px auto 0;
            color: #fff;
            width: 40%;
            padding: 30px;
            border-radius: 10px;
            background-color: #600416;
        }
        p {
            max-width: 400px;
            margin: 20px auto;
        }
    </style>
</head>
<body>
    
    <section>
        <div class="div-error">
            <h2>ERRO 404</h2>
            <h3>Página Não Encontrada</h3>
            <hr>
            <p><b>Motivos: </b>você pode ter tentado acessar uma pagina não existente ou
                de algum produto que já não está mais disponível... </p>
            <a href="{{ url('') }}" class="btn btn-secondary" title="Ir para página inicial do site Rocksay">Página Inicial</a>
            <a href="{{ url('/produtos') }}" class="btn btn-secondary" title="Ir para os produtos da loja Rocksay">Produtos</a>
        </div>
    </section>

</body>
</html>
