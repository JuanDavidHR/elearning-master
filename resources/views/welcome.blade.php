<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <style>
    *{
      box-sizing: border-box;
    }
    body {
        margin: 0;
        font-family: -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol";
        font-size: 1rem;
        font-weight: 400;
        line-height: 1.5;
        color: #212529;
        text-align: left;
        background-color: #fff;
    }
    .asd .card-header{
      border: 1px #000000 solid;
      border-style : double;
      border-width : 5px;
      border-bottom-style : none;
      margin-top: 35px;
      padding: .75rem 1.25rem;
      margin-bottom: 0;
      background-color: #ffd705;
      color: #000000;
      border-top-left-radius: 20px;
      border-top-right-radius: 20px;
      font-size: 15px;
    }
    .asd .card-body{
      border: 1px #000000 solid;
      border-style : double;
      border-width : 5px;
      border-top-style : none !important;
      font-size: 12px;
      border-bottom-left-radius: 20px;
      border-bottom-right-radius: 20px;
    }
    .asd .card-body p{
      padding: 0px; 
      margin-top: 8px;
      margin-bottom: 8px;
    }
    .card-body{
      padding: 1.25rem;
    }
    .asd{
      margin-bottom: 50px;
      margin-top: 20px;
    }
    .title{
      font-weight: bold;
    }
    .container {
      max-width: 540px;
      padding-right: 15px;
      padding-left: 15px;
      margin-right: auto;
      margin-left: auto;
    }
    h2{
      text-align: center;
      text-decoration: underline;
    }
  </style>  
</head>
<body>
<div class="container">
  <h2>CONTROL DE ENCARGO</h2>
<div class="asd">
  <div class="card-header">
    <span class="title">{{$title}}</span>
  </div>
  <div class="card-body">
    <p><span class="title">Tipo de actividad: </span>{{$encargo[0]->tipo_actividad}}</p>
    <p><span class="title">Documento de solicitud: </span>{{ $encargo[0]->documento_solicitud}}</p>
    <p><span class="title">Fecha de solicitud: </span>{{$fecha_solicitud}}</p>
    <p><span class="title">Documento de autorización: </span>{{$encargo[0]->documento_autorizacion}}</p>
    <p><span class="title">Fecha de autorización: </span>{{$fecha_autorizacion}}</p>
    <p><span class="title">Nombre de responsable: </span>{{$encargo[0]->nombre_responsable}}</p>
    <p><span class="title">Monto: </span>{{$money}}</p>
    <p><span class="title">Fecha de inicio: </span>{{$fecha_inicio}}</p>
    <p><span class="title">Fecha de fin: </span>{{$fecha_final}}</p>
    <p><span class="title">Fecha máxima de rendición: </span>{{$fecha_maximo}}</p>
  </div>
</div>
</div>  
</body>
</html>
