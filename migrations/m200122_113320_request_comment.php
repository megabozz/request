<?php

use yii\db\Migration;

/**
 * Class m200122_113320_request_comment
 */
class m200122_113320_request_comment extends Migration
{

    private static $table_request_comment = "{{%request_comment}}";

    private function manageComment(bool $delete = false)
    {
        if ($delete) {
            $this->dropTable(self::$table_request_comment);
            return;
        }
        $this->createTable(self::$table_request_comment, [
            'id' => $this->primaryKey(),
            'request_id' => $this->integer()->notNull(),
            'description' => $this->text()->notNull(),
            'created_at' => $this->dateTime()->unsigned()->notNull(),
            'created_by' => $this->integer()->notNull(),
            'work_time_estimated' => $this->integer()->unsigned()->null(),
            'FOREIGN KEY (request_id) REFERENCES {{%request}} (id)',
        ]);

        $this->createIndex('IX_request_id', self::$table_request_comment, 'request_id');
        $this->createIndex('IX_created_by', self::$table_request_comment, 'created_by');
    }

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->manageComment(false);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->manageComment(true);
        return true;
    }

    /*
      // Use up()/down() to run migration code without a transaction.
      public function up()
      {

      }

      public function down()
      {
      echo "m200122_113320_request_comment cannot be reverted.\n";

      return false;
      }
     */
}
