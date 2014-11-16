<!-- Bouton RSS -->
<div class="subscribeBox">
	<a href="<?php bloginfo('rss2_url'); ?>">S'abonner au flux RSS</a>
</div>
<!-- Formulaire de recherche -->
<p class="archives_titles">Rechercher</p>
<?php get_search_form(); ?>
<!-- Archives -->
<p class="archives_titles">Les archives</p>
<ul class="list">
	<?php wp_get_archives('type=monthly'); ?>
</ul>