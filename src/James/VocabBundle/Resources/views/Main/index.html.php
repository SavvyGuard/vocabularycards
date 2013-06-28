<?php $view->extend('JamesVocabBundle::layout.html.php') ?>
<?php $view['slots']->start('body') ?>

<div class="hero-unit">
  	<h3 class="btn-link" id="word_text" word_id="0"></h3>
  	
  	<div id="definition" rel="tooltip" data-placement="left" data-title="Click to Reveal" class="well" style="cursor:pointer"> 
  		<div id="definition_container"></div>
  	</div>

	<button status="1" class="btn btn-warning">Don't Know</button>
	<button status="-1" class="btn btn-success">Know</button>
</div>

<script>
$("#word_text, #definition").click(function() {
	var current_word = $('#word_text').text();
	$.get("<?=$view['router']->generate('def_word_main')?>" + '/' + current_word, function(data){
		console.log(data);
		var word_class = data[0].class;
		var definition_objects = data[0].definitions;
		var definitions = '';
		for (defin in definition_objects) {
			var definition = '';
			var synonyms = '';
			var summary = definition_objects[defin].summary;
			if (summary.length > 0) {
				summary = summary + '; ';
			} 
			for (syn in definition_objects[defin].synonyms) {
				if (syn > 0) {
					synonyms = synonyms + ', ';
				}
				synonyms = synonyms + definition_objects[defin].synonyms[syn];
			}

			var use = definition_objects[defin].use;

			if (use.length > 0) {
				use = ' - ' + use;
			}
			
			definition = summary + synonyms + '<i>' + use + '</i>';
			console.log(definition);
			var number = +defin + 1;
			definitions = definitions + '<p><small>' + number + '. ' + definition + '</small></p>';
		}
		
		
		$('#definition_container').html('<h5 id="word_class">'+word_class+'</h5>'+ definitions);
		$('#word_class').text(word_class);
		$('#definition_container').css("visibility", "visible");
		
	}, "json");
	});
$(".btn").click(function() {
	$.post("<?=$view['router']->generate('word_status_main')?>", { word_id: $('#word_text').attr('word_id'), status: $(this).attr('status') });
	$.get("<?=$view['router']->generate('random_word_main')?>", function(data){
		console.log(data);
		$('#word_text').text(data.word_text);
		$('#word_text').attr('word_id',data.word_id);
		$('#definition_container').css("visibility", "hidden");
	}, "json");
	});
$.get("<?=$view['router']->generate('random_word_main')?>", function(data){
	console.log(data);
	$('#word_text').text(data.word_text);
	$('#word_text').attr('word_id',data.word_id);
}, "json");
</script>

<?php $view['slots']->stop() ?>

  
