<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Employee_model extends CI_Model
{
    protected $table = 'employee';
    protected $where_id = 'id';

    public function all()
    {
        return $this->db->query("SELECT *, employee.id AS ID_employee FROM {$this->table} JOIN departement ON employee.departement_id = departement.id ORDER BY ID_employee ASC")->result();
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

    public function count_all()
    {
        return $this->db->query("SELECT COUNT(*) AS row FROM {$this->table}")->row();
    }

    public function generate_employee_id()
    {
        $q = $this->db->query("SELECT MAX(RIGHT(id,5)) AS max_no FROM {$this->table}");
        $num = 1;
        if ($q->num_rows() > 0 && $q->row()->max_no !== null) {
            $num = ((int)$q->row()->max_no) + 1;
        }
        return 'K' . str_pad($num, 5, '0', STR_PAD_LEFT);
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
}
