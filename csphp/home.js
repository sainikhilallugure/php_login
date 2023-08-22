
$(document).ready(function(){

    var userId = localStorage.getItem('token');
    if(!userId){
        window.location.replace("login.html");
    }
    var token = localStorage.getItem("token");
    $.post("api/getuser.php", {token:token},function(result){
        var result = JSON.parse(result);
        if(!result.status){
            alert(result.message);
        }else{
            $("#welcomeMsg").text(result.message);
        }
    });
});