﻿<?php
$con = bancoMysqli();
$idPessoaFisica = $_SESSION['idUser'];


if(isset($_POST['cadastrarFisica']))
{		
	$Email = $_POST['email'];
	$Telefone1 = addslashes($_POST['telefone1']);
	if($Email == '' OR $Telefone1 == '')
	{
		$mensagem = "Por favor, preencha todos os campos.";
	}
	else
	{	
	$idPessoaFisica = $_POST['cadastrarFisica'];
	$Nome = addslashes($_POST['nome']);
	$NomeArtistico = addslashes($_POST['nomeArtistico']);
	$IdEstadoCivil = $_POST['idEstadoCivil'];
	$DataNascimento = exibirDataMysql($_POST['dataNascimento']);
	$Nacionalidade = $_POST['nacionalidade'];
	$LocalNascimento = $_POST['localNascimento'];
	$Telefone1 = $_POST['telefone1'];
	$Telefone2 = $_POST['telefone2'];
	$Telefone3 = $_POST['telefone3'];
	$Email = $_POST['email'];
	$Login = $_POST['login'];
	$dataAtualizacao = date("Y-m-d");
		
	
	$sql_atualiza_pf = "UPDATE usuario_pf SET
	`nome` = '$Nome',
	`nomeArtistico` = '$NomeArtistico',
	`idEstadoCivil` = '$IdEstadoCivil', 
	`dataNascimento` = '$DataNascimento', 
	`nacionalidade` = '$Nacionalidade', 
	`localNascimento` = '$LocalNascimento', 
	`telefone1` = '$Telefone1', 
	`telefone2` = '$Telefone2',  
	`telefone3` = '$Telefone3', 
	`email` = '$Email',
	`dataAtualizacao` = '$dataAtualizacao'
	WHERE `id` = '$idPessoaFisica'";	
	
	if(mysqli_query($con,$sql_atualiza_pf))
	{
		$mensagem = "Atualizado com sucesso!";	
	}
	else
	{
		$mensagem = "Erro ao atualizar! Tente novamente.";
	}	
	}
}

$pf = recuperaDados("usuario_pf","id",$idPessoaFisica);
?>

<section id="contact" class="home-section bg-white">
	<div class="container"><?php include 'includes/menu_interno_pf.php'; ?>
		<div class="form-group">
			<h3>INFORMAÇÕES INICIAIS</h3>
			<p><b>Código de cadastro:</b> <?php echo $idPessoaFisica; ?> | <b>Nome:</b> <?php echo $pf['nome']; ?></p>
			<h5><?php if(isset($mensagem)){echo $mensagem;};?></h5>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
			<form class="form-horizontal" role="form" action="?inicio_pf.php" method="post">
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Nome *:</strong><br/>
						<input type="text" class="form-control" name="nome" placeholder="Insira seu nome completo" value="<?php echo $pf['nome']; ?>" >
					</div>
				</div>

				<div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Nome Artístico:</strong><br/>
						<input type="text" class="form-control" name="nomeArtistico" placeholder="Nome Artístico" value="<?php echo $pf['nomeArtistico']; ?>">
					</div>
				</div>
				  
				<div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Celular *:</strong><br/>
						<input type="text" class="form-control" name="telefone1" id="telefone" onkeyup="mascara( this, mtel );" maxlength="15" placeholder="Exemplo: (11) 98765-4321" value="<?php echo $pf['telefone1']; ?>">
					</div>
					<div class="col-md-6"><strong>Telefone #2:</strong><br/>
						<input type="text" class="form-control" name="telefone2" id="telefone" onkeyup="mascara( this, mtel );" maxlength="15" placeholder="Exemplo: (11) 98765-4321" value="<?php echo $pf['telefone2']; ?>">
					</div>
				</div>
						  
				<div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Telefone #3:</strong><br/>
						<input type="text" class="form-control" name="telefone3" id="telefone" onkeyup="mascara( this, mtel );" maxlength="15" placeholder="Exemplo: (11) 98765-4321" value="<?php echo $pf['telefone3']; ?>" >
					</div>
					<div class="col-md-6"><strong>Data de nascimento:</strong><br/>
						<input type="text" class="form-control" id="datepicker01" name="dataNascimento" placeholder="Data de Nascimento" value="<?php echo exibirDataBr($pf['dataNascimento']); ?>">
					</div>
				</div>
		  
				<div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>E-mail *:</strong><br/>
						<input type="text" class="form-control" name="email" placeholder="E-mail" value="<?php echo $pf['email']; ?>" >
					</div>	
					<div class="col-md-6"><strong>Estado civil:</strong><br/>
						<select class="form-control" name="idEstadoCivil" >
							<?php geraOpcao("estado_civil",$pf['idEstadoCivil'],""); ?>  
						</select>
					</div>	
				</div>	  
		  
				<div class="form-group">			  
					<div class="col-md-offset-2 col-md-6"><strong>Nacionalidade:</strong><br/>
						<input type="text" class="form-control" name="nacionalidade" placeholder="Nacionalidade" value="<?php echo $pf['nacionalidade']; ?>">
					</div>
					<div class="col-md-6"><strong>Local de Nascimento:</strong><br/>
						<input type="text" class="form-control" name="localNascimento" placeholder="Nacionalidade" value="<?php echo $pf['localNascimento']; ?>">
					</div>
				</div>
		  
				<!-- Botão para Gravar -->
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8">
						<input type="hidden" name="cadastrarFisica" value="<?php echo $idPessoaFisica ?>">
						<input type="submit" value="GRAVAR" class="btn btn-theme btn-lg btn-block">
					</div>
				</div>
			</form>
			
			<div class="form-group">
					<div class="col-md-offset-2 col-md-8"><hr/><br/></div>
			</div>
				
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