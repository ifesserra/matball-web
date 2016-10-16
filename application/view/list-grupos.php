<?php include "./includes/page-header.php" ?>
<?php include "./includes/page-middle.php" ?>

<link href="../../assets/external/data-tables/css/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css"/>
<link href="../../assets/external/data-tables-responsive/css/responsive.bootstrap.min.css" rel="stylesheet" type="text/css"/>

<style>
    .acertos{
        text-align: center;
        font-size: 16px;
        font-weight: bold;
        color: #00f;
    }
    
    .erros{
        text-align: center;
        font-size: 16px;
        font-weight: bold;
        color: #f00;
    }
</style>

<div class="name-page">Meus Grupos</div>

<div class="row">
    <div class="col-xs-12 aln-right margin-bottom-15">
        <a href="add-grupo.php" class="btn btn-primary">
            <i class="fa fa-users"></i>
            <strong>Criar Grupo</strong>
        </a>
    </div>
    
    <div class="col-xs-12">
        <input id="usuario_id" type="hidden"
               value="<?php echo(RestrictedSession::getID()) ?>">
        
        <table id='listTable' class="table table-striped table-bordered dt-responsive" 
               cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th class="aln-center">Nome</th>
                    <th class="aln-center">Tipo</th>
                    <th class="aln-center">Dono</th>
                    <th class="aln-center">Criação</th>
                    <th class="aln-center">Entrada</th>
                    <th class="aln-center">Moderador</th>
                    <th class="aln-center"></th>
                </tr>
            </thead>
            
            <tbody></tbody>

        </table>
    </div>
</div>

<script src="../../assets/external/data-tables/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="../../assets/external/data-tables/js/dataTables.bootstrap.min.js" type="text/javascript"></script>
<script src="../../assets/external/data-tables-responsive/js/dataTables.responsive.min.js" type="text/javascript"></script>
<script src="../../assets/external/data-tables-responsive/js/responsive.bootstrap.min.js" type="text/javascript"></script>

<script>

    $(document).ready(function (){
        showLoad("Carregando...");
        loadTable();
        
    });
    
    var dataTable;
    function loadTable(){
        var object = {usuario_id: $('#usuario_id').val()};

        sendPostService(
            '../Receiver.php',
            'Grupos', 'listByUser', object,
            function(r){
                loadListTable(null, '#listTable', r.object, 
                    function (row, o){
                        var tipos = ['fa-user-secret', 'fa-lock', 'fa-globe'];
                                
                        row.append($("<td class='aln-center'>" + o.grupo_nome + "</td>"));
                        
                        row.append($("<td class='aln-center'><i class='fa fa-2x " + 
                                tipos[parseInt(o.grupo_tipo)] + "'></i></td>"));
                        
                        row.append($("<td class='aln-center'>" + 
                                (o.administrador_id === $('#usuario_id').val() ? 'Você': o.administrador_nome) + 
                                "</td>"));
                        
                        row.append($("<td class='aln-center' data-order='" + 
                                o.dt_criacao.replace(/-/g, '') + "'>" + 
                                sqlDateToDate(o.dt_criacao) + "</td>"));
                        
                        row.append($("<td class='aln-center' data-order='" + 
                                o.dt_entrada.replace(/-/g, '') + "'>" + 
                                sqlDateToDate(o.dt_entrada) + "</td>"));
                        
                        row.append($("<td class='aln-center'>" + 
                                (o.moderador_id !== null || o.administrador_id === $('#usuario_id').val() ? "Sim": "Não") + 
                                "</td>"));
                        
                        row.append($("<td class='aln-center'><a href='view-grupo?id=" + o.grupo_id + 
                                        "' class='btn btn-primary' title='Visualizar'><i class='glyphicon glyphicon-search'></i>" +
                                    "</td>"));
                    }
                );
                
                dataTable = toDataTable('#listTable', {orderable: false, "targets": 6}, [ 0, "asc" ]);
                
                hideLoad();
            },
            function (){}
        );
    }
    


</script>

<?php include "./includes/page-footer.php" ?>