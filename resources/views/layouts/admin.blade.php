<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>NovaCart Admin</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>

    <style>

        body{

            margin:0;

            background:#f5f7fb;

            font-family:Poppins,sans-serif;

        }

        .wrapper{

            display:flex;

            min-height:100vh;

        }

        .content{

            width:100%;

            margin-left:260px;

        }

        .main-content{

            padding:30px;

        }

    </style>

</head>

<body>

<div class="wrapper">

    @include('admin.partials.sidebar')

    <div class="content">

        

        <div class="main-content">

            @yield('content')

        </div>

        @include('admin.partials.footer')

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>