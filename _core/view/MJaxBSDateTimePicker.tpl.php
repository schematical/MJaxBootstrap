<div class="control-group">
    <label class="control-label">DateTime Picking</label>
    <div class="controls input-append date form_datetime" data-date="1979-09-16T05:25:07Z" data-date-format="dd MM yyyy - HH:ii p" data-link-field="dtp_input1">
        <input size="16" type="text" value="" readonly>
        <span class="add-on"><i class="icon-remove"></i></span>
        <span class="add-on"><i class="icon-th"></i></span>
    </div>
    <input type="hidden" id="dtp_input1" value="" /><br/>
</div>
<script type="text/javascript">
    $('.form_datetime').datetimepicker({
        //language:  'fr',
        weekStart: 1,
        todayBtn:  1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        forceParse: 0,
        showMeridian: 1
    });
    /*$('.form_date').datetimepicker({
     language:  'fr',
     weekStart: 1,
     todayBtn:  1,
     autoclose: 1,
     todayHighlight: 1,
     startView: 2,
     minView: 2,
     forceParse: 0
     });
     $('.form_time').datetimepicker({
     language:  'fr',
     weekStart: 1,
     todayBtn:  1,
     autoclose: 1,
     todayHighlight: 1,
     startView: 1,
     minView: 0,
     maxView: 1,
     forceParse: 0
     });*/
</script>