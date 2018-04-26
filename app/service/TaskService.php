<?php

namespace ffuf\customer\project\app\service;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use ffuf\customer\project\app\model\Task;
use a15l\cmp\symfony\validator\container\Validator; # Import Validator
use a15l\cmp\symfony\validator\container\exception\ValidationExceptionInterface;


/**
 * Class TaskService
 */
class TaskService implements TaskServiceInterface{

// ...

    /**
     * @var Validator
     */
    protected $validator;

    /**
     * @param EntityManagerInterface $entityManager
     * @param \a15l\cmp\symfony\validator\container\Validator $validator
     */

    public function __construct(EntityManagerInterface $entityManager, Validator $validator)
    {
        $this->entityManager = $entityManager;
        $this->validator = $validator;
    }

    /*
     * @param Task $task
     */
    public function create(Task $task)
    {
        $this->validator->validate($task);
        $this->entityManager->beginTransaction();
        $task->setCreatedAt(new \DateTime());
        $task->setFinishedAt(null);
        $this->entityManager->persist($task);
        $this->entityManager->flush();
        $this->entityManager->commit();
    }

    /**
     * return Task
     */
    public function show()
    {
        return $this->entityManager->createQuery
        ("
      SELECT t FROM " . Task::class ." t ORDER BY t.id DESC
   ")->getResult();
    }

    /**
     * @param integer $id
     * @return Task
     */
    public function getTaskById($id)
    {
        return $this->entityManager->createQuery("
        SELECT i FROM " . Task::class . " i WHERE i.id
        = :taskId")->setParameter('taskId', $id)
            ->getSingleResult();
    }

    public function update(Task $task){
        $this->validator->validate($task);
        $this->entityManager->beginTransaction();
        $this->entityManager->merge($task);
        $this->entityManager->flush();
        $this->entityManager->commit();
    }

    public function finishedAt(Task $task){
        $task->setFinishedAt(new \DateTime());
    }

    /**
     * @param integer $id
     */
    public function delete($id)
    {
        $this->entityManager->beginTransaction();
        $task = $this->getTaskById($id);
        $this->entityManager->remove($task);
        $this->entityManager->flush();
        $this->entityManager->commit();
    }
// ...
}