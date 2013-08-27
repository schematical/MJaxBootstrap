    <div style='margin-left:18Px;' class="controls input-append date form_datetime" data-date="1979-09-16T05:25:07Z" data-date-format="<?php echo $_CONTROL->strFormat; ?>" data-link-field="<?php echo $_CONTROL->txtDate->ControlId; ?>" <?php if(!is_null($_CONTROL->strLinkFormat)){ echo 'data-link-format="' . $_CONTROL->strLinkFormat .'"'; } ?>>
        <input size="16" type="text" value="<?php echo $_CONTROL->txtDate->Text; ?>" readonly='readonly'></input>

        <span class="add-on"><i class="icon-remove"></i></span>
        <span class="add-on"><i class="icon-th"></i></span>
    </div>
    <?php $_CONTROL->txtDate->Render(); ?>
