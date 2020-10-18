<?php

/**
 * Extensions for PressBooks / clipboarddata
 *
 * Add a #copyright notice to the clipboard when someone copies a text from the website.
 * 		if ( $key_pb_subtitle !=  'Revision' )
 *    const pagelink = `\n\nSource: © ${document.location.href}`;
 *
 *  @link https://stackoverflow.com/questions/2026335/how-to-add-extra-info-to-copied-web-text
 *	@link https://developer.mozilla.org/en-US/docs/Web/API/Element/copy_event
 *	@link https://www.wpbeginner.com/wp-tutorials/how-to-add-a-read-more-link-to-copied-text-in-wordpress/
 * @since             1.X
 * @package           extensions-for-pressbooks
 *
 **/



function efpb_clipboarddata() {

  if ( !wp_is_mobile() && !is_user_logged_in() && is_singular('chapter') ) { ?>
  	<script type="text/javascript">

  	document.addEventListener('copy', (event) => {
  	  const pagelink = `\n\nSource: <?php the_title(); ?> © <?php echo wp_get_shortlink(get_the_ID()); ?>`; //Original: `\n\nSource: ${document.location.href}`
  	  event.clipboardData.setData('text', document.getSelection() + pagelink);
  	  event.preventDefault();
  	});

  	</script>
  <?php
  }

}
add_action( 'wp_footer', 'efpb_clipboarddata', 100 );
?>
