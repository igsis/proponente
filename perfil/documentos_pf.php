<?php
$con = bancoMysqli();
$idPessoaFisica = $_SESSION['idUsuario'];
$ultimo = $idPessoaFisica;

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

$pf = recuperaDados("usuario_pf","id",$idPessoaFisica);

?>

<section id="contact" class="home-section bg-white">
	<div class="container"><?php include 'includes/menu_interno_pf.php'; ?>
		<div class="form-group">
			<h3>DOCUMENTOS</h3>
			<p><b>Código de cadastro:</b> <?php echo $idPessoaFisica; ?> | <b>Nome:</b> <?php echo $pf['nome']; ?></p>
			<h5><?php if(isset($mensagem)){echo $mensagem;}; echo $idPessoaFisica; ?></h5>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
			<form class="form-horizontal" role="form" action="?perfil=documentos_pf" method="post">
								  
				<div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Tipo de documento *:</strong><br/>
						<select class="form-control" id="tipoDocumento" name="tipoDocumento" >
							<?php geraOpcao("tipo_documento",$pf['tipoDocumento'],""); ?>  
						</select>
					</div>				  
					<div class=" col-md-6"><strong>Documento *:</strong><br/>
						<input type="text" class="form-control" id="RG" name="RG" placeholder="Documento" value="<?php echo $pf['rg']; ?>">
					</div>
				</div>
				
				<!-- Botão para gravar -->
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8">
						<input type="hidden" name="cadastrarFisica" value="<?php echo $pf['idPessoaFisica'] ?>">	<input type="hidden" name="Sucesso" id="Sucesso" />
						<input type="submit" value="GRAVAR" class="btn btn-theme btn-lg btn-block">
					</div>
				</div>
				
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
						<input type="text" class="form-control" id="inss" name="inss" placeholder="Nº da inscrição INSS" value="<?php echo $pf['inscricaoInss']; ?>">
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
				
				</form>
			
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