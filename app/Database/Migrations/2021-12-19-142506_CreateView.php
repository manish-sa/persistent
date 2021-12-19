<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateView extends Migration
{
    public function up()
    {
        $this->db->query('CREATE OR REPLACE VIEW router_view AS SELECT id, spid, hostname, loopback, mac FROM routerdata WHERE deleted_at IS NULL;');
    }

    public function down()
    {
        //
    }
}
