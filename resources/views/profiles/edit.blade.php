<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier le profil - ZTF Foundation</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('profiles.css') }}">
</head>
<body>
    <div class="dashboard-container">
        <main class="main-content" style="margin-left: 0;">
            <div class="page-header">
                <h1 class="page-title">{{ __('Profile') }}</h1>
                <div class="breadcrumb">
                    <a href="{{ route('staff.dashboard') }}" class="text-blue-600">Dashboard</a> / Profile
                </div>
            </div>

            <div class="py-12">
                <div class="max-w-2xl mx-auto sm:px-6 lg:px-8 space-y-6">
                    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                        <div class="max-w-xl">
                            <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
                                @csrf
                                <div>
                                    <x-input-label for="matricule" :value="__('Matricule')" />
                                    <x-text-input id="matricule" name="matricule" type="text" class="mt-1 block w-full" :value="old('matricule', $user->matricule)" required @readonly(true) />
                                    <x-input-error class="mt-2" :messages="$errors->get('matricule')" />
                                </div>
                                <div>
                                    <x-input-label for="name" :value="__('Nom complet')" />
                                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autocomplete="name" />
                                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                                </div>
                                <div>
                                    <x-input-label for="email" :value="__('Email')" />
                                    <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
                                    <x-input-error class="mt-2" :messages="$errors->get('email')" />
                                </div>
                                <div class="flex items-center gap-4">
                                    <x-primary-button>{{ __('Enregistrer') }}</x-primary-button>
                                    @if (session('status') === 'profile-updated')
                                        <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-gray-600">{{ __('Enregistré.') }}</p>
                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                        <div class="max-w-xl">
                            @include('profile.partials.update-password-form')
                        </div>
                    </div>

                    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                        <div class="max-w-xl">
                            @include('profile.partials.delete-user-form')
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
