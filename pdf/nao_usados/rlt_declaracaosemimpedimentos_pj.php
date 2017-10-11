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
$idPessoaJuridica = $_SESSION['idUser'];

$pessoa = recuperaDados("usuario_pj","id",$idPessoaJuridica);
$enderecoCEP = enderecoCEP($pessoa['cep']);
$dbBanco = recuperaDados("banco","id",$pessoa['codigoBanco']);
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

header("Content-type: application/vnd.ms-word");
header("Content-Disposition: attachment;Filename=declaracao-nao-impedimento.doc");
echo "<html>";
echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=Windows-1252\">";
echo "<body>";
echo 
	"<p align='center'><strong>DECLARAÇÃO DA NÃO OCORRÊNCIA DE IMPEDIMENTOS</strong></p>".
	"<p>&nbsp;</p>".
	"<p>&nbsp;</p>".
	"<ul>".
	"<li>Está regularmente constituída ou, se estrangeira, está autorizada a funcionar no território nacional;</li>".
	"<li>Não foi omissa no dever de prestar contas de parceria anteriormente celebrada;</li>".
	"<li>Não tem como dirigente membro de Poder ou do Ministério Público, ou dirigente de órgão ou entidade da administração pública da mesma esfera governamental na qual será celebrado o termo de fomento, estendendo-se a vedação aos respectivos cônjuges ou companheiros, bem como parentes em linha reta, colateral ou por afinidade, até o segundo grau. Observação: a presente vedação não se aplica às entidades que, pela sua própria natureza, sejam constituídas pelas autoridades ora referidas (o que deverá ser devidamente informado e justificado pela organização da sociedade civil), sendo vedado que a mesma pessoa figure no instrumento de parceria simultaneamente como dirigente e administrador público (art. 39, §5º, da Lei nº 13.019, de 2014);</li>".
	"<li>Não teve as contas rejeitadas pela administração pública nos últimos cinco anos, observadas as exceções previstas no art. 39, caput, inciso IV, alíneas “a” a “c”, da Lei nº 13.019, de 2014; </li>".
	"<li>Não se encontra submetida aos efeitos das sanções de suspensão de participação em licitação e impedimento de contratar com a administração, declaração de inidoneidade para licitar ou contratar com a administração pública, suspensão temporária da participação em chamamento público e impedimento de celebrar parceria ou contrato com órgãos e entidades da esfera de governo da administração pública sancionadora e, por fim, declaração de inidoneidade para participar de chamamento público ou celebrar parceria ou contrato com órgãos e entidades de todas as esferas de governo;</li>".
	"<li>Não teve contas de parceria julgadas irregulares ou rejeitadas por Tribunal ou Conselho de Contas de qualquer esfera da Federação, em decisão irrecorrível, nos últimos 8 (oito) anos; e</li>".
	"<li>Não tem entre seus dirigentes pessoa cujas contas relativas a parcerias tenham sido julgadas irregulares ou rejeitadas por Tribunal ou Conselho de Contas de qualquer esfera da Federação, em decisão irrecorrível, nos últimos 8 (oito) anos; julgada responsável por falta grave e inabilitada para o exercício de cargo em comissão ou função de confiança, enquanto durar a inabilitação; ou considerada responsável por ato de improbidade, enquanto durarem os prazos estabelecidos nos incisos I, II e III do art. 12 da Lei nº 8.429, de 2 de junho de 1992. </li>".
	"</ul>".
	"<p>&nbsp;</p>".
	"<p><center>Local-UF, ____ de ______________ de 20___</center></p>".
	"<p>&nbsp;</p>".
	"<p><center>_____________________________</center></p>".
	"<p><b><center>".$rep01Nome."<br/>
		".$rep01RG."<br/>
		".$rep01CPF."</center></b></p>";

echo "</body>";
echo "</html>";	


?>