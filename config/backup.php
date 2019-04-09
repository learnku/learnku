<?php

return [

    'backup' => [

        /*
         * 此应用程序的名称。 您可以使用此名称进行监控
         * The name of this application. You can use this name to monitor
         * the backups.
         */
        'name' => config('app.name'),

        'source' => [

            'files' => [

                /*
                 * 将包含在备份中的目录和文件列表。
                 */
                'include' => [
                    base_path(),
                ],

                /*
                 * 这些目录和文件将从备份中排除。
                 * These directories and files will be excluded from the backup.
                 * 备份过程使用的目录将自动排除。
                 * Directories used by the backup process will automatically be excluded.
                 */
                'exclude' => [
                    base_path('vendor'),
                    base_path('node_modules'),
                ],

                /*
                 * 确定是否应遵循符号链接。
                 * Determines if symlinks should be followed.
                 */
                'followLinks' => false,
            ],

            /*
             * 应备份的数据库的连接名称
             * 支持MySQL，PostgreSQL，SQLite 和 Mongo 数据库。
             *
             * 可以为每个连接定制数据库转储的内容
             * by adding a 'dump' key to the connection settings in config/database.php.
             * E.g.
             * 'mysql' => [
             *       ...
             *      'dump' => [
             *           'excludeTables' => [
             *                'table_to_exclude_from_backup',
             *                'another_table_to_exclude'
             *            ]
             *       ]
             * ],
             *
             * 有关可用自定义选项的完整列表，请参阅 https://github.com/spatie/db-dumper
             */
            'databases' => [
                'mysql',
            ],
        ],

        /*
         * 可以压缩数据库转储以减少磁盘空间使用量。
         *
         * 开箱即用的 Laravel-backup
         * Spatie\DbDumper\Compressors\GzipCompressor::class.
         *
         * 您还可以创建自定义压缩器。 更多信息在这里：
         * https://github.com/spatie/db-dumper#using-compression
         *
         * 如果您根本不需要任何压缩器，请将其设置为 null
         */
        'database_dump_compressor' => null,

        'destination' => [

            /*
             * 用于备份zip文件的文件名前缀。
             */
            'filename_prefix' => '',

            /*
             * 将存储备份的磁盘名称。
             */
            'disks' => [
                'local',
            ],
        ],

        /*
         * 将存储临时文件的目录。
         */
        'temporary_directory' => storage_path('app/backup-temp'),
    ],

    /*
     * 您可以在特定事件发生时收到通知。 开箱即用你可以使用 'mail' 和 'slack'
     * 对于 Slack，你需要安装 guzzlehttp/guzzle。
     *
     * 您也可以使用自己的通知类，只需确保该类以“Spatie\Backup\Events”命名。
     * You can also use your own notification classes, just make sure the class is named after one of
     * the `Spatie\Backup\Events` classes.
     */
    'notifications' => [

        'notifications' => [
            \Spatie\Backup\Notifications\Notifications\BackupHasFailed::class         => ['mail'],
            \Spatie\Backup\Notifications\Notifications\UnhealthyBackupWasFound::class => ['mail'],
            \Spatie\Backup\Notifications\Notifications\CleanupHasFailed::class        => ['mail'],
            \Spatie\Backup\Notifications\Notifications\BackupWasSuccessful::class     => ['mail'],
            \Spatie\Backup\Notifications\Notifications\HealthyBackupWasFound::class   => ['mail'],
            \Spatie\Backup\Notifications\Notifications\CleanupWasSuccessful::class    => ['mail'],
        ],

        /*
         * 您可以在此处指定通知应发送到的通知。 默认通知将使用此配置文件中指定的变量。
         */
        'notifiable' => \Spatie\Backup\Notifications\Notifiable::class,

        'mail' => [
            // 通知邮箱
            'to' => 'guccilee_1@163.com',
        ],

        'slack' => [
            'webhook_url' => '',

            /*
             * 如果将其设置为null，则将使用 webhook 的默认通道。
             */
            'channel' => null,

            'username' => null,

            'icon' => null,

        ],
    ],

    /*
     * 您可以在此处指定应监视哪些备份。
     * 如果备份不符合指定的要求，将触发 UnHealthyBackupWasFound 事件。
     */
    'monitorBackups' => [
        [
            'name' => config('app.name'),
            'disks' => ['local'],
            'newestBackupsShouldNotBeOlderThanDays' => 1,
            'storageUsedMayNotBeHigherThanMegabytes' => 5000,
        ],

        /*
        [
            'name' => 'name of the second app',
            'disks' => ['local', 's3'],
            'newestBackupsShouldNotBeOlderThanDays' => 1,
            'storageUsedMayNotBeHigherThanMegabytes' => 5000,
        ],
        */
    ],

    'cleanup' => [
        /*
         * 将用于清除旧备份的策略。 默认策略会将所有备份保留一定天数。
         * 在此期间之后，仅保留每日备份。 在此期间之后，将仅保留每周备份，依此类推。
         *
         * 无论您如何配置它，默认策略都不会删除最新的备份。
         */
        'strategy' => \Spatie\Backup\Tasks\Cleanup\Strategies\DefaultStrategy::class,

        'defaultStrategy' => [

            /*
             * 必须保留备份的天数。
             */
            'keepAllBackupsForDays' => 7,

            /*
             * 必须保留每日备份的天数。
             */
            'keepDailyBackupsForDays' => 16,

            /*
             * 必须保留一周备份的周数。
             */
            'keepWeeklyBackupsForWeeks' => 8,

            /*
             * 必须保留一个月备份的月数。
             */
            'keepMonthlyBackupsForMonths' => 4,

            /*
             * 必须保留一年备份的年数。
             */
            'keepYearlyBackupsForYears' => 2,

            /*
             * 清理备份后，删除最旧的备份，直到达到此兆字节数。
             */
            'deleteOldestBackupsWhenUsingMoreMegabytesThan' => 5000,
        ],
    ],
];
