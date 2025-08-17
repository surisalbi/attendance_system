<main class="flex-1 p-8">
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

    <div class="bg-gradient-to-r from-blue-500 to-blue-700 text-white rounded-2xl shadow-lg p-6 flex items-center justify-between">
      <div>
        <h2 class="text-base/none font-medium opacity-90">Total Karyawan</h2>
        <p class="text-4xl font-extrabold mt-2"><?php echo $count_employee->row ?></p>
      </div>
      <div class="bg-white p-4 rounded-full opacity-50 shadow-inner">
        <i data-feather="users" class="w-10 h-10 text-blue-700"></i>
      </div>
    </div>

    <div class="bg-gradient-to-r from-emerald-500 to-emerald-700 text-white rounded-2xl shadow-lg p-6 flex items-center justify-between">
      <div>
        <h2 class="text-base/none font-medium opacity-90">Jumlah Departemen</h2>
        <p class="text-4xl font-extrabold mt-2"><?php echo $count_departement->row ?></p>
      </div>
      <div class="bg-white p-4 rounded-full opacity-50 shadow-inner">
        <i data-feather="briefcase" class="w-10 h-10 text-emerald-700"></i>
      </div>
    </div>

    <div class="bg-gradient-to-r from-rose-500 to-rose-700 text-white rounded-2xl shadow-lg p-6 flex items-center justify-between">
      <div>
        <h2 class="text-base/none font-medium opacity-90">Jumlah Telat Hari Ini</h2>
        <p class="text-4xl font-extrabold mt-2"><?php echo $count_late_today ?></p>
      </div>
      <div class="bg-white p-4 rounded-full opacity-50 shadow-inner">
        <i data-feather="clock" class="w-10 h-10 text-rose-700"></i>
      </div>
    </div>

    <div class="bg-gradient-to-r from-amber-500 to-amber-700 text-white rounded-2xl shadow-lg p-6 flex items-center justify-between">
      <div>
        <h2 class="text-base/none font-medium opacity-90">Jumlah Datang Lebih Awal</h2>
        <p class="text-4xl font-extrabold mt-2"><?php echo $count_ontime_today ?></p>
      </div>
      <div class="bg-white p-4 rounded-full opacity-50 shadow-inner">
        <i data-feather="sunrise" class="w-10 h-10 text-amber-700"></i>
      </div>
    </div>

  </div>

</main>

<!-- Modal -->
<div id="editModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
  <div class="bg-white w-full max-w-lg rounded-lg shadow-lg p-6 relative">
    <h3 class="text-lg font-semibold mb-4">Edit Attendance</h3>
    <form id="editForm" class="space-y-4" action="">
      <div>
        <label class="block mb-1 font-medium">Name</label>
        <input type="text" id="modalName" name="name" class="w-full border border-gray-300 rounded px-3 py-2">
      </div>
      <div>
        <label class="block mb-1 font-medium">Department</label>
        <input type="text" id="modalDept" name="department" class="w-full border border-gray-300 rounded px-3 py-2">
      </div>
      <div>
        <label class="block mb-1 font-medium">Date</label>
        <input type="date" id="modalDate" name="date" class="w-full border border-gray-300 rounded px-3 py-2">
      </div>
      <div class="grid grid-cols-2 gap-4">
        <div>
          <label class="block mb-1 font-medium">Clock In</label>
          <input type="time" id="modalIn" name="clock_in" class="w-full border border-gray-300 rounded px-3 py-2">
        </div>
        <div>
          <label class="block mb-1 font-medium">Clock Out</label>
          <input type="time" id="modalOut" name="clock_out" class="w-full border border-gray-300 rounded px-3 py-2">
        </div>
      </div>
      <div>
        <label class="block mb-1 font-medium">Description</label>
        <textarea id="modalDesc" name="description" class="w-full border border-gray-300 rounded px-3 py-2"></textarea>
      </div>
      <div class="flex justify-end space-x-2 mt-4">
        <button type="button" id="closeModal" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Cancel</button>
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Save</button>
      </div>
    </form>
  </div>
</div>