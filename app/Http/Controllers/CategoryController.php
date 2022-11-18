<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class CategoryController extends Controller
{
    //direct list page
    public function list(){
        // dd(request('key')); //for testing data output
        $categories = Category::when(request('key'),function($query){//for data searching
            $query->where('name','like','%'.request('key').'%');
        })->orderBy('id','desc')->paginate(5); //for show data
        // dd($categories);//must be collection
        return view('admin.category.list',compact('categories'));
    }

    //direct create page
    public function createPage(){
        return view('admin.category.create');
    }

    //category create
    public function create(Request $request){
        $this->categoryValidationCheck($request);
        $data = $this->requestCategoryData($request); //to array format
        Category::create($data); //insert data
        return redirect()->route('category#list');
    }

    //edit page
    public function edit($id){
        $category = Category::where('id',$id)->first();
        return view('admin.category.edit',compact('category'));
    }

    //delete category
    public function delete($id){
        // dd($id);
        Category::where('id',$id)->delete(); //id from model
        return back()->with(['deleteSuccess' => 'Category deleted...']);
    }

    //update category
    public function update(Request $request){
        // dd($request->all()); test output data
        $this->categoryValidationCheck($request);
        $data = $this->requestCategoryData($request); //to array format
        Category::where('id',$request->categoryId)->update($data);
        return redirect()->route('category#list');
    }

    //category validation check
    private function categoryValidationCheck($request){
        Validator::make($request->all(), [
            'categoryName' => 'required | min:4 | unique:categories,name,'.$request->categoryId
        ])->validate();
    }
     // request category data
    private function requestCategoryData($request){
        return [
            'name' => $request -> categoryName
        ];
    }
}
