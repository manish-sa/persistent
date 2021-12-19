<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RouterData extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'spid' => [
                'type'       => 'VARCHAR',
                'constraint' => '18',
                'null'       => true,
            ],
            'hostname'       => [
                'type'       => 'VARCHAR',
                'constraint' => '14',
                'null'       => true,
            ],
            'loopback'       => [
                'type'       => 'VARCHAR',
                'constraint' => '18',
                'null'       => true,
            ],
            'mac'       => [
                'type'       => 'VARCHAR',
                'constraint' => '17',
                'null'       => true,
            ],
            'created_at'     => [
                'type'=>"TIMESTAMP",
                'null'       => true,
            ],
            'updated_at'     => [
                'type'=>"TIMESTAMP",
                'null'       => true,
            ],
            'deleted_at'     => [
                'type'=>"TIMESTAMP",
                'null'       => true,
            ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey(['hostname', 'loopback'], true);
        $this->forge->createTable('routerdata');
    }

    public function down()
    {
        $this->forge->dropTable('routerdata');
    }
}
