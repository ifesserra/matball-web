<?php
require_once "application/controller/RestrictedSession.class.php";
    
if(RestrictedSession::isLogged()){
    header("Location: http://" . $_SERVER['HTTP_HOST'] . "/matball-web/application/view/home-usuario.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>MatBall</title>
    
    <meta charset="utf-8">
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="author" content="matball">
    
    <link rel="icon" href="assets/img/favicon.png">
    
    <link href="assets/external/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="assets/external/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
    
    <script src="assets/external/jquery/jquery.min.js" type="text/javascript"></script>
    <script src="assets/external/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    
    <link href="assets/external/remodal/remodal.css" rel="stylesheet" type="text/css"/>
    <link href="assets/external/remodal/remodal-default-theme.css" rel="stylesheet" type="text/css"/>
    <script src="assets/external/remodal/remodal.min.js" type="text/javascript"></script>
    
    <script src="assets/js/my-functions.js" type="text/javascript"></script>
    
    <link href="assets/css/styles.css" rel="stylesheet" type="text/css"/>
    <link href="assets/css/index.css" rel="stylesheet" type="text/css"/>
    
</head>

    <body>
        <!-- MODAL MESSAGE -->
        <div id="modalMessage" data-remodal-id="modalMessage">
            
            <button data-remodal-action="close" class="remodal-close"></button>
            <br>
            <div class="div-full aln-center message"></div>
            <br>
            <div class="div-full aln-right">
                <button data-remodal-action="confirm" class="btn btn-primary">Fechar</button>
            </div>
        </div>
        
        <img id="bg" src="assets/img/bg_index.jpg" alt=""/>
        
        <div class="shape-back shape-back-sizes shape-position">
        </div>

        <div id="divAction" class="shape shape-back-sizes shape-position">
            <img id="imgLogotipo">
            
            <div id="divBtns">
                
                <a id="btnEntrar" class="btn btn-default">
                    <label>Entrar</label>
                </a>
                
                <a id="btnCadastrar" class="btn btn-default">
                    <label>Cadastrar</label>
                </a>
            </div>
        </div>
        
        <div id="divLogin" class="shape shape-back-sizes shape-position aln-left" style="display: none;">
            
            <form id="loginform" class="form-horizontal" role="form">
                
                <div class="input-group input-login">
                    <span class="input-group-addon">
                        <i class="glyphicon glyphicon-user"></i>
                    </span>
                    
                    <input cmp-post="string" id="user" type="text" class="form-control" value="" required
                           placeholder="Login">
                </div>
                
                <div class="input-group input-login">
                    <span class="input-group-addon">
                        <i class="glyphicon glyphicon-lock"></i>
                    </span>
                    
                    <input cmp-post="string" id="password" type="password" class="form-control" required
                           placeholder="Senha">
                </div>
                
                <div style="margin-top:10px" class="aln-center">
                    <div class="controls">
                        <a id="btnCancel" href="#" class="btn btn-default">
                            Cancelar
                        </a>
                        
                        <a type="submit" id="btnConfirm" href="#" class="btn btn-primary">
                            <i class="fa fa-sign-in"></i>&nbsp;
                            Entrar
                        </a>

                    </div>
                </div>
            </form>
        </div>
            
        <script>
            
            $(window).ready(function(){
                var wScreen = $(window).width();
                var hScreen = $(window).height();
                
                if(wScreen > hScreen){
                    $('#bg').css('width', wScreen);
                    $('#bg').css('height', 'auto');
                }
                else{
                    $('#bg').css('height', hScreen);
                    $('#bg').css('width', 'auto');
                }
                
                $('#btnConfirm').css('width', '100');
                $('#btnCancel').css('width', '100');
                
                $('#btnEntrar').click(function (){
                    showDivLogin();
                    return false;
                });
                
                $('#btnCadastrar').click(function (){
                    window.location = "application/view/add-usuario.php";
                    return false;
                });
                
                $('#btnCancel').click(function (){
                    fadeOutIn("#divLogin", 300, "#divAction", 300);
                    return false;
                });
                
                $('#btnConfirm').click(function (){
                    confirmLogin();
                    return false;
                });
            });
            
            function showDivLogin(){
                fadeOutIn("#divAction", 300, "#divLogin", 300);
            }
            
            function confirmLogin(){
                var object = serializeForm('cmp-post');
                
                if(object.user === "" || object.password === ""){
                    showMessage("Informe seus dados para entrar no Sistema Acadêmico.", 'danger');
                }
                else{
                    sendPostService(
                        'application/Receiver.php',
                        'Usuarios', 'login', object,
                        function (r){
                            window.location = r.object.link;
                        },
                        function (){}
                    );
                }
            }
        </script>

    </body>

</html>