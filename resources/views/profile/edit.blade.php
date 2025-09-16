<x-app-layout>
    <x-slot name="header">
        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl shadow-xl py-8 px-8">
            <div class="max-w-7xl mx-auto">
                <h2 class="font-bold text-3xl md:text-4xl leading-tight">
                    {{ __('Hồ sơ cá nhân') }}
                </h2>
                <p class="mt-2 text-indigo-100 text-lg">Quản lý thông tin cá nhân và cài đặt tài khoản</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-lg shadow-sm">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <p>{{ session('success') }}</p>
            </div>
        </div>
        @endif

        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Sidebar -->
            <aside class="lg:w-1/4">
                <div class="bg-white rounded-xl shadow-xl overflow-hidden transition-all duration-300 hover:shadow-2xl">
                    <div class="p-6 text-center border-b border-gray-100">
                        <div class="relative mx-auto h-32 w-32">
                            <img src="{{ auth()->user()->profile_photo_url ?? asset('images/default-avatar.png') }}"
                                 class="h-full w-full rounded-full object-cover ring-4 ring-indigo-100 ring-opacity-50 shadow-md"
                                 alt="Avatar">
                            <span class="absolute bottom-2 right-2 h-4 w-4 bg-green-500 rounded-full ring-2 ring-white"></span>
                        </div>
                        <h3 class="mt-4 text-xl font-semibold text-gray-900">{{ auth()->user()->name }}</h3>
                        <p class="text-sm text-gray-500 mt-1">{{ auth()->user()->email }}</p>
                    </div>
                    <nav class="divide-y divide-gray-100">
                        <a href="#basic" class="flex items-center gap-3 px-6 py-4 text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition-all duration-200 group">
                            <div class="p-2 bg-indigo-50 rounded-lg group-hover:bg-indigo-100 transition-colors duration-200">
                                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zm-4 7a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                            <span>Thông tin cơ bản</span>
                        </a>
                        <a href="#password" class="flex items-center gap-3 px-6 py-4 text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition-all duration-200 group">
                            <div class="p-2 bg-indigo-50 rounded-lg group-hover:bg-indigo-100 transition-colors duration-200">
                                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0-1.1-.9-2-2-2s-2 .9-2 2v2h4v-2zm2 5H8v-2h6v2zm6-4h-1v-1c0-2.8-2.2-5-5-5s-5 2.2-5 5v1H4v8h16v-8z"/>
                                </svg>
                            </div>
                            <span>Đổi mật khẩu</span>
                        </a>
                        <a href="#addresses" class="flex items-center gap-3 px-6 py-4 text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition-all duration-200 group">
                            <div class="p-2 bg-indigo-50 rounded-lg group-hover:bg-indigo-100 transition-colors duration-200">
                                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                </svg>
                            </div>
                            <span>Địa chỉ giao hàng</span>
                        </a>
                        <a href="#delete-account" class="flex items-center gap-3 px-6 py-4 text-red-600 hover:bg-red-50 hover:text-red-700 transition-all duration-200 group">
                            <div class="p-2 bg-red-50 rounded-lg group-hover:bg-red-100 transition-colors duration-200">
                                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </div>
                            <span>Xóa tài khoản</span>
                        </a>
                    </nav>
                </div>
            </aside>

            <!-- Main Content -->
            <section class="lg:flex-1">
                <div class="tab-content space-y-8">
                    <!-- Basic Info -->
                    <div id="basic" class="tab-pane fade show active bg-white rounded-xl shadow-xl p-8 transition-all duration-300">
                        <h4 class="text-2xl font-semibold text-gray-800 mb-6 flex items-center gap-2">
                            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zm-4 7a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            Thông tin cơ bản
                        </h4>
                        <form method="POST" action="{{ route('profile.update') }}" class="space-y-6">
                            @csrf @method('PATCH')
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Họ tên</label>
                                <input type="text" name="name"
                                       class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200"
                                       value="{{ old('name', auth()->user()->name) }}">
                                @error('name')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                <input type="email" name="email"
                                       class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200"
                                       value="{{ old('email', auth()->user()->email) }}">
                                @error('email')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <button type="submit" class="px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition duration-200 inline-flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                                </svg>
                                Lưu thay đổi
                            </button>
                        </form>
                    </div>

                    <!-- Change Password -->
                    <div id="password" class="tab-pane fade bg-white rounded-xl shadow-xl p-8 transition-all duration-300">
                        <h4 class="text-2xl font-semibold text-gray-800 mb-6 flex items-center gap-2">
                            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0-1.1-.9-2-2-2s-2 .9-2 2v2h4v-2zm2 5H8v-2h6v2zm6-4h-1v-1c0-2.8-2.2-5-5-5s-5 2.2-5 5v1H4v8h16v-8z"/>
                            </svg>
                            Đổi mật khẩu
                        </h4>
                        <form method="POST" action="{{ route('user.password') }}" class="space-y-6">
                            @csrf
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Mật khẩu hiện tại</label>
                                <input type="password" name="current_password"
                                       class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200">
                                @error('current_password')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Mật khẩu mới</label>
                                <input type="password" name="password"
                                       class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200">
                                @error('password')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Xác nhận mật khẩu</label>
                                <input type="password" name="password_confirmation"
                                       class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200">
                            </div>
                            <button type="submit" class="px-6 py-3 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition duration-200 inline-flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                                Cập nhật mật khẩu
                            </button>
                        </form>
                    </div>

                    <!-- Addresses -->
                    <div id="addresses" class="tab-pane fade bg-white rounded-xl shadow-xl p-8 transition-all duration-300">
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                            <h4 class="text-2xl font-semibold text-gray-800 flex items-center gap-2">
                                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                </svg>
                                Địa chỉ giao hàng
                            </h4>
                            <a href="{{ route('addresses.create') }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition duration-200 inline-flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                Thêm địa chỉ
                            </a>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @forelse(auth()->user()->addresses as $a)
                                <div class="border border-gray-200 rounded-xl p-6 relative hover:shadow-md transition-shadow duration-200">
                                    @if($a->is_default)
                                        <span class="absolute top-4 right-4 px-3 py-1 text-xs bg-indigo-600 text-white rounded-full shadow-sm">Mặc định</span>
                                    @endif
                                    <p class="font-semibold text-lg text-gray-800">{{ $a->label ?: 'Địa chỉ' }}</p>
                                    <p class="text-sm text-gray-600 mt-2">
                                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        {{ $a->recipient_name }} – {{ $a->phone }}
                                    </p>
                                    <p class="text-sm text-gray-600 mt-2">
                                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        </svg>
                                        {{ $a->detail }}, {{ $a->ward }}, {{ $a->district }}, {{ $a->province }}
                                    </p>
                                    <div class="mt-4 space-x-3">
                                        <a href="{{ route('addresses.edit', $a) }}" class="text-indigo-600 hover:text-indigo-800 font-medium text-sm inline-flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                            Sửa
                                        </a>
                                        <form action="{{ route('addresses.destroy', $a) }}" method="POST" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" onclick="return confirm('Bạn có chắc muốn xóa địa chỉ này?')" class="text-red-600 hover:text-red-800 font-medium text-sm inline-flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                                Xóa
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @empty
                                <div class="col-span-2 text-center py-8">
                                    <svg class="w-16 h-16 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    </svg>
                                    <p class="mt-4 text-gray-500">Bạn chưa có địa chỉ nào.</p>
                                    <a href="{{ route('addresses.create') }}" class="mt-4 inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition duration-200">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                        </svg>
                                        Thêm địa chỉ mới
                                    </a>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Delete Account -->
                    <div id="delete-account" class="tab-pane fade bg-white rounded-xl shadow-xl p-8 transition-all duration-300">
                        <h4 class="text-2xl font-semibold text-red-600 mb-6 flex items-center gap-2">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Xóa tài khoản
                        </h4>
                        <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-lg mb-6">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-red-700">
                                        Một khi xóa, mọi dữ liệu sẽ bị mất vĩnh viễn. Hành động này không thể hoàn tác.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <button data-tw-toggle="modal" data-tw-target="#confirmDeleteModal"
                                class="px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition duration-200 inline-flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Xác nhận xóa tài khoản
                        </button>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <!-- Modal Confirm Delete -->
    <div id="confirmDeleteModal" data-tw-modal-backdrop="static" class="hidden fixed inset-0 z-50 overflow-y-auto transition-opacity duration-300">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="bg-white rounded-xl shadow-2xl max-w-md w-full p-8 relative transform transition-all duration-300 scale-95">
                <button data-tw-dismiss="modal" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition-colors duration-150">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
                <h5 class="text-xl font-semibold text-gray-800 mb-6">Xác nhận xóa tài khoản</h5>
                <form method="POST" action="{{ route('profile.destroy') }}" class="space-y-6">
                    @csrf @method('DELETE')
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nhập mật khẩu của bạn để xác nhận</label>
                        <input type="password" name="password"
                               class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition duration-200">
                        @error('password')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex justify-end space-x-3">
                        <button type="button" data-tw-dismiss="modal" class="px-5 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition duration-200">
                            Hủy bỏ
                        </button>
                        <button type="submit" class="px-5 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition duration-200">
                            Xóa vĩnh viễn
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Initialize tabs
            const tabs = document.querySelectorAll('[data-tw-toggle="pill"]');
            const panes = document.querySelectorAll('.tab-pane');

            // Show first tab by default
            if (tabs.length > 0) {
                tabs[0].click();
            }

            // Tab switching functionality
            tabs.forEach(tab => {
                tab.addEventListener('click', (e) => {
                    e.preventDefault();

                    // Remove active classes from all tabs and panes
                    tabs.forEach(t => t.classList.remove('active'));
                    panes.forEach(p => {
                        p.classList.remove('show', 'active');
                        p.style.opacity = '0';
                    });

                    // Add active class to clicked tab
                    tab.classList.add('active');

                    // Show corresponding pane
                    const target = document.querySelector(tab.getAttribute('href'));
                    if (target) {
                        target.classList.add('show', 'active');
                        setTimeout(() => {
                            target.style.opacity = '1';
                        }, 50);
                    }
                });
            });

            // Modal animation
            const deleteModal = document.getElementById('confirmDeleteModal');
            if (deleteModal) {
                deleteModal.addEventListener('show.tw.modal', function() {
                    deleteModal.querySelector('.transform').classList.remove('scale-95');
                    deleteModal.querySelector('.transform').classList.add('scale-100');
                });
                deleteModal.addEventListener('hide.tw.modal', function() {
                    deleteModal.querySelector('.transform').classList.remove('scale-100');
                    deleteModal.querySelector('.transform').classList.add('scale-95');
                });
            }
        });
    </script>
    @endpush

    @push('styles')
    <style>
        .tab-pane {
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
            display: none;
        }
        .tab-pane.show.active {
            opacity: 1;
            display: block;
        }
        #confirmDeleteModal {
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
        }
        #confirmDeleteModal.show {
            opacity: 1;
        }
        #confirmDeleteModal .transform {
            transform: scale(0.95);
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        #confirmDeleteModal.show .transform {
            transform: scale(1);
        }
    </style>
    @endpush
</x-app-layout>
