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
		$this->Image('../pdf/img/facc_pf.jpg',15,10,180);
		
		// Line break
		$this->Ln(20);
	}
}


//CONSULTA 
$idPessoaFisica = $_SESSION['idUser'];

$pessoa = recuperaDados("usuario_pf","id",$idPessoaFisica);
$enderecoCEP = enderecoCEP($pessoa['cep']);
$dbBanco = recuperaDados("banco","id",$pessoa['codigoBanco']);

$banco = $dbBanco["banco"];
$codbanco = $dbBanco["codigoBanco"];

$rua = $enderecoCEP["rua"]; 
$bairro = $enderecoCEP["bairro"];
$cidade = $enderecoCEP["cidade"];
$estado = $enderecoCEP["estado"];

$Nome = $pessoa["nome"];
$RG = $pessoa["rg"];
$CPF = $pessoa["cpf"];
$CCM = $pessoa["ccm"];
$NumEndereco = $pessoa["numero"];
$Complemento = $pessoa["complemento"];
$cep = $pessoa["cep"];
$Telefone01 = $pessoa["telefone1"];
$agencia = $pessoa["agencia"];
$conta = $pessoa["conta"];
$cbo = $pessoa["cbo"];
$PIS = $pessoa["pis"];
$DataNascimento = exibirDataBr($pessoa["dataNascimento"]);


// GERANDO O PDF:
$pdf = new PDF('P','mm','A4'); //CRIA UM NOVO ARQUIVO PDF NO TAMANHO A4
$pdf->AliasNbPages();
$pdf->AddPage();

   
$x=20;
$l=7; //DEFINE A ALTURA DA LINHA   
   
   $pdf->SetXY( $x , 40 );// SetXY - DEFINE O X (largura) E O Y (altura) NA PÁGINA

   $pdf->SetXY(113, 40);
   $pdf->SetFont('Arial','', 10);
   $pdf->Cell(10,$l,utf8_decode('X'),0,0,'L');

   $pdf->SetXY($x, 40);
   $pdf->SetFont('Arial','', 10);
   $pdf->Cell(53,$l,utf8_decode($CPF),0,0,'L');
   
   $pdf->SetXY(155, 40);
   $pdf->SetFont('Arial','', 10);
   $pdf->Cell(53,$l,utf8_decode($CCM),0,0,'L');
   
   $pdf->SetXY($x, 55);
   $pdf->SetFont('Arial','', 10);
   $pdf->Cell(160,$l,utf8_decode($Nome),0,0,'L');
   
   $pdf->SetXY($x, 68);
   $pdf->SetFont('Arial','', 10);
   $pdf->Cell(160,$l,utf8_decode("$rua".", "."$NumEndereco".", "."$Complemento"),0,0,'L');
   
   $pdf->SetXY($x, 82);
   $pdf->SetFont('Arial','', 9);
   $pdf->Cell(68,$l,utf8_decode($bairro),0,0,'L');
   $pdf->Cell(88,$l,utf8_decode($cidade),0,0,'L');
   $pdf->Cell(5,$l,utf8_decode($estado),0,0,'L');
   
   $pdf->SetXY($x, 96);
   $pdf->SetFont('Arial','', 10);
   $pdf->Cell(33,$l,utf8_decode($cep),0,0,'L');
   $pdf->Cell(57,$l,utf8_decode($Telefone01),0,0,'L');
   $pdf->Cell(15,$l,utf8_decode($codbanco),0,0,'L');
   $pdf->Cell(35,$l,utf8_decode($agencia),0,0,'L');
   $pdf->Cell(37,$l,utf8_decode($conta),0,0,'L');
   
   $pdf->SetXY($x, 107);
   $pdf->SetFont('Arial','', 10);
   $pdf->Cell(87,$l,utf8_decode($PIS),0,0,'L');
   $pdf->Cell(52,$l,utf8_decode($DataNascimento),0,0,'L');
   $pdf->Cell(33,$l,utf8_decode($cbo),0,0,'L');
   
   $pdf->SetXY($x, 122);
   $pdf->SetFont('Arial','', 9);
   $pdf->Cell(87,$l,utf8_decode($Nome),0,0,'L');
   $pdf->Cell(50,$l,utf8_decode($RG),0,0,'L');


$pdf->Output();
?>