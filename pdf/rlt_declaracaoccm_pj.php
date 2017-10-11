<?php 

// INSTALAÇÃO DA CLASSE NA PASTA FPDF.
require_once("../include/lib/fpdf/fpdf.php");
require_once("../funcoes/funcoesConecta.php");
require_once("../funcoes/funcoesGerais.php");

//CONEXÃO COM BANCO DE DADOS 
$conexao = bancoMysqli(); 
   
session_start();
   
//CONSULTA 
$idPessoaJuridica = $_SESSION['idUser'];

$pessoa = recuperaDados("usuario_pj","id",$idPessoaJuridica);
$enderecoCEP = enderecoCEP($pessoa['cep']);
$dbBanco = recuperaDados("banco","id",$pessoa['codigoBanco']);
$rep01 = recuperaDados("representante_legal","id",$pessoa['idRepresentanteLegal1']);

$rua = $enderecoCEP["rua"]; 
$bairro = $enderecoCEP["bairro"];
$cidade = $enderecoCEP["cidade"];
$estado = $enderecoCEP["estado"];

//PessoaJuridica
$pjRazaoSocial = $pessoa["razaoSocial"];
$pjCNPJ = $pessoa['cnpj'];
$pjNumEndereco = $pessoa["numero"];
$pjComplemento = $pessoa["complemento"];
$pjcep = $pessoa["cep"];

// Representante01
$rep01Nome = $rep01["nome"];
$rep01RG = $rep01["rg"];
$rep01CPF = $rep01["cpf"];


header("Content-type: application/vnd.ms-word");
header("Content-Disposition: attachment;Filename=declaracao-ccm-$pjRazaoSocial.doc");
echo "<html>";
echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=Windows-1252\">";
echo "<body>";
echo 
	"<p align='center'><strong>DECLARAÇÃO</strong></p>".
	"<p>&nbsp;</p>".
	"<p>Declaramos, sob as penas da lei, que a empresa ".$pjRazaoSocial.", CNPJ ".$pjCNPJ.", sediada na $rua CEP: ".$pjcep.", Bairro ".$bairro.", cidade ".$cidade.", ".$estado.", não é inscrita no CCM de São Paulo e que não tem débitos perante à Fazenda Pública Municipal de São Paulo no tocante a encargos tributários e que está ciente de que o ISS incidente sobre a operação será retido.</p>".
	"<p>&nbsp;</p>".	
	"<p>______________________________________</p>".
	"<p><strong>Nome do Representante Legal:</strong> ".$rep01Nome."</p>".
	"<p><strong>CNPJ:</strong> ".$pjCNPJ."</p>";
echo "</body>";
echo "</html>";	
?>