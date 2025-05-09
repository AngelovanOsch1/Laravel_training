<div class="max-w-4xl mx-auto p-6 rounded-xl bg-white shadow-lg shadow-[#e0e0e0]">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-bold text-left mb-6">My serie list</h2>
        <x-primary-button
            type="button"
            text='Add'
            class="px-6 py-2 bg-green-300 text-white font-semibold rounded-md shadow-md shadow-[#e0e0e0] hover:shadow-[#c0c0c0] hover:bg-green-400 focus:outline-none focus:ring-2 focus:ring-green-400 focus:ring-opacity-50"
        />
    </div>
    <div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200 bg-white shadow-md rounded-lg">
        <thead class="bg-gray-100">
            <tr>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">ID</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Image</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Name</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Status</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Score</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Start Date</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 text-sm text-gray-700">1</td>
                <td class="px-6 py-4">
                    <img src="https://via.placeholder.com/40" alt="John Doe" class="w-10 h-10 rounded-full object-cover">
                </td>
                <td class="px-6 py-4 text-sm text-gray-700">John Doe</td>
                <td class="px-6 py-4 text-sm">
                    <span class="inline-block px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-700">
                        Active
                    </span>
                </td>
                <td class="px-6 py-4 text-sm text-gray-700">89</td>
                <td class="px-6 py-4 text-sm text-gray-700">Jan 10, 2023</td>
            </tr>
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 text-sm text-gray-700">2</td>
                <td class="px-6 py-4">
                    <img src="https://via.placeholder.com/40" alt="Jane Smith" class="w-10 h-10 rounded-full object-cover">
                </td>
                <td class="px-6 py-4 text-sm text-gray-700">Jane Smith</td>
                <td class="px-6 py-4 text-sm">
                    <span class="inline-block px-2 py-1 text-xs font-medium rounded-full bg-red-100 text-red-700">
                        Inactive
                    </span>
                </td>
                <td class="px-6 py-4 text-sm text-gray-700">75</td>
                <td class="px-6 py-4 text-sm text-gray-700">Nov 5, 2022</td>
            </tr>
        </tbody>
    </table>
</div>
</div>