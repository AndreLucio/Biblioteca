<?php
if (!isset($_SESSION)) {
    session_start();
}

if($_SESSION['tipo'] != 4){
    header('location:index.php');
}

require_once "view/template.php";
require_once "dao/daoCategoria.php";
require_once "dao/daoEditora.php";
require_once "dao/daoLivro.php";


template::header();
template::sidebar();
template::mainpanel();

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "save") {
    $livro = new Livro();
    if(isset($_POST["id"])){
        $livro->setIdLivro($_POST["id"]);
    }
    $livro->setTitulo($_POST["titulo"]);
    $livro->setIsbn($_POST["isbn"]);
    $livro->setAno($_POST["ano"]);
    $livro->setEdicao($_POST["edicao"]);
    $livro->setUpload($_FILES["arq"]["name"]);
    $livro->setCategoria($_POST["categoria"]);
    $livro->setEditora($_POST["editora"]);

    if (isset($_POST['MAX_FILE_SIZE'])){
        $dir = "uploads/";
        $file = $_FILES["arq"];
    echo '<pre>';
    // Move o arquivo da pasta temporaria de upload para a pasta de destino
        if (move_uploaded_file($file["tmp_name"], "$dir/".$file["name"])) {
            echo "Arquivo válido e enviado com sucesso.\n";
        } else {
            echo "Falha no upload de arquivo!\n";
        }
    print "</pre>";
    }

    $daoLivro = new daoLivro();
    $daoLivro->salvar($livro);
    unset($livro);

}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "upd" && $_REQUEST["id"]) {
    $id = $_REQUEST["id"];
    $daoLivro = new daoLivro();
    $livro = new Livro();
    $livro = $daoLivro->select($id);
}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "del" && $_REQUEST["id"]) {
    $id = $_REQUEST["id"];
    $daoLivro = new daoLivro();
    $daoLivro->remover($id);
}


?>

    <div class='content' xmlns="http://www.w3.org/1999/html">
        <div class='container-fluid'>
            <div class='row'>
                <div class='col-md-12'>
                    <div class='card'>
                        <div class='header'>
                            <h4 class='title'>Livros</h4>
                            <p class='category'>Lista de Livros do Sistema</p>
                        </div>
                        <div class='content table-responsive'>
                            <form enctype="multipart/form-data" action="?act=save&id=" method="POST">
                                <input type="hidden" name="id" value="<?php if(isset($livro) && $livro != null) {echo $livro->getIdLivro();}?>">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="">Título</label>
                                        <input type="text" name="titulo" class="form-control" value="<?php if(isset($livro) && $livro != null) {echo $livro->getTitulo();}?>">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="">ISBN</label>
                                        <input type="text" name="isbn" class="form-control" value="<?php if(isset($livro) && $livro != null) {echo $livro->getIsbn();}?>">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-2">
                                        <label for="">Edição:</label>
                                        <input type="number" name="edicao" class="form-control" value="<?php if(isset($livro) && $livro != null) {echo $livro->getEdicao();}?>">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="">Ano:</label>
                                        <input type="number" name="ano" class="form-control" value="<?php if(isset($livro) && $livro != null) {echo $livro->getAno();}?>">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="inputState">Categoria</label>
                                        <select name="categoria" id="inputState" class="form-control">
                                            <option value="0" selected>Selecione</option>

                                            <?php

                                            $daoCategoria = new daoCategoria();
                                            $categorias = $daoCategoria->selectAll();
                                            foreach($categorias as $categoria){
                                                if(isset($livro) && $livro != null && $categoria->getNomeCategoria() == $livro->getCategoria()){
                                                ?>
                                                    <option value="<?php echo $categoria->getIdCategoria() ?>" selected><?php echo $categoria->getNomeCategoria()?></option>
                                                <?php
                                                }else{ ?>
                                                <option value="<?php echo $categoria->getIdCategoria() ?>"><?php echo $categoria->getNomeCategoria()?></option>
                                            <?php }} ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="inputState">Editora</label>
                                        <select name="editora" id="inputState" class="form-control">
                                            <option value="0" selected>Selecione</option>
                                            <?php
                                            $daoEditora = new daoEditora();
                                            $editoras = $daoEditora->selectAll();
                                            foreach($editoras as $editora){
                                                if(isset($livro) && $livro != null && $editora->getNomeEditora() == $livro->getEditora()){
                                                ?>
                                                    <option value="<?php echo $editora->getIdEditora() ?>" selected><?php echo $editora->getNomeEditora() ?></option>
                                                 <?php
                                                }else{
                                                 ?>
                                                    <option value="<?php echo $editora->getIdEditora() ?>"><?php echo $editora->getNomeEditora() ?></option>
                                                <?php
                                                }} ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="custom-file">
                                        <!-- MAX_FILE_SIZE deve preceder o campo input -->
                                        <input type="hidden" name="MAX_FILE_SIZE" value="3000000" />
                                        <!-- O Nome do elemento input determina o nome da array $_FILES -->
                                        <input type="file" name="arq" />
                                        <label>Arquivo Digital</label>
                                    </div>

                                </div>
                                <button class='btn btn-success' type="submit">Cadastrar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <?php
                $daoLivro = new DaoLivro();
                $daoLivro->tabelapaginada();
            ?>
        </div>
    </div>


<?php
    template::footer();
?>



