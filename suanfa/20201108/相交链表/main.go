/**
  @desc https://leetcode-cn.com/problems/intersection-of-two-linked-lists/
  @author 魏龙云
  @date  2020-11-08
*/
package main
import (
	"fmt"
	"gosuanfa/link"
)
func main() {
	//定义一个数组
	LinkNums1 := []int{4,1,9,4,6}
	LinkNums2 := []int{5,0,1,9,4,6}
	l1 := new(link.ListNode)
	l2 := new(link.ListNode)
	temp1 := l1
	temp2 := l2
	for i := 0; i < len(LinkNums1); i++ {
		temp1.Val = LinkNums1[i]
		if i == len(LinkNums1)-1 {
			break
		}
		temp1.Next = new(link.ListNode)
		temp1 = temp1.Next
	}
	for i := 0; i < 3; i++ {
		temp2.Val = LinkNums2[i]
		if i == 2 {
			break
		}
		temp2.Next = new(link.ListNode)
		temp2 = temp2.Next
	}
	for i:=2;i<len(LinkNums2);i++{
		temp2.Next = l1.Next.Next
	}
	//listNode类型
	l3 := link.GetIntersectionNode(l1,l2)
	//l3 := link.GetIntersectionNode1(l1,l2)
	//l3 := link.GetIntersectionHash(l1,l2)
	resNums := l3.GetInt()
	fmt.Println(resNums)
}