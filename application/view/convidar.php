<?php include "./includes/page-header.php" ?>
<?php include "./includes/page-middle.php" ?>

<style>

</style>

<div class="name-page">Convidar Usuário</div>

<div class="row margin-top-100">
    <form class="form-horizontal">
        <input cmp-post="int" id="usuario_id" type="hidden" value="<?php echo RestrictedSession::getID(); ?>">
        <input cmp-post="int" id="grupo_id" type="hidden" value="<?php echo $_GET["id"]; ?>">
        
        <div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
            <div class="row">
                <div class="col-xs-10 col-sm-11 form-group">
                    <input cmp-post='string' type="text" class="form-control"
                           id="login" required maxlength="30" placeholder="Usuário">
                </div>

                <div class="col-xs-2 col-sm-1 form-group aln-right">
                    <div class="btn btn-primary" id="btnBuscar">
                        <i class="fa fa-search"></i>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script src="../../assets/js/convidar.js" type="text/javascript"></script>

<?php include "./includes/page-footer.php" ?>