<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notice;

class NoticeController extends Controller
{
    //
    public function getNotice(){
        $notice = Notice::get();
        return response()->json($notice,200);
    }

}
