<?php
require __DIR__ . '/../../backend/bootstrap.php';

Api::dispatch(PublicController::routes());
