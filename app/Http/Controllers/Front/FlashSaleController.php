<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;

use App\Repositories\FlashSaleRepository;

use Carbon\Carbon;

class FlashSaleController extends Controller
{

    private $flashSaleRepository;

    public function __construct(FlashSaleRepository $flashSaleRepo)
    {
        $this->flashSaleRepository = $flashSaleRepo;
    }

    public function index(Request $request)
    {
    	$cur =  processTime( Carbon::now() );
    	$time01 = $cur;
    	$time02 = $cur->copy()->addHours(2);
    	$time03 = $cur->copy()->addHours(4);
    	$time04 = $cur->copy()->addHours(6);
    	$time05 = $cur->copy()->addHours(8);

        //取查询参数
        $inputs = $request->all();
        $time_begin = $time01;
        //$time_end = $time02;
        if (array_key_exists('time_begin', $inputs) && !empty($inputs['time_begin'])) {
            $time_begin = $inputs['time_begin'];
            //$time_begin = processTime( Carbon::parse($inputs['time_begin']) );
            //$time_end = $time_begin->copy()->addHours(2);
        }
        $sales = $this->flashSaleRepository->salesBetweenTime(0, 20, $time_begin);
    	return view(frontView('flashsales.index'), compact('time01', 'time02', 'time03', 'time04', 'time05', 'sales', 'time_begin'));
    }

}
