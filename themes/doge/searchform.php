<div id="blog_search_form_wrapper">
	<form id="blog_search_form" action="<?php bloginfo('siteurl'); ?>"  method="get">
		<fieldset>
			<input id="search" class="searchInput" type="search" value="<?php echo trim( get_search_query() ); ?>" name="s">
			<input class="iconSearch" type="image"  alt="Recherche" src="<?php bloginfo('template_url'); ?>/img/searchformimg.png">
		</fieldset>
	</form>
</div>