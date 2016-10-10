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

<div class="name-page">Diário de Pontuações</div>

<div class="row">
    <div class="col-xs-12">
        <input id="usuario_id" type="hidden"
               value="<?php echo(RestrictedSession::getID()) ?>">
        
        <table id='listTable' class="table table-striped table-bordered dt-responsive" 
               cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th class="aln-center">Data</th>
                    <th class="aln-center">Nível Max.</th>
                    <th class="aln-center">Pont. Max.</th>
                    <th class="aln-center">Jogos</th>
                    <th class="aln-center">Tempo</th>
                    <th class="aln-center">Ult. Jogo</th>
                    <th class="acertos">&plus;</th>
                    <th class="acertos">&minus;</th>
                    <th class="acertos">&times;</th>
                    <th class="acertos">&divide;</th>
                    <th class="erros">&plus;</th>
                    <th class="erros">&minus;</th>
                    <th class="erros">&times;</th>
                    <th class="erros">&divide;</th>
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
            'Diarios', 'listByUser', object,
            function(r){
                loadListTable(null, '#listTable', r.object, 
                    function (row, o){
                        row.append($("<td class='aln-center' data-order='" + 
                                o.dt_diario.replace(/-/g, '') + "'>" + 
                                sqlDateToDate(o.dt_diario) + "</td>"));
                        row.append($("<td class='aln-right'>" + o.nivel_max + "</td>"));
                        row.append($("<td class='aln-right'>" + o.pontos_max + "</td>"));
                        row.append($("<td class='aln-right'>" + o.qtd_jogos + "</td>"));
                        row.append($("<td class='aln-center'>" + o.tempo_total + "</td>"));
                        row.append($("<td class='aln-center'>" + o.hr_ultimo_jogo + "</td>"));
                        row.append($("<td class='acertos'>" + o.acertos_adicao + "</td>"));
                        row.append($("<td class='acertos'>" + o.acertos_subtracao + "</td>"));
                        row.append($("<td class='acertos'>" + o.acertos_multiplicacao + "</td>"));
                        row.append($("<td class='acertos'>" + o.acertos_divisao + "</td>"));
                        row.append($("<td class='erros'>" + o.erros_adicao + "</td>"));
                        row.append($("<td class='erros'>" + o.erros_subtracao + "</td>"));
                        row.append($("<td class='erros'>" + o.erros_multiplicacao + "</td>"));
                        row.append($("<td class='erros'>" + o.erros_divisao + "</td>"));
                    }
                );
                
                dataTable = toDataTable('#listTable', {}, [ 0, "desc" ]);
                
                hideLoad();
            },
            function (){}
        );
    }
    


</script>

<?php include "./includes/page-footer.php" ?>