<?php $view->extend('JamesVocabBundle::layout.html.php') ?>
<?php $view['slots']->start('body') ?>

<div class="hero-unit">
  	
</div>

<script>
$.get("<?=$view['router']->generate('_nbastats_ajax')?>" + '/' + "Howard" + '/' + "Dwight", function(data){
	console.log(data);
}, "json");
</script>

<?php $view['slots']->stop() ?>

  

  