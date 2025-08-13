<?php
namespace App\Services;

use Illuminate\Database\Eloquent\Model;

abstract class BaseCrudService
{
    protected Model $model;

    public function getAll($orderBy = 'id', $direction = 'desc')
    {
        return $this->model->orderBy($orderBy, $direction)->paginate(10);
    }
    public function getTrash($orderBy = 'id', $direction = 'desc')
    {
        return $this->model->onlyTrashed()->orderBy($orderBy, $direction)->paginate(10);
    }
    public function find($id)
    {
        return $this->model->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(Model $item, array $data)
    {
        $item->update($data);
        return $item;
    }

    public function delete(Model $item)
    {
        return $item->delete();
    }
    public function restore($id)
    {
        $item = $this->model->onlyTrashed()->findOrFail($id);
        return $item->restore();
    }
     public function forceDelete($id)
    {
        $item = $this->model->onlyTrashed()->findOrFail($id);
        return $item->forceDelete();
    }
}
