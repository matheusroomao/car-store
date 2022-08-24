<?php

namespace App\Repository;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use function env;

abstract class AbstractRepository
{
    private object $model;
    private array $relationships;
    private array $dependencies;
    private array $unique;
    private array $upload;
    private int $code;

    public function __construct($model, $relationships, $dependencies, $unique, $upload = null)
    {
        $this->model = $model;
        $this->relationships = $relationships;
        $this->dependencies = $dependencies;
        $this->unique = $unique;
        $this->upload = $upload;
        $this->code = 400;
    }


    public function findAll(Request $request)
    {
        $models = $this->model->query()->with($this->relationships);
        if ($request->exists('search')) {
            $this->setFilterGlobal($request, $models);
        } else {
            $this->setFilterByColumn($request, $models);
        }
        $this->setOrder($request, $models);
        $models = $models->paginate(env('DEFAULT_PAGINATE', 15));
        $this->setCode(200);
        return $models;
    }

    public function findById($id)
    {
        return $this->model->with($this->relationships)->findOrFail($id);
    }

    public function deleteById($id)
    {
        $model = $this->findById($id);
        if (empty($model)) {
            $this->setCode(404);
            return null;
        }
        if ($this->dependencies($model) == FALSE) {
            $this->setCode(403);
            return null;
        }
        $this->uploadFiles($model);
        $model->destroy($model->id);
        $this->setCode(204);
        return null;
    }

    public function save(Request $request)
    {
        if ($this->isDuplicate($request) == TRUE) {
            $this->setCode(422);
            return null;
        }
        $model = new $this->model();
        $model->fill($request->all());
        $this->uploadFiles($model, $request);
        $model->save();

        $this->setCode(200);
        return $model;
    }

    public function update($id, Request $request)
    {
        $model = $this->findById($id);
        if (empty($model)) {
            $this->setCode(404);
            return null;
        }

        if ($this->isDuplicate($request, $id) == TRUE) {
            $this->setCode(422);
            return null;
        }

        $model->fill($request->all());
        $this->uploadFiles($model, $request);
        $model->save();

        $this->setCode(200);
        return $model;
    }


    protected function dependencies($model): bool
    {
        $count = 0;
        if (!empty($model = $this->model->with($this->dependencies)->find($model->id))) {
            foreach ($this->dependencies as $dependence) {
                if (!empty($model->$dependence[0])) $count++;
            }
        }
        if ($count > 0) {
            return false;
        }
        return true;
    }

    protected function isDuplicate(Request $data, $id = null): bool
    {
        $columns = $this->unique;
        if (empty($this->unique)) return false;
        $models = $this->model->query();
        $count = 0;
        foreach ($columns as $column) {
            if (!empty($data->$column) && Schema::hasColumn($this->model->getTable(), $column)) {
                $models->where($column, $data->$column);
                $count++;
            }
        }
        if ($id != null) {
            $models->where('id', '!=', $id);
        }
        if (count($models->get()) > 0 && count($columns) == $count) {
            return true;
        }
        return false;
    }


    public function setFilterGlobal(Request $request, $search)
    {
        if ($request->exists('search') == true) {
            foreach (Schema::getColumnListing($this->model->getTable()) as $column) $search->orWhere($column, "LIKE", "%" . $request->search . "%");
        }
    }


    public function setFilterByColumn(Request $request, $search)
    {
        $columns = Schema::getColumnListing($this->model->getTable());
        foreach ($columns as $field) {
            if ($request->exists($field) == true) {
                $column = Schema::getColumnType($this->model->getTable(), $field);
                if ($column == "int" || $column == "bigint") {
                    $search->where($field, $request->$field);
                } else if ($column == "string") {
                    $search->where($field, 'like', '%' . $request->$field . '%');
                } else if ($column == "datetime") {
                    $search->where($field, 'like', '%' . $request->$field . '%');
                } else if ($column == "float" || $column == "double") {
                    $search->where($field, $request->$field);
                } else if ($column == "boolean") {
                    $search->where($field, boolval($request->$field));
                }
            }
        }
    }

    public function setOrder(Request $request, $search)
    {
        $orderBy = $request->order_by;
        $order = $request->order;
        if (empty($orderBy)) {
            $orderBy = 'id';
        }
        if (empty($order)) {
            $order = 'desc';
        }
        if (Schema::hasColumn($this->model->getTable(), $orderBy) == false) {
            $orderBy = 'id';
        }
        return $search->orderBy($orderBy, $order);
    }

    public function uploadFiles($model, Request $request = null)
    {
        if ($this->upload == []) {
            return null;
        }
        $file = $this->upload[0];
        $path = $this->upload[1];

        if (!$request) {
            if (Storage::exists($model->$file()) === null) {
                Storage::delete($model->$file());
            }
            return null;
        }

        if ($request->hasFile($file) == TRUE && $model->id) {
            if (Storage::exists($model->$file()) === null) {
                Storage::delete($model->$file());
            }
            $model->$file = $request->file($file)->store($path);
            return $model->$file;
        } else if ($request->hasFile($file) == TRUE && empty($model->id)) {
            $model->$file = $request->file($file)->store($path);
            return $model->$file;
        }
        return null;
    }


    public function getCode(): int
    {
        return $this->code;
    }

    protected function setCode($code)
    {
        $this->code = $code;
    }
}
