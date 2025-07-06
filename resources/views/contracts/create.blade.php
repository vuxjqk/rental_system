<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <a href="{{ route('contracts.index') }}"
                    class="text-gray-600 hover:text-gray-900 mr-4 transition duration-200">
                    <i class="fas fa-arrow-left text-lg"></i>
                </a>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    <i class="fas fa-plus-circle mr-2 text-green-600"></i>
                    {{ __('Thêm hợp đồng mới') }}
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Form Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('contracts.store') }}" class="space-y-6"
                        enctype="multipart/form-data">
                        @csrf

                        <!-- Form Header -->
                        <div class="border-b border-gray-200 pb-4">
                            <h3 class="text-lg font-medium text-gray-900">
                                <i class="fas fa-info-circle mr-2 text-blue-600"></i>
                                Thông tin hợp đồng
                            </h3>
                            <p class="mt-1 text-sm text-gray-600">
                                Vui lòng điền đầy đủ thông tin để tạo hợp đồng mới trong hệ thống.
                            </p>
                        </div>

                        <!-- Property -->
                        <div>
                            <label for="property_id" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-home mr-1 text-blue-600"></i>
                                Bất động sản <span class="text-red-500">*</span>
                            </label>
                            <select id="property_id" name="property_id" required
                                class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('property_id') border-red-500 @enderror">
                                <option value="">Chọn bất động sản</option>
                                @foreach ($properties as $property)
                                    <option value="{{ $property->id }}"
                                        {{ old('property_id') == $property->id ? 'selected' : '' }}>
                                        {{ $property->name ?? 'Bất động sản #' . $property->id }}
                                    </option>
                                @endforeach
                            </select>
                            @error('property_id')
                                <p class="mt-1 text-sm text-red-600">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Tenant -->
                        <div>
                            <label for="tenant_id" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-user mr-1 text-green-600"></i>
                                Người thuê <span class="text-red-500">*</span>
                            </label>
                            <select id="tenant_id" name="tenant_id" required
                                class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('tenant_id') border-red-500 @enderror">
                                <option value="">Chọn người thuê</option>
                                @foreach ($tenants as $tenant)
                                    <option value="{{ $tenant->id }}"
                                        {{ old('tenant_id') == $tenant->id ? 'selected' : '' }}>
                                        {{ $tenant->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('tenant_id')
                                <p class="mt-1 text-sm text-red-600">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Landlord -->
                        <div>
                            <label for="landlord_id" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-user-tie mr-1 text-purple-600"></i>
                                Chủ nhà <span class="text-red-500">*</span>
                            </label>
                            <select id="landlord_id" name="landlord_id" required
                                class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('landlord_id') border-red-500 @enderror">
                                <option value="">Chọn chủ nhà</option>
                                @foreach ($landlords as $landlord)
                                    <option value="{{ $landlord->id }}"
                                        {{ old('landlord_id') == $landlord->id ? 'selected' : '' }}>
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

                        <!-- Start Date -->
                        <div>
                            <label for="start_date" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-calendar-alt mr-1 text-blue-600"></i>
                                Ngày bắt đầu <span class="text-red-500">*</span>
                            </label>
                            <input type="date" id="start_date" name="start_date" value="{{ old('start_date') }}"
                                required
                                class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('start_date') border-red-500 @enderror">
                            @error('start_date')
                                <p class="mt-1 text-sm text-red-600">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- End Date -->
                        <div>
                            <label for="end_date" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-calendar-alt mr-1 text-blue-600"></i>
                                Ngày kết thúc <span class="text-red-500">*</span>
                            </label>
                            <input type="date" id="end_date" name="end_date" value="{{ old('end_date') }}" required
                                class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('end_date') border-red-500 @enderror">
                            @error('end_date')
                                <p class="mt-1 text-sm text-red-600">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Deposit -->
                        <div>
                            <label for="deposit" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-dollar-sign mr-1 text-green-600"></i>
                                Tiền cọc <span class="text-red-500">*</span>
                            </label>
                            <input type="number" id="deposit" name="deposit" value="{{ old('deposit') }}" required
                                min="0" step="0.01" placeholder="Nhập số tiền cọc..."
                                class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('deposit') border-red-500 @enderror">
                            @error('deposit')
                                <p class="mt-1 text-sm text-red-600">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                            <p class="mt-1 text-sm text-gray-500">
                                <i class="fas fa-info mr-1"></i>
                                Nhập số tiền cọc (VND)
                            </p>
                        </div>

                        <!-- Monthly Rent -->
                        <div>
                            <label for="monthly_rent" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-dollar-sign mr-1 text-green-600"></i>
                                Tiền thuê hàng tháng <span class="text-red-500">*</span>
                            </label>
                            <input type="number" id="monthly_rent" name="monthly_rent"
                                value="{{ old('monthly_rent') }}" required min="0" step="0.01"
                                placeholder="Nhập tiền thuê hàng tháng..."
                                class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('monthly_rent') border-red-500 @enderror">
                            @error('monthly_rent')
                                <p class="mt-1 text-sm text-red-600">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                            <p class="mt-1 text-sm text-gray-500">
                                <i class="fas fa-info mr-1"></i>
                                Nhập tiền thuê hàng tháng (VND)
                            </p>
                        </div>

                        <!-- Contract File -->
                        <div>
                            <label for="contract_file_url" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-file-pdf mr-1 text-yellow-600"></i>
                                Tệp hợp đồng
                            </label>
                            <input type="file" id="contract_file_url" name="contract_file_url"
                                accept=".pdf,.doc,.docx"
                                class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('contract_file_url') border-red-500 @enderror">
                            @error('contract_file_url')
                                <p class="mt-1 text-sm text-red-600">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                            <p class="mt-1 text-sm text-gray-500">
                                <i class="fas fa-info mr-1"></i>
                                Tải lên tệp PDF, DOC hoặc DOCX (tối đa 2MB)
                            </p>
                        </div>

                        <!-- Form Actions -->
                        <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-200">
                            <a href="{{ route('contracts.index') }}"
                                class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-6 rounded-lg transition duration-200 flex items-center">
                                <i class="fas fa-times mr-2"></i>
                                Hủy bỏ
                            </a>
                            <button type="submit"
                                class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded-lg transition duration-200 flex items-center">
                                <i class="fas fa-save mr-2"></i>
                                Lưu hợp đồng
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
                        <a href="{{ route('contracts.index') }}"
                            class="flex items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition duration-200">
                            <i class="fas fa-list text-blue-600 mr-3"></i>
                            <div>
                                <p class="font-medium text-blue-900">Xem danh sách</p>
                                <p class="text-sm text-blue-700">Quay lại danh sách hợp đồng</p>
                            </div>
                        </a>
                        <button type="button" onclick="document.getElementById('property_id').focus()"
                            class="flex items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition duration-200">
                            <i class="fas fa-edit text-green-600 mr-3"></i>
                            <div>
                                <p class="font-medium text-green-900">Tiếp tục nhập</p>
                                <p class="text-sm text-green-700">Focus vào trường bất động sản</p>
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
                    document.getElementById('property_id').focus();
                }
            }

            document.addEventListener('DOMContentLoaded', function() {
                const propertySelect = document.getElementById('property_id');
                const tenantSelect = document.getElementById('tenant_id');
                const landlordSelect = document.getElementById('landlord_id');
                const startDateInput = document.getElementById('start_date');
                const endDateInput = document.getElementById('end_date');
                const contractFileInput = document.getElementById('contract_file_url');

                // Auto-focus next field
                propertySelect.addEventListener('change', function() {
                    if (this.value) {
                        tenantSelect.focus();
                    }
                });

                tenantSelect.addEventListener('change', function() {
                    if (this.value) {
                        landlordSelect.focus();
                    }
                });

                landlordSelect.addEventListener('change', function() {
                    if (this.value) {
                        startDateInput.focus();
                    }
                });

                startDateInput.addEventListener('change', function() {
                    if (this.value) {
                        endDateInput.focus();
                    }
                });

                // File input validation feedback
                contractFileInput.addEventListener('change', function() {
                    const file = this.files[0];
                    let errorMessage = '';
                    const maxSize = 2 * 1024 * 1024; // 2MB in bytes
                    const allowedTypes = ['application/pdf', 'application/msword',
                        'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
                    ];

                    if (file) {
                        if (!allowedTypes.includes(file.type)) {
                            errorMessage = 'Vui lòng chỉ tải lên các tệp PDF, DOC hoặc DOCX.';
                        } else if (file.size > maxSize) {
                            errorMessage = `Tệp ${file.name} vượt quá giới hạn 2MB.`;
                        }
                    }

                    let errorElement = document.getElementById('contract-file-error');
                    if (!errorElement) {
                        errorElement = document.createElement('p');
                        errorElement.id = 'contract-file-error';
                        errorElement.className = 'mt-1 text-sm text-red-600';
                        contractFileInput.parentNode.appendChild(errorElement);
                    }

                    errorElement.innerHTML = errorMessage ?
                        `<i class="fas fa-exclamation-circle mr-1"></i>${errorMessage}` : '';
                });
            });
        </script>
    @endpush
</x-app-layout>
