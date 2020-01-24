<?php

use yii\db\Migration;

/**
 * Class m200124_100312_log
 */
class m200124_100312_log extends Migration
{
    private static $table_request_log = "{{%request_log}}";

    private function manageLog(bool $delete = false)
    {
        if ($delete) {
            $this->dropTable(self::$table_request_log);
            return;
        }
        $this->createTable(self::$table_request_log, [
            'id' => $this->primaryKey(),
            'request_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'created_at' => $this->timestamp()->notNull(),
            'description' => $this->text()->notNull(),
            'FOREIGN KEY (request_id) REFERENCES {{%request}} (id)',
        ]);
        $this->createIndex('IX_log_request_id', self::$table_request_log, 'request_id');
        $this->createIndex('IX_log_user_id', self::$table_request_log, 'user_id');
        $this->createIndex('IX_log_created_at', self::$table_request_log, 'created_at');
    }

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->manageLog(false);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->manageLog(true);
        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200124_100312_log cannot be reverted.\n";

        return false;
    }
    */
}
