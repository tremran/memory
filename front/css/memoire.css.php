<?php 

header("Content-type: text/css");
include __DIR__ . '/../../src/include.php';

?>

* {
	box-sizing:border-box
}

#conteneur {
	width:<?php echo ($config['taille_ligne'] * ($config['image_largeur_px'] + 2.5 * $config['image_taille_margin']) + 4); ?>px;
	margin:auto;
}


#titre {
	text-align:center;
	background-color:lightgray;
	font-size:20px;
	padding:0.5em;
}

#grille {
	background-color:#f48fb1;
	padding:3px;
	padding-bottom:7px;
}

#chrono {
	float:right;
}

#progressbar {
	width:50%;
	margin:auto;
	border:1px solid black;
	padding: 1px;
	height; 15px;
	margin-top:5px;
}

#progress {
	background-color:red;
	width:25%;
}

.carte {
	margin-left:<?php echo $config['image_taille_margin']; ?>px;
	margin-top:3px;
	background-color:#8E8E8E;
	width:<?php echo $config['image_largeur_px']; ?>px;
	height:<?php echo $config['image_hauteur_px']; ?>px;
	display:inline-block;
}



<?php for($i = 0; $i < $config['nb_paires'] ; $i++): ?>
	.carte-<?php echo $i; ?> {
		background-image:url("/img/cards.png");
		background-position:0 -<?php echo ($config['image_hauteur_px'] * $i); ?>px;
	}
<?php endfor; ?>