<html>
<head>
	<style>
		input{
			border: none;
			outline: none;
			height: 50px;
			width: 300px;
			border: 1px solid #B0BEC5;
			border-radius: 5px 5px 5px 5px;
		}
		input:hover{
			border: 1px solid #D84315;
		}

		button{
			border: none;
			box-shadow: none;
			height: 50px;
			width: 200px;
			border-radius: 8px 8px 8px 8px;
			cursor: pointer;
			font-size: 	15px;
			background-color: white;
			border: 1px solid #D84315;
		}

		button:hover{
			background-color: #D84315;
			border: 1px solid black;
		}



	</style>
</head>
<body>
	<form method="post" action="">
		<input type="text" placeholder="Scegli il nome del tuo progetto" name="name_file"><br><br>
		<button type="submit" name="create_file">Crea</button>
	</form>
	<?php 


		if(isset($_POST['create_file'])){

			$nome_file = $_POST['name_file'];
			if(crea_file($nome_file, '', 'JS', '.js', 'jsbehind')){
				echo "Ho creato il file .js<br>";
				$files = 1;
			}

			if(crea_file($nome_file, '', 'Model', '.php', 'model')){
				echo "Ho creato il file Model.php<br>";
				$files = $files+1;
			}
			if(crea_file($nome_file, '', 'Layout', '.php', 'layout')){
				echo "Ho creato il file Layout.php<br>";
				$files = $files+1;
			}
			if(crea_file($nome_file, '', 'PHP', '.php', 'phpbehind')){
				echo "Ho creato il file PHP.php<br>";
				$files = $files+1;
			}
			if($files === 4){
				echo "Tutti i file sono stati creati, buon lavoro";
			}
		}


	function crea_file($nomefile = '', $contenuto = '', $tipo = 'PHP', $estensione = '.php', $cartella = ''){
			
			$fpjs = fopen('../application/'.$cartella.'/'.$nomefile.$tipo.$estensione,'w+');
		    fclose($fpjs);


			if($fpjs){
				return true;
			}else{
				return false;
			}
	}
	?>
</body>
</html>