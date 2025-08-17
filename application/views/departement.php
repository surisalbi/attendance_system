<main class="flex-1 p-8">

  <h2 class="text-2xl font-bold mb-6">Data Departemen </h2>
  <div class="bg-white p-6 rounded-lg shadow">
    <button class="addBtnDept border mb-4 border-green-600 text-green-600 px-3 py-1 rounded hover:bg-green-50">Tambah</button>
    <?php echo $this->session->flashdata('alert'); ?>
    <div class="overflow-x-auto">
      <table id="attendanceTable" class="display w-full">
        <thead>
          <tr>
            <th>No</th>
            <th>Nama Departemen</th>
            <th>Max Absen Masuk</th>
            <th>Max Absen Keluar</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <?php $no = 1; foreach ($departement as $row): ?>
          <tr>
            <td width="1"><?php echo $no++ ?></td>
            <td><?php echo $row->departement_name ?></td>
            <td><?php echo $row->max_clock_in_time ?></td>
            <td><?php echo $row->max_clock_out_time ?></td>
            <td>
              <button class="editBtnDept<?php echo $row->id ?> border border-blue-600 text-blue-600 px-3 py-1 rounded hover:bg-blue-50">Edit</button>
              <button class="deleteBtnDept<?php echo $row->id ?> border border-red-600 text-red-600 px-3 py-1 rounded hover:bg-red-50">Hapus</button>
            </td>
          </tr>

          <!-- Modal -->
          <div id="editModalDept<?php echo $row->id ?>" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white w-full max-w-lg rounded-lg shadow-lg p-6 relative">
              <h3 class="text-lg font-semibold mb-4">Edit Data</h3>
              <form action="<?php echo site_url('departement/update/'.$row->id) ?>" class="space-y-4" method="post">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                <div>
                  <label class="block mb-1 font-medium">Nama Departemen</label>
                  <input type="text" name="departement_name" required value="<?php echo $row->departement_name ?>" class="w-full border border-gray-300 rounded px-3 py-2">
                </div>
                <div>
                  <label class="block mb-1 font-medium">Maksimal Waktu Absen Datang</label>
                  <input type="time" name="max_clock_in_time" required value="<?php echo $row->max_clock_in_time ?>" class="w-full border border-gray-300 rounded px-3 py-2">
                </div>
                <div>
                  <label class="block mb-1 font-medium">Maksimal Waktu Absen Keluar</label>
                  <input type="time" name="max_clock_out_time" required value="<?php echo $row->max_clock_out_time ?>" class="w-full border border-gray-300 rounded px-3 py-2">
                </div>
                <div class="flex justify-end space-x-2 mt-4">
                  <button type="button" id="closeModalEdit<?php echo $row->id ?>" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Tutup</button>
                  <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Simpan</button>
                </div>
              </form>
            </div>
          </div>

          <!-- Modal -->
          <div id="deleteModalDept<?php echo $row->id ?>" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white w-full max-w-lg rounded-lg shadow-lg p-6 relative">
              <h3 class="text-lg font-semibold mb-4">Hapus Data</h3>
              <p>Apakah anda yakin ingin menghapus data ini ?</p>
              <div class="flex justify-end space-x-2 mt-4">
                <button type="button" id="closeModalDelete<?php echo $row->id ?>" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Tutup</button>
                <a href="<?php echo site_url('departement/delete/'.$row->id) ?>" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Ya,Hapus</a>
              </div>
            </div>
          </div>

          <script>
            $(document).ready(function () {

              // Buka modal (kosong)
              $(document).on('click', '.addBtnDept', function () {
                $('#addModalDept').removeClass('hidden');
              });

              $(document).on('click', '.editBtnDept<?php echo $row->id ?>', function () {
                $('#editModalDept<?php echo $row->id ?>').removeClass('hidden');
              });

              // Buka modal (kosong)
              $(document).on('click', '.deleteBtnDept<?php echo $row->id ?>', function () {
                $('#deleteModalDept<?php echo $row->id ?>').removeClass('hidden');
              });

              // Tutup modal
              $('#closeModalAdd').on('click', function () {
                $('#addModalDept').addClass('hidden');
              });

              $('#closeModalEdit<?php echo $row->id ?>').on('click', function () {
                $('#editModalDept<?php echo $row->id ?>').addClass('hidden');
              });

              $('#closeModalDelete<?php echo $row->id ?>').on('click', function () {
                $('#deleteModalDept<?php echo $row->id ?>').addClass('hidden');
              });

            });
          </script>

          <?php endforeach ?>
        </tbody>
      </table>
    </div>
  </div>

</main>
  
<!-- Modal -->
<div id="addModalDept" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
  <div class="bg-white w-full max-w-lg rounded-lg shadow-lg p-6 relative">
    <h3 class="text-lg font-semibold mb-4">Edit Data</h3>
    <form action="<?php echo site_url('departement/create') ?>" class="space-y-4" method="post">
      <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
      <div>
        <label class="block mb-1 font-medium">Nama Departemen</label>
        <input type="text" name="departement_name" required class="w-full border border-gray-300 rounded px-3 py-2">
      </div>
      <div>
        <label class="block mb-1 font-medium">Maksimal Waktu Absen Datang</label>
        <input type="time" name="max_clock_in_time" required class="w-full border border-gray-300 rounded px-3 py-2">
      </div>
      <div>
        <label class="block mb-1 font-medium">Maksimal Waktu Absen Keluar</label>
        <input type="time" name="max_clock_out_time" required class="w-full border border-gray-300 rounded px-3 py-2">
      </div>
      <div class="flex justify-end space-x-2 mt-4">
        <button type="button" id="closeModalAdd" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Tutup</button>
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Simpan</button>
      </div>
    </form>
  </div>
</div>
