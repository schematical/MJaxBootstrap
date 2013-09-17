
    <?php $_CONTROL->lnkPrimary->Render(); ?>
    <ul class="dropdown-menu">
        <?php foreach($_CONTROL->arrOptions as $intIndex => $ctlItem){ ?>
            <li>
                <?php $ctlItem->Render(); ?>
            </li>
        <?php } ?>
    </ul>
