<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CRUD пользователей</title>

    <link rel="stylesheet" href="assets/css/reset.css">
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <link rel="stylesheet" href="assets/css/style.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <script src="assets/js/jQuery.js"></script>
    <script src="assets/js/bootstrap.js"></script>
</head>
<body>
    <div id="preloader">
        <img src="assets/img/spinner.gif" alt="wait some time...">
    </div>

    <div class="container">
        <div class="row col-12">
            <p class="display-4 text-center py-5">CRUD (AJAX) пользователей</p>
        </div>
    </div>

    <div class="container">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Логин</th>
                    <th scope="col">Почта</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th>0</th>
                    <td>Lancelot</td>
                    <td>lancelot.ozernuy@gmail.com</td>
                    <td>
                        <li class="list-inline-item">
                            <a href="#" class="btn btn-primary btn-sm rounded-1" title="Edit">
                                <i class="fa fa-edit"></i>
                            </a>
                        </li>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <script>
        $(document).ready(() => {
            $("#preloader").remove();
        });
    </script>
</body>
</html>