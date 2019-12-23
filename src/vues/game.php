<div id="conteneur">
	<div id="titre">Jeu de mémoire<span id="chrono"></span></div>
	<div id="grille">
		<?php foreach($game->getCards() as $card): ?>
			<span class="carte" cardid="<?php echo $card->getNumber(); ?>" notfound></span>
		<?php endforeach; ?>
	</div>
	<div id="progressbar"><div id="progress">&nbsp;</div></div>
	<div>
		<a href="/game">Recommencer</a>
	</div>
</div>

<script src="/js/memory.js"></script>
<script>
	memoireStartMillisecond = Date.now();
	timerTimeout = null;
	var maxTime = <?php echo $config['temps_max']; ?>;
	var gameId = '<?php echo $game->getGameId(); ?>';
	
	updateTimer();
</script>