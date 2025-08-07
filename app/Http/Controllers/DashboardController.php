<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Show the main dashboard based on user role
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->isVendor()) {
            return redirect()->route('vendor.dashboard');
        } else {
            return redirect()->route('customer.dashboard');
        }
    }

    /**
     * Show admin dashboard
     */
    public function adminDashboard()
    {
        $user = Auth::user();
        $totalUsers = \App\Models\User::count();
        $totalCustomers = \App\Models\User::where('role', 'customer')->count();
        $totalVendors = \App\Models\User::where('role', 'vendor')->count();
        $recentUsers = \App\Models\User::latest()->take(5)->get();

        return view('dashboard.admin', compact('user', 'totalUsers', 'totalCustomers', 'totalVendors', 'recentUsers'));
    }

    /**
     * Show vendor dashboard
     */
    public function vendorDashboard()
    {
        $user = Auth::user();
        // Add vendor-specific data here when vendor module is implemented
        return view('dashboard.vendor', compact('user'));
    }

    /**
     * Show customer dashboard
     */
    public function customerDashboard()
    {
        $user = Auth::user();
        // Add customer-specific data here when ticket booking module is implemented
        return view('dashboard.customer', compact('user'));
    }
} 