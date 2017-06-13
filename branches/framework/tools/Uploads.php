<?php
/**
 * 图片上传类
 *
 */
Yaf_Loader::import(PATH_FW_TOOLS . "/Resourceapi.php");

class Tools_Uploads extends ResourceApiClient
{
    private $_upload_name = 'Filedata';
    private $_pic_max_size = 2097152; //文件最大字节
    
    public function __construct($pkey = '', $mkey = '')
    {
        parent::__construct($pkey, $mkey);
    }
    
    /**
     * 上传图片
     * @param string $field_name
     * @return multitype:string
     */
    public function upload_pic($file)
    {
        if(!empty($field_name)) $this->_upload_name = $field_name;

        if(!isset($file[$this->_upload_name]))
        {
            return $this->result(false, '文件不存在');
        }

        $filear = $file[$this->_upload_name];

        if($filear['error'] > 0)
        {
            return $this->result(false, $filear['error']);
        }

        if($filear["size"] > $this->_pic_max_size )
        {
            return $this->result(false, "上传文件 ".$filear["name"]." 大小超出系统限定值[".$this->_pic_max_size." 字节]，不能上传。");
        }

        $this->get_ext($filear['name']);

        $newfile = $filear['tmp_name'].'.'.$this->_ext;

        rename($filear['tmp_name'],$newfile);

        //api上传图片
        $res = $this->upload($newfile);

        if($res['code'] != 0)
        {
            return $this->result(true, $res['msg']);
        }

        return $this->result(false, $res);
        
    }
    
    /**
     * 取得文件扩展名
     * $filename 为文件名称
     */
    function get_ext($filename)
    {
        if($filename == "") return;
        $ext = explode(".", $filename);
        $this->_ext = $ext[sizeof($ext)-1];
    }
    
    /**
     * 返回结果
     * @param string $result
     * @param string $info
     * @return multitype:string
     */
    public function result($result = false, $info = '')
    {
        return array(
            'result' => $result,
            'info' => $info,
        );
    }
}