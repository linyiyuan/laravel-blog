<?php

namespace App\Http\Controllers\Home;

use App\Models\Introduce;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Home\Common\BaseController;

class ResumeController extends BaseController
{
    public function resume()
    {
    	 $introduce = Introduce::find(1);
    	 $parsedown = new \Parsedown();
         $parsedown->setSafeMode(true);

         $introduce->resume = $parsedown->text($introduce->resume);

    	return view('home.resume',compact('introduce'));
    }
}
