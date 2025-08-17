<main class="flex-1 p-8">

  <div class="mb-3">
    <span class="text-xl font-bold mb-6">
      Data Absensi Karyawan 
      <?php  
        if ($this->uri->segment(2) == "filter_date") {
          echo "(";
          echo mediumdate_indo($from);
          echo " s.d ";
          echo mediumdate_indo($to);
          echo ")";
        }
        if ($this->uri->segment(2) == "filter_departement") {
          echo "(";
          echo $departement->departement_name;
          echo ")";
        }
      ?>
    </span>
    <div x-data="{ open: false }" class="relative inline-block text-left float-end">
    <!-- Tombol -->
    <button @click="open = !open" 
            class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
      <i class="fas fa-filter mr-2"></i> Filter
      <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
      </svg>
    </button>

    <!-- Dropdown Menu -->
    <div x-show="open" @click.away="open = false"
         class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5">
      <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
        <a href="#" class="btnModalFilterTanggal flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
          <i class="fas fa-calendar-alt mr-2 text-blue-500"></i> Berdasarkan Tanggal
        </a>
        <a href="#" class="btnModalFilterDept flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
          <i class="fas fa-building mr-2 text-green-500"></i> Berdasarkan Departemen
        </a>
      </div>
    </div>
  </div>
  </div>

  <!-- Clock In Form -->
  <div class="bg-white p-6 rounded-lg shadow mb-8">
    <?php echo $this->session->flashdata('alert'); ?>
    <h3 class="text-m font-semibold mb-4">Absen Masuk</h3>
    <form action="<?php echo site_url('attendance/create') ?>" method="post" class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
      <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
      <div>
        <select id="absen" name="employee_id" required class="w-full px-0 text-xl py-0 rounded focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
          <option value="" disabled="" selected="">--Karyawan--</option>
          <?php 
            date_default_timezone_set('Asia/Jakarta');
            foreach ($employee as $emp) : 
              $date_time = date("Y-m-d H:i:s");
              $check_attendance = $this->db->query("SELECT COUNT(*) AS count_row FROM attendance WHERE attendance.employee_id = '$emp->employee_id' AND DATE(attendance.created_at) = CURDATE()")->row();
          ?>
          <option <?php echo $check_attendance->count_row > 0 ? "disabled" : "" ?> value="<?php echo $emp->employee_id ?>"><?php echo $emp->name ?></option>
          <?php endforeach ?>
        </select>
      </div>
      <div>
        <label class="block mb-1 font-medium">Jam</label>
        <input type="time" name="clock_in" required class="w-full text-sm h-9 w-40 border border-gray-300 rounded px-3 py-2">
      </div>
      <div>
        <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700"><i class="fas fa-arrow-right mr-2"></i> Simpan</button>
      </div>
    </form>
  </div>


  <div class="bg-white p-6 rounded-lg shadow">
    <h3 class="text-lg font-semibold mb-4">Histori Absensi</h3>
    <div class="overflow-x-auto">
      <table id="attendanceTable" class="display text-sm w-full">
        <thead>
          <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Departemen</th>
            <th>Tanggal</th>
            <th>Jam Masuk</th>
            <th>Jam Keluar</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <?php $no = 1; foreach ($attendance_history as $row) : ?>
          <tr>
            <td><?php echo $no++ ?></td>
            <td><?php echo $row->name ?></td>
            <td><?php echo $row->departement_name ?></td>
            <td><?php echo substr($row->date_attendance,0,10) ?></td>
            <td>
              <?php echo substr($row->clock_in,0,5) ?><br>
              <small>
                <?php  
                  $max_time  = strtotime($row->max_clock_in_time);
                  $post_time = strtotime($row->clock_in);

                  $diff = $post_time - $max_time;

                  if ($diff > 0) {
                      $jam   = floor($diff / 3600);
                      $menit = floor(($diff % 3600) / 60);

                      if ($jam > 0) {
                          $description = "<span class='text-red-600'>Telat $jam jam $menit menit</span>";
                      } else {
                          $description = "<span class='text-red-600'>Telat $menit menit</span>";
                      }

                  } elseif ($diff == 0) {
                      $description = "Tepat waktu";

                  } else {
                      $diff  = abs($diff);
                      $jam   = floor($diff / 3600);
                      $menit = floor(($diff % 3600) / 60);

                      if ($jam > 0) {
                          $description = "<span class='text-green-600'>Datang lebih cepat $jam jam $menit menit</span>";
                      } else {
                          $description = "<span class='text-green-600'>Datang lebih cepat $menit menit</span>";
                      }
                  }

                  echo $description;
                ?>
              </small>
            </td>
            <td>
              <?php echo substr($row->clock_out,0,5) ?><br>
              <small>
                <?php 
                  if(!empty($row->clock_out)) {
                    $max_time  = strtotime($row->max_clock_out_time);
                    $post_time = strtotime($row->clock_out);

                    $diff = $post_time - $max_time;

                    if ($diff > 0) {
                        // Lembur
                        $jam   = floor($diff / 3600);
                        $menit = floor(($diff % 3600) / 60);

                        if ($jam > 0 && $menit > 0) {
                            $description = "<span class='text-blue-600'>Lembur selama $jam jam $menit menit</span>";
                        } elseif ($jam > 0) {
                            $description = "<span class='text-blue-600'>Lembur selama $jam jam</span>";
                        } else {
                            $description = "<span class='text-blue-600'>Lembur selama $menit menit</span>";
                        }

                    } elseif ($diff == 0) {
                        // Tepat waktu
                        $description = "Pulang tepat waktu";

                    } else {
                        // Keluar lebih awal
                        $diff  = abs($diff);
                        $jam   = floor($diff / 3600);
                        $menit = floor(($diff % 3600) / 60);

                        if ($jam > 0 && $menit > 0) {
                            $description = "<span class='text-orange-600'>Pulang lebih awal $jam jam $menit menit</span>";
                        } elseif ($jam > 0) {
                            $description = "<span class='text-orange-600'>Pulang lebih awal $jam jam</span>";
                        } else {
                            $description = "<span class='text-orange-600'>Pulang lebih awal $menit menit</span>";
                        }
                    }

                    echo $description;
                  }
                ?>
              </small>
            </td>
            <td>
              <?php if(empty($row->clock_out)) : ?>
                <a href="#" class="btnModalAbsenKeluar<?php echo $row->ID_att ?> border border-blue-600 text-blue-600 px-3 py-1 rounded hover:bg-blue-50">Absen Keluar</a>
              <?php endif ?>
            </td>
          </tr>

          <div id="modalAbsenKeluar<?php echo $row->ID_att ?>" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white w-full max-w-lg rounded-lg shadow-lg p-6 relative">
              <h3 class="text-lg font-semibold mb-4">Absen Keluar</h3>
              <form action="<?php echo site_url('attendance/update/'.$row->ID_att) ?>" class="space-y-4" method="post">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                <div>
                  <label class="block mb-1 font-medium">Jam</label>
                  <input type="time" name="clock_out" required class="w-full text-sm h-9 w-40 border border-gray-300 rounded px-3 py-2">
                </div>
                <div class="flex justify-end space-x-2 mt-4">
                  <button type="button" id="closeModalAbsenKeluar<?php echo $row->ID_att ?>" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Tutup</button>
                  <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Tampilkan</button>
                </div>
              </form>
            </div>
          </div>

          <script>
            $(document).ready(function () {

              $(document).on('click', '.btnModalAbsenKeluar<?php echo $row->ID_att ?>', function () {
                $('#modalAbsenKeluar<?php echo $row->ID_att ?>').removeClass('hidden');
              });

              // Tutup modal
              $('#closeModalAbsenKeluar<?php echo $row->ID_att ?>').on('click', function () {
                $('#modalAbsenKeluar<?php echo $row->ID_att ?>').addClass('hidden');
              });

            });
          </script>

          <?php endforeach ?>
        </tbody>
      </table>
    </div>
    <?php if(!empty($attendance_history)) : ?>
      <a href="<?php echo site_url('attendance/delete_all') ?>" onclick="return confirm('Apakah anda yakin ?')" class="border border-red-600 text-red-600 px-3 py-2 rounded hover:bg-red-50"><i class="fas fa-trash"></i> Reset Data</a>
    <?php endif ?>
  </div>


</main>

<div id="modalFilterTanggal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
  <div class="bg-white w-full max-w-lg rounded-lg shadow-lg p-6 relative">
    <h3 class="text-lg font-semibold mb-4">Tampilkan Data Berdasarkan Tanggal</h3>
    <form action="<?php echo site_url('attendance/filter_date') ?>" class="space-y-4" method="get">
      <div>
        <label class="block mb-1 font-medium">Dari Tanggal</label>
        <input type="date" name="from" required class="w-full border border-gray-300 rounded px-3 py-2">
      </div>
      <div>
        <label class="block mb-1 font-medium">Sampai Tanggal</label>
        <input type="date" name="to" required class="w-full border border-gray-300 rounded px-3 py-2">
      </div>
      <div class="flex justify-end space-x-2 mt-4">
        <button type="button" id="closeModal" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Tutup</button>
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Tampilkan</button>
      </div>
    </form>
  </div>
</div>

<div id="modalFilterDept" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
  <div class="bg-white w-full max-w-lg rounded-lg shadow-lg p-6 relative">
    <h3 class="text-lg font-semibold mb-4">Tampilkan Data Berdasarkan Departemen</h3>
    <form action="<?php echo site_url('attendance/filter_departement') ?>" class="space-y-4" method="get">
      <div>
        <label class="block mb-1 font-medium">Departemen</label>
        <select id="dept" name="departement_id" required class="w-full border border-gray-300 rounded px-3 py-2">
          <option value="">-- Pilih --</option>
          <?php foreach ($departement_list as $dept) : ?>
          <option value="<?php echo $dept->id ?>"><?php echo $dept->departement_name ?></option>
          <?php endforeach ?>
        </select>
      </div>
      <div class="flex justify-end space-x-2 mt-4">
        <button type="button" id="closeModalDept" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Tutup</button>
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Tampilkan</button>
      </div>
    </form>
  </div>
</div>

<script>
  $(document).ready(function () {

    $(document).on('click', '.btnModalFilterTanggal', function () {
      $('#modalFilterTanggal').removeClass('hidden');
    });

    $(document).on('click', '.btnModalFilterDept', function () {
      $('#modalFilterDept').removeClass('hidden');
    });

    // Tutup modal
    $('#closeModal').on('click', function () {
      $('#modalFilterTanggal').addClass('hidden');
    });

    $('#closeModalDept').on('click', function () {
      $('#modalFilterDept').addClass('hidden');
    });


  });
</script>

<script>
  new TomSelect("#absen",{
    create: false,
    sortField: {
      field: "text",
      direction: "asc"
    }
  });

  new TomSelect("#dept",{
    create: false,
    sortField: {
      field: "text",
      direction: "asc"
    }
  });
</script>