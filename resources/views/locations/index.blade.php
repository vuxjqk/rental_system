<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <i class="fas fa-map-marker-alt mr-2 text-blue-600"></i>
                {{ __('Quản lý Địa điểm') }}
            </h2>
            <a href="{{ route('locations.create') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200 flex items-center">
                <i class="fas fa-plus mr-2"></i>
                Thêm địa điểm
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Search and Filter Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <form method="GET" action="{{ route('locations.index') }}"
                        class="flex flex-col md:flex-row gap-4">
                        <div class="flex-1">
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-search text-gray-400"></i>
                                </div>
                                <input type="text" name="search" value="{{ $search }}"
                                    placeholder="Tìm kiếm địa điểm..."
                                    class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200 flex items-center">
                                <i class="fas fa-search mr-2"></i>
                                Tìm kiếm
                            </button>
                            @if ($search)
                                <a href="{{ route('locations.index') }}"
                                    class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg transition duration-200 flex items-center">
                                    <i class="fas fa-times mr-2"></i>
                                    Xóa bộ lọc
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-blue-100 mr-4">
                                <i class="fas fa-city text-blue-600 text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-600">Tổng thành phố</p>
                                <p class="text-2xl font-bold text-gray-900">
                                    {{ $locations->where('type', 'city')->count() }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-green-100 mr-4">
                                <i class="fas fa-building text-green-600 text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-600">Tổng quận/huyện</p>
                                <p class="text-2xl font-bold text-gray-900">
                                    {{ $locations->where('type', 'district')->count() }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-purple-100 mr-4">
                                <i class="fas fa-map-marked-alt text-purple-600 text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-600">Tổng phường/xã</p>
                                <p class="text-2xl font-bold text-gray-900">
                                    {{ $locations->where('type', 'ward')->count() }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Locations Table -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if ($locations->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            <i class="fas fa-hashtag mr-1"></i>ID
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            <i class="fas fa-map-marker-alt mr-1"></i>Tên địa điểm
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            <i class="fas fa-layer-group mr-1"></i>Loại
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            <i class="fas fa-sitemap mr-1"></i>Cấp cha
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            <i class="fas fa-clock mr-1"></i>Ngày tạo
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            <i class="fas fa-cogs mr-1"></i>Thao tác
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($locations as $location)
                                        <tr class="hover:bg-gray-50 transition duration-150 ease-in-out">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                #{{ $location->id }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    @if ($location->type == 'city')
                                                        <i class="fas fa-city text-blue-600 mr-2"></i>
                                                    @elseif($location->type == 'district')
                                                        <i class="fas fa-building text-green-600 mr-2"></i>
                                                    @else
                                                        <i class="fas fa-map-marked-alt text-purple-600 mr-2"></i>
                                                    @endif
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ $location->name }}
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if ($location->type == 'city')
                                                    <span
                                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                        <i class="fas fa-city mr-1"></i>Thành phố
                                                    </span>
                                                @elseif($location->type == 'district')
                                                    <span
                                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                        <i class="fas fa-building mr-1"></i>Quận/Huyện
                                                    </span>
                                                @else
                                                    <span
                                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                                        <i class="fas fa-map-marked-alt mr-1"></i>Phường/Xã
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                @if ($location->parent_id)
                                                    <div class="flex items-center">
                                                        <i class="fas fa-arrow-up text-gray-400 mr-2"></i>
                                                        {{ $location->parent->name ?? 'N/A' }}
                                                    </div>
                                                @else
                                                    <span class="text-gray-400">
                                                        <i class="fas fa-minus mr-1"></i>Cấp gốc
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                <div class="flex items-center">
                                                    <i class="fas fa-calendar-alt text-gray-400 mr-2"></i>
                                                    {{ $location->created_at->format('d/m/Y') }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <div class="flex items-center space-x-2">
                                                    <a href="{{ route('locations.show', $location->id) }}"
                                                        class="text-blue-600 hover:text-blue-900 transition duration-150 ease-in-out">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('locations.edit', $location->id) }}"
                                                        class="text-yellow-600 hover:text-yellow-900 transition duration-150 ease-in-out">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form method="POST"
                                                        action="{{ route('locations.destroy', $location->id) }}"
                                                        class="inline"
                                                        onsubmit="return confirm('Bạn có chắc chắn muốn xóa địa điểm này không?')">
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
                            {{ $locations->appends(request()->query())->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="mx-auto h-12 w-12 text-gray-400">
                                <i class="fas fa-map-marker-alt text-4xl"></i>
                            </div>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Không có địa điểm nào</h3>
                            <p class="mt-1 text-sm text-gray-500">
                                @if ($search)
                                    Không tìm thấy địa điểm nào phù hợp với từ khóa "{{ $search }}"
                                @else
                                    Bắt đầu bằng cách tạo một địa điểm mới.
                                @endif
                            </p>
                            <div class="mt-6">
                                <a href="{{ route('locations.create') }}"
                                    class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <i class="fas fa-plus mr-2"></i>
                                    Thêm địa điểm đầu tiên
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
            // Auto-submit search form on Enter key
            document.addEventListener('DOMContentLoaded', function() {
                const searchInput = document.querySelector('input[name="search"]');
                if (searchInput) {
                    searchInput.addEventListener('keypress', function(e) {
                        if (e.key === 'Enter') {
                            e.preventDefault();
                            this.form.submit();
                        }
                    });
                }
            });
        </script>
    @endpush
</x-app-layout>
