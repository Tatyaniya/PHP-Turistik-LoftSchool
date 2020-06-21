
    <footer class="main-footer">
        <div class="footer-triangle"></div>
        <div class="content-footer">
          <div class="bottom-menu">
            <?php 
                wp_nav_menu( [
                    'theme_location'  => 'footer_menu',
                    'menu'            => 'footer-menu',
                    'container'       => false, 
                    'menu_class'      => 'b-menu__list',
                    'echo'            => true,
                    'fallback_cb'     => 'wp_page_menu',
                    'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                    'depth'           => 0,
                    'walker'          => '',
                ] );
            ?>
          </div>
          <div class="copyright-wrap">
            <div class="copyright-text">Туристик<a href="#" class="copyright-text__link"> loftschool <?php echo date('Y') ?></a></div>
          </div>
        </div>
      </footer>
    </div>
    <?php wp_footer(); ?>
  </body>
</html>

