<?php

namespace Suifengpiao\Admin\Controllers;

use Suifengpiao\Admin\Facades\Admin;
use Suifengpiao\Admin\Form;
use Suifengpiao\Admin\Grid;

trait ModelForm
{

    public function index(){
        return $this->grid()->render();
    }

    public function create(){
        return $this->form()->render();
    }


    public function edit($id){
        return $this->form()->edit($id)->render();
    }

    protected function grid(){
        return Admin::grid(\Illuminate\Database\Eloquent\Model::class,function(Grid $grid){});
    }

    protected function form(){
        return Admin::form(\Illuminate\Database\Eloquent\Model::class,function(Form $form){});
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->edit($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        return $this->form()->update($id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result=$this->form()->destroy($id);
        if (true===$result) {
            return response()->json([
                'code'  => 200,
                'message' => trans('backend.delete_succeeded'),
            ]);
        } else {
            return response()->json([
                'code'  => 400,
                'message' => trans('backend.delete_failed'),
                'error_ids'=>$result['error_ids']??'',
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        return $this->form()->store();
    }
}
