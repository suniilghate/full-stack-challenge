<?php

$menuParam = array('records','director','single-director','business','single-business','businesses-registered-in-year','last-100','business-name-with-director-fullname');

$requestParam = (isset($_GET['fetch']) ? $_GET['fetch'] : 'records');

include __DIR__ . '/../views/index.phtml';