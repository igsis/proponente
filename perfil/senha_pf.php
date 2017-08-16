<?php
 $idPessoaFisica = $_SESSION['idUsuario'];

	if(isset($_POST['senha01']))
	{
		//verifica se há um post
		if(($_POST['senha01'] != "") AND (strlen($_POST['senha01']) >= 5))
		{
			if($_POST['senha01'] == $_POST['senha02'])
			{
				// verifica se a nova senha foi digitada corretamente duas vezes
				$senha = recuperaDados("usuario_pf","login",$_SESSION['login']);
				if(md5($_POST['senha03']) == $senha['senha'])
				{
					$usuario = $_SESSION['idUsuario'];
					$senha01 = md5($_POST['senha01']);
					$sql_senha = "UPDATE `usuario_pf` SET `senha` = '$senha01' WHERE `id` = '$usuario';";
					$con = bancoMysqli();
					$query_senha = mysqli_query($con,$sql_senha);
					if($query_senha)
					{
						$mensagem = "Senha alterada com sucesso!";	
					}
					else
					{
						$mensagem = "Não foi possível mudar a senha. Tente novamente.";	
					}
				}
				else
				{
						$mensagem = "Senha atual incorreta.";	
				}
			}
			else
			{
				// caso não tenha digitado 2 vezes
				$mensagem = "As senhas não conferem. Tente novamente.";
			}
		}
		else
		{
			$mensagem = "A senha não pode estar em branco e deve conter mais de 5 caracteres";	
		}
	}
	
	if(isset($_POST['fraseSeguranca']))
{
	$idPessoaFisica = $_POST['fraseSeguranca'];
	$idFraseSeguranca = $_POST['idFraseSeguranca'];
	$respostaFrase = $_POST['respostaFrase'];
	
	$sql_atualiza_pf = "UPDATE usuario_pf SET
	`idFraseSeguranca` = '$idFraseSeguranca', 
	`respostaFrase` = '$respostaFrase'
	WHERE `id` = '$idPessoaFisica'";	
	
	if(mysqli_query($con,$sql_atualiza_pf))
	{
		$mensagem = "Atualizado com sucesso!!!";	
	}
	else
	{
		$mensagem = "Erro ao atualizar suas informações de segurança! Tente novamente.";
	}	
}
	
$pf = recuperaDados("usuario_pf","id",$idPessoaFisica);
?>
<section id="contact" class="home-section bg-white">
	<div class="container"><?php include 'includes/menu_interno_pf.php'; ?>
		<div class="form-group">
			<h3>DADOS DA CONTA</h3>
			<p><b>Código de cadastro:</b> <?php echo $idPessoaFisica; ?> | <b>Nome:</b> <?php echo $pf['nome']; ?></p>
			<h5><?php if(isset($mensagem)){echo $mensagem;}; ?></h5>
		</div>
		<!-- Redefinição de senha -->
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<form method="POST" action="?perfil=senha_pf"class="form-horizontal" role="form">
					<div class="form-group">
						<h5>Redefinição de senha</h5>
						<div class="col-md-offset-2 col-md-8"><label>Insira sua senha antiga para confirmar a mudança.</label>
							<input type="password" name="senha03" class="form-control" id="inputName" placeholder="">
						</div>
					</div>
					
					<div class="form-group">
						<div class="col-md-offset-2 col-md-6"><label>Nova senha</label>
							<input type="password" name="senha01" class="form-control" id="inputName" placeholder="">
						</div>
						<div class=" col-md-6"><label>Redigite a nova senha</label>
							<input type="password" name="senha02" class="form-control" id="inputEmail" placeholder="">
						</div>
					</div>
					
					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<button type="submit" class="btn btn-theme btn-lg btn-block">Mudar a senha</button>
						</div>
					</div>
				</form>
			</div>
		</div>
		<!-- Fim Redefinição de Senha -->
		
		<!-- Pergunta de Segurança -->
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<form method="POST" action="?perfil=senha_pf"class="form-horizontal" role="form">
					<h5>Recuperação de Senha</h5>
						<div class="form-group">
							<div class="col-md-offset-2 col-md-8"><strong>Escolha uma pergunta secreta:</strong><br/>
								<select class="form-control" name="idFraseSeguranca" id="idFraseSeguranca">
									<option></option>
									<?php geraOpcao("frase_seguranca",$pf['idFraseSeguranca'],"");	?>
								</select>	
							</div>
						</div> 
					
					<div class="form-group">
						<div class="col-md-offset-2 col-md-8"><label>Resposta</label>
							<input type="text" name="respostaFrase" class="form-control" id="respostaFrase" placeholder="Ex: Amarelo">
						</div>
					</div>
					
				<!-- Botão para gravar -->
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8">
						<input type="hidden" name="fraseSeguranca" value="<?php echo $pf['id'] ?>">
						<input type="submit" value="GRAVAR" class="btn btn-theme btn-lg btn-block">
					</div>
				</div>
				</form>
			</div>
		</div>
		<!-- Fim Pergunta de Segurança -->
	</div>
</section>