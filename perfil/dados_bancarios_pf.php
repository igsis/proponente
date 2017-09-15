<?php
$con = bancoMysqli();
$idPessoaFisica = $_SESSION['idUsuario'];

$idCampo = 25;
$tipoPessoa = 1;

if(isset($_POST['cadastrarBanco']))
{
	$idPessoaFisica = $_POST['cadastrarBanco'];
	$CodigoBanco = $_POST['codigoBanco'];
	$Agencia = $_POST['agencia'];
	$Conta = $_POST['conta'];
	
	$sql_atualiza_pf = "UPDATE usuario_pf SET
	`codigoBanco` = '$CodigoBanco', 
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


if(isset($_POST["enviar"]))
{
	$sql_arquivos = "SELECT * FROM upload_lista_documento WHERE idTipoPessoa = '$tipoPessoa' AND id = '$idCampo'";
	$query_arquivos = mysqli_query($con,$sql_arquivos);
	while($arq = mysqli_fetch_array($query_arquivos))
	{ 
		$y = $arq['id'];
		$x = $arq['sigla'];
		$nome_arquivo = $_FILES['arquivo']['name'][$x];
		
		if($nome_arquivo != "")
		{
			$nome_temporario = $_FILES['arquivo']['tmp_name'][$x];		
			$new_name = date("YmdHis")."_".semAcento($nome_arquivo); //Definindo um novo nome para o arquivo
			$hoje = date("Y-m-d H:i:s");
			$dir = '../uploadsdocs/'; //Diretório para uploads
		
			if(move_uploaded_file($nome_temporario, $dir.$new_name))
			{  
				$sql_insere_arquivo = "INSERT INTO `upload_arquivo` (`idTipoPessoa`, `idPessoa`, `idUploadListaDocumento`, `arquivo`, `dataEnvio`, `publicado`) VALUES ('$tipoPessoa', '$idPessoaFisica', '$idCampo', '$new_name', '$hoje', '1'); ";
				$query = mysqli_query($con,$sql_insere_arquivo);
			
				if($query)
				{
					$mensagem = "Arquivo recebido com sucesso";
				}
				else
				{
					$mensagem = "Erro ao gravar no banco";
				}
				
			}
			else
			{
				 $mensagem = "Erro no upload"; 
			}
		}	
	}
}

if(isset($_POST['apagar']))
{
	$idArquivo = $_POST['apagar'];
	$sql_apagar_arquivo = "UPDATE upload_arquivo SET publicado = 0 WHERE id = '$idArquivo'";
	if(mysqli_query($con,$sql_apagar_arquivo))
	{
		$mensagem =	"Arquivo apagado com sucesso!";
		gravarLog($sql_apagar_arquivo);
	}
	else
	{
		$mensagem = "Erro ao apagar o arquivo. Tente novamente!";
	}
}


$pf = recuperaDados("usuario_pf","id",$idPessoaFisica);

?>

<section id="list_items" class="home-section bg-white">
	<div class="container"><?php include 'includes/menu_interno_pf.php'; ?>
		<div class="form-group">
			<h3>DADOS BANCÁRIOS</h3>
			<p><b>Código de cadastro:</b> <?php echo $idPessoaFisica; ?> | <b>Nome:</b> <?php echo $pf['nome']; ?></p>
			<h5><?php if(isset($mensagem)){echo $mensagem;};?></h5>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
			<form class="form-horizontal" role="form" action="?perfil=dados_bancarios_pf" method="post">
			
			<font color="#FF0000"><strong>Realizamos pagamentos de valores acima de R$ 4.999,99 *SOMENTE COM CONTA NO BANCO DO BRASIL*.</strong></font>
			<p>
			
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Banco:</strong><br/>
						<select class="form-control" name="codigoBanco" id="codigoBanco">
							<option></option>
							<?php geraOpcao("banco",$pf['codigoBanco'],"");	?>
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
						<input type="hidden" name="cadastrarBanco" value="<?php echo $idPessoaFisica ?>">
						<input type="submit" value="GRAVAR" class="btn btn-theme btn-lg btn-block">
					</div>
				</div>
			</form>				
				
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8"><hr/></div>
				</div>
					
				<!-- Gerar FACC -->
				<?php
					$server = "http://".$_SERVER['SERVER_NAME']."/proponente/"; //mudar para pasta do igsis
					$http = $server."/pdf/";
					$link1 = $http."rlt_facc_pf.php"."?id_pf=".$idPessoaFisica;
				?>
					
				<div class="form-group">
					<div class="col-md-offset-2 col-md-5">
						<p align="left">Após inserir seus dados pessoais e os dados bancários, clique no botão para gerar a FACC</p>						
					</div>
					<div class="col-md-3">
						<a href='<?php echo $link1 ?>' target='_blank' class="btn btn-theme btn-lg btn-block"><strong>Gerar</strong></a>							
					</div>
				</div>
				<!--  FIM Gerar FACC -->
								
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8"><hr/><br/></div>
				</div>
				
				<!-- Exibir arquivos -->
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8">
						<div class="table-responsive list_info"><h6>Arquivo(s) Anexado(s)</h6>
							<?php listaArquivoCamposMultiplos($idPessoaFisica,$tipoPessoa,$idCampo,"dados_bancarios_pf",3); ?>
						</div>
					</div>
				</div>				
				
				
				<!-- Upload de arquivo -->
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8">
						<div class = "center">
						<form method="POST" action="?perfil=dados_bancarios_pf" enctype="multipart/form-data">
							<table>
								<tr>
									<td width="50%"><td>
								</tr>
								<?php 
									$sql_arquivos = "SELECT * FROM upload_lista_documento WHERE idTipoPessoa = '$tipoPessoa' AND id = '$idCampo'";
									$query_arquivos = mysqli_query($con,$sql_arquivos);
									while($arq = mysqli_fetch_array($query_arquivos))
									{ 
								?>
										<tr>
											<td><label><?php echo $arq['documento']?></label></td><td><input type='file' name='arquivo[<?php echo $arq['sigla']; ?>]'></td>
										</tr>
								<?php 
									}
								?>
							</table><br>						
							<input type="hidden" name="idPessoa" value="<?php echo $idPessoaFisica; ?>"  />
							<input type="hidden" name="tipoPessoa" value="<?php echo $tipoPessoa; ?>"  />
							<input type="submit" name="enviar" class="btn btn-theme btn-lg btn-block" value='Enviar'>
						</form>
						</div>
					</div>
				</div>
				<!-- Fim Upload de arquivo -->
				
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8"><hr/><br/></div>
				</div>
											
		
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