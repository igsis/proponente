<?php
function recuperaPessoa($id,$tipo)
{
	//recupera os dados de uma pessoa
	$con = bancoMysqli();
	if($id == 0)
	{
		$y['nome'] = ""; 
		$y['tipo'] = "";
		$y['numero'] = "";		
		return $y;
	}
	else
	{
		switch($tipo)
		{
			case '1':
				$sql = "SELECT * FROM usuario_pf WHERE Id_PessoaFisica = $id";
				$query = mysqli_query($con,$sql);
				$x = mysqli_fetch_array($query);
				$y['nome'] = $x['Nome']; 
				$y['tipo'] = "Pessoa física";
				$y['numero'] = $x['CPF'];
				$y['cep'] = $x['CEP'];
				$y['ccm'] = $x['CCM'];
				$y['email'] = $x['Email'];
				$y['telefones'] = $x['Telefone1']." / ".$x['Telefone2']." / ".$x['Telefone3'];
				return $y;
			break;
			case '2':
				$sql = "SELECT * FROM usuario_pj WHERE Id_PessoaJuridica = $id";
				$query = mysqli_query($con,$sql);
				$x = mysqli_fetch_array($query);
				$y['nome'] = $x['RazaoSocial']; 
				$y['tipo'] = "Pessoa jurídica";
				$y['numero'] = $x['CNPJ'];
				$y['cep'] = $x['CEP'];
				$y['ccm'] = $x['CCM'];
				$y['email'] = $x['Email'];
				$y['telefones'] = $x['Telefone1']." / ".$x['Telefone2']." / ".$x['Telefone3'];
				return $y;	
			break;
			case '3':
				$sql = "SELECT * FROM sis_representante_legal WHERE Id_RepresentanteLegal = $id";
				$query = mysqli_query($con,$sql);
				$x = mysqli_fetch_array($query);
				$y['nome'] = $x['RepresentanteLegal']; 
				$y['tipo'] = "Representante legal";
				$y['numero'] = $x['CPF'];		
				return $y;
			break;
		}
	}
}


function listaArquivosPessoa($idPessoa,$tipo,$form,$pag)
{
	$con = bancoMysqli();
	$sql = "SELECT * 
		FROM igsis_arquivos_pessoa 
		WHERE idPessoa = '$idPessoa' 
		AND idTipoPessoa = '$tipo' 
		AND publicado = '1'";
	$query = mysqli_query($con,$sql);
	echo "
		<table class='table table-condensed'>
			<thead>
				<tr class='list_menu'>
					<td width='30%'>Tipo</td>
					<td>Nome do arquivo</td>
					<td width='10%'></td>
				</tr>
			</thead>
			<tbody>";
	while($campo = mysqli_fetch_array($query))
	{
		$tipoDoc = recuperaDados("upload_tipo_documento",$campo['tipo'],"idTipoDoc");
		echo "<tr>";
		echo "<td class='list_description'>".$tipoDoc['documento']."</td>";
		echo "<td class='list_description'><a href='../uploadsdocs/".$campo['arquivo']."' target='_blank'>".$campo['arquivo']."</a></td>";
		echo "
			<td class='list_description'>
				<form method='POST' action='?perfil=".$pag."&p=frm_arquivos&id=".$idPessoa."&tipo=".$tipo."'>
					<input type='hidden' name='idPessoa' value='".$idPessoa."' />
					<input type='hidden' name='tipoPessoa' value='".$tipo."' />
					<input type='hidden' name='$form' value='1' />
					<input type='hidden' name='apagar' value='".$campo['idArquivosPessoa']."' />
					<input type ='submit' class='btn btn-theme  btn-block' value='apagar'></td></form>"	;
		echo "</tr>";		
	}
	echo "
		</tbody>
		</table>";
}

?>