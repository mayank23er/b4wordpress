<!DOCTYPE html>
<html class="no-js" <?php language_attributes(); ?>>
<head>
  <meta name="description" content="<?php if ( is_single() ) {
      single_post_title('', true);
    } else {
      bloginfo('name'); echo " - "; bloginfo('description');
    }
  ?>" />
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <?php wp_head(); ?>
  <!--[if lt IE 9]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js">
</script>
<![endif]-->
      
      <!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js">
</script>
<script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js">
</script>
<![endif]-->
    
  <!--[if IE]>
	<link rel="stylesheet" type="text/css" href="css/ie.css" />
<![endif]--> 
</head>

<body <?php body_class(); ?>>
<?php 
if ( is_404() ) {
    // add search form so that users can search other posts
	$erroClass = "inner-header";
}
?>

  <header class="<?php echo @$erroClass;?>">
<nav class="navbar navbar-expand-lg navbar-light fixed-top bg-light">
<div class="progress progressBarLoad" style="height: 3px; z-index: 99999; padding-bottom: 0px; margin-bottom: 0px; top: 0px; left: 0px; right: 0px; position: absolute; display: none;">
				<div style="width:100%;" aria-valuemax="100" aria-valuemin="0" aria-valuenow="100" role="progressbar" class="progress-bar progress-bar-success progress-bar-striped active"></div>
			 </div>
  <div class="container">

  <a class="navbar-brand logo-white col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4 padLR" href="<?php echo esc_url( home_url('/') ); ?>"><img src="<?php echo MAIN_DIR; ?>/images/white-logo.svg" class=""></a>
  <a class="navbar-brand logo-black col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4 padLR" href="<?php echo esc_url( home_url('/') ); ?>"><img src="<?php echo MAIN_DIR; ?>/images/logo-black.svg" class=""></a>
	
	<div class="pull-right search_mag_outer col-7 col-sm-7 col-md-7 col-lg-7 col-xl-7">
                        <div class="suggesIconWrap paddingLeft0">
                            <span class="suggesIcon"></span>
                        </div>	
			</div>

   <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"><i class="humburger"></i>
<i class="humburger"></i>
<i class="humburger"></i>
</span>
  </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <?php
	  
        wp_nav_menu( array(
          'theme_location'  => 'navbar',
          'container'       => false,
          'menu_class'      => '',
          'fallback_cb'     => '__return_false',
          'items_wrap'      => '<ul id="%1$s" class="navbar-nav ml-auto %2$s">%3$s</ul>',
          'depth'           => 2,
          'walker'          => new b4st_walker_nav_menu()
        ) );
      ?>
	<div class="header-footer">
				<div class="container">
					<div class="row">
						<div class="col-12 col-sm-12 col-md-12 hf-logo">
							<a href="#"><img src="<?php echo MAIN_DIR; ?>/images/rg-logo-footer.svg"></a>
						</div>
					</div>
					<div class="row hf-social-links">
						<div class="col-12 col-sm-12 col-md-12">
							<a href="https://www.facebook.com/roundglass1" target="_blank"><img src="<?php echo MAIN_DIR; ?>/images/icon-fb-button.svg"></a>
							<a href="https://www.linkedin.com/company/roundglass/" target="_blank"><img src="<?php echo MAIN_DIR; ?>/images/icon-linkedin.svg"></a>
							<a href="https://twitter.com/round_glass" target="_blank"><img src="<?php echo MAIN_DIR; ?>/images/icon-twitter-logo.svg"></a>
							<a href="#" class="hub-popup"><img src="<?php echo MAIN_DIR; ?>/images/icon-email-us.svg"></a>
						</div>
					</div>
					<div class="row">
						<div class="col-12 col-sm-12 col-md-12">
							<a style="color:#2d2d2d; font-size:12px;" href="https://round.glass" class="rg-copyright image_captions" target="_blank">© RoundGlass 2018</a>
						</div>
					</div>
					</div>
				</div>

				</div>
			</div>
      
    </div>

  </div>
</nav>
 <div class="searchPop hideSearch">
			<div class="searbg">
				<div class="container searchWrap">
					<div class="col-md-12 searchSuggestive searchcom paddingLeftRight0">
						<form class="form-group" autocomplete="off" id="suggestiveForm">
							<input type="search" name="search" id="suggestiveSearchInputResponsive" class="searchSuggestiveT search_heading" placeholder="Search">
							<input type="" id="headerSubmit" name="" value="">
							<div class="row autoCompleteSrpSuggestion"></div>
						</form>           
					</div>
				</div>
			</div>
			<div class="searInner"></div>
		</div>
 </header>
      