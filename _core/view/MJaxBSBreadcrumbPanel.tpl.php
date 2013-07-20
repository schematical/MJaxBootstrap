<ul class="breadcrumb">
    <?php foreach($_CONTROL->arrCrumbs as $intIndex => $mixCrumb){ ?>
        <li>
            <?php if(is_string($mixCrumb)){
                echo $mixCrumb;
            }elseif($mixCrumb instanceof MJaxControl){
                $mixCrumb->Render();
            } ?>
            <?php //echo count($_CONTROL->arrCrumbs) . '>' . $intIndex;
            if(count($_CONTROL->arrCrumbs) -1 > $intIndex){ ?>
                <span class="divider">
                    <i class="icon-chevron-right"></i>
                </span>
            <?php } ?>
        </li>
    <?php } ?>

    <!--li>
        <a href="#">Library</a>
        <span class="divider">/</span>
    </li>
    <li class="active">
        Data
    </li-->
</ul>