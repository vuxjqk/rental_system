<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <a href="{{ route('contracts.index') }}"
                    class="text-gray-600 hover:text-gray-900 mr-4 transition duration-200">
                    <i class="fas fa-arrow-left text-lg"></i>
                </a>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    <i class="fas fa-file-contract mr-2 text-blue-600"></i>
                    {{ __('Chi tiết hợp đồng') }}
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Contract Details Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Contract Header -->
                    <div class="border-b border-gray-200 pb-4 mb-6">
                        <h3 class="text-lg font-medium text-gray-900">
                            <i class="fas fa-info-circle mr-2 text-blue-600"></i>
                            Thông tin hợp đồng
                        </h3>
                        <p class="mt-1 text-sm text-gray-600">
                            Chi tiết về hợp đồng cho bất động sản
                            {{ $contract->property->name ?? 'Bất động sản #' . $contract->property->id }}
                        </p>
                    </div>

                    <!-- Contract Details -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Property -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                <i class="fas fa-home mr-1 text-blue-600"></i>
                                Bất động sản
                            </label>
                            <p class="text-gray-900">
                                {{ $contract->property->name ?? 'Bất động sản #' . $contract->property->id }}
                            </p>
                        </div>

                        <!-- Tenant -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                <i class="fas fa-user mr-1 text-green-600"></i>
                                Người thuê
                            </label>
                            <p class="text-gray-900">{{ $contract->tenant->name ?? 'N/A' }}</p>
                        </div>

                        <!-- Landlord -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                <i class="fas fa-user-tie mr-1 text-purple-600"></i>
                                Chủ nhà
                            </label>
                            <p class="text-gray-900">{{ $contract->landlord->name ?? 'N/A' }}</p>
                        </div>

                        <!-- Start Date -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                <i class="fas fa-calendar-alt mr-1 text-blue-600"></i>
                                Ngày bắt đầu
                            </label>
                            <p class="text-gray-900">{{ \Carbon\Carbon::parse($contract->start_date)->format('d/m/Y') }}
                            </p>
                        </div>

                        <!-- End Date -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                <i class="fas fa-calendar-alt mr-1 text-blue-600"></i>
                                Ngày kết thúc
                            </label>
                            <p class="text-gray-900">{{ \Carbon\Carbon::parse($contract->end_date)->format('d/m/Y') }}
                            </p>
                        </div>

                        <!-- Deposit -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                <i class="fas fa-dollar-sign mr-1 text-green-600"></i>
                                Tiền cọc
                            </label>
                            <p class="text-gray-900">{{ number_format($contract->deposit, 2) }} VND</p>
                        </div>

                        <!-- Monthly Rent -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                <i class="fas fa-dollar-sign mr-1 text-green-600"></i>
                                Tiền thuê hàng tháng
                            </label>
                            <p class="text-gray-900">{{ number_format($contract->monthly_rent, 2) }} VND</p>
                        </div>

                        <!-- Status -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                <i class="fas fa-info mr-1 text-green-600"></i>
                                Trạng thái
                            </label>
                            <p class="text-gray-900">
                                @switch($contract->status)
                                    @case('active')
                                        Đang hoạt động
                                    @break

                                    @case('terminated')
                                        Đã chấm dứt
                                    @break

                                    @case('expired')
                                        Hết hạn
                                    @break
                                @endswitch
                            </p>
                        </div>

                        <!-- Contract File -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                <i class="fas fa-file-pdf mr-1 text-yellow-600"></i>
                                Tệp hợp đồng
                            </label>
                            @if ($contract->contract_file_url)
                                <a href="{{ $contract->contract_file_full_url }}" target="_blank"
                                    class="text-blue-600 hover:text-blue-900 flex items-center">
                                    <i class="fas fa-download mr-2"></i>
                                    Tải xuống tệp hợp đồng
                                </a>
                            @else
                                <p class="text-gray-900">Không có tệp hợp đồng</p>
                            @endif
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-200">
                        <a href="{{ route('contracts.index') }}"
                            class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-6 rounded-lg transition duration-200 flex items-center">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Quay lại
                        </a>
                        <a href="{{ route('contracts.edit', $contract) }}"
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
                        <a href="{{ route('contracts.index') }}"
                            class="flex items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition duration-200">
                            <i class="fas fa-list text-blue-600 mr-3"></i>
                            <div>
                                <p class="font-medium text-blue-900">Xem danh sách</p>
                                <p class="text-sm text-blue-700">Quay lại danh sách hợp đồng</p>
                            </div>
                        </a>
                        <a href="{{ route('contracts.edit', $contract) }}"
                            class="flex items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition duration-200">
                            <i class="fas fa-edit text-green-600 mr-3"></i>
                            <div>
                                <p class="font-medium text-green-900">Chỉnh sửa</p>
                                <p class="text-sm text-green-700">Cập nhật thông tin hợp đồng</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
