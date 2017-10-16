<?php
$con = bancoMysqli();
$idPessoaFisica = $_SESSION['idUser'];

$tipoPessoa = 1;

$server = "http://".$_SERVER['SERVER_NAME']."/capac/"; //mudar para pasta do igsis
$http = $server."/pdf/";
$link1 = $http."rlt_declaracaoccm_pf.php"."?id_pf=".$idPessoaFisica;


/* Insere os documentos */
if(isset($_POST['cadastrarDocumentos']))
{
	$idPessoaFisica = $_POST['cadastrarDocumentos'];
	$ccm = $_POST['ccm'];
	$pis = $_POST['pis'];
	$rg = $_POST['rg'];	
		
	$sql_insere_cpf = "UPDATE `usuario_pf` SET 
	`ccm` = '$ccm',
	`pis` = '$pis',
	`rg` = '$rg'
	WHERE `id` = '$idPessoaFisica'";
	if(mysqli_query($con,$sql_insere_cpf))
	{
		$mensagem = "Documento(s) atualizado(s) com sucesso!";	
	}
	else
	{
		$mensagem = "Erro ao editar o(s) documento(s)! Tente novamente.";
	}
}

/* Grava o Tipo de Documento */
if(isset($_POST['tipoDocumento']))
{
	$idTipoDocumento = $_POST['idTipoDocumento'];
	
	$sql_atualiza_tipo_documento = "UPDATE usuario_pf SET
	`idTipoDocumento` = '$idTipoDocumento'
	WHERE `id` = '$idPessoaFisica'";
	if(mysqli_query($con,$sql_atualiza_tipo_documento))
	{
		$mensagem = "Atualizado com sucesso!";	
	}
	else
	{
		$mensagem = "Erro ao atualizar o tipo de documento! Tente novamente.";
	}
}

/* Edita o RG 
if(isset($_POST['editaRg']))
{
	
	$sql_edita_rg = "UPDATE `usuario_pf` SET `rg` = '$rg' 
	WHERE `id` = '$idPessoaFisica'";
	if(mysqli_query($con,$sql_edita_rg))
	{
		$mensagem = "Atualizado com sucesso!";	
	}
	else
	{
		$mensagem = "Erro ao editar os dados! Tente novamente.";
	}
}
*/

if(isset($_POST["enviar"]))
{
	$sql_arquivos = "SELECT * FROM upload_lista_documento WHERE idTipoPessoa = '$tipoPessoa' AND id IN (1,2,11,14)";
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
						$sql_insere_arquivo = "INSERT INTO `upload_arquivo` (`idTipoPessoa`, `idPessoa`, `idUploadListaDocumento`, `arquivo`, `dataEnvio`, `publicado`) VALUES ('$tipoPessoa', '$idPessoaFisica', '$y', '$new_name', '$hoje', '1'); ";
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


$pf = recuperaDados("usuario_pf","id",$idPessoaFisica);
?>

<section id="list_items" class="home-section bg-white">
	<div class="container"><?php include 'includes/menu_interno_pf.php'; ?>
		<div class="form-group">
			<h3>DOCUMENTOS</h3>
			<p><b>Código de cadastro:</b> <?php echo $idPessoaFisica; ?> | <b>Nome:</b> <?php echo $pf['nome']; ?></p>
			<h5><?php if(isset($mensagem)){echo $mensagem;}; ?></h5>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<!-- Escolha o tipo de documento -->
				<form class="form-horizontal" role="form" action="?perfil=documentos_pf" method="post">
				
					<div class="form-group">
						<div class="col-md-offset-2 col-md-6"><strong>Tipo de documento *:</strong><br/>
							<select class="form-control" id="idTipoDocumento" name="idTipoDocumento" >
								<?php geraOpcao("tipo_documento",$pf['idTipoDocumento'],""); ?>  
							</select>
						</div>
						<div class=" col-md-6"><br/>
							<input type="hidden" name="tipoDocumento" value="<?php echo $pf['id'] ?>">	
							<input type="submit" value="Escolher" class="btn btn-theme btn-lg btn-block">
						</div>
					</div>	
				</form>
			<!-- Fim Escolha o tipo de documento -->
			
			<form class="form-horizontal" role="form" action="?perfil=documentos_pf" method="post">	
			
				<div class="form-group">
				<!-- Se for RG -->
				<?php
				If ($pf['idTipoDocumento'] == 1) //se for rg
				{?>				
					<div class="col-md-offset-2 col-md-8"><strong>RG nº *:</strong><br/>
				<?php			
				}
				If ($pf['idTipoDocumento'] == 2) //se for rne
				{				
				?>
					<div class="col-md-offset-2 col-md-8"><strong>RNE nº *:</strong><br/>
				<?php
				}
				If ($pf['idTipoDocumento'] == 3)// se for passaporte
				{
				?>
					<div class="col-md-offset-2 col-md-8"><strong>Passaporte nº *:</strong><br/>
				<?php
				}
				?>
						<input type="text" class="form-control" name="rg" placeholder="Número" value="<?php echo $pf['rg']; ?>">
					</div>
				</div>
						
				
				<!-- demais campos -->						
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>CPF *:</strong><br/>
						<input type="text" readonly class="form-control" id="cpf" name="cpf" placeholder="CPF" value="<?php echo $pf['cpf']; ?>">
					</div>					
				</div>
			
				<div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>CCM:</strong><br/>
						<input type="text" class="form-control" id="ccm" name="ccm" placeholder="Nº do CCM" value="<?php echo $pf['ccm']; ?>">
					</div>
					<div class="col-md-6"><strong>PIS/PASEP/NIT:</strong><br/>
						<input type="text" class="form-control" id="pis" name="pis" placeholder="Nº do PIS/PASEP/NIT" value="<?php echo $pf['pis']; ?>">
					</div>
				</div>
				<!-- fim dos campos -->
	
				<!-- Botão para gravar -->		
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8">
						<input type="hidden" name="cadastrarDocumentos" value="<?php echo $idPessoaFisica ?>">	
						<input type="hidden" name="Sucesso" id="Sucesso" />
						<input type="submit" value="GRAVAR" class="btn btn-theme btn-lg btn-block">
					</div>
				</div>
			</form>
					
					
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8"><hr/><br/></div>
				</div>
				
				<!-- Links emissão de documentos -->
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8">
						<div class="table-responsive list_info"><h6>Gerar Arquivo(s)</h6>
						<p>Para gerar alguns dos arquivos online, utilize os links abaixo:</p>
							<div align="left">
								<a href="https://www.receita.fazenda.gov.br/Aplicacoes/SSL/ATCTA/cpf/ImpressaoComprovante/ConsultaImpressao.asp" target="_blank">Cartão CPF</a></i><br/><br />
								<a href="https://ccm.prefeitura.sp.gov.br/login/contribuinte?tipo=F" target="_blank">FDC CCM - Ficha de Dados Cadastrais de Contribuintes Mobiliários</a></i><br/><br />
								<a href='<?php echo $link1 ?>' target="_blank">Declaração CCM</a></i><br/><br />
							</div>
						</div>
					</div>
				</div>
				
				<!-- Exibir arquivos -->
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8">
						<div class="table-responsive list_info"><h6>Arquivo(s) Anexado(s)</h6>
							<?php listaArquivoCamposMultiplos($idPessoaFisica,$tipoPessoa,"","documentos_pf",1); ?>
						</div>
					</div>
				</div>				
				
				
				<!-- Upload de arquivo 1 -->
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8">
						<div class = "center">
						<form method="POST" action="?perfil=documentos_pf" enctype="multipart/form-data">
							<table>
								<tr>
									<td width="50%"><td>
								</tr>
								<?php 
									$sql_arquivos = "SELECT * FROM upload_lista_documento WHERE idTipoPessoa = '$tipoPessoa' AND id = '1'";
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
									$sql_arquivos = "SELECT * FROM upload_lista_documento WHERE idTipoPessoa = '$tipoPessoa' AND id = '2'";
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
				
								<!-- Upload de arquivo 3 -->
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8">
						<div class = "center">
							<table>
								<tr>
									<td width="50%"><td>
								</tr>
								<?php 
									$sql_arquivos = "SELECT * FROM upload_lista_documento WHERE idTipoPessoa = '$tipoPessoa' AND id = '11'";
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
				
								<!-- Upload de arquivo 4 -->
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8">
						<div class = "center">
							<table>
								<tr>
									<td width="50%"><td>
								</tr>
								<?php 
									$sql_arquivos = "SELECT * FROM upload_lista_documento WHERE idTipoPessoa = '$tipoPessoa' AND id = '14'";
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
						<form class="form-horizontal" role="form" action="?perfil=inicio_pf" method="post">
							<input type="submit" value="Voltar" class="btn btn-theme btn-lg btn-block"  value="<?php echo $idPessoaFisica ?>">
						</form>	
					</div>
					<div class="col-md-offset-4 col-md-2">
						<form class="form-horizontal" role="form" action="?perfil=endereco_pf" method="post">	
							<input type="submit" value="Avançar" class="btn btn-theme btn-lg btn-block"  value="<?php echo $idPessoaFisica ?>">
						</form>	
					</div>					
				</div>
			</div>
		</div>
		</div>
		</div>	
	</div>
</section>  