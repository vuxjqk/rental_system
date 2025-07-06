<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <a href="{{ route('properties.index') }}"
                    class="text-gray-600 hover:text-gray-900 mr-4 transition duration-200">
                    <i class="fas fa-arrow-left text-lg"></i>
                </a>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    <i class="fas fa-edit mr-2 text-yellow-600"></i>
                    {{ __('Chỉnh sửa bất động sản') }}
                </h2>
            </div>
            <div class="flex items-center space-x-2">
                <a href="{{ route('properties.show', $property->id) }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200 flex items-center">
                    <i class="fas fa-eye mr-2"></i>
                    Xem chi tiết
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Current Property Info Card -->
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-lg p-6 mb-6">
                <div class="flex items-center">
                    <i class="fas fa-home text-blue-600 text-2xl mr-4"></i>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">{{ $property->address_detail }}</h3>
                        <p class="text-sm text-gray-600">
                            <i class="fas fa-tag mr-1"></i>
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
                            • Trạng thái:
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
                        <p class="text-xs text-gray-500">
                            <i class="fas fa-clock mr-1"></i>
                            ID: #{{ $property->id }} • Tạo: {{ $property->created_at->format('d/m/Y H:i') }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Form Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('properties.update', $property->id) }}" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Form Header -->
                        <div class="border-b border-gray-200 pb-4">
                            <h3 class="text-lg font-medium text-gray-900">
                                <i class="fas fa-info-circle mr-2 text-blue-600"></i>
                                Cập nhật thông tin bất động sản
                            </h3>
                            <p class="mt-1 text-sm text-gray-600">
                                Chỉnh sửa thông tin bất động sản trong hệ thống. Các trường có dấu (*) là bắt buộc.
                            </p>
                        </div>

                        <!-- Landlord -->
                        <div>
                            <label for="landlord_id" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-user mr-1 text-blue-600"></i>
                                Chủ nhà <span class="text-red-500">*</span>
                            </label>
                            <select id="landlord_id" name="landlord_id" required
                                class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('landlord_id') border-red-500 @enderror">
                                <option value="">Chọn chủ nhà</option>
                                @foreach ($landlords as $landlord)
                                    <option value="{{ $landlord->id }}"
                                        {{ (old('landlord_id') ?? $property->landlord_id) == $landlord->id ? 'selected' : '' }}>
                                        {{ $landlord->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('landlord_id')
                                <p class="mt-1 text-sm text-red-600">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Location -->
                        <div>
                            <label for="location_id" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-map-marker-alt mr-1 text-green-600"></i>
                                Vị trí <span class="text-red-500">*</span>
                            </label>
                            <select id="location_id" name="location_id" required
                                class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('location_id') border-red-500 @enderror">
                                <option value="">Chọn vị trí</option>
                                @foreach ($locations as $location)
                                    <option value="{{ $location->id }}"
                                        {{ (old('location_id') ?? $property->location_id) == $location->id ? 'selected' : '' }}>
                                        {{ $location->name }}
                                        ({{ $location->type == 'city' ? 'Thành phố' : ($location->type == 'district' ? 'Quận/Huyện' : 'Phường/Xã') }})
                                    </option>
                                @endforeach
                            </select>
                            @error('location_id')
                                <p class="mt-1 text-sm text-red-600">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Address Detail -->
                        <div>
                            <label for="address_detail" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-home mr-1 text-purple-600"></i>
                                Địa chỉ chi tiết <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="address_detail" name="address_detail"
                                value="{{ old('address_detail') ?? $property->address_detail }}" required
                                maxlength="255" placeholder="Nhập địa chỉ chi tiết..."
                                class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('address_detail') border-red-500 @enderror">
                            @error('address_detail')
                                <p class="mt-1 text-sm text-red-600">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                            <p class="mt-1 text-sm text-gray-500">
                                <i class="fas fa-info mr-1"></i>
                                Tối đa 255 ký tự
                            </p>
                        </div>

                        <!-- Property Type -->
                        <div>
                            <label for="type" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-building mr-1 text-blue-600"></i>
                                Loại bất động sản <span class="text-red-500">*</span>
                            </label>
                            <select id="type" name="type" required
                                class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('type') border-red-500 @enderror">
                                <option value="">Chọn loại bất động sản</option>
                                <option value="single_room"
                                    {{ (old('type') ?? $property->type) == 'single_room' ? 'selected' : '' }}>Phòng đơn
                                </option>
                                <option value="shared_room"
                                    {{ (old('type') ?? $property->type) == 'shared_room' ? 'selected' : '' }}>Phòng
                                    ghép</option>
                                <option value="apartment"
                                    {{ (old('type') ?? $property->type) == 'apartment' ? 'selected' : '' }}>Căn hộ
                                </option>
                                <option value="whole_house"
                                    {{ (old('type') ?? $property->type) == 'whole_house' ? 'selected' : '' }}>Nhà
                                    nguyên căn</option>
                            </select>
                            @error('type')
                                <p class="mt-1 text-sm text-red-600">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Price -->
                        <div>
                            <label for="price" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-dollar-sign mr-1 text-green-600"></i>
                                Giá thuê <span class="text-red-500">*</span>
                            </label>
                            <input type="number" id="price" name="price"
                                value="{{ old('price') ?? $property->price }}" required min="0" step="0.01"
                                placeholder="Nhập giá thuê..."
                                class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('price') border-red-500 @enderror">
                            @error('price')
                                <p class="mt-1 text-sm text-red-600">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                            <p class="mt-1 text-sm text-gray-500">
                                <i class="fas fa-info mr-1"></i>
                                Nhập giá thuê (VND)
                            </p>
                        </div>

                        <!-- Area -->
                        <div>
                            <label for="area" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-ruler-combined mr-1 text-purple-600"></i>
                                Diện tích <span class="text-red-500">*</span>
                            </label>
                            <input type="number" id="area" name="area"
                                value="{{ old('area') ?? $property->area }}" required min="0" step="0.01"
                                placeholder="Nhập diện tích..."
                                class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('area') border-red-500 @enderror">
                            @error('area')
                                <p class="mt-1 text-sm text-red-600">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                            <p class="mt-1 text-sm text-gray-500">
                                <i class="fas fa-info mr-1"></i>
                                Nhập diện tích (m²)
                            </p>
                        </div>

                        <!-- Max Occupants -->
                        <div>
                            <label for="max_occupants" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-users mr-1 text-blue-600"></i>
                                Số người tối đa <span class="text-red-500">*</span>
                            </label>
                            <input type="number" id="max_occupants" name="max_occupants"
                                value="{{ old('max_occupants') ?? $property->max_occupants }}" required
                                min="1" placeholder="Nhập số người tối đa..."
                                class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('max_occupants') border-red-500 @enderror">
                            @error('max_occupants')
                                <p class="mt-1 text-sm text-red-600">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-info mr-1 text-green-600"></i>
                                Trạng thái <span class="text-red-500">*</span>
                            </label>
                            <select id="status" name="status" required
                                class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('status') border-red-500 @enderror">
                                <option value="">Chọn trạng thái</option>
                                <option value="available"
                                    {{ (old('status') ?? $property->status) == 'available' ? 'selected' : '' }}>Sẵn
                                    sàng</option>
                                <option value="rented"
                                    {{ (old('status') ?? $property->status) == 'rented' ? 'selected' : '' }}>Đã thuê
                                </option>
                                <option value="maintenance"
                                    {{ (old('status') ?? $property->status) == 'maintenance' ? 'selected' : '' }}>Bảo
                                    trì</option>
                            </select>
                            @error('status')
                                <p class="mt-1 text-sm text-red-600">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-comment mr-1 text-purple-600"></i>
                                Mô tả
                            </label>
                            <textarea id="description" name="description" rows="4"
                                class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('description') border-red-500 @enderror"
                                placeholder="Nhập mô tả về bất động sản...">{{ old('description') ?? $property->description }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Form Actions -->
                        <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-200">
                            <a href="{{ route('properties.index') }}"
                                class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-6 rounded-lg transition duration-200 flex items-center">
                                <i class="fas fa-times mr-2"></i>
                                Hủy bỏ
                            </a>
                            <button type="button" onclick="resetForm()"
                                class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-6 rounded-lg transition duration-200 flex items-center">
                                <i class="fas fa-undo mr-2"></i>
                                Khôi phục
                            </button>
                            <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg transition duration-200 flex items-center">
                                <i class="fas fa-save mr-2"></i>
                                Cập nhật
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Related Information -->
            <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Quick Actions -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">
                            <i class="fas fa-bolt mr-2 text-yellow-600"></i>
                            Thao tác nhanh
                        </h3>
                        <div class="space-y-3">
                            <a href="{{ route('properties.show', $property->id) }}"
                                class="flex items-center p-3 bg-blue-50 rounded-lg hover:bg-blue-100 transition duration-200">
                                <i class="fas fa-eye text-blue-600 mr-3"></i>
                                <div>
                                    <p class="font-medium text-blue-900">Xem chi tiết</p>
                                    <p class="text-sm text-blue-700">Xem thông tin đầy đủ</p>
                                </div>
                            </a>
                            <a href="{{ route('properties.index') }}"
                                class="flex items-center p-3 bg-green-50 rounded-lg hover:bg-green-100 transition duration-200">
                                <i class="fas fa-list text-green-600 mr-3"></i>
                                <div>
                                    <p class="font-medium text-green-900">Danh sách</p>
                                    <p class="text-sm text-green-700">Quay lại danh sách</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Property Stats -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">
                            <i class="fas fa-chart-bar mr-2 text-purple-600"></i>
                            Thống kê
                        </h3>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">
                                    <i class="fas fa-calendar-alt mr-1"></i>
                                    Ngày tạo
                                </span>
                                <span class="text-sm font-medium text-gray-900">
                                    {{ $property->created_at->format('d/m/Y') }}
                                </span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">
                                    <i class="fas fa-edit mr-1"></i>
                                    Cập nhật lần cuối
                                </span>
                                <span class="text-sm font-medium text-gray-900">
                                    {{ $property->updated_at->format('d/m/Y') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Store original values
            const originalValues = {
                landlord_id: '{{ $property->landlord_id }}',
                location_id: '{{ $property->location_id }}',
                address_detail: '{{ $property->address_detail }}',
                type: '{{ $property->type }}',
                price: '{{ $property->price }}',
                area: '{{ $property->area }}',
                max_occupants: '{{ $property->max_occupants }}',
                status: '{{ $property->status }}',
                description: '{{ $property->description }}'
            };

            // Form utilities
            function resetForm() {
                if (confirm('Bạn có chắc chắn muốn khôi phục về giá trị ban đầu?')) {
                    document.getElementById('landlord_id').value = originalValues.landlord_id;
                    document.getElementById('location_id').value = originalValues.location_id;
                    document.getElementById('address_detail').value = originalValues.address_detail;
                    document.getElementById('type').value = originalValues.type;
                    document.getElementById('price').value = originalValues.price;
                    document.getElementById('area').value = originalValues.area;
                    document.getElementById('max_occupants').value = originalValues.max_occupants;
                    document.getElementById('status').value = originalValues.status;
                    document.getElementById('description').value = originalValues.description || '';
                }
            }

            // Dynamic form behavior
            document.addEventListener('DOMContentLoaded', function() {
                const landlordSelect = document.getElementById('landlord_id');
                const locationSelect = document.getElementById('location_id');
                const addressInput = document.getElementById('address_detail');
                const typeSelect = document.getElementById('type');

                // Auto-focus next field
                landlordSelect.addEventListener('change', function() {
                    if (this.value) {
                        locationSelect.focus();
                    }
                });

                locationSelect.addEventListener('change', function() {
                    if (this.value) {
                        addressInput.focus();
                    }
                });

                // Character counter for address_detail
                addressInput.addEventListener('input', function() {
                    const maxLength = 255;
                    const currentLength = this.value.length;
                    const remaining = maxLength - currentLength;

                    let counterElement = document.getElementById('address-counter');
                    if (!counterElement) {
                        counterElement = document.createElement('p');
                        counterElement.id = 'address-counter';
                        counterElement.className = 'mt-1 text-sm text-gray-500';
                        addressInput.parentNode.appendChild(counterElement);
                    }

                    counterElement.innerHTML =
                        `<i class="fas fa-keyboard mr-1"></i>${currentLength}/${maxLength} ký tự`;

                    if (remaining < 10) {
                        counterElement.className = 'mt-1 text-sm text-red-500';
                    } else {
                        counterElement.className = 'mt-1 text-sm text-gray-500';
                    }
                });

                // Trigger initial character count
                addressInput.dispatchEvent(new Event('input'));

                // Warn about unsaved changes
                let formChanged = false;
                const form = document.querySelector('form');
                const inputs = form.querySelectorAll('input, select, textarea');

                inputs.forEach(input => {
                    input.addEventListener('change', function() {
                        formChanged = true;
                    });
                });

                window.addEventListener('beforeunload', function(e) {
                    if (formChanged) {
                        const message = 'Bạn có thay đổi chưa được lưu. Bạn có chắc chắn muốn rời khỏi trang?';
                        e.returnValue = message;
                        return message;
                    }
                });

                // Remove warning when form is submitted
                form.addEventListener('submit', function() {
                    formChanged = false;
                });
            });
        </script>
    @endpush
</x-app-layout>
