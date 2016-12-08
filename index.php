<!DOCTYPE html>
<html>
<head>
  <title></title>
  <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400" rel="stylesheet">
  <script src="https://use.fontawesome.com/d54a710e5a.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
  <?php wp_head(); ?>
</head>
<body>
  <?php include 'landing.php'; ?>
  <div class="side-menu-navbutton previous"><span class="mini-title">Previous</span></div>
  <div class="side-menu-navbutton next"><span class="mini-title">Next</span></div>
  <div id="listings"><?php include 'listings.php'; ?></div>
  <?php include 'pagination.php'; ?>
  <?php include 'authenticity.php'; ?>
  <?php get_footer(); ?>
  <?php
    $cart = new WC_Cart();
    $cart->init();
    $cart_items = $cart->get_cart();
  ?>
  <?php if(count($cart_items)): ?>
  <div class="container-fluid cart-container">
    <div class="row cart-container-row">
      <div class="col-xs-8 cart-column">
        <div class="row cart-row">
          <?php foreach(array_keys($cart_items) as $item_key): ?>
          <div class="cart-item">
            <img class="cart-image" src="<?php echo get_the_post_thumbnail_url($cart_items[$item_key]['product_id']); ?>"/>
            <div class="cart-text">
              <h4 class="cart-time"><?php echo $cart_items[$item_key]['csr_expire_time']; ?></h4>
              <a class="btn cart-remove" href="<?php echo $cart->get_remove_url($item_key); ?>">Remove</a>
            </div>
          </div>
          <?php endforeach ?>
        </div>
      </div>
      <div class="col-xs-4 cart-button">
        <a class="btn">Go to Cart</a>
      </div>
    </div>
  </div>
  <?php else: ?>
    <div class="container-fluid cart-container-empty"></div>
  <?php endif ?>
</body>
</html>