<?php

return [

    'backup' => [

        /*
         * The name of this application. You can use this name to monitor
         * the backups.
         */
        //'name' => env('APP_URL'),   //这个备份时的目录名,如果是服务器上域名是不错的不过本地的话改一下比较好
        'name' => 'elick blog', 

        'source' => [
            //这个强大啊 还能备份文件
            'files' => [
                /*
                 * The list of directories that should be part of the backup. You can
                 * specify individual files as well.
                 * 这个是目录迭代器 但是当迭代node_modules时会出错 所以注销了
                 * 这样也就无法备份文件系统了 明天可以试试把排除放在前面看看可不可以
                 * 排除放在前面也不可以，但是可以挨个指定目录或文件
                 * 没有这个迭代还不可以 只有排除是不行的
                 * node_modules还是不行 里面全是链接目录一层套一层的 也不知道怎么搞的 不知道其他项目node目录是不是也这样
                 */
                'include' => [
                    //base_path(),
                     base_path('app'),
                    // base_path('artisan'),   //目录和单个文件都是可以的
                ],

                
                 // * These directories will be excluded from the backup.
                 // * You can specify individual files as well.
                 
                'exclude' => [
                    base_path('vendor'),
                    base_path('node_modules'),
                    storage_path(),
                    base_path('.git'),
                    base_path('.idea'),
                ],


                /*
                 * Determines if symlinks should be followed.
                 */
                'followLinks' => false,
            ],

            /*
             * The names of the connections to the databases that should be part of the backup.
             * Currently only MySQL- and PostgreSQL-databases are supported.
             */
            'databases' => [
                'test',     //这是在config/database.php里设置的 这样就可以保存系统之外的数据库了
            ],
        ],

        'destination' => [

            /*
             * The disk names on which the backups will be stored.
             * 保存位置在这
             * storage\app\http---localhost
             */
            'disks' => [
                'local',        //这个配置位置在 config/filesystems.php
                'backup',       //这个就是我自己加的
            ],
        ],
    ],

    'cleanup' => [
        /*
         * The strategy that will be used to cleanup old backups.
         * The youngest backup will never be deleted.
         * 这个应该是删除老备份的设置  但怎么用不晓得 在command里也没效果
         */
        'strategy' => \Spatie\Backup\Tasks\Cleanup\Strategies\DefaultStrategy::class,

        'defaultStrategy' => [

            /*
             * The amount of days that all backups must be kept.
             */
            'keepAllBackupsForDays' => 7,

            /*
             * The amount of days that all daily backups must be kept.
             */
            'keepDailyBackupsForDays' => 16,

            /*
             * The amount of weeks of which one weekly backup must be kept.
             */
            'keepWeeklyBackupsForWeeks' => 8,

            /*
             * The amount of months of which one monthly backup must be kept.
             */
            'keepMonthlyBackupsForMonths' => 4,

            /*
             * The amount of years of which one yearly backup must be kept.
             */
            'keepYearlyBackupsForYears' => 2,

            /*
             * After cleaning up the backups remove the oldest backup until
             * this amount of megabytes has been reached.
             */
            'deleteOldestBackupsWhenUsingMoreMegabytesThan' => 5000,
        ],
    ],


    /*
     *  In this array you can specify which backups should be monitored.
     *  If a backup does not meet the specified requirements the
     *  UnHealthyBackupWasFound-event will be fired.
     *  这里是backup::list读取保存位置地方 即使上面改了默认地址
     */
    'monitorBackups' => [
        [
            'name' => env('APP_URL'),
            'disks' => ['local','backup'],
            'newestBackupsShouldNotBeOlderThanDays' => 1,   //貌似是新的备份不能比老的大的天数 也就是时间间隔为一天 不过具体效果看不出来
            'storageUsedMayNotBeHigherThanMegabytes' => 5000,   //这是备份占的最大空间是
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

    'notifications' => [

        /*
         * This class will be used to send all notifications.
         */
        'handler' => Spatie\Backup\Notifications\Notifier::class,

        /*
         * Here you can specify the ways you want to be notified when certain
         * events take place. Possible values are "log", "mail", "slack",
         * "pushover", and "telegram".
         *
         * Slack requires the installation of the maknz/slack package.
         * Telegram requires the installation of the irazasyed/telegram-bot-sdk package.
         */
        'events' => [
            'whenBackupWasSuccessful'     => ['log'],
            'whenCleanupWasSuccessful'    => ['log'],
            'whenHealthyBackupWasFound'   => ['log'],
            'whenBackupHasFailed'         => ['log', 'mail'],
            'whenCleanupHasFailed'        => ['log', 'mail'],
            'whenUnhealthyBackupWasFound' => ['log', 'mail'],
        ],

        /*
         * Here you can specify how emails should be sent.
         */
        'mail' => [
            'from' => 'your@email.com',
            'to'   => 'your@email.com',
        ],

        /*
         * Here you can specify how messages should be sent to Slack.
         */
        'slack' => [
            'channel'  => '#backups',
            'username' => 'Backup bot',
            'icon'     => ':robot:',
        ],

        /*
         * Here you can specify how messages should be sent to Pushover.
         */
        'pushover' => [
            'token'  => env('PUSHOVER_APP_TOKEN'),
            'user'   => env('PUSHOVER_USER_KEY'),
            'sounds' => [
                'success' => env('PUSHOVER_SOUND_SUCCESS', 'pushover'),
                'error'   => env('PUSHOVER_SOUND_ERROR', 'siren'),
            ],
        ],

        /*
         * Here you can specify how messages should be sent to Telegram Bot API.
         */
        'telegram' => [
            'bot_token' => env('TELEGRAM_BOT_TOKEN'),
            'chat_id'   => env('TELEGRAM_CHAT_ID'),
            'async_requests' => env('TELEGRAM_ASYNC_REQUESTS', false),
            'disable_web_page_preview' => env('TELEGRAM_DISABLE_WEB_PAGE_PREVIEW', true),
        ],
    ],
];
