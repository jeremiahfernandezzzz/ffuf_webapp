<?php

namespace ffuf\customer\project\app\model;

/**
 * Task
 */
class Task
{
    /**
     * @var string|null
     */
    private $task;

    /**
     * @var \DateTime|null
     */
    private $createdAt;

    /**
     * @var \DateTime|null
     */
    private $finishedAt;

    /**
     * @var int
     */
    private $id;


    /**
     * Set task.
     *
     * @param string|null $task
     *
     * @return Task
     */
    public function setTask($task = null)
    {
        $this->task = $task;

        return $this;
    }

    /**
     * Get task.
     *
     * @return string|null
     */
    public function getTask()
    {
        return $this->task;
    }

    /**
     * Set createdAt.
     *
     * @param \DateTime|null $createdAt
     *
     * @return Task
     */
    public function setCreatedAt($createdAt = null)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt.
     *
     * @return \DateTime|null
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set finishedAt.
     *
     * @param \DateTime|null $finishedAt
     *
     * @return Task
     */
    public function setFinishedAt($finishedAt = null)
    {
        $this->finishedAt = $finishedAt;

        return $this;
    }

    /**
     * Get finishedAt.
     *
     * @return \DateTime|null
     */
    public function getFinishedAt()
    {
        return $this->finishedAt;
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}
