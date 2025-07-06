<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <a href="{{ route('locations.index') }}"
                    class="text-gray-600 hover:text-gray-900 mr-4 transition duration-200">
                    <i class="fas fa-arrow-left text-lg"></i>
                </a>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    <i class="fas fa-plus-circle mr-2 text-green-600"></i>
                    {{ __('Thêm địa điểm mới') }}
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Form Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('locations.store') }}" class="space-y-6">
                        @csrf

                        <!-- Form Header -->
                        <div class="border-b border-gray-200 pb-4">
                            <h3 class="text-lg font-medium text-gray-900">
                                <i class="fas fa-info-circle mr-2 text-blue-600"></i>
                                Thông tin địa điểm
                            </h3>
                            <p class="mt-1 text-sm text-gray-600">
                                Vui lòng điền đầy đủ thông tin để tạo địa điểm mới trong hệ thống.
                            </p>
                        </div>

                        <!-- Location Type -->
                        <div>
                            <label for="type" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-layer-group mr-1 text-purple-600"></i>
                                Loại địa điểm <span class="text-red-500">*</span>
                            </label>
                            <select id="type" name="type" required
                                class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('type') border-red-500 @enderror">
                                <option value="">Chọn loại địa điểm</option>
                                <option value="city" {{ old('type') == 'city' ? 'selected' : '' }}>
                                    Thành phố
                                </option>
                                <option value="district" {{ old('type') == 'district' ? 'selected' : '' }}>
                                    Quận/Huyện
                                </option>
                                <option value="ward" {{ old('type') == 'ward' ? 'selected' : '' }}>
                                    Phường/Xã
                                </option>
                            </select>
                            @error('type')
                                <p class="mt-1 text-sm text-red-600">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Location Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-map-marker-alt mr-1 text-blue-600"></i>
                                Tên địa điểm <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" required
                                maxlength="100" placeholder="Nhập tên địa điểm..."
                                class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                            <p class="mt-1 text-sm text-gray-500">
                                <i class="fas fa-info mr-1"></i>
                                Tối đa 100 ký tự
                            </p>
                        </div>

                        <!-- Parent Location -->
                        <div>
                            <label for="parent_id" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-sitemap mr-1 text-green-600"></i>
                                Địa điểm cấp cha
                            </label>
                            <select id="parent_id" name="parent_id"
                                class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('parent_id') border-red-500 @enderror">
                                <option value="">Không có cấp cha (Cấp gốc)</option>
                                @foreach ($locations as $location)
                                    <option value="{{ $location->id }}"
                                        {{ old('parent_id') == $location->id ? 'selected' : '' }}>
                                        @if ($location->type == 'city')
                                            <i class="fas fa-city"></i> {{ $location->name }} (Thành phố)
                                        @elseif($location->type == 'district')
                                            <i class="fas fa-building"></i> {{ $location->name }} (Quận/Huyện)
                                        @else
                                            <i class="fas fa-map-marked-alt"></i> {{ $location->name }} (Phường/Xã)
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                            @error('parent_id')
                                <p class="mt-1 text-sm text-red-600">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                            <p class="mt-1 text-sm text-gray-500">
                                <i class="fas fa-lightbulb mr-1"></i>
                                Chọn địa điểm cấp cha nếu có (VD: Phường thuộc Quận/Huyện)
                            </p>
                        </div>

                        <!-- Location Hierarchy Info -->
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <h4 class="text-sm font-medium text-blue-900 mb-2">
                                <i class="fas fa-info-circle mr-2"></i>
                                Hướng dẫn phân cấp địa điểm
                            </h4>
                            <div class="text-sm text-blue-800 space-y-1">
                                <div class="flex items-center">
                                    <i class="fas fa-city text-blue-600 mr-2"></i>
                                    <span><strong>Thành phố:</strong> Cấp cao nhất, thường không có cấp cha</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-building text-green-600 mr-2"></i>
                                    <span><strong>Quận/Huyện:</strong> Thuộc Thành phố</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-map-marked-alt text-purple-600 mr-2"></i>
                                    <span><strong>Phường/Xã:</strong> Thuộc Quận/Huyện</span>
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-200">
                            <a href="{{ route('locations.index') }}"
                                class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-6 rounded-lg transition duration-200 flex items-center">
                                <i class="fas fa-times mr-2"></i>
                                Hủy bỏ
                            </a>
                            <button type="submit"
                                class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded-lg transition duration-200 flex items-center">
                                <i class="fas fa-save mr-2"></i>
                                Lưu địa điểm
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
                        <a href="{{ route('locations.index') }}"
                            class="flex items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition duration-200">
                            <i class="fas fa-list text-blue-600 mr-3"></i>
                            <div>
                                <p class="font-medium text-blue-900">Xem danh sách</p>
                                <p class="text-sm text-blue-700">Quay lại danh sách địa điểm</p>
                            </div>
                        </a>

                        <button type="button" onclick="document.getElementById('name').focus()"
                            class="flex items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition duration-200">
                            <i class="fas fa-edit text-green-600 mr-3"></i>
                            <div>
                                <p class="font-medium text-green-900">Tiếp tục nhập</p>
                                <p class="text-sm text-green-700">Focus vào trường tên</p>
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
            // Form utilities
            function resetForm() {
                if (confirm('Bạn có chắc chắn muốn xóa tất cả dữ liệu đã nhập?')) {
                    document.querySelector('form').reset();
                    document.getElementById('type').focus();
                }
            }

            // Dynamic form behavior
            document.addEventListener('DOMContentLoaded', function() {
                const typeSelect = document.getElementById('type');
                const parentSelect = document.getElementById('parent_id');
                const nameInput = document.getElementById('name');

                // Filter parent options based on type selection
                typeSelect.addEventListener('change', function() {
                    const selectedType = this.value;
                    const parentOptions = parentSelect.querySelectorAll('option');

                    parentOptions.forEach(option => {
                        if (option.value === '') {
                            option.style.display = 'block';
                            return;
                        }

                        const optionText = option.textContent;
                        let shouldShow = false;

                        switch (selectedType) {
                            case 'district':
                                shouldShow = optionText.includes('(Thành phố)');
                                break;
                            case 'ward':
                                shouldShow = optionText.includes('(Quận/Huyện)');
                                break;
                            case 'city':
                                shouldShow = false; // Cities typically don't have parents
                                break;
                        }

                        option.style.display = shouldShow ? 'block' : 'none';
                    });

                    // Reset parent selection if current selection is not valid
                    if (parentSelect.value && parentSelect.querySelector(
                            `option[value="${parentSelect.value}"]`).style.display === 'none') {
                        parentSelect.value = '';
                    }
                });

                // Auto-focus next field
                typeSelect.addEventListener('change', function() {
                    if (this.value) {
                        nameInput.focus();
                    }
                });

                // Character counter for name field
                nameInput.addEventListener('input', function() {
                    const maxLength = 100;
                    const currentLength = this.value.length;
                    const remaining = maxLength - currentLength;

                    let counterElement = document.getElementById('name-counter');
                    if (!counterElement) {
                        counterElement = document.createElement('p');
                        counterElement.id = 'name-counter';
                        counterElement.className = 'mt-1 text-sm text-gray-500';
                        nameInput.parentNode.appendChild(counterElement);
                    }

                    counterElement.innerHTML =
                        `<i class="fas fa-keyboard mr-1"></i>${currentLength}/${maxLength} ký tự`;

                    if (remaining < 10) {
                        counterElement.className = 'mt-1 text-sm text-red-500';
                    } else {
                        counterElement.className = 'mt-1 text-sm text-gray-500';
                    }
                });
            });
        </script>
    @endpush
</x-app-layout>
