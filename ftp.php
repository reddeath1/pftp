<?php

/**
 * Created by IntelliJ IDEA.
 * User: reddeath
 * Date: 1/11/2018
 * Time: 3:04 PM
 */

class ftp
{
    public $conn;
    private $server;

    public function __construct()
    {
       if(!$this->connect()){
           die('Connection failed to the server:' .$this->server);
       }
    }

    /**
     * make connection to the server
     * @return bool
     */
    private function connect(){
        $connected = false;
        $login = false;
        set_time_limit(0);
        /**
         * host : ftp.nevaa.co
         * user : d4d3t9f4
         * pass : Hiddenroute
         */

        define('FTP_SERVER','192.168.42.200');
        define('FTP_USER','reddeath');
        define('FTP_PASSWORD','Hiddenroute1');
        define('FTP_PASSIVE',FALSE);
        define('FTP_PORT',21);
        define('FTP_TIME_OUT',90);

        /**
         * setup basic connection
         */

        $this->conn = ftp_connect(FTP_SERVER,FTP_PORT,FTP_TIME_OUT);

        $this->server = FTP_SERVER;
        if($this->conn){
            /**
             * login to the ftp server
             */

            $login = ftp_login($this->conn,FTP_USER,FTP_PASSWORD);

            /**
             * Set passve mode ON/OFF (default OFF)
             */

            ftp_pasv($this->conn,FTP_PASSIVE);
        }

        /**
         * Check connection
         */

        if($this->conn && $login){
            $connected = true;
        }

        return $connected;
    }

    /**
     * Make ftp directory
     * @param $dir
     * @return bool
     */
    public function mkdir($dir){
       return @ftp_mkdir($this->conn,$dir);
    }

    /**
     * @param $file
     * @param $newfile
     * @return bool
     */
    public function upload($file,$newfile){
        /**
         * Transfer mode
         */
        $ascii = array('txt',"cvs");
        $ext = end(explode(".",$ascii));
        $mode = FTP_BINARY;

        if(in_array($ext, $ascii, true)){
            $mode = FTP_ASCII;
        }

        return @ftp_put($this->conn,$newfile,$file,$mode);
    }


    /**
     * @param $dir
     * @return bool
     */
    public function chdir($dir){
        return @ftp_chdir($this->conn, $dir);
    }

    /**
     * @param string $dir
     * @param string $params
     * @return array|bool
     */
    public function drl($dir = '.',$params = '-la'){
        $data = @ftp_nlist($this->conn,$params. ' '. $dir);
       if(count($data) < 1){
           $data = false;
       }

       return $data;

    }

    /**
     * Download the file from the server
     * @param $file
     * @param $newfile
     * @return bool
     */
    public function download($file,$newfile){
        /**
         * Transfer mode
         */
        $ascii = array('txt', 'cvs');
        $ext = end(explode('.',$ascii));
        $mode = FTP_BINARY;

        if(in_array($ext, $ascii, true)){
            $mode = FTP_ASCII;
        }

        return @ftp_get($this->conn,$newfile,$file,$mode);
    }


    /**
     * Close connection
     */
    public function __destruct()
    {
        @ftp_quit($this->conn);
        @ftp_close($this->conn);
    }
}
