<?php

namespace App\Repository\Admin\Business;

use App\Models\CarItem;
use App\Repository\AbstractRepository;
use App\Repository\Admin\Contract\CarItemInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function app;

class CarItemRepository extends AbstractRepository implements CarItemInterface
{
    private $model = CarItem::class;
    private array $relationships = ['item', 'car'];
    private array $dependencies = [];
    private array $unique = ['name'];
    private array $upload = [];

    public function __construct()
    {
        $this->model = app($this->model);
        parent::__construct($this->model, $this->relationships, $this->dependencies, $this->unique, $this->upload);
    }

    public function deleteById($id)
    {
        $model = $this->findById($id);
        if (empty($model)) {
            $this->setCode(404);
            return null;
        }
        if ($this->verifyUser() != TRUE) {
            $this->setCode(422);
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
        if ($this->verifyUser() != TRUE) {
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
        if ($this->verifyUser() != TRUE) {
            $this->setCode(422);
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

    public function verifyUser()
    {
        if (Auth::user()->type != "ADMIN") {
            $this->model->query()->with($this->relationships)->whereHas('car', fn ($q) => $q
                ->where('user_id', Auth::user()->id));
            return false;
        }
        return true;
    }
}
