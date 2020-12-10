package 单链表反转
type ListNode struct {
	Val int
	Next *ListNode
}
func ReverseList(head *ListNode) *ListNode {
	cur := head
	var pre *ListNode
	for{
		if cur != nil{
			next := cur.Next
			cur.Next = pre
			pre = cur
			cur = next
		}else{
			return pre
		}
	}
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