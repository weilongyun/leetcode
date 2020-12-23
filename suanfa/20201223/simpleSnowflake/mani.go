package main

import (
	"fmt"
	"time"
)

//xuehua
//64 bit 最高位为0代表是正数
//之后的41位是代表时间戳
//后边的10位，高5位代表机器id 低5位位服务id或者机房id 后12位代表序号
//需要接收2个参数 1：机器id 2：机房id
func genSnowFlake(machine int64,jf int64) int64{
	//代表序列号是否需要重新计算，在相同毫秒级别内序列号+1否则清0
	sn :=0
	var lastTime int64
	//生成时间戳 1s=1000000000纳米秒
	curTime := time.Now().UnixNano() /1000000
	if curTime == lastTime{
		//说明和之前的时间是在同一个毫秒级下
		if sn > 4095{
			time.Sleep(time.Millisecond) //time.Millisecond和time.Now().UnixNano()等价
			curTime = time.Now().UnixNano() /1000000
			sn =0
		}
	}else{
		sn = 0
	}
	sn ++
	// 此时需要更新上一次的时间
	lastTime = curTime
	//当前时间戳左移22位
	curTime = curTime << 22
	//机器id左移动17位置
	machine = machine << 17
	//机房id左移5位
	jf = jf << 5
	reslut := int64(curTime) |  int64(machine) |  int64(jf)
	return reslut
}
func main() {
	reslut := genSnowFlake(3,5)
	fmt.Println(reslut)
}
