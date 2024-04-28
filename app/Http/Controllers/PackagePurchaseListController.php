<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PackagePurchaseList;
use App\Models\Package;
class PackagePurchaseListController extends Controller
{
   public function purchasePackage(Request $request){
// dd($request->package_id);
    $newPurchase = new PackagePurchaseList;
    $newPurchase->user_id = $request->user()->id;
    $newPurchase->package_id = $request->package_id;
    $newPurchase->save();
    return response()->json($newPurchase, 200);
   }



   public function getMyPurchasePackageList(Request $request)
   {
       $myPackageList = PackagePurchaseList::where('user_id', $request->user()->id)
           ->with('package') // Eager load the 'package' relationship
           ->get();

       return response()->json($myPackageList, 200);
   }

   public function getMyPurchasePackageIds(Request $request)
   {
       $myPackageList = PackagePurchaseList::where('user_id', $request->user()->id)->pluck('package_id');

       return response()->json($myPackageList, 200);
   }


}
