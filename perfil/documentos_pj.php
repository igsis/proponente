<?php
$con = bancoMysqli();
$idPessoaJuridica = $_SESSION['idUser'];

$tipoPessoa = 2;

$server = "http://".$_SERVER['SERVER_NAME']."/capac/"; 
$http = $server."/pdf/";
$link1 = $http."rlt_declaracaoccm_pj.php"."?id_pj=".$idPessoaJuridica;

if(isset($_POST['cadastrarDocumentosPJ']))
{
	$idPessoaJuridica = $_POST['cadastrarDocumentosPJ'];
	$ccm = $_POST['ccm'];
	
	$sql_documentos_pj = "UPDATE `usuario_pj` SET
	`ccm` = '$ccm'
	WHERE `id` = '$idPessoaJuridica'";	
	
	if(mysqli_query($con,$sql_documentos_pj))
	{
		$mensagem = "Atualizado com sucesso!";	
	}
	else
	{
		$mensagem = "Erro ao atualizar! Tente novamente.";
	}	
}

if(isset($_POST["enviar"]))
{
	$sql_arquivos = "SELECT * FROM upload_lista_documento WHERE idTipoPessoa = '$tipoPessoa' AND id IN (9,21)";
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
						$sql_insere_arquivo = "INSERT INTO `upload_arquivo` (`idTipoPessoa`, `idPessoa`, `idUploadListaDocumento`, `arquivo`, `dataEnvio`, `publicado`) VALUES ('$tipoPessoa', '$idPessoaJuridica', '$y', '$new_name', '$hoje', '1'); ";
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
			<h3>DOCUMENTOS</h3>
			<p><b>Código de cadastro:</b> <?php echo $idPessoaJuridica; ?> | <b>Razão Social:</b> <?php echo $pj['razaoSocial']; ?></p>
			<h5><?php if(isset($mensagem)){echo $mensagem;}; ?></h5>
		</div>
		<div class="row">	
			<div class="col-md-offset-1 col-md-10">	
				<form class="form-horizontal" role="form" action="?perfil=documentos_pj" method="post">	
					<div class="form-group">
						<div class="col-md-offset-2 col-md-8"><strong>CNPJ *:</strong><br/>
							<input type="text" readonly class="form-control" id="cnpj" name="cnpj" placeholder="CNPJ" value="<?php echo $pj['cnpj']; ?>">
						</div>
					</div>
					
					<div class="form-group">
						<div class="col-md-offset-2 col-md-8"><strong>CCM:</strong><br/>
							<input type="text" class="form-control" id="ccm" name="ccm" placeholder="CCM" value="<?php echo $pj['ccm']; ?>">
						</div>
					</div>
					
					<!-- Botão para gravar -->
					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<input type="hidden" name="cadastrarDocumentosPJ" value="<?php echo $idPessoaJuridica ?>">	
							<input type="hidden" name="Sucesso" id="Sucesso" />
							<input type="submit" value="GRAVAR" class="btn btn-theme btn-lg btn-block">
						</div>
					</div>
					
					<div class="form-group">
						<div class="col-md-offset-2 col-md-8"><br/></div>
					</div>
				</form>
			
			<!-- Links emissão de documentos -->
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8">
						<div class="table-responsive list_info"><h6>Gerar Arquivo(s)</h6>
						<p>Para gerar alguns dos arquivos online, utilize os links abaixo:</p>
							<div align="left">
								<a href="http://www.receita.fazenda.gov.br/pessoajuridica/cnpj/cnpjreva/cnpjreva_solicitacao.asp" target="_blank">Cartão CNPJ</a></i><br/><br />
								<a href="https://ccm.prefeitura.sp.gov.br/login/contribuinte?tipo=F" target="_blank">FDC CCM - Ficha de Dados Cadastrais de Contribuintes Mobiliários</a></i><br/><br />
								<a href='<?php echo $link1 ?>' target="_blank">Declaração CCM (Empresa Fora de São Paulo)</a></i><br/><br />
							</div>
						</div>
					</div>
				</div>
			
			<!-- Exibir arquivos -->
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8">
						<div class="table-responsive list_info"><h6>Arquivo(s) Anexado(s)</h6>
							<?php listaArquivoCamposMultiplos($idPessoaJuridica,$tipoPessoa,"","documentos_pj",2); ?>
						</div>
					</div>
				</div>				
				
				
				<!-- Upload de arquivo 1 -->
					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<div class = "center">
							<form method="POST" action="?perfil=documentos_pj" enctype="multipart/form-data">
								<table>
									<tr>
										<td width="50%"><td>
									</tr>
									<?php 
										$sql_arquivos = "SELECT * FROM upload_lista_documento WHERE idTipoPessoa = '$tipoPessoa' AND id = '9'";
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
							</div>
						</div>
					</div>	
					
					
				<!-- Upload de arquivo 2 -->
					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<div class = "center">
								<table>
									<tr>
										<td width="50%"><td>
									</tr>
									<?php 
										$sql_arquivos = "SELECT * FROM upload_lista_documento WHERE idTipoPessoa = '$tipoPessoa' AND id = '21'";
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
								<input type="hidden" name="idPessoa" value="<?php echo $idPessoaJuridica ?>"  />
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
						<form class="form-horizontal" role="form" action="?perfil=inicio_pj" method="post">
							<input type="submit" value="Voltar" class="btn btn-theme btn-lg btn-block"  value="<?php echo $idPessoaJuridica ?>">
						</form>	
					</div>
					<div class="col-md-offset-4 col-md-2">
						<form class="form-horizontal" role="form" action="?perfil=endereco_pj" method="post">	
							<input type="submit" value="Avançar" class="btn btn-theme btn-lg btn-block"  value="<?php echo $idPessoaJuridica ?>">
						</form>	
					</div>					
				</div>
			</div>
		</div>
	</div>
</section>  