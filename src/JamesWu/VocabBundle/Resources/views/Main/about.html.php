<?php $view->extend('JamesWuVocabBundle::layout.html.php') ?>
<?php $view['slots']->start('body') ?>

	<h3> About This App</h3>	 
	<p> I made this quick app to help me study for the GRE exams. It automatically adjusts the probability of showing a word by how well I know it.</p>
	<p> The source code is available on <a href ="https://github.com/SavvyGuard/vocabularycards/">github</a> </p> 
	<p> It uses Symfony2, php, mysql, jQuery, and the Twitter Bootsrap </p>  

<?php $view['slots']->stop() ?>
