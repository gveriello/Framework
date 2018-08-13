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
		<input type="text" placeholder="Digita il nome della Page" name="name_file"><br><br>
		<button type="submit" name="create_file">Crea</button>
	</form>
	<?php 


		if(isset($_POST['create_file'])){
			$nome_file = $_POST['name_file'];
			$boh = '$page';
			$contenuto_js = 
			"<script>

			</script>
			";

			$contenuto_layout = 
			'
			<!DOCTYPE html>
				<html>
				<head>
				    <meta charset="utf-8" />
				    <title>
				        <?= $page; ?>
				    </title>
				</head>
				<body>
				    <h1>
				        Benvenuto in <?= $page; ?>
				    </h1>
				</body>
				</html>
			';

			$contenuto_model = 
			"
				<?php
					class ".$nome_file."Model extends Model{
					    function __construct(){
					        
					    }
					}
			";

			$contenuto_php = 
			'
				<?php
					class '.$nome_file.'PHP extends PHPBehind{

					    function __construct($_querystring){
					        parent::setQueryString($_querystring);
					    }

					    public function index(){
					        Allocate(LAYOUT, $this->layout);
					    }	
			';
			if(crea_file($nome_file, $contenuto_js, 'JS', '.js', 'jsbehind')){
				echo "Ho creato il file in: application/jsbehind/".$nome_file."JS.js<br>";
				$files = 1;
			}

			if(crea_file($nome_file, $contenuto_model, 'Model', '.class.php', 'model')){
				echo "Ho creato il file in: application/model/".$nome_file."Model.class.php<br>";
				$files = $files+1;
			}
			if(crea_file($nome_file, $contenuto_layout, 'Layout', '.php', 'layout')){
				echo "Ho creato il file in: application/layout/".$nome_file."Layout.php<br>";
				$files = $files+1;
			}
			if(crea_file($nome_file, $contenuto_php, 'PHP', '.class.php', 'phpbehind')){
				echo "Ho creato il file in: application/phpbehind/".$nome_file."PHP.class.php<br>";
				$files = $files+1;
			}
			if($files === 4){
				echo "Tutti i file sono stati creati, buon lavoro";
			}
		}


	function crea_file($nomefile = '', $contenuto = '', $tipo = 'PHP', $estensione = '.php', $cartella = ''){
			
			if(file_exists('../application/'.$cartella.'/'.$nomefile.$tipo.$estensione)){
				unlink('../application/'.$cartella.'/'.$nomefile.$tipo.$estensione);
				$fp = fopen('../application/'.$cartella.'/'.$nomefile.$tipo.$estensione,'w+');
				fwrite($fp, $contenuto);
		    	fclose($fp);
		    	echo "<label style='color:red'>Il file esiste già, è stato sovrascritto</label>";
			}else{
				$fp = fopen('../application/'.$cartella.'/'.$nomefile.$tipo.$estensione,'w+');
				fwrite($fp, $contenuto);
		    	fclose($fp);

			}

			if($fp){
				return true;
			}else{
				return false;
			}
	}
	?>
</body>
</html>