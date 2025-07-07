@extends('tenant.layouts.app')

@section('title', 'Chi tiết phòng trọ')

@section('content')
    <div class="min-h-screen bg-gray-50">
        <!-- Header với breadcrumb -->
        <div class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <nav class="flex items-center space-x-2 text-sm text-gray-500">
                        <a href="#" class="hover:text-blue-600 transition-colors">
                            <i class="fas fa-home"></i>
                            Trang chủ
                        </a>
                        <i class="fas fa-chevron-right text-xs"></i>
                        <a href="#" class="hover:text-blue-600 transition-colors">
                            Danh sách phòng
                        </a>
                        <i class="fas fa-chevron-right text-xs"></i>
                        <span class="text-gray-900 font-medium">Chi tiết phòng</span>
                    </nav>

                    <div class="flex items-center space-x-3">
                        <button class="p-2 text-gray-400 hover:text-red-500 transition-colors" title="Yêu thích">
                            <i class="far fa-heart text-xl"></i>
                        </button>
                        <button class="p-2 text-gray-400 hover:text-blue-500 transition-colors" title="Chia sẻ">
                            <i class="fas fa-share-alt text-xl"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Cột chính - Thông tin chi tiết -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Gallery ảnh -->
                    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
                        @if ($property->images->isNotEmpty())
                            <div class="relative">
                                <!-- Ảnh chính -->
                                <div class="aspect-w-16 aspect-h-9 bg-gray-200">
                                    <img id="mainImage" src="{{ $property->images->first()->image_full_url }}"
                                        alt="Ảnh phòng trọ" class="w-full h-96 object-cover">
                                </div>

                                <!-- Overlay với số lượng ảnh -->
                                <div
                                    class="absolute bottom-4 right-4 bg-black bg-opacity-60 text-white px-3 py-1 rounded-full text-sm">
                                    <i class="fas fa-camera mr-1"></i>
                                    {{ $property->images->count() }} ảnh
                                </div>

                                <!-- Nút xem toàn bộ ảnh -->
                                <button
                                    class="absolute bottom-4 left-4 bg-white text-gray-800 px-4 py-2 rounded-full text-sm font-medium hover:bg-gray-100 transition-colors">
                                    <i class="fas fa-expand mr-2"></i>
                                    Xem tất cả ảnh
                                </button>
                            </div>

                            <!-- Thumbnail ảnh -->
                            @if ($property->images->count() > 1)
                                <div class="p-4 bg-gray-50">
                                    <div class="flex space-x-2 overflow-x-auto">
                                        @foreach ($property->images as $image)
                                            <img src="{{ $image->image_full_url }}" alt="Ảnh {{ $loop->index + 1 }}"
                                                class="w-20 h-20 object-cover rounded-lg cursor-pointer hover:opacity-80 transition-opacity flex-shrink-0 {{ $loop->first ? 'ring-2 ring-blue-500' : '' }}"
                                                onclick="changeMainImage(this.src, this)">
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        @else
                            <div class="h-96 bg-gray-200 flex items-center justify-center">
                                <div class="text-center text-gray-500">
                                    <i class="fas fa-image text-4xl mb-2"></i>
                                    <p>Chưa có ảnh</p>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Thông tin cơ bản -->
                    <div class="bg-white rounded-2xl shadow-sm p-6">
                        <div class="mb-6">
                            <div class="flex items-center justify-between mb-4">
                                <h1 class="text-2xl font-bold text-gray-900">
                                    {{ ucfirst($property->type) }} tại {{ $property->location->name ?? 'Chưa xác định' }}
                                </h1>
                                <span
                                    class="px-3 py-1 rounded-full text-sm font-medium
                                {{ $property->status === 'available' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $property->status === 'available' ? 'Còn trống' : 'Đã cho thuê' }}
                                </span>
                            </div>

                            <div class="flex items-center text-gray-600 mb-4">
                                <i class="fas fa-map-marker-alt mr-2"></i>
                                <span>{{ $property->address_detail }}</span>
                            </div>

                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                                <div class="bg-blue-50 rounded-lg p-4 text-center">
                                    <i class="fas fa-dollar-sign text-blue-600 text-xl mb-2"></i>
                                    <div class="text-sm text-gray-600">Giá thuê</div>
                                    <div class="text-lg font-bold text-blue-600">{{ number_format($property->price) }}đ
                                    </div>
                                </div>

                                <div class="bg-green-50 rounded-lg p-4 text-center">
                                    <i class="fas fa-ruler-combined text-green-600 text-xl mb-2"></i>
                                    <div class="text-sm text-gray-600">Diện tích</div>
                                    <div class="text-lg font-bold text-green-600">{{ $property->area }}m²</div>
                                </div>

                                <div class="bg-purple-50 rounded-lg p-4 text-center">
                                    <i class="fas fa-users text-purple-600 text-xl mb-2"></i>
                                    <div class="text-sm text-gray-600">Sức chứa</div>
                                    <div class="text-lg font-bold text-purple-600">{{ $property->max_occupants }} người
                                    </div>
                                </div>

                                <div class="bg-orange-50 rounded-lg p-4 text-center">
                                    <i class="fas fa-home text-orange-600 text-xl mb-2"></i>
                                    <div class="text-sm text-gray-600">Loại phòng</div>
                                    <div class="text-lg font-bold text-orange-600">{{ ucfirst($property->type) }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Mô tả -->
                    <div class="bg-white rounded-2xl shadow-sm p-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-4">
                            <i class="fas fa-info-circle mr-2 text-blue-600"></i>
                            Mô tả chi tiết
                        </h2>
                        <div class="text-gray-700 leading-relaxed">
                            @if ($property->description)
                                {!! nl2br(e($property->description)) !!}
                            @else
                                <p class="text-gray-500 italic">Chưa có mô tả chi tiết.</p>
                            @endif
                        </div>
                    </div>

                    <!-- Tiện ích -->
                    <div class="bg-white rounded-2xl shadow-sm p-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-4">
                            <i class="fas fa-star mr-2 text-yellow-500"></i>
                            Tiện ích
                        </h2>
                        @if ($property->amenities->isNotEmpty())
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                                @foreach ($property->amenities as $amenity)
                                    <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                        <i class="fas fa-check-circle text-green-500 mr-3"></i>
                                        <span class="text-gray-700">{{ $amenity->name }}</span>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500 italic">Chưa có thông tin tiện ích.</p>
                        @endif
                    </div>

                    <!-- Thông tin chủ trọ -->
                    <div class="bg-white rounded-2xl shadow-sm p-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-4">
                            <i class="fas fa-user-tie mr-2 text-blue-600"></i>
                            Thông tin chủ trọ
                        </h2>
                        <div class="flex items-center space-x-4">
                            <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-user text-blue-600 text-2xl"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900">{{ $property->landlord->name ?? 'Chưa xác định' }}
                                </h3>
                                <p class="text-gray-600">Chủ trọ</p>
                                <div class="flex items-center mt-2 space-x-4">
                                    <button
                                        class="flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                        <i class="fas fa-phone mr-2"></i>
                                        Liên hệ
                                    </button>
                                    <button
                                        class="flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                                        <i class="fas fa-comment mr-2"></i>
                                        Nhắn tin
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Cột bên - Thông tin liên hệ và bản đồ -->
                <div class="lg:col-span-1 space-y-6">
                    <!-- Card liên hệ nhanh -->
                    <div class="bg-white rounded-2xl shadow-sm p-6 sticky top-8">
                        <div class="text-center mb-6">
                            <div class="text-3xl font-bold text-blue-600 mb-2">
                                {{ number_format($property->price) }}đ
                            </div>
                            <div class="text-gray-600">/ tháng</div>
                        </div>

                        <div class="space-y-4">
                            <button
                                class="w-full bg-blue-600 text-white py-3 rounded-lg font-medium hover:bg-blue-700 transition-colors">
                                <i class="fas fa-phone mr-2"></i>
                                Gọi ngay
                            </button>

                            <button
                                class="w-full bg-green-600 text-white py-3 rounded-lg font-medium hover:bg-green-700 transition-colors">
                                <i class="fas fa-comment mr-2"></i>
                                Nhắn tin
                            </button>

                            <button
                                class="w-full border border-gray-300 text-gray-700 py-3 rounded-lg font-medium hover:bg-gray-50 transition-colors">
                                <i class="fas fa-calendar mr-2"></i>
                                Đặt lịch xem
                            </button>
                        </div>

                        <div class="mt-6 pt-6 border-t">
                            <div class="flex items-center justify-between text-sm text-gray-600 mb-2">
                                <span>Trạng thái:</span>
                                <span
                                    class="font-medium {{ $property->status === 'available' ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $property->status === 'available' ? 'Còn trống' : 'Đã cho thuê' }}
                                </span>
                            </div>

                            <div class="flex items-center justify-between text-sm text-gray-600">
                                <span>Cập nhật:</span>
                                <span>{{ $property->updated_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Bản đồ -->
                    <div class="bg-white rounded-2xl shadow-sm p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">
                            <i class="fas fa-map-marker-alt mr-2 text-red-500"></i>
                            Vị trí
                        </h3>
                        <div class="bg-gray-200 rounded-lg h-48 flex items-center justify-center">
                            <div class="text-center text-gray-500">
                                <i class="fas fa-map text-3xl mb-2"></i>
                                <p>Bản đồ</p>
                                <p class="text-sm">{{ $property->address_detail }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Thông tin bổ sung -->
                    <div class="bg-white rounded-2xl shadow-sm p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">
                            <i class="fas fa-info-circle mr-2 text-blue-600"></i>
                            Thông tin bổ sung
                        </h3>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-gray-600">Mã phòng:</span>
                                <span class="font-medium">#{{ $property->id }}</span>
                            </div>

                            <div class="flex items-center justify-between">
                                <span class="text-gray-600">Khu vực:</span>
                                <span class="font-medium">{{ $property->location->name ?? 'Chưa xác định' }}</span>
                            </div>

                            <div class="flex items-center justify-between">
                                <span class="text-gray-600">Loại hình:</span>
                                <span class="font-medium">{{ ucfirst($property->type) }}</span>
                            </div>

                            @if ($property->location && $property->location->parent)
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-600">Quận/Huyện:</span>
                                    <span class="font-medium">{{ $property->location->parent->name }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function changeMainImage(src, element) {
            // Thay đổi ảnh chính
            document.getElementById('mainImage').src = src;

            // Cập nhật border cho thumbnail
            document.querySelectorAll('.ring-2').forEach(el => {
                el.classList.remove('ring-2', 'ring-blue-500');
            });
            element.classList.add('ring-2', 'ring-blue-500');
        }
    </script>
@endsection
