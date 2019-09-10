<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package DigitalZen
 */

?>

    </div><!-- #content -->

<!--footer-->

    <footer id="colophon" class="site-footer">
      <div class="site-info">
        <a href="<?php echo esc_url( __( 'https://wordpress.org/', 'digitalzen' ) ); ?>">
<?php
/* translators: %s: CMS name, i.e. WordPress. */
printf( esc_html__('Proudly powered by %s', 'DigitalZen' ), 'WordPress');
?>
        </a>
        <span class="sep"> | </span>
<?php
/* translators: 1: Theme name, 2: Theme author. */
printf( esc_html__( 'Theme: %1$s by %2$s.', 'digitalzen' ), 'digitalzen', '<a href="http://www.digitalzenworks.com">James John McGuire</a>' );
?>
      </div><!-- .site-info -->
    </footer><!-- #colophon -->
  </div><!-- #page -->

  <script src="js/vendor/modernizr-3.7.1.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
  <script>window.jQuery || document.write('<script src="js/vendor/jquery-3.4.1.min.js"><\/script>')</script>
  <script src="js/plugins.js"></script>
  <script src="js/main.js"></script>

  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

<?php wp_footer(); ?>
</body>
</html>
