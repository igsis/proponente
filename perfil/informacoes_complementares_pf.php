<?php
$con = bancoMysqli();
$idPessoaFisica = $_SESSION['idUsuario'];

if(isset($_POST['cadastrarFisica']))
{
	$idPessoaFisica = $_POST['cadastrarFisica'];
	$CBO = $_POST['cbo'];
	$Funcao = $_POST['funcao'];
	$numero = $_POST['numero'];
	$dataEmissao = exibirDataMysql ($_POST['dataEmissao']);
	
	$sql_atualiza_complementares = "UPDATE usuario_pf SET
	`cbo` = '$CBO',
	`funcao` = '$Funcao'
	WHERE `id` = '$idPessoaFisica'";
	
	$sql_atualiza_complementares_drt = "UPDATE drt SET 
	`numero` = '$numero',
	`dataEmissao` = '$dataEmissao'
	WHERE `idUsuario` = '$idPessoaFisica'";
	
	if(mysqli_query($con,$sql_atualiza_complementares_drt) AND mysqli_query($con,$sql_atualiza_complementares))
	{
		$mensagem = "Atualizado com sucesso!";	
	}
	else
	{
		$mensagem = "Erro ao atualizar! Tente novamente.";
	}	
}

$pf = recuperaDados("usuario_pf","id",$idPessoaFisica);
$drt = recuperaDados("drt","idUsuario",$pf['id']);

?>

<section id="contact" class="home-section bg-white">
	<div class="container"><?php include 'includes/menu_interno_pf.php'; ?>
		<div class="form-group">
			<h3>INFORMAÇÕES COMPLEMENTARES</h3>
			<p><b>Código de cadastro:</b> <?php echo $idPessoaFisica; ?> | <b>Nome:</b> <?php echo $pf['nome']; ?></p>
			<h5><?php if(isset($mensagem)){echo $mensagem;};?></h5>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
			<form class="form-horizontal" role="form" action="?perfil=informacoes_complementares_pf" method="post">
				
						  
				<div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>DRT:</strong><br/>
						<input type="text" class="form-control" name="numero" placeholder="DRT" value="<?php echo $drt['numero']; ?>">
					</div>
					<div class="col-md-6"><strong>Data Emissão:</strong><br/>
						<input type="text" class="form-control" id="datepicker01" name="dataEmissao" placeholder="Data de Emissão" value="<?php echo exibirDataBr($drt['dataEmissao']); ?>">
					</div>
				</div>
		 
				<div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>C.B.O.:</strong> <i><a href="http://www.mtecbo.gov.br/cbosite/pages/pesquisas/BuscaPorTitulo.jsf" target="_blank">Consulte o código aqui</a></i><br/>
						<input type="text" class="form-control" id="cbo" name="cbo" placeholder="C.B.O."value="<?php echo $pf['cbo']; ?>" >
					</div> 				  
					<div class=" col-md-6"><strong>Função:</strong><br/>
						<input type="text" class="form-control" id="Funcao" name="funcao" placeholder="Função" value="<?php echo $pf['funcao']; ?>">
					</div>
				</div>				
		  
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8">
						<input type="hidden" name="cadastrarFisica" value="<?php echo $idPessoaFisica ?>">	<input type="hidden" name="Sucesso" id="Sucesso" />
						<input type="submit" value="GRAVAR" class="btn btn-theme btn-lg btn-block">
					</div>
				</div>
			</form>
		
				<!-- Botão para Voltar e Prosseguir -->
				<div class="form-group">					
					<div class="col-md-offset-2 col-md-2">
						<form class="form-horizontal" role="form" action="?perfil=endereco_pf" method="post">
							<input type="submit" value="Voltar" class="btn btn-theme btn-lg btn-block"  value="<?php echo $idPessoaFisica ?>">
						</form>	
					</div>
					<div class="col-md-offset-4 col-md-2">
						<form class="form-horizontal" role="form" action="?perfil=dados_bancarios_pf" method="post">	
							<input type="submit" value="Avançar" class="btn btn-theme btn-lg btn-block"  value="<?php echo $idPessoaFisica ?>">
						</form>	
					</div>					
				</div>
				
			</div>
		</div>
	</div>
</section>  