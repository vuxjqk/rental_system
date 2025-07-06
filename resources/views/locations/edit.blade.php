<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <a href="{{ route('locations.index') }}"
                    class="text-gray-600 hover:text-gray-900 mr-4 transition duration-200">
                    <i class="fas fa-arrow-left text-lg"></i>
                </a>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    <i class="fas fa-edit mr-2 text-yellow-600"></i>
                    {{ __('Chỉnh sửa địa điểm') }}
                </h2>
            </div>
            <div class="flex items-center space-x-2">
                <a href="{{ route('locations.show', $location->id) }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200 flex items-center">
                    <i class="fas fa-eye mr-2"></i>
                    Xem chi tiết
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Current Location Info Card -->
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-lg p-6 mb-6">
                <div class="flex items-center">
                    @if ($location->type == 'city')
                        <i class="fas fa-city text-blue-600 text-2xl mr-4"></i>
                    @elseif($location->type == 'district')
                        <i class="fas fa-building text-green-600 text-2xl mr-4"></i>
                    @else
                        <i class="fas fa-map-marked-alt text-purple-600 text-2xl mr-4"></i>
                    @endif
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">{{ $location->name }}</h3>
                        <p class="text-sm text-gray-600">
                            <i class="fas fa-tag mr-1"></i>
                            @if ($location->type == 'city')
                                Thành phố
                            @elseif($location->type == 'district')
                                Quận/Huyện
                            @else
                                Phường/Xã
                            @endif
                            @if ($location->parent_id)
                                • Thuộc: {{ $location->parent->name ?? 'N/A' }}
                            @endif
                        </p>
                        <p class="text-xs text-gray-500">
                            <i class="fas fa-clock mr-1"></i>
                            ID: #{{ $location->id }} • Tạo: {{ $location->created_at->format('d/m/Y H:i') }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Form Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('locations.update', $location->id) }}" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Form Header -->
                        <div class="border-b border-gray-200 pb-4">
                            <h3 class="text-lg font-medium text-gray-900">
                                <i class="fas fa-info-circle mr-2 text-blue-600"></i>
                                Cập nhật thông tin địa điểm
                            </h3>
                            <p class="mt-1 text-sm text-gray-600">
                                Chỉnh sửa thông tin địa điểm trong hệ thống. Các trường có dấu (*) là bắt buộc.
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
                                <option value="city"
                                    {{ (old('type') ?? $location->type) == 'city' ? 'selected' : '' }}>
                                    Thành phố
                                </option>
                                <option value="district"
                                    {{ (old('type') ?? $location->type) == 'district' ? 'selected' : '' }}>
                                    Quận/Huyện
                                </option>
                                <option value="ward"
                                    {{ (old('type') ?? $location->type) == 'ward' ? 'selected' : '' }}>
                                    Phường/Xã
                                </option>
                            </select>
                            @error('type')
                                <p class="mt-1 text-sm text-red-600">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                            @if ($location->type != (old('type') ?? $location->type))
                                <p class="mt-1 text-sm text-yellow-600">
                                    <i class="fas fa-exclamation-triangle mr-1"></i>
                                    Thay đổi loại địa điểm có thể ảnh hưởng đến cấu trúc phân cấp
                                </p>
                            @endif
                        </div>

                        <!-- Location Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-map-marker-alt mr-1 text-blue-600"></i>
                                Tên địa điểm <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="name" name="name"
                                value="{{ old('name') ?? $location->name }}" required maxlength="100"
                                placeholder="Nhập tên địa điểm..."
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
                                @foreach ($locations as $loc)
                                    @if ($loc->id != $location->id)
                                        <option value="{{ $loc->id }}"
                                            {{ (old('parent_id') ?? $location->parent_id) == $loc->id ? 'selected' : '' }}>
                                            @if ($loc->type == 'city')
                                                {{ $loc->name }} (Thành phố)
                                            @elseif($loc->type == 'district')
                                                {{ $loc->name }} (Quận/Huyện)
                                            @else
                                                {{ $loc->name }} (Phường/Xã)
                                            @endif
                                        </option>
                                    @endif
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
                                Không thể chọn chính địa điểm này làm cấp cha
                            </p>
                        </div>

                        <!-- Warning about children -->
                        @if ($location->children && $location->children->count() > 0)
                            <div class="bg-amber-50 border border-amber-200 rounded-lg p-4">
                                <h4 class="text-sm font-medium text-amber-900 mb-2">
                                    <i class="fas fa-exclamation-triangle mr-2"></i>
                                    Cảnh báo về địa điểm con
                                </h4>
                                <p class="text-sm text-amber-800 mb-3">
                                    Địa điểm này có <strong>{{ $location->children->count() }}</strong> địa điểm con.
                                    Thay đổi loại hoặc cấp cha có thể ảnh hưởng đến cấu trúc phân cấp.
                                </p>
                                <div class="text-sm text-amber-700">
                                    <strong>Các địa điểm con:</strong>
                                    <ul class="list-disc list-inside mt-1">
                                        @foreach ($location->children->take(5) as $child)
                                            <li>{{ $child->name }} ({{ ucfirst($child->type) }})</li>
                                        @endforeach
                                        @if ($location->children->count() > 5)
                                            <li>... và {{ $location->children->count() - 5 }} địa điểm khác</li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        @endif

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
                            <a href="{{ route('locations.show', $location->id) }}"
                                class="flex items-center p-3 bg-blue-50 rounded-lg hover:bg-blue-100 transition duration-200">
                                <i class="fas fa-eye text-blue-600 mr-3"></i>
                                <div>
                                    <p class="font-medium text-blue-900">Xem chi tiết</p>
                                    <p class="text-sm text-blue-700">Xem thông tin đầy đủ</p>
                                </div>
                            </a>

                            <a href="{{ route('locations.index') }}"
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

                <!-- Location Stats -->
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
                                    {{ $location->created_at->format('d/m/Y') }}
                                </span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">
                                    <i class="fas fa-edit mr-1"></i>
                                    Cập nhật lần cuối
                                </span>
                                <span class="text-sm font-medium text-gray-900">
                                    {{ $location->updated_at->format('d/m/Y') }}
                                </span>
                            </div>
                            @if ($location->children && $location->children->count() > 0)
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">
                                        <i class="fas fa-sitemap mr-1"></i>
                                        Địa điểm con
                                    </span>
                                    <span class="text-sm font-medium text-gray-900">
                                        {{ $location->children->count() }}
                                    </span>
                                </div>
                            @endif
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
                type: '{{ $location->type }}',
                name: '{{ $location->name }}',
                parent_id: '{{ $location->parent_id }}'
            };

            // Form utilities
            function resetForm() {
                if (confirm('Bạn có chắc chắn muốn khôi phục về giá trị ban đầu?')) {
                    document.getElementById('type').value = originalValues.type;
                    document.getElementById('name').value = originalValues.name;
                    document.getElementById('parent_id').value = originalValues.parent_id || '';
                }
            }

            // Dynamic form behavior
            document.addEventListener('DOMContentLoaded', function() {
                const typeSelect = document.getElementById('type');
                const parentSelect = document.getElementById('parent_id');
                const nameInput = document.getElementById('name');
                const currentLocationId = {{ $location->id }};

                // Filter parent options based on type selection
                function filterParentOptions() {
                    const selectedType = typeSelect.value;
                    const parentOptions = parentSelect.querySelectorAll('option');

                    parentOptions.forEach(option => {
                        if (option.value === '') {
                            option.style.display = 'block';
                            return;
                        }

                        // Don't show current location as parent option
                        if (option.value == currentLocationId) {
                            option.style.display = 'none';
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
                    if (parentSelect.value && parentSelect.querySelector(`option[value="${parentSelect.value}"]`).style
                        .display === 'none') {
                        parentSelect.value = '';
                    }
                }

                // Initialize filtering
                filterParentOptions();

                // Update filtering on type change
                typeSelect.addEventListener('change', filterParentOptions);

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

                // Trigger initial character count
                nameInput.dispatchEvent(new Event('input'));

                // Warn about unsaved changes
                let formChanged = false;
                const form = document.querySelector('form');
                const inputs = form.querySelectorAll('input, select');

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
