<div x-show="openAdd" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">

    <div @click.away="openAdd = false"
        class="bg-white w-full max-w-lg rounded-3xl shadow-2xl overflow-hidden transform transition-all">

        <div class="px-8 py-6 border-b border-slate-100 flex justify-between items-center bg-white">
            <div>
                <h3 class="text-xl font-bold text-slate-800" x-text="title"></h3>
                <p class="text-xs text-slate-400 mt-1">Step <span x-text="step"></span> of 2</p>
            </div>
            <button @click="openAdd = false; step = 1"
                class="h-8 w-8 flex items-center justify-center rounded-full bg-slate-100 text-slate-400 hover:bg-red-50 hover:text-red-500 transition">
                <i class="fa fa-times text-sm"></i>
            </button>
        </div>

        <div class="w-full bg-slate-100 h-1.5 flex">
            <div :class="step >= 1 ? 'bg-blue-500' : 'bg-slate-100'" class="flex-1 transition-all duration-500"></div>
            <div :class="step >= 2 ? 'bg-blue-500' : 'bg-slate-100'" class="flex-1 transition-all duration-500"></div>
        </div>

        <form action="{{ route('admin.tenants.store') }}" method="POST" class="p-8">
            @csrf

            <div x-show="step === 1" x-transition:enter="transition ease-out duration-300">
                <div class="space-y-5">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Property
                            Name</label>
                        <input type="text" name="tenant_name" value="{{ old('tenant_name') }}" required
                            class="w-full px-4 py-3 border {{ $errors->has('tenant_name') ? 'border-red-500' : 'border-slate-200' }} rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition"
                            placeholder="e.g. Sunset Heights Apartments">
                        @error('tenant_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label
                            class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Subdomain</label>
                        <div class="flex">
                            <input type="text" name="domain" value="{{ old('domain') }}" required
                                class="flex-1 px-4 py-3 border {{ $errors->has('domain') ? 'border-red-500' : 'border-slate-200' }} rounded-l-xl focus:ring-2 focus:ring-blue-500 outline-none transition"
                                placeholder="sunset">
                            <span
                                class="inline-flex items-center px-4 bg-slate-50 border border-l-0 border-slate-200 rounded-r-xl text-slate-400 font-semibold text-sm">
                                .{{ request()->getHttpHost() }}
                            </span>
                        </div>
                        @error('domain') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Database
                            Name</label>
                        <input type="text" name="db_name" value="{{ old('db_name') }}" required
                            class="w-full px-4 py-3 border {{ $errors->has('db_name') ? 'border-red-500' : 'border-slate-200' }} rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition"
                            placeholder="tenant_sunset_db">
                        @error('db_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <div x-show="step === 2" x-transition:enter="transition ease-out duration-300" x-cloak>
                <div class="space-y-5">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Owner Full
                            Name</label>
                        <input type="text" name="owner_name" value="{{ old('owner_name') }}" required
                            class="w-full px-4 py-3 border {{ $errors->has('owner_name') ? 'border-red-500' : 'border-slate-200' }} rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition"
                            placeholder="John Doe">
                        @error('owner_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Owner
                            Email</label>
                        <input type="email" name="owner_email" value="{{ old('owner_email') }}" required
                            class="w-full px-4 py-3 border {{ $errors->has('owner_email') ? 'border-red-500' : 'border-slate-200' }} rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition"
                            placeholder="john@example.com">
                        @error('owner_email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Access
                            Password</label>
                        <input type="password" name="owner_password" required
                            class="w-full px-4 py-3 border {{ $errors->has('owner_password') ? 'border-red-500' : 'border-slate-200' }} rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition"
                            placeholder="••••••••">
                        @error('owner_password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <div class="mt-10 flex justify-between items-center">
                <button type="button" x-show="step > 1" @click="prevStep()"
                    class="text-slate-400 hover:text-slate-600 font-bold px-4 py-2 transition">
                    <i class="fa fa-arrow-left mr-2 text-sm"></i> Back
                </button>
                <div x-show="step === 1" class="flex-1"></div>

                <button type="button" x-show="step < 2" @click="nextStep()"
                    class="bg-slate-800 text-white px-8 py-3 rounded-xl font-bold hover:bg-slate-900 transition shadow-lg">
                    Next: Owner Account
                </button>

                <button type="submit" x-show="step === 2"
                    class="bg-blue-600 text-white px-8 py-3 rounded-xl font-bold hover:bg-blue-700 transition shadow-lg shadow-blue-200">
                    Create Tenant Account
                </button>
            </div>
        </form>
    </div>
</div>