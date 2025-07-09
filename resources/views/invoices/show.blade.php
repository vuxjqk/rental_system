<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <a href="{{ route('invoices.index') }}"
                    class="text-gray-600 hover:text-gray-900 mr-4 transition duration-200">
                    <i class="fas fa-arrow-left text-lg"></i>
                </a>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    <i class="fas fa-file-invoice mr-2 text-blue-600"></i>
                    {{ __('Chi tiết hóa đơn') }}
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Invoice Details Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Invoice Header -->
                    <div class="border-b border-gray-200 pb-4 mb-6">
                        <h3 class="text-lg font-medium text-gray-900">
                            <i class="fas fa-info-circle mr-2 text-blue-600"></i>
                            Thông tin hóa đơn
                        </h3>
                        <p class="mt-1 text-sm text-gray-600">
                            Chi tiết về hóa đơn #{{ $invoice->id }}
                        </p>
                    </div>

                    <!-- Invoice Details -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Contract -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                <i class="fas fa-file-contract mr-1 text-blue-600"></i>
                                Hợp đồng
                            </label>
                            <p class="text-gray-900">
                                Hợp đồng #{{ $invoice->contract->id ?? 'N/A' }}
                            </p>
                        </div>

                        <!-- Tenant -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                <i class="fas fa-user mr-1 text-green-600"></i>
                                Người thuê
                            </label>
                            <p class="text-gray-900">{{ $invoice->tenant->name ?? 'N/A' }}</p>
                        </div>

                        <!-- Landlord -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                <i class="fas fa-user-tie mr-1 text-purple-600"></i>
                                Chủ nhà
                            </label>
                            <p class="text-gray-900">{{ $invoice->contract->landlord->name ?? 'N/A' }}</p>
                        </div>

                        <!-- Total Amount -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                <i class="fas fa-dollar-sign mr-1 text-green-600"></i>
                                Tổng số tiền
                            </label>
                            <p class="text-gray-900">{{ number_format($invoice->total_amount, 2) }} VND</p>
                        </div>

                        <!-- Due Date -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                <i class="fas fa-calendar-alt mr-1 text-blue-600"></i>
                                Ngày đến hạn
                            </label>
                            <p class="text-gray-900">{{ \Carbon\Carbon::parse($invoice->due_date)->format('d/m/Y') }}
                            </p>
                        </div>

                        <!-- Status -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                <i class="fas fa-info mr-1 text-green-600"></i>
                                Trạng thái
                            </label>
                            <p class="text-gray-900">
                                @switch($invoice->status)
                                    @case('pending')
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            Chờ xử lý
                                        </span>
                                    @break

                                    @case('paid')
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Đã thanh toán
                                        </span>
                                    @break

                                    @case('overdue')
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            Quá hạn
                                        </span>
                                    @break
                                @endswitch
                            </p>
                        </div>
                    </div>

                    <!-- Invoice Items -->
                    <div class="mt-8">
                        <h4 class="text-md font-medium text-gray-900 mb-4">
                            <i class="fas fa-list-ul mr-2 text-purple-600"></i>
                            Chi tiết hóa đơn
                        </h4>
                        @if ($invoice->items->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                <i class="fas fa-align-left mr-1"></i>
                                                Mô tả
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                <i class="fas fa-dollar-sign mr-1"></i>
                                                Số tiền (VND)
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach ($invoice->items as $item)
                                            <tr class="hover:bg-gray-50 transition duration-150 ease-in-out">
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                    {{ $item->description }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                    {{ number_format($item->amount, 2) }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-gray-600">Không có chi tiết hóa đơn nào.</p>
                        @endif
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-200">
                        <a href="{{ route('invoices.index') }}"
                            class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-6 rounded-lg transition duration-200 flex items-center">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Quay lại
                        </a>
                        <a href="{{ route('invoices.edit', $invoice) }}"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg transition duration-200 flex items-center">
                            <i class="fas fa-edit mr-2"></i>
                            Chỉnh sửa
                        </a>
                    </div>
                </div>
            </div>

            <!-- Quick Actions Card -->
            <div class="mt-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">
                        <i class="fas fa-bolt mr-2 text-yellow-600"></i>
                        Thao tác nhanh
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <a href="{{ route('invoices.index') }}"
                            class="flex items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition duration-200">
                            <i class="fas fa-list text-blue-600 mr-3"></i>
                            <div>
                                <p class="font-medium text-blue-900">Xem danh sách</p>
                                <p class="text-sm text-blue-700">Quay lại danh sách hóa đơn</p>
                            </div>
                        </a>
                        <a href="{{ route('invoices.edit', $invoice) }}"
                            class="flex items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition duration-200">
                            <i class="fas fa-edit text-green-600 mr-3"></i>
                            <div>
                                <p class="font-medium text-green-900">Chỉnh sửa</p>
                                <p class="text-sm text-green-700">Cập nhật thông tin hóa đơn</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
