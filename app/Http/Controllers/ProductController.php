<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Dotenv\Validator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use PhpParser\Builder;

class ProductController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $frd = $request->all();
        $products = Product::filter($frd)->get();
        //$products= Product::get();

        return view('crm.products.index', compact('products'));
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('crm.products.create');
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
            'price'=>'required',
        ];

        $messages = [
            'name.required'=>'Введите название продукта!',
            'name.min'=>'Название должно быть блльше 2 символов!',
            'name.max'=>'Название должно быть меньше 30 символов!',
            'price.requires'=>'Введите стоимость продукта!',
        ];

        Validator::make($frd,$rules,$messages) -> validate();

        $frd['password'] = Hash::make(Arr::get($frd, 'password'));

        $product = new User($frd);
        $product->save();

        return redirect()->route('crm.products.index');
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
     * @param Product $product
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Product $product)
    {
        return view('crm.products.edit', compact('product'));
    }

    /**
     * @param Request $request
     * @param Product $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Product $product)
    {
        $frd = $request->all();

        $rules = [
            'name' => 'required|min2|max30',
            'price'=>'required',
        ];

        $messages = [
            'name.required'=>'Введите название продукта!',
            'name.min'=>'Название должно быть блльше 2 символов!',
            'name.max'=>'Название должно быть меньше 30 символов!',
            'price.requires'=>'Введите стоимость продукта!',
        ];

        Validator::make($frd,$rules,$messages)->validate();

        $product->update($frd);

        return redirect()->back();
    }

    /**
     * @param Product $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('crm.products.index');
    }

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
