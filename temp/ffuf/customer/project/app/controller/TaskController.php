<?php

namespace ffuf\customer\project\app\controller;

use a15l\cmp\symfony\validator\container\Validator;
use a15l\cmp\symfony\validator\container\exception\ValidationExceptionInterface;
use ffuf\customer\project\app\model\Task;
use ffuf\customer\project\app\service\TaskServiceInterface;
use phastl\ViewEngineInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Class Main
 */
class TaskController{

    /**
     * @var ViewEngineInterface
     */
    private $view;

    /**
     * @var \ffuf\customer\project\app\service\TaskServiceInterface
     */
    private $taskService;

    /**
     * Main Constructor
     * @param ViewEngineInterface $view
     * @param TaskServiceInterface $taskService
     * @Inject("taskService", "\ffuf\customer\project\app\service\TaskService")
     */
    function __construct(
        ViewEngineInterface $view,
        TaskServiceInterface $taskService
    ){
        $this->view = $view;
        $this->taskService = $taskService;
    }

    /**
     * @return view
     */
    public function getIndexPage(){
        $this->view->assign('tasks', $this->taskService->show());
        return $this->view->render('pages/index');
    }

    /**
     * @param Task $task
     * @return RedirectResponse
     */
    public function postTask(Task $task){
        try {
            $this->taskService->create($task);
            return new RedirectResponse('/');
        } catch (ValidationExceptionInterface $ex) {
            $this->view->assign('tasks', $this->taskService->show());
            return $this->view->render('pages/index',
                ['_exception' => $ex]
            );
        }
    }

    /**
     * @param Task $task
     * @return RedirectResponse
     */
    public function editTask(Task $task){
        try {
            //return $this->view->render('pages/update', ['task' => $task]);
            $this->taskService->edit($task);
            return new RedirectResponse('/');
        } catch (ValidationExceptionInterface $ex) {
            $this->view->assign('tasks', $this->taskService->show());
            return $this->view->render('pages/index',
                ['_exception' => $ex]
            );
        }
    }
    /*
    public function updateTask(Task $task){
        try {
            $this->taskService->update($task);
            return new RedirectResponse('/');
        } catch (ValidationExceptionInterface $ex) {
            $this->view->assign('tasks', $this->taskService->show());
            return $this->view->render('pages/index',
                ['_exception' => $ex]
            );
        }
    }
    */

    public function deleteTask(Task $task){
        try {
            $this->taskService->delete($task);
            return new RedirectResponse('/');
        } catch (ValidationExceptionInterface $ex) {
            $this->view->assign('tasks', $this->taskService->show());
            return $this->view->render('pages/index',
                ['_exception' => $ex]
            );
        }
    }
}