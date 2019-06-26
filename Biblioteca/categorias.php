<?php
if (!isset($_SESSION)) {
    session_start();
}

if($_SESSION['tipo'] != 4){
    header('location:index.php');
}

require_once "view/template.php";
require_once "dao/daoCategoria.php";
require_once "modelo/categoria.php";

template::header();
template::sidebar();
template::mainpanel();

$daoCategoria = new daoCategoria();

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "save") {
    $categoria = new Categoria();
    if(isset($_POST["id"])){
        $categoria->setIdCategoria($_POST["id"]);
    }
    $categoria->setNomeCategoria($_POST["nomeCategoria"]);
    
    $daoCategoria->salvar($categoria);
    unset($categoria);

}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "upd" && $_REQUEST["id"]) {
    $id = $_REQUEST["id"];
    $categoria = new Categoria();
    $categoria = $daoCategoria->atualizar($id);
}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "del" && $_REQUEST["id"]) {
    $id = $_REQUEST["id"];
    $daoCategoria->remover($id);
}


?>

    <div class='content' xmlns="http://www.w3.org/1999/html">
        <div class='container-fluid'>
            <div class='row'>
                <div class='col-md-12'>
                    <div class='card'>
                        <div class='header'>
                            <h4 class='title'>Categorias</h4>
                            <p class='category'>Lista de Categorias do Sistema</p>
                        </div>
                        <div class='content table-responsive'>
                            <form action="?act=save&id=" method="POST">
                                <input type="hidden" name="id" value="<?php if(isset($categoria) && $categoria != null) {echo $categoria->getIdCategoria();}?>">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="">Nome</label>
                                        <input type="text" name="nomeCategoria" class="form-control" value="<?php if(isset($categoria) && $categoria != null) {echo $categoria->getNomeCategoria();}?>">
                                    </div>
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
                $daoCategoria->tabelaPaginada();
            ?>
        </div>
    </div>


<?php
    template::footer();
?>



