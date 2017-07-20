<?php
$con = bancoMysqli();
$idPessoaFisica = $_SESSION['idUsuario'];

if(isset($_POST['cadastrarFisica']))
{
	$idPessoaFisica = $_POST['cadastrarFisica'];
	$CodBanco = $_POST['codBanco'];
	$Agencia = $_POST['agencia'];
	$Conta = $_POST['conta'];
	
	$sql_atualiza_pf = "UPDATE usuario_pf SET
	`codBanco` = '$CodBanco', 
	`agencia` = '$Agencia', 
	`conta` = '$Conta'
	WHERE `id` = '$idPessoaFisica'";	
	
	if(mysqli_query($con,$sql_atualiza_pf))
	{
		$mensagem = "Atualizado com sucesso!!!";	
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
			<h3>DADOS BANCÁRIOS</h3>
			<p><b>Código de cadastro:</b> <?php echo $idPessoaFisica; ?> | <b>Nome:</b> <?php echo $pf['nome']; ?></p>
			<h5><?php if(isset($mensagem)){echo $mensagem;};?></h5>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
			<form class="form-horizontal" role="form" action="?perfil=dados_bancarios_pf" method="post">
						 
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Banco:</strong><br/>
						<select class="form-control" name="codBanco" id="codBanco">
							<option></option>
							<?php geraOpcao("banco",$pf['codBanco'],"");	?>
						</select>	
					</div>
				</div> 
		  
				<div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Agência</strong><br/>
						<input type="text" class="form-control" id="agencia" name="agencia" placeholder="" value="<?php echo $pf['agencia']; ?>">
					</div>				  
					<div class=" col-md-6"><strong>Conta:</strong><br/>
						<input type="text" class="form-control" id="conta" name="conta" placeholder="" value="<?php echo $pf['conta']; ?>">
					</div>
				</div> 
		  
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8">
						<input type="hidden" name="cadastrarFisica" value="<?php echo $idPessoaFisica ?>">
						<input type="submit" value="GRAVAR" class="btn btn-theme btn-lg btn-block">
					</div>
				</div>
			</form>
			
				<!-- Gerar FACC -->
				<?php
				/* criar aqui a recuperação de dados dos campos:
					cpf
					ccm
					nome
					cep
					numero
					telefone
					codbanco
					agencia
					conta
					nit
					cbo
					rg
				*/
				if ($idPessoaFisica == 1) //Se todos os campos necessários para a FACC forem preenchidos
				{
				?>
				
					<div class="form-group">
						<div class="col-md-offset-2 col-md-8"><br/></div>
					</div>
					
					<div class="form-group">
						<div class="col-md-offset-4 col-md-6">
							<input type="hidden" name="gerarFacc" value="<?php echo $idPessoaFisica ?>">	
							<input type="submit" value="Gerar FACC" class="btn btn-theme btn-lg btn-block">
						</div>
					</div>
					
					<div class="form-group">
						<div class="col-md-offset-2 col-md-8"><br/><br/></div>
					</div>
				<?php
				}
				?>				
		
				<!-- Botão para Voltar e Prosseguir -->
				<div class="form-group">					
					<div class="col-md-offset-2 col-md-2">
						<form class="form-horizontal" role="form" action="?perfil=informacoes_complementares_pf" method="post">
							<input type="submit" value="Voltar" class="btn btn-theme btn-lg btn-block"  value="<?php echo $idPessoaFisica ?>">
						</form>	
					</div>
					<div class="col-md-offset-4 col-md-2">
						<form class="form-horizontal" role="form" action="?perfil=anexos_pf" method="post">	
							<input type="submit" value="Avançar" class="btn btn-theme btn-lg btn-block"  value="<?php echo $idPessoaFisica ?>">
						</form>	
					</div>					
				</div>
				
			</div>
		</div>
	</div>
</section>  