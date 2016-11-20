$(document).ready(function (){
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });

    $(".menu-link").click(function (){
        var subMenu = $(this).parent().children('.sub-menu');
        subMenu.slideToggle(200);

        $(this).children('h4').children('i.menu-icon').toggleClass('fa-chevron-circle-right fa-chevron-circle-down');
    });

    $("#btnLogout").click(function (){
        showConfirm("Realmente deseja sair do MatBall?",
            "Sim", function (){
                executeLogout();
            },
            "Não", function (){}
        );
    });
    
    $("[action='go-back']").click(function (){
        history.back();
    });
});

function executeLogout(){
    sendPostService(
        '../Receiver.php',
        'Usuarios', 'logout', {},
        function (r){
            window.location = r.object.link;
        },
        function (){}
    );
}