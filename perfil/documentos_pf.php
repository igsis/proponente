<?php
$con = bancoMysqli();
$idPessoaFisica = $_SESSION['idUsuario'];

if(isset($_POST['cadastrarFisica']))
{
	$idPessoaFisica = $_POST['cadastrarFisica'];
	$Nome = addslashes($_POST['nome']);
	$InscricaoInss = $_POST['inscricaoInss'];
	$tipoDocumento = $_POST['tipoDocumento'];
	$data = date('Y-m-d');
	$idUsuario = $_SESSION['idUsuario'];
	
	$sql_atualiza_pf = "UPDATE usuario_pf SET
	`nome` = '$Nome',
	`inscricaoInss` = '$InscricaoInss', 
	`tipoDocumento` = '$tipoDocumento', 
	`IdUsuario` = '$idUsuario'
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

/* Grava o Tipo de Documento */
if(isset($_POST['tipoDocumento']))
{
	$idTipoDocumento = $_POST['idTipoDocumento'];
	
	$sql_atualiza_tipo_documento = "UPDATE usuario_pf SET
	`idTipoDocumento` = '$idTipoDocumento'
	WHERE `id` = '$idPessoaFisica'";
	if(mysqli_query($con,$sql_atualiza_tipo_documento))
	{
		$mensagem = "Atualizado com sucesso!";	
	}
	else
	{
		$mensagem = "Erro ao atualizar (1)! Tente novamente.";
	}
}

/* Insere o RG */
if(isset($_POST['cadastraRg']))
{
	$titulo = addslashes($_POST['titulo']);
	$numero = $_POST['numero'];
	$dataRg = exibirDataMysql($_POST['dataRg']);
	$sql_insere_rg = "INSERT INTO `rg`(`titulo`, `numero`, `dataEmissao`, `idUsuario`) VALUES ('$titulo', '$numero', '$dataRg', '$idPessoaFisica')";
	if(mysqli_query($con,$sql_insere_rg))
	{
		$mensagem = "RG inserido com sucesso!";	
	}
	else
	{
		$mensagem = "Erro ao inserir os dados do RG! Tente novamente.";
	}
}

/* Edita o RG */
if(isset($_POST['editaRg']))
{
	$numero = $_POST['numero'];
	$dataRg = exibirDataMysql($_POST['dataRg']);
	$sql_insere_rg = "UPDATE `rg` SET `numero` = '$numero', `dataEmissao` = '$dataRg' WHERE `idUsuario` = '$idPessoaFisica'";
	if(mysqli_query($con,$sql_insere_rg))
	{
		$mensagem = "Atualizado com sucesso!";	
	}
	else
	{
		$mensagem = "Erro ao editar os dados do RG! Tente novamente.";
	}
}

$pf = recuperaDados("usuario_pf","id",$idPessoaFisica);
?>

<section id="contact" class="home-section bg-white">
	<div class="container"><?php include 'includes/menu_interno_pf.php'; ?>
		<div class="form-group">
			<h3>DOCUMENTOS</h3>
			<p><b>Código de cadastro:</b> <?php echo $idPessoaFisica; ?> | <b>Nome:</b> <?php echo $pf['nome']; ?></p>
			<h5><?php if(isset($mensagem)){echo $mensagem;}; ?></h5>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
			<!-- Escolha o tipo de documento -->
			<form class="form-horizontal" role="form" action="?perfil=documentos_pf" method="post">
				<div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Tipo de documento *:</strong><br/>
						<select class="form-control" id="idTipoDocumento" name="idTipoDocumento" >
							<?php geraOpcao("tipo_documento",$pf['idTipoDocumento'],""); ?>  
						</select>
					</div>
					<div class=" col-md-6"><br/>
						<input type="hidden" name="tipoDocumento" value="<?php echo $pf['id'] ?>">	
						<input type="submit" value="Escolher" class="btn btn-theme btn-lg btn-block">
					</div>
				</div>
			</form>	
			<!-- Escolha o tipo de documento -->
			
			<!-- Se for RG -->
			<?php
			If ($pf['idTipoDocumento'] == 1)
			{
				$rg = recuperaDados("rg","idUsuario",$idPessoaFisica);
			?>	
			<form class="form-horizontal" role="form" action="?perfil=documentos_pf" method="post">
				<div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>RG nº *:</strong><br/>
						<input type="text" class="form-control" name="numero" placeholder="Número" value="<?php echo $rg['numero']; ?>">
					</div>
					<div class="col-md-6"><strong>Data Emissão *:</strong><br/>
						<input type="text" class="form-control" id="datepicker01" name="dataRg" placeholder="Data da Emissão" value="<?php echo exibirDataBr($rg['dataEmissao']); ?>">
					</div>
				</div>
				<?php 
				if ($rg == NULL) //Se ainda não tiver registro do RG
				{
				?>
					<!-- Botão para gravar -->
					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<input type="hidden" name="cadastraRg" value="<?php echo $pf['id'] ?>">
							<input type="submit" value="INSERIR" class="btn btn-theme btn-lg btn-block">
						</div>
					</div>
					<!-- Fim Botão -->
				<?php
				}
				else //Caso já tenha um RG registrado
				{
				?>
					<!-- Botão para gravar -->
					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<input type="hidden" name="editaRg" value="<?php echo $pf['id'] ?>">
							<input type="submit" value="EDITAR" class="btn btn-theme btn-lg btn-block">
						</div>
					</div>
					<!-- Fim Botão -->				
				<?php
				}	
				?>				
			</form>
			<?php			
			}	
			?>
			<!-- Fim Se for RG -->
						
				
				<hr/>
				
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>CPF *:</strong><br/>
						<input type="text" class="form-control" id="cpf" name="CPF" placeholder="CPF" value="<?php echo $pf['cpf']; ?>">
					</div>
				</div>
				
				<!-- Botão para gravar -->
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8">
						<input type="hidden" name="cadastrarFisica" value="<?php echo $idPessoaFisica ?>">	<input type="hidden" name="Sucesso" id="Sucesso" />
						<input type="submit" value="GRAVAR" class="btn btn-theme btn-lg btn-block">
					</div>
				</div>
				
				<hr/>
				
				
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Inscrição INSS:</strong><br/>
						<input type="text" class="form-control" id="inscricaoInss" name="inscricaoInss" placeholder="Nº da inscrição INSS" value="<?php echo $pf['inscricaoInss']; ?>">
					</div>
				</div>
				
				<!-- Botão para gravar -->
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8">
						<input type="hidden" name="cadastrarFisica" value="<?php echo $inscricaoInss ?>">	<input type="hidden" name="Sucesso" id="Sucesso" />
						<input type="submit" value="GRAVAR" class="btn btn-theme btn-lg btn-block">
					</div>
				</div>
				
				<hr/>
				
				
			
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8"><br/></div>
				</div>
		
				<!-- Botão para Voltar e Prosseguir -->
				<div class="form-group">					
					<div class="col-md-offset-2 col-md-2">
						<form class="form-horizontal" role="form" action="?perfil=inicio" method="post">
							<input type="submit" value="Voltar" class="btn btn-theme btn-lg btn-block"  value="<?php echo $idPessoaFisica ?>">
						</form>	
					</div>
					<div class="col-md-offset-4 col-md-2">
						<form class="form-horizontal" role="form" action="?perfil=endereco_pf" method="post">	
							<input type="submit" value="Avançar" class="btn btn-theme btn-lg btn-block"  value="<?php echo $idPessoaFisica ?>">
						</form>	
					</div>					
				</div>
			</div>
		</div>
	</div>
</section>  