<?php

return [
    /** when import data from cbs failed, how many time that we want system retry */
    'cbs_import_retry_times'      => 2,

    /** this section is for running schedule to import data from cbs for every month on date and time */
    'schedule_import_cbs_monthly' => ['date' => 3, 'time' => '5:00'],

    /** this section is for running schedule to send message to customer that has ticket for spinning for every month on date and time */
    'schedule_send_sms_monthly'   => ['date' => 5, 'time' => '7:00'],

    /** this section is for master user information when user want play role as master user */
    'master_user'  => [
        'name'     => 'master.prince',
        'email'    => 'master.prince@princebank.com.kh',
        'password' => 'master@prince',
    ],

    /** message content */
    'message_content' => 'We would like to inform you that you have :tocketAmount tickets qualify for this month lucky draw. Your Ticket No. are :tiketNumbers. The lucky draw will be done remotely through Prince Bank Plc. official Facebook page on 6th. For more information, please contact 1800 20 8888.'
];
