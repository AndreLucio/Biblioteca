<?php 
    use PHPMailer\PHPMailer\PHPMailer;
    require "./PHPMailer/src/PHPMailer.php";
    require "./PHPMailer/src/SMTP.php";
    require "./PHPMailer/src/Exception.php";
    require "./dao/daoUsuario.php";

    if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "enviarEmail") {

        if(isset($_POST["emailRecuperarSenha"])){

            $daoUsuario = new daoUsuario();
            $usuario = $daoUsuario->findByEmail($_POST["emailRecuperarSenha"]);
            if($usuario != null){
                $daoUsuario = new daoUsuario();
                $mail = new PHPMailer;
                $mail->isSMTP();
                //Enable SMTP debugging
                // 0 = off (for production use)
                // 1 = client messages
                // 2 = client and server messages
                $mail->SMTPDebug = 0;
                $mail->Host = 'smtp.gmail.com';
                $mail->Port = 587;
                $mail->SMTPSecure = 'tls';
                $mail->SMTPAuth = true;
                $mail->Username = "no.replay.law@gmail.com";
                $mail->Password = "123law2018";
                $mail->setFrom('no.replay.law@gmail.com', 'No Replay');
                //$mail->addReplyTo('tassio@tassio.eti.br', 'Tassio Sirqueira');
                $mail->addAddress($_POST["emailRecuperarSenha"]);
                $mail->Subject = 'Recuperar senha';
                $mail->msgHTML('
                <!DOCTYPE html>
                <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <style>
                        .bg{
                            font-family: Roboto, arial;
                            width: 100%;
                            height: 100%;
                            background-color: white;
                            display: flex;
                            justify-content: center;
                        }    
                        .bg-white{
                            width: 100%;
                            background-color: #17a2b8;
                            margin: 30px 10% 50px 10%;
                            border: 1px solid white;
                            border-radius: 5px;
                            padding: 20px 30px 5px 20px;
                        }

                        .text-white{
                            color: white;
                        }
                        .titulo{
                            font-size: 3rem;
                        }
                        .texto-normal{
                            font-size: 1rem;
                        }
                    </style>    
                </head>
                <body>
                    <div class="bg">
                        <div class="bg-white text-white">
                            <h4 class="titulo">Olá, '. $usuario->getNomeUsuario() .'</h4>
                            <p class="texto-normal">Foi gerada uma solicitação de recuperação de senha no site da <strong>BIBLIOTECA DIGITAL</strong>.</p>
                            <p class="texto-normal">Para voltar a acessar o sistema utilize a seguinte senha: <strong>'. $usuario->getSenha() .'</strong>.</p>
                        </div>
                    </div>
                </body>
                </html>');

                if (!$mail->send()) {
                    $msgErroEmail = "Erro ao enviar e-mail"; 
                } else {
                    $msgSucessoEmail = "E-mail enviado com sucesso";
                }
            } else {
                $msgErroEmail = "Usuário não encontrado";
            }

            
        }
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Logar no Sistema</title>
    <link rel="stylesheet" href="assets/css/bootstrap.css" />
</head>

<body>
    <div class="row d-flex justify-content-center mt-5">
        <div class="col-lg-3">
            <?php
                session_start();
                if(isset($_SESSION['msgErro'])){
                    echo "<div class='alert alert-warning text-danger'>";
                        echo $_SESSION['msgErro'];
                        unset($_SESSION['msgErro']);
                    echo "</div>";
                }else if(isset($msgSucessoEmail)){
                    echo "<div class='alert alert-success'>";
                        echo $msgSucessoEmail;
                    echo "</div>";
                } else if(isset($msgErroEmail)){
                    echo "<div class='alert alert-warning text-danger'>";
                        echo $msgErroEmail;
                    echo "</div>";
                }
            ?>
            <div class="card shadow-lg">
                <div class="card-header text-white bg-info">
                    <h5>Login</h5>
                </div>
                <div class="card-body">
                    <form method="post" action="logar.php" id="formlogin" name="formlogin">
                        <div class="form-group">
                            <label class="col-form-label-sm">Nome</label>
                            <input type="text" name="login" id="login" class="form-control shadow-sm" />
                        </div>
                        <div class="form-group">
                            <label class="col-form-label-sm">Senha</label>
                            <input type="password" name="senha" id="senha" class="form-control shadow-sm" />
                        </div>
                        <div class="form-group d-flex justify-content-center mt-5">
                            <input type="submit" value="Efetuar Login" class="btn btn-info" />
                        </div>
                        <div class="form-group d-flex justify-content-center">
                            <!-- Chama modal de recuperação de senha -->
                            <a href="" data-toggle="modal" data-target="#modalEsqueciSenha">
                                Esqueci minha senha
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de recuperação de senha -->
    <div class="modal fade" id="modalEsqueciSenha" tabindex="-1" role="dialog" aria-labelledby="modalEsqueciSenhaTitle"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h4 class="modal-title" id="modalEsqueciSenhaTitle">Recuperar senha</h4>
                </div>
                <form action="?act=enviarEmail" method="POST">
                    <div class="modal-body">

                        <div class="form-group">
                            <label class="col-form-label-sm">E-mail</label>
                            <input type="email" name="emailRecuperarSenha" class="form-control shadow-sm">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger text-white" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-info">Recuperar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="./assets/Scripts/jquery.js"></script>
    <script src="./assets/Scripts/bootstrap/bootstrap.js"></script>
</body>

</html>