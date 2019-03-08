<?php
function get_segments() {
    $url = BASE_URL;
    $url = str_replace('://', '', $url);
    $url = rtrim($url, '/');
    $bits = explode('/', $url);
    $num_bits = count($bits);

    if ($num_bits>1) {
        $num_segments_to_ditch = $num_bits-1;
    } else {
        $num_segments_to_ditch = 0;
    }

    $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] .  $_SERVER['REQUEST_URI'];

    $url = str_replace('://', '', $url);
    $url = rtrim($url, '/');
    $segments = explode('/', $url);

    for ($i=0; $i < $num_segments_to_ditch; $i++) { 
        unset($segments[$i]);
    }

    $segments = array_values($segments);
    return $segments;
}

class Core {

    protected $current_module = DEFAULT_MODULE;
    protected $current_controller = DEFAULT_CONTROLLER;
    protected $current_method = DEFAULT_METHOD;
    protected $current_value = '';

    public function __construct() {

        $url = rtrim($_SERVER['REQUEST_URI'], '/');
        $url = filter_var($url, FILTER_SANITIZE_URL);
        $url = $this->attempt_add_custom_routes($url);

        $pos = strpos($url, MODULE_ASSETS_TRIGGER);

        if ($pos === false) {
            $this->serve_controller($url);
        } else {
            $this->serve_module_asset($url);
        }

    }

    private function attempt_add_custom_routes($url) {

        foreach (CUSTOM_ROUTES as $key => $value) {
            $contains_needle = $this->contains_needle($key, $url);

            if ($contains_needle == true) {
                $url = str_replace($key, $value, $url);
            }

        }

        return $url;
    }

    private function contains_needle($needle, $haystack) {
        $pos = strpos($haystack, $needle);

        if ($pos === false) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    private function serve_module_asset($url) {

        $url_segments = get_segments();

        foreach ($url_segments as $url_segment_key => $url_segment_value) {
            $pos = strpos($url_segment_value, MODULE_ASSETS_TRIGGER);

            if (is_numeric($pos)) {
                $target_module = str_replace(MODULE_ASSETS_TRIGGER, '', $url_segment_value);
                $file_name = $url_segments[count($url_segments)-1];                
                $target_dir = $url_segments[count($url_segments)-2];
                $asset_path = '../modules/'.strtolower($target_module).'/assets/'.$target_dir.'/'.$file_name;   
                $abs_file_path = str_replace('../', BASE_URL, $asset_path);
            
                if (file_exists($asset_path)) {
                    $content_type = mime_content_type($asset_path);

                    if ($content_type == 'text/plain') {

                        $pos2 = strpos($file_name, '.css');
                        if (is_numeric($pos2)) {
                            $content_type = 'text/css';
                        }
                        
                    }

                    header('Content-type: '.$content_type);
                    $contents = file_get_contents($asset_path);
                    echo $contents;
                    die();
                } else {
                    $this->serve_child_module_asset($asset_path, $file_name);
                }
            } 
        }

    }

    private function serve_child_module_asset($asset_path, $file_name) {

        $start = '/modules/';
        $end = '/assets/';

        $pos = stripos($asset_path, $start);
        $str = substr($asset_path, $pos);
        $str_two = substr($str, strlen($start));
        $second_pos = stripos($str_two, $end);
        $str_three = substr($str_two, 0, $second_pos);
        $target_str = trim($str_three);


        $bits = explode('-', $target_str);

        if (count($bits)==2) {
            if (strlen($bits[1])>0) {
                $parent_module = $bits[0];
                $child_module = $bits[1];

                $asset_path = str_replace($target_str, $parent_module.'/'.$child_module, $asset_path);
                if (file_exists($asset_path)) {

                    $content_type = mime_content_type($asset_path);

                    if ($content_type == 'text/plain') {

                        $pos2 = strpos($file_name, '.css');
                        if (is_numeric($pos2)) {
                            $content_type = 'text/css';
                        }
                        
                    }

                    header('Content-type: '.$content_type);
                    $contents = file_get_contents($asset_path);
                    echo $contents;
                    die();

                }
            }
        }
    }

    private function attempt_sql_transfer($controller_path) {
        $ditch = 'controllers/'.$this->current_controller.'.php';
        $dir_path = str_replace($ditch, '', $controller_path);
        
        $files = array();
        foreach (glob($dir_path."*.sql") as $file) {
            $file = str_replace($controller_path, '', $file);
            $files[] = $file;
        }

        if (count($files)>0) {
            require_once('tg_transferer/index.php');
            die();
        }
        
    }

    private function serve_controller($url) {

        $segments = get_segments();

        if (isset($segments[1])) {
            $this->current_module = strtolower($segments[1]);
            $this->current_controller = ucfirst($this->current_module);
        }
        
        if (isset($segments[2])) {
            $this->current_method = strtolower($segments[2]);
            //make sure not private
            $str = substr($this->current_method, 0, 1);
            if ($str == '_') {
                $this->draw_error_page();
            }
        } 

        if (isset($segments[3])) {
            $this->current_value = $segments[3];
        }

        $controller_path = '../modules/'.$this->current_module.'/controllers/'.$this->current_controller.'.php';

        if (!file_exists($controller_path)) {
            $controller_path = $this->attempt_init_child_controller($controller_path);
        }

        require_once $controller_path;

        if (ENV == 'dev') {
            $this->attempt_sql_transfer($controller_path);
        }

        if (method_exists($this->current_controller, $this->current_method)) {
            $target_method = $this->current_method;
            $this->current_controller = new $this->current_controller($this->current_module);
            $this->current_controller->$target_method($this->current_value);
        } else {
            $this->draw_error_page();
        }
    }

    private function attempt_init_child_controller($controller_path) {
        $bits = explode('-', $this->current_controller);

        if (count($bits)==2) {
            if (strlen($bits[1])>0) {
                
                $parent_module = strtolower($bits[0]);
                $child_module = strtolower($bits[1]);
                $this->current_controller = ucfirst($bits[1]);
                $controller_path = '../modules/'.$parent_module.'/'.$child_module.'/controllers/'.ucfirst($bits[1]).'.php';

                if (file_exists($controller_path)) {
                    return $controller_path;
                }
            }
        }

        $this->draw_error_page();
    }

    private function draw_error_page() {
        require_once('../templates/error_404.php');
    }

}