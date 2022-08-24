<?php
namespace App\Repository\Admin\Contract;

use Illuminate\Http\Request;

interface ItemInterface{
    public function findAll(Request $request);
    public function findById($id);
    public function save(Request $request);
    public function update($id,Request $request);
    public function deleteById($id);

    public function getCode();
}
