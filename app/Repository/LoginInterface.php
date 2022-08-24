<?php
namespace App\Repository;
use Illuminate\Http\Request;

interface LoginInterface{
    public function login(Request $request);
    public function logout(Request $request);
    public function me(Request $request);

    public function getCode();
}
