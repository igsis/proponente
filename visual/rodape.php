

	<footer>
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<p>2017 @ MACAPAC - Mapeamento e Cadastro de Artistas e Profissionais de Arte e Cultura / Secretaria Municipal de Cultura / Prefeitura de São Paulo</p>
				</div>
				<div class="col-md-12">
					<?php
//if($_SESSION['perfil'] == 1){
echo "<strong>SESSION</strong><pre>", var_dump($_SESSION), "</pre>";
echo "<strong>POST</strong><pre>", var_dump($_POST), "</pre>";
echo "<strong>GET</strong><pre>", var_dump($_GET), "</pre>";
echo "<strong>FILES</strong><pre>", var_dump($_FILES), "</pre>";

echo ini_get('session.gc_maxlifetime')/60; // em minutos
//}

?>
				</div>
			</div>		
		</div>	
	</footer>
	 
    
    <script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.smooth-scroll.min.js"></script>
	<script src="js/jquery.dlmenu.js"></script>
	<script src="js/wow.min.js"></script>
	<script src="js/custom.js"></script>
  	</body>
