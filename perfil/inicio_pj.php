<?php
$con = bancoMysqli();
$idPessoaJuridica = $_SESSION['idUser'];


if(isset($_POST['cadastrarJuridica']))
{
	$idPessoaJuridica = $_POST['cadastrarJuridica'];
	$RazaoSocial = addslashes($_POST['razaoSocial']);
	$Telefone1 = $_POST['telefone1'];
	$Telefone2 = $_POST['telefone2'];
	$Telefone3 = $_POST['telefone3'];
	$Email = $_POST['email'];
	$Login = $_POST['login'];
	
	$sql_atualiza_pj = "UPDATE usuario_pj SET
	`razaoSocial` = '$RazaoSocial',
	`telefone1` = '$Telefone1', 
	`telefone2` = '$Telefone2',  
	`telefone3` = '$Telefone3', 
	`email` = '$Email'
	WHERE `id` = '$idPessoaJuridica'";	
	
	if(mysqli_query($con,$sql_atualiza_pj))
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
			<h3>INFORMAÇÕES INICIAIS</h3>
			<p><b>Código de cadastro:</b> <?php echo $idPessoaJuridica; ?> | <b>Razão Social:</b> <?php echo $pj['razaoSocial']; ?></p>
			<h5><?php if(isset($mensagem)){echo $mensagem;};?></h5>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
			<form class="form-horizontal" role="form" action="?inicio.php" method="post">
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Razão Social *:</strong><br/>
						<input type="text" class="form-control" name="razaoSocial" placeholder="Razão Social" value="<?php echo $pj['razaoSocial']; ?>" >
					</div>
				</div>
				  
				<div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Celular *:</strong><br/>
						<input type="text" class="form-control" name="telefone1" id="telefone" onkeyup="mascara( this, mtel );" maxlength="15" placeholder="Exemplo: (11) 98765-4321" value="<?php echo $pj['telefone1']; ?>">
					</div>
					<div class="col-md-6"><strong>Telefone #2:</strong><br/>
						<input type="text" class="form-control" name="telefone2" id="telefone" onkeyup="mascara( this, mtel );" maxlength="15" placeholder="Exemplo: (11) 98765-4321" value="<?php echo $pj['telefone2']; ?>">
					</div>
				</div>
						  
				<div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Telefone #3:</strong><br/>
						<input type="text" class="form-control" name="telefone3" id="telefone" onkeyup="mascara( this, mtel );" maxlength="15" placeholder="Exemplo: (11) 98765-4321" value="<?php echo $pj['telefone3']; ?>" >
					</div>
					<div class="col-md-6"><strong>E-mail:</strong><br/>
						<input type="text" class="form-control" name="email" placeholder="E-mail" value="<?php echo $pj['email']; ?>" >
					</div>
				</div>					
		  
					  
				<!-- Botão para Gravar -->
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8">
						<input type="hidden" name="cadastrarJuridica" value="<?php echo $idPessoaJuridica ?>">
						<input type="submit" value="GRAVAR" class="btn btn-theme btn-lg btn-block">
					</div>
				</div>
			</form>
			
			<div class="form-group">
					<div class="col-md-offset-2 col-md-8"><hr/><br/></div>
			</div>			
			
				<!-- Botão para Prosseguir -->
				<div class="form-group">
					<form class="form-horizontal" role="form" action="?perfil=documentos_pj" method="post">
						<div class="col-md-offset-8 col-md-2">
							<input type="submit" value="Avançar" class="btn btn-theme btn-lg btn-block"  value="<?php echo $idPessoaJuridica ?>">
						</div>
					</form>
				</div>
			
		
			</div>
		</div>
	</div>
</section>  