<!-- Sidebar -->
<aside class="w-64 bg-gray-800 text-white p-6">
  <h1 class="text-xl font-bold mb-8 text-center">Admin Panel</h1>
  <nav class="space-y-2">
    <a href="<?php echo site_url('/') ?>" class="block py-2 px-4 rounded <?php echo $this->uri->segment(1) == "apps" || $this->uri->segment(1) == "" ? "" : "hover:" ?>bg-gray-700">Dashboard</a>
    <a href="<?php echo site_url('/departement') ?>" class="block py-2 px-4 rounded <?php echo $this->uri->segment(1) == "departement" ? "" : "hover:" ?>bg-gray-700">Departemen</a>
    <a href="<?php echo site_url('/employee') ?>" class="block py-2 px-4 rounded <?php echo $this->uri->segment(1) == "employee" ? "" : "hover:" ?>bg-gray-700">Karyawan</a>
    <a href="<?php echo site_url('/attendance') ?>" class="block py-2 px-4 rounded <?php echo $this->uri->segment(1) == "attendance" ? "" : "hover:" ?>bg-gray-700">Absensi</a>
  </nav>
</aside>