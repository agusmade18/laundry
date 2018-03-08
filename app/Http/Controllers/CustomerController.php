<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Customer;

class CustomerController extends Controller
{
    /**
   * Create a new controller instance.
   *
   * @return void
   */
  private $dateNow;
  public function __construct()
  {
      $this->middleware('auth');
      $this->dateNow = Carbon::now();
  }

  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Http\Response
   */

  public function index()
  {
    $i = 1;
  	$custs = Customer::all();
  	return view('customer.view', compact('custs', 'i'));
  }
}
