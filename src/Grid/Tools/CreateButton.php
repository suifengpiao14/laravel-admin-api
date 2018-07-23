<?php

namespace Suifengpiao\Admin\Grid\Tools;

use Suifengpiao\Admin\Grid;

class CreateButton extends AbstractTool
{
    /**
     * Create a new CreateButton instance.
     *
     * @param Grid $grid
     */
    public function __construct(Grid $grid)
    {
        $this->grid = $grid;
    }

    /**
     * Render CreateButton.
     *
     * @return string
     */
    public function render()
    {
        if (!$this->grid->allowCreation()) {
            return '';
        }

        $data=[
            'url'=>$this->grid->resource(),
            'label'=>trans('backend.create'),
        ];
        return $data;
    }
}
