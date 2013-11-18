    <div id="search">

      <form role="search" class="main-search" action="http://www.washington.edu/search" id="searchbox_008816504494047979142:bpbdkw8tbqc" name="form1">
          <input value="008816504494047979142:bpbdkw8tbqc" name="cx" type="hidden">
          <input value="FORID:0" name="cof" type="hidden">
          <label for="q" class="hide">Search the UW</label>
          <input id="q" class="wTextInput" placeholder="Search the UW" title="Search the UW" name="q" type="text" autocomplete="off">
          <input value="Go" name="sa" class="formbutton" type="submit">
      </form>	

      <!--span class="search-toggle search-toggle"></span-->

      <div class="search-options">
        <label class="radio">
          <input type="radio" name="search-toggle" value="main" checked="checked" data-placeholder="the UW">
          UW.edu
        </label>
        <label class="radio">
          <input type="radio" name="search-toggle" value="directory" data-placeholder="the Directory"/>
          UW Directory
        </label>
              <label class="radio">
          <input type="radio" name="search-toggle" value="site" data-site="<?php echo home_url('/') ?>" data-placeholder="<?php bloginfo(); ?>"/>
          This site
        </label>
        
        <span class="search-options-notch"></span>
      </div>

	</div><!-- #search -->
