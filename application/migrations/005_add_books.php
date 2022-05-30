<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_books extends CI_Migration {
  public function up () {
    $this->dbforge->add_field([
      'id' => [
        'type' => 'INT',
        'constraint' => 11,
        'auto_increment' => true
      ],
      'title' => [
        'type' => 'VARCHAR',
        'constraint' => 255
      ],
      'authors_name' => [
        'type' => 'VARCHAR',
        'constraint' => 255,
        'null' => true,
        'default' => true
      ],
      'edition' => [
        'type' => 'INT',
        'constraint' => 11,
        'null' => true,
        'default' => null
      ],
      'publisher' => [
        'type' => 'VARCHAR',
        'constraint' => 255,
        'null' => true,
        'default' => null
      ],
      'isbn' => [
        'type' => 'VARCHAR',
        'constraint' => 255,
        'unique' => true,
        'null' => true,
        'default' => null
      ],
      'year' => [
        'type' => 'INT',
        'constraint' => 4,
        'null' => true,
        'default' => null
      ],
      'created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
      'updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP'
    ]);

    $this->dbforge->add_key('id', true);
    $this->dbforge->create_table('books');
  }

  public function down () {
    $this->dbforge->drop_table('books');
  }
}