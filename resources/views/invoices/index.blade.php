<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <i class="fas fa-file-invoice mr-2 text-blue-600"></i>
                {{ __('Quản lý Hóa đơn') }}
            </h2>
            <a href="{{ route('invoices.create') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200 flex items-center">
                <i class="fas fa-plus mr-2"></i>
                Thêm hóa đơn
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Filter Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <form method="GET" action="{{ route('invoices.index') }}" class="flex flex-col md:flex-row gap-4">
                        <div class="flex-1">
                            <select name="tenant_id"
                                class="block w-full py-2 px-3 border border-gray-300 rounded-md leading-5 bg-white focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Tất cả người thuê</option>
                                @foreach ($tenants as $tenant)
                                    <option value="{{ $tenant->id }}"
                                        {{ request('tenant_id') == $tenant->id ? 'selected' : '' }}>
                                        {{ $tenant->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex-1">
                            <select name="landlord_id"
                                class="block w-full py-2 px-3 border border-gray-300 rounded-md leading-5 bg-white focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Tất cả chủ nhà</option>
                                @foreach ($landlords as $landlord)
                                    <option value="{{ $landlord->id }}"
                                        {{ request('landlord_id') == $landlord->id ? 'selected' : '' }}>
                                        {{ $landlord->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex-1">
                            <select name="status"
                                class="block w-full py-2 px-3 border border-gray-300 rounded-md leading-5 bg-white focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Tất cả trạng thái</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Chờ xử lý
                                </option>
                                <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Đã thanh
                                    toán</option>
                                <option value="overdue" {{ request('status') == 'overdue' ? 'selected' : '' }}>Quá hạn
                                </option>
                            </select>
                        </div>
                        <div class="flex gap-2">
                            <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200 flex items-center">
                                <i class="fas fa-filter mr-2"></i>
                                Lọc
                            </button>
                            @if (request('tenant_id') || request('landlord_id') || request('status'))
                                <a href="{{ route('invoices.index') }}"
                                    class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg transition duration-200 flex items-center">
                                    <i class="fas fa-times mr-2"></i>
                                    Xóa bộ lọc
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <!-- Invoices Table -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if ($invoices->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            <i class="fas fa-user mr-1"></i>Người thuê
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            <i class="fas fa-user-tie mr-1"></i>Chủ nhà
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            <i class="fas fa-info-circle mr-1"></i>Trạng thái
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            <i class="fas fa-cogs mr-1"></i>Thao tác
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($invoices as $item)
                                        <tr class="hover:bg-gray-50 transition duration-150 ease-in-out">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                {{ $item->tenant->name ?? 'N/A' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $item->contract->landlord->name ?? 'N/A' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if ($item->status == 'pending')
                                                    <span
                                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                        Chờ xử lý
                                                    </span>
                                                @elseif ($item->status == 'paid')
                                                    <span
                                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                        Đã thanh toán
                                                    </span>
                                                @elseif ($item->status == 'overdue')
                                                    <span
                                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                        Quá hạn
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <div class="flex items-center space-x-2">
                                                    <a href="{{ route('invoices.show', $item->id) }}"
                                                        class="text-blue-600 hover:text-blue-900 transition duration-150 ease-in-out">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('invoices.edit', $item->id) }}"
                                                        class="text-yellow-600 hover:text-yellow-900 transition duration-150 ease-in-out">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form method="POST"
                                                        action="{{ route('invoices.destroy', $item->id) }}"
                                                        class="inline"
                                                        onsubmit="return confirm('Bạn có chắc chắn muốn xóa hóa đơn này không?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="text-red-600 hover:text-red-900 transition duration-150 ease-in-out">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="mt-6">
                            {{ $invoices->appends(request()->query())->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="mx-auto h-12 w-12 text-gray-400">
                                <i class="fas fa-file-invoice text-4xl"></i>
                            </div>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Không có hóa đơn nào</h3>
                            <p class="mt-1 text-sm text-gray-500">
                                @if (request('tenant_id') || request('landlord_id') || request('status'))
                                    Không tìm thấy hóa đơn nào phù hợp với bộ lọc
                                @else
                                    Bắt đầu bằng cách tạo một hóa đơn mới.
                                @endif
                            </p>
                            <div class="mt-6">
                                <a href="{{ route('invoices.create') }}"
                                    class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <i class="fas fa-plus mr-2"></i>
                                    Thêm hóa đơn đầu tiên
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Auto-submit filter form on select change
            document.addEventListener('DOMContentLoaded', function() {
                const selects = document.querySelectorAll('select');
                selects.forEach(select => {
                    select.addEventListener('change', function() {
                        this.form.submit();
                    });
                });
            });
        </script>
    @endpush
</x-app-layout>
