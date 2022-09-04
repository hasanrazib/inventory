<?php

namespace App\Http\Controllers\POS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{

    // view all category
    public function viewAllCategory(){

        $categories = Category::latest()->get();
        return view('backend.category.view_all_categories',compact('categories'));


    }//end method

    // add category
    public function addCategory(){

        return view('backend.category.add_category');
    }// end method


    //insert method
    public function insertCategory(Request $request){

        Category::insert([
            'cat_name' => $request->cat_name,
            'created_by' => Auth::User()->id,
            'created_at' => Carbon::now(),

        ]);
        $notification = array(
            'message' => 'Category Add Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('view.categories')->with($notification);

    }//end method


    //edit method
    public function editCategory($id){

        $category = Category::findOrFail($id);
        return view('backend.category.edit_category',compact('category'));
    }

       // update supplier
       public function updateCategory(Request $request){

        $id = $request->id;
        Category::findOrFail($id)->update([
            'cat_name' => $request->cat_name,
            'updated_by' => Auth::User()->id,
            'updated_at' => Carbon::now()
        ]);

        $notification = array(
            'message' => 'Category Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('view.categories')->with($notification);

    }//end method

    // delete method
      public function deleteCategory($id){

        Category::findOrFail($id)->delete();

         $notification = array(
            'message' => 'Category Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    } // End Method

}
