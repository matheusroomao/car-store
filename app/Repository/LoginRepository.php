<?php
namespace App\Repository;

use App\Models\User;
use Exception;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class LoginRepository implements LoginInterface
{
    private $model = User::class;

    public function __construct()
    {
        $this->model = app($this->model);
    }

    public function login(Request $request)
    {

        try {
            $model = $this->model->where('email', $request->email)->first();
            if(empty($model)){
                $this->setCode(404);
                return null;
            }
            if (Hash::check($request->password, $model->password) === true) {
                $token = $model->createToken($model->email . '-' . $model->email);
                $model->token = $token->plainTextToken;
                $model->group = $model->group();
                unset($model->created_at, $model->updated_at,$model->type);
                $this->setCode(200);
                return $model;
            }
            $this->setCode(401);
        } catch (Exception $e) {
            $this->setCode(500);
        }
        return null;
    }

    public function logout(Request $request)
    {
        try {
            $request->user()->tokens()->where('id', $request->user()->currentAccessToken()->id)->delete();
            $this->setCode(204);
            return null;
        } catch (Exception $e) {
            $this->setCode(500);
            return null;
        }
    }

    public function me(Request $request)
    {
        try {
            $model = $request->user();
            unset($model->created_at, $model->updated_at, $model->accessed_at);
            $this->setCode(200);
            return $model;
        } catch (Exception $e) {
            $this->setCode(500);
            return null;
        }
    }

    public function forgotPassword(Request $request)
    {
        try {
            $status = Password::sendResetLink(
                $request->only('email')
            );

            if ($status == Password::RESET_LINK_SENT) {
                $this->setCode(200);
                return null;
            } elseif ($status == Password::RESET_THROTTLED) {
                $this->setCode(409);
                return null;
            }
        } catch (Exception $e) {
            $this->setCode(500);
            return null;
        }
    }

    public function reset(Request $request)
    {
        try {
            $status = Password::reset(
                $request->only('email', 'password', 'password_confirmation', 'token'),
                function ($user) use ($request) {
                    $user->forceFill([
                        'password' => $request->password,
                    ])->save();
                    event(new PasswordReset($user));
                }
            );

            if ($status == Password::PASSWORD_RESET) {
                $this->setCode(200);
                return null;
            } elseif ($status == Password::INVALID_USER) {
                $this->setCode(401);
                return null;
            } elseif ($status == Password::INVALID_TOKEN) {
                $this->setCode(401);
                return null;
            }


            $this->setCode(500);
            return null;
        } catch (Exception $e) {
            $this->setCode(500);
            return null;
        }
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

