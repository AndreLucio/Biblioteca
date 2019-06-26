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
                    <div class="form-group">
                        <label for="">Gráfico</label>
                        <select name="" id="grafico" class="custom-select">
                            <option value="0">Empréstimos / 3 Mês </option>
                            <option value="1">Reserva / 3 Mês </option>
                            <option value="2">Reserva / Categoria </option>
                            <option value="3">Emprestimo / Categoria </option>
                            <option value="4">Reserva / Emprestimo / Mês </option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <button class="btn btn-secondary text-uppercase" onClick="getPDF();">
                        Gerar gráfico
                    </button>
                </div>
                
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="card shadow">
                        <div class="card-header bg-info text-uppercase text-white font-weight-bold" style="font-size: .7rem;">
                            Empréstimos / 3 Meses
                        </div>
                        <div class="card-body bg-white">
                            <canvas id="relatorio" class="bg-white" width="200px" height="200px"></canvas>
                        </div>
                    </div>
                </div>
                <div id="editor"></div>

                <div class="col-md-4">
                    <div class="card shadow">
                        <div class="card-header bg-info text-uppercase text-white font-weight-bold" style="font-size: .7rem;">
                            Reserva / 3 Meses
                        </div>
                        <div class="card-body">
                            <canvas id="relatorioReserva" width="200px" height="200px"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card shadow">
                        <div class="card-header bg-info text-uppercase text-white font-weight-bold" style="font-size: .7rem;">
                            Reserva / Categoria
                        </div>
                        <div class="card-body">
                            <canvas id="relatorioReservaCategoria" width="200px" height="200px"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="card shadow">
                        <div class="card-header bg-info text-uppercase text-white font-weight-bold" style="font-size: .7rem;">
                            Emprestimo / Categoria
                        </div>
                        <div class="card-body">
                            <canvas id="relatorioEmprestimoCategoria" width="200px" height="200px"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card shadow">
                        <div class="card-header bg-info text-uppercase text-white font-weight-bold" style="font-size: .7rem;">
                            Reserva / Emprestimo / Mês
                        </div>
                        <div class="card-body">
                            <canvas id="relatorioEmprestimoReservaMes" width="200px" height="200px"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="view/js/chart.js"></script>
    <script src="view/js/jquery.js"></script>
    <script src="view/js/jsPDF/dist/jspdf.debug.js"></script>
    <script src="view/js/html2canvas.js"></script>
    <script src="view/js/relatorio.js"></script>
    
<?php
    template::footer();
?>

