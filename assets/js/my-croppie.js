// opt = {
//    width:300,
//    height:300,
//    b_width:320,
//    b_height:320,
//    type:'square',
//    funcOnLoad: function (){}
// }
function initCroppie(opt, selectorPreview, selectorCroppie) {
    var uploadCrop = new Croppie(document.getElementById('imgUpload'), {
        viewport: {
            width: opt.width,
            height: opt.height,
            type: opt.type
        },
        enableOrientation: true,
        boundary: { width: opt.b_windth, height: opt.b_height },
        enforceBoundary: false
    });

    function readFile(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                uploadCrop.bind({
                    url: e.target.result,
                    orientation: 0
                });

                $(selectorPreview).hide();
                $(selectorCroppie).show();

                opt.funcOnLoad();
            };

            reader.readAsDataURL(input.files[0]);
        }
        else {
            showMessage("Seu navegador não supota a API FileReader. Faça atualização do mesmo.", 'danger');
        }
    }

    $('.btn-rotate').on('click', function() {
        uploadCrop.rotate(parseInt($(this).data('deg')));
        return false;
    });

    $('#upload').on('change', function () { 
        readFile(this);
    });
    
    return uploadCrop;
}