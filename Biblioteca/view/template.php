<?php
/**
 * Created by PhpStorm.
 * User: tassio
 * Date: 02/03/2018
 * Time: 11:23
 * Ícones: https://fontawesome.com/v4.7.0/icons/
 */
if (!isset($_SESSION)) {
    session_start();
}

if(!isset($_SESSION['login']) || $_SESSION['login'] == NULL){
    header('location:login.php');
}

class Template
{

    public static function header()
    {

/*session_start();
if((!isset ($_SESSION['login']) == true) and (!isset ($_SESSION['senha']) == true))
{
    unset($_SESSION['login']);
    unset($_SESSION['senha']);
    header('location:login.php');
}
$logado = $_SESSION['login'];
*/

        echo "<!doctype html>
<html lang='en'>
<head>
	<meta charset='utf-8' />
	<link rel='icon' type='image/png' sizes='96x96' href='assets/img/favicon.jpg'>
	<meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1' />

	<title>Biblioteca</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name='viewport' content='width=device-width' />

    <!-- Bootstrap core CSS     -->
    <link href='assets/css/bootstrap.css' rel='stylesheet' />

    <!-- Animation library for notifications   -->
    <link href='assets/css/animate.min.css' rel='stylesheet'/>

    <!--  Paper Dashboard core CSS    -->
    <link href='assets/css/paper-dashboard.css' rel='stylesheet'/>

    <!--  Fonts and icons     -->
    <link href='http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Muli:400,300' rel='stylesheet' type='text/css'>
    <link href='assets/css/themify-icons.css' rel='stylesheet'>

    <link rel='stylesheet' type='text/css' href=\"plugins/table-bootstrap/css/addons/datatables.min.css\">
    <link href='assets/css/home.css' rel='stylesheet' />
    
</head>
<body>";

    }

public static function footer()
    {
        echo " <footer class=\"footer\">
            <div class=\"container-fluid\">
                <nav class=\"pull-left\">
                    <ul>

                        <li>
                            <a href=\"http://www.tassio.eti.br\" target='_blank'>
                                Tassio Sirqueira
                            </a>
                        </li>
                    </ul>
                </nav>
                <div class=\"copyright pull-right\">
                    &copy; <script>document.write(new Date().getFullYear())</script>, template made with <i class=\"fa fa-heart heart\"></i> by <a href=\"http://www.creative-tim.com\" target='_blank'>Creative Tim</a>
                </div>
            </div>
        </footer>

    </div>
</div>
</body>

    <!--   Core JS Files   -->
    <script src=\"assets/js/jquery-1.10.2.js\" type=\"text/javascript\"></script>
	<script src=\"assets/js/bootstrap.min.js\" type=\"text/javascript\"></script>
	<!--  Checkbox, Radio & Switch Plugins -->
    <script src=\"assets/js/bootstrap-checkbox-radio.js\"></script>    
    
    <script src=\"plugins/table-bootstrap/js/addons/datatables.min.js\" type=\"text/javascript\"></script>   
    <script src=\"assets/js/home.js\" type=\"text/javascript\"></script>

</html>";

    }

    public static function sidebar()
    {
        echo "<div class=\"wrapper\">
        <div class=\"sidebar\" data-background-color=\"white\" data-active-color=\"danger\">
        <!--
            Tip 1: you can change the color of the sidebar's background using: data-background-color=\"white | black\"
            Tip 2: you can change the color of the active button using the data-active-color=\"primary | info | success | warning | danger\"
        -->
        <div class=\"sidebar-wrapper\">
            <div class=\"logo\">
                <a href='index.php'><img src=\"assets/img/logo.jpg\" height=\"150\" width=\"200\"></a>
                <h4>Biblioteca</h4>
                <h6>Logado: ". $_SESSION['login'] ."</h6>
                <small></small>
                <a class='btn btn-success'  href=\"logout.php\">Logout</a>
            </div>
            <ul class=\"nav d-flex flex-column\">
            ". ($_SESSION['tipo'] == 3 ? "<li><a href=\"usuarios.php\" class=\"d-flex align-items-center\"><i class=\"fa fa-user\"></i><p>Usuários</p></a></li>" : "") ."
                ".($_SESSION['tipo'] == 4 ? "<li>
                    <a href='autores.php' class=\"d-flex align-items-center\">
                        <i class=\"ti-user\"></i>
                        <p>Autores</p>
                    </a>
                </li>
                <li>
                    <a href=\"livros.php\" class=\"d-flex align-items-center\">
                        <i class=\"ti-agenda\"></i>
                        <p>Livros</p>
                    </a>
                </li>":"")."
                ". ($_SESSION['tipo'] == 4 ? "<li><a href=\"categorias.php\" class=\"d-flex align-items-center\"><i class=\"fa fa-tag\"></i><p>Categorias</p></a></li>
                <li>
                    <a href=\"editoras.php\" class=\"d-flex align-items-center\">
                        <i class=\"fa fa-list-alt\"></i>
                        <p>Editoras</p>
                    </a>
                </li>":"") ."
                ".($_SESSION['tipo'] == 4 ? "<li><a href=\"exemplares.php\" class=\"d-flex align-items-center\"><i class=\"fa fa-book\"></i><p>Exemplares</p></a></li>":"") ."
                
                ".($_SESSION['tipo'] == 3 ? "<li>
                    <a href=\"emprestimos.php\" class=\"d-flex align-items-center\">
                        <i class=\"fa fa-address-book\"></i>
                        <p>Empréstimos</p>
                    </a>
                </li>":"") ."
                ".($_SESSION['tipo'] == 5 ? "<li><a href=\"relatorio.php\" class=\"d-flex align-items-center\"><i class=\"fa fa-area-chart\"></i><p>Gráficos</p></a></li>":"")."
                ".($_SESSION['tipo'] == 5 ? "<li>
                    <a href=\"relatorioPDF.php\" class=\"d-flex align-items-center\">
                        <i class=\"fa fa-file-text\"></i>
                        <p>Relatórios</p>
                    </a>
                </li>" : "")."
            </ul>
        </div>
    </div>";
    }


public static function mainpanel()
    {
        date_default_timezone_set('America/Sao_Paulo');
        $data = date("F j, Y");
        echo "<div class=\"main-panel\">
        <nav class=\"navbar navbar-default\">
            <div class=\"container-fluid\">
                <div class=\"navbar-header\">
                    <button type=\"button\" class=\"navbar-toggle\">
                        <span class=\"sr-only\">Toggle navigation</span>
                        <span class=\"icon-bar bar1\"></span>
                        <span class=\"icon-bar bar2\"></span>
                        <span class=\"icon-bar bar3\"></span>
                    </button>
                    <a class=\"navbar-brand\" href=\"#\">Boas vindas!</a>
                </div>
                <div class=\"collapse navbar-collapse\">
                    <ul class=\"nav navbar-nav navbar-right\">
                        <!--li>
                            <a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">
                                <i class=\"ti-panel\"></i>
                                <p>Stats</p>
                            </a>
                        </li>
                        <li class=\"dropdown\">
                            <a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">
                                <i class=\"ti-bell\"></i>
                                <p class=\"notification\">5</p>
                                <p>Notifications</p>
                                <b class=\"caret\"></b>
                            </a>
                            <ul class=\"dropdown-menu\">
                                <li><a href=\"#\">Notification 1</a></li>
                                <li><a href=\"#\">Notification 2</a></li>
                                <li><a href=\"#\">Notification 3</a></li>
                                <li><a href=\"#\">Notification 4</a></li>
                                <li><a href=\"#\">Another notification</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href=\"#\">
                                <i class=\"ti-settings\"></i>
                                <p>Settings</p>
                            </a>
                        </li-->
                    </ul>

                </div>
            </div>
        </nav>";

    }

}