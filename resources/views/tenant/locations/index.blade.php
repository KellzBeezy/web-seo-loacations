@extends('tenant.layouts.tenant')

@section('content')
    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show"
        x-transition:leave="transition ease-in duration-500" x-transition:leave-start="opacity-100 translate-x-0"
        x-transition:leave-end="opacity-0 translate-x-10" class="fixed top-5 right-5 z-[110] min-w-[300px]" x-cloak>

        @if(session('success'))
            <div class="bg-white border-l-4 border-green-500 shadow-2xl p-4 rounded-xl flex items-center">
                <div class="bg-green-100 p-2 rounded-lg mr-4"><i class="fa-solid fa-circle-check text-green-600"></i></div>
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Success</p>
                    <p class="text-sm font-bold text-slate-800">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-white border-l-4 border-red-500 shadow-2xl p-4 rounded-xl flex items-center">
                <div class="bg-red-100 p-2 rounded-lg mr-4"><i class="fa-solid fa-triangle-exclamation text-red-600"></i></div>
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Error</p>
                    <p class="text-sm font-bold text-slate-800">{{ session('error') }}</p>
                </div>
            </div>
        @endif
    </div>

    <div x-data="{ 
                                            editModal: false, 
                                            deleteModal: false,
                                            activeLocation: { id: '', suburb: '', city: '', change_frequency: '' },
                                            rows: [{ city: '', suburb: '', change_frequency: '{{ \App\Enums\ChangeFrequency::WEEKLY->value }}' }],
                                            addRow() {
                                                this.rows.push({ city: '', suburb: '', change_frequency: '{{ \App\Enums\ChangeFrequency::WEEKLY->value }}' });
                                            },
                                            removeRow(index) {
                                                if(this.rows.length > 1) this.rows.splice(index, 1);
                                            },
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
                <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Locations Management</h2>
                <p class="text-slate-500 mt-1 font-medium text-lg">Manage service areas via bulk upload, dynamic entry, or
                    direct editing.</p>
            </div>
        </div>

        @if(auth()->user()->hasPermission('add_location'))

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
                <div class="bg-white shadow-sm rounded-3xl border border-slate-100 overflow-hidden">
                    <div class="px-6 py-5 border-b border-slate-50 bg-slate-50/50 flex justify-between items-center">
                        <h3 class="text-lg font-bold text-slate-800">Import from Excel/CSV</h3>
                        <a href="{{ route('locations.template') }}"
                            class="text-xs font-bold text-blue-600 hover:text-blue-800 flex items-center bg-blue-50 px-3 py-1.5 rounded-lg transition">
                            <i class="fa-solid fa-file-csv mr-1.5"></i> Download Template
                        </a>
                    </div>

                    <form action="{{ route('locations.import') }}" method="POST" enctype="multipart/form-data" class="p-8">
                        @csrf
                        <div
                            class="group relative flex flex-col items-center justify-center border-2 border-dashed border-slate-200 rounded-3xl p-8 hover:border-blue-400 transition-colors bg-slate-50/30">
                            <input type="file" name="file" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                                required>
                            <div class="text-center">
                                <div
                                    class="bg-blue-100 text-blue-600 w-12 h-12 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                                    <i class="fa-solid fa-cloud-arrow-up text-xl"></i>
                                </div>
                                <p class="text-sm font-bold text-slate-700">Click to upload or drag and drop</p>
                                <p class="text-xs text-slate-400 mt-1 font-medium">CSV or XLSX (Max. 2MB)</p>
                            </div>
                        </div>
                        <button type="submit"
                            class="w-full mt-6 py-4 bg-slate-900 text-white rounded-2xl font-bold shadow-lg hover:bg-slate-800 transition">
                            Start Import Process
                        </button>
                    </form>
                </div>

                <div class="bg-blue-600 rounded-3xl p-8 text-white relative overflow-hidden flex flex-col justify-center">
                    <div class="relative z-10">
                        <h3 class="text-xl font-bold mb-4 flex items-center">
                            <i class="fa-solid fa-circle-info mr-3 text-blue-200"></i> Formatting Guide
                        </h3>
                        <p class="text-blue-100 text-sm leading-relaxed mb-8">Ensure your spreadsheet headers match these
                            exactly for a successful import:</p>
                        <div class="grid grid-cols-3 gap-3 text-center">
                            @foreach(['city', 'suburb', 'frequency'] as $header)
                                <div class="bg-white/10 rounded-2xl p-4 border border-white/20">
                                    <span class="block text-[10px] font-black uppercase opacity-60 mb-1">Header</span>
                                    <span class="font-bold text-sm tracking-tight">{{ $header }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="absolute -bottom-10 -right-10 w-48 h-48 bg-white/10 rounded-full"></div>
                </div>
            </div>

            <div class="bg-white shadow-sm rounded-3xl border border-slate-100 overflow-hidden mb-12">
                <div class="px-6 py-5 border-b border-slate-50 bg-slate-50/50 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-slate-800">Bulk Manual Entry</h3>
                    <button type="button" @click="addRow()"
                        class="bg-blue-600 text-white px-4 py-2 rounded-xl text-sm font-bold hover:bg-blue-700 transition flex items-center shadow-md">
                        <i class="fa-solid fa-plus-circle mr-2"></i> Add Row
                    </button>
                </div>

                <form method="POST" action="{{ route('locations.store') }}" class="p-6">
                    @csrf
                    <div class="space-y-4">
                        <template x-for="(row, index) in rows" :key="index">
                            <div
                                class="flex flex-col md:flex-row gap-4 p-5 bg-slate-50/50 rounded-2xl border border-slate-100 items-end">
                                <div class="flex-1 w-full">
                                    <label
                                        class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">City
                                        Name</label>
                                    <input type="text" :name="`locations[${index}][city]`" x-model="row.city" required
                                        class="w-full px-4 py-3 border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-blue-500 transition bg-white shadow-sm font-medium">
                                </div>
                                <div class="flex-1 w-full">
                                    <label
                                        class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Suburb
                                        Name</label>
                                    <input type="text" :name="`locations[${index}][suburb]`" x-model="row.suburb" required
                                        class="w-full px-4 py-3 border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-blue-500 transition bg-white shadow-sm font-medium">
                                </div>
                                <div class="w-full md:w-56">
                                    <label
                                        class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Collection
                                        Frequency</label>
                                    <select :name="`locations[${index}][change_frequency]`" x-model="row.change_frequency"
                                        class="w-full px-4 py-3 border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-blue-500 transition bg-white shadow-sm font-medium">
                                        @foreach(\App\Enums\ChangeFrequency::cases() as $freq)
                                            <option value="{{ $freq->value }}">{{ $freq->value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="button" @click="removeRow(index)" x-show="rows.length > 1"
                                    class="p-3.5 text-red-400 hover:text-red-600 transition bg-white rounded-xl border border-slate-100 shadow-sm hover:border-red-100">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </div>
                        </template>
                    </div>

                    <div class="mt-8 flex justify-end">
                        <button type="submit"
                            class="px-12 py-4 bg-blue-600 text-white rounded-2xl font-bold shadow-lg hover:bg-blue-700 transition transform hover:-translate-y-0.5">
                            Save Entries
                        </button>
                    </div>
                </form>
            </div>

        @endif

        <div class="bg-white shadow-sm rounded-3xl border border-slate-100 overflow-hidden">
            <div class="px-6 py-6 border-b border-slate-50 flex justify-between items-center">
                <h3 class="text-xl font-bold text-slate-800">Existing Locations</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-100">
                    <thead class="bg-slate-50/50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-widest">
                                Location Info</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-widest">
                                Frequency</th>
                            <th class="px-6 py-4 text-right text-xs font-bold text-slate-500 uppercase tracking-widest">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-50">
                        @forelse($locations as $location)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="text-sm font-bold text-slate-900">{{ $location->suburb }}</div>
                                    <div class="text-xs text-slate-400 font-medium tracking-tight">{{ $location->city }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="px-3 py-1 text-[10px] font-bold rounded-full bg-blue-50 text-blue-600 uppercase border border-blue-100">
                                        {{ $location->change_frequency->value }}
                                    </span>
                                </td>
                                @if(auth()->user()->hasPermission('update_location') || auth()->user()->hasPermission('delete_location'))
                                    <td class="px-6 py-4 text-right space-x-2">
                                        <button @click="openEdit({{ json_encode($location) }})"
                                            class="text-blue-600 bg-blue-50 p-2.5 rounded-xl border border-blue-100 hover:bg-blue-100 transition shadow-sm"><i
                                                class="fa-solid fa-pen"></i></button>
                                        <button @click="openDelete({{ json_encode($location) }})"
                                            class="text-red-600 bg-red-50 p-2.5 rounded-xl border border-red-100 hover:bg-red-100 transition shadow-sm"><i
                                                class="fa-solid fa-trash"></i></button>
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3"
                                    class="px-6 py-20 text-center text-slate-400 font-bold uppercase text-xs tracking-widest">No
                                    locations found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div x-show="editModal" x-cloak
            class="fixed inset-0 z-[120] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
            <div @click.away="editModal = false"
                class="bg-white w-full max-w-md rounded-[2rem] shadow-2xl overflow-hidden border border-white/20">
                <div class="px-8 py-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                    <h3 class="text-xl font-black text-slate-800 tracking-tight">Edit Location</h3>
                    <button @click="editModal = false" class="text-slate-400 hover:text-red-500 transition"><i
                            class="fa-solid fa-xmark text-lg"></i></button>
                </div>
                <form :action="'/locations/' + activeLocation.id" method="POST" class="p-8 space-y-6">
                    @csrf @method('PUT')
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">City</label>
                        <input type="text" name="city" x-model="activeLocation.city"
                            class="w-full px-4 py-3 border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-blue-500 transition font-medium text-slate-700 shadow-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Suburb</label>
                        <input type="text" name="suburb" x-model="activeLocation.suburb"
                            class="w-full px-4 py-3 border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-blue-500 transition font-medium text-slate-700 shadow-sm">
                    </div>
                    <div>
                        <label
                            class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Frequency</label>
                        <select name="change_frequency" x-model="activeLocation.change_frequency"
                            class="w-full px-4 py-3 border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-blue-500 transition font-medium text-slate-700 shadow-sm">
                            @foreach(\App\Enums\ChangeFrequency::cases() as $freq)
                                <option value="{{ $freq->value }}">{{ $freq->value }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit"
                        class="w-full py-4 bg-blue-600 text-white rounded-2xl font-bold shadow-lg hover:bg-blue-700 transition">Update
                        Location</button>
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
                <h3 class="text-2xl font-black text-slate-800 mb-2 tracking-tight tracking-tight">Are you sure?</h3>
                <p class="text-slate-500 mb-8 font-medium italic">You are removing <span class="text-slate-900 font-bold"
                        x-text="activeLocation.suburb"></span>.</p>

                <form :action="'/locations/' + activeLocation.id" method="POST" class="flex gap-4">
                    @csrf @method('DELETE')
                    <button type="button" @click="deleteModal = false"
                        class="flex-1 py-4 bg-slate-100 text-slate-600 rounded-2xl font-bold hover:bg-slate-200 transition">No</button>
                    <button type="submit"
                        class="flex-1 py-4 bg-red-600 text-white rounded-2xl font-bold shadow-lg hover:bg-red-700 transition">Yes,
                        Delete</button>
                </form>
            </div>
        </div>
    </div>
@endsection