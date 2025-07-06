<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <a href="{{ route('properties.index') }}"
                    class="text-gray-600 hover:text-gray-900 mr-4 transition duration-200">
                    <i class="fas fa-arrow-left text-lg"></i>
                </a>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    <i class="fas fa-home mr-2 text-blue-600"></i>
                    {{ __('Chi tiết bất động sản') }}
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Property Details Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Property Header -->
                    <div class="border-b border-gray-200 pb-4 mb-6">
                        <h3 class="text-lg font-medium text-gray-900">
                            <i class="fas fa-info-circle mr-2 text-blue-600"></i>
                            Thông tin bất động sản
                        </h3>
                        <p class="mt-1 text-sm text-gray-600">
                            Chi tiết về bất động sản tại {{ $property->address_detail }}
                        </p>
                    </div>

                    <!-- Property Details -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Landlord -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                <i class="fas fa-user mr-1 text-blue-600"></i>
                                Chủ nhà
                            </label>
                            <p class="text-gray-900">{{ $property->landlord->name }}</p>
                        </div>

                        <!-- Location -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                <i class="fas fa-map-marker-alt mr-1 text-green-600"></i>
                                Vị trí
                            </label>
                            <p class="text-gray-900">
                                {{ $property->location->name }}
                                ({{ $property->location->type == 'city' ? 'Thành phố' : ($property->location->type == 'district' ? 'Quận/Huyện' : 'Phường/Xã') }})
                            </p>
                        </div>

                        <!-- Address Detail -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                <i class="fas fa-home mr-1 text-purple-600"></i>
                                Địa chỉ chi tiết
                            </label>
                            <p class="text-gray-900">{{ $property->address_detail }}</p>
                        </div>

                        <!-- Property Type -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                <i class="fas fa-building mr-1 text-blue-600"></i>
                                Loại bất động sản
                            </label>
                            <p class="text-gray-900">
                                @switch($property->type)
                                    @case('single_room')
                                        Phòng đơn
                                    @break

                                    @case('shared_room')
                                        Phòng ghép
                                    @break

                                    @case('apartment')
                                        Căn hộ
                                    @break

                                    @case('whole_house')
                                        Nhà nguyên căn
                                    @break
                                @endswitch
                            </p>
                        </div>

                        <!-- Price -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                <i class="fas fa-dollar-sign mr-1 text-green-600"></i>
                                Giá thuê
                            </label>
                            <p class="text-gray-900">{{ number_format($property->price, 2) }} VND</p>
                        </div>

                        <!-- Area -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                <i class="fas fa-ruler-combined mr-1 text-purple-600"></i>
                                Diện tích
                            </label>
                            <p class="text-gray-900">{{ $property->area }} m²</p>
                        </div>

                        <!-- Max Occupants -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                <i class="fas fa-users mr-1 text-blue-600"></i>
                                Số người tối đa
                            </label>
                            <p class="text-gray-900">{{ $property->max_occupants }}</p>
                        </div>

                        <!-- Status -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                <i class="fas fa-info mr-1 text-green-600"></i>
                                Trạng thái
                            </label>
                            <p class="text-gray-900">
                                @switch($property->status)
                                    @case('available')
                                        Sẵn sàng
                                    @break

                                    @case('rented')
                                        Đã thuê
                                    @break

                                    @case('maintenance')
                                        Bảo trì
                                    @break
                                @endswitch
                            </p>
                        </div>

                        <!-- Description -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                <i class="fas fa-comment mr-1 text-purple-600"></i>
                                Mô tả
                            </label>
                            <p class="text-gray-900">{{ $property->description ?? 'Không có mô tả' }}</p>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-200">
                        <a href="{{ route('properties.index') }}"
                            class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-6 rounded-lg transition duration-200 flex items-center">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Quay lại
                        </a>
                        <a href="{{ route('properties.edit', $property) }}"
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
                        <a href="{{ route('properties.index') }}"
                            class="flex items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition duration-200">
                            <i class="fas fa-list text-blue-600 mr-3"></i>
                            <div>
                                <p class="font-medium text-blue-900">Xem danh sách</p>
                                <p class="text-sm text-blue-700">Quay lại danh sách bất động sản</p>
                            </div>
                        </a>
                        <a href="{{ route('properties.edit', $property) }}"
                            class="flex items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition duration-200">
                            <i class="fas fa-edit text-green-600 mr-3"></i>
                            <div>
                                <p class="font-medium text-green-900">Chỉnh sửa</p>
                                <p class="text-sm text-green-700">Cập nhật thông tin bất động sản</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
