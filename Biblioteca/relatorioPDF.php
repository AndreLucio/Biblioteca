<?php
if (!isset($_SESSION)) {
    session_start();
}

if($_SESSION['tipo'] != 5){
    header('location:index.php');
}

require_once "view/template.php";
require_once "dao/daoLivro.php";
require_once "modelo/livro.php";
require_once "dao/daoExemplar.php";
require_once "modelo/exemplar.php";

template::header();
template::sidebar();
template::mainpanel();
?>

    <div class='content' xmlns="http://www.w3.org/1999/html">
        <div class='container-fluid'>            
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="form-group" >
                        <label for="">Relatório</label>
                        <select name="" id="relatorioSelecionado" class="custom-select" >
                            <option value="livroExemplar">Quantidade de exemplares</option>
                            <option value="livroEmprestado">Livros emprestados</option>
                            <option value="livroReservado">Livros reservados</option>
                            <option value="usuarios">Dados dos usuários</option>
                            <option value="livroAtraso">Empréstimos em atraso</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-5">
                    <button class="btn btn-primary text-uppercase" onClick="getPDF();">
                        Gerar relatório
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="view/js/chart.js"></script>
    <script src="view/js/jquery.js"></script>
    <script src="view/js/jsPDF/dist/jspdf.debug.js"></script>
    <script src="view/js/html2canvas.js"></script>    
    <script src="view/js/relatorioPDF.js"></script>
    
<?php
    template::footer();
?>

