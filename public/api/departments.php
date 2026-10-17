<?php
require __DIR__ . '/../../backend/bootstrap.php';

Api::dispatch(DepartmentController::routes());
