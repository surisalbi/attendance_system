<main class="flex-1 p-8">

  <h2 class="text-2xl font-bold mb-6">Data Karyawan </h2>
  <div class="bg-white p-6 rounded-lg shadow">
    <button class="addBtnEmp border mb-4 border-green-600 text-green-600 px-3 py-1 rounded hover:bg-green-50">Tambah</button>
    <?php echo $this->session->flashdata('alert'); ?>
    <div class="overflow-x-auto">
      <table id="attendanceTable" class="display text-sm w-full">
        <thead>
          <tr>
            <th>No</th>
            <th>ID Karyawan</th>
            <th>Nama Karyawan</th>
            <th>Departemen</th>
            <th>Alamat</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <?php $no = 1; foreach ($employee as $row): ?>
          <tr>
            <td width="1"><?php echo $no++ ?></td>
            <td><?php echo $row->employee_id ?></td>
            <td><?php echo $row->name ?></td>
            <td><?php echo $row->departement_name ?></td>
            <td><?php echo $row->address ?></td>
            <td>
              <button class="editBtnEmp<?php echo $row->ID_employee ?> border border-blue-600 text-blue-600 px-3 py-1 rounded hover:bg-blue-50">Edit</button>
              <button class="deleteBtnEmp<?php echo $row->ID_employee ?> border border-red-600 text-red-600 px-3 py-1 rounded hover:bg-red-50">Hapus</button>
            </td>
          </tr>

          <!-- Modal -->
          <div id="editModalEmp<?php echo $row->ID_employee ?>" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white w-full max-w-lg rounded-lg shadow-lg p-6 relative">
              <h3 class="text-lg font-semibold mb-4">Edit Data</h3>
              <form action="<?php echo site_url('employee/update/'.$row->ID_employee) ?>" class="space-y-4" method="post">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                <div class="mt-3">
                  <label class="block mb-1 font-medium">ID Karyawan</label>
                  <input type="text" readonly="" value="<?php echo $row->employee_id ?>" class="w-full border border-gray-300 bg-gray-100 rounded px-3 py-2">
                </div>
                <div class="mt-3">
                  <label class="block mb-1 font-medium">Nama Karyawan</label>
                  <input type="text" name="name" value="<?php echo $row->name ?>" required class="w-full border border-gray-300 rounded px-3 py-2">
                </div>
                <div class="mt-3">
                  <label class="block mb-1 font-medium">Departemen</label>
                  <select id="dept<?php echo $row->ID_employee ?>" name="departement_id" required class="w-full border border-gray-300 rounded px-3 py-2">
                    <option value="">-- Pilih --</option>
                    <?php foreach ($departement_list as $dept) : ?>
                    <option <?php echo $dept->id == $row->departement_id ? "selected" : "" ?> value="<?php echo $dept->id ?>"><?php echo $dept->departement_name ?></option>
                    <?php endforeach ?>
                  </select>
                </div>
                <div class="mt-3">
                  <label class="block mb-1 font-medium">Alamat</label>
                  <input type="text" name="address" value="<?php echo $row->address ?>" required class="w-full border border-gray-300 rounded px-3 py-2">
                </div>
                <div class="flex justify-end space-x-2 mt-4">
                  <button type="button" id="closeModalEdit<?php echo $row->ID_employee ?>" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Tutup</button>
                  <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Simpan</button>
                </div>
              </form>
            </div>
          </div>

          <!-- Modal -->
          <div id="deleteModalEmp<?php echo $row->ID_employee ?>" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white w-full max-w-lg rounded-lg shadow-lg p-6 relative">
              <h3 class="text-lg font-semibold mb-4">Hapus Data</h3>
              <p>Apakah anda yakin ingin menghapus data ini ?</p>
              <div class="flex justify-end space-x-2 mt-4">
                <button type="button" id="closeModalDelete<?php echo $row->ID_employee ?>" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Tutup</button>
                <a href="<?php echo site_url('employee/delete/'.$row->ID_employee) ?>" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Ya,Hapus</a>
              </div>
            </div>
          </div>

          <script>
            $(document).ready(function () {

              // Buka modal (kosong)
              $(document).on('click', '.addBtnEmp', function () {
                $('#addModalEmp').removeClass('hidden');
              });

              $(document).on('click', '.editBtnEmp<?php echo $row->ID_employee ?>', function () {
                $('#editModalEmp<?php echo $row->ID_employee ?>').removeClass('hidden');
              });

              // Buka modal (kosong)
              $(document).on('click', '.deleteBtnEmp<?php echo $row->ID_employee ?>', function () {
                $('#deleteModalEmp<?php echo $row->ID_employee ?>').removeClass('hidden');
              });

              // Tutup modal
              $('#closeModalAdd').on('click', function () {
                $('#addModalEmp').addClass('hidden');
              });

              $('#closeModalEdit<?php echo $row->ID_employee ?>').on('click', function () {
                $('#editModalEmp<?php echo $row->ID_employee ?>').addClass('hidden');
              });

              $('#closeModalDelete<?php echo $row->ID_employee ?>').on('click', function () {
                $('#deleteModalEmp<?php echo $row->ID_employee ?>').addClass('hidden');
              });

            });
          </script>

          <script>
            new TomSelect("#dept<?php echo $row->ID_employee ?>",{
              create: false,
              sortField: {
                field: "text",
                direction: "asc"
              }
            });
          </script>

          <?php endforeach ?>
        </tbody>
      </table>
    </div>
  </div>

</main>
  
<!-- Modal -->
<div id="addModalEmp" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
  <div class="bg-white w-full max-w-lg rounded-lg shadow-lg p-6 relative">
    <h3 class="text-lg font-semibold mb-4">Tambah Data</h3>
    <form action="<?php echo site_url('employee/create') ?>" class="space-y-4" method="post">
      <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
      <div>
        <label class="block mb-1 font-medium">ID Karyawan</label>
        <input type="text" readonly="" value="<?php echo $employee_id ?>" class="w-full border border-gray-300 bg-gray-100 rounded px-3 py-2">
      </div>
      <div>
        <label class="block mb-1 font-medium">Nama Karyawan</label>
        <input type="text" name="name" required class="w-full border border-gray-300 rounded px-3 py-2">
      </div>
      <div>
        <label class="block mb-1 font-medium">Departemen</label>
        <select id="dept" name="departement_id" required class="w-full border border-gray-300 rounded px-3 py-2">
          <option value="">-- Pilih --</option>
          <?php foreach ($departement_list as $dept) : ?>
          <option value="<?php echo $dept->id ?>"><?php echo $dept->departement_name ?></option>
          <?php endforeach ?>
        </select>
      </div>
      <div>
        <label class="block mb-1 font-medium">Alamat</label>
        <input type="text" name="address" required class="w-full border border-gray-300 rounded px-3 py-2">
      </div>
      <div class="flex justify-end space-x-2 mt-4">
        <button type="button" id="closeModalAdd" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Tutup</button>
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Simpan</button>
      </div>
    </form>
  </div>
</div>

<?php if(empty($employee)) : ?>
<script>
  $(document).ready(function () {

    // Buka modal (kosong)
    $(document).on('click', '.addBtnEmp', function () {
      $('#addModalEmp').removeClass('hidden');
    });

    // Tutup modal
    $('#closeModalAdd').on('click', function () {
      $('#addModalEmp').addClass('hidden');
    });

  });
</script>
<?php endif ?>

<script>
  new TomSelect("#dept",{
    create: false,
    sortField: {
      field: "text",
      direction: "asc"
    }
  });
</script>