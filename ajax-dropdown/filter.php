<div id="ajax-filter" class="post custom__filter">
<?php
     $taxonomy = 'categoria-soluciones';
     function get_child_categories( $parent_category_id,$taxonomy){
      $html = '';
      $child_categories = get_categories( array( 'parent' => $parent_category_id, 'hide_empty' => false, 'taxonomy' => $taxonomy) );
      
      if( !empty( $child_categories ) && !is_wp_error( $child_categories )){
          $html .= '<ul class="listcategorias">';
          
          foreach ( $child_categories as $child_category ) {
            $children = get_term_children( $child_category->term_id, $taxonomy);
            if(count($children) != 0){
                $html .= '<li class="child"><a type="button"  data-category="'.$child_category->term_id.'" data-posttype="'.$child_category->taxonomy.'" class="listsegres__a--child js-filter-item" data-taxonomy="'.$child_category->taxonomy.'" href="' .$child_category->term_id. '">' . $child_category->name . '</a>';
                $html .= get_child_categories( $child_category->term_id, $taxonomy);
                $html .= '</li>';
            }else{
                $html .= '<li class="child-single"><a type="button"  data-category="'.$child_category->term_id.'" data-posttype="'.$child_category->taxonomy.'" class="listsegres__a--singlechild js-filter-item" data-taxonomy="'.$child_category->taxonomy.'" href="' .$child_category->term_id. '">' . $child_category->name . '</a>';
                $html .= '</li>';
            }
                
              
          }
          $html .= '</ul>';
      }
      return $html;
  }
  function list_categories($taxonomy){
    $html = '';
    $parent_categories = get_categories( array( 'parent' => 0, 'hide_empty' => false, 'taxonomy' => $taxonomy ) );
    $html.= '<ul class="listsegres">';
    $html.= '<li class="listsegres__item"><a type="button" class="js-filter-item" href="'.home_url().'">Todas</a></li>';
    foreach ( $parent_categories as $parent_category ) {
        $html .= '<li class="parent"><a type="button"  data-category="'.$parent_category->term_id.'" data-posttype="'.$parent_category->taxonomy.'" class="listsegres__a--parent js-filter-item" data-taxonomy="'.$parent_category->taxonomy.'" href="' .$parent_category->term_id. '">' . $parent_category->name . '</a>';
        $html .= get_child_categories( $parent_category->term_id,$taxonomy);
        $html .= '</li>';
    }
    $html.= '</ul>';
    return $html;
}
  
     echo list_categories($taxonomy);
    ?>
</div>

<div id="response">
<ul class="post custom__items"> 
<?php
// THIS LOOP WILL SHOW ALL POSTS BY DEFAULT
$args = array(
    'post_type' => 'solucion',
    'posts_per_page' => -1
);
   
$the_query = new WP_Query( $args ); ?>
     
    <?php if ( $the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
    <li class="post item__post">
        <a href="<?php esc_url(the_permalink()); ?>"><?php the_post_thumbnail('thumbnail'); ?></a>
        <a href="<?php esc_url(the_permalink()); ?>"><h3 class="post__tittle"><?php the_title(); ?></h3></a>
    <?php endwhile; endif; ?></li>
   
<?php wp_reset_postdata(); ?>
</ul>
</div>