<?php

/**
 * Extensions for PressBooks / Reading time
 *
 * This file show in the theme the aprox reading time of a page.
 *
 * @link              URL
 * @since             1.2.8
 * @package           extensions-for-pressbooks
 *
 **/

  //estimated reading time
  function reading_time() {
  $content = get_post_field( 'post_content', $post->ID );
  $word_count = str_word_count( strip_tags( $content ) );
  $readingtime = ceil($word_count / 250);

  if ($readingtime == 1) {
  $timer = " minute";
  } else {
  $timer = " minutes";
  }
  $totalreadingtime = '   -   ' . $readingtime . $timer;

  return $totalreadingtime;
  }
