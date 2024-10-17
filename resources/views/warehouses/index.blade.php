<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Warehouses</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 text-gray-900 font-sans antialiase">
    <div class="container mx-auto py-8 px-4">
        <h1 class="text-3xl font-bold mb-6">Склад менеджер</h1>

        <button id="openCreateModal" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-sm text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">Создать склад</button>

        @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mt-4">
            {{ session('success') }}
        </div>
        @endif

        <div class="mt-6">
            <table class="min-w-full bg-white shadow overflow-hidden sm:rounded-lg">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Адрес</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Объём</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Действия</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($warehouses as $warehouse)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">{{ $warehouse->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $warehouse->Address }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $warehouse->Volume }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <button onclick="openEditModal({{ $warehouse->id }}, '{{ $warehouse->Address }}', {{ $warehouse->Volume }})" class="inline-flex items-center px-2 py-1 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-yellow-500 hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">Изменить</button>

                            <button onclick="openDeleteModal({{ $warehouse->id }})" class="inline-flex items-center px-2 py-1 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 ml-2">Удалить</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>


        <div id="createModal" class="fixed inset-0 hidden flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white p-6 rounded-lg shadow-lg max-w-lg w-full">
                <h2 class="text-2xl font-bold mb-6">Создать</h2>

                <form action="{{ route('warehouses.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Адрес</label>
                        <input type="text" name="Address" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Объём</label>
                        <input type="number" name="Volume" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-sm text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">Сохранить</button>
                        <button type="button" onclick="closeModal('createModal')" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-sm text-gray-700 hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 ml-2">Отмнить</button>
                    </div>
                </form>
            </div>
        </div>

        <div id="editModal" class="fixed inset-0 hidden flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white p-6 rounded-lg shadow-lg max-w-lg w-full">
                <h2 class="text-2xl font-bold mb-6">Изменить</h2>

                <form id="editForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Адрес</label>
                        <input type="text" id="editAddress" name="Address" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Объём</label>
                        <input type="number" id="editVolume" name="Volume" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-yellow-500 border border-transparent rounded-md font-semibold text-sm text-white hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">Обновить</button>
                        <button type="button" onclick="closeModal('editModal')" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-sm text-gray-700 hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 ml-2">Отменить</button>
                    </div>
                </form>
            </div>
        </div>

        <div id="deleteModal" class="fixed inset-0 hidden flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white p-6 rounded-lg shadow-lg max-w-lg w-full">
                <h2 class="text-2xl font-bold mb-6">Удалить</h2>

                <p class="text-sm text-gray-500">Вы уверены?</p>

                <div class="flex justify-end mt-6">
                    <form id="deleteForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-sm text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">Удалить</button>
                    </form>
                    <button type="button" onclick="closeModal('deleteModal')" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-sm text-gray-700 hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 ml-2">Отменить</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openModal(modalId) {
            document.getElementById(modalId).classList.remove('hidden');
        }


        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
        }


        document.getElementById('openCreateModal').addEventListener('click', function() {
            openModal('createModal');
        });


        function openEditModal(id, address, volume) {
            document.getElementById('editAddress').value = address;
            document.getElementById('editVolume').value = volume;
            document.getElementById('editForm').action = '/warehouses/' + id;

            openModal('editModal');
        }


        function openDeleteModal(id) {
            document.getElementById('deleteForm').action = '/warehouses/' + id;
            openModal('deleteModal');
        }
    </script>
</body>

</html>
