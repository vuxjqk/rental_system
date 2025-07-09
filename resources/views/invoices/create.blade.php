<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <a href="{{ route('invoices.index') }}"
                    class="text-gray-600 hover:text-gray-900 mr-4 transition duration-200">
                    <i class="fas fa-arrow-left text-lg"></i>
                </a>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    <i class="fas fa-plus-circle mr-2 text-green-600"></i>
                    {{ __('Thêm hóa đơn mới') }}
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Form Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('invoices.store') }}" class="space-y-6">
                        @csrf

                        <!-- Form Header -->
                        <div class="border-b border-gray-200 pb-4">
                            <h3 class="text-lg font-medium text-gray-900">
                                <i class="fas fa-file-invoice mr-2 text-blue-600"></i>
                                Thông tin hóa đơn
                            </h3>
                            <p class="mt-1 text-sm text-gray-600">
                                Vui lòng điền đầy đủ thông tin để tạo hóa đơn mới trong hệ thống.
                            </p>
                        </div>

                        <!-- Contract -->
                        <div>
                            <label for="contract_id" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-file-contract mr-1 text-blue-600"></i>
                                Hợp đồng <span class="text-red-500">*</span>
                            </label>
                            <select id="contract_id" name="contract_id" required
                                class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('contract_id') border-red-500 @enderror">
                                <option value="">Chọn hợp đồng</option>
                                @foreach ($contracts as $contract)
                                    <option value="{{ $contract->id }}"
                                        {{ old('contract_id') == $contract->id ? 'selected' : '' }}>
                                        Hợp đồng #{{ $contract->id }} - {{ $contract->tenant->name ?? 'N/A' }}
                                    </option>
                                @endforeach
                            </select>
                            @error('contract_id')
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

                        <!-- Invoice Items -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-list-ul mr-1 text-purple-600"></i>
                                Chi tiết hóa đơn <span class="text-red-500">*</span>
                            </label>
                            <div id="invoice-items" class="space-y-4">
                                <!-- Initial item -->
                                <div class="invoice-item flex flex-col md:flex-row gap-4 items-end">
                                    <div class="flex-1">
                                        <label for="descriptions[0]"
                                            class="block text-sm font-medium text-gray-700 mb-1">
                                            Mô tả
                                        </label>
                                        <input type="text" name="descriptions[0]" id="descriptions[0]"
                                            value="{{ old('descriptions.0') }}" required maxlength="100"
                                            placeholder="Nhập mô tả chi tiết..."
                                            class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('descriptions.0') border-red-500 @enderror">
                                        @error('descriptions.0')
                                            <p class="mt-1 text-sm text-red-600">
                                                <i class="fas fa-exclamation-circle mr-1"></i>
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>
                                    <div class="flex-1">
                                        <label for="amounts[0]" class="block text-sm font-medium text-gray-700 mb-1">
                                            Số tiền (VND)
                                        </label>
                                        <input type="number" name="amounts[0]" id="amounts[0]"
                                            value="{{ old('amounts.0') }}" required min="0" step="0.01"
                                            placeholder="Nhập số tiền..."
                                            class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('amounts.0') border-red-500 @enderror">
                                        @error('amounts.0')
                                            <p class="mt-1 text-sm text-red-600">
                                                <i class="fas fa-exclamation-circle mr-1"></i>
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>
                                    <button type="button" class="remove-item text-red-600 hover:text-red-900"
                                        style="display: none;">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                            <button type="button" id="add-item"
                                class="mt-4 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200 flex items-center">
                                <i class="fas fa-plus mr-2"></i>
                                Thêm chi tiết
                            </button>
                        </div>

                        <!-- Form Actions -->
                        <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-200">
                            <a href="{{ route('invoices.index') }}"
                                class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-6 rounded-lg transition duration-200 flex items-center">
                                <i class="fas fa-times mr-2"></i>
                                Hủy bỏ
                            </a>
                            <button type="submit"
                                class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded-lg transition duration-200 flex items-center">
                                <i class="fas fa-save mr-2"></i>
                                Lưu hóa đơn
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
                        <a href="{{ route('invoices.index') }}"
                            class="flex items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition duration-200">
                            <i class="fas fa-list text-blue-600 mr-3"></i>
                            <div>
                                <p class="font-medium text-blue-900">Xem danh sách</p>
                                <p class="text-sm text-blue-700">Quay lại danh sách hóa đơn</p>
                            </div>
                        </a>
                        <button type="button" onclick="document.getElementById('contract_id').focus()"
                            class="flex items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition duration-200">
                            <i class="fas fa-edit text-green-600 mr-3"></i>
                            <div>
                                <p class="font-medium text-green-900">Tiếp tục nhập</p>
                                <p class="text-sm text-green-700">Focus vào trường hợp đồng</p>
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
                    document.getElementById('contract_id').focus();
                    // Reset invoice items to one
                    const itemsContainer = document.getElementById('invoice-items');
                    itemsContainer.innerHTML = `
                        <div class="invoice-item flex flex-col md:flex-row gap-4 items-end">
                            <div class="flex-1">
                                <label for="descriptions[0]" class="block text-sm font-medium text-gray-700 mb-1">
                                    Mô tả
                                </label>
                                <input type="text" name="descriptions[0]" id="descriptions[0]" required maxlength="100"
                                    placeholder="Nhập mô tả chi tiết..."
                                    class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div class="flex-1">
                                <label for="amounts[0]" class="block text-sm font-medium text-gray-700 mb-1">
                                    Số tiền (VND)
                                </label>
                                <input type="number" name="amounts[0]" id="amounts[0]" required min="0" step="0.01"
                                    placeholder="Nhập số tiền..."
                                    class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <button type="button" class="remove-item text-red-600 hover:text-red-900" style="display: none;">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    `;
                }
            }

            document.addEventListener('DOMContentLoaded', function() {
                const contractSelect = document.getElementById('contract_id');
                const tenantSelect = document.getElementById('tenant_id');
                const addItemButton = document.getElementById('add-item');
                const itemsContainer = document.getElementById('invoice-items');
                let itemCount = 1;

                // Auto-focus next field
                contractSelect.addEventListener('change', function() {
                    if (this.value) {
                        tenantSelect.focus();
                    }
                });

                tenantSelect.addEventListener('change', function() {
                    if (this.value) {
                        document.getElementById('descriptions[0]').focus();
                    }
                });

                // Add new invoice item
                addItemButton.addEventListener('click', function() {
                    const newItem = document.createElement('div');
                    newItem.className = 'invoice-item flex flex-col md:flex-row gap-4 items-end';
                    newItem.innerHTML = `
                        <div class="flex-1">
                            <label for="descriptions[${itemCount}]" class="block text-sm font-medium text-gray-700 mb-1">
                                Mô tả
                            </label>
                            <input type="text" name="descriptions[${itemCount}]" id="descriptions[${itemCount}]"
                                required maxlength="100"
                                placeholder="Nhập mô tả chi tiết..."
                                class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div class="flex-1">
                            <label for="amounts[${itemCount}]" class="block text-sm font-medium text-gray-700 mb-1">
                                Số tiền (VND)
                            </label>
                            <input type="number" name="amounts[${itemCount}]" id="amounts[${itemCount}]"
                                required min="0" step="0.01"
                                placeholder="Nhập số tiền..."
                                class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <button type="button" class="remove-item text-red-600 hover:text-red-900">
                            <i class="fas fa-trash"></i>
                        </button>
                    `;
                    itemsContainer.appendChild(newItem);
                    itemCount++;

                    // Show remove buttons when more than one item
                    const removeButtons = document.querySelectorAll('.remove-item');
                    removeButtons.forEach(button => {
                        button.style.display = itemCount > 1 ? 'block' : 'none';
                    });

                    // Focus on new description field
                    document.getElementById(`descriptions[${itemCount - 1}]`).focus();
                });

                // Remove invoice item
                itemsContainer.addEventListener('click', function(e) {
                    if (e.target.closest('.remove-item')) {
                        const item = e.target.closest('.invoice-item');
                        item.remove();
                        itemCount--;

                        // Update indices of remaining items
                        const items = document.querySelectorAll('.invoice-item');
                        items.forEach((item, index) => {
                            const descriptionInput = item.querySelector('input[name^="descriptions"]');
                            const amountInput = item.querySelector('input[name^="amounts"]');
                            descriptionInput.name = `descriptions[${index}]`;
                            descriptionInput.id = `descriptions[${index}]`;
                            descriptionInput.nextElementSibling?.setAttribute('for',
                                `descriptions[${index}]`);
                            amountInput.name = `amounts[${index}]`;
                            amountInput.id = `amounts[${index}]`;
                            amountInput.nextElementSibling?.setAttribute('for', `amounts[${index}]`);
                        });

                        // Hide remove buttons if only one item remains
                        const removeButtons = document.querySelectorAll('.remove-item');
                        removeButtons.forEach(button => {
                            button.style.display = itemCount > 1 ? 'block' : 'none';
                        });
                    }
                });
            });
        </script>
    @endpush
</x-app-layout>
