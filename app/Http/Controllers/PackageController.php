<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\ExamList;
use App\Models\McqList;
use App\Models\Package;


class PackageController extends Controller
{
    public function getcata($id)
    {
        $categories = Category::where('package_id', $id)->get();

        $formattedCategories = $categories->map(function ($category) {
            return [
                'id' => $category->id,
                'name' => $category->name,
                'image' => asset("storage/{$category->image}"), // Assuming images are stored in the "storage" directory
                'package_id' => $category->package_id,
                'created_at' => $category->created_at,
                'updated_at' => $category->updated_at,
            ];
        });

        return response()->json(['data' => $formattedCategories]);
    }



    public function setsub($id)
    {
        $subcategories = SubCategory::where('category_id', $id)->get();

        $formattedSubcategories = $subcategories->map(function ($subcategory) {
            return [
                'id' => $subcategory->id,
                'name' => $subcategory->name,
                'category_id' => $subcategory->category_id,
                'image' => asset("storage/{$subcategory->image}"), // Assuming images are stored in the "storage" directory
                'created_at' => $subcategory->created_at,
                'updated_at' => $subcategory->updated_at,
            ];
        });

        return response()->json(['data' => $formattedSubcategories]);
    }


    public function exam($id)
    {
        $exams = ExamList::where('sub_cat_id', $id)->get();

        $formattedExams = $exams->map(function ($exam) {
            return [
                'id' => $exam->id,
                'sub_cat_id' => $exam->sub_cat_id,
                'title' => $exam->title,
                'image' => asset("storage/{$exam->image}"), // Assuming images are stored in the "storage" directory
                'total_mark'=>$exam->totall_number,
                'exam_time'=>$exam->exam_time,
                'exam_date'=>$exam->exam_date,
                'created_at' => $exam->created_at,
                'updated_at' => $exam->updated_at,
            ];
        });

        return response()->json(['exam' => $formattedExams]);
    }



public function getmcq($id){

    $mcq = McqList::where('exam_list_id',$id)->get();
    return response()->json(['mcq' => $mcq]);

}

public function getAllPackageList () {
    $allPackageList = Package::all()->map(function ($package) {
        $package->package_image = asset('storage/' . $package->package_image); // Include '/storage' part
        return $package;
    });

    return response()->json(['all_package_list' => $allPackageList]);
}


}
