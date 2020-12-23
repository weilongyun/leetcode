package main

import "fmt"

type ListNode struct {
	Val int
	Next *ListNode
}

func mergeTwoLists(l1 *ListNode, l2 *ListNode) *ListNode {
	// 哑结点
	dummy := &ListNode{}
	prev := dummy
	for l1 != nil && l2 != nil {
		if l1.Val < l2.Val {
			prev.Next = l1
			l1 = l1.Next
		} else {
			prev.Next = l2
			l2 = l2.Next
		}
		prev = prev.Next
	}

	if l1 != nil {
		prev.Next = l1
	} else {
		prev.Next = l2
	}

	return dummy.Next
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

func main() {
	l1 := new(ListNode)
	l2 := new(ListNode)
	temp1 := l1
	temp2 := l2
	num1 := []int{1, 2, 4}
	num2 := []int{1, 3, 4}
	for i := 0; i < len(num1); i++ {
		temp1.Val = num1[i]
		if i == len(num1)-1 {
			break
		}
		temp1.Next = new(ListNode)
		temp1 = temp1.Next
	}
	for i := 0; i < len(num2); i++ {
		temp2.Val = num2[i]
		if i == len(num2)-1 {
			break
		}
		temp2.Next = new(ListNode)
		temp2 = temp2.Next
	}
	l3 := mergeTwoLists(l1,l2)
	fmt.Println(l3.GetInt())
}
