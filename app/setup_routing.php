<?php

$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '/registration', ['event.controller', 'registrationAction']);
    $r->addRoute('POST', '/registration', ['event.controller', 'handleRegistrationAction']);
    $r->addRoute('GET', '/voucher/{voucher}', ['event.controller', 'printVoucherAction']);
});
