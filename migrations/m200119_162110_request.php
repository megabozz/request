<?php

use yii\db\Migration;

/**
 * Class m200119_162110_claim
 */
class m200119_162110_request extends Migration
{

    private static $table_request_contact = "{{%request_contact}}";
    private static $table_request_priority = "{{%request_priority}}";
    private static $table_request_type = "{{%request_type}}";
    private static $table_request_status = "{{%request_status}}";
    private static $table_request = "{{%request}}";
    private static $table_user = "{{%user}}";

    private function manageRequest(bool $delete = false)
    {
        if ($delete) {
            $this->dropTable(self::$table_request);
            return;
        }
        $this->createTable(self::$table_request, [
            'id' => $this->primaryKey(),
            'name' => $this->string(200)->notNull(),
            'description' => $this->text()->notNull(),
            'type_id' => $this->integer()->notNull(),
            'priority_id' => $this->integer()->notNull(),
            'status_id' => $this->integer()->notNull(),
            'contact_id' => $this->integer()->notNull(),
//            'work_time_estimated' => $this->integer()->unsigned()->null(),
//            'work_time_sum' => $this->integer()->unsigned()->null(),
//            'work_time_sum_modify_at' => $this->integer()->unsigned()->null(),
            'created_at' => $this->dateTime()->unsigned()->notNull(),
            'modify_by' => $this->integer()->unsigned()->null(),
            'modify_at' => $this->integer()->unsigned()->null(),
            'FOREIGN KEY (type_id) REFERENCES {{%request_type}} (id)',
            'FOREIGN KEY (priority_id) REFERENCES {{%request_priority}} (id)',
            'FOREIGN KEY (status_id) REFERENCES {{%request_status}} (id)',
            'FOREIGN KEY (contact_id) REFERENCES {{%request_contact}} (id)',
        ]);
        $this->createIndex('IX_type_id', self::$table_request, 'type_id');
        $this->createIndex('IX_priority_id', self::$table_request, 'priority_id');
        $this->createIndex('IX_status_id', self::$table_request, 'status_id');
        $this->createIndex('IX_contact_id', self::$table_request, 'contact_id');
        $this->createIndex('IX_created_at', self::$table_request, 'created_at');
    }

    private function manageRequestType(bool $delete = false)
    {
        if ($delete) {
            $this->dropTable(self::$table_request_type);
            return;
        }
        $this->createTable(self::$table_request_type, [
            'id' => $this->primaryKey(),
            'name' => $this->string(20)->notNull(),
        ]);

        $this->insert(self::$table_request_type, ["name" => "SERVICEMAINTENANCE"]);
        $this->insert(self::$table_request_type, ["name" => "SUPPORT"]);
        $this->insert(self::$table_request_type, ["name" => "TECHNICALREQUEST"]);
    }

    private function manageReauestPriority(bool $delete = false)
    {
        if ($delete) {
            $this->dropTable(self::$table_request_priority);
            return;
        }
        $this->createTable(self::$table_request_priority, [
            'id' => $this->primaryKey(),
            'name' => $this->string(20)->notNull(),
        ]);

        $this->insert(self::$table_request_priority, ["name" => "SLOW"]);
        $this->insert(self::$table_request_priority, ["name" => "MID"]);
        $this->insert(self::$table_request_priority, ["name" => "HIGH"]);
    }

    private function manageRequestStatus(bool $delete = false)
    {
        if ($delete) {
            $this->dropTable(self::$table_request_status);
            return;
        }
        $this->createTable(self::$table_request_status, [
            'id' => $this->primaryKey(),
            'name' => $this->string(20)->notNull(),
        ]);

        $this->insert(self::$table_request_status, ["name" => "NEW"]);
        $this->insert(self::$table_request_status, ["name" => "INPROGRESS"]);
        $this->insert(self::$table_request_status, ["name" => "COMPLETED"]);
        $this->insert(self::$table_request_status, ["name" => "DELAYED"]);
        $this->insert(self::$table_request_status, ["name" => "SOLVED"]);
    }

    private function manageRequestContact(bool $delete = false)
    {
        if ($delete) {
            $this->dropTable(self::$table_request_contact);
            return;
        }
        $this->createTable(self::$table_request_contact, [
            'id' => $this->primaryKey(),
            'name' => $this->string(150)->notNull(),
            'phone' => $this->string(20)->null(),
            'email' => $this->string(50)->null(),
        ]);
    }

    private function manageUser(bool $delete = false)
    {
        if ($delete) {
            $this->dropTable(self::$table_user);
            return;
        }
        $this->createTable(self::$table_user, [
            'id' => $this->primaryKey(),
            'name' => $this->string(150)->notNull(),
            'username' => $this->string(32)->notNull(),
            'password' => $this->string(128)->notNull(),
            'authkey' => $this->string(128)->null(),
            'accesstoken' => $this->string(128)->null(),
            'disabled' => $this->boolean()->defaultValue(false),
        ]);

        $this->createIndex('IX_disabled', self::$table_user, 'disabled');
        $this->createIndex('IX_username', self::$table_user, 'username');

        $this->insert(self::$table_user, ['name' => 'USER-1', 'username' => 'user1', 'password' => \app\helpers\Crypt::passwordHash('passuser1')]);
        $this->insert(self::$table_user, ['name' => 'USER-2', 'username' => 'user2', 'password' => \app\helpers\Crypt::passwordHash('passuser2')]);
        $this->insert(self::$table_user, ['name' => 'USER-3', 'username' => 'user3', 'password' => \app\helpers\Crypt::passwordHash('passuser3')]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->manageUser();
        $this->manageReauestPriority();
        $this->manageRequestStatus();
        $this->manageRequestType();
        $this->manageRequestContact();
        $this->manageRequest();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->manageRequest(true);
        $this->manageRequestContact(true);
        $this->manageReauestPriority(true);
        $this->manageRequestStatus(true);
        $this->manageRequestType(true);
        $this->manageUser(true);
        return true;
    }

    /*
      // Use up()/down() to run migration code without a transaction.
      public function up()
      {

      }

      public function down()
      {
      echo "m200119_162110_claim cannot be reverted.\n";

      return false;
      }
     */
}
