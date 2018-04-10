<?php
/**
 * Created by PhpStorm.
 * User: mark
 * Date: 25/03/2018
 * Time: 13:06
 */

namespace App\Http\Controllers;

use App\Repositories\CustomerRepository;
use App\Repositories\ExpenseRepository;
use App\Repositories\OrderRepository;
use Shinobi;

class AdminController extends Controller
{
    public function index()
    {
        if ( Shinobi::can( config('admin.acl.watchtower.index', false) ) ) {
            $links = config('admin.dashboard');
            return view( 'admin.index' )
                ->with('dashboard', $links)
                ->with('title', config('admin.site_title') );
        }

        return view('auth.login', [ 'message' => 'view the dashboard' ]);
    }

    public function viewDashboard()
    {
        if ( Shinobi::can( config('admin.acl.watchtower.index', false) ) ) {
            $newstatus = 'NEW';
            $newOrders = OrderRepository::getOrdersCount($newstatus);
            $completedStatus = 'FULLY PAID';
            $completedOrders = OrderRepository::getOrdersCount($completedStatus);

            $totalExpenses = ExpenseRepository::getTotalExpenses();
            $numberOfNumbers = CustomerRepository::getCustomersCount();

            return view( 'dashboard.dashboard',["neworders" => $newOrders,"completedOrders"=>$completedOrders,"totalExpenses"=>$totalExpenses,"numberOfNumbers"=>$numberOfNumbers] );
        }

        return view('auth.login', [ 'message' => 'view the dashboard' ]);
    }
}