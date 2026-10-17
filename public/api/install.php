<?php
const INSTALLER = true;
require __DIR__ . '/../../backend/bootstrap.php';

Api::dispatch(InstallController::routes());
