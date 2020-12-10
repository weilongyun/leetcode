package three

import "fmt"

// Node 链表中的节点结构体
type Node struct {
	Val  int
	Next *Node
}

// CreRingRoadList 创建环路链表
func CreRingRoadList() *Node {
	var (
		// 声明两个切片
		arr   []int = []int{1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15}
		head  *Node = new(Node)
		cur   *Node = head
		cutIn *Node
	)
	// 创建环路链表
	for i := 0; i < len(arr); i++ {
		cur.Val = arr[i]
		if i == 13 {
			cutIn = cur // 保存环路切入点的地址
			fmt.Printf("环路链表切入节点地址为：%p\n", cutIn)
		}
		// 当遍历到数组的最后一个元素时
		// 将尾节点的下一跳指向切入节点cutIn，构成环路链表
		if i == len(arr)-1 {
			cur.Next = cutIn	// 闭环
			break
		}
		cur.Next = new(Node)
		cur = cur.Next
	}
	return head
}

// PrintList 打印链表
func (l *Node) PrintList() {
	if l == nil {
		return
	}
	i := 0
	for ; l != nil; l = l.Next {
		fmt.Printf("%d ", l.Val)
		if i == 36 {
			break
		}
		i++
	}
	fmt.Printf("\n")
}

// IsRingRoadLists 快慢指针环路链表检测
func IsRingRoadLists(head *Node) *Node {
	var fast, slow *Node = head, head
	for fast != nil {
		fast = fast.Next.Next
		slow = slow.Next
		if fast == slow {
			break
		}
	}
	fast = head
	for {
		fast = fast.Next
		slow = slow.Next
		if fast == slow {
			return fast
		}
	}
	return nil
}

// IsRingRoadLists2 hashmap环路链表检测
func IsRingRoadLists2(head *Node) *Node {
	var listMap map[*Node]bool = make(map[*Node]bool,10)
	for cur:=head;cur!=nil;cur=cur.Next {
		if listMap[cur]==false {
			listMap[cur]=true
		}else{
			return cur
		}
	}
	return nil
}
