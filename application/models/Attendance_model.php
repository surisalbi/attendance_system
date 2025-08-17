<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Attendance_model extends CI_Model
{
	protected $table = 'attendance';
	protected $where_id = 'id';

    public function all()
    {
        return $this->db->query("SELECT * FROM {$this->table}")->result();
    }

    public function all_asc()
    {
        return $this->db->query("SELECT * FROM {$this->table} ORDER BY {$this->where_id} ASC")->result();
    }

    public function all_desc()
    {
        return $this->db->query("SELECT * FROM {$this->table} ORDER BY {$this->where_id} DESC")->result();
    }

    public function get_where($id)
    {
        return $this->db->query("SELECT * FROM {$this->table} WHERE {$this->where_id} = '$id'")->row();
    }

    public function get_where_all($id)
    {
        return $this->db->query("SELECT * FROM {$this->table} WHERE {$this->where_id} = '$id'")->result();
    }

    public function insert($request)
    {
        $this->db->insert($this->table, $request);
    }

    public function update($request, $id)
    {
        $this->db->where($this->where_id, $id);
        $this->db->update($this->table, $request);
    }

    public function delete($id)
    {
        $this->db->where($this->where_id, $id);
        $this->db->delete($this->table);
    }

    public function delete_all()
    {
        $this->db->query("DELETE FROM {$this->table}");
    }
}
