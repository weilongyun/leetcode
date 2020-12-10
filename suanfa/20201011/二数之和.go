package main

/**
 给定 nums = [2, 7, 11, 15], target = 9
 因为 nums[0] + nums[1] = 2 + 7 = 9
 所以返回 [0, 1]
/*

/**
 @author 魏龙云
 @date 20201011
*/
//第一种方式暴力破解法 （时间复杂度01）
func twoSum(nums []int, target int) []int {
//计算出数组的长度
len := len(nums)
for i:=0;i<len - 1;i++{
    for j:= i + 1;j<len;j++{
        if nums[i] + nums[j] == target{
        return []int{i,j}
        }
    }
   }
    return []int{}
}
//第二种方式(时间复杂度o(n))，通过hash表的方式
func twoSum(nums []int, target int) []int {
    mapArray := make(map[int]int)
    //1 定义一个map数组
    //2 每次用目标值-当前的这个值看看是否在map中
    for i:=0;i<len(nums);i++{
        v := nums[i];
        if k,ok := mapArray[target - v];ok{
            return []int{k,i}
        }
        mapArray[v] = i;
    }
    return []int{}
}
//第三种方式
func twoSum(nums []int, target int) []int {
    mapArray := make(map[int]int)
    //1 定义一个map数组
    //2 每次用目标值-当前的这个值看看是否在map中
    for i,v := range nums{
        if k,ok := mapArray[target - v];ok{
            return []int{k,i}
        }
        mapArray[v] = i;
    }
    return []int{}
}
