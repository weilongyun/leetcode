package main

import (
	"fmt"
	"strconv"
)

/*
  	https://leetcode-cn.com/problems/monotone-increasing-digits/
 */

var mapOne =  make(map[int]int)

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

/*
	内存没最优解使用少
*/
func main() {
	fmt.Println(getIncreIntNum(16543));
}

/*
	最优解
*/
func monotoneIncreasingDigits(n int) int {
	s := []byte(strconv.Itoa(n))
	i := 1
	for i < len(s) && s[i] >= s[i-1] {
		i++
	}
	if i < len(s) {
		for i > 0 && s[i] < s[i-1] {
			s[i-1]--
			i--
		}
		for i++; i < len(s); i++ {
			s[i] = '9'
		}
	}
	ans, _ := strconv.Atoi(string(s))
	return ans
}


