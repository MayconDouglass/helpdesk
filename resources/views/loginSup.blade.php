<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HelpDesk ~ Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/solid.css">
    <script src="https://use.fontawesome.com/releases/v5.0.7/js/all.js"></script>
    <link rel="stylesheet" type="text/css" href="css/loginSup.css">
</head>

<body>

    <div class="modal-dialog text-center">

        <div class="col-sm-8 main-section">

            <div class="modal-content">

                <div class="col-12 user-img">
                    <img src="/storage/config/suporte.png">
                </div>
                <form class="login-form" method="POST" action="/suporte/login">
                    @csrf
                    @if (session('status_login_error'))
                        <div class="alert alert-danger">
                            {{ session('status_login_error') }}
                        </div>
					@endif
					
                    <div class="col-sm-12">
                        <input type="email" class="form-control" placeholder="Email" id="email" name="email"><br>
                    </div>

                    <div class="col-sm-12">
                        <input type="password" class="form-control" placeholder="Senha" id="senha" name="senha"><br>
                    </div>

                    <div class="col-sm-12">
                        <button type="submit" class="btn"><i class="fas fa-sign-in-alt"></i> Login</button>
                    </div>

                    <div class="col-sm-12">
                        <input type="checkbox" name="remember"><span class="texto"> Lembrar</span>
                    </div>

                </form>

                <div class="col-12 forgot">
                    <a href="#">Esqueci a senha</a>
                </div>

            </div>
            <!--- Fim do Modal Content -->
        </div>
    </div>

</body>

</html>
