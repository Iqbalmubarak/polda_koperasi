<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\inventoris;
use App\Models\inventorisDetail;
use Illuminate\Support\Facades\DB;
use \Carbon\Carbon;

class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('backend.index');
    }
}
