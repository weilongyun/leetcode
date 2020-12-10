package link
type ListNode struct {
	Val int
	Next *ListNode
}
//length 获取链表的长度
func length(l *ListNode) int{
	len := 0
	for l != nil{
		len++
		l = l.Next
	}
	return len
}
//GetIntersectionNode 获取第一个相交的节点，没有返回nil 第二种方式 长度对齐
func GetIntersectionNode(headA, headB *ListNode) *ListNode {
	//获取长度
	diff := 0
	len1 := length(headA)
	len2 := length(headB)
	temp1 := headA
	temp2 := headB
	if len1 > len2{
		diff = len1 - len2
	}else{
		temp1 = headB
		temp2 = headA
		diff = len2 - len1
	}
	for i:=0;i<diff;i++{
		temp1 = temp1.Next
	}
	for temp1!= nil{
		if temp1 == temp2{
			return temp1
		}
		temp1 = temp1.Next
		temp2 = temp2.Next
	}
	return nil
}
//GetIntersectionNode1 第三种方式 根据总路程
func GetIntersectionNode1(headA, headB *ListNode) *ListNode {
	temp1 := headA
	temp2 := headB
	for temp1 != temp2{
		if temp1 == nil{
			temp1 = headB
		}else{
			temp1 = temp1.Next
		}
		if temp2 == nil{
			temp2 = headA
		}else{
			temp2 = temp2.Next
		}
	}
	return temp1
}
//GetIntersectionHash hashmap方式
func GetIntersectionHash(headA, headB *ListNode) *ListNode {
	hashmap := make(map[interface{}]interface{})
	for headA != nil{
		hashmap[headA] = 1
		headA = headA.Next
	}
	for headB != nil{
		if hashmap[headB] == 1{
			return headB
		}
		headB = headB.Next
	}
	return headB
}
//GetInt 获取链表中的内容
func (l *ListNode) GetInt() []int {
	if l == nil {
		return []int{}
	}
	nums := []int{}
	for l != nil {
		nums = append(nums, l.Val)
		l = l.Next
	}
	return nums
}