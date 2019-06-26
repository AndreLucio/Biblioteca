<?php
require_once "db/Conexao.php";
require_once "modelo/usuario.php";
require_once "modelo/TipoUsuario.php";

class daoUsuario{

    public function findAllTipoUsuario(){
        try {
            $statement = Conexao::getInstance()->prepare("SELECT * FROM tp_usuario_tb;");
            if ($statement->execute()) {
                $lista = array();
                $tipoUsuario = "";
                while($rs = $statement->fetch(PDO::FETCH_OBJ)){
                    $tipoUsuario = new TipoUsuario();
                    $tipoUsuario->setId($rs->id);
                    $tipoUsuario->setNome($rs->nome);
                    array_push($lista, $tipoUsuario);
                }                
                return $lista;
            } else {
                throw new PDOException("<script> alert('Não foi possível executar a declaração SQL !'); </script>");
            }
        } catch (PDOException $erro) {
            return "Erro: " . $erro->getMessage();
        }
    }

    public function logar($login, $senha){
        try{
            $statement = Conexao::getInstance()->prepare("SELECT nomeUsuario, tipo FROM tb_usuaio WHERE nomeUsuario = :login AND senha = :senha");
            $statement->bindValue(":login", $login);
            $statement->bindValue(":senha", md5($senha));
            if($statement->execute()){
                $rs = $statement->fetch(PDO::FETCH_OBJ);
                $usuario = new Usuario();
                if($rs != null){
                    $usuario->setNomeUsuario($rs->nomeUsuario);
                    $usuario->setTipo($rs->tipo);
                }else{
                    $usuario = null;
                }
                return $usuario;
            }
        } catch(PDOException $erro){
            return "Erro: " . $erro->getMessage();
        }
    }

    public function findByEmail($email){
        try{
            $statement = Conexao::getInstance()->prepare("SELECT * FROM tb_usuaio WHERE email = :email");
            $statement->bindValue(":email", $email);
            if($statement->execute()){
                $rs = $statement->fetch(PDO::FETCH_OBJ);
                $usuario = null;
                if($rs != null){
                    $usuario = new Usuario();
                    $usuario->setIdtbUsuario($rs->idtb_usuaio);
                    $usuario->setNomeUsuario($rs->nomeUsuario);
                    $usuario->setTipo($rs->tipo);
                    $usuario->setEmail($rs->email);
                    $usuario->setSenha($rs->senha);
                }                
                return $usuario;
            }
        } catch(PDOException $erro){
            return "Erro: " . $erro->getMessage();
        }
    }

    public function save($usuario){
        try {
            if($usuario->getIdtbUsuario() != ""){
                $statement = Conexao::getInstance()->prepare("UPDATE tb_usuaio SET nomeUsuario = :nomeUsuario, tipo = :tipo, email = :email, senha = :senha WHERE idtb_usuaio = :id");
                $statement->bindValue(":id", $usuario->getIdtbUsuario());
            }else{
                $statement = Conexao::getInstance()->prepare("INSERT INTO tb_usuaio (nomeUsuario, tipo, email, senha) VALUES (:nomeUsuario, :tipo, :email, :senha)");
            }
            $statement->bindValue(":nomeUsuario", $usuario->getNomeUsuario());
            $statement->bindValue(":tipo", $usuario->getTipo());
            $statement->bindValue(":email", $usuario->getEmail());
            $statement->bindValue(":senha", md5($usuario->getSenha()));
            if($statement->execute()){
                if($statement->rowCount() > 0){
                    return "<script>alert('Categoria cadastrada com sucesso!')</script>";
                }else{
                    return "<script>alert('Erro ao cadastradar categoria!')</script>";
                }
            }else{
                throw new PDOException("<script>alert('Não foi possível executar a declaração SQL !')</script>");
            }
        } catch (PDOException $erro) {
            return "Erro: " . $erro->getMessage();
        }
    }

    public function delete($id){
        try {
            $statement = Conexao::getInstance()->prepare("DELETE FROM tb_usuaio WHERE idtb_usuaio = :id");
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

    public function update($id){
        try {
            $statement = Conexao::getInstance()->prepare("   SELECT *
                                                               FROM tb_usuaio
                                                              WHERE idtb_usuaio = :id");
            $statement->bindValue(":id", $id);
            if ($statement->execute()) {
                $rs = $statement->fetch(PDO::FETCH_OBJ);
                $usuario = new Usuario();
                $usuario->setIdtbUsuario($rs->idtb_usuaio);
                $usuario->setNomeUsuario($rs->nomeUsuario);
                $usuario->setEmail($rs->email);
                $usuario->setTipo($rs->tipo);
                $usuario->setSenha(md5($rs->senha));
                return $usuario;
            } else {
                throw new PDOException("<script> alert('Não foi possível executar a declaração SQL !'); </script>");
            }
        } catch (PDOException $erro) {
            return "Erro: " . $erro->getMessage();
        }
    }

    public function selectByName($nome){
        try {
            $statement = Conexao::getInstance()->prepare("   SELECT *
                                                               FROM tb_usuaio
                                                              WHERE nomeUsuario = :nome");
            $statement->bindValue(":nome", $nome);
            if ($statement->execute()) {
                $rs = $statement->fetch(PDO::FETCH_OBJ);
                $usuario = new Usuario();
                $usuario->setIdtbUsuario($rs->idtb_usuaio);
                $usuario->setNomeUsuario($rs->nomeUsuario);
                $usuario->setEmail($rs->email);
                $usuario->setTipo($rs->tipo);
                $usuario->setSenha($rs->senha);
                return $usuario;
            } else {
                throw new PDOException("<script> alert('Não foi possível executar a declaração SQL !'); </script>");
            }
        } catch (PDOException $erro) {
            return "Erro: " . $erro->getMessage();
        }
    }

    public function selectAll(){
        try {
            $statement = Conexao::getInstance()->prepare("   SELECT *
                                                               FROM tb_usuaio");
            if ($statement->execute()) {
                $usuarios = [];
                while($rs = $statement->fetch(PDO::FETCH_OBJ)){
                    $usuario = new Usuario();
                    $usuario->setIdtbUsuario($rs->idtb_usuaio);
                    $usuario->setNomeUsuario($rs->nomeUsuario);
                    $usuario->setEmail($rs->email);
                    $usuario->setTipo($rs->tipo);
                    $usuario->setSenha($rs->senha);
                    array_push($usuarios, $usuario);
                }
                return $usuarios;
            } else {
                throw new PDOException("<script> alert('Não foi possível executar a declaração SQL !'); </script>");
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
        $sql = "SELECT * FROM tb_usuaio LIMIT {$linha_inicial}, " . QTDE_REGISTROS;
        $statement = Conexao::getInstance()->prepare($sql);
        $statement->execute();
        $dados = $statement->fetchAll(PDO::FETCH_OBJ);
        /* Conta quantos registos existem na tabela */
        $sqlContador = "SELECT COUNT(*) AS total_registros FROM tb_usuaio";
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
        <th style='text-align: center; font-weight: bolder;'>Nome</th>
        <th style='text-align: center; font-weight: bolder;'>Tipo</th>
        <th style='text-align: center; font-weight: bolder;'>Email</th>
        <th style='text-align: center; font-weight: bolder;' colspan='2'>Ações</th>
       </tr>
     </thead>
     <tbody>";
            foreach ($dados as $source):
                echo "<tr>
                        <td style='text-align: center'>" . $source->idtb_usuaio . "</td>
                        <td style='text-align: center'>" . $source->nomeUsuario . "</td>
                        <td style='text-align: center'>" . $source->tipo . "</td>
                        <td style='text-align: center'>" . $source->email . "</td>
                        <td style='text-align: center'><a href='?act=upd&id=" . $source->idtb_usuaio . "' title='Alterar'><i class='ti-reload'></i></a></td>
                        <td style='text-align: center'><a href='?act=del&id=" . $source->idtb_usuaio . "' title='Remover'><i class='ti-close'></i></a></td>
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
