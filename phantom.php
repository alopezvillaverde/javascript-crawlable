<?php
	function error(){
		header("HTTP/1.0 404 Not Found");
		include_once('path-to-error-page');
	};

	function cache(){
		$hash = md5($_GET['url']);
		if (file_exists('path-to-phantom-cache' . $hash)) {
			$cache = file_get_contents('path-to-phantom-cache' . $hash);
			if (strpos($cache, '404 ERROR')){ 
				error(); 
			}else{
				echo $cache;
			}
		} else {
			$maxTries = 5;
			while (!$content && $maxTries > 0){
				if ($content = phantom($_GET['url'], $maxTries)){
					file_put_contents('path-to-phantom-cache' . $hash, $content);
					if (strpos($content, '404 ERROR')){ 
						error(); 
					}else{
						echo $content;
					}
					
				}else{
					$maxTries--;
				}
			}
			if ($maxTries == 0){
				header("HTTP/1.0 408 Request Timeout");
				include_once('path-to-error-page');
			}
		};
	};
	
	function phantom($url, $trie){
		$seconds = 1;
		$maxTries = 5;
		$timeout = $maxTries - $trie + $seconds;
		$result = shell_exec('timeout ' . $timeout . ' ' . 'path-to-phantom' . ' page.js ' . 'http://' . $_SERVER['SERVER_NAME'] . '/#' . $url);
		if (strpos($result, '<html')){
			return $result . '<!-- Tries left: ' . $trie. ' -->';
		}else{
			return false;
		}
	};

	if (preg_match("/^([0-9a-z]+\/?)*$/", $_GET['url'])){
		cache();	
	}else{
		error(); 
	};
?>
