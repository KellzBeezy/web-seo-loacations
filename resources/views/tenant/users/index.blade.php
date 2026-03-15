@extends('tenant.layouts.tenant')

@section('content')
    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show"
        class="fixed top-5 right-5 z-[110] min-w-[300px]" x-cloak>
        @if(session('success'))
            <div class="bg-white border-l-4 border-green-500 shadow-2xl p-4 rounded-xl flex items-center">
                <div class="bg-green-100 p-2 rounded-lg mr-4"><i class="fa fa-check text-green-600"></i></div>
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Success</p>
                    <p class="text-sm font-bold text-slate-800">{{ session('success') }}</p>
                </div>
            </div>
        @endif
        @if(session('error'))
            <div class="bg-white border-l-4 border-red-500 shadow-2xl p-4 rounded-xl flex items-center">
                <div class="bg-red-100 p-2 rounded-lg mr-4"><i class="fa fa-exclamation-triangle text-red-600"></i></div>
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Error</p>
                    <p class="text-sm font-bold text-slate-800">{{ session('error') }}</p>
                </div>
            </div>
        @endif
    </div>

    <div x-data="{ openAdd: {{ $errors->any() ? 'true' : 'false' }} }">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
            <div>
                <h2 class="text-3xl font-extrabold text-slate-900">Team Management</h2>
                <p class="text-slate-500 text-sm mt-1">Manage users and their access roles.</p>
            </div>
            @if(auth()->user()->hasRole('admin'))
                <button @click="openAdd = true"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-6 py-3 rounded-xl transition shadow-lg flex items-center">
                    <i class="fa fa-user-plus mr-2 text-sm"></i> Add New User
                </button>
            @endif
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left whitespace-nowrap">
                    <thead class="bg-slate-50/50 border-b border-slate-100">
                        <tr>
                            <th class="px-6 py-4 text-xs font-bold uppercase text-slate-500">User</th>
                            <th class="px-6 py-4 text-xs font-bold uppercase text-slate-500">Role</th>
                            <th class="px-6 py-4 text-xs font-bold uppercase text-slate-500">Joined</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($users as $u)
                            <tr class="hover:bg-slate-50/50 transition duration-150">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="h-10 w-10 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center font-bold mr-3 border border-blue-100">
                                            {{ strtoupper(substr($u->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="text-sm font-bold text-slate-900">{{ $u->name }}</div>
                                            <div class="text-xs text-slate-400 font-medium">{{ $u->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @foreach($u->roles as $role)
                                        <span class="px-3 py-1 text-[10px] font-bold rounded-full bg-slate-100 text-slate-600 uppercase">
                                            {{ $role->name }}
                                        </span>
                                    @endforeach
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-500">
                                    {{ $u->created_at->format('M d, Y') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if($users->hasPages())
                <div class="px-6 py-4 bg-slate-50/50 border-t border-slate-100">{{ $users->links() }}</div>
            @endif
        </div>

        <div x-show="openAdd" x-cloak
            class="fixed inset-0 z-[120] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
            <div @click.away="openAdd = false" class="bg-white w-full max-w-lg rounded-3xl overflow-hidden shadow-2xl">
                <div class="px-8 py-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                    <h3 class="text-xl font-bold text-slate-800">Create New User</h3>
                    <button @click="openAdd = false" class="text-slate-400 hover:text-red-500">
                        <i class="fa fa-times"></i>
                    </button>
                </div>
                <form action="{{ route('users.store') }}" method="POST" class="p-8 space-y-5">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Full Name</label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                            class="w-full px-4 py-3 border @error('name') border-red-500 @else border-slate-200 @enderror rounded-xl outline-none focus:ring-2 focus:ring-blue-500 transition">
                        @error('name') <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Email Address</label>
                        <input type="email" name="email" value="{{ old('email') }}" required
                            class="w-full px-4 py-3 border @error('email') border-red-500 @else border-slate-200 @enderror rounded-xl outline-none focus:ring-2 focus:ring-blue-500 transition">
                        @error('email') <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Assign Role</label>
                        <select name="role_id" required
                            class="w-full px-4 py-3 border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-blue-500 transition">
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Password</label>
                        <input type="password" name="password" required
                            class="w-full px-4 py-3 border @error('password') border-red-500 @else border-slate-200 @enderror rounded-xl outline-none focus:ring-2 focus:ring-blue-500 transition">
                        @error('password') <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                    </div>

                    <button type="submit"
                        class="w-full py-4 bg-blue-600 text-white rounded-2xl font-bold shadow-lg hover:bg-blue-700 transition">
                        Create Account
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection