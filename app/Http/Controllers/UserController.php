<?php

namespace App\Http\Controllers;

use App\Models\User;
use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use PhpParser\Builder;

class UserController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $frd = $request->all();
        $users = User::filter($frd)->get();
        //$users = User::get();

        return view('crm.users.index', compact('users'));
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('crm.users.create');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $frd = $request->all();

        $rules = [
            'name' => 'required|min2|max30',
            'email'=>'required',
            'password'=>'requires|min:8',
        ];

        $messages = [
            'name.required'=>'Введите имя!',
            'name.min'=>'Имя должно быть блльше 2 символов!',
            'name.max'=>'Имя должно быть меньше 30 символов!',
            'email.requires'=>'Введите почту!',
            'password.requires'=>'Введите пароль!',
            'password.min'=>'Пароль должен быть больше 8 символов!',
        ];

        Validator::make($frd,$rules,$messages) -> validate();

        $frd['password'] = Hash::make(Arr::get($frd, 'password'));

        $user = new User($frd);
        $user->save();

        return redirect()->route('crm.users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * @param User $user
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(User $user)
    {
        return view('crm.users.edit', compact('user'));
    }

    /**
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, User $user)
    {
        $frd = $request->all();

        $rules = [
            'name' => 'required|min2|max30',
            'email'=>'required',
            'password'=>'requires|min:8',
        ];

        $messages = [
            'name.required'=>'Введите имя!',
            'name.min'=>'Имя должно быть блльше 2 символов!',
            'name.max'=>'Имя должно быть меньше 30 символов!',
            'email.requires'=>'Введите почту!',
            'password.requires'=>'Введите пароль!',
            'password.min'=>'Пароль должен быть больше 8 символов!',
        ];

        Validator::make($frd,$rules,$messages)->validate();

        $user->update($frd);

        return redirect()->back();
    }

    /**
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('crm.users.index')
;    }

    /**
     * @param Builder $query
     * @param array $frd
     * @return Builder
     */
    public function scopeFilter(Builder $query, array $frd): Builder
    {
        foreach ($frd as $key => $value) {

            if (null === $value) {
                continue;
            }
            switch ($key) {
                case 'search':

                    {
                        $query->where(static function (Builder $query) use ($value): Builder {
                            return $query->where('name', 'like', '%' . $value . '%');
                        });
                    }
                    break;
            }
        }
        return $query;
    }
}
