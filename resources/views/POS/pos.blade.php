<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="google" content="notranslate" />
    <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
    <link href="css/plantilla.css" rel="stylesheet">
    
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Punto de Venta - Doctor Pc</title>
</head>
<body>
    <div id="app">
        @if(Auth::check())
            @if (Auth::user()->idroles==1)
                <template>
                    <pos></pos>
                </template>
            @else
                <h1>Pagina anti sapos xd</h1>
            @endif
        @endif
    </div>
    <script src="js/app.js"></script>
    <script src="js/plantilla.js"></script>
</body>
</html>