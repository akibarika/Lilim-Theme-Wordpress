<form role="search" method="get" class="search-form" action="<?php echo home_url('/'); ?>">
    <div class="header__item ico-search">
        <svg class="icon icon-magnifying-glass">
            <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#magnifying-glass"></use>
        </svg>
    </div>
    <input type="text" id="search-text" placeholder="SEARCH FOR ..." class="search-input js-search-input" name="s"
           value="<?php echo get_search_query() ?>">
</form>