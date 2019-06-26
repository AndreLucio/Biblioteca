<?php
if (!isset($_SESSION)) {
    session_start();
}

if($_SESSION['tipo'] != 3){
    header('location:index.php');
}

require_once "view/template.php";
require_once "dao/daoExemplar.php";
require_once "dao/daoEmprestimo.php";
require_once "dao/daoUsuario.php";
require_once "modelo/emprestimo.php";

template::header();
template::sidebar();
template::mainpanel();

$daoExemplar = new daoExemplar();
$exemplares = $daoExemplar->selectAll();

$daoUsuario = new daoUsuario();
$usuarios = $daoUsuario->selectAll();

$daoEmprestimo = new daoEmprestimo();

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "save") {
    $emprestimo = new Emprestimo();

    $emprestimo->setUsuario($_POST["usuario"]);
    $emprestimo->setExemplar($_POST["exemplar"]);
    $emprestimo->setDataEmprestimo($_POST["dt-emprestimo"]);
    $emprestimo->setObservacao($_POST["observacoes"]);
    $emprestimo->setTipo($_POST["tipo"]);

    $usuario = $daoUsuario->update($_POST['usuario']);

    $date = new DateTime($_POST["dt-emprestimo"]);
    $interval = new DateInterval('P10D');
    if($usuario->getTipo() == 2){
        $interval = new DateInterval('P15D');
    }
    $date->add($interval);
    
    $emprestimo->setVencimento($date->format('Y-m-d'));

    $daoEmprestimo->salvar($emprestimo);
    unset($categoria);

}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "upd" && $_REQUEST["usuario"] && $_REQUEST["titulo"]) {
    $emprestimo = new Emprestimo();
    $emprestimo->setUsuario($_GET['usuario']);
    $emprestimo->setExemplar($_GET['titulo']);
    $daoEmprestimo->devolverLivro($emprestimo);
}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "emp" && $_REQUEST["usuario"] && $_REQUEST["titulo"]) {
    $emprestimo = new Emprestimo();
    $emprestimo->setUsuario($_GET['usuario']);
    $emprestimo->setExemplar($_GET['titulo']);

    $usuario = $daoUsuario->selectByName($_GET['usuario']);

    $date = new DateTime();
    $interval = new DateInterval('P10D');
    
    if($usuario->getTipo() == 2){
        $interval = new DateInterval('P15D');
    }
    $date->add($interval);
    $emprestimo->setVencimento($date->format('Y-m-d'));
    $emprestimo->setTipo(1);

    $daoEmprestimo->tornarEmprestimo($emprestimo);
}

?>

    <div class='content' xmlns="http://www.w3.org/1999/html">
        <div class='container-fluid'>
            <div class='row'>
                <div class='col-md-12'>
                    <div class='card'>
                        <div class='header'>
                            <h4 class='title'>Empréstimos</h4>
                            <p class='category'>Lista de Empréstimos do Sistema</p>
                        </div>
                        <div class='content table-responsive'>
                            <form action="?act=save&id=" method="POST">
                                <input type="hidden" name="id" value="<?php if(isset($categoria) && $categoria != null) {echo $categoria->getIdCategoria();}?>">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Livro</label>
                                            <select name="exemplar" id="" class="custom-select">
                                                <?php                                                 
                                                if(isset($exemplares))
                                                {
                                                    
                                                    foreach($exemplares as $exemplar)
                                                    {
                                                ?>
                                                    <option value="<?php echo $exemplar->getIdExemplar() ?>"><?php echo $exemplar->getLivro()->getTitulo() ?></option>
                                                <?php

                                                    }
                                                }?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Usuário</label>
                                            <select name="usuario" id="" class="custom-select">
                                                <?php                                                 
                                                if(isset($usuarios))
                                                {
                                                    
                                                    foreach($usuarios as $usuario)
                                                    {
                                                ?>
                                                    <option value="<?php echo $usuario->getIdtbUsuario() ?>"><?php echo $usuario->getNomeUsuario() ?></option>
                                                <?php

                                                    }
                                                }?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="">Tipo</label>
                                            <select name="tipo" id="" class="custom-select">
                                                <option value="0">Reserva</option>
                                                <option value="1">Empréstimo</option>                                                
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                                <label for="">Data do empréstimo</label>
                                                <input type="date" class="form-control" name="dt-emprestimo">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="">Observações</label>
                                        <textarea name="observacoes" class="form-control" rows="3"></textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 d-flex align-items-center">
                                        <button class='btn btn-success' type="submit">Cadastrar</button>
                                    </div>
                                </div>                                
                                
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <?php
                $daoEmprestimo->tabelaPaginada();
            ?>
        </div>
    </div>


<?php
    template::footer();
?>



