<?php include "./includes/page-header.php" ?>
<?php include "./includes/page-middle.php" ?>

<link href="../../assets/external/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" type="text/css"/>

<link rel="stylesheet" type="text/css" 
      href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />

<link href="../../assets/external/croppie/croppie.css" rel="stylesheet" type="text/css"/>
<script src="../../assets/js/my-croppie.js" type="text/javascript"></script>

<style>
    #divImgPerfil {
        text-align: center;
        padding-top: 10px;
        width: 100%;
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

<div class="name-page">Perfil do Usuário</div>

<form class="form-horizontal">
    <div class="row form-group">
        
        <div id="divEnviarFoto" class="col-xs-12 col-sm-4 col-md-2">
            <div>
                <div id="croppie" style="display: none;">
                    <div class="aln-center">
                        <i class="glyphicon glyphicon-arrow-left btn-rotate"  data-deg="-90" style="padding-right: 30px;"></i>
                        <i class="glyphicon glyphicon-arrow-right btn-rotate" data-deg="90"></i>
                    </div>
                    <div id="imgUpload" style="padding: 10px;"></div>
                </div>

                <div id="divImgPerfil">
                    <img id="imgPerfil" alt="Foto de Perfil"/>
                </div>
            </div>

            <div class="aln-center">
                <div class="form-control-file btn btn-default">
                    <span class="fa fa-upload"></span>
                    &nbsp;
                    <span>Alterar Foto</span>
                    <input type="file" id="upload" accept="image/*" />
                </div>
            </div>
        </div>
        
        <div class="col-xs-12 col-sm-8 col-md-10">
            <div class="row">
                <input cmp-post='int' id="id" type="hidden"
                       value="<?php echo(RestrictedSession::getID()) ?>">
                
                <div class="col-xs-12 col-sm-8 col-md-10">
                    <label for="nome">Nome</label>
                    <input cmp-post='string' type="text" class="form-control" id="nome" required
                           maxlength="100">
                </div>

                <div class="col-xs-12 col-sm-4 col-md-2">
                    <label for="dt_nascimento">Dt. Nascimento</label>
                    <input cmp-post='string' id="dt_nascimento" type="text" class="form-control date" required>
                </div>

                <div class="col-xs-12 col-sm-8">
                    <label for="email">E-mail</label>
                    <input type="email" class="form-control" id="email" required
                           maxlength="200">
                </div>

                <div class="col-xs-12 col-sm-4">
                    <label for="login">Login</label>
                    <input type="text" class="form-control" id="login" required
                           maxlength="30">
                </div>
                
                <div class="col-xs-12 col-sm-4">
                    <label for="senha_atual">Senha Atual</label>
                    <input cmp-post='string' type="password" class="form-control" id="senha_atual" >
                </div>

                <div class="col-xs-12 col-sm-4">
                    <label for="senha_nova">Nova Senha</label>
                    <input cmp-post='string' type="password" class="form-control" id="senha_nova" >
                </div>
                
                <div class="col-xs-12 col-sm-4">
                    <label for="senha_nova2">Repita Senha</label>
                    <input type="password" class="form-control" id="senha_nova2" >
                </div>
                
                <div class="col-xs-12 col-sm-2">
                    <label for="pais">País</label>
                    <input cmp-post='string' type="text" class="form-control" id="pais" required
                           maxlength="2">
                </div>

                <div class="col-xs-12 col-sm-2">
                    <label for="estado">UF</label>
                    <input cmp-post='string' type="text" class="form-control" id="estado" required
                           maxlength="2">
                </div>

                <div class="col-xs-12 col-sm-8">
                    <label for="cidade">Cidade</label>
                    <input cmp-post='string' type="text" class="form-control" id="cidade" required
                           maxlength="200">
                </div>

                <div class="col-xs-12 col-sm-8">
                    <label for="escola">Nome da Escola</label>
                    <input cmp-post='string' type="text" class="form-control" id="escola"
                           maxlength="100">
                </div>

                <div class="col-xs-12 col-sm-4">
                    <label for="tipo_escola">Tipo</label>
                    <select cmp-post='string' id='tipo_escola' class="selectpicker form-control" required>
                        <option selected value="X">&nbsp;</option>
                        <option value="M">Municipal</option>
                        <option value="E">Estadual</option>
                        <option value="F">Federal</option>
                        <option value="P">Privada</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    
    <?php include "./includes/div-btn-save-cancel.php" ?>

</form>

<script src="../../assets/external/bootstrap-select/js/bootstrap-select.min.js" type="text/javascript"></script>
<script src="../../assets/external/bootstrap-select/js/defaults-pt_BR.min.js" type="text/javascript"></script>

<script src="../../assets/external/moment/moment.min.js" type="text/javascript"></script>
<script src="../../assets/external/moment/moment-with-locales.js" type="text/javascript"></script>
<script type="text/javascript" 
    src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js">
</script>

<script src="../../assets/external/croppie/croppie.min.js" type="text/javascript"></script>

<script>
    var base64Img = null;
    var uploadCrop;
    var selectImg = false;

    $(window).ready(function(){
        showLoad("Carregando dados do Usuário...");
        
        loadCurrentData();
        
        toDatepicker('.date', true);

        uploadCrop = initCroppie({
            width:130,
            height:130,
            b_width:150,
            b_height:150,
            type:'circle',
            funcOnLoad: function (){
                selectImg = true;
            }
        }, '#divImgPerfil', '#croppie');

        $('form').submit(function (){
            var object = serializeForm('cmp-post');
            object.base64Img = "";

            if(object.senha_nova !== $('#senha_nova2').val()){
                showMessage('As senhas não conferem.', 'danger');
                return false;
            }

            if(selectImg){
                uploadCrop.result({
                     type: 'canvas',
                     size: 'viewport',
                     format: 'png'
                 }).then(function(src){
                     object.base64Img = src;
                     submit(object);
                 });
            }
            else{
                submit(object);
            }

            return false;
        });
    });

    function submit(object){
        showLoad('Salvando as alterações...');
        sendPostService(
            '../Receiver.php',
            'Usuarios', 'update', object,
            function (r){
                window.location = r.object.link;
            },
            function (){}
        );
    }
    
    function loadCurrentData(){
        var object = {};
        object.id = $('#id').val();
        
        sendPostService(
            '../Receiver.php',
            'Usuarios', 'findById', object,
            function (r){
                setFormField(r.object);
                hideLoad();
            },
            function (){}
        );
    }
    
    function setFormField(o){
        $('#imgPerfil').attr('src', '../../' + o.url_foto);
        $('#nome').val(o.nome);
        $('#dt_nascimento').val(o.dt_nascimento);
        $('#pais').val(o.pais);
        $('#estado').val(o.estado);
        $('#cidade').val(o.cidade);
        $('#escola').val(o.escola);
        
        if(o.tipo_escola !== ""){
            $('#tipo_escola').selectpicker('val', o.tipo_escola);
        }
        
        $('#email').val(o.email);
        $('#email').prop('disabled', true);
        
        $('#login').val(o.login);
        $('#login').prop('disabled', true);
    }

</script>

<?php include "./includes/page-footer.php" ?>