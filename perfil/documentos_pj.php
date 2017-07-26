<?php
$con = bancoMysqli();
$idPessoaJuridica = $_SESSION['idUsuario'];

if(isset($_POST['cadastrarJuridica']))
{
	$idPessoaJuridica = $_POST['cadastrarJuridica'];
	$RazaoSocial = addslashes($_POST['razaoSocial']);
	$Cnpj = $_POST['cnpj'];
	$Data = date('Y-m-d');
	$idUsuario = $_SESSION['idUsuario'];
	
	$sql_documentos_pj = "INSERT INTO `usuario_pj` (`cnpj`) VALUES ('$cnpj')";

	
	if(mysqli_query($con,$sql_documentos_pj))
	{
		$mensagem = "Atualizado com sucesso!";	
	}
	else
	{
		$mensagem = "Erro ao atualizar! Tente novamente.";
	}	
}

$pj = recuperaDados("usuario_pj","id",$idPessoaJuridica);
?>

<section id="contact" class="home-section bg-white">
	<div class="container"><?php include 'includes/menu_interno_pj.php'; ?>
		<div class="form-group">
			<h3>DOCUMENTOS</h3>
			<p><b>Código de cadastro:</b> <?php echo $idPessoaJuridica; ?> | <b>Razão Social:</b> <?php echo $pj['razaoSocial']; ?></p>
			<h5><?php if(isset($mensagem)){echo $mensagem;}; ?></h5>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">				
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>CNPJ *:</strong><br/>
						<input type="text" class="form-control" id="cnpj" name="cnpj" placeholder="CNPJ" value="<?php echo $pj['cnpj']; ?>">
					</div>
				</div>
				
				<!-- Botão para gravar -->
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8">
						<input type="hidden" name="cadastrarJuridica" value="<?php echo $idPessoaJuridica ?>">	<input type="hidden" name="Sucesso" id="Sucesso" />
						<input type="submit" value="GRAVAR" class="btn btn-theme btn-lg btn-block">
					</div>
				</div>
				
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8"><br/></div>
				</div>
		
				<!-- Botão para Voltar e Prosseguir -->
				<div class="form-group">					
					<div class="col-md-offset-2 col-md-2">
						<form class="form-horizontal" role="form" action="?perfil=inicio_pj" method="post">
							<input type="submit" value="Voltar" class="btn btn-theme btn-lg btn-block"  value="<?php echo $idPessoaJuridica ?>">
						</form>	
					</div>
					<div class="col-md-offset-4 col-md-2">
						<form class="form-horizontal" role="form" action="?perfil=endereco_pj" method="post">	
							<input type="submit" value="Avançar" class="btn btn-theme btn-lg btn-block"  value="<?php echo $idPessoaJuridica ?>">
						</form>	
					</div>					
				</div>
			</div>
		</div>
	</div>
</section>  