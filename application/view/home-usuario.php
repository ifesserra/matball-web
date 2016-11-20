<?php 

require_once "../dao/RecordesDAO.class.php";
require_once "../dao/DiariosDAO.class.php";

include "includes/page-header.php";
include "includes/page-middle.php";

$recordes = RecordesDAO::getRanking(RestrictedSession::getID());
$diarioHoje = DiariosDAO::getRankingToday(RestrictedSession::getID());
include "./includes/resumo-usuario.php";

include "./includes/page-footer.php";