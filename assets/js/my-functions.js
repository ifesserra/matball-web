// MODAIS
var modalOptions = {hashTracking: false, closeOnOutsideClick: false};
var modalLoadOptions = {hashTracking: false, closeOnOutsideClick: false, closeOnEscape:false, closeOnCancel:false};
var modalMessage = null;
var modalLoad = null;
var modalConfirm = {
    modal: null,
    yes: null,
    no: null
};

// type: success | info | warning | danger
function showMessage(message, type, funcOnClosed, argument){
    if(modalLoad !== null){
        if(modalLoad.getState() !== 'closed'){
            setTimeout(
                function (){
                    showMessage(message, type, funcOnClosed, argument);
                }, 100);
            return false;
        }
    }
    
    if(modalMessage === null)
        modalMessage = $('#modalMessage').remodal(modalOptions);
    
    $('#modalMessage div.message').html(
        '<div class="alert alert-' + type + '">' +
            '<label class="font-size-18">' + message + '</label>' +
        '</div>'
    );
    
    modalMessage.open();
    if(funcOnClosed !== undefined && funcOnClosed !== null){
        $(document).on('closed', '#modalMessage', 
            function (){
                $(document).off('closed', '#modalMessage');
                funcOnClosed(argument);
            });
    }
}

// Modal Confirm
function showConfirm(message, lblYes, funcYes, lblNo, funcNo){
    if(modalConfirm.modal === null)
        modalConfirm.modal = $('#modalConfirm').remodal(modalOptions);
    
    $('#modalConfirm div.message').html(
        '<label class="font-size-18">' + message + '</label class="font-size-18">'
    );
    
    modalConfirm.yes = funcYes;
    modalConfirm.no = funcNo;
    
    $('#modalConfirm .confirm-yes').text(lblYes);
    $('#modalConfirm .confirm-no').text(lblNo);
    
    modalConfirm.modal.open();
}

function showLoad(message){
    if(modalLoad === null)
        modalLoad = $('#modalLoad').remodal(modalLoadOptions);
    
    var msg = (message === undefined ? "Carregando..." : message);
    $('#modalLoad div.message').html(
            '<label class="font-size-18">' + msg + '</label>'
    );
    
    modalLoad.open();
}

function hideLoad(){
    if(modalLoad !== null && modalLoad.getState() !== 'closed'){
        if(modalLoad.getState() === 'opening'){
            setTimeout(hideLoad, 100);
        }
        else{
            modalLoad.close();
        }
    }
}

function modalConfirmAction(f){
    if(modalConfirm.modal.getState() === 'opened'){
        modalConfirm.modal.close();
    }
    
    if(modalConfirm.modal.getState() === 'closing'){
        setTimeout(modalConfirmAction, 100, f);
        return false;
    }
    
    f();
}

$('#modalConfirm .confirm-yes').click(function (){
    modalConfirmAction(modalConfirm.yes);
});

$('#modalConfirm .confirm-no').click(function (){
    modalConfirmAction(modalConfirm.no);
});
// ---

function fadeOutIn(selectorOut, durationOut, selectorIn, durationIn){
    $(selectorOut).fadeOut(
            durationOut, 
            function(){
                $(selectorIn).fadeIn(durationIn);
            }
    );
}

function serializeForm(nameSelector){
    var objet = {};
    $('[' + nameSelector + ']').each(function (){
        var dataType = $(this).attr(nameSelector);
        var inputType = $(this).attr('type');
        var value;
        var id = $(this).attr('id');
        
        if(inputType === 'checkbox'){
            value = $(this).prop('checked')? 1: 0;
        }
        else{
            value = $(this).val();
            
            if(dataType === 'int')
                value = parseInt(value);
            else if(dataType === 'float')
                value = parseFloat(value);
        }
        
        objet[id] = value;
    });
    
    return objet;
}

function sendPostService(url, service, operation, object, funcSuccess, funcError){
    var json = {};
    json.service = service;
    json.operation = operation;
    json.object = object;
    var call = JSON.stringify(json);
    debugger;
    jQuery.ajax({
        url : url,
        type: 'post',
        data: 'call=' + call,
        success: function(r){
            debugger;
            console.log(r);
            r = jQuery.parseJSON(r);
            
            hideLoad();
            
            // Success = 0 (No Message)
            // Success = 1000 - 1999
            // Info    = 2000 - 2999
            // Warning = 3000 - 3999
            // Danger  = 4000 - 4999
            if(r.cd_message > 3999){
                if(funcError === undefined)
                    showMessage(r.message, 'danger');
                else
                    showMessage(r.message, 'danger', funcError, r);
            }
            else{
                if     (r.cd_message > 2999) showMessage(r.message, 'warning', funcSuccess, r);
                else if(r.cd_message > 1999) showMessage(r.message, 'info', funcSuccess, r);
                else if(r.cd_message > 999) showMessage(r.message, 'success', funcSuccess, r);
                else
                    funcSuccess(r);
            }
        },
        error: function(){
            hideLoad();
            if(funcError !== undefined)
                funcError(null);
        }
    });
}

function loadSelectOptions(selector, service, operation, object, funcReady){
    sendPostService(
        '../receiver.php',
        service, operation, object,
        function (r){
            var list = r.object;
            $(selector).empty();
            for(var i in list){
                $(selector).append(
                    "<option value=" + list[i].id + ">" +
                        list[i].text +
                    "</option>");
            }

            $(selector).selectpicker('refresh');
            
            if(funcReady !== undefined)
                funcReady();
        },
        function (){}
    );
}

function toDataTable(selector, columnDefs, order){
    return $(selector).DataTable({
        "lengthMenu": [[10, 50, 100], [10, 50, 100]],
        fixedHeader: {
            header: false,
            footer: true
        },
        "language": {"url": "http://cdn.datatables.net/plug-ins/1.10.11/i18n/Portuguese-Brasil.json"},
        "columnDefs": [
            //{"orderable": false, "targets": 0}
            columnDefs
        ],
        "order": [
            //[ 0, "asc" ]
            order
        ]
    });
}

function loadListTable(dataTable, selector, list, funcRowAppend){
    if(dataTable !== null){
        dataTable.clear();
        dataTable.destroy();
        $(selector + ' tr td').empty();
    }

    for(var i in list){
        var row = $("<tr />");
        $(selector).append(row);
        funcRowAppend(row, list[i]);
    }
}

function toDatepicker(selector, single){
    var conf = {
        showDropdowns: true,
        singleDatePicker: (single === undefined ? true : single),
        "autoApply": true,
        "locale": {
            "format": "DD/MM/YYYY",
            "separator": " - ",
            "applyLabel": "Aplicar",
            "cancelLabel": "Cancelar",
            "fromLabel": "De",
            "toLabel": "à",
            "customRangeLabel": "Custom",
            "weekLabel": "D",
            "daysOfWeek": ["D","S","T","Q","Q","S","S"],
            "monthNames": ["Janeiro","Fevereiro","Março","Abril","Maio","Junho",
                "Julho","Agosto","Setembro","Outubro","Novembro","Dezembro"],
            "firstDay": 0
        }
    };

    return $(selector).daterangepicker(conf);
}

// 01/02/2016 -> 20160201
function dateToOrderDate(date){
    return date.replace(/(\d{2})\/(\d{2})\/(\d{4})/g, "$3$2$1");
}

// 2016-02-01 -> 01/02/2016
function sqlDateToDate(date){
    return date.replace(/(\d{4})-(\d{2})-(\d{2})/g, "$3/$2/$1");
}

function formatCPF(cpf){
    return cpf.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/g, "$1.$2.$3-$4");
}

function formatPhoneDDD(phone){
    return phone.replace(/(\d{2})(\d{5})(\d{4})/g, "($1) $2-$3");
}
