import { Notify } from './../../../../style/layout/notify.ts';

$(document).ready(function(){
    /**
     *  Copy to clipboard link
     */
    $(".copy-analysis-uri").click(function (){
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val($(this).attr('uri')).select();
        document.execCommand("copy");
        $temp.remove();

        Notify.Me(["Link uspješno kopiran!", "success"]);
    });
});
