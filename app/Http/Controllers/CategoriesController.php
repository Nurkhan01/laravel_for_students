<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Category\BaseController;
use App\Http\Requests\category\CategoryRequest;
use App\Models\Category;
use App\Services\Category\CategoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoriesController extends BaseController
{
    /**
     * @param CategoryRequest $request
     * @return string
     */
    public function store(CategoryRequest $request, CategoryService $categoryService)
    {
        $category = $request->validated();
        if ($category) {
            return $categoryService->store($category);
        }
    }

    /**
     * @param CategoryRequest $request
     * @param Category $category
     * @return string
     */
    public function update(CategoryRequest $request, Category $category)
    {
        $updatedCategory = $request->validated();
        if ($updatedCategory) {
            return $this->service->update($category, $updatedCategory);
        }
    }

    /**
     * @param $id
     * @return string
     */
    public function delete($id)
    {
        $category = Category::find($id);
        if ($category->delete()) {
            return 'successfully deleted';
        } else {
            return 'not deleted';
        }
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function index()
    {
        return Category::all();
    }

    public function categoriesFull(){
        return DB::table('categories')->whereNull('deleted_at')->get();
    }

    public function restoreCategory()
    {
        $categories = Category::withTrashed()->get();
        foreach ($categories as $category) {
            if ($category) {
                $category->restore();
            };
        }
    }

    /**
     * @param $id
     * @return string
     */
    public function productsByCategory($id)
    {
//        SELECT * FROM products WHERE category_id = $id
        $category = Category::find($id);
        return $category ? $category->products : 'ошибка';
    }

    public function getInfo(Request $request)
    {
//        $product = Product::find(1);
//        return $product->client;
        $name = $request->query('name');

        $data = DB::table('orders')
            ->select(
                'clients.last_name_doc',
                'clients.first_name_doc',
                'products.name AS product',
                'categories.name AS Category',)
            ->leftJoin('clients', 'clients.id', '=', 'orders.client_id')
            ->leftJoin('products', 'products.id', '=', 'orders.product_id')
            ->leftJoin('categories', 'categories.id', '=', 'products.category_id')
            ->where('categories.name', '=', $name)
            ->get();

        return $data;
    }
}
