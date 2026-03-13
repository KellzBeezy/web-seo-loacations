@extends('admin.layouts.admin')
@section('title', 'Tenants')

@section('content')
    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3500)" x-show="show"
        x-transition:leave="transition ease-in duration-500" x-transition:leave-start="opacity-100 translate-x-0"
        x-transition:leave-end="opacity-0 translate-x-10" class="fixed top-5 right-5 z-[110] min-w-[300px]" x-cloak>
        @if(session('success'))
            <div class="bg-white border-l-4 border-green-500 shadow-2xl p-4 rounded-xl flex items-center">
                <div class="bg-green-100 p-2 rounded-lg mr-4"><i class="fa fa-check text-green-600"></i></div>
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Success</p>
                    <p class="text-sm font-bold text-slate-800">{{ session('success') }}</p>
                </div>
            </div>
        @endif
    </div>

    <div x-data="{ 
                openAdd: {{ $errors->any() ? 'true' : 'false' }}, 
                openEdit: false,
                openDelete: false,
                step: 1,
                addTitle: 'Tenant Information',
                selectedTenant: { id: '', name: '', domain: '' },

                nextStep() { 
                    if(this.step < 2) { 
                        this.step++; 
                        this.addTitle = 'Owner Account'; 
                    } 
                },
                prevStep() { 
                    if(this.step > 1) { 
                        this.step--; 
                        this.addTitle = 'Tenant Information'; 
                    } 
                },
                initEdit(tenant) {
                    this.selectedTenant = tenant;
                    this.openEdit = true;
                },
                initDelete(tenant) {
                    this.selectedTenant = tenant;
                    this.openDelete = true;
                }
            }">

        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
            <div>
                <h2 class="text-3xl font-extrabold text-slate-900">Manage Tenants</h2>
                <p class="text-slate-500 text-sm mt-1">Total of {{ $tenants->total() }} registered accounts.</p>
            </div>
            <button @click="openAdd = true; step = 1; addTitle = 'Tenant Information'"
                class="w-full md:w-auto bg-blue-600 hover:bg-blue-700 text-white font-bold px-6 py-3 rounded-xl transition shadow-lg flex items-center justify-center">
                <i class="fa fa-plus mr-2 text-sm"></i> Add New Tenant
            </button>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left whitespace-nowrap border-collapse">
                    <thead class="bg-slate-50/50 border-b border-slate-100">
                        <tr>
                            <th class="px-6 py-4 text-xs font-bold uppercase text-slate-500">Tenant Info</th>
                            <th class="px-6 py-4 text-xs font-bold uppercase text-slate-500">Owner</th>
                            <th class="px-6 py-4 text-xs font-bold uppercase text-slate-500 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($tenants as $tenant)
                            <tr class="hover:bg-slate-50/50 transition duration-150 group">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div
                                            class="h-10 w-10 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center font-bold mr-3">
                                            {{ strtoupper(substr($tenant->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="text-sm font-bold text-slate-900">{{ $tenant->name }}</div>
                                            <div class="text-xs text-slate-400 font-medium">{{ $tenant->domain }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm font-medium text-slate-700">
                                    {{ $tenant->owner->name ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end space-x-2">
                                        <button @click="initEdit({{ json_encode($tenant) }})"
                                            class="p-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                        <button @click="initDelete({{ json_encode($tenant) }})"
                                            class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-12 text-center text-slate-500">No tenants found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($tenants->hasPages())
                <div class="px-6 py-4 bg-slate-50 border-t border-slate-100">{{ $tenants->links() }}</div>
            @endif
        </div>

        <div x-show="openDelete" x-cloak
            class="fixed inset-0 z-[120] flex items-center justify-center p-4 bg-slate-900/80 backdrop-blur-sm">
            <div @click.away="openDelete = false" class="bg-white w-full max-w-md rounded-3xl p-8 shadow-2xl">
                <div class="text-center">
                    <div
                        class="w-16 h-16 bg-red-100 text-red-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fa fa-exclamation-triangle text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900">Delete <span x-text="selectedTenant.name"></span>?</h3>
                    <p class="text-slate-500 mt-2 text-sm">This will permanently remove the tenant record. The database
                        remains intact.</p>
                </div>
                <div class="mt-8 flex gap-3">
                    <button @click="openDelete = false"
                        class="flex-1 px-4 py-3 border border-slate-200 rounded-xl font-bold text-slate-600">Cancel</button>
                    <form :action="'/admin/tenants/' + selectedTenant.id" method="POST" class="flex-1">
                        @csrf @method('DELETE')
                        <button type="submit"
                            class="w-full px-4 py-3 bg-red-600 text-white rounded-xl font-bold">Delete</button>
                    </form>
                </div>
            </div>
        </div>

        <div x-show="openEdit" x-cloak
            class="fixed inset-0 z-[120] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
            <div @click.away="openEdit = false" class="bg-white w-full max-w-lg rounded-3xl overflow-hidden shadow-2xl">
                <div class="px-8 py-6 border-b border-slate-100 flex justify-between items-center">
                    <h3 class="text-xl font-bold text-slate-800">Edit Tenant</h3>
                    <button @click="openEdit = false" class="text-slate-400 hover:text-red-500"><i
                            class="fa fa-times"></i></button>
                </div>
                <form :action="'/admin/tenants/' + selectedTenant.id" method="POST" class="p-8 space-y-5">
                    @csrf @method('PUT')
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Property
                            Name</label>
                        <input type="text" name="name" x-model="selectedTenant.name"
                            class="w-full px-4 py-3 border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-blue-500 transition">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Domain</label>
                        <input type="text" name="domain" x-model="selectedTenant.domain" disabled
                            class="w-full px-4 py-3 border border-slate-200 rounded-xl bg-slate-50 text-slate-400 outline-none">
                    </div>
                    <button type="submit" class="w-full py-4 bg-blue-600 text-white rounded-2xl font-bold shadow-lg">Update
                        Tenant</button>
                </form>
            </div>
        </div>

        @include('admin.tenants.partials.add_modal')
    </div>
@endsection