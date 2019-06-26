<?php
require_once 'dao/daoEmprestimo.php';
require_once 'dao/daoExemplar.php';

if(isset($_GET['metodo']) && $_GET['metodo'] == 'emprestimo'){
    $daoEmprestimo = new daoEmprestimo();
    $retorno = $daoEmprestimo->retornaEmprestimosMes();
    header('Content-type: application/json');
    echo json_encode( $retorno );
}


if(isset($_GET['metodo']) && $_GET['metodo'] == 'reserva'){
    $daoEmprestimo = new daoEmprestimo();
    $retorno = $daoEmprestimo->retornaReservasMes();
    header('Content-type: application/json');
    echo json_encode( $retorno );
}

if(isset($_GET['metodo']) && $_GET['metodo'] == 'reservaCategoria'){
    $daoEmprestimo = new daoEmprestimo();
    $retorno = $daoEmprestimo->retornaReservasCategoria();
    header('Content-type: application/json');
    echo json_encode( $retorno );
}

if(isset($_GET['metodo']) && $_GET['metodo'] == 'EmprestimoCategoria'){
    $daoEmprestimo = new daoEmprestimo();
    $retorno = $daoEmprestimo->retornaEmprestimoCategoria();
    header('Content-type: application/json');
    echo json_encode( $retorno );
}

if(isset($_GET['metodo']) && $_GET['metodo'] == 'EmprestimoReservaCategoria'){
    $daoEmprestimo = new daoEmprestimo();
    $retorno = $daoEmprestimo->retornaEmprestimoReservaMes();
    header('Content-type: application/json');
    echo json_encode( $retorno );
}

if(isset($_GET['metodo']) && $_GET['metodo'] == 'TituloExemplar'){
    $daoExemplar = new daoExemplar();
    $retorno = $daoExemplar->retornaTituloExemplar();
    header('Content-type: application/json');
    echo json_encode( $retorno );
}