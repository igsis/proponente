<?php 
	session_start();
	   @ini_set('display_errors', '1');
	error_reporting(E_ALL); 	
   
   // INSTALAÇÃO DA CLASSE NA PASTA FPDF.
   require_once("../include/lib/fpdf/fpdf.php");
   require_once("../funcoes/funcoesConecta.php");
   require_once("../funcoes/funcoesGerais.php");
   require_once("../funcoes/funcoesVerifica.php");

   //CONEXÃO COM BANCO DE DADOS 
   $conexao = bancoMysqli(); 
   

class PDF extends FPDF
{
// Page header
function Header()
{
	$inst = recuperaDados("ig_instituicao",$_SESSION['idInstituicao'],"idInstituicao");	$logo = "img/".$inst['logo']; // Logo
    $this->Image($logo,20,20,50);
    // Move to the right
    $this->Cell(80);
    $this->Image('../visual/img/logo_smc.jpg',170,10);
    // Line break
    $this->Ln(20);
}

// Simple table
function Cabecalho($header, $data)
{
    // Header
    foreach($header as $col)
        $this->Cell(40,7,$col,1);
    $this->Ln();
    // Data

}

// Simple table
function Tabela($header, $data)
{
    //Data
    foreach($data as $col)
        $this->Cell(40,7,$col,1);
    $this->Ln();
    // Data

}


// Page footer
/*
function Footer()
{
    // Position at 1.5 cm from bottom
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Page number
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}
*/

//INSERIR ARQUIVOS

function ChapterBody($file)
{
    // Read text file
    $txt = file_get_contents($file);
    // Arial 10
    $this->SetFont('Arial','',10);
    // Output justified text
    $this->MultiCell(0,5,$txt);
    // Line break
    $this->Ln();
}

function PrintChapter($file)
{
    $this->ChapterBody($file);
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

header("Content-type: application/vnd.ms-word");
header("Content-Disposition: attachment;Filename=declaracao-nao-impedimento.doc");
echo "<html>";
echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=Windows-1252\">";
echo "<body>";
echo 
	"<p align='center'><strong>DECLARAÇÃO DE NÃO SERVIDOR</strong></p>".
	"<p>&nbsp;</p>".
	"<p>&nbsp;</p>".
	"<p>Declaro para os devidos fins que a [identificação da pessoa física] que não sou servidor público municipal e que não me encontro em condições de impedimento para celebrar parceria com a Prefeitura do Município de São Paulo, Secretaria Municipal de Cultura.<p>".
	"<p>&nbsp;</p>".
	"<p><center>Local-UF, ____ de ______________ de 20___</center></p>".
	"<p>&nbsp;</p>".
	"<p><center>_____________________________</center></p>".
	"<p><b><center>".$Nome."</center></b></p><br/>".

echo "</body>";
echo "</html>";	


?>