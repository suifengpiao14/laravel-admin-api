<?php

namespace Suifengpiao\Admin\Grid\Displayers;

use Suifengpiao\Admin\Admin;

class Actions extends AbstractDisplayer
{
    /**
     * @var array
     */
    protected $appends = [];

    /**
     * @var array
     */
    protected $prepends = [];

    /**
     * @var bool
     */
    protected $allowEdit = true;

    /**
     * @var bool
     */
    protected $allowDelete = true;

    /**
     * @var string
     */
    protected $resource;

    /**
     * @var
     */
    protected $key;

    /**
     * Append a action.
     *
     * @param $action
     *
     * @return $this
     */
    public function append($action)
    {
        array_push($this->appends, $action);

        return $this;
    }

    /**
     * Prepend a action.
     *
     * @param $action
     *
     * @return $this
     */
    public function prepend($action)
    {
        array_unshift($this->prepends, $action);

        return $this;
    }

    /**
     * Disable delete.
     *
     * @return void.
     */
    public function disableDelete()
    {
        $this->allowDelete = false;
    }

    /**
     * Disable edit.
     *
     * @return void.
     */
    public function disableEdit()
    {
        $this->allowEdit = false;
    }

    /**
     * Set resource of current resource.
     *
     * @param $resource
     *
     * @return void
     */
    public function setResource($resource)
    {
        $this->resource = $resource;
    }

    /**
     * Get resource of current resource.
     *
     * @return string
     */
    public function getResource()
    {
        return $this->resource ?: parent::getResource();
    }

    /**
     * {@inheritdoc}
     */
    public function display($callback = null)
    {
        if ($callback instanceof \Closure) {
            $callback->call($this, $this);
        }

        $actions = $this->prepends;
        if ($this->allowEdit) {
            array_push($actions, $this->editAction());
        }

        if ($this->allowDelete) {
            array_push($actions, $this->deleteAction());
        }

        $actions = array_merge($actions, $this->appends);

        return $actions;
    }

    public function setKey($key)
    {
        $this->key = $key;

        return $this;
    }

    public function getKey()
    {
        if ($this->key) {
            return $this->key;
        }

        return parent::getKey();
    }

    /**
     * Built edit action.
     *
     * @return string
     */
    protected function editAction()
    {
        return [
            'key'=>'EditRow',
            'method'=>'get',
            'url'=>sprintf("%s/%s/edit",$this->getResource(),$this->getKey()),
        ];
    }

    /**
     * Built delete action.
     *
     * @return string
     */
    protected function deleteAction()
    {
        return [
            'key'=>'DeleteRow',
            'method'=>'delete',
            'url'=>sprintf("%s/%s",$this->getResource(),$this->getKey()),
            'payload'=>['status'=>0]
        ];
    }
}
