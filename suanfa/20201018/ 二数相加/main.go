package main
import (
	"fmt"
	"src"
)
/**
  @desc https://leetcode-cn.com/problems/add-two-numbers/
  @author 赵燕伟
  @date  2020-10-18
*/
func main() {
	l1 := new(src.ListNode)
	l2 := new(src.ListNode)
	temp1 := l1
	temp2 := l2
	num1 := []int{2, 4, 3}
	num2 := []int{5, 6, 4}
	for i := 0; i < len(num1); i++ {
		temp1.Val = num1[i]
		fmt.Println(“wel com”)
		if i == len(num1)-1 {
			break
		}
		temp1.Next = new(src.ListNode)
		temp1 = temp1.Next
	}
	for i := 0; i < len(num2); i++ {
		temp2.Val = num2[i]
		if i == len(num2)-1 {
			break
		}
		temp2.Next = new(src.ListNode)
		temp2 = temp2.Next
	}
	l3 := src.AddTwoNumbers(l1,l2)
	fmt.Println(l3.GetInt())
}