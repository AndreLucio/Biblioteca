<?php
require_once "vendor/tecnick.com/tcpdf/tcpdf.php";
require_once "db/Conexao.php";

if($_GET['pagina'] == 'livroExemplar'){
	$sql = "SELECT a.titulo AS titulo, count(b.idtb_exemplar) AS qntExemplar FROM tb_livro a 
	INNER JOIN tb_exemplar b 
	ON a.idtb_livro = b.tb_livro_idtb_livro
	GROUP BY a.titulo";
}else if($_GET['pagina'] == 'livroEmprestado'){
	$sql = "    SELECT d.nomeUsuario AS usuario, 
				c.titulo AS livro
		   FROM tb_emprestimo a 
	 INNER JOIN tb_exemplar b 
	         ON a.tb_exemplar_idtb_exemplar = b.idtb_exemplar
	 INNER JOIN tb_livro c
	         ON b.tb_livro_idtb_livro = c.idtb_livro
	 INNER JOIN tb_usuaio d 
			 ON a.tb_usuaio_idtb_usuaio = d.idtb_usuaio
		  WHERE a.tipo = 1
		  ORDER BY d.nomeUsuario";
}else if($_GET['pagina'] == 'livroReservado'){
	$sql = "SELECT d.nomeUsuario AS usuario, c.titulo AS titulo 
	FROM tb_emprestimo a 
	INNER JOIN tb_exemplar b 
	ON a.tb_exemplar_idtb_exemplar = b.idtb_exemplar
	INNER JOIN tb_livro c 
	ON b.tb_livro_idtb_livro = c.idtb_livro 
	INNER JOIN tb_usuaio d 
	ON a.tb_usuaio_idtb_usuaio = d.idtb_usuaio
	WHERE a.tipo = 0
	ORDER BY d.nomeUsuario;";
}else if($_GET['pagina'] == 'usuarios'){
	$sql = "SELECT a.nomeUsuario AS nome, 
				   b.nome AS tipo,
				   a.email AS email
    		  FROM tb_usuaio a 
    	INNER JOIN tp_usuario_tb b 
    		 WHERE a.tipo = b.id";
}else if($_GET['pagina'] == 'livroAtraso'){
	$sql = "SELECT d.nomeUsuario AS usuario,
	c.titulo AS livro,
	a.vencimento AS vencimento,
	DATEDIFF(NOW(), a.vencimento) AS diasAtraso
FROM tb_emprestimo a 
INNER JOIN tb_exemplar b 
ON a.tb_exemplar_idtb_exemplar = b.idtb_exemplar
INNER JOIN tb_livro c 
ON b.tb_livro_idtb_livro = c.idtb_livro
INNER JOIN tb_usuaio d 
ON a.tb_usuaio_idtb_usuaio = d.idtb_usuaio
WHERE a.vencimento < NOW()
AND a.dt_entrega IS NULL
AND a.tipo = 1
ORDER BY DATEDIFF(NOW(), a.vencimento) DESC;";
}

$statement = Conexao::getInstance()->prepare($sql);
$statement->execute();
$dados = $statement->fetchAll(PDO::FETCH_ASSOC);

class MYPDF extends TCPDF {
    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Página '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}

$pdf= new MYPDF();
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('André Lúcio');
$pdf->SetTitle('Relatórios');
$pdf->SetKeywords('TCPDF, PDF, example, biblioteca, guide');

$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->AddPage();

// Set some content to print
if($_GET['pagina'] == 'livroExemplar'){
	$html = '
		<h2>Exemplares</h2>
		<table style="border-collapse: collapse;">
	    <thead>
	        <tr>
	            <th style="border: 1px solid #AFAFAF;font-weight: bold;">Titulo</th>
	            <th style="border: 1px solid #AFAFAF;font-weight: bold;">Quantidade de Exemplares</th>
	        </tr>
	    </thead>    
	    <tbody>';
	foreach ($dados as $key => $value) {
	    $html.= '
	        <tr>
	            <td style="border: 1px solid #AFAFAF;">'.$value['titulo'].'</td>
	            <td style="border: 1px solid #AFAFAF;">'.$value['qntExemplar'].'</td>
	        </tr>';
	}
	$html.='
	    </tbody>
	</table>
	';
}else if($_GET['pagina'] == 'livroEmprestado'){
	$html = '
		<h2>Livros emprestados</h2>
		<table style="border-collapse: collapse;">
	    <thead>
	        <tr>
	            <th style="border: 1px solid #AFAFAF;font-weight: bold;">Usuário</th>
	            <th style="border: 1px solid #AFAFAF;font-weight: bold;">Livro emprestado</th>	            
	        </tr>
	    </thead>    
	    <tbody>';
	foreach ($dados as $key => $value) {
	    $html.= '
	        <tr>
	            <td style="border: 1px solid #AFAFAF;">'.$value['usuario'].'</td>
	            <td style="border: 1px solid #AFAFAF;">'.$value['livro'].'</td>
	        </tr>';
	}
	$html.='
	    </tbody>
	</table>
	';
}else if($_GET['pagina'] == 'livroReservado'){
	$html = '
		<h2>Livros reservados</h2>
		<table style="border-collapse: collapse;">
	    <thead>
	        <tr>
	            <th style="border: 1px solid #AFAFAF;font-weight: bold;">Usuário</th>
	            <th style="border: 1px solid #AFAFAF;font-weight: bold;">Livro reservado</th>	            
	        </tr>
	    </thead>    
	    <tbody>';
	foreach ($dados as $key => $value) {
	    $html.= '
	        <tr>
	            <td style="border: 1px solid #AFAFAF;">'.$value['usuario'].'</td>
	            <td style="border: 1px solid #AFAFAF;">'.$value['titulo'].'</td>
	        </tr>';
	}
	$html.='
	    </tbody>
	</table>
	';
}else if($_GET['pagina'] == 'usuarios'){
	$html = '
		<h2>Dados dos usuários</h2>
		<table style="border-collapse: collapse;">
	    <thead>
	        <tr>
	            <th style="border: 1px solid #AFAFAF;font-weight: bold;">Nome</th>
	            <th style="border: 1px solid #AFAFAF;font-weight: bold;">Tipo</th>	            
	            <th style="border: 1px solid #AFAFAF;font-weight: bold;">E-mail</th>	            
	        </tr>
	    </thead>    
	    <tbody>';
	foreach ($dados as $key => $value) {
	    $html.= '
	        <tr>
	            <td style="border: 1px solid #AFAFAF;">'.$value['nome'].'</td>
	            <td style="border: 1px solid #AFAFAF;">'.$value['tipo'].'</td>
	            <td style="border: 1px solid #AFAFAF;">'.$value['email'].'</td>
	        </tr>';
	}
	$html.='
	    </tbody>
	</table>
	';
}else if($_GET['pagina'] == 'livroAtraso'){
	$html = '
		<h2>Livros em atraso</h2>
		<table style="border-collapse: collapse;">
	    <thead>
	        <tr>
	            <th style="border: 1px solid #AFAFAF;font-weight: bold;">Usuário</th>
	            <th style="border: 1px solid #AFAFAF;font-weight: bold;">Livro</th>	            
	            <th style="border: 1px solid #AFAFAF;font-weight: bold;">Vencimento</th>	            
	            <th style="border: 1px solid #AFAFAF;font-weight: bold;">Dias em atraso</th>	            
	        </tr>
	    </thead>    
	    <tbody>';
	foreach ($dados as $key => $value) {
	    $html.= '
	        <tr>
	            <td style="border: 1px solid #AFAFAF;">'.$value['usuario'].'</td>
	            <td style="border: 1px solid #AFAFAF;">'.$value['livro'].'</td>
	            <td style="border: 1px solid #AFAFAF;">'.$value['vencimento'].'</td>
	            <td style="border: 1px solid #AFAFAF;">'.$value['diasAtraso'].'</td>
	        </tr>';
	}
	$html.='
	    </tbody>
	</table>
	';
}
// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

// ---------------------------------------------------------

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('relatorio.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
