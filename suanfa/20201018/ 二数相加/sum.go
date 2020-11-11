package src
type ListNode struct {
	Val int
	Next *ListNode
}
func AddTwoNumbers(l1 *ListNode, l2 *ListNode) *ListNode {
	//list := &ListNode{0, nil}
	list := new(ListNode)
	//这里用一个result，只是为了后面返回节点方便，并无他用
	result := list
	tmp := 0
	for l1 != nil || l2 != nil || tmp != 0 {
		if l1 != nil {
			tmp += l1.Val
			l1 = l1.Next
		}
		if l2 != nil {
			tmp += l2.Val
			l2 = l2.Next
		}
		list.Next = &ListNode{tmp % 10, nil}
		tmp = tmp / 10
		list = list.Next
	}
	return result.Next
}
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