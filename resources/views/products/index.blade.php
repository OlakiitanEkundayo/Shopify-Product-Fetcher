<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopify Products</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50">

    <div class="container mx-auto px-4 py-8">

        @if (session('success'))
            <div
                class="alert bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded transition-opacity duration-500 opacity-100">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div
                class="alert bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded transition-opacity duration-500 opacity-100">
                {{ session('error') }}
            </div>
        @endif

        <div class="flex justify-between items-center mb-8">
            <div class="mb-8 ">
                <h1 class="text-3xl font-bold text-gray-800">Shopify Products</h1>
                <p class="text-gray-600 mt-2">Displaying all products from your store</p>
            </div>

            <form action="/sync" method="post" class="inline-block">
                @csrf
                <button type="submit"
                    class="px-4 py-2 rounded-md bg-green-600 text-white font-medium
               hover:bg-green-700 focus:outline-none focus:ring-2
               focus:ring-green-500 focus:ring-offset-2
               transition duration-200 ease-in-out shadow-sm">
                    Sync Products
                </button>
            </form>
        </div>


        @if (count($products) > 0)

            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">

                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                Image
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                Product Name
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                Vendor
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                Type
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                Price
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                Stock
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                Status
                            </th>
                        </tr>
                    </thead>

                    <!-- Table Body -->
                    <tbody class="bg-white divide-y divide-gray-200">

                        @foreach ($products as $product)
                            <tr class="hover:bg-gray-50 transition-colors duration-150">

                                <!-- Image Column -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if (isset($product->image_url))
                                        <img src="{{ $product->image_url }}" alt="{{ $product->title }}"
                                            class="h-16 w-16 object-cover rounded-md border border-gray-200">
                                    @else
                                        <div class="h-16 w-16 bg-gray-100 rounded-md flex items-center justify-center">
                                            <span class="text-gray-400 text-xs">No image</span>
                                        </div>
                                    @endif
                                </td>

                                <!-- Product Name Column -->
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $product->title }}
                                    </div>
                                </td>

                                <!-- Vendor Column -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-700">
                                        {{ $product->vendor ?? 'N/A' }}
                                    </div>
                                </td>

                                <!-- Product Type Column -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-700">
                                        {{ $product->product_type ?? 'Uncategorized' }}
                                    </div>
                                </td>

                                <!-- Price Column -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-semibold text-gray-900">
                                        @if (isset($product->price))
                                            ${{ number_format($product->price, 2) }}
                                        @else
                                            <span class="text-gray-400">N/A</span>
                                        @endif
                                    </div>
                                </td>

                                <!-- Stock Column -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if (isset($product->stock_quantity))
                                        @if ($product->stock_quantity > 0)
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                {{ $product->stock_quantity }} in stock
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                Out of stock
                                            </span>
                                        @endif
                                    @else
                                        <span class="text-gray-400 text-sm">N/A</span>
                                    @endif
                                </td>

                                <!-- Status Column -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($product->status === 'active')
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            Active
                                        </span>
                                    @elseif($product->status === 'draft')
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            Draft
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            {{ ucfirst($product->status) }}
                                        </span>
                                    @endif
                                </td>

                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>

            <!-- Pagination Container -->
            {{-- <div class="mt-6 flex justify-between items-center">

                <!-- LEFT SIDE: Previous Button -->
                <div>
                    <!-- Check if there's a previous page -->
                    @if ($hasPrevPage)
                    <!-- Show the Previous button as a clickable link -->
                        <a href="?page_info={{ $prevPageInfo }}"
                        class="inline-flex items-center px-4 py-2 bg-blue-500 text-white text-sm font-medium rounded-md hover:bg-blue-600 transition-colors duration-150">
                            <!-- Left arrow icon (SVG) -->
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 19l-7-7 7-7"></path>
                            </svg>
                            Previous
                        </a>
                    @else
                    <!-- No previous page - show disabled button -->
                        <span
                        class="inline-flex items-center px-4 py-2 bg-gray-300 text-gray-500 text-sm font-medium rounded-md cursor-not-allowed">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 19l-7-7 7-7"></path>
                            </svg>
                            Previous
                        </span>
                    @endif
                </div> --}}

            <div class="text-sm text-gray-600 mt-2">
                {{-- Showing {{ count($products) }} products --}}
                {{ $products->links() }}
            </div>

            {{-- <div>
                    <!-- Check if there's a next page -->
                    @if ($hasNextPage)
                        <!-- Show the Next button as a clickable link -->
                        <a href="?page_info={{ $nextPageInfo }}"
                            class="inline-flex items-center px-4 py-2 bg-blue-500 text-white text-sm font-medium rounded-md hover:bg-blue-600 transition-colors duration-150">
                            Next
                            <!-- Right arrow icon (SVG) -->
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                </path>
                            </svg>
                        </a>
                    @else
                        <!-- No next page - show disabled button -->
                        <span
                            class="inline-flex items-center px-4 py-2 bg-gray-300 text-gray-500 text-sm font-medium rounded-md cursor-not-allowed">
                            Next
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                </path>
                            </svg>
                        </span>
                    @endif
                </div> --}}

    </div>
@else
    <!-- No Products Message -->
    <div class="bg-white rounded-lg shadow-md p-8 text-center">
        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
            </path>
        </svg>
        <h3 class="mt-2 text-sm font-medium text-gray-900">No products found</h3>
        <p class="mt-1 text-sm text-gray-500">There are no products available to display.</p>
    </div>
    @endif

    </div>

    <script>
        const alerts = document.querySelectorAll('.alert');

        alerts.forEach(alert => {
            setTimeout(() => {

                alert.classList.remove('opacity-100');
                alert.classList.add('opacity-0');

                setTimeout(() => {
                    alert.remove();
                }, 500);
            }, 5000);
        });
    </script>
</body>

</html>
