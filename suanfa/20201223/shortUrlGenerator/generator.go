package shortUrlGenerator

import (
	"crypto/md5"
	"encoding/hex"
	"strconv"
)

const (
	VAL   = 0x3FFFFFFF
	INDEX = 0x0000003D //十进制61，作为aggregate切片下标使用
)

//总共62位
var aggregate []byte  = []byte("abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ")

func MakeShortCode(str string) []string {
	var result []string = make([]string,4)
	var chars []byte
	md5str := getMd5Str(str)//拿到32位16进制字符串
	for i := 0; i < 4; i ++ {
		 str8 := md5str[i*8 : (i+1)*8]//分成四份，八位一份
		 hexVal, err := strconv.ParseInt(str8, 16, 64)//16进制字符串转化10进制数字
		 if err != nil {
		 	return result
		 }

		 dec10 := hexVal & int64(VAL)//取30位10十进制数字
	   	 for j := 0; j < 6; j ++ {
			 index := dec10 & int64(INDEX)//取低5位和0x0000003D，拿到数字下标
			 dec10  >>= 5
			 chars = append(chars,aggregate[index])
	   	 }
		result[i] = string(chars)
		chars = []byte{}
	}

	return result
}


func getMd5Str(str string) string {
	m := md5.New()
	m.Write([]byte(str))
	c := m.Sum(nil)
	return hex.EncodeToString(c)
}
