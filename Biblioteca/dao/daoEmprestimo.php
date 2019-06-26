<?php

require_once "IPage.php";
require_once "modelo/emprestimo.php";
require_once "db/Conexao.php";

class daoEmprestimo
{

    public function salvar($emprestimo)
    {
        try {
                $statement = Conexao::getInstance()->prepare("INSERT INTO tb_emprestimo (
                                                                          tb_usuaio_idtb_usuaio, 
                                                                          tb_exemplar_idtb_exemplar, 
                                                                          dataEmprestimo, 
                                                                          observacao,
                                                                          vencimento,
                                                                          tipo ) 
                                                                   VALUES (
                                                                          :usuario,
                                                                          :exemplar,
                                                                          :dataEmprestimo,
                                                                          :obsevacao,
                                                                          :vencimento,
                                                                          :tipo )");
            $statement->bindValue(":usuario", $emprestimo->getUsuario());
            $statement->bindValue(":exemplar", $emprestimo->getExemplar());
            $statement->bindValue(":dataEmprestimo", $emprestimo->getDataEmprestimo());
            $statement->bindValue(":obsevacao", $emprestimo->getObservacao());
            $statement->bindValue(":vencimento", $emprestimo->getVencimento());
            $statement->bindValue(":tipo", $emprestimo->getTipo());
            if($statement->execute()){
                if($statement->rowCount() > 0){
                    return "<script>alert('Exemplar cadastrada com sucesso!')</script>";
                }else{
                    return "<script>alert('Erro ao cadastradar exemplar!')</script>";
                }
            }else{
                throw new PDOException("<script>alert('Não foi possível executar a declaração SQL !')</script>");
            }
        } catch (PDOException $erro) {
            return "Erro: " . $erro->getMessage();
        }
    }

    public function tornarEmprestimo($emprestimo){
        try {
            $statement = Conexao::getInstance()->prepare("UPDATE tb_emprestimo a 
                                                             SET a.tipo = :tipo,
                                                                 a.dataEmprestimo = NOW(),
                                                                 a.vencimento = :vencimento
                                                           WHERE a.tb_usuaio_idtb_usuaio = 
                                                                (SELECT a.idtb_usuaio 
                                                                   FROM tb_usuaio a 
                                                                  WHERE a.nomeUsuario = :usuario)
                                                             AND a.tb_exemplar_idtb_exemplar = 
                                                                 (SELECT a.idtb_exemplar 
                                                                    FROM tb_exemplar a 
                                                              INNER JOIN tb_livro b 
                                                                      ON a.tb_livro_idtb_livro = b.idtb_livro 
                                                                   WHERE b.titulo = :titulo
                                                                     AND a.tipoExemplar = 1)");
            $statement->bindValue(":usuario", $emprestimo->getUsuario());
            $statement->bindValue(":titulo", $emprestimo->getExemplar());
            $statement->bindValue(":tipo", $emprestimo->getTipo());
            $statement->bindValue(":vencimento", $emprestimo->getVencimento());

        if($statement->execute()){
            if($statement->rowCount() > 0){
                return "<script>alert('Exemplar cadastrada com sucesso!')</script>";
            }else{
                return "<script>alert('Erro ao cadastradar exemplar!')</script>";
            }
        }else{
            throw new PDOException("<script>alert('Não foi possível executar a declaração SQL !')</script>");
        }
    } catch (PDOException $erro) {
        return "Erro: " . $erro->getMessage();
    }
    }

    public function devolverLivro($emprestimo){
        try {
            $statement = Conexao::getInstance()->prepare("UPDATE tb_emprestimo a 
                                                             SET dt_entrega = NOW() 
                                                           WHERE a.tb_usuaio_idtb_usuaio = 
                                                                (SELECT a.idtb_usuaio 
                                                                   FROM tb_usuaio a 
                                                                  WHERE a.nomeUsuario = :usuario)
                                                             AND a.tb_exemplar_idtb_exemplar = 
                                                                 (SELECT a.idtb_exemplar 
                                                                    FROM tb_exemplar a 
                                                              INNER JOIN tb_livro b 
                                                                      ON a.tb_livro_idtb_livro = b.idtb_livro 
                                                                   WHERE b.titulo = :titulo
                                                                     AND a.tipoExemplar = 1)");
            $statement->bindValue(":usuario", $emprestimo->getUsuario());
            $statement->bindValue(":titulo", $emprestimo->getExemplar());

        if($statement->execute()){
            if($statement->rowCount() > 0){
                return "<script>alert('Exemplar cadastrada com sucesso!')</script>";
            }else{
                return "<script>alert('Erro ao cadastradar exemplar!')</script>";
            }
        }else{
            throw new PDOException("<script>alert('Não foi possível executar a declaração SQL !')</script>");
        }
    } catch (PDOException $erro) {
        return "Erro: " . $erro->getMessage();
    }
    }

    public function retornaEmprestimosMes(){
        try {
            $mesesAno = array('Janeiro', 
                            'Fevereiro',
                            'Março',
                            'Abril',
                            'Maio',
                            'Junho',
                            'Julho',
                            'Agosto',
                            'Setembro',
                            'Outubro',
                            'Novembro',
                            'Dezembro'); 
            $statement = Conexao::getInstance()->prepare("SELECT COUNT(*) AS totMes,
                                                                 MONTH(dataEmprestimo) AS mes FROM tb_emprestimo 
            WHERE DATE_ADD(dataEmprestimo, INTERVAL 3 MONTH) >= NOW() AND tipo = 1
            GROUP BY MONTH(dataEmprestimo);) >= NOW()");
            if($statement->execute()){
                if($statement->rowCount() > 0){
                    $labels = array();
                    $datas = array();
                    while($rs = $statement->fetch(PDO::FETCH_OBJ)){
                        array_push($labels, $mesesAno[$rs->mes -1]);
                        array_push($datas, $rs->totMes);
                    }
                    $retorno = array($labels, $datas);
                    return $retorno;
                }else{
                    return "<script>alert('Erro ao cadastradar exemplar!')</script>";
                }
            }else{
                throw new PDOException("<script>alert('Não foi possível executar a declaração SQL !')</script>");
            }
        } catch (PDOException $erro) {
            return "Erro: " . $erro->getMessage();
        }
    }

    public function retornaReservasMes(){
        try {
            $mesesAno = array('Janeiro', 
                            'Fevereiro',
                            'Março',
                            'Abril',
                            'Maio',
                            'Junho',
                            'Julho',
                            'Agosto',
                            'Setembro',
                            'Outubro',
                            'Novembro',
                            'Dezembro'); 
            $statement = Conexao::getInstance()->prepare("SELECT COUNT(*) AS totMes,
                                                                 MONTH(dataEmprestimo) AS mes FROM tb_emprestimo 
            WHERE DATE_ADD(dataEmprestimo, INTERVAL 3 MONTH) >= NOW() AND tipo = 0
            GROUP BY MONTH(dataEmprestimo);) >= NOW()");
            if($statement->execute()){
                if($statement->rowCount() > 0){
                    $labels = array();
                    $datas = array();
                    while($rs = $statement->fetch(PDO::FETCH_OBJ)){
                        array_push($labels, $mesesAno[$rs->mes -1]);
                        array_push($datas, $rs->totMes);
                    }
                    $retorno = array($labels, $datas);
                    return $retorno;
                }else{
                    return "<script>alert('Erro ao cadastradar exemplar!')</script>";
                }
            }else{
                throw new PDOException("<script>alert('Não foi possível executar a declaração SQL !')</script>");
            }
        } catch (PDOException $erro) {
            return "Erro: " . $erro->getMessage();
        }
    }

    public function retornaReservasCategoria(){
        try { 
            $statement = Conexao::getInstance()->prepare("SELECT d.nomeCategoria AS categoria, count(a.tipo) AS totMes FROM tb_emprestimo a 
            INNER JOIN tb_exemplar b 
            ON a.tb_exemplar_idtb_exemplar = b.idtb_exemplar
            INNER JOIN tb_livro c 
            ON b.tb_livro_idtb_livro = c.idtb_livro
            INNER JOIN tb_categoria d 
            ON c.tb_categoria_idtb_categoria = d.idtb_categoria
            WHERE DATE_ADD(a.dataEmprestimo, INTERVAL 3 MONTH) >= NOW() AND a.tipo = 0
            GROUP BY d.nomeCategoria");
            if($statement->execute()){
                if($statement->rowCount() > 0){
                    $labels = array();
                    $datas = array();
                    while($rs = $statement->fetch(PDO::FETCH_OBJ)){
                        array_push($labels, $rs->categoria);
                        array_push($datas, $rs->totMes);
                    }
                    $retorno = array($labels, $datas);
                    return $retorno;
                }else{
                    return "<script>alert('Erro ao cadastradar exemplar!')</script>";
                }
            }else{
                throw new PDOException("<script>alert('Não foi possível executar a declaração SQL !')</script>");
            }
        } catch (PDOException $erro) {
            return "Erro: " . $erro->getMessage();
        }
    }

    public function retornaEmprestimoCategoria(){
        try { 
            $statement = Conexao::getInstance()->prepare("SELECT d.nomeCategoria AS categoria, count(a.tipo) AS totMes FROM tb_emprestimo a 
            INNER JOIN tb_exemplar b 
            ON a.tb_exemplar_idtb_exemplar = b.idtb_exemplar
            INNER JOIN tb_livro c 
            ON b.tb_livro_idtb_livro = c.idtb_livro
            INNER JOIN tb_categoria d 
            ON c.tb_categoria_idtb_categoria = d.idtb_categoria
            WHERE DATE_ADD(a.dataEmprestimo, INTERVAL 3 MONTH) >= NOW() AND a.tipo = 1
            GROUP BY d.nomeCategoria");
            if($statement->execute()){
                if($statement->rowCount() > 0){
                    $labels = array();
                    $datas = array();
                    while($rs = $statement->fetch(PDO::FETCH_OBJ)){
                        array_push($labels, $rs->categoria);
                        array_push($datas, $rs->totMes);
                    }
                    $retorno = array($labels, $datas);
                    return $retorno;
                }else{
                    return "<script>alert('Erro ao cadastradar exemplar!')</script>";
                }
            }else{
                throw new PDOException("<script>alert('Não foi possível executar a declaração SQL !')</script>");
            }
        } catch (PDOException $erro) {
            return "Erro: " . $erro->getMessage();
        }
    }

    public function retornaEmprestimoReservaMes(){
        try { 
            $statement = Conexao::getInstance()->prepare("SELECT COUNT(*) AS totMes,
            IF(tipo = 0,'Reserva','Empréstimo')AS tipo 
            FROM tb_emprestimo
            WHERE DATE_ADD(dataEmprestimo, INTERVAL 1 MONTH) >= NOW()
            GROUP BY tipo");
            if($statement->execute()){
                if($statement->rowCount() > 0){
                    $labels = array();
                    $datas = array();
                    while($rs = $statement->fetch(PDO::FETCH_OBJ)){
                        array_push($labels, $rs->tipo);
                        array_push($datas, $rs->totMes);
                    }
                    $retorno = array($labels, $datas);
                    return $retorno;
                }else{
                    return "<script>alert('Erro ao cadastradar exemplar!')</script>";
                }
            }else{
                throw new PDOException("<script>alert('Não foi possível executar a declaração SQL !')</script>");
            }
        } catch (PDOException $erro) {
            return "Erro: " . $erro->getMessage();
        }
    }
    public function tabelapaginada()
    {
        //endereço atual da página
        $endereco = $_SERVER ['PHP_SELF'];
        /* Constantes de configuração */
        define('QTDE_REGISTROS', 2);
        define('RANGE_PAGINAS', 3);
        /* Recebe o número da página via parâmetro na URL */
        $pagina_atual = (isset($_GET['page']) && is_numeric($_GET['page'])) ? $_GET['page'] : 1;
        /* Calcula a linha inicial da consulta */
        $linha_inicial = ($pagina_atual - 1) * QTDE_REGISTROS;
        /* Instrução de consulta para paginação com MySQL */
        $sql = " SELECT b.nomeUsuario AS nomeUsuario, 
                        d.titulo AS titulo, 
                        a.dataEmprestimo AS dataEmprestimo, 
                        a.dt_entrega AS dataEntrega,
                        a.observacao AS observacao,
                        a.vencimento AS vencimento,
                        a.tipo AS tipo
                   FROM tb_emprestimo a 
             INNER JOIN tb_usuaio b 
                     ON a.tb_usuaio_idtb_usuaio = b.idtb_usuaio
             INNER JOIN tb_exemplar c 
                     ON a.tb_exemplar_idtb_exemplar = c.idtb_exemplar
             INNER JOIN tb_livro d 
                     ON c.tb_livro_idtb_livro = d.idtb_livro
               ORDER BY a.dataEmprestimo DESC
                 LIMIT {$linha_inicial}, " . QTDE_REGISTROS;
        $statement = Conexao::getInstance()->prepare($sql);
        $statement->execute();
        $dados = $statement->fetchAll(PDO::FETCH_OBJ);
        /* Conta quantos registos existem na tabela */
        $sqlContador = "SELECT COUNT(*) AS total_registros FROM tb_emprestimo";
        $statement = Conexao::getInstance()->prepare($sqlContador);
        $statement->execute();
        $valor = $statement->fetch(PDO::FETCH_OBJ);
        /* Idêntifica a primeira página */
        $primeira_pagina = 1;
        /* Cálcula qual será a última página */
        $ultima_pagina = ceil($valor->total_registros / QTDE_REGISTROS);
        /* Cálcula qual será a página anterior em relação a página atual em exibição */
        $pagina_anterior = ($pagina_atual > 1) ? $pagina_atual - 1 : 0;
        /* Cálcula qual será a pŕoxima página em relação a página atual em exibição */
        $proxima_pagina = ($pagina_atual < $ultima_pagina) ? $pagina_atual + 1 : 0;
        /* Cálcula qual será a página inicial do nosso range */
        $range_inicial = (($pagina_atual - RANGE_PAGINAS) >= 1) ? $pagina_atual - RANGE_PAGINAS : 1;
        /* Cálcula qual será a página final do nosso range */
        $range_final = (($pagina_atual + RANGE_PAGINAS) <= $ultima_pagina) ? $pagina_atual + RANGE_PAGINAS : $ultima_pagina;
        /* Verifica se vai exibir o botão "Primeiro" e "Pŕoximo" */
        $exibir_botao_inicio = ($range_inicial < $pagina_atual) ? 'mostrar' : 'esconder';
        /* Verifica se vai exibir o botão "Anterior" e "Último" */
        $exibir_botao_final = ($range_final > $pagina_atual) ? 'mostrar' : 'esconder';
        if (!empty($dados)):
            echo "
     <table class='table table-striped table-bordered'>
     <thead>
       <tr style='text-transform: uppercase;' class='active'>
        <th style='text-align: center; font-weight: bolder;'>Usuário</th>
        <th style='text-align: center; font-weight: bolder;'>Livro</th>
        <th style='text-align: center; font-weight: bolder;'>Situação</th>
        <th style='text-align: center; font-weight: bolder;'>Vencimento</th>
        <th style='text-align: center; font-weight: bolder;'>Tipo</th>
        <th style='text-align: center; font-weight: bolder;'>Dada de entrega</th>
        <th style='text-align: center; font-weight: bolder;'>Obeservações</th>
        <th style='text-align: center; font-weight: bolder;' colspan='2'>Ações</th>
       </tr>
     </thead>
     <tbody>";
            foreach ($dados as $source):
                echo "<tr>
        <td style='text-align: center'> $source->nomeUsuario </td>
        <td style='text-align: center'> $source->titulo </td>
        <td style='text-align: center'>". ($source->dataEntrega == null ? "EMPRESTADO" : "DEVOLVIDO") . "</td>
        <td style='text-align: center'> $source->vencimento </td>
        <td style='text-align: center'> ". ($source->tipo == 0 ? "RESERVA" : "EMPRESTIMO") ." </td>
        <td style='text-align: center'> $source->dataEntrega </td>
        <td style='text-align: center'> $source->observacao </td>". 
        ($source->tipo == 1 ? ($source->dataEntrega == null ?"<td style='text-align: center'><a href='?act=upd&usuario=$source->nomeUsuario&titulo=$source->titulo' title='Devolver'><i class='ti-reload'></i></a></td>": "<td></td>"): "<td style='text-align: center'><a href='?act=emp&usuario=$source->nomeUsuario&titulo=$source->titulo&dt-emprestimo=$source->dataEmprestimo' title='Tornar Empréstimo'><i class='ti-reload'></i></a></td>") ."</tr>";
            endforeach;
            echo "
</tbody>
    </table>
     <div class='box-paginacao' style='text-align: center'>
       <a class='box-navegacao  $exibir_botao_inicio' href='$endereco?page=$primeira_pagina' title='Primeira Página'> Primeira  |</a>
       <a class='box-navegacao  $exibir_botao_inicio' href='$endereco?page=$pagina_anterior' title='Página Anterior'> Anterior  |</a>
";
            /* Loop para montar a páginação central com os números */
            for ($i = $range_inicial; $i <= $range_final; $i++):
                $destaque = ($i == $pagina_atual) ? 'destaque' : '';
                echo "<a class='box-numero $destaque' href='$endereco?page=$i'> ( $i ) </a>";
            endfor;
            echo "<a class='box-navegacao $exibir_botao_final' href='$endereco?page=$proxima_pagina' title='Próxima Página'>| Próxima  </a>
                  <a class='box-navegacao $exibir_botao_final' href='$endereco?page=$ultima_pagina'  title='Última Página'>| Última  </a>
     </div>";
        else:
            echo "<p class='bg-danger'>Nenhum registro foi encontrado!</p>
     ";
        endif;
    }

}