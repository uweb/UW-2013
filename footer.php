<?php wp_footer(); ?> 


<div id="footerBG">
    <div id="footer" role="navigation" aria-label="Global Footer Menu">
    	<?php uw_footer_menu(); ?>
    </div>
</div>


<div id="footer-main" role="contentinfo">
  <div id="footer-right">
  	<a href="http://www.seattle.gov/">Seattle, Washington</a>
  </div>
	  <ul>
	  	<li><a href="http://www.washington.edu/home/siteinfo/form">Contact Us</a></li>
	  	<li><a href="http://www.washington.edu/jobs">Jobs</a></li>
	  	<li><a href="http://myuw.washington.edu/">My UW</a></li>
	  	<li><a href="http://www.washington.edu/admin/rules/wac/rulesindex.html">Rules Docket</a></li>
	  	<li><a href="http://www.washington.edu/online/privacy">Privacy</a></li>
	  	<li><a href="http://www.washington.edu/online/terms">Terms</a></li>
      </ul>
  <div id="footer-left">
  	<a href="http://www.washington.edu/">&copy; <?php echo date('Y'); ?> University of Washington</a>
  </div>
</div>


<div id="uw-mobile-panel" style="display:none;">

	<div class="mobile-search">
	  <form role="search" action="http://www.washington.edu/search" name="form1">
	      <input value="008816504494047979142:bpbdkw8tbqc" name="cx" type="hidden">
	      <input value="FORID:0" name="cof" type="hidden">
	      <label for="q" class="hide">Search the UW</label>
	      <input id="q" class="wTextInput" placeholder="Search the UW" title="Search the UW" name="q" type="text" autocomplete="off">
	      <input value="Go" name="sa" class="formbutton" type="submit">
	   </form>	
	</div>

<?php wp_nav_menu(array('theme_location' => 'primary', 'container_class' => 'uw-mobile-menu', 'menu_class' => 'uw-mobile-menu', 'menu_id' => 'dawgdrops-mobile' ) ); ?>
      
<h3>Resources</h3>

<div id="mobile-thin-strip">
  <div role="navigation">
    <ul>
      <li><a href="http://www.washington.edu/">UW Home</a></li>
      <li><a href="http://www.washington.edu/home/directories.html">Directories</a></li>
      <li><a href="http://www.washington.edu/discover/visit/uw-events">Calendar</a></li>
      <li><a href="http://www.lib.washington.edu/">Libraries</a></li>
      <li><a href="http://www.washington.edu/maps">Maps</a></li>
      <li><a href="http://myuw.washington.edu/">My UW</a></li>
      <li class="visible-desktop"><a href="http://www.bothell.washington.edu/">UW Bothell</a></li>
      <li class="visible-desktop"><a href="http://www.tacoma.uw.edu/">UW Tacoma</a></li>
      <li class="visible-phone"><a href="http://www.uw.edu/news">News</a></li>
      <li class="visible-phone"><a href="http://www.gohuskies.com/">UW Athletics</a></li>
    </ul>
  </div>	
</div>

</div>

</body>
</html>
