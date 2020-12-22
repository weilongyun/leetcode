package main

import (
	"fmt"
)

/*
	股票买卖问题一次
	https://leetcode-cn.com/problems/best-time-to-buy-and-sell-stock/
*/

func main() {
	var prices []int = []int{7,1,5,3,6,4}
	var min int  = int(^uint(0) >> 1)
	var max int = 0

	for _,value := range prices {
		if value < min {
			min = value
		}else if value-min > max {
			max = value-min
		}
	}

	fmt.Print(max)
}



