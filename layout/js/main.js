

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

//ubber-bar search

$(".ubber-bar .search .serch_show").on("click", function(){

    $(".ubber-bar .search .search_cont").fadeToggle()

})
$(".ubber-bar .search .serch_close").on("click", function(){

    $(this).parent().fadeOut()

})

//login  and signup toggle

$(".login-sign-up-page  .toggle-to-login").click(function(){
    $(".login-sign-up-page").removeClass("sign-up");
})

$(".login-sign-up-page  .toggle-to-sign-up").click(function(){
    $(".login-sign-up-page").addClass("sign-up");
})
//check sign-up form the password fielda equal to each other


function checkpasswords($form_id , $pass_1_id , $pass_2_id){

   
    $("#"+$form_id).on("submit", function(event){

        let pass_1=$("#"+$pass_1_id),
            pass_2=$("#"+$pass_2_id);
            
         if((pass_1.val() != pass_2.val() )){
             event.preventDefault();
             $(this).find(".error_messege").text("the password fields not equal")
         }
         else if(pass_1.val().length < 5){
             event.preventDefault();
             $(this).find(".error_messege").text("password can not be less than 5 characters");
         }
     
     })

}
checkpasswords("edit_password" , "new_password_1" ,"new_password_2");
$("#sign-up-form").on("submit", function(event){

   let pass_1=$("#pass-1"),
       pass_2=$("#pass-2"),
       username =$("#username");
       
    if(username.val().length < 4){
        event.preventDefault();
        $(this).find(".error_messege").text("username can not be less than 4 characters");
    }
    else if((pass_1.val() != pass_2.val() )){
        event.preventDefault();
        $(this).find(".error_messege").text("the password fields not equal")
    }
    else if(pass_1.val().length < 5){
        event.preventDefault();
        $(this).find(".error_messege").text("password can not be less than 5 characters");
    }

  

  
})
//handle delete 
let target ='';

function handleDelete(selector){
    $("."+selector).on("click",function(event){
        event.preventDefault();
        target = $(this).attr("href");
    
        $("body").append(`<div id="delet-alert"> 
        <div class="cont">
        <p>Are you sure you want to delete this member</p>
            <button class="yes btn btn-danger">yes</button>
            <button class="no btn btn-primary">no</button>
        </div>
        </div>`);
    
    })

}
$("body").on("click"," #delet-alert button",function(){
    if($(this).hasClass("yes")){
      window.location.href= window.location.protocol+"//"+window.location.hostname+"/eCommerce/"+target;
    }
    $(this).parent().parent().remove();
    
})

handleDelete("delete_item_from_cart");
handleDelete("delete_item_from_ads");

})