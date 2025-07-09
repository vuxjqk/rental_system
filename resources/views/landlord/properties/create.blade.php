<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <a href="{{ route('landlord.properties.index') }}"
                    class="text-gray-600 hover:text-gray-900 mr-4 transition duration-200">
                    <i class="fas fa-arrow-left text-lg"></i>
                </a>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    <i class="fas fa-plus-circle mr-2 text-green-600"></i>
                    {{ __('Thêm bất động sản mới') }}
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Form Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('landlord.properties.store') }}" class="space-y-6"
                        enctype="multipart/form-data">
                        @csrf

                        <!-- Form Header -->
                        <div class="border-b border-gray-200 pb-4">
                            <h3 class="text-lg font-medium text-gray-900">
                                <i class="fas fa-info-circle mr-2 text-blue-600"></i>
                                Thông tin bất động sản
                            </h3>
                            <p class="mt-1 text-sm text-gray-600">
                                Vui lòng điền đầy đủ thông tin để tạo bất động sản mới trong hệ thống.
                            </p>
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
                                        {{ old('location_id') == $location->id ? 'selected' : '' }}>
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
                                value="{{ old('address_detail') }}" required maxlength="255"
                                placeholder="Nhập địa chỉ chi tiết..."
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
                                <option value="single_room" {{ old('type') == 'single_room' ? 'selected' : '' }}>Phòng
                                    đơn</option>
                                <option value="shared_room" {{ old('type') == 'shared_room' ? 'selected' : '' }}>Phòng
                                    ghép</option>
                                <option value="apartment" {{ old('type') == 'apartment' ? 'selected' : '' }}>Căn hộ
                                </option>
                                <option value="whole_house" {{ old('type') == 'whole_house' ? 'selected' : '' }}>Nhà
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
                            <input type="number" id="price" name="price" value="{{ old('price') }}" required
                                min="0" step="0.01" placeholder="Nhập giá thuê..."
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
                            <input type="number" id="area" name="area" value="{{ old('area') }}" required
                                min="0" step="0.01" placeholder="Nhập diện tích..."
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
                                value="{{ old('max_occupants') }}" required min="1"
                                placeholder="Nhập số người tối đa..."
                                class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('max_occupants') border-red-500 @enderror">
                            @error('max_occupants')
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
                                placeholder="Nhập mô tả về bất động sản...">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Amenities -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-check-circle mr-1 text-blue-600"></i>
                                Tiện nghi
                            </label>
                            <div class="grid grid-cols-2 gap-4">
                                @foreach ($amenities as $amenity)
                                    <div class="flex items-center">
                                        <input type="checkbox" id="amenity_{{ $amenity->id }}" name="amenities[]"
                                            value="{{ $amenity->id }}"
                                            {{ in_array($amenity->id, old('amenities', [])) ? 'checked' : '' }}
                                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                        <label for="amenity_{{ $amenity->id }}"
                                            class="ml-2 text-sm text-gray-700">{{ $amenity->name }}</label>
                                    </div>
                                @endforeach
                            </div>
                            @error('amenities')
                                <p class="mt-1 text-sm text-red-600">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Images -->
                        <div>
                            <label for="images" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-image mr-1 text-yellow-600"></i>
                                Hình ảnh
                            </label>
                            <input type="file" id="images" name="images[]" multiple
                                accept="image/jpeg,image/png,image/jpg,image/gif,image/svg+xml"
                                class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('images.*') border-red-500 @enderror">
                            @error('images.*')
                                <p class="mt-1 text-sm text-red-600">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                            <p class="mt-1 text-sm text-gray-500">
                                <i class="fas fa-info mr-1"></i>
                                Tải lên nhiều hình ảnh (JPEG, PNG, JPG, GIF, SVG; tối đa 2MB mỗi ảnh)
                            </p>
                        </div>

                        <!-- Form Actions -->
                        <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-200">
                            <a href="{{ route('landlord.properties.index') }}"
                                class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-6 rounded-lg transition duration-200 flex items-center">
                                <i class="fas fa-times mr-2"></i>
                                Hủy bỏ
                            </a>
                            <button type="submit"
                                class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded-lg transition duration-200 flex items-center">
                                <i class="fas fa-save mr-2"></i>
                                Lưu bất động sản
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Quick Actions Card -->
            <div class="mt-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">
                        <i class="fas fa-bolt mr-2 text-yellow-600"></i>
                        Thao tác nhanh
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <a href="{{ route('landlord.properties.index') }}"
                            class="flex items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition duration-200">
                            <i class="fas fa-list text-blue-600 mr-3"></i>
                            <div>
                                <p class="font-medium text-blue-900">Xem danh sách</p>
                                <p class="text-sm text-blue-700">Quay lại danh sách bất động sản</p>
                            </div>
                        </a>

                        <button type="button" onclick="document.getElementById('landlord_id').focus()"
                            class="flex items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition duration-200">
                            <i class="fas fa-edit text-green-600 mr-3"></i>
                            <div>
                                <p class="font-medium text-green-900">Tiếp tục nhập</p>
                                <p class="text-sm text-green-700">Focus vào trường chủ nhà</p>
                            </div>
                        </button>

                        <button type="button" onclick="resetForm()"
                            class="flex items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition duration-200">
                            <i class="fas fa-undo text-gray-600 mr-3"></i>
                            <div>
                                <p class="font-medium text-gray-900">Làm mới form</p>
                                <p class="text-sm text-gray-700">Xóa tất cả dữ liệu</p>
                            </div>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function resetForm() {
                if (confirm('Bạn có chắc chắn muốn xóa tất cả dữ liệu đã nhập?')) {
                    document.querySelector('form').reset();
                    document.getElementById('landlord_id').focus();
                }
            }

            document.addEventListener('DOMContentLoaded', function() {
                const locationSelect = document.getElementById('location_id');
                const addressInput = document.getElementById('address_detail');
                const typeSelect = document.getElementById('type');
                const imagesInput = document.getElementById('images');

                // Auto-focus next field
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

                // Image input validation feedback
                imagesInput.addEventListener('change', function() {
                    const files = this.files;
                    let errorMessage = '';
                    const maxSize = 2 * 1024 * 1024; // 2MB in bytes
                    const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/svg+xml'];

                    for (let i = 0; i < files.length; i++) {
                        if (!allowedTypes.includes(files[i].type)) {
                            errorMessage = 'Vui lòng chỉ tải lên các tệp JPEG, PNG, JPG, GIF hoặc SVG.';
                            break;
                        }
                        if (files[i].size > maxSize) {
                            errorMessage = `Tệp ${files[i].name} vượt quá giới hạn 2MB.`;
                            break;
                        }
                    }

                    let errorElement = document.getElementById('images-error');
                    if (!errorElement) {
                        errorElement = document.createElement('p');
                        errorElement.id = 'images-error';
                        errorElement.className = 'mt-1 text-sm text-red-600';
                        imagesInput.parentNode.appendChild(errorElement);
                    }

                    errorElement.innerHTML = errorMessage ?
                        `<i class="fas fa-exclamation-circle mr-1"></i>${errorMessage}` : '';
                });
            });
        </script>
    @endpush
</x-app-layout>
