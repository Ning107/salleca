<?php 
header('Content_type:text/html;charset=utf-8');
$link=@mysqli_connect('localhost','zhangn','107Zhangning','zhangn');
if(mysqli_connect_errno()){
    exit(mysqli_connect_error());
}
mysqli_set_charset($link,'utf8');
$query="select * from consultation";
$result=mysqli_query($link,$query);
if ($result) {
    //pour récupérer toutes les informations
    while($data=mysqli_fetch_array($result,MYSQLI_ASSOC)){
       // print_r($data);
    }
}else{
    var_dump(mysqli_error($link));
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Salle ça - Consultation</title>
    <link href="css/bootstrap.min.css" rel="stylesheet" />
	<link href="https://cdn.bootcss.com/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
  		<a class="navbar-brand" href="#">Salle ça ! </a>
  		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    		<span class="navbar-toggler-icon"></span>
  		</button>

  		<div class="collapse navbar-collapse" id="navbarSupportedContent">
    		<ul class="navbar-nav mr-auto">
      			<li class="nav-item">
        			<a class="nav-link" href="reservation.html">Réservation</a>
      			</li>
      			<li class="nav-item active">
        			<a class="nav-link" href="consultation.php">Consultation<span class="sr-only">(current)</span></a>
      			</li>
      			<li class="nav-item dropdown">
        			<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Marie_R</a>
        			<div class="dropdown-menu" aria-labelledby="navbarDropdown">
          				<a class="dropdown-item" href="compte.html">Mon profil</a>
          				<a class="dropdown-item" href="#">Mes réservations</a>
          				<div class="dropdown-divider"></div>
          				<a class="dropdown-item" href="index.html">Se déconnecter</a>
        			</div>
      			</li>	
    		</ul>

  		</div>
	</nav>
	<div class="jumbotron">
		<h1 style = "text-align : center;">Consultation</h1>
		<p class="lead" style = "text-align : center;">Vous trouverez ici les informations utiles selon la citère que vous choisissez.</p>
	</div>
	<form method = "post" action = "consultation.php">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="form-group">
    				<label for="exampleFormControlSelect1" style="font-size:30px;">Flitrer par : </label>
    				<select class="form-control" id="exampleFormControlSelect1" name = "filtre" >
	      				<option value ="professeur">Professeur</option>
	      				<option value = "salle">Salle</option>
	    			</select>
  				</div>
            </div>
        </div>
    </div>
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="form-group" id="salle" style = "display : none;">
                        <label for="exampleFormControlSelect1" style="font-size:15px;">Nom de salle : </label>
                        <select class="form-control" id="exampleFormControlSelect1" name = "selectsalle">
                            <?php
                                $query2="select distinct salle_name from consultation";
                                $result2=mysqli_query($link,$query2);
                                if ($result2) {
                                    //pour récupérer tous les noms de salle
                                    while($salle=mysqli_fetch_row($result2)){
                                        echo "<option value ='".$salle['0']."'>".$salle['0']."</option>";
                                    }
                                }else{
                                    var_dump(mysqli_error($link));
                                }
                            ?>
                        </select>
                    </div>
                     <div class="form-group" id="professeur">
                        <label for="exampleFormControlSelect1" style="font-size:15px;">Nom de professeur : </label>
                        <select class="form-control" id="exampleFormControlSelect1" name = "selectprof">
                            <?php
                                $query1="select distinct user from consultation where profil='Professeur'";
                                $result1=mysqli_query($link,$query1);
                                if ($result1) {
                                    //pour récupérer tous les noms de professeur
                                    while($nom=mysqli_fetch_row($result1)){
                                        echo "<option value ='".$nom['0']."'>".$nom['0']."</option>";
                                    }
                                }else{
                                    var_dump(mysqli_error($link));
                                }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label>Date : </label>
                        <div class='input-group date' id='datetimepicker1'>
                            <input type='text' class="form-control" />
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div style="margin-left:45%;margin-bottom:30px;">
            <button class="btn btn-primary" type="submit" id = "valide">Valide</button>
        </div >
    </form>
    
    <div class = "container" id="horaires"><?php
    
		if (isset($_POST['filtre'])){
			$filtre = $_POST['filtre'];
			
			if ($filtre == "professeur") {		// si filtre par prof
				if (isset($_POST['selectprof'])){
					$prof = $_POST['selectprof'];
					
					print "<h2 style = 'text-align : center;'>".$prof."</h2>\n
							<div class = 'row'>\n";
					
					$requete = "select salle_name, date, horaire, info from consultation where user = '".$prof."'";
					$reponse=mysqli_query($link,$requete);
					if ($reponse) {
						while($enr=mysqli_fetch_array($reponse,MYSQLI_ASSOC)){
							$salle = $enr['salle_name'];
							$date = $enr['date'];
							$horaire = $enr['horaire'];
							$info = $enr['info'];
							
							print "<div class='col-md-4'>\n
									<div class='card' style='width: 18rem;'>\n
									<div class='card-body'>\n";
							print "<h6 class='card-subtitle mb-2 text-muted'>".$date." | ".$horaire."</h6>";
							print "<p class = 'card-text'>Salle : ".$salle.
									"<br/>\nInformations : ".$info."</p>";
							print "\n</div>
									\n</div>
									\n</div>";
							
						}
					}
				}
			}
			elseif ($filtre == "salle"){	// si filtre par salle
				if (isset ($_POST['selectsalle'])){
					$salle = $_POST['selectsalle'];
					print "<h2 style = 'text-align : center;'>".$salle."</h2>\n
							<div class = 'row'>\n";
					
					$requete = "select user, date, horaire, info from consultation where salle_name = '".$salle."'";
					$reponse=mysqli_query($link,$requete);
					if ($reponse) {
						while($enr=mysqli_fetch_array($reponse,MYSQLI_ASSOC)){
							$prof = $enr['user'];
							$date = $enr['date'];
							$horaire = $enr['horaire'];
							$info = $enr['info'];
							
							print "<div class='col-md-4'>\n
									<div class='card' style='width: 18rem;'>\n
									<div class='card-body'>\n";
							print "<h6 class='card-subtitle mb-2 text-muted'>".$date." | ".$horaire."</h6>";
							print "<p class = 'card-text'>Professeur : ".$prof.
									"<br/>\nInformations : ".$info."</p>";
							print "\n</div>
									\n</div>
									\n</div>";
							
						}
					}
				}
			}
		}
		else {
			echo "Sélectionner les informations de consultation.";
		}
    
		?></div>
    </div>
	
<hr class="my-4">

</body>
<script src="js/core/jquery.3.2.1.min.js" type="text/javascript"></script>
<script src="jquery-3.4.1.js" type="text/javascript"></script>
<script src="js/core/popper.min.js" type="text/javascript"></script>
<script src="js/core/bootstrap.min.js" type="text/javascript"></script>
<!--  Plugin for Switches, full documentation here: http://www.jque.re/plugins/version3/bootstrap.switch/ -->
<script src="js/plugins/bootstrap-switch.js"></script>
<!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->

<script src="https://cdn.bootcss.com/jquery/3.3.1/jquery.js"></script>
<script type="text/javascript" src="js/moment/min/moment-with-locales.js"></script>
<script src="https://cdn.bootcss.com/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
<script>

	var filtre;
	
	
		
		// afficher nom de prof ou nom de salle
	$("[name = 'filtre']").change(function() {
		filtre = $(this).val();
		if (filtre == 'salle') {
			$("#salle").show();
			$("#professeur").hide();
		}
		else {
			$("#salle").hide();
			$("#professeur").show();
		}
	});
	

	
	$(function () {
	$('#datetimepicker1').datetimepicker({
	format: 'DD-MM-YYYY',
	locale: moment.locale('fr')
	});
	$('#datetimepicker2').datetimepicker({
	format: 'YYYY-MM-DD hh:mm',
	locale: moment.locale('zh-cn')
	});
	});
</script>
</html>
