@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Gestion des RÃ´les et Permissions</h1>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Utilisateur
                        </th>
                        <th class="px-6 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Email
                        </th>
                        <th class="px-6 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Matricule
                        </th>
                        <th class="px-6 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($users as $user)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $user->name }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $user->email }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $user->matricule }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <button onclick="openModal('{{ $user->id }}')" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    GÃ©rer les rÃ´les et permissions
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div id="assignmentModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full">
    <div class="relative top-20 mx-auto p-5 border w-4/5 shadow-lg rounded-md bg-white">
        <div class="flex justify-between items-center pb-3">
            <h3 class="text-xl font-bold">Assigner les RÃ´les et Permissions</h3>
            <button onclick="closeModal()" class="text-black close-modal">&times;</button>
        </div>
        
        <div class="mt-2">
            <form id="roleForm" action="{{ route('assign.role') }}" method="POST" class="mb-6">
                @csrf
                <input type="hidden" name="user_id" id="modalUserId">
                
                <h4 class="font-bold mb-2">RÃ´les</h4>
                <div class="grid grid-cols-3 gap-4 mb-4">
                    @foreach($roles as $role)
                        <div class="flex items-center">
                            <input type="checkbox" name="roles[]" value="{{ $role->id }}" class="role-checkbox">
                            <label class="ml-2">{{ $role->display_name }}</label>
                        </div>
                    @endforeach
                </div>
                
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Sauvegarder les RÃ´les
                </button>
            </form>

            <form id="permissionForm" action="{{ route('assign.permission') }}" method="POST">
                @csrf
                <input type="hidden" name="user_id" id="modalUserIdPerm">
                
                <h4 class="font-bold mb-2">Permissions</h4>
                <div class="grid grid-cols-3 gap-4 mb-4">
                    @foreach($permissions as $permission)
                        <div class="flex items-center">
                            <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" class="permission-checkbox">
                            <label class="ml-2">{{ $permission->display_name }}</label>
                        </div>
                    @endforeach
                </div>
                
                <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    Sauvegarder les Permissions
                </button>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')

@endsection
    <script src="{{ asset('js/index.js') }}"></script>
