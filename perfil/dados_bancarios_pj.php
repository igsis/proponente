<?php
$con = bancoMysqli();
$idPessoaJuridica = $_SESSION['idUser'];

$idCampo = 54;
$tipoPessoa = 2;

if(isset($_POST['cadastrarBanco']))
{
	$idPessoaJuridica = $_POST['cadastrarBanco'];
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
		$f_size = $_FILES['arquivo']['size'][$x];
		
		//Extensões permitidas
		$ext = array("PDF","pdf");
		
		if($f_size > 2097152) // 2MB em bytes
		{
			$mensagem = "Erro! Tamanho de arquivo excedido! Tamanho máximo permitido: 02 MB.";
		}
		else
		{
		
			if($nome_arquivo != "")
			{
				$nome_temporario = $_FILES['arquivo']['tmp_name'][$x];		
				$new_name = date("YmdHis")."_".semAcento($nome_arquivo); //Definindo um novo nome para o arquivo
				$hoje = date("Y-m-d H:i:s");
				$dir = '../uploadsdocs/'; //Diretório para uploads
				
				$allowedExts = array(".pdf", ".PDF"); //Extensões permitidas
				
				$ext = strtolower(substr($nome_arquivo,-4));

				if(in_array($ext, $allowedExts)) //Pergunta se a extensão do arquivo, está presente no array das extensões permitidas
				{				
					if(move_uploaded_file($nome_temporario, $dir.$new_name))
					{  
						$sql_insere_arquivo = "INSERT INTO `upload_arquivo` (`idTipoPessoa`, `idPessoa`, `idUploadListaDocumento`, `arquivo`, `dataEnvio`, `publicado`) VALUES ('$tipoPessoa', '$idPessoaJuridica', '$idCampo', '$new_name', '$hoje', '1'); ";
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
				else
				{
					$mensagem = "Erro no upload! Anexar documentos somente no formato PDF."; 
				}	
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
$pj = recuperaDados("usuario_pj","id",$idPessoaJuridica);
?>

<section id="list_items" class="home-section bg-white">
	<div class="container"><?php include 'includes/menu_interno_pj.php'; ?>
		<div class="form-group">
			<h3>DADOS BANCÁRIOS</h3>
			<p><b>Código de cadastro:</b> <?php echo $idPessoaJuridica; ?> | <b>Razão Social:</b> <?php echo $pj['razaoSocial']; ?></p>
			<h5><?php if(isset($mensagem)){echo $mensagem;};?></h5>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
			<form class="form-horizontal" role="form" action="?perfil=dados_bancarios_pj" method="post">
			
			<font color="#FF0000"><strong>Realizamos pagamentos de valores acima de R$ 5.000,00 *SOMENTE COM CONTA NO BANCO DO BRASIL*.</strong></font><br />
			<p>
						 
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Banco:</strong><br/>
						<select class="form-control" name="codigoBanco" id="codigoBanco">
							<option></option>
							<?php geraOpcao("banco",$pj['codigoBanco'],"");	?>
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
						<input type="hidden" name="cadastrarBanco" value="<?php echo $idPessoaJuridica ?>">
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
					$link1 = $http."rlt_facc_pj.php"."?id_pj=".$idPessoaJuridica;
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
							<?php listaArquivoCamposMultiplos($idPessoaJuridica,$tipoPessoa,$idCampo,"dados_bancarios_pj",3); ?>
						</div>
					</div>
				</div>				
				
				
				<!-- Upload de arquivo -->
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8">
						<div class = "center">
						<form method="POST" action="?perfil=dados_bancarios_pj" enctype="multipart/form-data">
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
							<input type="hidden" name="idPessoa" value="<?php echo $idPessoaJuridica; ?>"  />
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