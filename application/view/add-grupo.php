<?php include "./includes/page-header.php" ?>
<?php include "./includes/page-middle.php" ?>

<link href="../../assets/external/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" type="text/css"/>

<style>

</style>

<div class="name-page">Criar Grupo</div>

<form class="form-horizontal">
    <div class="row form-group">
        <input cmp-post='int' id="id" type="hidden"
            value="<?php echo RestrictedSession::getID() ?>">
        
        <div class="col-xs-12">
            <label for="nome">Nome</label>
            <input cmp-post='string' type="text" class="form-control" id="nome" required
                   maxlength="30">
        </div>
        
        <div class="col-xs-12">
            <label for="tipo">Tipo</label>
            <select cmp-post='int' id='tipo' class="selectpicker form-control" required>
                <option value="0" data-icon="fa fa-user-secret">&nbsp;Oculto</option>
                <option value="1" data-icon="fa fa-lock" selected>&nbsp;Privado</option>
                <option value="2" data-icon="fa fa-globe">&nbsp;Público</option>
            </select>
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

<script src="../../assets/js/add-grupo.js" type="text/javascript"></script>

<?php include "./includes/page-footer.php" ?>