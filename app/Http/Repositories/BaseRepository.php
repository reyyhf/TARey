<?php

namespace App\Http\Repositories;

use Illuminate\Database\Eloquent\Model;

class BaseRepository
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function store($attributes)
    {
        return $this->model->create($attributes);
    }

    public function bulkStore($attributes)
    {
        return $this->model->insert($attributes);
    }

    public function findColumn($column, $params)
    {
        return $this->model->where($column, $params)->first();
    }

    public function getColumn($column, $params)
    {
        return $this->model->where($column, $params)->get();
    }

    public function getColumns($params = [])
    {
        return $this->model->where($params)->get();
    }

    public function find($id)
    {
        return $this->model->findOrFail($id);
    }

    public function update($id, $attributes)
    {
        $data = $this->find($id);

        $data->update($attributes);

        return $data;
    }

    public function checkUpdateOrCreate($arrayCheck, $attributes)
    {
        return $this->model->updateOrCreate($arrayCheck, $attributes);
    }

    public function destroy($id)
    {
        return $this->find($id)->delete();
    }
}
