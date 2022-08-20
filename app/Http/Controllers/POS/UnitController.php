<?php

namespace App\Http\Controllers\POS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Unit;
use Auth;

class UnitController extends Controller
{
    // view all units
    public function viewAllUnit(){

        $units = Unit::latest()->get();
        return view('backend.unit.view_all_units',compact('units'));
    }// end method

    // add unit method
    public function addUnit(){

        return view('backend.unit.add_unit');
    }

    // insert data
    public function insertUnit(Request $request){

        Unit::insert([
            'unit_name' => $request->unit_name,
            'created_by' => Auth::User()->id,
            'created_at' => Carbon::now(),

        ]);
        $notification = array(
            'message' => 'Unit Add Successfully', 
            'alert-type' => 'success'
        );

        return redirect()->route('view.units')->with($notification);
    }//end method


    //edit method
    public function editUnit($id){
        
        $unit = Unit::findOrFail($id);
        return view('backend.unit.edit_unit',compact('unit'));
    }


    // update supplier
    public function updateUnit(Request $request){

        $id = $request->id;
        Unit::findOrFail($id)->update([
            'unit_name' => $request->unit_name,
            'updated_by' => Auth::User()->id,
            'updated_at' => Carbon::now()
        ]);

        $notification = array(
            'message' => 'Unit Updated Successfully', 
            'alert-type' => 'success'
        );

        return redirect()->route('view.units')->with($notification);

    }//end method

    // delete method
      public function deleteUnit($id){

        Unit::findOrFail($id)->delete();

         $notification = array(
            'message' => 'Unit Deleted Successfully', 
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);       

    } // End Method

}
