  <!--<footer class="mt-5 bg-light">
<div class="container">-->
	<?php /*if(is_active_sidebar('footer-widget-area')): ?>
    <div class="row border-bottom pt-5 pb-4" id="footer" role="navigation">
      <?php dynamic_sidebar('footer-widget-area'); ?>
    </div>
    <?php endif;*/ ?>

   <!-- <div class="row pt-3">
      <div class="col">
        <p class="text-center">&copy; <?php //echo date('Y'); ?> <a href="<?php //echo home_url('/'); ?>"><?php //bloginfo('name'); ?></a></p>
      </div>
    </div>
  </div>
</footer>-->
<!-- Modal -->
<?php 
$booking_form='[ninja_form id=21]';
?>
<div class="modal fade" id="myBook">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">
          <img src="<?php echo MAIN_DIR; ?>/images/close-red.png" />
        </button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <div class="pop-image col-md-12 col-12"> 
          <img id="modal-desktop-img" src="<?php echo MAIN_DIR; ?>/images/dummy-pop-dk.jpg" class="dk-image" />
          <img id="modal-mobile-img" src="<?php echo MAIN_DIR; ?>/images/dummy-pop-mb.jpg" class="mb-image" />
          <div class="pop-text">
            <h5 id="modal-journey-title">Magic in mountains</h5>
            <div class="location">
              <span class="map" id="modal-journey-city">Binsar</span>
            </div>
          </div>
        </div>
       <?php echo do_shortcode($booking_form); ?>
      </div>

    </div>
  </div>
</div>

<?php wp_footer(); ?>
</body>
</html>
