<!DOCTYPE html>
<html lang="es">
<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Sistema Ventas">
  <meta name="keyword" content="Sistema ventas">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>Sistema Café</title>

  <link href="css/plantilla.css" rel="stylesheet">

</head>

<body class="app d-flex align-items-center justify-content-center" style="background:#eee;">
    <div class="container">
        @yield('login')
    </div>
    <script src="js/plantilla.js"></script>
</body>
</html>