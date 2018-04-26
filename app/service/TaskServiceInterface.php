<?php

namespace ffuf\customer\project\app\service;

use ffuf\customer\project\app\model\Task;

/**
 * Interface TaskServiceInterface
 */
interface TaskServiceInterface{

    public function create(Task $task);
    public function show();
    public function update(Task $task);
    public function finishedAt(Task $task);
    public function delete(Task $task);
    public function getTaskById($id);
}