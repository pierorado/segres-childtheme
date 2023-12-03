<?php
// =============================================================
// AJAX CALLBACK FOR CPT TAXONOMIES
// =============================================================

add_action('wp_ajax_nopriv_filterterm', 'filter_ajax_term');
add_action('wp_ajax_filterterm', 'filter_ajax_term');

function filter_ajax_term(){

	$category = $_POST['category'];

	$args = array(
		'post_type' => $_POST['solucion'], 
		'posts_per_page' => -1, 
		'orderby'	=> 'NAME', 
		'order' => 'ASC'
	);

	if ($category !== null && isset($category) && $category !== '' && !empty($category)) {
		$args['tax_query'] = 
			array( 
				array( 
						'taxonomy' => $_POST['taxonomy'], 
						'field' => 'id', 
						'terms' => array((int)$category) 
					) 
			); 
	} else {
		$all_terms = get_terms(array('taxonomy' => 'categoria-soluciones', 'fields' => 'slugs'));
		$args['tax_query'][] = [
			'taxonomy' => 'categoria-soluciones',
			'field'    => 'slug',
			'terms'    => $all_terms
		];
	}


	$the_query = new WP_Query( $args ); ?>
	
	<div class="response">
    <ul class="post custom__items">
		<?php if ( $the_query->have_posts() ) : 
			while ( $the_query->have_posts() ) : $the_query->the_post(); 
			
			$category = get_the_category(); ?>

				<li class="post item__post">
				<a href="<?php esc_url(the_permalink()); ?>"><?php the_post_thumbnail('thumbnail'); ?></a>
        		<a href="<?php esc_url(the_permalink()); ?>"><h3 class="post__tittle"><?php the_title(); ?></h3></a>
			    </li>
	
		<?php endwhile; endif; ?>
	</ul>
	</div>
	
<?php

	die();
}