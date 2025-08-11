<?php
if (!defined('FREEPBX_IS_AUTH')) { die('No direct script access allowed'); }

global $db;

// Remove SimpleDailer dialplan files and includes
$extensions_file = '/etc/asterisk/extensions_simpledialer.conf';
if (file_exists($extensions_file)) {
    unlink($extensions_file);
    out(_('Removed extensions_simpledialer.conf'));
}

// Remove include from extensions.conf
$extensions_conf = '/etc/asterisk/extensions.conf';
$include_line = '#include extensions_simpledialer.conf';

if (file_exists($extensions_conf)) {
    $content = file_get_contents($extensions_conf);
    $content = str_replace("\n$include_line", '', $content);
    $content = str_replace($include_line, '', $content);
    file_put_contents($extensions_conf, $content);
    out(_('Removed include from extensions.conf'));
    
    // Reload dialplan
    exec('asterisk -rx "dialplan reload"');
    out(_('Dialplan reloaded'));
}

// Drop database tables
$tables = ['simpledialer_call_logs', 'simpledialer_contacts', 'simpledialer_campaigns'];
foreach ($tables as $table) {
    $sql = "DROP TABLE IF EXISTS $table";
    $db->query($sql);
}

out(_('Database tables removed'));

// Remove sounds directory (optional - commented out to preserve user files)
// $sounds_dir = '/var/lib/asterisk/sounds/custom/simpledialer';
// if (is_dir($sounds_dir)) {
//     exec("rm -rf $sounds_dir");
//     out(_('Sounds directory removed'));
// }

out(_('Simple Dialer module uninstalled successfully'));