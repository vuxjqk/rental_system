<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <a href="{{ route('amenities.index') }}"
                    class="text-gray-600 hover:text-gray-900 mr-4 transition duration-200">
                    <i class="fas fa-arrow-left text-lg"></i>
                </a>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    <i class="fas fa-edit mr-2 text-yellow-600"></i>
                    {{ __('Chỉnh sửa tiện ích') }}
                </h2>
            </div>
            <div class="flex items-center space-x-2">
                <a href="{{ route('amenities.show', $amenity->id) }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200 flex items-center">
                    <i class="fas fa-eye mr-2"></i>
                    Xem chi tiết
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Current Amenity Info Card -->
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-lg p-6 mb-6">
                <div class="flex items-center">
                    <i class="fas fa-concierge-bell text-blue-600 text-2xl mr-4"></i>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">{{ $amenity->name }}</h3>
                        <p class="text-sm text-gray-600">
                            <i class="fas fa-align-left mr-1"></i>
                            {{ $amenity->description ?? 'Không có mô tả' }}
                        </p>
                        <p class="text-xs text-gray-500">
                            <i class="fas fa-clock mr-1"></i>
                            ID: #{{ $amenity->id }} • Tạo: {{ $amenity->created_at->format('d/m/Y H:i') }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Form Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('amenities.update', $amenity->id) }}" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Form Header -->
                        <div class="border-b border-gray-200 pb-4">
                            <h3 class="text-lg font-medium text-gray-900">
                                <i class="fas fa-info-circle mr-2 text-blue-600"></i>
                                Cập nhật thông tin tiện ích
                            </h3>
                            <p class="mt-1 text-sm text-gray-600">
                                Chỉnh sửa thông tin tiện ích trong hệ thống. Các trường có dấu (*) là bắt buộc.
                            </p>
                        </div>

                        <!-- Amenity Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-concierge-bell mr-1 text-blue-600"></i>
                                Tên tiện ích <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="name" name="name"
                                value="{{ old('name') ?? $amenity->name }}" required maxlength="50"
                                placeholder="Nhập tên tiện ích..."
                                class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                            <p class="mt-1 text-sm text-gray-500">
                                <i class="fas fa-info mr-1"></i>
                                Tối đa 50 ký tự
                            </p>
                        </div>

                        <!-- Amenity Description -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-align-left mr-1 text-green-600"></i>
                                Mô tả
                            </label>
                            <textarea id="description" name="description" rows="4" placeholder="Nhập mô tả tiện ích (không bắt buộc)..."
                                class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('description') border-red-500 @enderror">{{ old('description') ?? $amenity->description }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                            <p class="mt-1 text-sm text-gray-500">
                                <i class="fas fa-lightbulb mr-1"></i>
                                Mô tả chi tiết về tiện ích (nếu có)
                            </p>
                        </div>

                        <!-- Form Actions -->
                        <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-200">
                            <a href="{{ route('amenities.index') }}"
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
                            <a href="{{ route('amenities.show', $amenity->id) }}"
                                class="flex items-center p-3 bg-blue-50 rounded-lg hover:bg-blue-100 transition duration-200">
                                <i class="fas fa-eye text-blue-600 mr-3"></i>
                                <div>
                                    <p class="font-medium text-blue-900">Xem chi tiết</p>
                                    <p class="text-sm text-blue-700">Xem thông tin đầy đủ</p>
                                </div>
                            </a>
                            <a href="{{ route('amenities.index') }}"
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

                <!-- Amenity Stats -->
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
                                    {{ $amenity->created_at->format('d/m/Y') }}
                                </span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">
                                    <i class="fas fa-edit mr-1"></i>
                                    Cập nhật lần cuối
                                </span>
                                <span class="text-sm font-medium text-gray-900">
                                    {{ $amenity->updated_at->format('d/m/Y') }}
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
                name: '{{ $amenity->name }}',
                description: '{{ $amenity->description ?? '' }}'
            };

            // Form utilities
            function resetForm() {
                if (confirm('Bạn có chắc chắn muốn khôi phục về giá trị ban đầu?')) {
                    document.getElementById('name').value = originalValues.name;
                    document.getElementById('description').value = originalValues.description;
                }
            }

            // Dynamic form behavior
            document.addEventListener('DOMContentLoaded', function() {
                const nameInput = document.getElementById('name');
                const descriptionInput = document.getElementById('description');

                // Character counter for name field
                nameInput.addEventListener('input', function() {
                    const maxLength = 50;
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

                // Auto-focus next field
                nameInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        descriptionInput.focus();
                    }
                });

                // Warn about unsaved changes
                let formChanged = false;
                const form = document.querySelector('form');
                const inputs = form.querySelectorAll('input, textarea');

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
