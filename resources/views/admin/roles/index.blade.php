<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Role Management</title>
    <link rel="shortcut icon" href="{{ asset('favicon.png') }}" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-900 text-gray-200">

    <div class="container mx-auto mt-10 p-2">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-3xl font-bold">Roles List</h2>
            <button onclick="openModal('addRoleModal')" class="bg-blue-500 text-white px-4 py-2 rounded">Add
                Role
            </button>
        </div>

        @session('success')
            <div class="bg-green-200 text-green-800 p-3 mb-4">{{ session('success') }}</div>
        @endsession

        @if ($errors->any())
            <div class="bg-red-200 text-red-800 p-3 mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-gray-800 rounded-lg shadow-md p-4">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr>
                        <th class="p-3 border-b border-gray-600">ID</th>
                        <th class="p-3 border-b border-gray-600">Name</th>
                        <th class="p-3 border-b border-gray-600">Permissions</th>
                        <th class="p-3 border-b border-gray-600">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($roles as $index => $role)
                        <tr class="hover:bg-gray-700">
                            <td class="p-3 border-b border-gray-700">{{ $index + 1 }}</td>
                            <td class="p-3 border-b border-gray-700">{{ $role->role }}</td>
                            <td class="p-3 border-b border-gray-700">{{ $role->permissions->count() }}</td>
                            <td class="p-3 border-b border-gray-700">
                                {{--                        <button onclick="openEditModal({{$role->id}}, '{{$role->role}}')" class="bg-yellow-500 text-white px-3 py-1 rounded">Edit</button> --}}
                                <button
                                    onclick="openEditModal({{ $role->id }}, '{{ $role->role }}', {{ json_encode($role->permissions->pluck('id')) }})"
                                    class="bg-yellow-500 text-white px-3 py-1 rounded">Edit
                                </button>

                                <button onclick="openDeleteModal({{ $role->id }})"
                                    class="bg-red-500 text-white px-3 py-1 rounded">Delete
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Add Role Modal -->
    <div id="addRoleModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center">
        <div class="bg-gray-800 p-6 rounded shadow-md w-96">
            <h3 class="text-xl font-bold mb-4">Add Role</h3>
            <form action="{{ route('roles.store') }}" method="POST">
                @csrf
                <input type="text" name="role" value="{{ old('role') }}" placeholder="Role Name"
                    class="w-full p-3 rounded bg-gray-700 text-gray-100 border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 mb-4">

                <div id="addPermissionsList" class="flex flex-wrap items-center gap-2 mb-4">
                    @foreach ($permissions as $permission)
                        <input type="checkbox" name="permissions[]" id="add_permission_{{ $permission->id }}"
                            value="{{ $permission->id }}" class="hidden">
                        <label for="add_permission_{{ $permission->id }}" data-permission-id="{{ $permission->id }}"
                            class="permission-label cursor-pointer p-2 border border-gray-600 rounded text-gray-100 hover:bg-gray-700 transition">
                            {{ ucwords(str_replace('_', ' ', $permission->name)) }}
                        </label>
                    @endforeach
                </div>

                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="closeModal('addRoleModal')"
                        class="bg-gray-500 text-white px-4 py-2 rounded">Cancel
                    </button>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Save</button>
                </div>
            </form>
        </div>
    </div>


    <!-- Edit Role Modal -->
    <div id="editRoleModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center">
        <div class="bg-gray-800 p-6 rounded shadow-md w-96">
            <h3 class="text-xl font-bold mb-4">Edit Role</h3>
            <form id="editRoleForm" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" id="editRoleId">
                <input type="text" id="editRoleName" name="role" placeholder="Role Name"
                    class="w-full p-3 rounded bg-gray-700 text-gray-100 border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 mb-4">

                <div id="permissionsList" class="flex flex-wrap items-center gap-2 mb-4">
                    @foreach ($permissions as $permission)
                        <input type="checkbox" name="permissions[]" id="permission_{{ $permission->id }}"
                            value="{{ $permission->id }}" class="hidden">
                        <label for="permission_{{ $permission->id }}" data-permission-id="{{ $permission->id }}"
                            class="permission-label cursor-pointer p-2 border border-gray-600 rounded text-gray-100 hover:bg-gray-700 transition">
                            {{ ucwords(str_replace('_', ' ', $permission->name)) }}
                        </label>
                    @endforeach
                </div>

                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="closeModal('editRoleModal')"
                        class="bg-gray-500 text-white px-4 py-2 rounded">Cancel
                    </button>
                    <button type="submit" class="bg-yellow-500 text-white px-4 py-2 rounded">Update</button>
                </div>
            </form>
        </div>
    </div>


    <!-- Delete Confirmation Modal -->
    <div id="deleteRoleModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center">
        <div class="bg-gray-800 p-6 rounded shadow-md w-96">
            <h3 class="text-xl font-bold mb-4">Delete Role?</h3>
            <p>Are you sure you want to delete this role?</p>
            <form id="deleteRoleForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="flex justify-end space-x-2 mt-4">
                    <button type="button" onclick="closeModal('deleteRoleModal')"
                        class="bg-gray-500 text-white px-4 py-2 rounded">Cancel
                    </button>
                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded">Delete</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openModal(id) {
            document.getElementById(id).classList.remove('hidden');

            // Reset permissions when opening add modal
            if (id === 'addRoleModal') {
                const addPermissionInputs = document.querySelectorAll('#addPermissionsList input[type="checkbox"]');
                const addPermissionLabels = document.querySelectorAll('#addPermissionsList .permission-label');

                addPermissionInputs.forEach(input => {
                    input.checked = false;
                });
                addPermissionLabels.forEach(label => {
                    label.classList.remove('bg-green-600', 'border-green-500');
                    label.classList.add('border-gray-600');
                });
            }
        }

        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
        }

        function openEditModal(id, role, rolePermissions) {
            document.getElementById('editRoleId').value = id;
            document.getElementById('editRoleName').value = role;
            document.getElementById('editRoleForm').action = `/roles/${id}`;

            const permissionInputs = document.querySelectorAll('#permissionsList input[type="checkbox"]');
            const permissionLabels = document.querySelectorAll('#permissionsList .permission-label');

            // Reset all checkboxes and labels
            permissionInputs.forEach(input => {
                input.checked = false;
            });
            permissionLabels.forEach(label => {
                label.classList.remove('bg-green-600', 'border-green-500');
                label.classList.add('border-gray-600');
            });

            // Check the role permissions and update labels
            rolePermissions.forEach(permissionId => {
                const input = document.querySelector(`#permissionsList input[value="${permissionId}"]`);
                if (input) {
                    input.checked = true;
                    const label = document.querySelector(`label[for="permission_${permissionId}"]`);
                    if (label) {
                        label.classList.remove('border-gray-600');
                        label.classList.add('bg-green-600', 'border-green-500');
                    }
                }
            });

            openModal('editRoleModal');
        }

        function openDeleteModal(id) {
            document.getElementById('deleteRoleForm').action = `/roles/${id}`;
            openModal('deleteRoleModal');
        }

        // Add event listeners for permission labels
        document.addEventListener('DOMContentLoaded', function() {
            // Use event delegation to handle clicks on permission labels
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('permission-label')) {
                    e.preventDefault(); // Prevent any default behavior

                    // Find the checkbox using the for attribute
                    const labelFor = e.target.getAttribute('for');
                    let checkbox = document.getElementById(labelFor);

                    if (checkbox) {
                        // Toggle checkbox state
                        checkbox.checked = !checkbox.checked;

                        // Update visual appearance
                        if (checkbox.checked) {
                            e.target.classList.remove('border-gray-600');
                            e.target.classList.add('bg-green-600', 'border-green-500');
                        } else {
                            e.target.classList.remove('bg-green-600', 'border-green-500');
                            e.target.classList.add('border-gray-600');
                        }
                    }
                }
            });
        });
    </script>

</body>

</html>
