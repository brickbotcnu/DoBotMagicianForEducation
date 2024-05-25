<?php
session_start();
function logged_in(){
    if(isset($_SESSION['username']) || isset($_COOKIE['username'])){
        return true;
    }
    else{
        return false;
    }
}
if (!logged_in()){
     header("location:index.php");
}else {
//print_r($_POST);
if(isset($_POST['trimite'])) {
    if (isset($_POST['x'])&isset($_POST['y'])&&isset($_POST['z'])&&isset($_POST['r'])&&isset($_POST['s'])){
    $x=$_POST['x'];
    $y=$_POST['y'];
    $z=$_POST['z'];
    $r=$_POST['r'];
    $s=$_POST['s'];
    $u=$_SESSION['username'];
    $params=array_map(null,$x,$y,$z,$r,$s);
    //print_r($params);

   foreach ($params as $linie_tabel){
	//print_r($linie_tabel);
        if ($linie_tabel[4]=='true'){
           $suction=1;
         }else{
           $suction=0;
         }
     if (!exec("python3 DoBot.py -x ".$linie_tabel[0]." -y ".$linie_tabel[1]." -z ".$linie_tabel[2]." -r ".$linie_tabel[3]." -s ".$suction." -u ".$u,$output)){
     //print_r($output);
 }
   }
   //exit();
   }
}
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dobot Magician Control</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #1e1e1e;
            margin: 0;
            padding: 0;
            color: #fff;
        }

        .container, .tabel-main-container{ 
		display: flex; 
		flex-wrap: wrap; 
		align-items: flex-start;
		justify-content: space-between; 
		margin: 20px; 
		padding: 20px; 
		background-color: #252525; 
		box-shadow: 0 0 20px rgba(0, 0, 0, 0.5); 
		border-radius: 10px;
        }

        .video-container {
            width: 651px;
            height: 501px;
            background-color: #333333;
            margin-right: 20px;
            border-radius: 10px;
        }

        .coordinates-container {
		flex: 1;
		height 501; 
		padding: 20px;
    		background-color: #333333;
    		border-radius: 10px;
    		margin-right: 10px;

        }


	.image-container {
                height: 501px;
                width: 282px;
                padding: 0px;
                background-color: #333333;
                border-radius: 10px;
                margin-right: 10px;
		background-image: url('img/DoBotView.jpg');
   		background-size: 282px 501px;
    		background-position: center;
        }


	.image-container{
		margin right: 20px;
	}

	.tabel-container {
		flex-grow: 1 100%;
		padding: 20px;
		background-color: #333333;
		border-radius: 10px;
		margin-top: 10px;
	}

        h2 {
            margin-top: 0;
            color: #66ccff; 
            border-bottom: 2px solid #66ccff; 
            padding-bottom: 10px;
        }

        form {
            margin-top: 20px;
            display: flex;
            flex-direction: column; 
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #66ccff; 
        }

        input[type="text"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #666666; 
            border-radius: 4px;
            box-sizing: border-box;
            background-color: #1e1e1e; 
            color: #fff; 
        }

        input[type="submit"], .suction-button {
            background-color: #4da6ff; 
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px; 
            align-self: flex-end; 
        }

        input[type="submit"]:hover, .suction-button:hover {
            background-color: #66ccff; 
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #666666; 
        }

        th {
            background-color: #404040; 
            color: #66ccff; 
            border-top: 1px solid #666666; 
        }
        
        .checkbox {
  			display: block;
  			position: relative;
  			padding-left: 35px;
  			margin-bottom: 12px;
  			cursor: pointer;
  			font-size: 22px;
  			-webkit-user-select: none;
  			-moz-user-select: none;
  			-ms-user-select: none;
  			user-select: none;
		}

		.checkbox input {
 			position: absolute;
  			opacity: 0;
  			cursor: pointer;
  			height: 0;
  			width: 0;	
		}

		.checkmark {
  			position: absolute;
  			top: 0;
  			left: 0;
  			height: 25px;
  			width: 25px;
  			background-color: #eee;
		}

		.checkbox:hover input ~ .checkmark {
  			background-color: #ccc;
		}

		.checkbox input:checked ~ .checkmark {
  			background-color: #66ccff;
		}

		.checkmark:after {
  			content: "";
  			position: absolute;
  			display: none;
		}

		.checkbox input:checked ~ .checkmark:after {
  		display: block;
		}

		.checkbox .checkmark:after {
  			left: 9px;
  			top: 5px;
  			width: 5px;
  			height: 10px;
  			border: solid white;
  			border-width: 0 3px 3px 0;
  			-webkit-transform: rotate(45deg);
  			-ms-transform: rotate(45deg);
  			transform: rotate(45deg);
		}

    </style>
</head>
<body>
    <h2><img src="img/SiglaCNU.png" style="height:40px;">&nbsp;Dobot Magician Control</h2>
    <div class="container">
        <div class="video-container">
             <iframe src="http://192.168.0.203:8000" style="width:650px;height:500px;"></iframe>
        </div>

        <div class="coordinates-container">
            <h2>Introduceți coordonatele și acțiunile</h2>
            <form name="form_coord" id="form_coord" action="trimite_coordonate.php" method="post">
            <label for="coord_x">Coordonata X:</label>
                <input type="number" id="coord_x" name="coord_x"><br>
                <label for="coord_y">Coordonata Y:</label>
                <input type="number" id="coord_y" name="coord_y"><br>
                <label for="coord_z">Coordonata Z:</label>
                <input type="number" id="coord_z" name="coord_z"><br>
                <label for="coord_r">Rotatia capului</label>
                <input type="number" id="coord_r" name="coord_r"><br>
                <label for="ventuza">Activeaza Ventuza</label>
		<label class="checkbox">
  				<input type="checkbox", id="ventuza" name="ventuza">
  				<span class="checkmark"></span>
		</label><br>
                <input type="submit" value="Adauga comanda">
	     </form> 
	</div>
		<div class="image-container">
		</div>
	</div>
<?php
 echo " <form action=".$_SERVER['PHP_SELF']." method=\"POST\" name=\"comenzi\">\n";
?>
	<div class="tabel-main-container">
	    <div class="tabel-container">
           	<table name="coord_comm" id="coord_comm">
            	     	<thead><tr><th>Coord X</th><th>Coord Y</th><th>Coord Z</th><th>Rot r</th><th>Absorbtie</th></tr></thead>
            		<tbody></tbody>
            	</table>
            	<input type="submit" name="trimite" value="Trimite comenzile catre DoBot">
            	</form>
	     </div>
	</div>
            <script>
    // Array pentru a stoca coordonatele
    var coordQueue = [];

    // Funcție pentru a adăuga coordonatele în coadă
    function addToQueue(coordX, coordY, coordZ, coordR, sucction) {
        coordQueue.push({ x: coordX, y: coordY, z: coordZ, r: coordR, s:sucction });
    }

    // Funcție pentru a afișa istoricul coordonatelor
    function displayHistory() {
        var tableBody = document.querySelector('#coord_comm tbody');
        tableBody.innerHTML = ''; // Curăță tabelul

        // Iterează prin fiecare coordonată din coadă și adaugă-o în tabel
        coordQueue.forEach(function(coord) {
            var row = document.createElement('tr');
            row.innerHTML = '<td><input type="number" name="x[]" value="' + coord.x + '"></td>' +
                            '<td><input type="number" name="y[]" value="' + coord.y + '"></td>' +
                            '<td><input type="number" name="z[]" value="' + coord.z + '"></td>' +
                            '<td><input type="number" name="r[]" value="' + coord.r + '"></td>' +
                            '<td><input type="text" name="s[]" value="' + coord.s + '"></td>' +
                            '</tr>';
            tableBody.appendChild(row);
        });
    }

    // Funcția pentru a activa/dectiva ventuza
    function activateSuction() {
        // Implementarea funcționalității pentru activarea/dezactivarea ventuzei
    }

    // La trimiterea formularului
    document.querySelector('#form_coord').addEventListener('submit', function(event) {
        event.preventDefault(); // Previne comportamentul implicit de trimitere a formularului

        // Obține valorile coordonatelor introduse de utilizator
        var coordX = document.getElementById('coord_x').value;
        var coordY = document.getElementById('coord_y').value;
        var coordZ = document.getElementById('coord_z').value;
        var coordR = document.getElementById('coord_r').value;
        var sucction = document.getElementById('ventuza').checked;

        // Adaugă coordonatele la coadă
        addToQueue(coordX, coordY, coordZ, coordR, sucction);

        // Afișează istoricul coordonatelor
        displayHistory();

        // Poți adăuga aici și funcționalitatea pentru trimiterea coordonatelor către server, dacă este necesar
    });
</script>


</body>
</html>
