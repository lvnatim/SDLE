<div class="container pagination-container">
  <div class="row">
    <div class="col-xs-1"></div>
    <div class="col-xs-10">
      <ul class="pagination">
      <?php $max_pages = range(1, ceil(wp_count_posts('product')->publish / 48 ));?>
      <?php foreach($max_pages as $page): ?>
        <li class="pagelist" data-page="<?php echo $page - 1?>"><?php echo $page; ?></li>
      <?php endforeach ?>
      </ul>
    </div>
    <div class="col-xs-1"></div>
  </div>
</div>