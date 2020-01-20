<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'sqlite:@app/database/request.db',
    'charset' => 'utf8',
    'enableSchemaCache' => true,
        // Schema cache options (for production environment)
        //'schemaCacheDuration' => 60,
        //'schemaCache' => 'cache',
];
