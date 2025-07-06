<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <a href="{{ route('contracts.index') }}"
                    class="text-gray-600 hover:text-gray-900 mr-4 transition duration-200">
                    <i class="fas fa-arrow-left text-lg"></i>
                </a>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    <i class="fas fa-edit mr-2 text-yellow-600"></i>
                    {{ __('Chỉnh sửa hợp đồng') }}
                </h2>
            </div>
            <div class="flex items-center space-x-2">
                <a href="{{ route('contracts.show', $contract->id) }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200 flex items-center">
                    <i class="fas fa-eye mr-2"></i>
                    Xem chi tiết
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Current Contract Info Card -->
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-lg p-6 mb-6">
                <div class="flex items-center">
                    <i class="fas fa-file-contract text-blue-600 text-2xl mr-4"></i>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">
                            Hợp đồng #{{ $contract->id }}
                        </h3>
                        <p class="text-sm text-gray-600">
                            <i class="fas fa-home mr-1"></i>
                            {{ $contract->property->name ?? 'Bất động sản #' . $contract->property->id }}
                            • Trạng thái:
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
                        <p class="text-xs text-gray-500">
                            <i class="fas fa-clock mr-1"></i>
                            Tạo: {{ $contract->created_at->format('d/m/Y H:i') }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Form Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('contracts.update', $contract->id) }}" class="space-y-6"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Form Header -->
                        <div class="border-b border-gray-200 pb-4">
                            <h3 class="text-lg font-medium text-gray-900">
                                <i class="fas fa-info-circle mr-2 text-blue-600"></i>
                                Cập nhật thông tin hợp đồng
                            </h3>
                            <p class="mt-1 text-sm text-gray-600">
                                Chỉnh sửa thông tin hợp đồng trong hệ thống. Các trường có dấu (*) là bắt buộc.
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
                                        {{ (old('property_id') ?? $contract->property_id) == $property->id ? 'selected' : '' }}>
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
                                        {{ (old('tenant_id') ?? $contract->tenant_id) == $tenant->id ? 'selected' : '' }}>
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
                                        {{ (old('landlord_id') ?? $contract->landlord_id) == $landlord->id ? 'selected' : '' }}>
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
                            <input type="date" id="start_date" name="start_date"
                                value="{{ old('start_date') ?? $contract->start_date->format('Y-m-d') }}" required
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
                            <input type="date" id="end_date" name="end_date"
                                value="{{ old('end_date') ?? $contract->end_date->format('Y-m-d') }}" required
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
                            <input type="number" id="deposit" name="deposit"
                                value="{{ old('deposit') ?? $contract->deposit }}" required min="0"
                                step="0.01" placeholder="Nhập số tiền cọc..."
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
                                value="{{ old('monthly_rent') ?? $contract->monthly_rent }}" required min="0"
                                step="0.01" placeholder="Nhập tiền thuê hàng tháng..."
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

                        <!-- Status -->
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-info mr-1 text-green-600"></i>
                                Trạng thái <span class="text-red-500">*</span>
                            </label>
                            <select id="status" name="status" required
                                class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('status') border-red-500 @enderror">
                                <option value="">Chọn trạng thái</option>
                                <option value="active"
                                    {{ (old('status') ?? $contract->status) == 'active' ? 'selected' : '' }}>
                                    Đang hoạt động
                                </option>
                                <option value="terminated"
                                    {{ (old('status') ?? $contract->status) == 'terminated' ? 'selected' : '' }}>
                                    Đã chấm dứt
                                </option>
                                <option value="expired"
                                    {{ (old('status') ?? $contract->status) == 'expired' ? 'selected' : '' }}>
                                    Hết hạn
                                </option>
                            </select>
                            @error('status')
                                <p class="mt-1 text-sm text-red-600">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Contract File -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-file-pdf mr-1 text-yellow-600"></i>
                                Tệp hợp đồng hiện tại
                            </label>
                            @if ($contract->contract_file_url)
                                <div class="flex items-center mb-2">
                                    <a href="{{ Storage::url($contract->contract_file_url) }}" target="_blank"
                                        class="text-blue-600 hover:text-blue-900 flex items-center">
                                        <i class="fas fa-download mr-2"></i>
                                        Tải xuống tệp hợp đồng
                                    </a>
                                    <label class="ml-4 flex items-center">
                                        <input type="checkbox" name="remove_contract_file" value="1"
                                            class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300 rounded">
                                        <span class="ml-2 text-sm text-red-600">Xóa tệp hợp đồng</span>
                                    </label>
                                </div>
                            @else
                                <p class="text-gray-900 mb-2">Không có tệp hợp đồng</p>
                            @endif
                            <label for="contract_file_url" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-upload mr-1 text-blue-600"></i>
                                Tải lên tệp hợp đồng mới
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
                                Chấp nhận các định dạng: PDF, DOC, DOCX. Kích thước tối đa: 2MB.
                            </p>
                        </div>

                        <!-- Form Actions -->
                        <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-200">
                            <a href="{{ route('contracts.index') }}"
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
                            <a href="{{ route('contracts.show', $contract->id) }}"
                                class="flex items-center p-3 bg-blue-50 rounded-lg hover:bg-blue-100 transition duration-200">
                                <i class="fas fa-eye text-blue-600 mr-3"></i>
                                <div>
                                    <p class="font-medium text-blue-900">Xem chi tiết</p>
                                    <p class="text-sm text-blue-700">Xem thông tin đầy đủ</p>
                                </div>
                            </a>
                            <a href="{{ route('contracts.index') }}"
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

                <!-- Contract Stats -->
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
                                    {{ $contract->created_at->format('d/m/Y') }}
                                </span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">
                                    <i class="fas fa-edit mr-1"></i>
                                    Cập nhật lần cuối
                                </span>
                                <span class="text-sm font-medium text-gray-900">
                                    {{ $contract->updated_at->format('d/m/Y') }}
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
                property_id: '{{ $contract->property_id }}',
                tenant_id: '{{ $contract->tenant_id }}',
                landlord_id: '{{ $contract->landlord_id }}',
                start_date: '{{ $contract->start_date->format('Y-m-d') }}',
                end_date: '{{ $contract->end_date->format('Y-m-d') }}',
                deposit: '{{ $contract->deposit }}',
                monthly_rent: '{{ $contract->monthly_rent }}',
                status: '{{ $contract->status }}',
                remove_contract_file: false,
                contract_file_url: null
            };

            // Form utilities
            function resetForm() {
                if (confirm('Bạn có chắc chắn muốn khôi phục về giá trị ban đầu?')) {
                    document.getElementById('property_id').value = originalValues.property_id;
                    document.getElementById('tenant_id').value = originalValues.tenant_id;
                    document.getElementById('landlord_id').value = originalValues.landlord_id;
                    document.getElementById('start_date').value = originalValues.start_date;
                    document.getElementById('end_date').value = originalValues.end_date;
                    document.getElementById('deposit').value = originalValues.deposit;
                    document.getElementById('monthly_rent').value = originalValues.monthly_rent;
                    document.getElementById('status').value = originalValues.status;
                    document.getElementById('contract_file_url').value = '';
                    document.querySelector('input[name="remove_contract_file"]').checked = originalValues.remove_contract_file;
                }
            }

            // Dynamic form behavior
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
