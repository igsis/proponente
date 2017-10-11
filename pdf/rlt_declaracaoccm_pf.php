<?php 

// INSTALAÇÃO DA CLASSE NA PASTA FPDF.
require_once("../include/lib/fpdf/fpdf.php");
require_once("../funcoes/funcoesConecta.php");
require_once("../funcoes/funcoesGerais.php");

//CONEXÃO COM BANCO DE DADOS 
$conexao = bancoMysqli(); 
   
session_start();
   
//CONSULTA 
$idPessoaFisica = $_SESSION['idUser'];

$pessoa = recuperaDados("usuario_pf","id",$idPessoaFisica);

$Nome = $pessoa["nome"];
$RG = $pessoa["rg"];
$CPF = $pessoa["cpf"];


header("Content-type: application/vnd.ms-word");
header("Content-Disposition: attachment;Filename=declaracao-ccm-$Nome.doc");
echo "<html>";
echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=Windows-1252\">";
echo "<body>";
echo 
	"<p align='center'><strong>DECLARAÇÃO</strong></p>".
	"<p>&nbsp;</p>".
	"<p>Declaro, sob as penas da lei, que não sou inscrito no CCM de São Paulo, que não tenho débitos perante a Fazenda Pública Municipal de São Paulo no tocante a encargos tributários e que estou ciente de que o ISS sobre a operação será retido.</p>".
	"<p>&nbsp;</p>".	
	"<p>______________________________________</p>".
	"<p><strong>Nome:</strong> ".$Nome."</p>".
	"<p><strong>RG:</strong> ".$RG."</p>".
	"<p><strong>CPF:</strong> ".$CPF."</p>";
echo "</body>";
echo "</html>";	
?>