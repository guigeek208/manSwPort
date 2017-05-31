<?php
class manSwPort
{
	private static $_instance;
	private $_configfile = "../config/conf.json";
	private $_authfile = "../config/auth.json";
	private $_configjson;
	private $_key;
	private $_sw_login;
	private $_sw_passwd;
	private $_sw_encpasswd;
	private $_sw_enablepasswd;
	private $_sw_encenablepasswd;

	public function __construct() {
		$this->_configjson = $this->load_Configjson();
		$this->load_Authjson();
	}

	/**
     * Récupère l'instance de la classe
     *
     * @return manSwPort instance
     */
    public static function getInstance()
    {
        if( true === is_null( self::$_instance ) )
        {
            self::$_instance = new self();
        }

        return self::$_instance;
    }



	private function load_Configjson() {
		$json = file_get_contents($this->_configfile);
		$infos = json_decode($json, true);
		return $infos;
	}

	public function get_Configjson() {
		return $this->_configjson;
	}

	public function launch_cmd($ip, $cmd) {
		$output = "";
		$cmd_line = "../tools/command.sh ".$ip." ".$this->_sw_login." ".trim($this->_sw_passwd)." ".trim($this->_sw_enablepasswd)." ".$cmd;
		//var_dump($cmd_line);
		$output = shell_exec($cmd_line);
		//var_dump($output);
		return $output;
	}

	public function parse_results($devices, $output) {
		$arr = array();
		//print_r($output);
		foreach ($devices as $device) {
			$portslash = addcslashes($device["portname"], "/");
			$lines = explode("\n", $output);
			$boolfound = false;
			foreach ($lines as $line) {
				if ($boolfound) {
					$boolfound = false;
					if (preg_match("/".$portslash."\s+is\s+\w+\s*\w+,\s*\w+\s+\w+\s+\w+\s+\w+\s+\((\w+)\)/", trim($line), $matches)) {
					//if (preg_match("/".$portslash."\s+(\w+)\s+/", trim($line), $matches)) {
						if ($matches[1] == "disabled") {
							$arr[$device["port"]] = 0;
						} else {
							$arr[$device["port"]] = 1;
						}
					}
				}
				if (preg_match("/show int \| inc ".$portslash."/", $line, $matches)) {
					$boolfound = true;
				} else {
					$boolfound = false;
				}
			}
		}
		return $arr;
	}

	public function status() {
		$results = array();
		$output = "";
		$infos = $this->_configjson;
		foreach($infos["site"] as $site) {
			foreach ($site["salles"] as $salle) {
				foreach ($salle["hosts"] as $host) {
					$fileport = fopen("../tools/interface.txt", "w");
					foreach ($host["devices"] as $device) {
						fwrite($fileport, $device["portname"]."\n");
					}
					fclose($fileport);
					$output = $this->launch_cmd($host["ip"], "status");
					$arr = $this->parse_results($host["devices"], $output);		
					$results[$host["ip"]] = $arr;
				}
			}
		}
		$json = json_encode($results);
		print_r($json);
		return $results;
	}

	public function changePortState($status, $data) {
		$devices = array();
		foreach ($data as $host=>$listports) {
			$fileport = fopen("../tools/interface.txt", "w");
			foreach($listports as $port) {
				$devices[]["port"] = $port;
				fwrite($fileport, $port."\n");
			}
			fclose($fileport);
			$output = $this->launch_cmd($host, $status);
			//var_dump($output);
			$arr = $this->parse_results($devices, $output);		
			$results[$host] = $arr;
		}
		$json = json_encode($results);
		print_r($json);
		return $results;
	}

	public function localcrypt($plaintext) {
		# --- CHRIFFREMENT ---
		//$key = pack('H*', "bcb04b7e103a0cd8b54763051cef08bc55abe029fdebae5e1d417e2ffb2a00a3");
		$key = pack('H*', $this->_key);
		//$key = pack('H*', "43930F50BF3669B831AEA18EB1FE2A90CF60A45BBA0E9E8665F739ADAE5ADA36");
		# Montre la taille de la clé utilisée ; soit des clés sur 16, 24 ou 32 octets pour
		# AES-128, 192 et 256 respectivement.
		$key_size =  strlen($key);
		# Crée un IV aléatoire à utiliser avec l'encodage CBC
		$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
		$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
		# Crée un encodage explicite pour le texte plein
		$plaintext_utf8 = utf8_encode($plaintext);
		# Crée un texte cipher compatible avec AES (Rijndael block size = 128)
		# pour conserver le texte confidentiel.
		# Uniquement applicable pour les entrées encodées qui ne se terminent jamais
		# pas la valeur 00h (en raison de la suppression par défaut des zéros finaux)
		$ciphertext = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key,
									 $plaintext_utf8, MCRYPT_MODE_CBC, $iv);
		# On ajoute à la fin le IV pour le rendre disponible pour le chiffrement
		$ciphertext = $iv . $ciphertext;
		# Encode le texte du cipher résultant pouvant être représenté ainsi sous forme de chaîne de caractères
		$ciphertext_base64 = base64_encode($ciphertext);
		//echo  $ciphertext_base64 . "\n";
	 	return $ciphertext_base64;
	}

	public function localdecrypt($ciphertext_base64) {
		$key = pack('H*', $this->_key);
		//$key = pack('H*', "43930F50BF3669B831AEA18EB1FE2A90CF60A45BBA0E9E8665F739ADAE5ADA36");
		# --- DECHIFFREMENT ---
		$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
		$ciphertext_dec = base64_decode($ciphertext_base64);
		# Récupère le IV, iv_size doit avoir été créé en utilisant la fonction
		# mcrypt_get_iv_size()
		$iv_dec = substr($ciphertext_dec, 0, $iv_size);
		# Récupère le texte du cipher (tout, sauf $iv_size du début)
		$ciphertext_dec = substr($ciphertext_dec, $iv_size);
		# On doit supprimer les caractères de valeur 00h de la fin du texte plein
		$plaintext_utf8_dec = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key,
											 $ciphertext_dec, MCRYPT_MODE_CBC, $iv_dec);
		//echo  $plaintext_utf8_dec . "\n";
		return $plaintext_utf8_dec;
	}

	public function load_Authjson() {
		$json = file_get_contents($this->_authfile);
		$infos = json_decode($json, true);
		$this->_key = $infos["key"];
		$this->_sw_login = $infos["sw_login"];
		$this->_sw_encpasswd = $infos["sw_passwd"];
		$this->_sw_passwd = $this->localdecrypt($infos["sw_passwd"]);
		$this->_sw_encenablepasswd = $infos["sw_enablepasswd"];
		$this->_sw_enablepasswd = $this->localdecrypt($infos["sw_enablepasswd"]);
		$this->_web_passwd = $infos["web_passwd"];
		//echo $this->_sw_enablepasswd;
		//var_dump($infos);
	}

	public function login($pass) {
		$passhash = hash('sha256', $pass);
		if ($passhash == $this->_web_passwd) {
			return True;
		} else {
			return False;
		}
	}

	public function set_swuser($username, $password, $enablepassword) {
		$this->_sw_login = trim($username);
		$this->_sw_passwd = trim($password);
		$this->_sw_enablepasswd = trim($enablepassword);
		$this->_sw_encpasswd = $this->localcrypt(trim($password));
		$this->_sw_encenablepasswd = $this->localcrypt(trim($enablepassword));
		$this->save_Authjson();
	}

	public function set_webpassword($pass) {
		$this->_web_passwd = hash('sha256', $pass);
		$this->save_Authjson();
	}

	public function save_Authjson() {
		$data = array(
			"key" => $this->_key,
			"web_passwd" => $this->_web_passwd, 
			"sw_login" => $this->_sw_login,
			"sw_passwd" => $this->_sw_encpasswd,
			"sw_enablepasswd" => $this->_sw_encenablepasswd
		);
		$json = json_encode($data, JSON_PRETTY_PRINT);
		//var_dump($json);
		file_put_contents($this->_authfile, $json);
	}

}
?>
