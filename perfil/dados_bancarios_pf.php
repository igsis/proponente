﻿<?php
$con = bancoMysqli();
$idPessoaFisica = $_SESSION['idUsuario'];
$ultimo = $idPessoaFisica;

if(isset($_POST['cadastrarFisica']))
{
	$idPessoaFisica = $_POST['cadastrarFisica'];
	$Nome = addslashes($_POST['Nome']);
	$NomeArtistico = addslashes($_POST['NomeArtistico']);
	$RG = $_POST['RG'];
	$CPF = $_POST['CPF'];
	$CCM = $_POST['CCM'];
	$IdEstadoCivil = $_POST['IdEstadoCivil'];
	$DataNascimento = exibirDataMysql($_POST['DataNascimento']);
	$Nacionalidade = $_POST['Nacionalidade'];
	$CEP = $_POST['CEP'];
	$Numero = $_POST['Numero'];
	$Complemento = $_POST['Complemento'];
	$Bairro = $_POST['Bairro'];
	$Cidade = $_POST['Cidade'];
	$Telefone1 = $_POST['Telefone1'];
	$Telefone2 = $_POST['Telefone2'];
	$Telefone3 = $_POST['Telefone3'];
	$Email = $_POST['Email'];
	$DRT = $_POST['DRT'];
	$cbo = $_POST['cbo'];
	$Funcao = $_POST['Funcao'];
	$InscricaoINSS = $_POST['InscricaoINSS'];
	$OMB = $_POST['OMB'];
	$codBanco = $_POST['codBanco'];
	$agencia = $_POST['agencia'];
	$conta = $_POST['conta'];
	$Observacao = addslashes($_POST['Observacao']);
	$tipoDocumento = $_POST['tipoDocumento'];
	$Pis = 0;
	$data = date('Y-m-d');
	$idUsuario = $_SESSION['idUsuario'];
	
	$sql_atualizar_pessoa = "UPDATE sis_pessoa_fisica SET
	`Nome` = '$Nome',
	`NomeArtistico` = '$NomeArtistico',
	`RG` = '$RG', 
	`CPF` = '$CPF', 
	`CCM` = '$CCM', 
	`IdEstadoCivil` = '$IdEstadoCivil' , 
	`DataNascimento` = '$DataNascimento', 
	`Nacionalidade` = '$Nacionalidade', 
	`CEP` = '$CEP', 
	`Numero` = '$Numero', 
	`Complemento` = '$Complemento', 
	`Telefone1` = '$Telefone1', 
	`Telefone2` = '$Telefone2',  
	`Telefone3` = '$Telefone3', 
	`Email` = '$Email', 
	`DRT` = '$DRT', 
	`cbo` = '$cbo',
	`Funcao` = '$Funcao', 
	`InscricaoINSS` = '$InscricaoINSS', 
	`Pis` = '$Pis', 
	`OMB` = '$OMB', 
	`DataAtualizacao` = '$data', 
	`Observacao` = '$Observacao', 
	`IdUsuario` = '$idUsuario', 
	`tipoDocumento` = '$tipoDocumento', 
	`codBanco` = '$codBanco', 
	`agencia` = '$agencia', 
	`conta` = '$conta'  
	WHERE `Id_PessoaFisica` = '$idPessoaFisica'";	
	
	if(mysqli_query($con,$sql_atualizar_pessoa))
	{
		$mensagem = "Atualizado com sucesso!";	
	}
	else
	{
		$mensagem = "Erro ao atualizar! Tente novamente.";
	}	
}

$fisica = recuperaDados("sis_pessoa_fisica",$ultimo,"Id_PessoaFisica");

?>

<section id="contact" class="home-section bg-white">
	<div class="container"><?php include 'includes/menu_interno_pf.php'; ?>
		<div class="form-group">
			<h3>DADOS BANCÁRIOS</h3>
			<p><b>Código de cadastro:</b> <?php echo $idPessoaFisica; ?> - <b>Nome:</b> <?php echo $idPessoaFisica; ?></p>
			<h5><?php if(isset($mensagem)){echo $mensagem;}; echo $idPessoaFisica; ?></h5>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
			<form class="form-horizontal" role="form" action="?perfil=contratos&p=frm_edita_pf&id_pf=<?php echo $ultimo ?>" method="post">
						 
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Banco:</strong><br/>
						<select class="form-control" name="codBanco" id="codBanco">
							<option></option>
							<option value='32'>Banco do Brasil S.A.</option>
							<?php geraOpcao("igsis_bancos",$fisica['codBanco'],"");	?>
						</select>	
					</div>
				</div> 
		  
				<div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Agência</strong><br/>
						<input type="text" class="form-control" id="agencia" name="agencia" placeholder="" value="<?php echo $fisica['agencia']; ?>">
					</div>				  
					<div class=" col-md-6"><strong>Conta:</strong><br/>
						<input type="text" class="form-control" id="conta" name="conta" placeholder="" value="<?php echo $fisica['conta']; ?>">
					</div>
				</div> 
		  
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8">
						<input type="hidden" name="cadastrarFisica" value="<?php echo $fisica['Id_PessoaFisica'] ?>">	<input type="hidden" name="Sucesso" id="Sucesso" />
						<input type="submit" value="GRAVAR" class="btn btn-theme btn-lg btn-block">
					</div>
				</div>
			</form>
		
				<!-- Botão para Voltar e Prosseguir -->
				<div class="form-group">					
					<div class="col-md-offset-2 col-md-2">
						<form class="form-horizontal" role="form" action="?perfil=informacoes_complementares_pf" method="post">
							<input type="submit" value="Voltar" class="btn btn-theme btn-lg btn-block"  value="<?php echo $idPessoaFisica ?>">
						</form>	
					</div>
					<div class="col-md-offset-4 col-md-2">
						<form class="form-horizontal" role="form" action="?perfil=anexos_pf" method="post">	
							<input type="submit" value="Avançar" class="btn btn-theme btn-lg btn-block"  value="<?php echo $idPessoaFisica ?>">
						</form>	
					</div>					
				</div>
				
			</div>
		</div>
	</div>
</section>  