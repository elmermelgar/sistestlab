<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Presupuesto</title>

    <!-- Styles -->
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/quick-budget.css" rel="stylesheet">
    <link href="{{url('css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{url('css/quick-budget.css')}}" rel="stylesheet">

</head>

<body>
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            @include('presupuesto_rapido.budget')
        </div>
    </div>
</div>

</body>
</html>
