<?php
if (!isset($_SESSION)) {
    session_start();
}

if($_SESSION['tipo'] != 3){
    header('location:index.php');
}

require_once "view/template.php";
require_once "dao/daoUsuario.php";
require_once "modelo/usuario.php";

template::header();
template::sidebar();
template::mainpanel();

$daoUsuario = new daoUsuario();

$tipoUsuario = $daoUsuario->findAllTipoUsuario();

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "save") {
    $usuario = new Usuario();
    if(isset($_POST["id"])){
        $usuario->setIdtbUsuario($_POST["id"]);
    }
    
    $usuario->setNomeUsuario($_POST["nome"]);
    $usuario->setTipo($_POST["tipo"]);
    $usuario->setEmail($_POST["email"]);
    $usuario->setSenha($_POST["senha"]);

    $daoUsuario->save($usuario);
    unset($usuario);
}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "upd" && $_REQUEST["id"]) {
    $id = $_REQUEST["id"];
    $usuario = new Usuario();
    $usuario = $daoUsuario->update($id);
}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "del" && $_REQUEST["id"]) {
    $id = $_REQUEST["id"];
    $daoUsuario->delete($id);
}


?>

    <div class='content' xmlns="http://www.w3.org/1999/html">
        <div class='container-fluid'>
            <div class='row'>
                <div class='col-md-12'>
                    <div class='card'>
                        <div class='header'>
                            <h4 class='title'>Usuários</h4>
                            <p class='category'>Lista de Usuários do Sistema</p>
                        </div>
                        <div class='content table-responsive'>
                            <form action="?act=save&id=" method="POST">
                                <input type="hidden" name="id" value="<?php if(isset($usuario) && $usuario->getIdtbUsuario() != "") echo $usuario->getIdtbUsuario()?>">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="">Nome</label>
                                            <input type="text" name="nome" class="form-control" value="<?php if(isset($usuario) && $usuario->getIdtbUsuario() != "") echo $usuario->getNomeUsuario()?>">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="">Email</label>
                                            <input type="email" name="email" class="form-control" value="<?php if(isset($usuario) && $usuario->getIdtbUsuario() != "") echo $usuario->getEmail()?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="">Tipo</label>
                                            <select class="custom-select" name="tipo">
                                                <?php                                                
                                                    foreach($tipoUsuario as $value){
                                                        print_r($value);
                                                        if(isset($usuario) && $usuario->getIdtbUsuario() != "" && $usuario->getTipo() == $value->getId()){
                                                            ?>
                                                                <option value="<?php echo $value->getId()?>" selected><?php echo $value->getNome();?></option>
                                                            <?php 
                                                        }else{
                                                            ?>
                                                                <option value="<?php echo $value->getId()?>"><?php echo $value->getNome();?></option>
                                                            <?php
                                                        }
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="">Senha</label>
                                            <input type="password" name="senha" class="form-control" value="<?php if(isset($usuario) && $usuario->getIdtbUsuario() != "") echo $usuario->getSenha()?>">
                                        </div>
                                    </div>
                                </div>
                                

                                </div>
                                <div class="col-md-3 d-flex align-items-center mb-3">
                                    <button class='btn btn-success' type="submit">Cadastrar</button>
                                </div>
                            </form>
                        </div>
                        <?php
                            $daoUsuario->tabelapaginada();
                        ?>
                    </div>                    
                </div>
            </div>
        </div>
    </div>


<?php
    template::footer();
?>



