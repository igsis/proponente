<?php
$con = bancoMysqli();
$idPessoaJuridica = $_SESSION['idUsuario'];

// Cadastro um representante que não existe
if(isset($_POST['cadastraRepresentante']))
{
	$idRep1 = $_POST['cadastraRepresentante'];
	$nome = addslashes($_POST['nome']);
	$rg = $_POST['rg'];
	$cpf = $_POST['cpf'];
	$idEstadoCivil = $_POST['idEstadoCivil'];
	$nacionalidade = $_POST['nacionalidade'];
	
	$sql_insere_rep1 = "INSERT INTO `representante_legal` (`nome`, `rg`, `cpf`, `nacionalidade`, `idEstadoCivil`) VALUES ('$nome', '$rg', '$cpf', '$nacionalidade', '$idEstadoCivil')";
			
	if(mysqli_query($con,$sql_insere_rep1))
	{
		$mensagem = "Cadastrado com sucesso!";
		$idRep1 = recuperaUltimo("representante_legal");
		$sql_representante1_empresa = "UPDATE usuario_pj SET idRepresentanteLegal1 = '$idRep1' WHERE id = '$idPessoaJuridica'";
		$query_representante1_empresa = mysqli_query($con,$sql_representante1_empresa);
	}
	else
	{
		$mensagem = "Erro ao cadastrar! Tente novamente.";
	}	
}

// Insere um Representante que foi pesquisado
if(isset($_POST['insereRepresentante']))
{
	$idRep1 = $_POST['insereRepresentante'];
}	

// Edita os dados do representante
if(isset($_POST['editaRepresentante']))
{
	$idRep1 = $_POST['editaRepresentante'];
	$nome = addslashes($_POST['nome']);
	$rg = $_POST['rg'];
	$cpf = $_POST['cpf'];
	$idEstadoCivil = $_POST['idEstadoCivil'];
	$nacionalidade = $_POST['nacionalidade'];
	
	$sql_atualiza_rep1 = "UPDATE `representante_legal` SET 
	`nome` = '$nome',
	`rg` = '$rg', 
	`cpf` = '$cpf',  
	`nacionalidade` = '$nacionalidade', 
	`idEstadoCivil` = '$idEstadoCivil'
	WHERE `id` = '$idRep1'";	
	
		
	if(mysqli_query($con,$sql_atualiza_rep1))
	{
		$mensagem = "Atualizado com sucesso!";
		$sql_representante1_empresa = "UPDATE usuario_pj SET idRepresentanteLegal1 = '$idRep1' WHERE id = '$idPessoaJuridica'";
		$query_representante1_empresa = mysqli_query($con,$sql_representante1_empresa);		
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
			<h3>REPRESENTANTE LEGAL #1</h3>
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
						<input type="text" readonly class="form-control" name="cpf" placeholder="CPF" value="<?php echo $representante1['cpf']; ?>" >
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
						<input type="hidden" name="editaRepresentante" value="<?php echo $idRep1 ?>">
						<input type="submit" value="GRAVAR" class="btn btn-theme btn-lg btn-block">
					</div>
				</div>
			</form>
			
			</div>
		</div>
	</div>
</section>  