<div>
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
        Dashboard
    </h2>
    <!-- Cards -->
    <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4">
        <!-- Card -->
        <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
            <div class="p-3 mr-4 text-orange-500 bg-orange-100 rounded-full dark:text-orange-100 dark:bg-orange-500">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z">
                    </path>
                </svg>
            </div>
            <div>
                <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                    Total clients
                </p>
                <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                    {{ $totalUsers }}
                </p>
            </div>
        </div>
        <!-- Card -->
        <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
            <div class="p-3 mr-4 text-green-500 bg-green-100 rounded-full dark:text-green-100 dark:bg-green-500">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"
                        clip-rule="evenodd"></path>
                </svg>
            </div>
            <div>
                <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                    Total Sales
                </p>
                <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                    $ {{ number_format($totalRevenue, 2) }}
                </p>
            </div>
        </div>
        <!-- Card -->
        <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
            <div class="p-3 mr-4 text-blue-500 bg-blue-100 rounded-full dark:text-blue-100 dark:bg-blue-500">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z">
                    </path>
                </svg>
            </div>
            <div>
                <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                    Total Products
                </p>
                <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                    {{ $totalProducts }}
                </p>
            </div>
        </div>
        <!-- Card -->
        <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
            <div class="p-3 mr-4 text-teal-500 bg-teal-100 rounded-full dark:text-teal-100 dark:bg-teal-500">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zM7 8H5v2h2V8zm2 0h2v2H9V8zm6 0h-2v2h2V8z"
                        clip-rule="evenodd"></path>
                </svg>
            </div>
            <div>
                <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                    Pending reviews
                </p>
                <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                    {{ $pendingReviews }}
                </p>
            </div>
        </div>
    </div>

    <!-- New Table -->
    <div class="w-full overflow-hidden rounded-lg shadow-xs">
        <div class="w-full overflow-x-auto">
            <table class="w-full whitespace-no-wrap">
                <thead>
                    <tr
                        class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                        <th class="px-4 py-3">Client</th>
                        <th class="px-4 py-3">Amount</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Date</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    @forelse($recentOrders as $recentOrder)
                        <tr class="text-gray-700 dark:text-gray-400">
                            <td class="px-4 py-3">
                                <div class="flex items-center text-sm">
                                    <div>
                                        <p class="font-semibold"> {{ $recentOrder->user->email }} </p>
                                        <p class="text-xs text-gray-600 dark:text-gray-400">
                                            {{ $recentOrder->payment_status }}
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-sm">
                                ${{ number_format($recentOrder->total_price, 2) }}
                            </td>
                            <td class="px-4 py-3 text-xs">
                                <span class="@if ($recentOrder->status === 'pending') px-2 py-1 font-semibold leading-tight text-gray-700 bg-gray-100 rounded-full dark:text-gray-100 dark:bg-gray-700
                                @elseif ($recentOrder->status === 'processed') px-2 py-1 font-semibold leading-tight text-orange-700 bg-orange-100 rounded-full dark:text-white dark:bg-orange-600
                                    @elseif ($recentOrder->status === 'shipped') px-2 py-1 font-semibold leading-tight text-orange-700 bg-orange-100 rounded-full dark:text-white dark:bg-orange-600
                                        @elseif ($recentOrder->status === 'delivered') px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100
                                            @elseif ($recentOrder->status === 'cancelled') px-2 py-1 font-semibold leading-tight text-red-700 bg-red-100 rounded-full dark:text-red-100 dark:bg-red-700
                                                    @else px-2 py-1 font-semibold leading-tight text-gray-700 bg-gray-100 rounded-full dark:text-gray-100 dark:bg-gray-700
                                                @endif">
                                    {{ $recentOrder->status }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-sm">
                                {{ $recentOrder->created_at }}
                            </td>
                        </tr>
                    @empty
                    <tr class="text-gray-700 dark:text-gray-400">
                        <td class="px-4 py-3">
                            <div class="flex items-center text-sm">
                                <span class="flex items-center col-span-3">
                                    No recent Orders
                                </span>
                            </div>
                        </td>
                    </tr>
                    @endForelse

                </tbody>
            </table>
        </div>
        <div
            class="grid px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">
            <a href="{{ route('admin.orders') }}">
                <span class="flex text-purple-600 items-center col-span-3">
                    See orders
                </span>
            </a>

        </div>
    </div>

    <!-- Charts -->
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
        Charts
    </h2>
    <div class="grid gap-6 mb-8 md:grid-cols-2">
        <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
            <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">
                Sales per category
            </h4>
            <canvas id="revpie"></canvas>
            <div class="flex justify-center mt-4 space-x-3 text-sm text-gray-600 dark:text-gray-400">

            </div>
        </div>
        <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
            <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">
                Revenue per month
            </h4>
            <canvas id="linegraph"></canvas>
            <div class="flex justify-center mt-4 space-x-3 text-sm text-gray-600 dark:text-gray-400">
                <!-- Chart legend -->
                <div class="flex items-center">
                    <span class="inline-block w-3 h-3 mr-1 bg-teal-600 rounded-full"></span>
                    <span>revenue</span>
                </div>
            </div>
        </div>
    </div>

    <script>
        setTimeout(() => {
            const categoryData = @json($categoryChartData);
            const pieConfig = {
                type: "doughnut",
                data: {
                    datasets: [
                        {
                            data: categoryData.map((item) => item.quantity),
                            backgroundColor: ["#0694a2", "#1c64f2", "#7e3af2"],
                            label: 'revenue',
                        },
                    ],
                    labels: categoryData.map((item) => item.label),
                },
                options: {
                    responsive: true,
                    cutoutPercentage: 80,
                    legend: {
                        display: false,
                    },
                },
            };

            // change this to the id of your chart element in HMTL
            const pieCtx = document.getElementById("revpie");
            window.myPie = new Chart(pieCtx, pieConfig);
        }, 200);


    </script>


    <script>
        setTimeout(() => {
            const lineGraphData = @json($lineGraphData);
            const lineConfig = {
                type: 'line',
                data: {
                    labels: lineGraphData.map((item) => item.month),
                    datasets: [
                        {
                            label: 'Monthly Sales ($)',
                            backgroundColor: '#0694a2',
                            borderColor: '#0694a2',
                            data: lineGraphData.map((item) => item.revenue),
                            fill: false,
                        },
                    ],
                },
                options: {
                    responsive: true,
                    legend: {
                        display: false,
                    },
                    tooltips: {
                        mode: 'index',
                        intersect: false,
                    },
                    hover: {
                        mode: 'nearest',
                        intersect: true,
                    },
                    scales: {
                        x: {
                            display: true,
                            scaleLabel: {
                                display: true,
                                labelString: 'Month',
                            },
                        },
                        y: {
                            display: true,
                            scaleLabel: {
                                display: true,
                                labelString: 'Value',
                            },
                        },
                    },
                },
            }
            const lineCtx = document.getElementById('linegraph')
            window.myLine = new Chart(lineCtx, lineConfig)
        }, 2000);


    </script>
</div>