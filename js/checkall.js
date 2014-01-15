$(document).ready(function() {
    $('.chkall').click(function(){
        $('.chkboxes').attr('checked',$(this).attr('checked'));
    })
    $('.chkboxes').click(function(){
        if($('.chkboxes').length == $('.chkboxes:checked').length)
              $('.chkall').attr('checked',true)
        else
             $('.chkall').attr('checked',false)
    })
});