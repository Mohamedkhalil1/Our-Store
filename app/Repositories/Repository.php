<?php 

namespace App\Repositories;

use App\Interfaces\RepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class Repository implements RepositoryInterface{

    protected $model ; 

    public function __construct(Model $model)
    {
        $this->model = $model ;
    }

    public function all(){
        return $this->model->all();
    }

    public function create(array $data){
        return $this->model->create($data);
    }

    public function update(array $data,$id){
        return $this->model->findOrFail($id)->update($data);
    }

    public function delete($id){
        return $this->model->findOrFail($id)->delete();
    }

    public function show($id){
        return $this->model->findOrFail($id);
    }

    public function setModel($model){
        $this->model = $model;
        return $this;
    }

    public function getModel(){
        return $this->model;
    }

    public function with($relations){
        return $this->model->with($relations);
    }
}