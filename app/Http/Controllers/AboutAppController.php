<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AboutApp;

class AboutAppController extends Controller
{
    //
    public function getAbouts(){
        $aboutus= AboutApp::first();
    
        return response()->json($aboutus,200);
    }
}
