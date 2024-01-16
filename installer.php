<?php
$settings = array(
	'repo'		=> 'Cvolton/GMDprivateServer',
	'videoId'	=> '',
	'logoUrl'	=> 'https://upload.wikimedia.org/wikipedia/en/3/35/Geometry_Dash_Logo.PNG',
	'timeout'	=> array(
		'start' => 5,
		'redirection' => 5
	),
	'redirect'	=> TRUE,
);

error_reporting(E_ALL ^ E_NOTICE);
define('ROOT_PATH', rtrim(str_replace('\\','/', __DIR__), '/') . '/'); 
define('ROOT_PATH_RELATIVE', rtrim(dirname($_SERVER['SCRIPT_NAME']), '\/') . '/');
define('HTTP_HOST', $_SERVER['HTTP_HOST']);
define('HTTP_PROTOCOL', ((!empty($_SERVER['HTTPS']) and strtolower($_SERVER['HTTPS']) == 'on') or $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') ? 'https' : 'http');
define('ROOT_URL', HTTP_PROTOCOL . "://".HTTP_HOST . ROOT_PATH_RELATIVE); // http(s)://www.mysite.com/chevereto/
define('SELF', ROOT_PATH . basename(__FILE__));
if (class_exists('ZipArchive')) {
	class my_ZipArchive extends ZipArchive {
		public function extractSubdirTo($destination, $subdir) {
			$errors = array();

			// Prepare dirs
			$destination = str_replace(array("/", "\\"), DIRECTORY_SEPARATOR, $destination);
			$subdir = str_replace(array("/", "\\"), "/", $subdir);

			if (substr($destination, mb_strlen(DIRECTORY_SEPARATOR, "UTF-8") * -1) != DIRECTORY_SEPARATOR) {
				$destination .= DIRECTORY_SEPARATOR;
			}

			if (substr($subdir, -1) != "/") {
				$subdir .= "/";
			}

			// Extract files
			for ($i = 0; $i < $this->numFiles; $i++) {
				$filename = $this->getNameIndex($i);

				if (substr($filename, 0, mb_strlen($subdir, "UTF-8")) == $subdir) {
					$relativePath = substr($filename, mb_strlen($subdir, "UTF-8"));
					$relativePath = str_replace(array("/", "\\"), DIRECTORY_SEPARATOR, $relativePath);

					if (mb_strlen($relativePath, "UTF-8") > 0) {
						if (substr($filename, -1) == "/") { // Directory
							// New dir
							if (!is_dir($destination . $relativePath)) {
								if (!@mkdir($destination . $relativePath, 0755, true)) {
									$errors[$i] = $filename;
								}
							}
						} else {
							if (dirname($relativePath) != ".") {
								if (!is_dir($destination . dirname($relativePath))) {
									// New dir (for file)
									@mkdir($destination . dirname($relativePath), 0755, true);
								}
							}
							// New file
							if (@file_put_contents($destination . $relativePath, $this->getFromIndex($i)) === false) {
								$errors[$i] = $filename;
							}
						}
					}
				}
			}
			
			return $errors;
		}
	}
}
function debug($arguments) {
	if(empty($arguments)) return;
	echo '<pre>';
	foreach(func_get_args() as $value) {
		print_r($value);
	}
	echo '</pre>';
}
function json_error($args) {
	if(func_num_args($args) == 1 and is_object($args)) {
		if(method_exists($args, 'getMessage') and method_exists($args, 'getCode')) {
			$message = $args->getMessage();
			$code = $args->getCode();
			$context = get_class($args);
			error_log($message); // log class errors
		} else {
			return;
		}
	} else {
		if(func_num_args($args) == 1) {
			$message = $args; 
			$code = NULL;
			$context = NULL;
		} else {
			$message = func_get_arg(0);
			$code = func_get_arg(1);
			$context = NULL;
		}
	}
	return [
		'status_code' => 400,
		'error' => [
			'message'	=> $message,
			'code'		=> $code,
			'context'	=> $context
		]
	];
}
function json_output($data=[]) {
	error_reporting(0);
	@ini_set('display_errors', false);
	if(ob_get_level() === 0 and !ob_start('ob_gzhandler')) ob_start();
	header('Last-Modified: '.gmdate('D, d M Y H:i:s').'GMT');
	header('Cache-Control: no-cache, must-revalidate');
	header('Pragma: no-cache');
	header('Content-type: application/json; charset=UTF-8');
	
	// Invalid json request
	if(empty($data)) {
		set_status_header(400);
		$json_fail = [
			'status_code' => 400,
			'status_txt' => get_set_status_header_desc(400),
			'error' => [
				'message' => 'no request data present',
				'code' => NULL
			]
		];
		die(json_encode($json_fail));
	}
	
	// Populate missing values
	if($data['status_code'] && !$data['status_txt']){
		$data['status_txt'] = get_set_status_header_desc($data['status_code']);
	}
	
	$json_encode = json_encode($data);
	
	if(!$json_encode) { // Json failed
		set_status_header(500);
		$json_fail = [
			'status_code' => 500,
			'status_txt' => get_set_status_header_desc(500),
			'error' => [
				'message' => "data couldn't be encoded into json",
				'code' => NULL
			]
		];
		die(json_encode($json_fail));
	}
	set_status_header($data['status_code']);
	
	print $json_encode;
	die();
}
function set_status_header($code) {
	$desc = get_set_status_header_desc($code);
	if(empty($desc)) return false;
	$protocol = $_SERVER['SERVER_PROTOCOL'];
	if('HTTP/1.1' != $protocol && 'HTTP/1.0' != $protocol) $protocol = 'HTTP/1.0';
	$set_status_header = "$protocol $code $desc";
	return @header($set_status_header, true, $code);
}
function get_set_status_header_desc($code) {
	$codes_to_desc = array(
			100 => 'Continue',
			101 => 'Switching Protocols',
			102 => 'Processing',
			200 => 'OK',
			201 => 'Created',
			202 => 'Accepted',
			203 => 'Non-Authoritative Information',
			204 => 'No Content',
			205 => 'Reset Content',
			206 => 'Partial Content',
			207 => 'Multi-Status',
			226 => 'IM Used',
			300 => 'Multiple Choices',
			301 => 'Moved Permanently',
			302 => 'Found',
			303 => 'See Other',
			304 => 'Not Modified',
			305 => 'Use Proxy',
			306 => 'Reserved',
			307 => 'Temporary Redirect',
			400 => 'Bad Request',
			401 => 'Unauthorized',
			402 => 'Payment Required',
			403 => 'Forbidden',
			404 => 'Not Found',
			405 => 'Method Not Allowed',
			406 => 'Not Acceptable',
			407 => 'Proxy Authentication Required',
			408 => 'Request Timeout',
			409 => 'Conflict',
			410 => 'Gone',
			411 => 'Length Required',
			412 => 'Precondition Failed',
			413 => 'Request Entity Too Large',
			414 => 'Request-URI Too Long',
			415 => 'Unsupported Media Type',
			416 => 'Requested Range Not Satisfiable',
			417 => 'Expectation Failed',
			422 => 'Unprocessable Entity',
			423 => 'Locked',
			424 => 'Failed Dependency',
			426 => 'Upgrade Required',
			500 => 'Internal Server Error',
			501 => 'Not Implemented',
			502 => 'Bad Gateway',
			503 => 'Service Unavailable',
			504 => 'Gateway Timeout',
			505 => 'HTTP Version Not Supported',
			506 => 'Variant Also Negotiates',
			507 => 'Insufficient Storage',
			510 => 'Not Extended'
	);
	if(array_key_exists($code, $codes_to_desc)) {
		return $codes_to_desc[$code];	
	}
}
function str_replace_last($search, $replace, $subject) {
	$pos = strrpos($subject, $search);
	if($pos !== false) {
		$subject = substr_replace($subject, $replace, $pos, strlen($search));
	}
	return $subject;
}
function random_string($length) {
	switch(true) {
		case function_exists('random_bytes') :
			$r = random_bytes($length);
		break;
		case function_exists('openssl_random_pseudo_bytes') :
			$r = openssl_random_pseudo_bytes($length);
		break;
		case is_readable('/dev/urandom') : // deceze
			$r = file_get_contents('/dev/urandom', false, null, 0, $length);
		break;
		default :
			$i = 0;
			$r = '';
			while($i ++ < $length) {
				$r .= chr(mt_rand(0, 255));
			}
		break;
	}
	return substr(bin2hex($r), 0, $length);
}
function fetch_url($url, $file=NULL) {
	if(!$url) {
		throw new Exception('missing $url in ' . __FUNCTION__);
	}
	if(ini_get('allow_url_fopen') !== 1 && !function_exists('curl_init')) {
		throw new Exception("Fatal error in " .__FUNCTION__. ": cURL isn't installed and allow_url_fopen is disabled. Can't perform HTTP requests.");
	}

	if(ini_get('allow_url_fopen') !== 1 && !function_exists('curl_init')) {
		throw new Exception("Fatal error in " .__FUNCTION__. ": cURL isn't installed and allow_url_fopen is disabled. Can't perform HTTP requests.");
	}

	// File get contents is the failover fn
	$fn = (!function_exists('curl_init') ? 'fgc' : 'curl'); 
	
	$content_disposition_regex = '/\bContent-Disposition:.*filename=(?:["\']?)(.*)(?:["\']?)\b/i';
	
	if(is_dir($file)) {
		$dir = rtrim($file, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
		$filename = 'download_' . random_string(8) . '-' . time();
		$file = $dir . $filename;
	}
	
	if($fn == 'curl') {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_USERAGENT, 'Chevereto/php-repo-installer');
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 120);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_FAILONERROR, 0);
		curl_setopt($ch, CURLOPT_ENCODING, 'gzip'); // this needs zlib output compression enabled (php)
		curl_setopt($ch, CURLOPT_VERBOSE, 0);
		
		if($file) {
			if(isset($dir)) {
				$header_filename = $filename . '-header.txt';
				$header_file = $dir . $header_filename;
				$header_out = fopen($header_file, 'w');
				curl_setopt($ch, CURLOPT_WRITEHEADER, $header_out);
			}
			// Save the file to $file destination
			$out = @fopen($file, 'wb');
			if(!$out) {
				throw new Exception("Can't open " . __FUNCTION__ . "() file for read and write");
			}
			curl_setopt($ch, CURLOPT_FILE, $out);
			$result = @curl_exec($ch);
			if(is_resource($out)) {
				@fclose($out);
			}
			if(is_resource($header_out)) {
				@fclose($header_out);
			}
			if(is_file($header_file)) {
				if(isset($dir)) {
					$headers = @file_get_contents($header_file);
					if($headers && preg_match($content_disposition_regex, $headers, $matches)) {
						$downloaded_file = $dir . $matches[1];
						@rename($file, $downloaded_file);
					}
				}
				@unlink($header_file);
			}
			return $downloaded_file; // file || null
		} else {
			// Return the file string
			$file_get_contents = @curl_exec($ch);
		}
		if(curl_errno($ch)) {
			$curl_error = curl_error($ch);
			curl_close($ch);
			throw new Exception('Curl error: ' . $curl_error);
		}
		if($file == NULL) {
			curl_close($ch);
			return $file_get_contents;
		}
	} else {
		$context = stream_context_create([
			'http' => [
				'ignore_errors' => TRUE,
				'method'		=> 'GET',
				'header'		=> 'User-agent: Chevereto/php-repo-installer' . "\r\n"
			],
		]);
		$result = file_get_contents($url, FALSE, $context);
		if(!$result) {
			throw new Exception("file_get_contents: can't fetch target URL");
		}
		if($file) {
			if(isset($dir)) {
				// Get file content-disposition header
				foreach($http_response_header as $header) {
					if(preg_match($content_disposition_regex, $header, $matches)) {
						$file = $dir . $matches[1];
						break;
					}
				}
			}
			if(file_put_contents($file, $result) === FALSE) {
				throw new Exception("file_put_contents: can't fetch target URL");
			}
			return $file;
		} else {
			return $result;
		}
	}
}
try {
	error_reporting(0);
	if(isset($_REQUEST['action'])) {
		set_time_limit(600); // Allow up to five minutes...
		$temp_dir = ROOT_PATH;
		// Detect writting permissions
		if(!is_writable($temp_dir)) {
			throw new Exception(sprintf("Can't write into %s path", $temp_dir));
		}
		if(!is_writable(SELF)) {
			throw new Exception(sprintf("Can't write into %s file", $temp_dir));
		}
		switch($_REQUEST['action']) {
			case 'download':
				$zipball_url = 'https://api.github.com/repos/' . $settings['repo'] . '/zipball';
				$download = fetch_url($zipball_url, __DIR__);
				if($download === FALSE || is_null($download)) {
					throw new Exception(sprintf("Can't fetch %s from GitHub (fetch_url)", $settings['repo']), 400);
				}
				$zip_local_filename = str_replace_last('.zip', '_' . random_string(8) . time() . '.zip', $download);
				@rename($download, $zip_local_filename);
				$json_array = [
					'success' => [
						'message'   => 'Download completed',
						'code'      => 200
					],
					'download' => [
						'filename' => basename($zip_local_filename)
					]
				];
			break;
			case 'extract':
				$error_catch = [];
				foreach(['ZipArchive', 'RecursiveIteratorIterator', 'RecursiveDirectoryIterator'] as $k => $v) {
					if(!class_exists($v)) {
						$error_catch[] = strtr('%c class [http://php.net/manual/en/class.%l.php] not found', [
							'%c' => $v,
							'%l' => strtolower($v)
						]);
					}
				}
				if($error_catch) {
					throw new Exception(join("<br>", $error_catch), 100);
				}
				
				$repo_canonized_name = str_replace('/', '-', $settings['repo']);
				
				$zip_file = $temp_dir . $_REQUEST['file'];
				
				$explode_base = explode('_', $_REQUEST['file']);
				$expode_sub = explode('-', $explode_base[0]);
				$etag_short = end($expode_sub);
				
				// To be honest I don't know why GitHub prefix a "g" and sometimes prefix an "e"
				if($etag_short[0] == 'g') {
					$etag_short = substr($etag_short, 1);
				}
				
				if(empty($etag_short)) {
					throw new Exception("Can't detect zipball short etag");
				}
				
                // Test .zip
                if(!is_readable($zip_file)) {
                    throw new Exception('Missing '.$zip_file.' file', 400);
                }
                // Unzip .zip
                $zip = new my_ZipArchive;
                if ($zip->open($zip_file) === TRUE) {
					$folder = $repo_canonized_name . '-' . $etag_short . '/';
					if(!empty($settings['repoPath'])) {
						$folder .= $settings['repoPath'];
					}
					$zip->extractSubdirTo($temp_dir, $folder);
                    $zip->close();
                    @unlink($zip_file);
                } else {
                    throw new Exception(strtr("Can't extract %f (%m)", ['%f' => $zip_file, '%m' => 'Zip open error']), 401);
                }
                $json_array['success'] = ['message' => 'OK', 'code' => 200];
			break;
		}
		// Inject any missing status_code
        if(isset($json_array['success']) && !isset($json_array['status_code'])) {
            $json_array['status_code'] = 200;
        }
		$json_array['request'] = $_REQUEST;
		json_output($json_array);
	}
} catch(Exception $e) {
	$json_array = json_error($e);
	$json_array['request'] = $_REQUEST;
	json_output($json_array);
}
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="UTF-8">
<title><?php echo $settings['repo']; ?> Installer</title>
<?php if(isset($settings['logoUrl'])) { ?><link rel="shortcut icon" href="<?php echo $settings['logoUrl']; ?>"><?php } ?>

<style type="text/css">
	* {
		color: #dce6e6;
		line-height: 1.45;
		font-family: Monaco, Consolas, "Lucida Console", monospace;
		text-shadow: 2px 2px 1px rgba(0,0,0,.9);
	}
	body, html {
		min-height: 100%;
		padding: 0;
		margin: 0;
		background: #000;		
	}
	::selection {
		color: rgb(20,30,30);
		background: rgb(220,230,230);
	}
	
	@keyframes joltBG {
		0% {
			opacity: 0.3;
		}
		22%, 26% {
			opacity: 0.2;
		}
		27%, 45% {
			opacity: 0.4;
		}
		46%, 76% {
			opacity: 0.5;
		}
		76%, 78% {
			opacity: 0.05;
		}
		78% {
			opacity: 0.3;
		}
		100% {
			opacity: 0.3;
		}
	}
	@keyframes waiting {
		0% {
			opacity: 1;
		}
		50% {
			opacity: 0;
		}
		100% {
			opacity: 1;
		}
	}
	@keyframes spin {
		from {
			transform: rotateY(0);
		}
		to {
			transform: rotateY(360deg);
		}
	}

	#terminal {
		white-space: pre-wrap;
		padding: 20px;
		margin: 0;
		line-height: 1.45;
		font-family: Monaco, Consolas, "Lucida Console", monospace;
		position: relative;
		text-shadow: 2px 2px 1px rgba(0,0,0,.9);
	}
	#terminal::before {
		position: fixed;
		pointer-events: none;
		top:0;
		right: 0;
		bottom: 0;
		left:0;
		background-color: rgba(50,50,80, 0.6);
		content: '';
		z-index: 100;
		box-shadow: inset 0px 0px 20px 0px rgba(0,0,60,0.3);
		background: url('data:image/svg+xml,%3C?xml version="1.0" encoding="utf-8"?%3E %3C!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd"%3E %3Csvg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="2px" height="2px" viewBox="0 0 2 2" enable-background="new 0 0 600 600" xml:space="preserve"%3E %3Cline fill="none" stroke="#000000" stroke-miterlimit="10" x1="0" y1="0.5" x2="600" y2="0.5"/%3E %3C/svg%3E');
		animation-name: joltBG;
		animation-duration: 10000ms;
		animation-iteration-count: infinite;
		animation-timing-function: linear;
	}
	.js #terminal::after {
		position: absolute;
		pointer-events: none;
		bottom: 0;
		content: '■';
		animation-name: waiting;
		animation-duration: 1000ms;
		animation-iteration-count: infinite;
		animation-timing-function: step-end;
	}
	
	#background {
		position: absolute;
		top: 0;
		right: 0;
		bottom: 0;
		left: 0;
		background-size: cover;
		background-position: center;
		background-repeat: no-repeat;
	}
		#background .logo {
			position: fixed;
			top: 20px;
			right: 20px;
			width: 50vw;
			max-width: 400px;
			animation-name: spin;
			animation-duration: 3s;
			animation-iteration-count: infinite;
			animation-timing-function: ease-in-out;
		}
	
	iframe, video {
		position: fixed;
		width: 100%;
		height: 100%;
		pointer-events: none;
		display: none;
	}
	
	.js iframe, .js video {
		display: block;
	}
	
	@media (max-width: 568px) {
		iframe, video {
			opacity: 0;
		}
	}
	@media (min-width: 569px) {
		#background {
			background-image: none !important;
		}
	}
	
	.status {
		text-transform: uppercase;
	}
		.status--error {
			color: red;
		}
		.status--ok {
			color: #00FF00;
		}
</style>
</head>
<body>
	
	<div id="background">
		<?php if(isset($settings['logoUrl'])) { ?><img class="logo" src="<?php echo $settings['logoUrl']; ?>"><?php } ?>
	</div>

<div id="terminal">GDPS Installer by DuckyHD - Twitter: @duckyishot93
--

This script will install <?php echo $settings['repo']; ?> in <?php echo ROOT_PATH; ?> 
To use another path close this tab and move this file somewhere else.

<noscript><span class="status status--error">ERROR</span> JavaScript is needed to use this installer.</noscript></div>
	
	<script src="https://code.jquery.com/jquery-3.0.0.min.js"></script> 

	<script>
		$(function(){
			
			$("html").addClass("js");
			
			var settings = <?php echo json_encode($settings); ?>;
			var url = "<?php echo ROOT_URL . basename(__FILE__); ?>";
			var path = "<?php echo ROOT_PATH; ?>"
			var strings = {
					now: "<i>NOW!</i>"
				};
			var terminal = "#terminal";
			var redirectUrl = "<?php echo ROOT_URL; ?>";
			
			function countdown(seconds, callback) {
				var $countdown = $(terminal).find(".countdown").last();
				var countdownInterval = setInterval(function() {
					seconds = seconds - 1;
					if(seconds == 0) {
						$countdown.html(strings.now);
						clearInterval(countdownInterval);
						if(typeof callback == "function") {
							callback();
						}
					} else {
						$countdown.html(seconds);
					}
				}, 1000)
			}
			
			$.each(['start', 'redirection'], function(i, v) {
				if(settings.timeout[v] === 0) {
					settings.timeout[v] = strings.now;
				}
			});

			function writeLine(str, callback) {
				if(typeof str !== "object") {
					var str = [str];
				}
				for (var i=0; i<str.length; i++) {
					$(terminal).html($(terminal).html() + str[i] + '<br>');
					if(i+1 == str.length && typeof callback == "function") {
						callback();
					}
				}
			}
			
			function writeLineBreak(times, callback) {
				if(typeof times == typeof undefined) {
					var times = 1;
				}
				var i;
				for (i=0; i<times; i++) {
					writeLine("");
					if(i+1 == times && typeof callback == "function") {
						callback();
					}
				}
			};
			
			function writeConsoleCommand(str) {
				writeLine('&gt; ' + str);
			}
			
			function writeConsoleResponse(str, valid) {
				if(typeof valid == typeof undefined) {
					var valid = true;
				}
				if(typeof str !== "object") {
					var str = [str];
				}
				var valid = valid ? 'ok' : 'error';
				$.each(str, function(i,v) {
					writeLine('<span class="status status--' + valid + '">' + valid + '</span> ' + v);
				});
				
			}
			
			var TOASTY = {
				vars: {
					selector: "#mk-toasty",
					image: 'https://static.wikia.nocookie.net/numberlemon/images/f/fc/DiaDuck.png/revision/latest?cb=20190819051621',
					sound: './quack.mp3',
					width: 225,
					height: 218,
					keys: [],
					combo: "39,39,40,38", // dos pa adelante, abajo arriba
				},
				call: function() {
					var $this = this;
					this.remove();
					$("#background").append('<audio id="'+this.vars.selector.replace("#", "")+'-audio" preload="auto" autoplay="autoplay"><source src="'+this.vars.sound+'" /></audio>').append($('<img id="'+this.vars.selector.replace("#", "")+'-image" src="'+this.vars.image+'" />').css({
						position: "fixed",
						right:-this.vars.width,
						bottom: 0,
						width: this.vars.width,
						height: this.vars.height,
					}).animate({right: 0}, 300).delay(300).animate({right: -this.vars.width}, 300, function() {
						$this.remove();
					}));
					
				},
				remove: function() {
					$("[id^='"+this.vars.selector.replace("#", "")+"']").remove();
				},
				keyListener: function(e) {
					TOASTY.vars.keys.push(e.charCode || e.keyCode);
					if(TOASTY.vars.keys.toString().indexOf(TOASTY.vars.combo) >= 0) {
						TOASTY.vars.keys = [];
						TOASTY.call();
					}
				}
			};
			window.addEventListener("keyup", TOASTY.keyListener, true);
			
			var INSTALL = {
				vars: {},
				download: function() {
					var _this = this;
					writeConsoleCommand("Downloading %s from GitHub".replace("%s", settings.repo));
					$.ajax({
						url: url,
						data: {action: "download"},
					}).always(function(data, status, XHR) {
						console.log(data)
						if(!XHR) {
							writeConsoleResponse("Can't connect to %s".replace("%s", url), false);
							return;
						}
						if(data.status_code == 200) {
							_this.vars.target_filename = data.download.filename;
							writeConsoleResponse("■■■■■■■■■■ 100% - Download saved as %s".replace("%s", data.download.filename));
							_this.extract();
						} else {
							writeConsoleResponse(data.responseJSON.error.message, false);
						}
					});
				},
				extract: function(callback) {
					var _this = this;
					writeConsoleCommand("Extracting downloaded file, this could take a while");
					$.ajax({
						url: url,
						data: {action: "extract", file: _this.vars.target_filename},
					}).always(function(data, status, XHR) {
						if(!XHR) {
							writeConsoleResponse("Can't connect to %s".replace("%s", url), false);
							return;
						}
						if(data.status_code == 200) {
							TOASTY.call();
							writeConsoleResponse("■■■■■■■■■■ 100% - Extraction done");
							writeConsoleResponse("Toasty! " + settings.repo + " installed");
							setTimeout(function() {
								writeLineBreak();
								writeLine("Process completed!");
								if(settings.redirect) {
									writeLineBreak();
									writeLine(['Redirecting ' + (typeof settings.timeout.redirection == "number" ? ('in <span class="countdown">' + settings.timeout.redirection + '</span>') : 'right now')], function() {
										if(typeof settings.timeout.redirection === "number") {
											countdown(settings.timeout.redirection, function() {
												window.location = redirectUrl;
											});
										} else {
											window.location = redirectUrl;
										}
									});
								}
							}, 500);
						} else {
							writeConsoleResponse(data.responseJSON.error.message, false);
						}
					});
				},
			};
			
			writeLine(['The process will begin ' + (typeof settings.timeout.start == "number" ? ('in <span class="countdown">' + settings.timeout.start + '</span>') : 'right now')], function() {
				writeLineBreak(1);
				if(typeof settings.timeout.start === "number") {
					countdown(settings.timeout.start, function() {
						INSTALL.download();
					});
				} else {
					INSTALL.download();
				}
			});

		});
	</script>
</body>
</html>
