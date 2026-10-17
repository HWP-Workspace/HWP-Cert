<?php
require __DIR__ . '/../../backend/bootstrap.php';

Api::dispatch(AuthController::routes());
