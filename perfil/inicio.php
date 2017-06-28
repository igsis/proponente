<?php
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
	<div class="container"><?php include 'includes/menu_interno.php'; ?>
		<div class="form-group">
			<h3>INFORMAÇÕES INICIAIS</h3>
			<p><b>Código de cadastro:</b> <?php echo $idPessoaFisica; ?> - <b>Nome:</b> <?php echo $idPessoaFisica; ?></p>
			<h5><?php if(isset($mensagem)){echo $mensagem;};?></h5>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
			<form class="form-horizontal" role="form" action="?inicio.php" method="post">
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Nome *:</strong><br/>
						<input type="text" class="form-control" id="Nome" name="Nome" placeholder="Nome" value="<?php echo $fisica['Nome']; ?>" >
					</div>
				</div>

				<div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Nome Artístico:</strong><br/>
						<input type="text" class="form-control" id="NomeArtistico" name="NomeArtistico" placeholder="Nome Artístico" value="<?php echo $fisica['NomeArtistico']; ?>">
					</div>
				</div>
				  
				<div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Telefone #1 *:</strong><br/>
						<input type="text" class="form-control" name="Telefone1" id="telefone" onkeyup="mascara( this, mtel );" maxlength="15" placeholder="Exemplo: (11) 98765-4321" value="<?php echo $fisica['Telefone1']; ?>">
					</div>
					<div class="col-md-6"><strong>Telefone #2:</strong><br/>
						<input type="text" class="form-control" name="Telefone2" id="telefone" onkeyup="mascara( this, mtel );" maxlength="15" placeholder="Exemplo: (11) 98765-4321" value="<?php echo $fisica['Telefone2']; ?>">
					</div>
				</div>
						  
				<div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Telefone #3:</strong><br/>
						<input type="text" class="form-control" name="Telefone3" id="telefone" onkeyup="mascara( this, mtel );" maxlength="15" placeholder="Exemplo: (11) 98765-4321" value="<?php echo $fisica['Telefone3']; ?>" >
					</div>
					<div class="col-md-6"><strong>E-mail:</strong><br/>
						<input type="text" class="form-control" id="Email" name="Email" placeholder="E-mail" value="<?php echo $fisica['Email']; ?>" >
					</div>
				</div>	  
		  
				<div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Estado civil:</strong><br/>
						<select class="form-control" id="IdEstadoCivil" name="IdEstadoCivil" >
							<?php geraOpcao("sis_estado_civil",$fisica['IdEstadoCivil'],""); ?>  
						</select>
					</div>				  
					<div class=" col-md-6"><strong>Data de nascimento:</strong><br/>
						<input type="text" class="form-control" id="datepicker01" name="DataNascimento" placeholder="Data de Nascimento" value="<?php echo exibirDataBr($fisica['DataNascimento']); ?>">
					</div>
				</div>
		  
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Nacionalidade:</strong><br/>
						<input type="text" class="form-control" id="Nacionalidade" name="Nacionalidade" placeholder="Nacionalidade" value="<?php echo $fisica['Nacionalidade']; ?>">
					</div>	
				</div>
		  
				<!-- Botão para Gravar -->
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8">
						<input type="hidden" name="cadastrarFisica" value="<?php echo $fisica['Id_PessoaFisica'] ?>">	<input type="hidden" name="Sucesso" id="Sucesso" />
						<input type="submit" value="GRAVAR" class="btn btn-theme btn-lg btn-block">
					</div>
				</div>
			</form>
			
			
				<!-- Botão para Prosseguir -->
				<div class="form-group">
					<form class="form-horizontal" role="form" action="?perfil=documentos_pf" method="post">
						<div class="col-md-offset-8 col-md-2">
							<input type="submit" value="Avançar" class="btn btn-theme btn-lg btn-block"  value="<?php echo $idPessoaFisica ?>">
						</div>
					</form>
				</div>
			
		
			</div>
		</div>
	</div>
</section>  