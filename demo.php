<?php



$SK = new WS();

$ar['code1'] = uniqid();//收信息人员
$ar['code'] = uniqid();//发信息人员
$ar['time'] = date('Y-m-d H:i:s');
$str = $SK->code(json_encode($ar));//对发送信息进行编码处理


var_dump($str);
Class WS {


    //与uncode相对
    function code($msg){
        $frame = array();
        $frame[0] = '81';
        $len = strlen($msg);//strlen() 函数获取字符串长度
        if($len < 126){
            $frame[1] = $len<16?'0'.dechex($len):dechex($len);//dechex() 函数把十进制转换为十六进制
        }else if($len < 65025){
            $s=dechex($len);
            $frame[1]='7e'.str_repeat('0',4-strlen($s)).$s;//str_repeat() 函数把字符串重复指定的次数
        }else{
            $s=dechex($len);
            $frame[1]='7f'.str_repeat('0',16-strlen($s)).$s;
        }
        $frame[2] = $this->ord_hex($msg);
        $data = implode('',$frame);//implode() 把数组元素组合为字符串
        return pack("H*", $data);//pack() 函数把数据装入一个二进制字符串
    }
    function ord_hex($data)  {
        $msg = '';
        $l = strlen($data);
        for ($i= 0; $i<$l; $i++) {
            $msg .= dechex(ord($data{$i}));//ord() 函数返回字符串的首个字符的 ASCII 值
        }
        return $msg;
    }


}