@extends('tenant.layouts.tenant')

@section('content')
    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show"
        x-transition:leave="transition ease-in duration-500" x-transition:leave-start="opacity-100 translate-x-0"
        x-transition:leave-end="opacity-0 translate-x-10" class="fixed top-5 right-5 z-[110] min-w-[300px]" x-cloak>

        @if(session('success'))
            <div class="bg-white border-l-4 border-green-500 shadow-2xl p-4 rounded-xl flex items-center">
                <div class="bg-green-100 p-2 rounded-lg mr-4">
                    <i class="fa-solid fa-circle-check text-green-600"></i>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Success</p>
                    <p class="text-sm font-bold text-slate-800">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-white border-l-4 border-red-500 shadow-2xl p-4 rounded-xl flex items-center">
                <div class="bg-red-100 p-2 rounded-lg mr-4">
                    <i class="fa-solid fa-triangle-exclamation text-red-600"></i>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Error</p>
                    <p class="text-sm font-bold text-slate-800">{{ session('error') }}</p>
                </div>
            </div>
        @endif
    </div>

    <div x-data="{ 
                    editModal: {{ $errors->any() ? 'true' : 'false' }}, 
                    deleteModal: false,
                    activeLocation: { id: '', suburb: '', city: '', change_frequency: '' },
                    openEdit(location) {
                        this.activeLocation = Object.assign({}, location);
                        this.editModal = true;
                    },
                    openDelete(location) {
                        this.activeLocation = location;
                        this.deleteModal = true;
                    }
                }">
        <div class="md:flex md:items-center md:justify-between mb-8">
            <div class="flex-1 min-w-0">
                <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">
                    Locations Management
                </h2>
                <p class="text-slate-500 mt-1 font-medium">Manage service areas and collection frequencies for this
                    property.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
            <div class="lg:col-span-1">
                <div class="bg-white shadow-sm rounded-3xl border border-slate-100 overflow-hidden">
                    <div class="px-6 py-5 border-b border-slate-50 bg-slate-50/50">
                        <h3 class="text-lg font-bold text-slate-800">Add New Location</h3>
                    </div>

                    <form method="POST" action="{{ route('locations.store') }}" class="p-6 space-y-6">
                        @csrf

                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Change
                                Frequency</label>
                            <select name="change_frequency"
                                class="w-full px-4 py-3 border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-blue-500 transition bg-white text-slate-700 font-medium shadow-sm"
                                required>
                                <option value="">Select Frequency</option>
                                <option value="Daily" {{ old('change_frequency') == 'Daily' ? 'selected' : '' }}>Daily
                                </option>
                                <option value="Weekly" {{ old('change_frequency') == 'Weekly' || !old('change_frequency') ? 'selected' : '' }}>Weekly</option>
                                <option value="Monthly" {{ old('change_frequency') == 'Monthly' ? 'selected' : '' }}>Monthly
                                </option>
                                <option value="Yearly" {{ old('change_frequency') == 'Yearly' ? 'selected' : '' }}>Yearly
                                </option>
                            </select>
                            @error('change_frequency') <p class="mt-2 text-xs font-bold text-red-500 uppercase">
                                {{ $message }}
                            </p> @enderror
                        </div>

                        <div>
                            <label
                                class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Suburb</label>
                            <input type="text" name="suburb" value="{{ old('suburb') }}"
                                class="w-full px-4 py-3 border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-blue-500 transition text-slate-700 font-medium placeholder-slate-300 shadow-sm"
                                placeholder="e.g. Northcliff" required>
                            @error('suburb') <p class="mt-2 text-xs font-bold text-red-500 uppercase">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label
                                class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">City</label>
                            <input type="text" name="city" value="{{ old('city') }}"
                                class="w-full px-4 py-3 border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-blue-500 transition text-slate-700 font-medium placeholder-slate-300 shadow-sm"
                                placeholder="e.g. Johannesburg" required>
                            @error('city') <p class="mt-2 text-xs font-bold text-red-500 uppercase">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="pt-2">
                            <button type="submit"
                                class="w-full py-4 bg-blue-600 text-white rounded-2xl font-bold shadow-lg hover:bg-blue-700 transition transform hover:-translate-y-0.5 active:translate-y-0">
                                Save Location
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="lg:col-span-2">
                <div class="bg-white shadow-sm rounded-3xl border border-slate-100 overflow-hidden flex flex-col h-full">
                    <div class="px-6 py-5 border-b border-slate-50 bg-white">
                        <h3 class="text-lg font-bold text-slate-800">Current Locations</h3>
                    </div>

                    <div class="flex-grow overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-100">
                            <thead class="bg-slate-50/50">
                                <tr>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-widest">
                                        Suburb</th>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-widest">
                                        City</th>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-widest">
                                        Change Frequency</th>
                                    <th
                                        class="px-6 py-4 text-right text-xs font-bold text-slate-500 uppercase tracking-widest">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-slate-50">
                                @forelse($locations as $location)
                                    <tr class="hover:bg-slate-50/50 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900 font-bold">
                                            {{ $location->suburb }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500 font-medium">
                                            {{ $location->city }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="px-3 py-1 inline-flex text-[10px] leading-5 font-bold rounded-full bg-blue-50 text-blue-600 uppercase tracking-wider border border-blue-100">
                                                {{ $location->change_frequency }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-right text-sm font-medium space-x-2">
                                            <button @click="openEdit({{ json_encode($location) }})"
                                                class="text-blue-600 hover:text-blue-900 bg-blue-50 p-2.5 rounded-xl transition shadow-sm border border-blue-100">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </button>
                                            <button @click="openDelete({{ json_encode($location) }})"
                                                class="text-red-600 hover:text-red-900 bg-red-50 p-2.5 rounded-xl transition shadow-sm border border-red-100">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-16 text-center">
                                            <div
                                                class="bg-slate-50 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                                                <i class="fa-solid fa-map-location-dot text-slate-300 text-2xl"></i>
                                            </div>
                                            <span class="text-sm font-bold text-slate-400 uppercase tracking-widest">No
                                                locations registered yet.</span>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($locations->hasPages())
                        <div class="px-6 py-4 bg-slate-50/50 border-t border-slate-100">
                            {{ $locations->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div x-show="editModal" x-cloak
            class="fixed inset-0 z-[120] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
            <div @click.away="editModal = false"
                class="bg-white w-full max-w-md rounded-3xl shadow-2xl overflow-hidden border border-white/20">
                <div class="px-8 py-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                    <h3 class="text-xl font-bold text-slate-800">Edit Location</h3>
                    <button @click="editModal = false" class="text-slate-400 hover:text-red-500 transition">
                        <i class="fa-solid fa-xmark text-lg"></i>
                    </button>
                </div>
                <form :action="'/locations/' + activeLocation.id" method="POST" class="p-8 space-y-6">
                    @csrf @method('PUT')
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Suburb</label>
                        <input type="text" name="suburb" x-model="activeLocation.suburb"
                            class="w-full px-4 py-3 border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-blue-500 transition font-medium text-slate-700 shadow-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">City</label>
                        <input type="text" name="city" x-model="activeLocation.city"
                            class="w-full px-4 py-3 border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-blue-500 transition font-medium text-slate-700 shadow-sm">
                    </div>
                    <div>
                        <label
                            class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Frequency</label>
                        <select name="change_frequency" x-model="activeLocation.change_frequency"
                            class="w-full px-4 py-3 border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-blue-500 transition font-medium text-slate-700 shadow-sm">
                            <option value="Daily">Daily</option>
                            <option value="Weekly">Weekly</option>
                            <option value="Monthly">Monthly</option>
                            <option value="Yearly">Yearly</option>
                        </select>
                    </div>
                    <div class="flex gap-4 pt-4">
                        <button type="button" @click="editModal = false"
                            class="flex-1 py-4 bg-slate-100 text-slate-600 rounded-2xl font-bold hover:bg-slate-200 transition">Cancel</button>
                        <button type="submit"
                            class="flex-1 py-4 bg-blue-600 text-white rounded-2xl font-bold shadow-lg hover:bg-blue-700 transition">Update</button>
                    </div>
                </form>
            </div>
        </div>

        <div x-show="deleteModal" x-cloak
            class="fixed inset-0 z-[120] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
            <div @click.away="deleteModal = false"
                class="bg-white w-full max-w-sm rounded-[2.5rem] shadow-2xl p-10 text-center">
                <div
                    class="w-20 h-20 bg-red-50 text-red-500 rounded-full flex items-center justify-center mx-auto mb-6 border border-red-100 text-3xl">
                    <i class="fa-solid fa-trash-can"></i>
                </div>
                <h3 class="text-2xl font-black text-slate-800 mb-2 tracking-tight">Are you sure?</h3>
                <p class="text-slate-500 mb-8 font-medium">You are about to delete <span class="text-slate-900 font-bold"
                        x-text="activeLocation.suburb"></span>. This cannot be undone.</p>

                <form :action="'/locations/' + activeLocation.id" method="POST" class="flex gap-4">
                    @csrf @method('DELETE')
                    <button type="button" @click="deleteModal = false"
                        class="flex-1 py-4 bg-slate-100 text-slate-600 rounded-2xl font-bold hover:bg-slate-200 transition">No,
                        keep it</button>
                    <button type="submit"
                        class="flex-1 py-4 bg-red-600 text-white rounded-2xl font-bold shadow-lg hover:bg-red-700 transition">Yes,
                        delete</button>
                </form>
            </div>
        </div>
    </div>
@endsection