<?php
$ROOT = dirname(__DIR__, 2);
require_once "$ROOT/application/controller/RestrictedSession.class.php";
    
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
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport'>
    <meta name="author" content="matball">
    
    <link rel="icon" href="../../assets/img/favicon.png">
    
    <link href="../../assets/external/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="../../assets/external/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
    
    <script src="../../assets/external/jquery/jquery.min.js" type="text/javascript"></script>
    <script src="../../assets/external/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    
    <link href="../../assets/external/remodal/remodal.css" rel="stylesheet" type="text/css"/>
    <link href="../../assets/external/remodal/remodal-default-theme.css" rel="stylesheet" type="text/css"/>
    <script src="../../assets/external/remodal/remodal.min.js" type="text/javascript"></script>
    
    <script src="../../assets/js/my-functions.js" type="text/javascript"></script>
    
    <link href="../../assets/css/styles.css" rel="stylesheet" type="text/css"/>

    <link href="../../assets/external/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" type="text/css"/>

    <link rel="stylesheet" type="text/css" 
          href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />

    <link href="../../assets/external/croppie/croppie.css" rel="stylesheet" type="text/css"/>
    <script src="../../assets/js/my-croppie.js" type="text/javascript"></script>
    
    <style>
        @media screen and (max-width: 199px) {
            #imgLogotipo{
                content: url('../../assets/img/logotipo_128.png');
            }
        }
        
        @media screen and (min-width: 200px) and (max-width: 255px) {
            #imgLogotipo{
                content: url('../../assets/img/logotipo_200.png');
            }
        }
        
        @media screen and (min-width: 256px) and (max-width: 399px) {
            #imgLogotipo{
                content: url('../../assets/img/logotipo_256.png');
            }
        }
        
        @media screen and (min-width: 400px) and (max-width: 511px) {
            #imgLogotipo{
                content: url('../../assets/img/logotipo_400.png');
            }
        }
        
        @media screen and (min-width: 512px) {
            #imgLogotipo{
                content: url('../../assets/img/logotipo_512.png');
            }
        }
        
        @media screen and (min-width: 601px) {
            form div.div-body{
                width: 600px;
            }
        }
        
        .titulo-pag{
            font-size: 30px;
            color: #198f90;
            font-weight: bold;
        }
        
        form label{
            color: #198f90;
            margin-top: 10px;
        }
        
        input.form-control{
            color: #198f90;
        }
        
        body { 
            background: url('../../assets/img/bg_index.jpg') no-repeat center center fixed;
            -moz-background-size: cover;
            -webkit-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
        }
        
        .upload-msg {
            text-align: center;
            padding-top: 90px;
            font-size: 22px;
            color: #fff;
            width: 100%;
            height: 200px;
            margin: 5px auto;
            border: 1px solid #fff;
        }

        .form-control-file {
            position: relative;
            overflow: hidden;
            margin: 10px;
            color: #198f90;
            border: 0;
        }
        
        .form-control-file:hover{
            color: #fff;
            background: #198f90;
        }
    </style>
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
        
        <form class="form-horizontal">
            <div class="container-fluid div-body">
                <div class="row">
                    <div class="col-xs-12 aln-center" style="padding: 15px;">
                        <img id='imgLogotipo' alt="MatBall Logotipo"/>
                    </div>
                    
                    <div class="col-xs-12 aln-center" style="padding: 15px; vertical-align: middle; height: 100%;">
                        <h2 class="titulo-pag">Cadastro de Usuário</h2>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-sm-12 col-md-8">
                        <label for="nome">Nome</label>
                        <input cmp-post='string' type="text" class="form-control" id="nome" required
                               maxlength="100">
                    </div>
                    
                    <div class="col-sm-12 col-md-4">
                        <label for="dt_nascimento">Dt. Nascimento</label>
                        <input cmp-post='string' id="dt_nascimento" type="text" class="form-control date" required>
                    </div>
                    
                    <div class="col-md-12">
                        <label for="email">E-mail</label>
                        <input cmp-post='string' type="email" class="form-control" id="email" required
                               maxlength="200">
                    </div>
                    
                    <div class="col-sm-12">
                        <label for="login">Login</label>
                        <input cmp-post='string' type="text" class="form-control" id="login" required
                               maxlength="30">
                    </div>
                    
                    <div class="col-sm-12 col-md-6">
                        <label for="senha">Senha</label>
                        <input cmp-post='string' type="password" class="form-control" id="senha" required>
                    </div>
                    
                    <div class="col-sm-12 col-md-6">
                        <label for="senha2">Confirmar Senha</label>
                        <input type="password" class="form-control" id="senha2" required>
                    </div>
                    
                    <div class="col-sm-12 col-md-2">
                        <label for="pais">País</label>
                        <input cmp-post='string' type="text" class="form-control" id="pais" required
                               maxlength="2">
                    </div>
                    
                    <div class="col-sm-12 col-md-2">
                        <label for="estado">UF</label>
                        <input cmp-post='string' type="text" class="form-control" id="estado" required
                               maxlength="2">
                    </div>
                    
                    <div class="col-sm-12 col-md-8">
                        <label for="cidade">Cidade</label>
                        <input cmp-post='string' type="text" class="form-control" id="cidade" required
                               maxlength="200">
                    </div>
                    
                    <div class="col-sm-12 col-md-8">
                        <label for="escola">Nome da Escola</label>
                        <input cmp-post='string' type="text" class="form-control" id="escola"
                               maxlength="100">
                    </div>
                    
                    <div class="col-sm-12 col-md-4">
                        <label for="tipo_escola">Tipo</label>
                        <select cmp-post='string' id='tipo_escola' class="selectpicker form-control" required>
                            <option selected value="X">&nbsp;</option>
                            <option value="M">Municipal</option>
                            <option value="E">Estadual</option>
                            <option value="F">Federal</option>
                            <option value="P">Privada</option>
                        </select>
                    </div>
                    
                    <div id="divEnviarFoto" class="col-md-12" style="padding-top: 20px;">
                        <div>
                            <div id="croppie">
                                <div class="aln-center">
                                    <i class="glyphicon glyphicon-arrow-left btn-rotate"  data-deg="-90" style="padding-right: 100px;"></i>
                                    <i class="glyphicon glyphicon-arrow-right btn-rotate" data-deg="90"></i>
                                </div>
                                <div id="imgUpload" style="padding: 10px;"></div>
                            </div>

                            <div class="upload-msg">
                                Foto não Carregada
                            </div>
                        </div>

                        <div class="aln-center">
                            <div class="form-control-file btn btn-default">
                                <span class="fa fa-upload"></span>
                                &nbsp;
                                <span>Carregar uma Foto</span>
                                <input type="file" id="upload" accept="image/*" />
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-xs-12 aln-right" style="margin: 50px 0 50px 0;">
                        <button id='btnCancel' type="button" class="btn btn-default">
                            Cancelar
                        </button>

                        <button id='btnSave' type="submit" class="btn btn-primary">
                            <i class="glyphicon glyphicon-ok"></i>&nbsp;
                            Enviar
                        </button>
                    </div>
                </div>
            </div>
        </form>
        
        <script src="../../assets/external/bootstrap-select/js/bootstrap-select.min.js" type="text/javascript"></script>
        <script src="../../assets/external/bootstrap-select/js/defaults-pt_BR.min.js" type="text/javascript"></script>

        <script src="../../assets/external/moment/moment.min.js" type="text/javascript"></script>
        <script src="../../assets/external/moment/moment-with-locales.js" type="text/javascript"></script>
        <script type="text/javascript" 
            src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js">
        </script>

        <script src="../../assets/external/croppie/croppie.min.js" type="text/javascript"></script>
            
        <script src="../../assets/js/add-usuario.js" type="text/javascript"></script>

    </body>

</html>