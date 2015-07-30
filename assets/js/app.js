/**
 * Created by sam on 7/21/15.
 */

$(document).ready(function(e){


    $("#password, #conf-password").on("keyup", function (){
        if($("#password").val() == $("#conf-password").val()){
            $(".pass-confirm").css("background", 'lightgreen');
            $(".pass-confirm").html("Passwords Match");
        } else {
            $(".pass-confirm").css("background", 'red');
            $(".pass-confirm").html("Passwords Don't Match");
        }
    });


});

$(".markdown-preview").keyup(function(e){

    var text = $(this).val();

    var converter = new Showdown.converter();
    var html = converter.makeHtml(text);

    //alert(html);

    $($(this).attr("data-target")).html(html);
});

$(".froala-editor").editable({
    inlineMode: false,
    imageUpload: false,
    height: 300
});

$(".toggle_hidden").click(function(){
    $($(this).attr("data-toggle")).toggleClass('hidden');
});

$(".hc-tree li a.title").click(function(e){
    e.preventDefault();
    $(this).parent().toggleClass("active");
});
$(".expand-tree").click(function(e){
    e.preventDefault();

    $($(this).attr("href") + " li").removeClass("active").addClass("active");
});
$(".compress-tree").click(function(e){
    e.preventDefault();

    $($(this).attr("href") + " li").removeClass("active");
});


$("#remote").modal({ remote : true });