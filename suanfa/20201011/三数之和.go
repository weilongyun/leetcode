/**
 给你一个包含 n 个整数的数组 nums，判断 nums 中是否存在三个元素 a，b，c ，使得 a + b + c = 0 ？请你找出所有满足条件且不重复的三元组
 示例：
	给定数组 nums = [-1, 0, 1, 2, -1, -4]，
	满足要求的三元组集合为：
	[
	[-1, 0, 1],
	[-1, -1, 2]
    ]
*/
package main

import (
	"fmt"
	"sort"
	"strconv"
)
func main(){
	nums := []int{-1, 0, 1, 2, -1, -4}
	res := ThreeSumOpt(nums)
	fmt.Println(res)
}
// 核心思想（排序）：
// 1. 先对数组进行排序
// 2. 在第一层循环中，从头开始遍历元素，相同的元素，跳过
// 3. 在第二层循环中，只要j(j=i+1)<k(k=len-1),当三个数之和小于0，j++；当三个数之和大于0，k–；当三个数之和等于0，j++,k–,并且记录三个数；
// 注意点：判断切片是否在目标切片中，采用map[string]bool{}来记录存在的切片（注意：这里使用relect来判断切片是否相等会导致time limit exceeded）
// 时间复杂度：O(n^2) 空间复杂度: O(n1) n1为结果的切片长度
func ThreeSumOpt(nums []int) [][]int {
	sort.Ints(nums)
	isSearch := map[int]bool{}
	isVisited := map[string]bool{}
	res := [][]int{}
	for i := 0; i < len(nums); i++ {
		if _, ok := isSearch[nums[i]]; ok {
			continue
		}
		j := i + 1
		k := len(nums) - 1
		for {
			if j >= k {
				break
			}
			tmpArr := []int{}
			if nums[i]+nums[j]+nums[k] < 0 {
				j++
			} else if nums[i]+nums[j]+nums[k] > 0 {
				k--
			} else {
				tmpArr = append(tmpArr, nums[i], nums[j], nums[k])
				tmpStr := strconv.Itoa(nums[i]) + strconv.Itoa(nums[j]) + strconv.Itoa(nums[k])
				if _, ok := isVisited[tmpStr]; !ok {
					res = append(res, tmpArr)
					isVisited[tmpStr] = true
				}
				j++
				k--
			}
		}
		isSearch[nums[i]] = true
	}
	fmt.Println(isSearch)
	return res
}
//
package solution
import (
"sort"
"strconv"
)
// 核心思想（不排序）：
// 1. 在第一层循环，从头开始遍历元素，相同的元素，跳过
// 2. 在第二层循环，记录前两次比较的大小
// 3. 在第三层循环，判断三个数的和是否为0
// 4. 对三个元素从小到大，依次插入切片中
// 5. 判断切片是否在目标切片中，采用map[string]bool{}来记录存在的切片（注意：这里使用relect来判断切片是否相等会导致time limit exceeded）
// 时间复杂度：O(n^3) 空间复杂度: O(n1) n1为结果的切片长度
func ThreeSum(nums []int) [][]int {
	isSearch := map[int]bool{}
	isVisited := map[string]bool{}
	res := [][]int{}
	for i := 0; i < len(nums); i++ {
		if _, ok := isSearch[nums[i]]; ok {
			continue
		}
		for j := i + 1; j < len(nums); j++ {
			maxNum := nums[j]
			minNum := nums[i]
			if nums[j] < nums[i] {
				maxNum = nums[i]
				minNum = nums[j]
			}
			tmpArr := []int{}
			sum := nums[i] + nums[j]
			for k := j + 1; k < len(nums); k++ {
				if sum+nums[k] == 0 {
					tmpStr := ""
					if nums[k] > maxNum {
						// nums[k] > maxNum > minNum
						tmpArr = append(tmpArr, minNum, maxNum, nums[k])
						tmpStr += strconv.Itoa(minNum) + strconv.Itoa(maxNum) + strconv.Itoa(nums[k])
					} else if nums[k] > minNum {
						// maxNum > nums[k] > minNum
						tmpArr = append(tmpArr, minNum, nums[k], maxNum)
						tmpStr += strconv.Itoa(minNum) + strconv.Itoa(nums[k]) + strconv.Itoa(maxNum)
					} else {
						// maxNum > minNum > nums[k]
						tmpArr = append(tmpArr, nums[k], minNum, maxNum)
						tmpStr += strconv.Itoa(nums[k]) + strconv.Itoa(minNum) + strconv.Itoa(maxNum)
					}
					if _, ok := isVisited[tmpStr]; !ok {
						res = append(res, tmpArr)
						isVisited[tmpStr] = true
					}
					break
				}
			}
		}
		isSearch[nums[i]] = true
	}
	return res
}

