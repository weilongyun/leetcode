package main

import (
	"fmt"
	"strconv"
)

var mapOne = make(map[int]int)

func getIntOne(len int) int {
	if mapOne[len] != 0 {
		return mapOne[len]
	}

	var tmp string
	for i := 0; i < len ;i++ {
		tmp += strconv.Itoa(1)
	}
	intOne,_:= strconv.Atoi(tmp)
	mapOne[len] = intOne
	return intOne
}

/*
    单调递增的数字
  	https://leetcode-cn.com/problems/monotone-increasing-digits/
*/

func getIncreIntNum(num int) int {
	var total int
	strnum := strconv.Itoa(num)
	numlen := len(strnum)
	if numlen == 1 {
		return num
	}
	total = getIntOne(numlen)
	if total > num {
		numlen = numlen-1
		total = getIntOne(numlen)
	}

	for(! (total == num || (total % 10 == 9))) {
		if total + getIntOne(numlen) > num {
			numlen -= 1
		} else {
			total += getIntOne(numlen)
		}
	}
	return  total
}

func main() {
	fmt.Println(getIncreIntNum(16543));
	fmt.Print("\n")
}



