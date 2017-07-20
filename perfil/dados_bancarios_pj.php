<?php
$con = bancoMysqli();
$idPessoaJuridica = $_SESSION['idUsuario'];

if(isset($_POST['cadastrarJuridica']))
{
	$idPessoaJuridica = $_POST['cadastrarJuridica'];
	$CodigoBanco = $_POST['codigoBanco'];
	$Agencia = $_POST['agencia'];
	$Conta = $_POST['conta'];
	
	$sql_atualiza_pj = "UPDATE usuario_pj SET
	`codigoBanco` = '$CodigoBanco', 
	`agencia` = '$Agencia', 
	`conta` = '$Conta'
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
			<h3>DADOS BANCÁRIOS</h3>
			<p><b>Código de cadastro:</b> <?php echo $idPessoaJuridica; ?> | <b>Razão Social:</b> <?php echo $pj['razaoSocial']; ?></p>
			<h5><?php if(isset($mensagem)){echo $mensagem;};?></h5>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
			<form class="form-horizontal" role="form" action="?perfil=dados_bancarios_pj" method="post">
						 
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Banco:</strong><br/>
						<select class="form-control" name="codigoBanco" id="codigoBanco">
							<option value='32'>Banco do Brasil S.A.</option>
							<?php geraOpcao("banco",$pj['codigoBanco'],""); ?>
						</select>
					</div>
				</div>  
		  
				<div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Agência</strong><br/>
						<input type="text" class="form-control" id="agencia" name="agencia" placeholder="" value="<?php echo $pj['agencia']; ?>">
					</div>				  
					<div class=" col-md-6"><strong>Conta:</strong><br/>
						<input type="text" class="form-control" id="conta" name="conta" placeholder="" value="<?php echo $pj['conta']; ?>">
					</div>
				</div> 
		  
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8">
						<input type="hidden" name="cadastrarJuridica" value="<?php echo $idPessoaJuridica ?>">
						<input type="submit" value="GRAVAR" class="btn btn-theme btn-lg btn-block">
					</div>
				</div>
			</form>
			
				<!-- Gerar FACC -->
				<?php
				/* criar aqui a recuperação de dados dos campos:
					cnpj
					razaosocial
					cep
					numero
					telefone
					codigobanco
					agencia
					conta
				*/
				if ($idPessoaJuridica == 2) //Se todos os campos necessários para a FACC forem preenchidos
				{
				?>
				
					<div class="form-group">
						<div class="col-md-offset-2 col-md-8"><br/></div>
					</div>
					
					<div class="form-group">
						<div class="col-md-offset-4 col-md-6">
							<input type="hidden" name="gerarFacc" value="<?php echo $idPessoaJuridica ?>">	
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
						<form class="form-horizontal" role="form" action="?perfil=informacoes_complementares_pj" method="post">
							<input type="submit" value="Voltar" class="btn btn-theme btn-lg btn-block"  value="<?php echo $idPessoaJuridica ?>">
						</form>	
					</div>
					<div class="col-md-offset-4 col-md-2">
						<form class="form-horizontal" role="form" action="?perfil=anexos_pj" method="post">	
							<input type="submit" value="Avançar" class="btn btn-theme btn-lg btn-block"  value="<?php echo $idPessoaJuridica ?>">
						</form>	
					</div>					
				</div>
				
			</div>
		</div>
	</div>
</section>  