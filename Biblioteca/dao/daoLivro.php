<?php

require_once "modelo/livro.php";
require_once "db/Conexao.php";

class daoLivro{

    public function salvar($source)
    {
        try {
            if ($source->getIdLivro() != "") {
                $statement = Conexao::getInstance()->prepare(" UPDATE tb_livro 
                                                                            SET titulo = :titulo, 
                                                                                isbn = :isbn, 
                                                                                edicao = :edicao, 
                                                                                ano = :ano, 
                                                                                upload = :upload, 
                                                                                tb_editora_idtb_editora = :editora, 
                                                                                tb_categoria_idtb_categoria = :categoria 
                                                                          WHERE idtb_livro = :idLivro");
                $statement->bindValue(":idLivro", $source->getIdLivro());
            } else {
                $statement = Conexao::getInstance()->prepare("INSERT INTO tb_livro (ano, 
                                                                                              edicao, 
                                                                                              isbn, 
                                                                                              tb_categoria_idtb_categoria, 
                                                                                              tb_editora_idtb_editora, 
                                                                                              titulo, 
                                                                                              upload) 
                                                                              VALUES(:ano, 
                                                                                     :edicao, 
                                                                                     :isbn, 
                                                                                     :categoria, 
                                                                                     :editora, 
                                                                                     :titulo, 
                                                                                     :upload)");
            }
            $statement->bindValue(":titulo", $source->getTitulo());
            $statement->bindValue(":isbn", $source->getIsbn());
            $statement->bindValue(":edicao", $source->getEdicao());
            $statement->bindValue(":ano", $source->getAno());
            $statement->bindValue(":upload", $source->getUpload());
            $statement->bindValue(":editora", $source->getEditora());
            $statement->bindValue(":categoria", $source->getCategoria());
            if ($statement->execute()) {
                if ($statement->rowCount() > 0) {
                    return "<script> alert('Dados cadastrados com sucesso !'); </script>";
                } else {
                    return "<script> alert('Erro ao tentar efetivar cadastro !'); </script>";
                }
            } else {
                throw new PDOException("<script> alert('Não foi possível executar a declaração SQL !'); </script>");
            }
        } catch (PDOException $erro) {
            return "Erro: " . $erro->getMessage();
        }
    }

    public function selectAll(){
        try {
            $statement = Conexao::getInstance()->prepare("SELECT a.idtb_livro AS IdLivro,
                                                                           a.titulo AS Titulo,
                                                                           a.isbn AS ISBN,
                                                                           a.edicao AS Edicao,
                                                                           a.ano AS Ano,
                                                                           a.upload AS Upload,
                                                                           b.nomeEditora AS Editora, 
                                                                           c.nomeCategoria AS Categoria
                                                                      FROM tb_livro a 
                                                                INNER JOIN tb_editora b 
                                                                        ON a.tb_editora_idtb_editora = b.idtb_editora
                                                                INNER JOIN tb_categoria c 
                                                                        ON a.tb_categoria_idtb_categoria = C.idtb_categoria ");
            if ($statement->execute()) {
                $livros = [];
                while($rs = $statement->fetch(PDO::FETCH_OBJ)) {
                    $livro = new livro;
                    $livro->setIdLivro($rs->IdLivro);
                    $livro->setTitulo($rs->Titulo);
                    $livro->setIsbn($rs->ISBN);
                    $livro->setAno($rs->Ano);
                    $livro->setEdicao($rs->Edicao);
                    $livro->setUpload($rs->Upload);
                    $livro->setEditora($rs->Editora);
                    $livro->setCategoria($rs->Categoria);
                    array_push($livros, $livro);
                }
                return $livros;
            } else {
                throw new PDOException("<script> alert('Não foi possível executar a declaração SQL !'); </script>");
            }
        } catch (PDOException $erro) {
            return "Erro: " . $erro->getMessage();
        }
    }

    public function select($id){
        try {
            $statement = Conexao::getInstance()->prepare("SELECT a.idtb_livro AS IdLivro,
                                                                           a.titulo AS Titulo,
                                                                           a.isbn AS ISBN,
                                                                           a.edicao AS Edicao,
                                                                           a.ano AS Ano,
                                                                           a.upload AS Upload,
                                                                           b.nomeEditora AS Editora, 
                                                                           c.nomeCategoria AS Categoria
                                                                      FROM tb_livro a 
                                                                INNER JOIN tb_editora b 
                                                                        ON a.tb_editora_idtb_editora = b.idtb_editora
                                                                INNER JOIN tb_categoria c 
                                                                        ON a.tb_categoria_idtb_categoria = C.idtb_categoria 
                                                                     WHERE a.idtb_livro = " . $id);
            if ($statement->execute()) {
                $rs = $statement->fetch(PDO::FETCH_OBJ);
                $livro = new livro;
                $livro->setIdLivro($rs->IdLivro);
                $livro->setTitulo($rs->Titulo);
                $livro->setIsbn($rs->ISBN);
                $livro->setAno($rs->Ano);
                $livro->setEdicao($rs->Edicao);
                $livro->setUpload($rs->Upload);
                $livro->setEditora($rs->Editora);
                $livro->setCategoria($rs->Categoria);

                return $livro;
            } else {
                throw new PDOException("<script> alert('Não foi possível executar a declaração SQL !'); </script>");
            }
        } catch (PDOException $erro) {
            return "Erro: " . $erro->getMessage();
        }
    }

    public function remover($id)
    {
        try {
            $statement = Conexao::getInstance()->prepare("DELETE FROM tb_livro WHERE idtb_livro = :id");
            $statement->bindValue(":id", $id);
            if ($statement->execute()) {
                return "<script> alert('Registo foi excluído com êxito !'); </script>";
            } else {
                throw new PDOException("<script> alert('Não foi possível executar a declaração SQL !'); </script>");
            }
        } catch (PDOException $erro) {
            return "Erro: " . $erro->getMessage();
        }
    }
    

//INSERT INTO tb_autores (nomeAutor) VALUES ('Gomes, S.');
//INSERT INTO tb_categoria (nomeCategoria) VALUES ('Suspense');
//INSERT INTO tb_editora (nomeEditora) VALUES ('Record');
//INSERT INTO tb_livro (ano, edicao, isbn, tb_categoria_idtb_categoria, tb_editora_idtb_editora, titulo, upload) VALUES(2001, 1, '9781405606592', 1, 1, 'O Jardim de Ossos', NULL)
//INSERT INTO tb_livro_autor (tb_livro_idtb_livro, tb_autores_idtb_autores) values (1, 13)
//INSERT INTO tb_exemplar (tb_livro_idtb_livro, tipoExemplar) values (1, 'Fisico')

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
        $sql = "SELECT * FROM tb_livro LIMIT {$linha_inicial}, " . QTDE_REGISTROS;
        $statement = Conexao::getInstance()->prepare($sql);
        $statement->execute();
        $dados = $statement->fetchAll(PDO::FETCH_OBJ);
        /* Conta quantos registos existem na tabela */
        $sqlContador = "SELECT COUNT(*) AS total_registros FROM tb_livro";
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
        <th style='text-align: center; font-weight: bolder;'>ID</th>
        <th style='text-align: center; font-weight: bolder;'>Título</th>
        <th style='text-align: center; font-weight: bolder;'>Ano</th>
        <th style='text-align: center; font-weight: bolder;'>Edição</th>
        <th style='text-align: center; font-weight: bolder;'>Categoria</th>
        <th style='text-align: center; font-weight: bolder;'>Editora</th>
        <th style='text-align: center; font-weight: bolder;' colspan='2'>Ações</th>
       </tr>
     </thead>
     <tbody>";
            foreach ($dados as $source):
                echo "<tr>
                        <td style='text-align: center'>" . $source->idtb_livro . "</td>
                        <td style='text-align: center'>" . $source->titulo . "</td>
                        <td style='text-align: center'>" . $source->ano . "</td>
                        <td style='text-align: center'>" . $source->edicao . "</td>
                        <td style='text-align: center'>" . $source->tb_categoria_idtb_categoria . "</td>
                        <td style='text-align: center'>" . $source->tb_editora_idtb_editora . "</td>
                        <td style='text-align: center'><a href='?act=upd&id=" . $source->idtb_livro . "' title='Alterar'><i class='ti-reload'></i></a></td>
                        <td style='text-align: center'><a href='?act=del&id=" . $source->idtb_livro . "' title='Remover'><i class='ti-close'></i></a></td>
                      </tr>";
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
