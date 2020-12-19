/**
  @desc https://leetcode-cn.com/problems/container-with-most-water
  @author 田力
  @date  2020-11-29
*/
package main

import (
	"fmt"
	"math"
	"runtime"
)

// maxWater 最多能盛多少水
func maxWater(arr []float64) ( /*最大盛水*/ maxW float64) {
	l := 0            // 坐下标
	r := len(arr) - 1 // 右下标
	curW := 0.0       // 当前盛水量

	for l != r {
		curW = float64(r-l) * math.Min(arr[l], arr[r])
		maxW = math.Max(maxW, curW)
		if arr[l] < arr[r] {
			l++
		} else {
			r--
		}
	}
	return maxW
}

func main() {
	var array = []float64{1, 8, 6, 2, 5, 4, 8, 3, 7}
	maxW := maxWater(array)
	fmt.Printf("最大盛水容量：%v\n", maxW)
	fmt.Println(runtime.NumCPU())
}
