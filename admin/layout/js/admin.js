

$(function(){
//placeholder handler
$("[placeholder]").focus(function(){

    $(this).attr("data-placeholder" ,$(this).attr("placeholder"));

    $(this).attr("placeholder","");
}).blur(function(){
    $(this).attr("placeholder" ,$(this).attr("data-placeholder"));

    $(this).attr("data-placeholder","");  
})
//placeholder handler
// add astriks after requared input fields

$("input , textarea").each(function(){
    if($(this).attr("required")){
        $(this).after("<span class='astriks'>*</span>");
    }
})

//handle delete user
let target ='';
$(".remove_member ,.remove_item").on("click",function(event){
    event.preventDefault();
    target = $(this).attr("href");

    $("body").append(`<div id="delet-member-alert"> 
    <div class="cont">
    <p>Are you sure you want to delete this member</p>
        <button class="yes btn btn-danger">yes</button>
        <button class="no btn btn-primary">no</button>
    </div>
    </div>`);

})

$("body").on("click"," #delet-member-alert button",function(){
    if($(this).hasClass("yes")){
      window.location.href= window.location.protocol+"//"+window.location.hostname+"/eCommerce/admin/"+target;
     // console.log("http://"+window.location.hostname+"/eCommerce/admin/"+target)

      
    }
    $(this).parent().parent().remove();
    
})
// dashboard last items 

$(".dashboard .latest .item .head .latest_butt_toggle").on("click",function(){

    $(this).toggleClass("hide");

    if($(this).hasClass("hide")){
        $(this).html("<i class='fas fa-plus'></i>")
        $(this).parent(".head").parent(".item").find(".body").slideUp();
    }else{
        $(this).html("<i class='fas fa-minus'></i>")
        $(this).parent(".head").parent(".item").find(".body").slideDown();
    }

})
// categories full view 
$(".category-page .head .full-view-toggle").on('click', function(){
    $(this).toggleClass("active");
    if($(this).hasClass("active")){
        $('.category-page .body .item .full_view').slideDown().addClass("show");

        localStorage.setItem("categories-full-view","yes");
    }else{
        $('.category-page .body .item .full_view').slideUp().removeClass("show");
        localStorage.setItem("categories-full-view","no");
    }
    
})


$(".category-page .body .item h3").on("click",function(){
    $(this).parent(".item").find(".full_view").slideToggle().toggleClass("show");
})

// full view localStorage

let full_view =localStorage.getItem("categories-full-view");

if(full_view != null){
    if(full_view =="yes"){
        $('.category-page .body .item .full_view').slideDown().addClass("show");
        $(".category-page .head .full-view-toggle").addClass("active");
    }
}



})