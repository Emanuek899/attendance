<?php
/**
 * Base manager to handle repetitive functions, this class
 * will be part of controllers and will communicate to the
 * managers
 */
class BaseController{
    private object $manager;

    public function __construct(object $manager){
        $this->manager = $manager;
    }

    /**
     * Get the data from the respective manager and return the return value
     */
    public function get(array $conditions = [], array $cols = ['*']){
        return $this->manager->read($conditions, $cols);
    }

    /**
     * Insert the data from the respective manager and return
     * the return value
     */
    public function insert(array $data){
        return $this->manager->create($data);
    }

    /**
     * Call the respective manager to use the update method od the manager
     */
    public function update(array $data, array $conditions){
        return $this->manager->update($data, $conditions);
    }

    /**
     * Calls the manager and use the delete method of this one.
     */
    public function delete(array $conditions){
        return $this->manager->delete($conditions);
    }
}