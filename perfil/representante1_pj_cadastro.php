<?php
$con = bancoMysqli();
$idPessoaJuridica = $_SESSION['idUsuario'];

If ($_POST['insereRepresentante'] == '')
{
	$idRep1 = $_POST['cadastraRepresentante'];
}
else
{
	$idRep1 = $_POST['insereRepresentante'];
}	

if(isset($_POST['cadastraRepresentante']))
{
	$nome = addslashes($_POST['nome']);
	$rg = $_POST['rg'];
	$cpf = $_POST['cpf'];
	$idEstadoCivil = $_POST['idEstadoCivil'];
	$nacionalidade = $_POST['nacionalidade'];
	
	$sql_atualiza_pj = "UPDATE `representante_legal` SET 
	`nome` = '$nome',
	`rg` = '$rg', 
	`cpf` = '$cpf',  
	`nacionalidade` = '$nacionalidade', 
	`idEstadoCivil` = '$idEstadoCivil'
	WHERE `id` = '$idRep1'";	
	
		
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
$representante1 = recuperaDados("representante_legal","id",$idRep1);
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
			<form class="form-horizontal" role="form" action="?perfil=representante1_pj_cadastro" method="post">
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Nome: *</strong><br/>
						<input type="text" class="form-control" name="nome" placeholder="Nome completo" value="<?php echo $representante1['nome']; ?>" >
					</div>
				</div>
				  
				<div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>RG: *</strong><br/>
						<input type="text" class="form-control" name="rg" placeholder="RG" value="<?php echo $representante1['rg']; ?>" >
					</div>
					<div class="col-md-6"><strong>CPF: *</strong><br/>
						<input type="text" class="form-control" name="cpf" placeholder="CPF" value="<?php echo $representante1['cpf']; ?>" >
					</div>
				</div>
				
				<div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Nacionalidade: </strong><br/>
						<input type="text" class="form-control" name="nacionalidade" placeholder="Nacionalidade" value="<?php echo $representante1['nacionalidade']; ?>">
					</div>
					<div class="col-md-6"><strong>Estado civil:</strong><br/>
						<select class="form-control" name="idEstadoCivil" >
							<?php geraOpcao("estado_civil",$representante1['idEstadoCivil'],""); ?>  
						</select>
					</div>	
				</div>	  
		  
					  
				<!-- Botão para Gravar -->
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8">
						<input type="hidden" name="cadastraRepresentante" value="<?php echo $idRep1 ?>">
						<input type="submit" value="GRAVAR" class="btn btn-theme btn-lg btn-block">
					</div>
				</div>
			</form>
			
			</div>
		</div>
	</div>
</section>  