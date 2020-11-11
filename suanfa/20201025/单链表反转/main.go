/**
  @desc https://leetcode-cn.com/problems/fan-zhuan-lian-biao-lcof/
  @author 魏龙云
  @date  2020-10-25
*/
package main
import (
	"fmt"
	"suanfa/Link"
)
func main(){
	// 待添加到链表中的数组
	LinkNums := [7]int{1,2,3,4,5,6,7}
	// 构造一个空链表 l1不动，最后li是需要待反转的链表
	l1 := new (Link.ListNode)
	//定义一个临时指针，负责移动并将数组中的元素添加到链表中
	temp := l1
	for k,v := range LinkNums{
		//将元素放入当前temp节点
		temp.Val = v
		if k == len(LinkNums) - 1{
			break
		}
		//当前temp节点中的next指针指向一个新的空节点
		temp.Next = new (Link.ListNode)
		//指针向后移动
		temp = temp.Next
	}
	res := Link.ReverseList(l1)
	arr := res.GetInt()
	fmt.Println(arr)
}