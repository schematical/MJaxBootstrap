<div class="dropdown">
    <!-- Link or button to toggle dropdown -->
    <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
        <?php foreach($_CONTROL->arrOptions as $lnkOption){
            $lnkOption->Render();
        } ?>
        <li></li>
       <!-- <li><a tabindex="-1" href="#">Action</a></li>
        <li><a tabindex="-1" href="#">Another action</a></li>
        <li><a tabindex="-1" href="#">Something else here</a></li>
        <li class="divider"></li>
        <li><a tabindex="-1" href="#">Separated link</a></li>-->
    </ul>
</div>