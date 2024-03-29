<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['base_url'] =  ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ?  "https" : "http");
$config['base_url'] .=  "://".$_SERVER['HTTP_HOST'];
$config['base_url'] .=  str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);

$config['index_page'] = '';

$config['uri_protocol']	= 'REQUEST_URI';

$config['url_suffix'] = '.htm';

$config['language']	= 'english';

$config['charset'] = 'UTF-8';

$config['enable_hooks'] = FALSE;

$config['subclass_prefix'] = 'MY_';

$config['composer_autoload'] = FALSE;

$config['permitted_uri_chars'] = 'a-z 0-9~%.:_\-';

$config['enable_query_strings'] = FALSE;
$config['controller_trigger'] = 'c';
$config['function_trigger'] = 'm';
$config['directory_trigger'] = 'd';

$config['allow_get_array'] = TRUE;

$config['log_threshold'] = 1;

$config['log_path'] = PROJECT_DIR.'storage/logs/';

$config['log_file_extension'] = '.txt';

$config['log_file_permissions'] = 0644;

$config['log_date_format'] = 'Y-m-d H:i:s';

$config['error_views_path'] = PROJECT_DIR.'apps/views/errors/';

$config['cache_path'] = PROJECT_DIR.'apps/cache/';

$config['cache_query_string'] = FALSE;

$config['encryption_key'] = 'Alom@123';

$config['sess_driver'] = 'files';
//$config['sess_cookie_name'] = 'ci_session';
$config['sess_expiration'] = 7200;
$config['sess_save_path'] = NULL;
$config['sess_match_ip'] = FALSE;
$config['sess_time_to_update'] = 300;
$config['sess_regenerate_destroy'] = FALSE;

$config['cookie_prefix']	= '';
$config['cookie_domain']	= '';
$config['cookie_path']		= '/';
$config['cookie_secure']	= FALSE;
$config['cookie_httponly'] 	= FALSE;

$config['standardize_newlines'] = FALSE;

$config['global_xss_filtering'] = FALSE;

$config['csrf_protection'] = TRUE;
$config['csrf_token_name'] = 'csrf_alom';
$config['csrf_cookie_name'] = 'csrf_cookie_alom';
$config['csrf_expire'] = 7200;
$config['csrf_regenerate'] = TRUE;
$config['csrf_exclude_uris'] = array(
    'tickets/getRecords',
    'tickets/getDetails',
    'ticketsnew/getRecords',
    'ticketsopen/getRecords',
    'ticketsclose/getRecords',
    'reports/daterecords',
    'reports/callreports',
    'calls/getDetails',
    'ticketsopen/getUserRecords',
    'userlogs/getDatatableRecords',
    'ticketreports/getrecords',
    'ticketreports/getdtrecords'
);

$config['compress_output'] = FALSE;

$config['time_reference'] = 'local';

$config['rewrite_short_tags'] = FALSE;

$config['proxy_ips'] = '';
