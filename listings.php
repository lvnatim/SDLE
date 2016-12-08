<div class="container tile-container">
  <div class="row">
    <div class="spacer col-xs-1"></div>
    <div class="col-xs-10">
      <div class="row">
      <?php 
      if($_REQUEST['page_num']){
        $page_num = $_REQUEST['page_num'];
      } else {
        $page_num = 0;
      }
      $offset = $page_num * 48;
      $posts = get_posts(array(
        'offset'  => $offset,
        'post_type' => 'product',
        'posts_per_page' => 48,));
      ?>
      <?php foreach($posts as $post): ?>
      <?php
        $integration = new WC_Cart_Stock_Reducer();
        $stock_available = $integration->get_stock_available($post->ID);
        $stock = intval(get_post_meta( $post->ID, '_stock', true));
        $status = NULL;
        if($stock && $stock_available){
          $status = "available";
        } elseif ($stock && !$stock_available){
          $status = "hold";
        } else {
          $status = "sold";
        }
      ?>
        <div class="col-xs-6 col-sm-3 col-md-2 tile">
          <?php if($status === "hold") echo "<div class='hold-overlay'>On Hold</div>" ?>
          <img class="overlay-image product-image" src="<?php echo get_the_post_thumbnail_url($post); ?>"/>
          <img class="underlay-image product-image" src="<?php echo get_field('secondary_image', $post); ?>">
          <h4 class="title"><?php echo $post->post_title ?></h4>
          <?php if( of_get_option("store_open") !== "1" ): ?>
          <?php elseif($status === "available"): ?>
            <a class="btn btn-available" href="<?php echo site_url() . "?page_num=" . $page_num . "&add-to-cart=" .$post->ID ?>">Buy</a>
          <?php elseif($status === "hold"): ?> 
            <a class="btn btn-available hold">Buy</a>
          <?php else: ?> 
            <a class="btn btn-unavailable" href="">Sold</a>
          <?php endif ?>
        </div>
      <?php endforeach ?>
      <?php wp_reset_postdata(); ?>
      </div>
    </div>
  </div>
</div>