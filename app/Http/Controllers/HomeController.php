<?php

namespace App\Http\Controllers;

use App\Services\Core\HomeService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $homeService;

    public function __construct(HomeService $homeService)
    {
        $this->middleware(['auth', 'verified'])->only('home');
        $this->homeService = $homeService;
    }

    /**
     * Redirect to home page
     */
    public function redirectHome()
    {
        return redirect()->route('home');
    }

    /**
     * Show home page
     */
    public function returnHome()
    {
        $data = $this->homeService->getHomeData();
        return view('page.home', $data);
    }
}
