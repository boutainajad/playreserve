@extends('layouts.app')

@section('title', 'Mon Profil')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-black uppercase tracking-tight text-gray-900">Mon Profil</h1>
            <p class="text-gray-500 font-medium mt-1">Gérez vos informations personnelles et paramètres de compte.</p>
        </div>
    </div>

    <div class="bg-white rounded-[24px] shadow-sm border border-gray-100 p-8 mb-8 relative overflow-hidden">
        <div class="absolute -right-20 -top-20 w-64 h-64 bg-playtomic-lime/5 rounded-full blur-3xl z-0"></div>
        <div class="absolute -left-20 -bottom-20 w-64 h-64 bg-playtomic-blue/5 rounded-full blur-3xl z-0"></div>

        <div class="relative z-10">
            <h2 class="text-xl font-bold mb-6 text-gray-900 border-b border-gray-100 pb-4">Informations Personnelles</h2>
            
            <form action="{{ route('profile.update') }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-bold text-gray-700 mb-2">Nom complet</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-playtomic-blue focus:border-playtomic-blue block p-3 font-medium transition-colors" required>
                        @error('name') <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-bold text-gray-700 mb-2">Adresse E-mail</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-playtomic-blue focus:border-playtomic-blue block p-3 font-medium transition-colors" required>
                        @error('email') <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="phone" class="block text-sm font-bold text-gray-700 mb-2">Numéro de téléphone</label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone', $user->phone) }}" class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-playtomic-blue focus:border-playtomic-blue block p-3 font-medium transition-colors" placeholder="+212 6... (Optionnel)">
                        @error('phone') <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="address" class="block text-sm font-bold text-gray-700 mb-2">Adresse</label>
                        <input type="text" name="address" id="address" value="{{ old('address', $user->address) }}" class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-playtomic-blue focus:border-playtomic-blue block p-3 font-medium transition-colors" placeholder="Ville, Quartier (Optionnel)">
                        @error('address') <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="pt-6 mt-6 border-t border-gray-100">
                    <h2 class="text-xl font-bold mb-6 text-gray-900 pb-2">Changer le mot de passe <span class="text-sm font-normal text-gray-500 ml-2">(Laisser vide pour ne pas changer)</span></h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="password" class="block text-sm font-bold text-gray-700 mb-2">Nouveau mot de passe</label>
                            <input type="password" name="password" id="password" class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-playtomic-blue focus:border-playtomic-blue block p-3 font-medium transition-colors">
                            @error('password') <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-sm font-bold text-gray-700 mb-2">Confirmer le mot de passe</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-playtomic-blue focus:border-playtomic-blue block p-3 font-medium transition-colors">
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-4 pt-6 mt-6 border-t border-gray-100">
                    <a href="{{ url()->previous() }}" class="px-5 py-2.5 font-bold text-gray-500 hover:text-gray-900 transition-colors">Annuler</a>
                    <button type="submit" class="bg-playtomic-blue text-white px-8 py-2.5 rounded-full font-bold hover:bg-blue-700 transition-colors shadow-md shadow-playtomic-blue/20">
                        Enregistrer les modifications
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
