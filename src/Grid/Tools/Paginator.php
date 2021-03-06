<?php

namespace Suifengpiao\Admin\Grid\Tools;

use Suifengpiao\Admin\Grid;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Input;

class Paginator extends AbstractTool
{
    /**
     * @var \Illuminate\Pagination\LengthAwarePaginator
     */
    protected $paginator = null;

    /**
     * Create a new Paginator instance.
     *
     * @param Grid $grid
     */
    public function __construct(Grid $grid)
    {
        $this->grid = $grid;

        $this->initPaginator();
    }

    /**
     * Initialize work for Paginator.
     *
     * @return void
     */
    protected function initPaginator()
    {
        $this->paginator = $this->grid->model()->eloquent();

        if ($this->paginator instanceof LengthAwarePaginator) {
            $this->paginator->appends(Input::all());
        }
    }

    /**
     * Get Pagination links.
     *
     * @return string
     */
    protected function paginationLinks()
    {
        $data=$this->paginator->toArray();
        unset($data['data']);
        return $data;
    }

    /**
     * Get per-page selector.
     *
     * @return PerPageSelector
     */
    protected function perPageSelector()
    {
        return new PerPageSelector($this->grid);
    }

    /**
     * Get range infomation of paginator.
     *
     * @return string|\Symfony\Component\Translation\TranslatorInterface
     */
    protected function paginationRanger()
    {
        $parameters = [
            'first' => $this->paginator->firstItem(),
            'last'  => $this->paginator->lastItem(),
            'total' => $this->paginator->total(),
        ];

        return $parameters;
    }

    /**
     * Render Paginator.
     *
     * @return string
     */
    public function render()
    {
        if (!$this->grid->usePagination()) {
            return '';
        }

        return array_merge($this->paginationRanger(),$this->paginationLinks());
    }
}
