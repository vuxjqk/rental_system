<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <i class="fas fa-file-contract mr-2 text-blue-600"></i>
                {{ __('Quản lý Hợp đồng') }}
            </h2>
            <a href="{{ route('contracts.create') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200 flex items-center">
                <i class="fas fa-plus mr-2"></i>
                Thêm hợp đồng
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Filter Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <form method="GET" action="{{ route('contracts.index') }}"
                        class="flex flex-col md:flex-row gap-4">
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
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Đang hoạt
                                    động</option>
                                <option value="terminated" {{ request('status') == 'terminated' ? 'selected' : '' }}>Đã
                                    chấm dứt</option>
                                <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Hết hạn
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
                                <a href="{{ route('contracts.index') }}"
                                    class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg transition duration-200 flex items-center">
                                    <i class="fas fa-times mr-2"></i>
                                    Xóa bộ lọc
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <!-- Contracts Table -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if ($contract->count() > 0)
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
                                    @foreach ($contract as $item)
                                        <tr class="hover:bg-gray-50 transition duration-150 ease-in-out">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                {{ $item->tenant->name ?? 'N/A' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $item->landlord->name ?? 'N/A' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if ($item->status == 'active')
                                                    <span
                                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                        Đang hoạt động
                                                    </span>
                                                @elseif ($item->status == 'terminated')
                                                    <span
                                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                        Đã chấm dứt
                                                    </span>
                                                @elseif ($item->status == 'expired')
                                                    <span
                                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                        Hết hạn
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <div class="flex items-center space-x-2">
                                                    <a href="{{ route('contracts.show', $item->id) }}"
                                                        class="text-blue-600 hover:text-blue-900 transition duration-150 ease-in-out">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('contracts.edit', $item->id) }}"
                                                        class="text-yellow-600 hover:text-yellow-900 transition duration-150 ease-in-out">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form method="POST"
                                                        action="{{ route('contracts.destroy', $item->id) }}"
                                                        class="inline"
                                                        onsubmit="return confirm('Bạn có chắc chắn muốn xóa hợp đồng này không?')">
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
                            {{ $contract->appends(request()->query())->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="mx-auto h-12 w-12 text-gray-400">
                                <i class="fas fa-file-contract text-4xl"></i>
                            </div>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Không có hợp đồng nào</h3>
                            <p class="mt-1 text-sm text-gray-500">
                                @if (request('tenant_id') || request('landlord_id') || request('status'))
                                    Không tìm thấy hợp đồng nào phù hợp với bộ lọc
                                @else
                                    Bắt đầu bằng cách tạo một hợp đồng mới.
                                @endif
                            </p>
                            <div class="mt-6">
                                <a href="{{ route('contracts.create') }}"
                                    class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <i class="fas fa-plus mr-2"></i>
                                    Thêm hợp đồng đầu tiên
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
