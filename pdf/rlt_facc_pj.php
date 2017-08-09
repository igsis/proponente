<?php 
   
// INSTALAÇÃO DA CLASSE NA PASTA FPDF.
require_once("../include/lib/fpdf/fpdf.php");
require_once("../funcoes/funcoesConecta.php");
require_once("../funcoes/funcoesGerais.php");

//CONEXÃO COM BANCO DE DADOS 
$conexao = bancoMysqli(); 
   
session_start();
  
class PDF extends FPDF
{
	// Page header
	function Header()
	{	
		// Logo
		$this->Image('../pdf/img/facc_pj.jpg',15,10,180);
		
		// Line break
		$this->Ln(20);
	}
}

//CONSULTA 
$idPessoaJuridica = $_SESSION['idUsuario'];

$pessoa = recuperaDados("usuario_pj","id",$idPessoaJuridica);
$enderecoCEP = enderecoCEP($pessoa['cep']);
$dbBanco = recuperaDados("banco","id",$idPessoaJuridica);
$rep01 = recuperaDados("representante_legal","id",$pessoa['idRepresentanteLegal1']);

$banco = $dbBanco["banco"];
$codbanco = $dbBanco["codigoBanco"];

$rua = $enderecoCEP["rua"]; 
$bairro = $enderecoCEP["bairro"];
$cidade = $enderecoCEP["cidade"];
$estado = $enderecoCEP["estado"];

//PessoaJuridica
$pjRazaoSocial = $pessoa["razaoSocial"];
$pjCNPJ = $pessoa['cnpj'];
$pjCCM = $pessoa["ccm"];
$pjNumEndereco = $pessoa["numero"];
$pjComplemento = $pessoa["complemento"];
$pjcep = $pessoa["cep"];
$pjTelefone01 = $pessoa["telefone1"];
$agencia = $pessoa["agencia"];
$conta = $pessoa["conta"];


// Representante01
$rep01Nome = $rep01["nome"];
$rep01RG = $rep01["rg"];
$rep01CPF = $rep01["cpf"];



// GERANDO O PDF:
$pdf = new PDF('P','mm','A4'); //CRIA UM NOVO ARQUIVO PDF NO TAMANHO A4
$pdf->AliasNbPages();
$pdf->AddPage();

   
$x=20;
$l=7; //DEFINE A ALTURA DA LINHA   
   
   $pdf->SetXY( $x , 40 );// SetXY - DEFINE O X (largura) E O Y (altura) NA PÁGINA

   $pdf->SetXY(112, 44);
   $pdf->SetFont('Arial','', 10);
   $pdf->Cell(10,$l,utf8_decode('X'),0,0,'L');

   $pdf->SetXY($x, 45);
   $pdf->SetFont('Arial','', 10);
   $pdf->Cell(53,$l,utf8_decode($pjCNPJ),0,0,'L');
   
   $pdf->SetXY(150, 45);
   $pdf->SetFont('Arial','', 10);
   $pdf->Cell(53,$l,utf8_decode($pjCCM),0,0,'L');
   
   $pdf->SetXY($x, 60);
   $pdf->SetFont('Arial','', 10);
   $pdf->Cell(160,$l,utf8_decode($pjRazaoSocial),0,0,'L');
   
   $pdf->SetXY($x, 75);
   $pdf->SetFont('Arial','', 10);
   $pdf->Cell(160,$l,utf8_decode("$rua".", "."$pjNumEndereco".", "."$pjComplemento"),0,0,'L');
   
   $pdf->SetXY($x, 90);
   $pdf->SetFont('Arial','', 9);
   $pdf->Cell(65,$l,utf8_decode($bairro),0,0,'L');
   $pdf->Cell(83,$l,utf8_decode($cidade),0,0,'L');
   $pdf->Cell(5,$l,utf8_decode($estado),0,0,'L');
   
   $pdf->SetXY($x, 105);
   $pdf->SetFont('Arial','', 10);
   $pdf->Cell(33,$l,utf8_decode($pjcep),0,0,'L');
   $pdf->Cell(45,$l,utf8_decode($pjTelefone01),0,0,'L');
   
   $pdf->SetXY(98, 107);
   $pdf->Cell(15,$l,utf8_decode($codbanco),0,0,'L'); 
   $pdf->Cell(40,$l,utf8_decode($agencia),0,0,'L');
   $pdf->Cell(37,$l,utf8_decode($conta),0,0,'L');
   
   $pdf->SetXY($x, 127);
   $pdf->SetFont('Arial','', 9);
   $pdf->Cell(80,$l,utf8_decode($rep01Nome),0,0,'L');
   $pdf->Cell(50,$l,utf8_decode($rep01RG),0,0,'L');


$pdf->Output();
?>