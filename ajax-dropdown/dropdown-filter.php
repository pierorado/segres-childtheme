<form action="<?php echo site_url() ?>/wp-admin/admin-ajax.php" method="POST" id="filter">
	<?php
		if( $terms = get_terms( array( 'taxonomy' => 'categoria-soluciones', 'orderby' => 'name' ) ) ) : 
 
			echo '<select name="categoryfilter"><option value="">Select category...</option>';
			foreach ( $terms as $term ) :
				echo '<option value="' . $term->term_id . '">' . $term->name . '</option>'; // ID of the category as the value of an option
			endforeach;
			echo '</select>';
		endif;
	?>
	<button>Buscar</button>
	<input type="hidden" name="action" value="myfilter">
</form>
<div id="response">

<?php
// THIS LOOP WILL SHOW ALL POSTS solucion
$args = array(
    'post_type' => 'solucion', // Define the post type
    'posts_per_page' => -1 // Display all posts
);
   
$the_query = new WP_Query( $args ); ?>
   
    <?php if ( $the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
   
          <h2><a href="<?php esc_url(the_permalink()); ?>"><?php the_title(); ?></a></h2>
          <span><?php the_terms(get_the_ID(), 'categoria-soluciones', 'Categorías: ', ' / ') ?></span>
          <a href="<?php esc_url(the_permalink()); ?>">
                    <?php the_post_thumbnail('thumbnail'); ?>
                </a>
  
    <?php endwhile; endif; ?>
   
<?php wp_reset_postdata(); ?>

</div>