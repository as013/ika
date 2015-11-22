<?php
    defined('base_url') or die("Tidak Diijinkan Akses Langsung.");
    include 'template/nav.php';
?>
<nav class="navbar navbar-inverse">
    <div class="container no-padding">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
        </div>
        <div id="navbar" class="navbar-collapse collapse no-padding">
            <ul class="nav navbar-nav">
            <?php
                foreach ($menu as $mn){
            ?>
                <li <?php echo $page === $mn['page'] ? 'class = "active"':''?>>
                    <a href="<?php echo $mn['link']?>">
                        <i class="<?php echo $mn['icon']?>"></i>
                        <?php echo $mn['title']?>
                    </a>
                </li>
            <?php
                }
            ?>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>