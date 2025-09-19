@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Welcome card -->
    <div class="bg-white rounded-xl shadow-sm p-6 mb-6 border border-macgray-200">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="text-2xl font-semibold text-macgray-800">Welcome back, {{ Auth::user()->name }}</h2>
                <p class="text-macgray-500 mt-2">Here's what's happening with your business today.</p>
            </div>
            <button class="mt-4 md:mt-0 px-4 py-2 bg-macblue-500 text-white rounded-md hover:bg-macblue-600 transition-colors flex items-center space-x-2">
                <i data-feather="plus" class="w-4 h-4"></i>
                <span>New Invoice</span>
            </button>
        </div>
    </div>

    <!-- Stats cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <div class="bg-white rounded-xl shadow-sm p-6 border border-macgray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-macgray-500">Total Revenue</p>
                    <p class="text-2xl font-semibold text-macgray-800 mt-1">$24,780</p>
                    <p class="text-xs text-green-500 mt-1 flex items-center">
                        <i data-feather="trending-up" class="w-3 h-3 mr-1"></i>
                        <span>12% from last month</span>
                    </p>
                </div>
                <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center">
                    <i data-feather="dollar-sign" class="text-green-500"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6 border border-macgray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-macgray-500">Outstanding</p>
                    <p class="text-2xl font-semibold text-macgray-800 mt-1">$8,450</p>
                    <p class="text-xs text-red-500 mt-1 flex items-center">
                        <i data-feather="trending-down" class="w-3 h-3 mr-1"></i>
                        <span>5% from last month</span>
                    </p>
                </div>
                <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center">
                    <i data-feather="alert-circle" class="text-red-500"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6 border border-macgray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-macgray-500">Expenses</p>
                    <p class="text-2xl font-semibold text-macgray-800 mt-1">$5,230</p>
                    <p class="text-xs text-yellow-500 mt-1 flex items-center">
                        <i data-feather="trending-up" class="w-3 h-3 mr-1"></i>
                        <span>8% from last month</span>
                    </p>
                </div>
                <div class="w-12 h-12 rounded-full bg-yellow-100 flex items-center justify-center">
                    <i data-feather="credit-card" class="text-yellow-500"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6 border border-macgray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-macgray-500">Profit</p>
                    <p class="text-2xl font-semibold text-macgray-800 mt-1">$19,550</p>
                    <p class="text-xs text-green-500 mt-1 flex items-center">
                        <i data-feather="trending-up" class="w-3 h-3 mr-1"></i>
                        <span>15% from last month</span>
                    </p>
                </div>
                <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center">
                    <i data-feather="bar-chart-2" class="text-blue-500"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent activity and invoices -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent activity -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-macgray-200">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-macgray-800">Recent Activity</h3>
                <a href="#" class="text-sm text-macblue-500 hover:text-macblue-600">View All</a>
            </div>
            <div class="space-y-4">
                <div class="flex items-start">
                    <div class="w-10 h-10 rounded-full bg-purple-100 flex items-center justify-center mr-3 flex-shrink-0">
                        <i data-feather="file-text" class="text-purple-500 w-4 h-4"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-macgray-800">Invoice #INV-2023-0012 was paid</p>
                        <p class="text-xs text-macgray-500 mt-1">Acme Inc. • 2 hours ago</p>
                    </div>
                </div>
                <div class="flex items-start">
                    <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center mr-3 flex-shrink-0">
                        <i data-feather="user-plus" class="text-green-500 w-4 h-4"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-macgray-800">New customer added</p>
                        <p class="text-xs text-macgray-500 mt-1">Stark Industries • 5 hours ago</p>
                    </div>
                </div>
                <div class="flex items-start">
                    <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center mr-3 flex-shrink-0">
                        <i data-feather="dollar-sign" class="text-blue-500 w-4 h-4"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-macgray-800">Payment received</p>
                        <p class="text-xs text-macgray-500 mt-1">Wayne Enterprises • Yesterday</p>
                    </div>
                </div>
                <div class="flex items-start">
                    <div class="w-10 h-10 rounded-full bg-yellow-100 flex items-center justify-center mr-3 flex-shrink-0">
                        <i data-feather="alert-circle" class="text-yellow-500 w-4 h-4"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-macgray-800">Invoice overdue</p>
                        <p class="text-xs text-macgray-500 mt-1">Oscorp Industries • 2 days ago</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent invoices -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-macgray-200">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-macgray-800">Recent Invoices</h3>
                <a href="#" class="text-sm text-macblue-500 hover:text-macblue-600">View All</a>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-macgray-200">
                    <thead>
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-macgray-500 uppercase tracking-wider">Invoice</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-macgray-500 uppercase tracking-wider">Client</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-macgray-500 uppercase tracking-wider">Amount</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-macgray-500 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-macgray-200">
                        <tr>
                            <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-macgray-800">#INV-2023-0015</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-macgray-500">Acme Inc.</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-macgray-500">$2,500.00</td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">Paid</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-macgray-800">#INV-2023-0014</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-macgray-500">Stark Industries</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-macgray-500">$5,750.00</td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-macgray-800">#INV-2023-0013</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-macgray-500">Wayne Enterprises</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-macgray-500">$3,200.00</td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-red-100 text-red-800">Overdue</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-macgray-800">#INV-2023-0012</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-macgray-500">Oscorp Industries</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-macgray-500">$1,800.00</td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">Paid</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection