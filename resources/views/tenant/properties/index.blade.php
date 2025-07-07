@extends('tenant.layouts.app')

@section('title', 'Danh sách phòng trọ')

@section('content')
    <div class="min-h-screen bg-gray-50">
        <!-- Header -->
        <div class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <div class="flex items-center">
                        <h1 class="text-xl font-bold text-gray-900">Danh sách phòng trọ</h1>
                        <span class="ml-3 text-sm text-gray-500">
                            ({{ $properties->total() }} kết quả)
                        </span>
                    </div>

                    <div class="flex items-center space-x-4">
                        <button id="filterToggle"
                            class="lg:hidden flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                            <i class="fas fa-filter mr-2"></i>
                            Lọc
                        </button>

                        <div class="hidden sm:flex items-center space-x-2">
                            <span class="text-sm text-gray-600">Xem:</span>
                            <button id="gridView" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                                <i class="fas fa-th-large"></i>
                            </button>
                            <button id="listView" class="p-2 text-gray-400 hover:bg-gray-50 rounded-lg transition-colors">
                                <i class="fas fa-list"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex flex-col lg:flex-row gap-6">
                <!-- Sidebar Filters -->
                <div id="filterSidebar" class="lg:w-80 lg:flex-shrink-0 hidden lg:block">
                    <div class="bg-white rounded-2xl shadow-sm p-6 sticky top-6">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-lg font-bold text-gray-900">
                                <i class="fas fa-filter mr-2 text-blue-600"></i>
                                Bộ lọc
                            </h2>
                            <button id="clearFilters" class="text-sm text-blue-600 hover:text-blue-700 transition-colors">
                                Xóa bộ lọc
                            </button>
                        </div>

                        <form id="filterForm" method="GET" class="space-y-6">
                            <!-- Khu vực -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-map-marker-alt mr-1"></i>
                                    Khu vực
                                </label>
                                <select name="location_id"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <option value="">Tất cả khu vực</option>
                                    @php
                                        $locations = \App\Models\Location::whereNull('parent_id')
                                            ->with('children')
                                            ->get();
                                    @endphp
                                    @foreach ($locations as $location)
                                        <option value="{{ $location->id }}"
                                            {{ request('location_id') == $location->id ? 'selected' : '' }}>
                                            {{ $location->name }}
                                        </option>
                                        @if ($location->children)
                                            @foreach ($location->children as $child)
                                                <option value="{{ $child->id }}"
                                                    {{ request('location_id') == $child->id ? 'selected' : '' }}>
                                                    &nbsp;&nbsp;&nbsp;&nbsp;{{ $child->name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    @endforeach
                                </select>
                            </div>

                            <!-- Khoảng giá -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-dollar-sign mr-1"></i>
                                    Khoảng giá (VNĐ)
                                </label>
                                <div class="grid grid-cols-2 gap-2">
                                    <input type="number" name="min_price" placeholder="Từ"
                                        value="{{ request('min_price') }}"
                                        class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <input type="number" name="max_price" placeholder="Đến"
                                        value="{{ request('max_price') }}"
                                        class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </div>
                                <div class="mt-2 flex flex-wrap gap-2">
                                    <button type="button"
                                        class="price-preset px-3 py-1 text-xs border border-gray-300 rounded-full hover:bg-gray-50 transition-colors"
                                        data-min="0" data-max="3000000">Dưới 3 triệu</button>
                                    <button type="button"
                                        class="price-preset px-3 py-1 text-xs border border-gray-300 rounded-full hover:bg-gray-50 transition-colors"
                                        data-min="3000000" data-max="5000000">3-5 triệu</button>
                                    <button type="button"
                                        class="price-preset px-3 py-1 text-xs border border-gray-300 rounded-full hover:bg-gray-50 transition-colors"
                                        data-min="5000000" data-max="10000000">5-10 triệu</button>
                                    <button type="button"
                                        class="price-preset px-3 py-1 text-xs border border-gray-300 rounded-full hover:bg-gray-50 transition-colors"
                                        data-min="10000000" data-max="">Trên 10 triệu</button>
                                </div>
                            </div>

                            <!-- Diện tích -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-ruler-combined mr-1"></i>
                                    Diện tích (m²)
                                </label>
                                <div class="grid grid-cols-2 gap-2">
                                    <input type="number" name="min_area" placeholder="Từ" value="{{ request('min_area') }}"
                                        class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <input type="number" name="max_area" placeholder="Đến"
                                        value="{{ request('max_area') }}"
                                        class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </div>
                                <div class="mt-2 flex flex-wrap gap-2">
                                    <button type="button"
                                        class="area-preset px-3 py-1 text-xs border border-gray-300 rounded-full hover:bg-gray-50 transition-colors"
                                        data-min="0" data-max="20">Dưới 20m²</button>
                                    <button type="button"
                                        class="area-preset px-3 py-1 text-xs border border-gray-300 rounded-full hover:bg-gray-50 transition-colors"
                                        data-min="20" data-max="30">20-30m²</button>
                                    <button type="button"
                                        class="area-preset px-3 py-1 text-xs border border-gray-300 rounded-full hover:bg-gray-50 transition-colors"
                                        data-min="30" data-max="50">30-50m²</button>
                                    <button type="button"
                                        class="area-preset px-3 py-1 text-xs border border-gray-300 rounded-full hover:bg-gray-50 transition-colors"
                                        data-min="50" data-max="">Trên 50m²</button>
                                </div>
                            </div>

                            <!-- Loại phòng -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-home mr-1"></i>
                                    Loại phòng
                                </label>
                                <select name="type"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <option value="">Tất cả loại</option>
                                    <option value="phong-tro" {{ request('type') == 'phong-tro' ? 'selected' : '' }}>Phòng
                                        trọ</option>
                                    <option value="can-ho" {{ request('type') == 'can-ho' ? 'selected' : '' }}>Căn hộ
                                    </option>
                                    <option value="nha-nguyen-can"
                                        {{ request('type') == 'nha-nguyen-can' ? 'selected' : '' }}>Nhà nguyên căn</option>
                                    <option value="chung-cu-mini"
                                        {{ request('type') == 'chung-cu-mini' ? 'selected' : '' }}>Chung cư mini</option>
                                </select>
                            </div>

                            <!-- Tiện ích -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-star mr-1"></i>
                                    Tiện ích
                                </label>
                                <div class="space-y-2 max-h-40 overflow-y-auto">
                                    @php
                                        $amenities = \App\Models\Amenity::all();
                                        $selectedAmenities = request('amenities', []);
                                        if (!is_array($selectedAmenities)) {
                                            $selectedAmenities = explode(',', $selectedAmenities);
                                        }
                                    @endphp

                                    @foreach ($amenities as $amenity)
                                        <label class="flex items-center">
                                            <input type="checkbox" name="amenities[]" value="{{ $amenity->id }}"
                                                {{ in_array($amenity->id, $selectedAmenities) ? 'checked' : '' }}
                                                class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                            <span class="ml-2 text-sm text-gray-700">{{ $amenity->name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Sắp xếp -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-sort mr-1"></i>
                                    Sắp xếp
                                </label>
                                <div class="grid grid-cols-2 gap-2">
                                    <select name="sort_by"
                                        class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                        <option value="created_at"
                                            {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>Ngày đăng</option>
                                        <option value="price" {{ request('sort_by') == 'price' ? 'selected' : '' }}>Giá
                                        </option>
                                        <option value="area" {{ request('sort_by') == 'area' ? 'selected' : '' }}>Diện
                                            tích</option>
                                    </select>
                                    <select name="sort_order"
                                        class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                        <option value="desc" {{ request('sort_order') == 'desc' ? 'selected' : '' }}>
                                            Giảm dần</option>
                                        <option value="asc" {{ request('sort_order') == 'asc' ? 'selected' : '' }}>Tăng
                                            dần</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Action buttons -->
                            <div class="flex space-x-3">
                                <button type="submit"
                                    class="flex-1 bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors">
                                    <i class="fas fa-search mr-2"></i>
                                    Tìm kiếm
                                </button>
                                <button type="button" id="resetForm"
                                    class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                                    <i class="fas fa-undo mr-2"></i>
                                    Đặt lại
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="flex-1">
                    <!-- Active Filters -->
                    <div id="activeFilters" class="mb-6">
                        @if (request()->hasAny(['location_id', 'min_price', 'max_price', 'min_area', 'max_area', 'type', 'amenities']))
                            <div class="bg-white rounded-xl shadow-sm p-4">
                                <div class="flex items-center justify-between mb-3">
                                    <h3 class="text-sm font-medium text-gray-700">Bộ lọc đang áp dụng:</h3>
                                    <a href="{{ route('tenant.properties.index') }}"
                                        class="text-sm text-blue-600 hover:text-blue-700">
                                        Xóa tất cả
                                    </a>
                                </div>
                                <div class="flex flex-wrap gap-2">
                                    @if (request('location_id'))
                                        @php
                                            $selectedLocation = \App\Models\Location::find(request('location_id'));
                                        @endphp
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            Khu vực: {{ $selectedLocation->name ?? 'Không xác định' }}
                                            <a href="{{ request()->fullUrlWithQuery(['location_id' => null]) }}"
                                                class="ml-1 inline-flex items-center justify-center w-4 h-4 rounded-full text-blue-400 hover:text-blue-600">
                                                <i class="fas fa-times text-xs"></i>
                                            </a>
                                        </span>
                                    @endif

                                    @if (request('min_price') || request('max_price'))
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Giá: {{ request('min_price') ? number_format(request('min_price')) : '0' }}₫ -
                                            {{ request('max_price') ? number_format(request('max_price')) : '∞' }}₫
                                            <a href="{{ request()->fullUrlWithQuery(['min_price' => null, 'max_price' => null]) }}"
                                                class="ml-1 inline-flex items-center justify-center w-4 h-4 rounded-full text-green-400 hover:text-green-600">
                                                <i class="fas fa-times text-xs"></i>
                                            </a>
                                        </span>
                                    @endif

                                    @if (request('min_area') || request('max_area'))
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                            Diện tích: {{ request('min_area') ? request('min_area') : '0' }}m² -
                                            {{ request('max_area') ? request('max_area') : '∞' }}m²
                                            <a href="{{ request()->fullUrlWithQuery(['min_area' => null, 'max_area' => null]) }}"
                                                class="ml-1 inline-flex items-center justify-center w-4 h-4 rounded-full text-orange-400 hover:text-orange-600">
                                                <i class="fas fa-times text-xs"></i>
                                            </a>
                                        </span>
                                    @endif

                                    @if (request('type'))
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                            Loại: {{ ucfirst(str_replace('-', ' ', request('type'))) }}
                                            <a href="{{ request()->fullUrlWithQuery(['type' => null]) }}"
                                                class="ml-1 inline-flex items-center justify-center w-4 h-4 rounded-full text-purple-400 hover:text-purple-600">
                                                <i class="fas fa-times text-xs"></i>
                                            </a>
                                        </span>
                                    @endif

                                    @if (request('amenities'))
                                        @php
                                            $selectedAmenities = request('amenities', []);
                                            if (!is_array($selectedAmenities)) {
                                                $selectedAmenities = explode(',', $selectedAmenities);
                                            }
                                            $amenityNames = \App\Models\Amenity::whereIn(
                                                'id',
                                                $selectedAmenities,
                                            )->pluck('name');
                                        @endphp
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            Tiện ích:
                                            {{ $amenityNames->take(2)->implode(', ') }}{{ $amenityNames->count() > 2 ? ' (+' . ($amenityNames->count() - 2) . ')' : '' }}
                                            <a href="{{ request()->fullUrlWithQuery(['amenities' => null]) }}"
                                                class="ml-1 inline-flex items-center justify-center w-4 h-4 rounded-full text-yellow-400 hover:text-yellow-600">
                                                <i class="fas fa-times text-xs"></i>
                                            </a>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Quick Search Bar -->
                    <div class="mb-6 lg:hidden">
                        <div class="bg-white rounded-xl shadow-sm p-4">
                            <div class="relative">
                                <input type="text" placeholder="Tìm kiếm theo địa chỉ, khu vực..."
                                    class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-search text-gray-400"></i>
                                </div>
                                <button class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                    <i class="fas fa-microphone text-gray-400 hover:text-blue-500 transition-colors"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Properties Grid -->
                    <div id="propertiesContainer" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                        @forelse($properties as $property)
                            <div
                                class="bg-white rounded-2xl shadow-sm overflow-hidden hover:shadow-lg transition-shadow duration-300 property-card">
                                <div class="relative">
                                    @if ($property->images->isNotEmpty())
                                        <img src="{{ $property->images->first()->image_full_url }}" alt="Ảnh phòng trọ"
                                            class="w-full h-48 object-cover">
                                    @else
                                        <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                            <i class="fas fa-image text-gray-400 text-2xl"></i>
                                        </div>
                                    @endif

                                    <!-- Status badge -->
                                    <div class="absolute top-3 left-3">
                                        <span
                                            class="px-2 py-1 text-xs font-medium rounded-full
                                        {{ $property->status === 'available' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $property->status === 'available' ? 'Còn trống' : 'Đã thuê' }}
                                        </span>
                                    </div>

                                    <!-- Favorite button -->
                                    <button
                                        class="absolute top-3 right-3 p-2 bg-white bg-opacity-90 rounded-full text-gray-400 hover:text-red-500 transition-colors">
                                        <i class="far fa-heart"></i>
                                    </button>

                                    <!-- Image count -->
                                    @if ($property->images->count() > 1)
                                        <div
                                            class="absolute bottom-3 right-3 px-2 py-1 bg-black bg-opacity-60 text-white text-xs rounded-full">
                                            <i class="fas fa-camera mr-1"></i>{{ $property->images->count() }}
                                        </div>
                                    @endif
                                </div>

                                <div class="p-4">
                                    <div class="mb-3">
                                        <h3 class="font-semibold text-gray-900 mb-1 line-clamp-1">
                                            {{ ucfirst($property->type) }} tại
                                            {{ $property->location->name ?? 'Chưa xác định' }}
                                        </h3>
                                        <p class="text-sm text-gray-600 flex items-center">
                                            <i class="fas fa-map-marker-alt mr-1"></i>
                                            {{ $property->address_detail }}
                                        </p>
                                    </div>

                                    <div class="flex items-center justify-between mb-3">
                                        <div class="text-xl font-bold text-blue-600">
                                            {{ number_format($property->price) }}đ
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            {{ $property->area }}m²
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-3 gap-2 mb-4 text-xs text-gray-600">
                                        <div class="flex items-center">
                                            <i class="fas fa-ruler-combined mr-1"></i>
                                            {{ $property->area }}m²
                                        </div>
                                        <div class="flex items-center">
                                            <i class="fas fa-users mr-1"></i>
                                            {{ $property->max_occupants }} người
                                        </div>
                                        <div class="flex items-center">
                                            <i class="fas fa-home mr-1"></i>
                                            {{ ucfirst($property->type) }}
                                        </div>
                                    </div>

                                    @if ($property->amenities->isNotEmpty())
                                        <div class="mb-4">
                                            <div class="flex flex-wrap gap-1">
                                                @foreach ($property->amenities->take(3) as $amenity)
                                                    <span class="px-2 py-1 bg-gray-100 text-gray-600 text-xs rounded-full">
                                                        {{ $amenity->name }}
                                                    </span>
                                                @endforeach
                                                @if ($property->amenities->count() > 3)
                                                    <span class="px-2 py-1 bg-gray-100 text-gray-600 text-xs rounded-full">
                                                        +{{ $property->amenities->count() - 3 }} khác
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    @endif

                                    <div class="flex items-center justify-between">
                                        <span class="text-xs text-gray-500">
                                            {{ $property->created_at->diffForHumans() }}
                                        </span>
                                        <div class="flex space-x-2">
                                            <button class="p-2 text-gray-400 hover:text-blue-500 transition-colors"
                                                title="Liên hệ">
                                                <i class="fas fa-phone"></i>
                                            </button>
                                            <a href="{{ route('tenant.properties.show', $property) }}"
                                                class="px-3 py-1 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 transition-colors">
                                                Xem chi tiết
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full">
                                <div class="bg-white rounded-2xl shadow-sm p-12 text-center">
                                    <i class="fas fa-search text-gray-300 text-4xl mb-4"></i>
                                    <h3 class="text-lg font-medium text-gray-900 mb-2">Không tìm thấy phòng trọ nào</h3>
                                    <p class="text-gray-600 mb-6">Thử thay đổi bộ lọc hoặc từ khóa tìm kiếm</p>
                                    <a href="{{ route('tenant.properties.index') }}"
                                        class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                        <i class="fas fa-undo mr-2"></i>
                                        Xem tất cả
                                    </a>
                                </div>
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    @if ($properties->hasPages())
                        <div class="mt-8 flex justify-center">
                            <div class="bg-white rounded-xl shadow-sm px-6 py-4">
                                <nav class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <p class="text-sm text-gray-700 mr-4">
                                            Hiển thị {{ $properties->firstItem() }} - {{ $properties->lastItem() }}
                                            trong {{ $properties->total() }} kết quả
                                        </p>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        {{-- Previous Page Link --}}
                                        @if ($properties->onFirstPage())
                                            <span
                                                class="px-3 py-2 text-sm text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">
                                                <i class="fas fa-chevron-left"></i>
                                            </span>
                                        @else
                                            <a href="{{ $properties->previousPageUrl() }}"
                                                class="px-3 py-2 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                                                <i class="fas fa-chevron-left"></i>
                                            </a>
                                        @endif

                                        {{-- Page Numbers --}}
                                        @php
                                            $start = max($properties->currentPage() - 2, 1);
                                            $end = min($start + 4, $properties->lastPage());
                                            $start = max($end - 4, 1);
                                        @endphp

                                        @for ($i = $start; $i <= $end; $i++)
                                            @if ($i == $properties->currentPage())
                                                <span
                                                    class="px-3 py-2 text-sm bg-blue-600 text-white rounded-lg">{{ $i }}</span>
                                            @else
                                                <a href="{{ $properties->url($i) }}"
                                                    class="px-3 py-2 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                                                    {{ $i }}
                                                </a>
                                            @endif
                                        @endfor

                                        {{-- Next Page Link --}}
                                        @if ($properties->hasMorePages())
                                            <a href="{{ $properties->nextPageUrl() }}"
                                                class="px-3 py-2 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                                                <i class="fas fa-chevron-right"></i>
                                            </a>
                                        @else
                                            <span
                                                class="px-3 py-2 text-sm text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">
                                                <i class="fas fa-chevron-right"></i>
                                            </span>
                                        @endif
                                    </div>
                                </nav>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle mobile filter
            const filterToggle = document.getElementById('filterToggle');
            const filterSidebar = document.getElementById('filterSidebar');

            filterToggle?.addEventListener('click', function() {
                filterSidebar.classList.toggle('hidden');
            });

            // Price presets
            document.querySelectorAll('.price-preset').forEach(button => {
                button.addEventListener('click', function() {
                    const minPrice = this.dataset.min;
                    const maxPrice = this.dataset.max;

                    document.querySelector('input[name="min_price"]').value = minPrice;
                    document.querySelector('input[name="max_price"]').value = maxPrice;
                });
            });

            // Area presets
            document.querySelectorAll('.area-preset').forEach(button => {
                button.addEventListener('click', function() {
                    const minArea = this.dataset.min;
                    const maxArea = this.dataset.max;

                    document.querySelector('input[name="min_area"]').value = minArea;
                    document.querySelector('input[name="max_area"]').value = maxArea;
                });
            });

            // Reset form
            document.getElementById('resetForm')?.addEventListener('click', function() {
                document.getElementById('filterForm').reset();
                window.location.href = '{{ route('tenant.properties.index') }}';
            });

            // Clear all filters
            document.getElementById('clearFilters')?.addEventListener('click', function() {
                window.location.href = '{{ route('tenant.properties.index') }}';
            });

            // View toggle
            const gridView = document.getElementById('gridView');
            const listView = document.getElementById('listView');
            const container = document.getElementById('propertiesContainer');

            gridView?.addEventListener('click', function() {
                container.className = 'grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6';
                gridView.classList.add('text-blue-600');
                gridView.classList.remove('text-gray-400');
                listView.classList.add('text-gray-400');
                listView.classList.remove('text-blue-600');
            });

            listView?.addEventListener('click', function() {
                container.className = 'grid grid-cols-1 gap-6';
                listView.classList.add('text-blue-600');
                listView.classList.remove('text-gray-400');
                gridView.classList.add('text-gray-400');
                gridView.classList.remove('text-blue-600');
            });

            // Auto-submit form on select change (optional)
            document.querySelectorAll('select[name="location_id"], select[name="type"]').forEach(select => {
                select.addEventListener('change', function() {
                    // Auto-submit when location or type changes
                    document.getElementById('filterForm').submit();
                });
            });

            // Handle checkbox changes for amenities
            document.querySelectorAll('input[name="amenities[]"]').forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    // Optional: Auto-submit when amenities change
                    // document.getElementById('filterForm').submit();
                });
            });

            // Handle number input changes
            let priceTimeout, areaTimeout;

            document.querySelectorAll('input[name="min_price"], input[name="max_price"]').forEach(input => {
                input.addEventListener('input', function() {
                    clearTimeout(priceTimeout);
                    priceTimeout = setTimeout(() => {
                        // Optional: Auto-submit after user stops typing
                        // document.getElementById('filterForm').submit();
                    }, 1000);
                });
            });

            document.querySelectorAll('input[name="min_area"], input[name="max_area"]').forEach(input => {
                input.addEventListener('input', function() {
                    clearTimeout(areaTimeout);
                    areaTimeout = setTimeout(() => {
                        // Optional: Auto-submit after user stops typing
                        // document.getElementById('filterForm').submit();
                    }, 1000);
                });
            });

            // Handle sort changes
            document.querySelectorAll('select[name="sort_by"], select[name="sort_order"]').forEach(select => {
                select.addEventListener('change', function() {
                    document.getElementById('filterForm').submit();
                });
            });

            // Property card hover effects
            document.querySelectorAll('.property-card').forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-4px)';
                });

                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
            });

            // Smooth scroll to top when pagination is clicked
            document.querySelectorAll('a[href*="page="]').forEach(link => {
                link.addEventListener('click', function(e) {
                    setTimeout(() => {
                        window.scrollTo({
                            top: 0,
                            behavior: 'smooth'
                        });
                    }, 100);
                });
            });
        });
    </script>
@endsection
