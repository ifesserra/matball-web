var base64Img = null;
var uploadCrop;
var selectImg = false;

$(window).ready(function(){
    toDatepicker('.date', true);

    $('#btnCancel').click(function (){
        window.location = '../../index.php';
    });

    uploadCrop = initCroppie({
        width:130,
        height:130,
        b_width:200,
        b_height:200,
        type:'circle',
        funcOnLoad: function (){
            selectImg = true;
        }
    }, '.upload-msg', '#croppie');

    $('#croppie').hide();

    $('form').submit(function (){
        var object = serializeForm('cmp-post');
        object.base64Img = "";

        if(object.senha !== $('#senha2').val()){
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
    if(object.base64Img === ""){
        showMessage('Carregue uma foto de perfil.', 'danger');
        return false;
    }

    sendPostService(
        '../Receiver.php',
        'Usuarios', 'insert', object,
        function (r){
            window.location = r.object.link;
        },
        function (){}
    );
}