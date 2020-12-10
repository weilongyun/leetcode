/**
  @desc https://leetcode-cn.com/problems/remove-nth-node-from-end-of-list/
  @author 田力
  @date  2020-11-01
*/



// 方法一：计算链表长度
// 1、第一次遍历节点得到链表的长度
// 2、第二次遍历到删除节点的前一个结点，
// 并将这个节点的后续节点指向下下个节点
func (head *Node) DelNode(n int) {
	length := getLen(head)
	// 定义一个哑节点，串联在头节点前面
	dummy := &Node{0, head}
	cur := dummy
	// 删除 size-n
	for i := 0; i < length-n; i++ {
	cur = cur.next
	}
	cur.next = cur.next.next
	*head = *dummy.next
}

// 空间复杂度：O(1)
// 方法二：栈
// DelNode 删除指定下标n对应的节点
func (head *Node) DelNode(n int) {
	slice := []*Node{}
	dummy := &Node{0, head}
	for cur := dummy; nil != cur; cur = cur.next {
	slice = append(slice, cur)
	}
	pre := slice[len(slice)-1-n]
	pre.next = pre.next.next
	*head = *dummy.next
}

//时间复杂度：O(n)
// 空间复杂度：O(n)
// 方法三：快慢指针
// DelNode 删除指定下标n对应的节点
func (head *Node) DelNode(n int) {
	dummy := &Node{0, head}
	first, second := head, dummy
	// 快指针先前进n个节点
	for i := 0; i < n; i++ {
		first = first.next
		}
		// 同时移动快慢指针
		for ; nil != first; first = first.next {
		second = second.next
		}
		second.next = second.next.next
		*head = *dummy.next
}
// 时间复杂度：O(n)
// 空间复杂度：O(1)
