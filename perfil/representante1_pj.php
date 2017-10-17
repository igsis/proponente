<?php
$con = bancoMysqli();
$idPessoaJuridica = $_SESSION['idUser'];

$pj = recuperaDados("usuario_pj","id",$idPessoaJuridica);

// Edita os dados do representante
if(isset($_POST['apagaRepresentante']))
{
	$idPessoaJuridica = $_POST['apagaRepresentante'];
			
	$sql_apaga_rep1 = "UPDATE usuario_pj SET idRepresentanteLegal1 = '0'
	WHERE `id` = '$idPessoaJuridica'";	
	
		
	if(mysqli_query($con,$sql_apaga_rep1))
	{
		$mensagem = "Apagado com sucesso!";
	?>
		<script language="JavaScript">
			window.location = "?perfil=representante1_pj"; 
		</script>
	<?php		
	}
	else
	{
		$mensagem = "Erro ao atualizar! Tente novamente.";
	}	
}

if ($pj['idRepresentanteLegal1'] == 0) // Não possui representante legal cadastrado
{	
?>	
	<section id="services" class="home-section bg-white">
		<div class="container"><?php include 'includes/menu_interno_pj.php'; ?>
			<div class="row">
				<div class="col-md-offset-2 col-md-8">
					<div class="section-heading">
						<h3>REPRESENTANTE LEGAL #1</h3>
						<p><strong><?php if(isset($mensagem)){echo $mensagem;} ?></strong></p>
						<p><strong>Você está inserindo representante legal </strong></p>
						<p></p>
					</div>
				</div>
			</div>
			<div class="row">
				<form method="POST" action="?perfil=representante1_pj_resultado_busca" class="form-horizontal" role="form">
					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">				      
							<label>Insira o CPF</label>
								<input type="text" name="busca" class="form-control" id="cpf" >
						</div>
					</div>
					
					<br />             
				 
					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<input type="submit" class="btn btn-theme btn-lg btn-block" value="Pesquisar">                   
						</div>
					</div>
				</form>	
				
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8"><hr/><br/></div>
				</div>
				
				<!-- Botão para Voltar e Prosseguir -->
				<div class="form-group">					
					<div class="col-md-offset-2 col-md-2">
						<form class="form-horizontal" role="form" action="?perfil=endereco_pj" method="post">
							<input type="submit" value="Voltar" class="btn btn-theme btn-lg btn-block"  value="<?php echo $idPessoaJuridica ?>">
						</form>	
					</div>
					<div class="col-md-offset-4 col-md-2">
						<form class="form-horizontal" role="form" action="?perfil=representante2_pj" method="post">	
							<input type="submit" value="Avançar" class="btn btn-theme btn-lg btn-block"  value="<?php echo $idPessoaJuridica ?>">
						</form>	
					</div>					
				</div>				
			</div>
		</div>
	</section>
		
<?php	
}	
else
{		
	$representante1 = recuperaDados("representante_legal","id",$pj['idRepresentanteLegal1']);
	$idPj = $pj['id'];
	$estado_civil = recuperaDados("estado_civil","id",$representante1['idEstadoCivil']);
?>	
	<section id="services" class="home-section bg-white">
		<div class="container"><?php include 'includes/menu_interno_pj.php'; ?>
			<div class="row">
				<div class="col-md-offset-2 col-md-8">					
					<h3>REPRESENTANTE LEGAL #1</h3>					
				</div>
			</div>
			<div class="row">
				<div class="col-md-offset-1 col-md-10">
					<div align="left">
						<div class="form-group">
							<div class="col-md-offset-2 col-md-8"><strong>Nome:</strong> <?php echo $representante1['nome']; ?></div>
						</div>
						  
						<div class="form-group">
							<div class="col-md-offset-2 col-md-6"><strong>RG:</strong> <?php echo $representante1['rg']; ?></div>
							<div class="col-md-6"><strong>CPF:</strong> <?php echo $representante1['cpf']; ?></div>
						</div>
						
						<div class="form-group">
							<div class="col-md-offset-2 col-md-6"><strong>Nacionalidade:</strong> <?php echo $representante1['nacionalidade']; ?></div>
							<div class="col-md-6"><strong>Estado civil:</strong> <?php echo $estado_civil['estadoCivil'] ?></div>	
						</div>

						<div class="form-group">
							<div class="col-md-offset-2 col-md-8"><br/></div>
						</div>	
							  
						<!-- Botão para Trocar o Representante -->
						<div class="form-group">
							<div class="col-md-offset-2 col-md-8">
								<form method='POST' action='?perfil=representante1_pj'>
									<input type="hidden" name="apagaRepresentante" value="<?php echo $idPessoaJuridica ?>">
									<input type="submit" value="Trocar o Representante" class="btn btn-theme btn-lg btn-block">
								</form>	
							</div>
						</div>
						
						<div class="form-group">
							<div class="col-md-offset-2 col-md-8"><hr/><br/></div>
						</div>
								
						<!-- Botão para Voltar e Prosseguir -->
						<div class="form-group">					
							<div class="col-md-offset-2 col-md-2">
								<form class="form-horizontal" role="form" action="?perfil=endereco_pj" method="post">
									<input type="submit" value="Voltar" class="btn btn-theme btn-lg btn-block"  value="<?php echo $idPessoaJuridica ?>">
								</form>	
							</div>
							<div class="col-md-offset-4 col-md-2">
								<form class="form-horizontal" role="form" action="?perfil=representante2_pj" method="post">	
									<input type="submit" value="Avançar" class="btn btn-theme btn-lg btn-block"  value="<?php echo $idPessoaJuridica ?>">
								</form>	
							</div>					
						</div>
						
					</div>
				</div>
			</div>
		</div>
	</section>
<?php	
}	
?>